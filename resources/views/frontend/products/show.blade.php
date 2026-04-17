@extends('layouts.storefront')

@section('title', $product['name'])
@section('meta_description', $product['excerpt'])

@section('content')
    <section class="grid gap-8 lg:grid-cols-[minmax(0,1.05fr)_minmax(380px,0.95fr)] lg:items-start">
        <div class="space-y-6">
            <div class="rounded-[2.2rem] border border-slate-200 p-6 shadow-sm" style="{{ $product['cover_style'] }}">
                <div class="aspect-[5/4] rounded-[1.8rem] border border-white/30 bg-white/10 backdrop-blur-sm"></div>
            </div>

            <div class="grid gap-4 sm:grid-cols-3">
                @foreach ($product['gallery'] as $gallery)
                    <div class="aspect-[4/3] rounded-[1.6rem] border border-slate-200 shadow-sm" style="{{ $gallery }}"></div>
                @endforeach
            </div>
        </div>

        <div class="rounded-[2.2rem] border border-slate-200 bg-white p-8 shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">{{ $product['category'] }}</p>
                    <h1 class="mt-3 text-4xl font-black tracking-tight text-slate-950">{{ $product['name'] }}</h1>
                </div>
                <span class="rounded-full bg-brand-50 px-4 py-2 text-sm font-semibold text-brand-700">{{ $product['tag'] }}</span>
            </div>

            <div class="mt-6 flex items-center gap-4">
                <p class="text-3xl font-black tracking-tight text-slate-950">{{ $product['price_label'] }}</p>
                <span class="rounded-full bg-slate-50 px-3 py-1 text-sm font-semibold text-slate-700">{{ $product['rating'] }} / 5</span>
                <span class="text-sm text-slate-500">{{ $product['reviews'] }} reviews</span>
            </div>

            <p class="mt-6 text-base leading-8 text-slate-600">{{ $product['description'] }}</p>

            <div class="mt-8 grid gap-4 sm:grid-cols-2">
                @foreach ($product['features'] as $feature)
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 px-4 py-4 text-sm font-medium text-slate-700">
                        {{ $feature }}
                    </div>
                @endforeach
            </div>

            <div class="mt-8 flex flex-wrap items-center gap-3">
                <a href="{{ route('cart.index') }}" class="rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                    Add to Cart
                </a>
                <a href="{{ route('checkout.index') }}" class="rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:text-slate-900">
                    Buy Now
                </a>
                <span class="rounded-full bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700">{{ $product['stock_label'] }}</span>
            </div>
        </div>
    </section>

    <section class="mt-16">
        <x-frontend.section-heading
            eyebrow="Related Products"
            title="Consistent recommendations section"
            description="Komponen product card yang sama dipakai ulang untuk bagian related products."
        />

        <div class="mt-8 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($relatedProducts as $related)
                <x-frontend.product-card :product="$related" />
            @endforeach
        </div>
    </section>
@endsection
