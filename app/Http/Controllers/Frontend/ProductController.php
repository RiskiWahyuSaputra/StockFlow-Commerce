<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Support\StorefrontData;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        return view('frontend.products.index', [
            'categories' => StorefrontData::categories(),
            'products' => StorefrontData::products(),
            'featuredProducts' => StorefrontData::featuredProducts(),
        ]);
    }

    public function show(string $slug): View
    {
        $product = StorefrontData::product($slug);

        abort_unless($product, 404);

        return view('frontend.products.show', [
            'product' => $product,
            'relatedProducts' => collect(StorefrontData::products())
                ->reject(fn (array $item): bool => $item['slug'] === $slug)
                ->take(3)
                ->values()
                ->all(),
        ]);
    }
}
