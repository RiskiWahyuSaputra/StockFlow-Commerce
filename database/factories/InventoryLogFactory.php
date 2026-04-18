<?php

namespace Database\Factories;

use App\Models\InventoryLog;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<InventoryLog>
 */
class InventoryLogFactory extends Factory
{
    protected $model = InventoryLog::class;

    public function definition(): array
    {
        $before = fake()->numberBetween(10, 100);
        $change = fake()->numberBetween(-5, 25);
        $after = max(0, $before + $change);

        return [
            'product_id' => Product::factory(),
            'user_id' => User::factory()->admin(),
            'order_id' => null,
            'type' => InventoryLog::TYPE_ADJUSTMENT,
            'quantity_before' => $before,
            'quantity_change' => $change,
            'quantity_changed' => $change,
            'quantity_after' => $after,
            'reference' => fake()->optional()->bothify('INV-###??'),
            'reference_type' => 'factory',
            'reference_id' => null,
            'notes' => fake()->optional()->sentence(),
            'note' => fake()->optional()->sentence(),
            'metadata' => [
                'source' => 'factory',
            ],
        ];
    }
}
