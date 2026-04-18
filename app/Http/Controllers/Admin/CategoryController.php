<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpsertCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $categories = Category::query()
            ->with(['parent:id,name', 'products:id,category_id'])
            ->withCount('products')
            ->when($search !== '', function ($query) use ($search): void {
                $query->where('name', 'like', '%'.$search.'%');
            })
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.categories.index', [
            'categories' => $categories,
            'filters' => [
                'search' => $search,
            ],
        ]);
    }

    public function create(): View
    {
        return view('admin.categories.create', [
            'category' => new Category,
            'parentCategories' => Category::query()->orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function store(UpsertCategoryRequest $request): RedirectResponse
    {
        $category = Category::create($this->payload($request));

        return redirect()
            ->route('admin.categories.edit', $category)
            ->with('status', 'Kategori berhasil dibuat.');
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', [
            'category' => $category,
            'parentCategories' => Category::query()
                ->whereKeyNot($category->id)
                ->orderBy('name')
                ->get(['id', 'name']),
        ]);
    }

    public function update(UpsertCategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update($this->payload($request));

        return redirect()
            ->route('admin.categories.edit', $category)
            ->with('status', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('status', 'Kategori berhasil dihapus.');
    }

    protected function payload(UpsertCategoryRequest $request): array
    {
        $payload = $request->validated();
        $payload['slug'] = filled($payload['slug'] ?? null)
            ? Str::slug((string) $payload['slug'])
            : null;

        return $payload;
    }
}
