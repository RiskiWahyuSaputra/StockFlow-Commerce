@props([
    'product',
])

@php
    $isModel = $product instanceof \App\Models\Product;
    $slug = $isModel ? $product->slug : $product['slug'];
    $name = $isModel ? $product->name : $product['name'];
    $categoryName = $isModel ? $product->primary_category_name : ($product['category'] ?? 'Catalog');
    $priceLabel = $isModel ? $product->price_label : $product['price_label'];
    $summary = $isModel ? $product->summary : ($product['excerpt'] ?? null);
    $stock = $isModel ? (int) $product->stock : (int) ($product['stock'] ?? 0);
    $stockLabel = $isModel ? $product->stock_label : ($product['stock_label'] ?? ($stock > 0 ? $stock.' tersedia' : 'Stok habis'));
    $eyebrow = $isModel ? ($product->is_featured ? 'Featured' : 'Catalog') : ($product['tag'] ?? 'Catalog');
    $isOutOfStock = $stock < 1;
@endphp

<article @class([
    'group overflow-hidden rounded-[2rem] border bg-white shadow-sm transition duration-300',
    'border-slate-200 hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-900/5' => ! $isOutOfStock,
    'border-rose-100 opacity-95' => $isOutOfStock,
])>
    <a href="{{ route('products.show', $slug) }}" class="block">
        <x-frontend.product-visual :product="$product" variant="card" />

        <div class="space-y-4 p-6">
            <div class="flex items-start justify-between gap-4">
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-400">{{ $eyebrow }}</p>
                    <h3 class="mt-2 text-2xl font-black tracking-tight text-slate-950">{{ $name }}</h3>
                    <p class="mt-2 text-sm font-medium text-slate-500">{{ $categoryName }}</p>
                </div>

                <span @class([
                    'shrink-0 rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em]',
                    'bg-emerald-50 text-emerald-700' => ! $isOutOfStock,
                    'bg-rose-50 text-rose-700' => $isOutOfStock,
                ])>
                    {{ $isOutOfStock ? 'Stok Habis' : 'Ready' }}
                </span>
            </div>

            <p class="text-sm leading-7 text-slate-600">
                {{ $summary }}
            </p>

            <div class="flex items-center justify-between border-t border-slate-100 pt-4">
                <div>
                    <p class="text-lg font-black tracking-tight text-slate-950">{{ $priceLabel }}</p>
                    <p class="mt-1 text-sm text-slate-500">{{ $stockLabel }}</p>
                </div>

                <span class="text-sm font-semibold text-brand-700 transition group-hover:text-brand-600">
                    View details
                </span>
            </div>
        </div>
    </a>
</article>
