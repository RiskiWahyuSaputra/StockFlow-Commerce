<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'category_slug' => 'smartphones',
                'name' => 'Aurora X1 Smartphone',
                'slug' => 'aurora-x1-smartphone',
                'sku' => 'PHN-AURORA-X1',
                'short_description' => 'Smartphone OLED dengan performa cepat untuk kebutuhan harian.',
                'description' => 'Aurora X1 hadir dengan layar OLED tajam, chipset hemat daya, dan kamera utama 50MP.',
                'price' => 3999000,
                'stock' => 24,
                'is_featured' => true,
            ],
            [
                'category_slug' => 'laptops',
                'name' => 'Nimbus Pro 14',
                'slug' => 'nimbus-pro-14',
                'sku' => 'LTP-NIMBUS-PRO14',
                'short_description' => 'Laptop tipis untuk kerja, kuliah, dan aktivitas kreatif ringan.',
                'description' => 'Nimbus Pro 14 menawarkan layar 14 inci, SSD cepat, dan baterai tahan seharian.',
                'price' => 12499000,
                'stock' => 12,
                'is_featured' => true,
            ],
            [
                'category_slug' => 'accessories',
                'name' => 'Pulse Wireless Earbuds',
                'slug' => 'pulse-wireless-earbuds',
                'sku' => 'ACC-PULSE-EARBUDS',
                'short_description' => 'Earbuds TWS dengan latensi rendah dan charging case ringkas.',
                'description' => 'Pulse Wireless Earbuds cocok untuk meeting, musik, dan pemakaian harian.',
                'price' => 749000,
                'stock' => 55,
                'is_featured' => false,
            ],
            [
                'category_slug' => 'kitchen',
                'name' => 'ChefMate Multi Pan',
                'slug' => 'chefmate-multi-pan',
                'sku' => 'KIT-CHEFMATE-PAN',
                'short_description' => 'Pan anti lengket serbaguna untuk dapur modern.',
                'description' => 'ChefMate Multi Pan memiliki lapisan anti lengket, distribusi panas merata, dan handle ergonomis.',
                'price' => 329000,
                'stock' => 40,
                'is_featured' => false,
            ],
            [
                'category_slug' => 'lighting',
                'name' => 'Luma Desk Lamp',
                'slug' => 'luma-desk-lamp',
                'sku' => 'HOM-LUMA-LAMP',
                'short_description' => 'Lampu meja minimalis dengan pengaturan brightness fleksibel.',
                'description' => 'Luma Desk Lamp mendukung tiga mode warna cahaya dan desain hemat ruang.',
                'price' => 289000,
                'stock' => 18,
                'is_featured' => false,
            ],
            [
                'category_slug' => 'men',
                'name' => 'Urban Essential Hoodie',
                'slug' => 'urban-essential-hoodie',
                'sku' => 'FSH-URBAN-HOODIE',
                'short_description' => 'Hoodie nyaman dengan potongan relaxed untuk daily wear.',
                'description' => 'Urban Essential Hoodie dibuat dari bahan cotton blend yang lembut dan tahan lama.',
                'price' => 459000,
                'stock' => 32,
                'is_featured' => true,
            ],
        ];

        foreach ($products as $productData) {
            $category = Category::where('slug', $productData['category_slug'])->firstOrFail();

            Product::updateOrCreate(
                ['sku' => $productData['sku']],
                [
                    'category_id' => $category->id,
                    'name' => $productData['name'],
                    'slug' => $productData['slug'],
                    'short_description' => $productData['short_description'],
                    'description' => $productData['description'],
                    'price' => $productData['price'],
                    'stock' => $productData['stock'],
                    'low_stock_threshold' => 5,
                    'weight' => 500,
                    'track_stock' => true,
                    'is_featured' => $productData['is_featured'],
                    'status' => Product::STATUS_ACTIVE,
                    'published_at' => now(),
                ]
            );
        }
    }
}
