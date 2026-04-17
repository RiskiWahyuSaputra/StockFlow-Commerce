<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = Str::title(fake()->unique()->words(fake()->numberBetween(2, 4), true));
        $price = fake()->numberBetween(50000, 1500000);
        $stock = fake()->numberBetween(0, 150);

        return [
            'category_id' => Category::factory(),
            'name' => $name,
            'slug' => Str::slug($name).'-'.fake()->unique()->numberBetween(100, 999),
            'sku' => 'SKU-'.fake()->unique()->bothify('??###??'),
            'short_description' => fake()->sentence(),
            'description' => fake()->paragraphs(3, true),
            'price' => $price,
            'stock' => $stock,
            'low_stock_threshold' => fake()->numberBetween(3, 10),
            'weight' => fake()->numberBetween(200, 3000),
            'track_stock' => true,
            'is_featured' => fake()->boolean(20),
            'status' => Product::STATUS_ACTIVE,
            'published_at' => now()->subDays(fake()->numberBetween(1, 45)),
        ];
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => Product::STATUS_DRAFT,
            'published_at' => null,
        ]);
    }
}
