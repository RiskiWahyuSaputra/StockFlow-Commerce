<?php

namespace App\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class StorefrontData
{
    public static function categories(): array
    {
        return [
            ['name' => 'Semua', 'slug' => 'all', 'count' => 12],
            ['name' => 'Ponsel Pintar', 'slug' => 'smartphones', 'count' => 4],
            ['name' => 'Workstation', 'slug' => 'workstation', 'count' => 3],
            ['name' => 'Audio', 'slug' => 'audio', 'count' => 2],
            ['name' => 'Rumah & Hunian', 'slug' => 'home-living', 'count' => 3],
        ];
    }

    public static function products(): array
    {
        return [
            [
                'slug' => 'aurora-x1-smartphone',
                'name' => 'Aurora X1 Smartphone',
                'category' => 'Ponsel Pintar',
                'tag' => 'Rilis Baru',
                'price' => 3999000,
                'price_label' => 'Rp3.999.000',
                'rating' => '4.9',
                'reviews' => 128,
                'stock' => 24,
                'stock_label' => '24 unit tersedia',
                'excerpt' => 'Panel OLED, kamera 50MP, dan baterai seharian untuk kebutuhan mobile yang serba cepat.',
                'description' => 'Aurora X1 dirancang untuk user yang ingin performa kencang, kamera tajam, dan desain premium dalam satu paket yang bersih dan modern.',
                'cover_style' => 'background: linear-gradient(135deg, #0f766e 0%, #2dd4bf 48%, #ecfeff 100%);',
                'gallery' => [
                    'background: linear-gradient(135deg, #0f766e 0%, #115e59 100%);',
                    'background: linear-gradient(135deg, #14b8a6 0%, #99f6e4 100%);',
                    'background: linear-gradient(135deg, #0f172a 0%, #475569 100%);',
                ],
                'features' => ['Layar OLED 6,7"', 'Kamera Utama 50MP', 'Baterai 5000mAh', 'Siap 5G'],
            ],
            [
                'slug' => 'nimbus-pro-14',
                'name' => 'Nimbus Pro 14',
                'category' => 'Workstation',
                'tag' => 'Pilihan Kreator',
                'price' => 12499000,
                'price_label' => 'Rp12.499.000',
                'rating' => '4.8',
                'reviews' => 73,
                'stock' => 12,
                'stock_label' => '12 unit tersedia',
                'excerpt' => 'Laptop tipis berperforma tinggi untuk kreator, pelajar, dan pekerjaan produktif sehari-hari.',
                'description' => 'Nimbus Pro 14 menghadirkan layar 14 inci yang tajam, chassis ringkas, dan performa stabil untuk produktivitas seharian.',
                'cover_style' => 'background: linear-gradient(135deg, #111827 0%, #334155 45%, #e2e8f0 100%);',
                'gallery' => [
                    'background: linear-gradient(135deg, #020617 0%, #1e293b 100%);',
                    'background: linear-gradient(135deg, #475569 0%, #cbd5e1 100%);',
                    'background: linear-gradient(135deg, #0f172a 0%, #94a3b8 100%);',
                ],
                'features' => ['Layar IPS 14"', 'SSD 1TB', 'Memori 16GB', 'Isi Daya Cepat'],
            ],
            [
                'slug' => 'pulse-wireless-earbuds',
                'name' => 'Pulse Wireless Earbuds',
                'category' => 'Audio',
                'tag' => 'Latensi Rendah',
                'price' => 749000,
                'price_label' => 'Rp749.000',
                'rating' => '4.7',
                'reviews' => 91,
                'stock' => 55,
                'stock_label' => '55 unit tersedia',
                'excerpt' => 'Teman audio harian yang ringkas dengan suara panggilan jernih dan playback latensi rendah yang stabil.',
                'description' => 'Pulse Wireless Earbuds cocok untuk meeting, commuting, dan sesi fokus dengan charging case yang tetap ringan di saku.',
                'cover_style' => 'background: linear-gradient(135deg, #f97316 0%, #fdba74 50%, #fff7ed 100%);',
                'gallery' => [
                    'background: linear-gradient(135deg, #c2410c 0%, #fb923c 100%);',
                    'background: linear-gradient(135deg, #ea580c 0%, #fed7aa 100%);',
                    'background: linear-gradient(135deg, #7c2d12 0%, #fdba74 100%);',
                ],
                'features' => ['Reduksi Bising Aktif', 'Baterai 32 Jam', 'Bluetooth 5.3', 'Mikrofon Ganda'],
            ],
            [
                'slug' => 'chefmate-multi-pan',
                'name' => 'ChefMate Multi Pan',
                'category' => 'Rumah & Hunian',
                'tag' => 'Andalan Dapur',
                'price' => 329000,
                'price_label' => 'Rp329.000',
                'rating' => '4.6',
                'reviews' => 46,
                'stock' => 40,
                'stock_label' => '40 unit tersedia',
                'excerpt' => 'Wajan multifungsi anti lengket yang praktis untuk rutinitas dapur sehari-hari.',
                'description' => 'ChefMate Multi Pan punya distribusi panas merata, lapisan anti lengket, dan desain ergonomis untuk dapur modern.',
                'cover_style' => 'background: linear-gradient(135deg, #16a34a 0%, #86efac 50%, #f0fdf4 100%);',
                'gallery' => [
                    'background: linear-gradient(135deg, #166534 0%, #4ade80 100%);',
                    'background: linear-gradient(135deg, #22c55e 0%, #dcfce7 100%);',
                    'background: linear-gradient(135deg, #14532d 0%, #bbf7d0 100%);',
                ],
                'features' => ['Lapisan Anti Lengket', 'Panas Merata', 'Pegangan Ergonomis', 'Mudah Dibersihkan'],
            ],
            [
                'slug' => 'luma-desk-lamp',
                'name' => 'Luma Desk Lamp',
                'category' => 'Rumah & Hunian',
                'tag' => 'Setup Meja',
                'price' => 289000,
                'price_label' => 'Rp289.000',
                'rating' => '4.8',
                'reviews' => 38,
                'stock' => 18,
                'stock_label' => '18 unit tersedia',
                'excerpt' => 'Lampu meja minimalis dengan pilihan kehangatan cahaya untuk sesi kerja yang lebih fokus.',
                'description' => 'Luma Desk Lamp menghadirkan desain hemat ruang dengan tiga mode temperatur warna dan tingkat brightness yang mudah diatur.',
                'cover_style' => 'background: linear-gradient(135deg, #6366f1 0%, #c7d2fe 52%, #eef2ff 100%);',
                'gallery' => [
                    'background: linear-gradient(135deg, #4338ca 0%, #818cf8 100%);',
                    'background: linear-gradient(135deg, #6366f1 0%, #e0e7ff 100%);',
                    'background: linear-gradient(135deg, #312e81 0%, #c7d2fe 100%);',
                ],
                'features' => ['3 Mode Cahaya', 'Desain Ringkas', 'Kontrol Sentuh', 'Daya USB'],
            ],
            [
                'slug' => 'urban-essential-hoodie',
                'name' => 'Urban Essential Hoodie',
                'category' => 'Gaya Hidup',
                'tag' => 'Terlaris',
                'price' => 459000,
                'price_label' => 'Rp459.000',
                'rating' => '4.9',
                'reviews' => 110,
                'stock' => 32,
                'stock_label' => '32 unit tersedia',
                'excerpt' => 'Hoodie relaxed fit berbahan campuran katun lembut untuk pemakaian harian.',
                'description' => 'Urban Essential Hoodie dirancang untuk kenyamanan harian dengan potongan relaxed, tekstur halus, dan warna yang mudah dipadukan.',
                'cover_style' => 'background: linear-gradient(135deg, #0f172a 0%, #f8fafc 100%);',
                'gallery' => [
                    'background: linear-gradient(135deg, #111827 0%, #64748b 100%);',
                    'background: linear-gradient(135deg, #1e293b 0%, #e2e8f0 100%);',
                    'background: linear-gradient(135deg, #020617 0%, #94a3b8 100%);',
                ],
                'features' => ['Potongan Relaxed', 'Campuran Katun', 'Bagian Dalam Lembut', 'Nyaman untuk Harian'],
            ],
        ];
    }

    public static function featuredProducts(): array
    {
        return array_slice(self::products(), 0, 4);
    }

    public static function product(string $slug): ?array
    {
        return collect(self::products())->firstWhere('slug', $slug);
    }

    public static function cart(): array
    {
        $items = [
            Arr::add(self::product('aurora-x1-smartphone'), 'quantity', 1),
            Arr::add(self::product('pulse-wireless-earbuds'), 'quantity', 2),
        ];

        $subtotal = collect($items)->sum(fn (array $item): int => $item['price'] * $item['quantity']);
        $shipping = 24000;
        $tax = 12000;

        return [
            'items' => array_map(function (array $item): array {
                $item['line_total'] = $item['price'] * $item['quantity'];
                $item['line_total_label'] = self::price($item['line_total']);

                return $item;
            }, $items),
            'subtotal' => $subtotal,
            'subtotal_label' => self::price($subtotal),
            'shipping' => $shipping,
            'shipping_label' => self::price($shipping),
            'tax' => $tax,
            'tax_label' => self::price($tax),
            'total' => $subtotal + $shipping + $tax,
            'total_label' => self::price($subtotal + $shipping + $tax),
        ];
    }

    public static function checkout(): array
    {
        $cart = self::cart();

        return [
            'summary' => $cart,
            'shipping_methods' => [
                ['name' => 'Kurir Same Day', 'eta' => 'Hari ini, 19:00', 'price' => 'Rp45.000', 'active' => false],
                ['name' => 'Pengiriman Reguler', 'eta' => 'Besok, 14:00', 'price' => 'Rp24.000', 'active' => true],
                ['name' => 'Titik Ambil', 'eta' => 'Besok, 11:00', 'price' => 'Gratis', 'active' => false],
            ],
            'payment_methods' => [
                ['name' => 'Midtrans Snap', 'detail' => 'Kartu, transfer bank, dan dompet digital', 'active' => true],
                ['name' => 'Virtual Account', 'detail' => 'BCA, BNI, Mandiri, Permata', 'active' => false],
                ['name' => 'QRIS', 'detail' => 'Checkout cepat dari mobile banking', 'active' => false],
            ],
        ];
    }

    public static function adminDashboard(): array
    {
        return [
            'stats' => [
                ['label' => 'Pratinjau Pendapatan', 'value' => 'Rp84,2jt', 'delta' => '+14,2%'],
                ['label' => 'Pesanan Aktif', 'value' => '128', 'delta' => '+9 hari ini'],
                ['label' => 'Item Katalog', 'value' => '64', 'delta' => '12 unggulan'],
                ['label' => 'Peringatan Stok Menipis', 'value' => '7', 'delta' => 'Perlu tindakan'],
            ],
            'activities' => [
                ['title' => 'Stok Aurora X1 diperbarui', 'meta' => 'Inventaris disesuaikan 15 menit lalu'],
                ['title' => '3 pesanan baru menunggu pembayaran', 'meta' => 'Antrian callback Midtrans berjalan normal'],
                ['title' => 'Hero beranda diperbarui', 'meta' => 'Koleksi unggulan diperbarui untuk minggu ini'],
            ],
            'low_stock' => [
                ['name' => 'Luma Desk Lamp', 'sku' => 'HOM-LUMA-LAMP', 'stock' => 18],
                ['name' => 'Nimbus Pro 14', 'sku' => 'LTP-NIMBUS-PRO14', 'stock' => 12],
                ['name' => 'Aurora X1 Smartphone', 'sku' => 'PHN-AURORA-X1', 'stock' => 24],
            ],
        ];
    }

    public static function price(int $amount): string
    {
        return 'Rp'.number_format($amount, 0, ',', '.');
    }
}
