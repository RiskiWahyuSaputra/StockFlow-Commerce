@props([
    'product',
])

@php
    $isModel = $product instanceof \App\Models\Product;
    $slug = $isModel ? $product->slug : $product['slug'];
    $name = $isModel ? $product->name : $product['name'];
    $categoryName = $isModel ? $product->primary_category_name : ($product['category'] ?? 'Katalog');
    $priceLabel = $isModel ? $product->price_label : $product['price_label'];
    $summary = $isModel ? $product->summary : ($product['excerpt'] ?? null);
    $stock = $isModel ? (int) $product->stock : (int) ($product['stock'] ?? 0);
    $stockLabel = $isModel ? $product->stock_label : ($product['stock_label'] ?? ($stock > 0 ? $stock.' tersedia' : 'Stok habis'));
    $eyebrow = $isModel ? ($product->is_featured ? 'Unggulan' : 'Katalog') : ($product['tag'] ?? 'Katalog');
    $isOutOfStock = $stock < 1;
@endphp

<article @class([
    'group overflow-hidden rounded-[2.5rem] border bg-white/[0.03] shadow-sm transition duration-300',
    'border-white/10 hover:border-white/20 hover:-translate-y-1 hover:shadow-2xl hover:shadow-black' => ! $isOutOfStock,
    'border-rose-500/10 opacity-90' => $isOutOfStock,
])>
    <a href="{{ route('products.show', $slug) }}" class="block">
        <x-frontend.product-visual :product="$product" variant="card" />

        <div class="space-y-4 p-6 sm:p-8">
            <div class="flex items-start justify-between gap-4">
                <div class="min-w-0">
                    <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-amber-400">{{ $eyebrow }}</p>
                    <h3 class="mt-3 text-2xl font-black tracking-tight text-white group-hover:text-amber-200 transition-colors">{{ $name }}</h3>
                    <p class="mt-2 text-sm font-semibold text-slate-500">{{ $categoryName }}</p>
                </div>

                <span @class([
                    'shrink-0 rounded-full px-3 py-1 text-[10px] font-bold uppercase tracking-[0.1em]',
                    'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' => ! $isOutOfStock,
                    'bg-rose-500/10 text-rose-400 border border-rose-500/20' => $isOutOfStock,
                ])>
                    {{ $isOutOfStock ? 'Stok Habis' : 'Ready' }}
                </span>
            </div>

            <p class="text-sm leading-7 text-slate-400">
                {{ $summary }}
            </p>

            <div class="flex items-center justify-between border-t border-white/10 pt-5">
                <div>
                    <p class="text-xl font-black tracking-tight text-white">{{ $priceLabel }}</p>
                    <p class="mt-1 text-xs font-bold text-slate-500 uppercase tracking-wide">{{ $stockLabel }}</p>
                </div>

                <span class="text-xs font-bold text-amber-400 uppercase tracking-[0.15em] transition group-hover:text-amber-300">
                    Detail →
                </span>
            </div>
        </div>
    </a>

    <div class="border-t border-white/10 px-6 pb-6 pt-5 sm:px-8 sm:pb-8">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <a href="{{ route('products.show', $slug) }}" class="inline-flex rounded-full border border-white/15 bg-white/5 px-5 py-2.5 text-xs font-bold text-white transition hover:bg-white/10">
                Lihat Detail
            </a>

            @if (! $isModel)
                <span class="inline-flex rounded-full bg-white/10 px-5 py-2.5 text-xs font-bold text-slate-500">
                    Pratinjau
                </span>
            @elseif ($isOutOfStock)
                <button type="button" disabled class="cursor-not-allowed rounded-full bg-white/5 px-5 py-2.5 text-xs font-bold text-slate-600">
                    Habis
                </button>
            @else
                <form method="POST" action="{{ route('cart.items.store') }}" class="flex items-center gap-2">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $isModel ? $product->id : '' }}">
                    <x-frontend.quantity-picker
                        name="quantity"
                        :value="1"
                        :min="1"
                        :max="$stock"
                        size="sm"
                        :id="'product-card-qty-'.$product->id"
                        class="dark-theme"
                    />
                    <button type="submit" class="rounded-full bg-white px-5 py-2.5 text-xs font-bold text-black transition hover:bg-slate-200">
                        Tambah
                    </button>
                </form>
            @endif
        </div>
    </div>
</article>
