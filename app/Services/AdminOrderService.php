<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AdminOrderService
{
    public function __construct(
        protected InventoryService $inventoryService,
    ) {}

    public function updateStatus(Order $order, string $status, ?User $actor = null): Order
    {
        return DB::transaction(function () use ($order, $status, $actor): Order {
            $lockedOrder = Order::query()
                ->with(['latestPayment', 'items'])
                ->lockForUpdate()
                ->findOrFail($order->id);

            if ($lockedOrder->order_status === $status) {
                return $lockedOrder;
            }

            if (
                in_array($lockedOrder->order_status, [Order::STATUS_CANCELLED, Order::STATUS_REFUNDED], true)
                && ! in_array($status, [Order::STATUS_CANCELLED, Order::STATUS_REFUNDED], true)
            ) {
                throw ValidationException::withMessages([
                    'order_status' => 'Order yang sudah cancelled/refunded tidak bisa dipindah ke status aktif lagi dari admin panel ini.',
                ]);
            }

            $attributes = [
                'order_status' => $status,
            ];

            if ($status === Order::STATUS_PAID) {
                $attributes['payment_status'] = Order::PAYMENT_PAID;
                $attributes['paid_at'] = $lockedOrder->paid_at ?? now();
                $this->inventoryService->confirmOrderPayment($lockedOrder, $actor);

                if ($lockedOrder->latestPayment instanceof Payment) {
                    $lockedOrder->latestPayment->forceFill([
                        'status' => Payment::STATUS_PAID,
                        'transaction_status' => $lockedOrder->latestPayment->transaction_status ?? 'manual_paid',
                        'paid_at' => $lockedOrder->latestPayment->paid_at ?? now(),
                    ])->save();
                }
            }

            if ($status === Order::STATUS_COMPLETED) {
                $attributes['completed_at'] = now();
            }

            if ($status === Order::STATUS_CANCELLED) {
                $attributes['cancelled_at'] = now();

                if ($lockedOrder->payment_status !== Order::PAYMENT_PAID) {
                    $attributes['payment_status'] = Order::PAYMENT_FAILED;
                }

                $this->inventoryService->releaseOrderStock(
                    $lockedOrder,
                    $actor,
                    'Stok dirilis ulang karena order dibatalkan oleh admin.',
                );

                if ($lockedOrder->latestPayment instanceof Payment && $lockedOrder->latestPayment->status !== Payment::STATUS_PAID) {
                    $lockedOrder->latestPayment->forceFill([
                        'status' => Payment::STATUS_CANCELLED,
                        'transaction_status' => $lockedOrder->latestPayment->transaction_status ?? 'manual_cancelled',
                    ])->save();
                }
            }

            if ($status === Order::STATUS_REFUNDED) {
                $attributes['payment_status'] = Order::PAYMENT_REFUNDED;
                $attributes['cancelled_at'] = $lockedOrder->cancelled_at ?? now();

                $this->inventoryService->releaseOrderStock(
                    $lockedOrder,
                    $actor,
                    'Stok dirilis ulang karena order direfund oleh admin.',
                );

                if ($lockedOrder->latestPayment instanceof Payment) {
                    $lockedOrder->latestPayment->forceFill([
                        'status' => Payment::STATUS_REFUNDED,
                    ])->save();
                }
            }

            $lockedOrder->forceFill($attributes)->save();

            return $lockedOrder->fresh(['user', 'items.product', 'payments', 'latestPayment']);
        });
    }
}
