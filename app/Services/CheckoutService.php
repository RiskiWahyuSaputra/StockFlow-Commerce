<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\InventoryLog;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CheckoutService
{
    public function __construct(
        protected CartService $cartService,
    ) {
    }

    public function getCheckoutCart(User $user): Cart
    {
        return $this->cartService->getActiveCart($user);
    }

    public function placeOrder(User $user, array $payload): Order
    {
        return DB::transaction(function () use ($user, $payload): Order {
            $cart = Cart::query()
                ->where('user_id', $user->id)
                ->active()
                ->lockForUpdate()
                ->first();

            if (! $cart) {
                throw ValidationException::withMessages([
                    'cart' => 'Cart aktif tidak ditemukan.',
                ]);
            }

            $cart->load([
                'items.product' => fn ($query) => $query->withTrashed(),
            ]);

            $this->ensureCartIsReady($cart);

            $products = Product::query()
                ->select(['id', 'name', 'slug', 'sku', 'price', 'stock', 'status'])
                ->active()
                ->whereIn('id', $cart->items->pluck('product_id'))
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            if ($products->count() !== $cart->items->count()) {
                throw ValidationException::withMessages([
                    'cart' => 'Ada produk di cart yang sudah tidak tersedia untuk checkout.',
                ]);
            }

            $subtotal = 0;

            foreach ($cart->items as $item) {
                $product = $products->get($item->product_id);

                if (! $product) {
                    throw ValidationException::withMessages([
                        'cart' => 'Ada produk di cart yang sudah tidak tersedia untuk checkout.',
                    ]);
                }

                if ($item->quantity > $product->stock) {
                    throw ValidationException::withMessages([
                        'cart' => 'Stok untuk '.$product->name.' tinggal '.$product->stock.' item. Mohon update cart terlebih dahulu.',
                    ]);
                }

                $lineTotal = $item->quantity * (float) $product->price;
                $subtotal += $lineTotal;

                $item->forceFill([
                    'unit_price' => $product->price,
                    'subtotal' => $lineTotal,
                ])->save();
            }

            $order = Order::create([
                'user_id' => $user->id,
                'cart_id' => $cart->id,
                'order_status' => Order::STATUS_PENDING,
                'payment_status' => Order::PAYMENT_UNPAID,
                'currency' => 'IDR',
                'subtotal' => $subtotal,
                'shipping_cost' => 0,
                'tax_amount' => 0,
                'discount_amount' => 0,
                'grand_total' => $subtotal,
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'customer_phone' => $payload['phone'],
                'shipping_recipient_name' => $payload['recipient_name'],
                'shipping_phone' => $payload['phone'],
                'shipping_address_line1' => $payload['address'],
                'shipping_address_line2' => null,
                'shipping_city' => $payload['city'],
                'shipping_state' => null,
                'shipping_postal_code' => $payload['postal_code'],
                'shipping_country' => 'ID',
                'shipping_notes' => $payload['note'] ?? null,
                'notes' => null,
                'placed_at' => now(),
            ]);

            $order->items()->createMany(
                $cart->items->map(function ($item) use ($products): array {
                    $product = $products->get($item->product_id);

                    return [
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'product_slug' => $product->slug,
                        'sku' => $product->sku,
                        'quantity' => $item->quantity,
                        'unit_price' => $product->price,
                        'discount_amount' => 0,
                        'total_price' => $item->quantity * (float) $product->price,
                    ];
                })->all()
            );

            foreach ($cart->items as $item) {
                $product = $products->get($item->product_id);
                $before = (int) $product->stock;
                $after = $before - $item->quantity;

                $product->forceFill([
                    'stock' => $after,
                ])->save();

                InventoryLog::create([
                    'product_id' => $product->id,
                    'user_id' => $user->id,
                    'order_id' => $order->id,
                    'type' => InventoryLog::TYPE_RESERVED,
                    'quantity_before' => $before,
                    'quantity_change' => -$item->quantity,
                    'quantity_after' => $after,
                    'reference' => $order->order_number,
                    'notes' => 'Stock reserved saat checkout order dibuat.',
                    'metadata' => [
                        'source' => 'checkout',
                        'cart_id' => $cart->id,
                    ],
                ]);
            }

            $cart->items()->delete();
            $cart->forceFill([
                'status' => Cart::STATUS_CONVERTED,
                'total_items' => 0,
                'subtotal' => 0,
                'converted_at' => now(),
            ])->save();

            return $order->load('items');
        });
    }

    protected function ensureCartIsReady(Cart $cart): void
    {
        if ($cart->items->isEmpty()) {
            throw ValidationException::withMessages([
                'cart' => 'Cart masih kosong. Tambahkan produk sebelum checkout.',
            ]);
        }
    }
}
