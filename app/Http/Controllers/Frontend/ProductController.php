<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ProductCatalogRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(ProductCatalogRequest $request): View
    {
        $filters = [
            'search' => trim((string) $request->validated('search', '')),
            'category' => (string) $request->validated('category', ''),
            'sort' => (string) $request->validated('sort', 'latest'),
        ];

        $categories = Category::query()
            ->select(['id', 'name', 'slug'])
            ->where('status', Category::STATUS_ACTIVE)
            ->whereHas('products', fn ($query) => $query->active())
            ->withCount([
                'products as active_products_count' => fn ($query) => $query->active(),
            ])
            ->orderBy('name')
            ->get();

        $products = Product::query()
            ->select([
                'id',
                'category_id',
                'name',
                'slug',
                'sku',
                'short_description',
                'price',
                'stock',
                'is_featured',
                'status',
                'published_at',
            ])
            ->with([
                'category:id,name,slug',
                'primaryImage:id,product_id,path,alt_text,is_primary',
            ])
            ->active()
            ->searchByName($filters['search'])
            ->inCategorySlug($filters['category'])
            ->applyCatalogSort($filters['sort'])
            ->paginate(9)
            ->withQueryString();

        return view('frontend.products.index', [
            'products' => $products,
            'categories' => $categories,
            'selectedCategory' => $categories->firstWhere('slug', $filters['category']),
            'filters' => $filters,
            'sortOptions' => [
                'latest' => 'Produk Terbaru',
                'lowest_price' => 'Harga Termurah',
                'highest_price' => 'Harga Termahal',
            ],
        ]);
    }

    public function show(string $slug): View
    {
        $product = Product::query()
            ->select([
                'id',
                'category_id',
                'name',
                'slug',
                'sku',
                'short_description',
                'description',
                'price',
                'stock',
                'weight',
                'status',
                'published_at',
                'updated_at',
            ])
            ->with([
                'category:id,name,slug',
                'images:id,product_id,path,alt_text,sort_order,is_primary',
            ])
            ->active()
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedProducts = Product::query()
            ->select([
                'id',
                'category_id',
                'name',
                'slug',
                'short_description',
                'price',
                'stock',
                'is_featured',
                'status',
                'published_at',
            ])
            ->with([
                'category:id,name,slug',
                'primaryImage:id,product_id,path,alt_text,is_primary',
            ])
            ->active()
            ->whereKeyNot($product->id)
            ->when($product->category_id, fn ($query) => $query->where('category_id', $product->category_id))
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        if ($relatedProducts->count() < 3) {
            $relatedProducts = $relatedProducts->concat(
                $this->fallbackRelatedProducts($product, $relatedProducts)
            );
        }

        return view('frontend.products.show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }

    protected function fallbackRelatedProducts(Product $product, Collection $relatedProducts): Collection
    {
        return Product::query()
            ->select([
                'id',
                'category_id',
                'name',
                'slug',
                'short_description',
                'price',
                'stock',
                'is_featured',
                'status',
                'published_at',
            ])
            ->with([
                'category:id,name,slug',
                'primaryImage:id,product_id,path,alt_text,is_primary',
            ])
            ->active()
            ->whereKeyNot($product->id)
            ->whereNotIn('id', $relatedProducts->pluck('id'))
            ->orderByDesc('published_at')
            ->limit(3 - $relatedProducts->count())
            ->get();
    }
}
