<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $name = Str::title(fake()->unique()->words(fake()->numberBetween(1, 2), true));

        return [
            'parent_id' => null,
            'name' => $name,
            'slug' => Str::slug($name).'-'.fake()->unique()->numberBetween(10, 999),
            'description' => fake()->sentence(),
            'status' => Category::STATUS_ACTIVE,
            'sort_order' => fake()->numberBetween(0, 50),
        ];
    }
}
