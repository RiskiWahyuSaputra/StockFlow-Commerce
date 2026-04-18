<?php

namespace App\Services;

use App\Models\InventoryLog;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class InventoryService
{
    public function restock(int $productId, int $quantity, ?User $actor = null, ?string $note = null): InventoryLog
    {
        if ($quantity < 1) {
            throw ValidationException::withMessages([
                'quantity' => 'Quantity restock harus lebih besar dari 0.',
            ]);
        }

        return $this->changeStock($productId, $quantity, InventoryLog::TYPE_RESTOCK, [
            'user' => $actor,
            'note' => $note ?: 'Manual restock oleh admin.',
            'reference_type' => 'admin_manual',
            'reference_id' => $actor?->id,
            'metadata' => [
                'source' => 'admin_restock',
            ],
        ]);
    }

    public function syncStock(int $productId, int $targetStock, ?User $actor = null, ?string $note = null): InventoryLog
    {
        if ($targetStock < 0) {
            throw ValidationException::withMessages([
                'stock' => 'Target stok tidak boleh minus.',
            ]);
        }

        return DB::transaction(function () use ($productId, $targetStock, $actor, $note): InventoryLog {
            $product = Product::query()
                ->select(['id', 'stock'])
                ->lockForUpdate()
                ->findOrFail($productId);

            $delta = $targetStock - (int) $product->stock;

            if ($delta === 0) {
                throw ValidationException::withMessages([
                    'stock' => 'Target stok sama dengan stok saat ini, jadi tidak ada perubahan yang perlu disimpan.',
                ]);
            }

            return $this->persistStockChange($product, $delta, InventoryLog::TYPE_ADJUSTMENT, [
                'user' => $actor,
                'note' => $note ?: 'Sinkronisasi stok manual oleh admin.',
                'reference_type' => 'admin_stock_sync',
                'reference_id' => $actor?->id,
                'metadata' => [
                    'source' => 'admin_stock_sync',
                    'target_stock' => $targetStock,
                ],
            ]);
        });
    }

    public function reserveOrderStock(Order $order, Collection $items, ?User $actor = null): void
    {
        foreach ($items as $item) {
            if (! $item instanceof OrderItem && ! method_exists($item, 'getAttribute')) {
                continue;
            }

            $existingLog = InventoryLog::query()
                ->where('product_id', $item->product_id)
                ->where('type', InventoryLog::TYPE_RESERVED)
                ->where('reference_type', 'order')
                ->where('reference_id', $order->id)
                ->first();

            if ($existingLog) {
                continue;
            }

            $this->changeStock($item->product_id, -((int) $item->quantity), InventoryLog::TYPE_RESERVED, [
                'user' => $actor,
                'order' => $order,
                'note' => 'Stock reserved saat checkout order dibuat.',
                'reference_type' => 'order',
                'reference_id' => $order->id,
                'metadata' => [
                    'source' => 'checkout',
                    'order_number' => $order->order_number,
                ],
            ]);
        }
    }

    public function confirmOrderPayment(Order $order, ?User $actor = null): void
    {
        $order->loadMissing('items');

        foreach ($order->items as $item) {
            $existingLog = InventoryLog::query()
                ->where('product_id', $item->product_id)
                ->where('type', InventoryLog::TYPE_DEDUCTED)
                ->where('reference_type', 'order')
                ->where('reference_id', $order->id)
                ->first();

            if ($existingLog) {
                continue;
            }

            $product = Product::query()
                ->select(['id', 'stock'])
                ->lockForUpdate()
                ->find($item->product_id);

            if (! $product) {
                continue;
            }

            $this->persistStockChange($product, 0, InventoryLog::TYPE_DEDUCTED, [
                'user' => $actor,
                'order' => $order,
                'note' => 'Reservasi stok difinalisasi setelah payment Midtrans berhasil.',
                'reference_type' => 'order',
                'reference_id' => $order->id,
                'metadata' => [
                    'source' => 'payment_success',
                    'order_number' => $order->order_number,
                ],
            ]);
        }
    }

    public function releaseOrderStock(Order $order, ?User $actor = null, ?string $note = null): void
    {
        $order->loadMissing('items');

        foreach ($order->items as $item) {
            $existingLog = InventoryLog::query()
                ->where('product_id', $item->product_id)
                ->where('type', InventoryLog::TYPE_RELEASED)
                ->where('reference_type', 'order')
                ->where('reference_id', $order->id)
                ->first();

            if ($existingLog) {
                continue;
            }

            $this->changeStock($item->product_id, (int) $item->quantity, InventoryLog::TYPE_RELEASED, [
                'user' => $actor,
                'order' => $order,
                'note' => $note ?: 'Stok dirilis ulang karena order dibatalkan atau payment gagal.',
                'reference_type' => 'order',
                'reference_id' => $order->id,
                'metadata' => [
                    'source' => 'order_cancellation',
                    'order_number' => $order->order_number,
                ],
            ]);
        }
    }

    public function changeStock(int $productId, int $quantityChanged, string $type, array $context = []): InventoryLog
    {
        return DB::transaction(function () use ($productId, $quantityChanged, $type, $context): InventoryLog {
            $product = Product::query()
                ->select(['id', 'stock'])
                ->lockForUpdate()
                ->findOrFail($productId);

            return $this->persistStockChange($product, $quantityChanged, $type, $context);
        });
    }

    protected function persistStockChange(Product $product, int $quantityChanged, string $type, array $context = []): InventoryLog
    {
        $before = (int) $product->stock;
        $after = $before + $quantityChanged;

        if ($after < 0) {
            throw ValidationException::withMessages([
                'stock' => 'Stok tidak cukup untuk operasi inventory ini. Stok saat ini: '.$before.'.',
            ]);
        }

        if ($quantityChanged !== 0) {
            $product->forceFill([
                'stock' => $after,
            ])->save();
        }

        /** @var User|null $user */
        $user = $context['user'] ?? null;
        /** @var Order|null $order */
        $order = $context['order'] ?? null;

        return InventoryLog::create([
            'product_id' => $product->id,
            'user_id' => $user?->id,
            'order_id' => $order?->id,
            'type' => $type,
            'quantity_before' => $before,
            'quantity_change' => $quantityChanged,
            'quantity_changed' => $quantityChanged,
            'quantity_after' => $after,
            'reference' => $context['reference'] ?? $order?->order_number,
            'reference_type' => $context['reference_type'] ?? null,
            'reference_id' => $context['reference_id'] ?? null,
            'notes' => $context['note'] ?? null,
            'note' => $context['note'] ?? null,
            'metadata' => $context['metadata'] ?? null,
        ]);
    }
}
