<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Support\StorefrontData;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $products = StorefrontData::products();

        return view('frontend.home', [
            'stats' => [
                ['label' => 'Produk Kurasi', 'value' => '64+'],
                ['label' => 'Area Kirim Cepat', 'value' => '18 Kota'],
                ['label' => 'Pelanggan Puas', 'value' => '2,4k'],
            ],
            'featuredProducts' => StorefrontData::featuredProducts(),
            'categories' => StorefrontData::categories(),
            'spotlightProduct' => $products[1],
        ]);
    }
}
