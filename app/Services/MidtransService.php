<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Midtrans\Config;
use Midtrans\Snap;
use RuntimeException;

class MidtransService
{
    public function __construct(
        protected InventoryService $inventoryService,
    ) {}

    public function createSnapPayment(Order $order): Payment
    {
        $order->loadMissing(['items', 'user', 'latestPayment']);

        if ($order->user_id === null) {
            throw ValidationException::withMessages([
                'order' => 'Order tidak valid untuk inisialisasi pembayaran.',
            ]);
        }

        if (in_array($order->order_status, [Order::STATUS_CANCELLED, Order::STATUS_REFUNDED], true)) {
            throw ValidationException::withMessages([
                'order' => 'Order ini sudah tidak bisa dibayarkan lagi.',
            ]);
        }

        if ($order->payment_status === Order::PAYMENT_PAID) {
            return $order->latestPayment ?? $order->payments()->latest()->firstOrFail();
        }

        if (
            $order->latestPayment
            && $order->latestPayment->status === Payment::STATUS_PENDING
            && filled($order->latestPayment->snap_token)
        ) {
            return $order->latestPayment;
        }

        $this->configure();

        $payload = $this->buildSnapPayload($order);
        $snapResponse = Snap::createTransaction($payload);

        return DB::transaction(function () use ($order, $payload, $snapResponse): Payment {
            $payment = $order->payments()->create([
                'provider' => 'midtrans',
                'method' => 'snap',
                'payment_type' => 'snap',
                'status' => Payment::STATUS_PENDING,
                'amount' => $order->grand_total,
                'gross_amount' => $order->grand_total,
                'currency' => $order->currency,
                'external_id' => $order->order_number,
                'snap_token' => $snapResponse->token ?? null,
                'snap_redirect_url' => $snapResponse->redirect_url ?? null,
                'transaction_status' => 'pending',
                'payload' => [
                    'snap_request' => $payload,
                    'snap_response' => [
                        'token' => $snapResponse->token ?? null,
                        'redirect_url' => $snapResponse->redirect_url ?? null,
                    ],
                ],
            ]);

            $order->forceFill([
                'payment_status' => Order::PAYMENT_PENDING,
            ])->save();

            return $payment->fresh();
        });
    }

    public function handleNotification(array $payload): Payment
    {
        $this->configure();
        $this->validateNotificationPayload($payload);
        $this->verifySignature($payload);

        return DB::transaction(function () use ($payload): Payment {
            $order = Order::query()
                ->where('order_number', $payload['order_id'])
                ->lockForUpdate()
                ->firstOrFail();

            $payment = Payment::query()
                ->where('external_id', $payload['order_id'])
                ->latest('id')
                ->lockForUpdate()
                ->first();

            if (! $payment) {
                $payment = $order->payments()->create([
                    'provider' => 'midtrans',
                    'method' => 'snap',
                    'payment_type' => $payload['payment_type'] ?? 'snap',
                    'status' => Payment::STATUS_PENDING,
                    'amount' => $order->grand_total,
                    'gross_amount' => (float) $payload['gross_amount'],
                    'currency' => $order->currency,
                    'external_id' => $payload['order_id'],
                ]);
            }

            $localPaymentStatus = $this->resolveLocalPaymentStatus(
                $payload['transaction_status'],
                $payload['fraud_status'] ?? null,
            );

            $payment->forceFill([
                'method' => 'snap',
                'payment_type' => $payload['payment_type'] ?? $payment->payment_type,
                'status' => $localPaymentStatus,
                'amount' => $order->grand_total,
                'gross_amount' => (float) $payload['gross_amount'],
                'currency' => $payload['currency'] ?? $order->currency,
                'external_id' => $payload['order_id'],
                'transaction_id' => $payload['transaction_id'] ?? $payment->transaction_id,
                'transaction_status' => $payload['transaction_status'],
                'fraud_status' => $payload['fraud_status'] ?? null,
                'status_code' => (string) ($payload['status_code'] ?? ''),
                'signature_key' => $payload['signature_key'] ?? null,
                'transaction_time' => $this->parseMidtransTimestamp($payload['transaction_time'] ?? null),
                'paid_at' => $this->resolvePaidAt($payload, $localPaymentStatus, $payment),
                'expired_at' => $this->resolveExpiredAt($payload, $localPaymentStatus, $payment),
                'failure_code' => $localPaymentStatus === Payment::STATUS_FAILED ? (string) ($payload['status_code'] ?? '') : null,
                'failure_message' => $this->resolveFailureMessage($payload, $localPaymentStatus),
                'payload' => $payload,
            ])->save();

            $this->syncOrderStatus($order, $payment, $payload);

            return $payment->fresh('order');
        });
    }

    protected function configure(): void
    {
        if (blank(config('midtrans.server_key'))) {
            throw new RuntimeException('Midtrans configuration is incomplete. Please set MIDTRANS_SERVER_KEY.');
        }

        Config::$serverKey = (string) config('midtrans.server_key');
        Config::$isProduction = (bool) config('midtrans.is_production');
        Config::$isSanitized = (bool) config('midtrans.is_sanitized');
        Config::$is3ds = (bool) config('midtrans.is_3ds');
    }

    protected function buildSnapPayload(Order $order): array
    {
        $itemDetails = $order->items
            ->map(function ($item): array {
                return [
                    'id' => $item->sku ?: 'ITEM-'.$item->id,
                    'price' => (int) round((float) $item->unit_price),
                    'quantity' => (int) $item->quantity,
                    'name' => Str::limit($item->product_name, 50, ''),
                ];
            })
            ->values()
            ->all();

        if ((float) $order->shipping_cost > 0) {
            $itemDetails[] = [
                'id' => 'SHIPPING',
                'price' => (int) round((float) $order->shipping_cost),
                'quantity' => 1,
                'name' => 'Shipping Cost',
            ];
        }

        return [
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => (int) round((float) $order->grand_total),
            ],
            'customer_details' => [
                'first_name' => $order->shipping_recipient_name,
                'email' => $order->customer_email,
                'phone' => $order->shipping_phone,
                'billing_address' => [
                    'first_name' => $order->customer_name,
                    'phone' => $order->customer_phone,
                    'address' => $order->shipping_address_line1,
                    'city' => $order->shipping_city,
                    'postal_code' => $order->shipping_postal_code,
                    'country_code' => $order->shipping_country,
                ],
                'shipping_address' => [
                    'first_name' => $order->shipping_recipient_name,
                    'phone' => $order->shipping_phone,
                    'address' => $order->shipping_address_line1,
                    'city' => $order->shipping_city,
                    'postal_code' => $order->shipping_postal_code,
                    'country_code' => $order->shipping_country,
                ],
            ],
            'item_details' => $itemDetails,
            'callbacks' => [
                'finish' => route('checkout.success', $order),
                'pending' => route('checkout.success', $order),
                'error' => route('checkout.success', $order),
            ],
        ];
    }

    protected function validateNotificationPayload(array $payload): void
    {
        foreach (['order_id', 'status_code', 'gross_amount', 'transaction_status', 'signature_key'] as $key) {
            if (blank($payload[$key] ?? null)) {
                throw ValidationException::withMessages([
                    'notification' => 'Payload notifikasi Midtrans tidak lengkap.',
                ]);
            }
        }
    }

    protected function verifySignature(array $payload): void
    {
        $expectedSignature = hash(
            'sha512',
            $payload['order_id'].$payload['status_code'].$payload['gross_amount'].config('midtrans.server_key'),
        );

        if (! hash_equals($expectedSignature, (string) $payload['signature_key'])) {
            throw ValidationException::withMessages([
                'notification' => 'Signature Midtrans tidak valid.',
            ]);
        }
    }

    protected function syncOrderStatus(Order $order, Payment $payment, array $payload): void
    {
        $orderPaymentStatus = $this->resolveOrderPaymentStatus($payment->status);
        $orderStatus = $this->resolveOrderStatus($payment->status, $payload['transaction_status']);

        if ($payment->status === Payment::STATUS_PAID) {
            $this->inventoryService->confirmOrderPayment($order, $order->user);
        }

        if ($this->shouldReleaseReservedStock($order, $payment, $payload['transaction_status'])) {
            $this->inventoryService->releaseOrderStock(
                $order,
                $order->user,
                'Stok dirilis ulang karena payment Midtrans '.$payment->transaction_status.'.',
            );
        }

        $order->forceFill([
            'payment_status' => $orderPaymentStatus,
            'order_status' => $orderStatus,
            'paid_at' => $payment->status === Payment::STATUS_PAID
                ? ($order->paid_at ?? $payment->paid_at ?? now())
                : $order->paid_at,
            'cancelled_at' => in_array($payment->status, [Payment::STATUS_FAILED, Payment::STATUS_EXPIRED, Payment::STATUS_CANCELLED], true)
                ? ($order->cancelled_at ?? now())
                : $order->cancelled_at,
        ])->save();
    }

    protected function resolveLocalPaymentStatus(string $transactionStatus, ?string $fraudStatus): string
    {
        return match ($transactionStatus) {
            'capture' => $fraudStatus === 'challenge'
                ? Payment::STATUS_PENDING
                : Payment::STATUS_PAID,
            'settlement' => Payment::STATUS_PAID,
            'pending' => Payment::STATUS_PENDING,
            'deny' => Payment::STATUS_FAILED,
            'expire' => Payment::STATUS_EXPIRED,
            'cancel' => Payment::STATUS_CANCELLED,
            'refund', 'partial_refund' => Payment::STATUS_REFUNDED,
            default => Payment::STATUS_PENDING,
        };
    }

    protected function resolveOrderPaymentStatus(string $paymentStatus): string
    {
        return match ($paymentStatus) {
            Payment::STATUS_PAID => Order::PAYMENT_PAID,
            Payment::STATUS_EXPIRED => Order::PAYMENT_EXPIRED,
            Payment::STATUS_REFUNDED => Order::PAYMENT_REFUNDED,
            Payment::STATUS_FAILED, Payment::STATUS_CANCELLED => Order::PAYMENT_FAILED,
            default => Order::PAYMENT_PENDING,
        };
    }

    protected function resolveOrderStatus(string $paymentStatus, string $transactionStatus): string
    {
        return match (true) {
            $paymentStatus === Payment::STATUS_PAID => Order::STATUS_PAID,
            $paymentStatus === Payment::STATUS_REFUNDED => Order::STATUS_REFUNDED,
            in_array($paymentStatus, [Payment::STATUS_FAILED, Payment::STATUS_EXPIRED, Payment::STATUS_CANCELLED], true) => Order::STATUS_CANCELLED,
            $transactionStatus === 'capture' => Order::STATUS_PENDING,
            default => Order::STATUS_PENDING,
        };
    }

    protected function shouldReleaseReservedStock(Order $order, Payment $payment, string $transactionStatus): bool
    {
        if ($order->cancelled_at !== null) {
            return false;
        }

        if ($payment->status === Payment::STATUS_REFUNDED) {
            return false;
        }

        return in_array($transactionStatus, ['deny', 'expire', 'cancel'], true);
    }

    protected function parseMidtransTimestamp(?string $value): ?Carbon
    {
        if (blank($value)) {
            return null;
        }

        return Carbon::parse($value, 'Asia/Jakarta');
    }

    protected function resolvePaidAt(array $payload, string $localPaymentStatus, Payment $payment): ?Carbon
    {
        if ($localPaymentStatus !== Payment::STATUS_PAID) {
            return $payment->paid_at;
        }

        return $this->parseMidtransTimestamp($payload['settlement_time'] ?? $payload['transaction_time'] ?? null) ?? now();
    }

    protected function resolveExpiredAt(array $payload, string $localPaymentStatus, Payment $payment): ?Carbon
    {
        if ($localPaymentStatus !== Payment::STATUS_EXPIRED) {
            return $payment->expired_at;
        }

        return $this->parseMidtransTimestamp($payload['expiry_time'] ?? null) ?? now();
    }

    protected function resolveFailureMessage(array $payload, string $localPaymentStatus): ?string
    {
        if (! in_array($localPaymentStatus, [Payment::STATUS_FAILED, Payment::STATUS_EXPIRED, Payment::STATUS_CANCELLED], true)) {
            return null;
        }

        return $payload['status_message'] ?? 'Midtrans mengembalikan status pembayaran yang tidak berhasil.';
    }
}
