<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CartService
{
    public function getActiveCart(User $user): Cart
    {
        $cart = $user->activeCart()->first();

        if ($cart) {
            return $this->loadCartRelations($cart);
        }

        $cart = $user->carts()->create([
            'status' => Cart::STATUS_ACTIVE,
            'currency' => 'IDR',
            'total_items' => 0,
            'subtotal' => 0,
            'expired_at' => now()->addDays(7),
        ]);

        return $this->loadCartRelations($cart);
    }

    public function addItem(User $user, int $productId, int $quantity): Cart
    {
        return DB::transaction(function () use ($user, $productId, $quantity): Cart {
            $product = Product::query()
                ->select(['id', 'price', 'stock', 'status'])
                ->active()
                ->lockForUpdate()
                ->findOrFail($productId);

            $cart = $this->resolveActiveCartForUpdate($user);

            $item = CartItem::query()
                ->where('cart_id', $cart->id)
                ->where('product_id', $product->id)
                ->lockForUpdate()
                ->first();

            $nextQuantity = ($item?->quantity ?? 0) + $quantity;

            $this->ensureAvailableStock($product, $nextQuantity);

            if ($item) {
                $item->update([
                    'quantity' => $nextQuantity,
                    'unit_price' => $product->price,
                    'subtotal' => $nextQuantity * (float) $product->price,
                ]);
            } else {
                $cart->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $product->price,
                    'subtotal' => $quantity * (float) $product->price,
                ]);
            }

            $this->refreshCartTotals($cart);

            return $this->loadCartRelations($cart->fresh());
        });
    }

    public function updateItemQuantity(CartItem $cartItem, int $quantity): Cart
    {
        return DB::transaction(function () use ($cartItem, $quantity): Cart {
            $product = Product::query()
                ->select(['id', 'price', 'stock', 'status'])
                ->active()
                ->lockForUpdate()
                ->findOrFail($cartItem->product_id);

            $this->ensureAvailableStock($product, $quantity);

            $cartItem->update([
                'quantity' => $quantity,
                'unit_price' => $product->price,
                'subtotal' => $quantity * (float) $product->price,
            ]);

            $this->refreshCartTotals($cartItem->cart);

            return $this->loadCartRelations($cartItem->cart->fresh());
        });
    }

    public function removeItem(CartItem $cartItem): Cart
    {
        return DB::transaction(function () use ($cartItem): Cart {
            $cart = $cartItem->cart;

            $cartItem->delete();

            $this->refreshCartTotals($cart);

            return $this->loadCartRelations($cart->fresh());
        });
    }

    protected function resolveActiveCartForUpdate(User $user): Cart
    {
        $cart = Cart::query()
            ->where('user_id', $user->id)
            ->active()
            ->lockForUpdate()
            ->first();

        if ($cart) {
            return $cart;
        }

        return $user->carts()->create([
            'status' => Cart::STATUS_ACTIVE,
            'currency' => 'IDR',
            'total_items' => 0,
            'subtotal' => 0,
            'expired_at' => now()->addDays(7),
        ]);
    }

    protected function refreshCartTotals(Cart $cart): void
    {
        $cart->forceFill([
            'total_items' => (int) $cart->items()->sum('quantity'),
            'subtotal' => (float) $cart->items()->sum('subtotal'),
        ])->save();
    }

    protected function ensureAvailableStock(Product $product, int $requestedQuantity): void
    {
        if ($product->stock < 1) {
            throw ValidationException::withMessages([
                'quantity' => 'Produk ini sedang habis dan belum bisa dimasukkan ke cart.',
            ]);
        }

        if ($requestedQuantity > $product->stock) {
            throw ValidationException::withMessages([
                'quantity' => 'Quantity melebihi stok tersedia. Stok saat ini: '.$product->stock.'.',
            ]);
        }
    }

    protected function loadCartRelations(Cart $cart): Cart
    {
        return $cart->load([
            'items.product.category',
            'items.product.primaryImage',
        ]);
    }
}
