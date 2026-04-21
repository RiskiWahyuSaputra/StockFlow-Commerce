@extends('layouts.storefront')

@section('title', 'Katalog Produk')
@section('meta_description', 'Daftar produk modern dan rapi untuk StockFlow Commerce.')

@push('styles')
<style>
/* ─── Animasi masuk (sama dengan home) ─── */
@keyframes sf-fade-up {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: none; }
}
.sf-anim { animation: sf-fade-up .5s cubic-bezier(.22,1,.36,1) both; }
.sf-d1 { animation-delay: .04s; }
.sf-d2 { animation-delay: .12s; }
.sf-d3 { animation-delay: .20s; }
.sf-d4 { animation-delay: .28s; }
.sf-d5 { animation-delay: .36s; }

/* ─── FAB (identik dengan home) ─── */
.sf-fab {
    position: fixed;
    bottom: 32px;
    right: 32px;
    z-index: 100;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #0f172a;
    color: #ffffff;
    text-decoration: none;
    border-radius: 9999px;
    padding: 13px 22px;
    font-size: 14px;
    font-weight: 600;
    box-shadow: 0 4px 20px rgba(15,23,42,.30), 0 1px 4px rgba(15,23,42,.15);
    transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.15s;
    animation: sf-fab-in .6s cubic-bezier(.34,1.56,.64,1) .6s both;
}
@keyframes sf-fab-in {
    from { transform: translateY(50px) scale(.8); opacity: 0; }
    to   { transform: none; opacity: 1; }
}
.sf-fab:hover {
    background: #1e293b;
    transform: translateY(-3px);
    box-shadow: 0 12px 36px rgba(15,23,42,.35), 0 2px 6px rgba(15,23,42,.18);
}
.sf-fab:active { transform: translateY(-1px); }
.sf-fab-badge {
    background: #10b981;
    color: #ffffff;
    border-radius: 9999px;
    padding: 2px 7px;
    font-size: 11px;
    font-weight: 700;
    min-width: 20px;
    height: 20px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    line-height: 1;
}

/* ─── Product card dengan gambar (konsisten dengan home) ─── */
.sf-product-card {
    background: #111111;
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 24px;
    overflow: hidden;
    transition: transform 0.22s ease, border-color 0.22s ease, box-shadow 0.22s ease;
}
.sf-product-card:hover {
    transform: translateY(-4px);
    border-color: rgba(245,158,11,0.24);
    box-shadow: 0 18px 46px rgba(0,0,0,0.45);
}
.sf-product-img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    display: block;
    background: #1a1a1a;
    transition: transform 0.35s ease;
}
.sf-product-card:hover .sf-product-img {
    transform: scale(1.05);
}
.sf-product-img-placeholder {
    width: 100%;
    height: 180px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #1a1a1a 0%, #111111 100%);
    font-size: 40px;
}
.sf-product-body { padding: 20px; }
.sf-product-name { font-size: 15px; font-weight: 800; color: #ffffff; line-height: 1.3; letter-spacing: -0.02em; }
.sf-product-sku  { font-size: 11px; color: #64748b; margin-top: 4px; font-weight: 600; letter-spacing: 0.05em; }
.sf-product-price{ font-size: 16px; font-weight: 800; color: #ffffff; margin-top: 8px; }
.sf-product-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 18px;
}
.sf-stock-green { background: rgba(16, 185, 129, 0.1); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2); border-radius: 9999px; padding: 4px 12px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; }
.sf-stock-amber { background: rgba(245, 158, 11, 0.1); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.2); border-radius: 9999px; padding: 4px 12px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; }
.sf-stock-red   { background: rgba(239, 68, 68, 0.1); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.2); border-radius: 9999px; padding: 4px 12px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; }
.sf-arrow-btn {
    width: 34px;
    height: 34px;
    background: #ffffff;
    border: none;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    text-decoration: none;
    transition: background 0.15s, transform 0.15s;
    flex-shrink: 0;
}
.sf-arrow-btn:hover { background: #e2e8f0; transform: scale(1.1); }

/* ─── Dark Theme Wrappers ─── */
.sf-dark-inner {
    max-width: 1280px;
    margin: 0 auto;
    padding: 100px 2rem 80px;
}

@media (max-width: 640px) {
    .sf-dark-inner { padding: 80px 1.25rem 60px; }
}
</style>
@endpush

@section('content')
    <div class="sf-dark-inner">
        @php
            $hasActiveFilters = filled($filters['search']) || filled($filters['category']) || $filters['sort'] !== 'latest';
        @endphp

        {{-- ── Header ── --}}
        <section class="rounded-[2.5rem] [0.03] p-8 shadow-sm sm:p-12 sf-anim sf-d1">
            <x-frontend.section-heading
                eyebrow="Katalog Produk"
                title="Katalog yang mudah dicari, difilter, dan siap dipakai untuk alur belanja nyata."
                description="Listing ini sudah memakai search, filter kategori, sort harga, pagination, dan eager loading agar siap dipakai untuk katalog produk yang sebenarnya."
            />
        </section>

        {{-- ── Konten Utama ── --}}
        <div class="mt-8 grid gap-8 lg:grid-cols-[280px_minmax(0,1fr)] sf-anim sf-d2">

            {{-- ── Sidebar Filter ── --}}
            <aside class="space-y-8 rounded-[2.5rem] border border-white/10 bg-white/[0.02] p-8">
                <form method="GET" action="{{ route('products.index') }}" class="space-y-6">
                    <div>
                        <label for="search" class="text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Cari Produk</label>
                        <input
                            id="search"
                            name="search"
                            type="text"
                            value="{{ $filters['search'] }}"
                            placeholder="Ketik nama produk..."
                            class="mt-4 block w-full rounded-2xl border border-white/10 bg-white/[0.05] px-5 py-4 text-sm text-white placeholder:text-slate-500 focus:border-amber-300/30 focus:bg-white/[0.08] focus:outline-none focus:ring-0 transition"
                        >
                    </div>

                    <div>
                        <label for="category" class="text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Kategori</label>
                        <select
                            id="category"
                            name="category"
                            class="mt-4 block w-full rounded-2xl border border-white/10 bg-white/[0.05] px-5 py-4 text-sm text-white focus:border-amber-300/30 focus:bg-white/[0.08] focus:outline-none focus:ring-0 transition appearance-none"
                        >
                            <option value="" class="bg-black">Semua kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->slug }}" @selected($filters['category'] === $category->slug) class="bg-black">
                                    {{ $category->name }} ({{ $category->active_products_count }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="sort" class="text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Urutkan</label>
                        <select
                            id="sort"
                            name="sort"
                            class="mt-4 block w-full rounded-2xl border border-white/10 bg-white/[0.05] px-5 py-4 text-sm text-white focus:border-amber-300/30 focus:bg-white/[0.08] focus:outline-none focus:ring-0 transition appearance-none"
                        >
                            @foreach ($sortOptions as $value => $label)
                                <option value="{{ $value }}" @selected($filters['sort'] === $value) class="bg-black">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col gap-3">
                        <button type="submit" class="inline-flex items-center justify-center rounded-full bg-white px-6 py-4 text-sm font-bold text-black transition hover:bg-slate-200">
                            Terapkan Filter
                        </button>

                        @if ($hasActiveFilters)
                            <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center rounded-full border border-white/15 bg-white/5 px-6 py-4 text-sm font-bold text-white transition hover:bg-white/10">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>

                <div>
                    <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Kategori Cepat</p>
                    <div class="mt-5 space-y-3">
                        @foreach ($categories as $category)
                            @php
                                $categoryQuery = array_merge(request()->except('page'), ['category' => $category->slug]);
                            @endphp
                            <a
                                href="{{ route('products.index', $categoryQuery) }}"
                                @class([
                                    'flex items-center justify-between rounded-2xl border px-5 py-4 text-sm font-semibold transition',
                                    'border-amber-300/30 bg-amber-300/10 text-amber-200' => $filters['category'] === $category->slug,
                                    'border-white/10 bg-white/[0.03] text-slate-400 hover:border-white/20 hover:text-white' => $filters['category'] !== $category->slug,
                                ])
                            >
                                <span>{{ $category->name }}</span>
                                <span @class([
                                    'text-xs',
                                    'text-amber-200/60' => $filters['category'] === $category->slug,
                                    'text-slate-600' => $filters['category'] !== $category->slug,
                                ])>{{ $category->active_products_count }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </aside>

            {{-- ── Area Produk ── --}}
            <div>

                {{-- Banner hasil --}}
                <div class="flex flex-col gap-6 rounded-[2.5rem] border border-white/10 bg-gradient-to-br from-white/[0.06] to-transparent p-8 text-white sm:flex-row sm:items-center sm:justify-between sf-anim sf-d3">
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-[0.28em] text-amber-400">Hasil Katalog</p>
                        <h2 class="mt-3 text-3xl font-black tracking-tight">
                            {{ $products->total() }} produk ditemukan
                        </h2>
                        <p class="mt-3 text-sm leading-7 text-slate-400">
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
                                <span class="rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs font-semibold text-slate-300">
                                    Pencarian: {{ $filters['search'] }}
                                </span>
                            @endif
                            @if ($selectedCategory)
                                <span class="rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs font-semibold text-slate-300">
                                    Kategori: {{ $selectedCategory->name }}
                                </span>
                            @endif
                            @if (($sortOptions[$filters['sort']] ?? null) && $filters['sort'] !== 'latest')
                                <span class="rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs font-semibold text-slate-300">
                                    Urutan: {{ $sortOptions[$filters['sort']] }}
                                </span>
                            @endif
                        </div>
                    @endif
                </div>

                @if ($products->count())
                    {{-- Grid produk dengan gambar --}}
                    <div class="mt-8 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                        @foreach ($products as $index => $product)
                            <div class="sf-product-card sf-anim" style="animation-delay: {{ 0.04 + ($index % 6) * 0.07 }}s">

                                {{-- Gambar produk --}}
                                @if ($product->primary_image_url)
                                    <img
                                        class="sf-product-img"
                                        src="{{ $product->primary_image_url }}"
                                        alt="{{ $product->name }}"
                                        loading="lazy"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                    >
                                    <div class="sf-product-img-placeholder" style="display:none;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#334155" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                                    </div>
                                @else
                                    <div class="sf-product-img-placeholder">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#334155" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                                    </div>
                                @endif

                                <div class="sf-product-body">
                                    <p class="sf-product-name">{{ $product->name }}</p>
                                    @if ($product->sku)
                                        <p class="sf-product-sku">SKU: {{ $product->sku }}</p>
                                    @endif
                                    <p class="sf-product-price">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </p>

                                    <div class="sf-product-footer">
                                        @if (isset($product->stock))
                                            @if ($product->stock > 10)
                                                <span class="sf-stock-green">Stok {{ $product->stock }}</span>
                                            @elseif ($product->stock > 0)
                                                <span class="sf-stock-amber">Stok {{ $product->stock }}</span>
                                            @else
                                                <span class="sf-stock-red">Habis</span>
                                            @endif
                                        @else
                                            <span></span>
                                        @endif

                                        <a href="{{ route('products.show', $product->slug) }}" class="sf-arrow-btn" aria-label="Lihat {{ $product->name }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-12">
                        {{ $products->onEachSide(1)->links() }}
                    </div>

                @else
                    <div class="mt-8 rounded-[2.5rem] border border-dashed border-white/10 bg-white/[0.02] p-16 text-center sf-anim sf-d4">
                        <p class="text-[11px] font-bold uppercase tracking-[0.3em] text-slate-500">Produk Tidak Ditemukan</p>
                        <h3 class="mt-5 text-3xl font-black tracking-tight text-white">Tidak ada produk yang cocok.</h3>
                        <p class="mx-auto mt-5 max-w-xl text-sm leading-8 text-slate-400">
                            Coba ubah keyword pencarian, ganti kategori, atau reset filter untuk melihat semua katalog yang tersedia.
                        </p>
                        <a href="{{ route('products.index') }}" class="mt-8 inline-flex rounded-full bg-white px-8 py-4 text-sm font-bold text-black transition hover:bg-slate-200">
                            Reset Katalog
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════
         FAB — Floating Cart Button (sama dengan home)
    ══════════════════════════════════════════════════════ --}}
    <a href="{{ route('cart.index') }}" class="sf-fab" aria-label="Buka Keranjang">
        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24"
             fill="none" stroke="currentColor" stroke-width="2"
             stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/>
            <line x1="3" y1="6" x2="21" y2="6"/>
            <path d="M16 10a4 4 0 0 1-8 0"/>
        </svg>
        <span>Keranjang</span>
        @if ($cartCount > 0)
            <span class="sf-fab-badge">{{ $cartCount > 99 ? '99+' : $cartCount }}</span>
        @endif
    </a>
@endsection
