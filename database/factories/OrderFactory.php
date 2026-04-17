<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $subtotal = fake()->numberBetween(100000, 2500000);
        $shipping = fake()->numberBetween(10000, 50000);
        $tax = fake()->numberBetween(0, 25000);
        $discount = fake()->numberBetween(0, 50000);

        return [
            'user_id' => User::factory(),
            'cart_id' => null,
            'order_number' => 'ORD-'.now()->format('Ymd').'-'.Str::upper(fake()->unique()->bothify('??##??')),
            'order_status' => Order::STATUS_PENDING,
            'payment_status' => Order::PAYMENT_UNPAID,
            'currency' => 'IDR',
            'subtotal' => $subtotal,
            'shipping_cost' => $shipping,
            'tax_amount' => $tax,
            'discount_amount' => $discount,
            'grand_total' => $subtotal + $shipping + $tax - $discount,
            'customer_name' => fake()->name(),
            'customer_email' => fake()->safeEmail(),
            'customer_phone' => fake()->numerify('08##########'),
            'shipping_recipient_name' => fake()->name(),
            'shipping_phone' => fake()->numerify('08##########'),
            'shipping_address_line1' => fake()->streetAddress(),
            'shipping_address_line2' => fake()->secondaryAddress(),
            'shipping_city' => fake()->city(),
            'shipping_state' => fake()->state(),
            'shipping_postal_code' => fake()->postcode(),
            'shipping_country' => 'ID',
            'shipping_notes' => fake()->optional()->sentence(),
            'notes' => fake()->optional()->sentence(),
            'placed_at' => now()->subDays(fake()->numberBetween(1, 14)),
            'paid_at' => null,
            'cancelled_at' => null,
            'completed_at' => null,
        ];
    }
}
