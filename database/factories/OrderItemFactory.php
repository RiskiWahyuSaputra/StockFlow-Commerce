<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<OrderItem>
 */
class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition(): array
    {
        $name = Str::title(fake()->words(3, true));
        $quantity = fake()->numberBetween(1, 4);
        $unitPrice = fake()->numberBetween(50000, 750000);
        $discount = fake()->numberBetween(0, 25000);

        return [
            'order_id' => Order::factory(),
            'product_id' => Product::factory(),
            'product_name' => $name,
            'product_slug' => Str::slug($name),
            'sku' => 'SKU-'.fake()->unique()->bothify('??###??'),
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'discount_amount' => $discount,
            'total_price' => ($quantity * $unitPrice) - $discount,
        ];
    }
}
