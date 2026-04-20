<?php

namespace Tests\Concerns;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;

trait CreatesEcommerceData
{
    protected function createCustomer(array $attributes = []): User
    {
        return User::factory()->create($attributes);
    }

    protected function createAdmin(array $attributes = []): User
    {
        return User::factory()->admin()->create($attributes);
    }

    protected function createActiveCategory(array $attributes = []): Category
    {
        return Category::factory()->create($attributes);
    }

    protected function createActiveProduct(array $attributes = []): Product
    {
        $category = $attributes['category'] ?? $this->createActiveCategory();
        unset($attributes['category']);

        return Product::factory()
            ->for($category)
            ->create(array_merge([
                'status' => Product::STATUS_ACTIVE,
                'published_at' => now(),
            ], $attributes));
    }

    protected function createCartWithItem(User $user, Product $product, int $quantity = 1): Cart
    {
        $cart = Cart::factory()->for($user)->create([
            'status' => Cart::STATUS_ACTIVE,
        ]);

        CartItem::factory()
            ->for($cart)
            ->for($product)
            ->create([
                'quantity' => $quantity,
                'unit_price' => $product->price,
                'subtotal' => $quantity * (float) $product->price,
            ]);

        $cart->forceFill([
            'total_items' => $quantity,
            'subtotal' => $quantity * (float) $product->price,
        ])->save();

        return $cart->fresh(['items.product']);
    }
}
