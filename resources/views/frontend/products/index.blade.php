@extends('layouts.storefront')

@section('title', 'Product Listing')
@section('meta_description', 'Daftar produk modern dan clean untuk E-Commerce Platform.')

@section('content')
    @php
        $hasActiveFilters = filled($filters['search']) || filled($filters['category']) || $filters['sort'] !== 'latest';
    @endphp

    <section class="rounded-[2.2rem] border border-slate-200 bg-white p-8 shadow-sm sm:p-10">
        <x-frontend.section-heading
            eyebrow="Product Catalog"
            title="A searchable catalog built to feel clean, focused, and production-ready."
            description="Listing ini sudah memakai search, filter kategori, sort harga, pagination, dan eager loading agar siap dipakai untuk katalog produk yang sebenarnya."
        />

        <div class="mt-8 grid gap-6 lg:grid-cols-[260px_minmax(0,1fr)]">
            <aside class="space-y-6 rounded-[2rem] border border-slate-200 bg-slate-50 p-6">
                <form method="GET" action="{{ route('products.index') }}" class="space-y-5">
                    <div>
                        <label for="search" class="text-sm font-semibold text-slate-900">Search Product</label>
                        <input
                            id="search"
                            name="search"
                            type="text"
                            value="{{ $filters['search'] }}"
                            placeholder="Cari nama produk..."
                            class="mt-3 block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 placeholder:text-slate-400 focus:border-slate-400 focus:outline-none focus:ring-0"
                        >
                    </div>

                    <div>
                        <label for="category" class="text-sm font-semibold text-slate-900">Category</label>
                        <select
                            id="category"
                            name="category"
                            class="mt-3 block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-slate-400 focus:outline-none focus:ring-0"
                        >
                            <option value="">Semua kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->slug }}" @selected($filters['category'] === $category->slug)>
                                    {{ $category->name }} ({{ $category->active_products_count }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="sort" class="text-sm font-semibold text-slate-900">Sort</label>
                        <select
                            id="sort"
                            name="sort"
                            class="mt-3 block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-slate-400 focus:outline-none focus:ring-0"
                        >
                            @foreach ($sortOptions as $value => $label)
                                <option value="{{ $value }}" @selected($filters['sort'] === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="inline-flex flex-1 items-center justify-center rounded-full bg-slate-900 px-4 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                            Apply
                        </button>

                        @if ($hasActiveFilters)
                            <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:text-slate-900">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>

                <div>
                    <p class="text-sm font-semibold text-slate-900">Quick Category</p>
                    <div class="mt-4 space-y-3">
                        @foreach ($categories as $category)
                            @php
                                $categoryQuery = array_merge(request()->except('page'), ['category' => $category->slug]);
                            @endphp

                            <a
                                href="{{ route('products.index', $categoryQuery) }}"
                                @class([
                                    'flex items-center justify-between rounded-2xl border bg-white px-4 py-3 text-sm font-medium transition',
                                    'border-slate-900 text-slate-900 shadow-sm' => $filters['category'] === $category->slug,
                                    'border-slate-200 text-slate-700 hover:border-slate-300 hover:text-slate-900' => $filters['category'] !== $category->slug,
                                ])
                            >
                                <span>{{ $category->name }}</span>
                                <span class="text-slate-400">{{ $category->active_products_count }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </aside>

            <div>
                <div class="flex flex-col gap-4 rounded-[2rem] border border-slate-200 bg-slate-950 p-6 text-white sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-400">Catalog Results</p>
                        <h2 class="mt-2 text-2xl font-black tracking-tight">
                            {{ $products->total() }} products found
                        </h2>
                        <p class="mt-2 text-sm text-slate-300">
                            @if ($products->count())
                                Menampilkan {{ $products->firstItem() }}-{{ $products->lastItem() }} dari total {{ $products->total() }} produk.
                            @else
                                Belum ada produk yang cocok dengan filter aktif.
                            @endif
                        </p>
                    </div>

                    @if ($hasActiveFilters)
                        <div class="flex flex-wrap gap-2">
                            @if (filled($filters['search']))
                                <span class="rounded-full bg-white/10 px-4 py-2 text-sm font-medium text-slate-200">
                                    Search: {{ $filters['search'] }}
                                </span>
                            @endif

                            @if ($selectedCategory)
                                <span class="rounded-full bg-white/10 px-4 py-2 text-sm font-medium text-slate-200">
                                    Category: {{ $selectedCategory->name }}
                                </span>
                            @endif

                            @if (($sortOptions[$filters['sort']] ?? null) && $filters['sort'] !== 'latest')
                                <span class="rounded-full bg-white/10 px-4 py-2 text-sm font-medium text-slate-200">
                                    Sort: {{ $sortOptions[$filters['sort']] }}
                                </span>
                            @endif
                        </div>
                    @endif
                </div>

                @if ($products->count())
                    <div class="mt-6 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                        @foreach ($products as $product)
                            <x-frontend.product-card :product="$product" />
                        @endforeach
                    </div>

                    <div class="mt-8">
                        {{ $products->onEachSide(1)->links() }}
                    </div>
                @else
                    <div class="mt-6 rounded-[2rem] border border-dashed border-slate-200 bg-slate-50 p-10 text-center">
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">No Products</p>
                        <h3 class="mt-4 text-2xl font-black tracking-tight text-slate-950">Tidak ada produk yang cocok.</h3>
                        <p class="mx-auto mt-4 max-w-xl text-sm leading-7 text-slate-600">
                            Coba ubah keyword pencarian, ganti kategori, atau reset filter untuk melihat semua katalog yang tersedia.
                        </p>
                        <a href="{{ route('products.index') }}" class="mt-6 inline-flex rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                            Reset Catalog
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
