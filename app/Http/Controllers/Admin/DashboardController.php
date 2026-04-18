<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $totalProducts = Product::query()->count();
        $totalOrders = Order::query()->count();
        $totalRevenue = Order::query()
            ->where('payment_status', Order::PAYMENT_PAID)
            ->sum('grand_total');

        $lowStockProducts = Product::query()
            ->select(['id', 'name', 'sku', 'stock', 'low_stock_threshold', 'status'])
            ->whereColumn('stock', '<=', 'low_stock_threshold')
            ->orderBy('stock')
            ->limit(5)
            ->get();

        $recentOrders = Order::query()
            ->select(['id', 'order_number', 'customer_name', 'grand_total', 'order_status', 'payment_status', 'placed_at'])
            ->latest('placed_at')
            ->limit(5)
            ->get();

        return view('admin.dashboard', [
            'stats' => [
                [
                    'label' => 'Total Products',
                    'value' => number_format($totalProducts),
                    'delta' => 'Katalog aktif dan draft tersinkron',
                ],
                [
                    'label' => 'Total Orders',
                    'value' => number_format($totalOrders),
                    'delta' => 'Semua order customer yang tersimpan',
                ],
                [
                    'label' => 'Total Revenue',
                    'value' => 'Rp'.number_format((int) round((float) $totalRevenue), 0, ',', '.'),
                    'delta' => 'Akumulasi order dengan payment paid',
                ],
                [
                    'label' => 'Low Stock',
                    'value' => number_format($lowStockProducts->count()),
                    'delta' => 'Produk yang sudah menyentuh threshold',
                ],
            ],
            'lowStockProducts' => $lowStockProducts,
            'recentOrders' => $recentOrders,
        ]);
    }
}
