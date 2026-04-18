<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpsertProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\AdminProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        protected AdminProductService $adminProductService,
    ) {}

    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $status = trim((string) $request->query('status', ''));

        $products = Product::query()
            ->with(['category:id,name', 'primaryImage:id,product_id,path'])
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($builder) use ($search): void {
                    $builder
                        ->where('name', 'like', '%'.$search.'%')
                        ->orWhere('sku', 'like', '%'.$search.'%');
                });
            })
            ->when($status !== '', fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.products.index', [
            'products' => $products,
            'filters' => [
                'search' => $search,
                'status' => $status,
            ],
            'statusOptions' => [
                Product::STATUS_DRAFT => 'Draft',
                Product::STATUS_ACTIVE => 'Active',
                Product::STATUS_INACTIVE => 'Inactive',
                Product::STATUS_ARCHIVED => 'Archived',
            ],
        ]);
    }

    public function create(): View
    {
        return view('admin.products.create', [
            'product' => new Product([
                'track_stock' => true,
                'is_featured' => false,
                'low_stock_threshold' => 5,
                'status' => Product::STATUS_DRAFT,
            ]),
            'categories' => Category::query()->orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function store(UpsertProductRequest $request): RedirectResponse
    {
        $product = $this->adminProductService->create(
            $this->payload($request),
            $request->user(),
        );

        return redirect()
            ->route('admin.products.edit', $product)
            ->with('status', 'Produk berhasil dibuat.');
    }

    public function edit(Product $product): View
    {
        return view('admin.products.edit', [
            'product' => $product->load('images'),
            'categories' => Category::query()->orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function update(UpsertProductRequest $request, Product $product): RedirectResponse
    {
        $product = $this->adminProductService->update(
            $product,
            $this->payload($request),
            $request->user(),
        );

        return redirect()
            ->route('admin.products.edit', $product)
            ->with('status', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->adminProductService->delete($product);

        return redirect()
            ->route('admin.products.index')
            ->with('status', 'Produk berhasil dihapus.');
    }

    protected function payload(UpsertProductRequest $request): array
    {
        $payload = $request->validated();
        $payload['slug'] = filled($payload['slug'] ?? null)
            ? Str::slug((string) $payload['slug'])
            : null;
        $payload['track_stock'] = $request->boolean('track_stock');
        $payload['is_featured'] = $request->boolean('is_featured');

        return $payload;
    }
}
