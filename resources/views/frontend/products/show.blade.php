@extends('layouts.storefront')

@section('title', $product->name)
@section('meta_description', $product->summary)

@section('content')
    @php
        $specs = [
            ['label' => 'Category', 'value' => $product->primary_category_name],
            ['label' => 'SKU', 'value' => $product->sku],
            ['label' => 'Weight', 'value' => $product->weight ? $product->weight.' gr' : 'N/A'],
            ['label' => 'Updated', 'value' => optional($product->updated_at)->format('d M Y') ?? 'N/A'],
        ];
    @endphp

    <div class="mb-6 flex flex-wrap items-center gap-3 text-sm text-slate-500">
        <a href="{{ route('home') }}" class="transition hover:text-slate-900">Home</a>
        <span>/</span>
        <a href="{{ route('products.index') }}" class="transition hover:text-slate-900">Products</a>
        <span>/</span>
        <span class="font-medium text-slate-900">{{ $product->name }}</span>
    </div>

    <section class="grid gap-8 lg:grid-cols-[minmax(0,1.05fr)_minmax(380px,0.95fr)] lg:items-start">
        <div class="space-y-6">
            <x-frontend.product-visual :product="$product" variant="hero" :seed="0" />

            <div class="grid gap-4 sm:grid-cols-3">
                @foreach (range(1, 3) as $seed)
                    <x-frontend.product-visual :product="$product" variant="thumb" :seed="$seed" />
                @endforeach
            </div>
        </div>

        <div class="rounded-[2.2rem] border border-slate-200 bg-white p-8 shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">{{ $product->primary_category_name }}</p>
                    <h1 class="mt-3 text-4xl font-black tracking-tight text-slate-950">{{ $product->name }}</h1>
                </div>
                <span @class([
                    'rounded-full px-4 py-2 text-sm font-semibold',
                    'bg-emerald-50 text-emerald-700' => $product->is_in_stock,
                    'bg-rose-50 text-rose-700' => ! $product->is_in_stock,
                ])>
                    {{ $product->stock_badge_label }}
                </span>
            </div>

            <div class="mt-6 flex flex-wrap items-center gap-4">
                <p class="text-3xl font-black tracking-tight text-slate-950">{{ $product->price_label }}</p>
                <span class="rounded-full bg-slate-50 px-4 py-2 text-sm font-semibold text-slate-700">
                    {{ $product->stock_label }}
                </span>
            </div>

            @if ($product->short_description)
                <p class="mt-6 text-lg leading-8 text-slate-700">{{ $product->short_description }}</p>
            @endif

            <p class="mt-6 text-base leading-8 text-slate-600">
                {{ $product->description }}
            </p>

            <div class="mt-8 grid gap-4 sm:grid-cols-2">
                @foreach ($specs as $spec)
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 px-4 py-4">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400">{{ $spec['label'] }}</p>
                        <p class="mt-2 text-sm font-medium text-slate-800">{{ $spec['value'] }}</p>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 flex flex-wrap items-center gap-3">
                @if ($product->is_in_stock)
                    <form method="POST" action="{{ route('cart.items.store') }}" class="flex flex-wrap items-center gap-3">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input
                            type="number"
                            name="quantity"
                            value="1"
                            min="1"
                            max="{{ $product->stock }}"
                            class="w-24 rounded-full border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 focus:border-slate-400 focus:outline-none focus:ring-0"
                        >
                        <button type="submit" class="rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                            Add to Cart
                        </button>
                    </form>
                    <a href="{{ route('checkout.index') }}" class="rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:text-slate-900">
                        Buy Now
                    </a>
                @else
                    <button type="button" disabled class="cursor-not-allowed rounded-full bg-slate-200 px-5 py-3 text-sm font-semibold text-slate-500">
                        Stok Tidak Tersedia
                    </button>
                @endif
            </div>
        </div>
    </section>

    <section class="mt-16">
        <x-frontend.section-heading
            eyebrow="Related Products"
            title="Produk lain yang masih satu nuansa katalog"
            description="Related products ini memakai query terpisah yang tetap efisien dan memakai komponen card yang sama."
        />

        <div class="mt-8 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($relatedProducts as $related)
                <x-frontend.product-card :product="$related" />
            @endforeach
        </div>
    </section>
@endsection
