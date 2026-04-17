<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Cart>
 */
class CartFactory extends Factory
{
    protected $model = Cart::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'status' => Cart::STATUS_ACTIVE,
            'currency' => 'IDR',
            'total_items' => 0,
            'subtotal' => 0,
            'converted_at' => null,
            'expired_at' => now()->addDays(7),
        ];
    }
}
