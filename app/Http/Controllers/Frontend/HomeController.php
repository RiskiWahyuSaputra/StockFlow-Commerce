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
                ['label' => 'Curated Products', 'value' => '64+'],
                ['label' => 'Fast Delivery Areas', 'value' => '18 Cities'],
                ['label' => 'Happy Customers', 'value' => '2.4k'],
            ],
            'featuredProducts' => StorefrontData::featuredProducts(),
            'categories' => StorefrontData::categories(),
            'spotlightProduct' => $products[1],
        ]);
    }
}
