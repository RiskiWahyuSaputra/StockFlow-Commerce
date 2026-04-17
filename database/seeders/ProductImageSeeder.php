<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductImageSeeder extends Seeder
{
    public function run(): void
    {
        Product::query()->get()->each(function (Product $product): void {
            $images = [
                [
                    'sort_order' => 1,
                    'is_primary' => true,
                    'path' => 'products/'.$product->slug.'-1.jpg',
                ],
                [
                    'sort_order' => 2,
                    'is_primary' => false,
                    'path' => 'products/'.$product->slug.'-2.jpg',
                ],
            ];

            foreach ($images as $imageData) {
                ProductImage::updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'sort_order' => $imageData['sort_order'],
                    ],
                    [
                        'path' => $imageData['path'],
                        'alt_text' => Str::limit($product->name.' product image '.$imageData['sort_order'], 255),
                        'is_primary' => $imageData['is_primary'],
                    ]
                );
            }
        });
    }
}
