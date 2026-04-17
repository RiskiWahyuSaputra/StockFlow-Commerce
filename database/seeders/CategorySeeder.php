<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'description' => 'Perangkat elektronik untuk kebutuhan harian dan produktivitas.',
                'children' => [
                    ['name' => 'Smartphones', 'slug' => 'smartphones'],
                    ['name' => 'Laptops', 'slug' => 'laptops'],
                    ['name' => 'Accessories', 'slug' => 'accessories'],
                ],
            ],
            [
                'name' => 'Home Living',
                'slug' => 'home-living',
                'description' => 'Produk rumah tangga dan dekorasi fungsional.',
                'children' => [
                    ['name' => 'Kitchen', 'slug' => 'kitchen'],
                    ['name' => 'Lighting', 'slug' => 'lighting'],
                ],
            ],
            [
                'name' => 'Fashion',
                'slug' => 'fashion',
                'description' => 'Apparel dan lifestyle essentials.',
                'children' => [
                    ['name' => 'Men', 'slug' => 'men'],
                    ['name' => 'Women', 'slug' => 'women'],
                ],
            ],
        ];

        foreach ($categories as $index => $categoryData) {
            $parent = Category::updateOrCreate(
                ['slug' => $categoryData['slug']],
                [
                    'parent_id' => null,
                    'name' => $categoryData['name'],
                    'description' => $categoryData['description'],
                    'status' => Category::STATUS_ACTIVE,
                    'sort_order' => $index + 1,
                ]
            );

            foreach ($categoryData['children'] as $childIndex => $childData) {
                Category::updateOrCreate(
                    ['slug' => $childData['slug']],
                    [
                        'parent_id' => $parent->id,
                        'name' => $childData['name'],
                        'description' => 'Subkategori '.$childData['name'].' dari '.$categoryData['name'].'.',
                        'status' => Category::STATUS_ACTIVE,
                        'sort_order' => $childIndex + 1,
                    ]
                );
            }
        }
    }
}
