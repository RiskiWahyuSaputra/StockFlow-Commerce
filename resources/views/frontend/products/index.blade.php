@extends('layouts.storefront')

@section('title', 'Product Listing')
@section('meta_description', 'Daftar produk modern dan clean untuk E-Commerce Platform.')

@section('content')
    <section class="rounded-[2.2rem] border border-slate-200 bg-white p-8 shadow-sm sm:p-10">
        <x-frontend.section-heading
            eyebrow="Product Listing"
            title="A clean catalog page built for browsing, filtering, and scaling."
            description="Struktur ini sengaja dibuat fleksibel agar nanti mudah disambungkan ke search, filter kategori, sort, dan pagination real."
        />

        <div class="mt-8 grid gap-6 lg:grid-cols-[260px_minmax(0,1fr)]">
            <aside class="space-y-6 rounded-[2rem] border border-slate-200 bg-slate-50 p-6">
                <div>
                    <p class="text-sm font-semibold text-slate-900">Categories</p>
                    <div class="mt-4 space-y-3">
                        @foreach ($categories as $category)
                            <button type="button" class="flex w-full items-center justify-between rounded-2xl border border-slate-200 bg-white px-4 py-3 text-left text-sm font-medium text-slate-700 transition hover:border-slate-300 hover:text-slate-900">
                                <span>{{ $category['name'] }}</span>
                                <span class="text-slate-400">{{ $category['count'] }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <div>
                    <p class="text-sm font-semibold text-slate-900">Price Range</p>
                    <div class="mt-4 rounded-3xl border border-dashed border-slate-200 bg-white p-4 text-sm leading-7 text-slate-500">
                        Filter UI masih dummy untuk preview layout. Nanti tinggal diganti dengan query string atau live filtering.
                    </div>
                </div>
            </aside>

            <div>
                <div class="flex flex-col gap-4 rounded-[2rem] border border-slate-200 bg-slate-950 p-6 text-white sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-400">Curated Results</p>
                        <h2 class="mt-2 text-2xl font-black tracking-tight">12 portfolio-ready products</h2>
                    </div>
                    <div class="rounded-full bg-white/10 px-4 py-2 text-sm font-medium text-slate-200">
                        Sort: Featured First
                    </div>
                </div>

                <div class="mt-6 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($products as $product)
                        <x-frontend.product-card :product="$product" />
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="mt-16">
        <x-frontend.section-heading
            eyebrow="Featured Strip"
            title="Use the same product card in secondary sections without redesigning from zero."
            description="Section ini menunjukkan bagaimana komponen yang sama bisa dipakai ulang untuk highlight di bagian bawah listing."
        />

        <div class="mt-8 grid gap-6 md:grid-cols-2 xl:grid-cols-4">
            @foreach ($featuredProducts as $product)
                <x-frontend.product-card :product="$product" />
            @endforeach
        </div>
    </section>
@endsection
