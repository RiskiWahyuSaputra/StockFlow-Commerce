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
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 18px;
    overflow: hidden;
    transition: transform 0.22s ease, box-shadow 0.22s ease;
}
.sf-product-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 36px rgba(0,0,0,0.10);
}
.sf-product-img {
    width: 100%;
    height: 140px;
    object-fit: cover;
    display: block;
    background: #f8fafc;
    transition: transform 0.35s ease;
}
.sf-product-card:hover .sf-product-img {
    transform: scale(1.05);
}
.sf-product-img-placeholder {
    width: 100%;
    height: 140px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    font-size: 40px;
}
.sf-product-body { padding: 16px 18px; }
.sf-product-name { font-size: 14px; font-weight: 700; color: #0f172a; line-height: 1.3; }
.sf-product-sku  { font-size: 11px; color: #94a3b8; margin-top: 2px; }
.sf-product-price{ font-size: 15px; font-weight: 700; color: #0f172a; margin-top: 6px; }
.sf-product-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 14px;
}
.sf-stock-green { background:#f0fdf4;color:#166534;border-radius:9999px;padding:3px 10px;font-size:11px;font-weight:600; }
.sf-stock-amber { background:#fffbeb;color:#92400e;border-radius:9999px;padding:3px 10px;font-size:11px;font-weight:600; }
.sf-stock-red   { background:#fef2f2;color:#991b1b;border-radius:9999px;padding:3px 10px;font-size:11px;font-weight:600; }
.sf-arrow-btn {
    width: 30px;
    height: 30px;
    background: #0f172a;
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
.sf-arrow-btn:hover { background: #334155; transform: scale(1.1); }
</style>
@endpush

@section('content')
    @php
        $hasActiveFilters = filled($filters['search']) || filled($filters['category']) || $filters['sort'] !== 'latest';
        $cartCount = session('cart_count', 0);
    @endphp

    {{-- ── Header ── --}}
    <section class="rounded-[2.2rem] border border-slate-200 bg-white p-8 shadow-sm sm:p-10 sf-anim sf-d1">
        <x-frontend.section-heading
            eyebrow="Katalog Produk"
            title="Katalog yang mudah dicari, difilter, dan siap dipakai untuk alur belanja nyata."
            description="Listing ini sudah memakai search, filter kategori, sort harga, pagination, dan eager loading agar siap dipakai untuk katalog produk yang sebenarnya."
        />
    </section>

    {{-- ── Konten Utama ── --}}
    <div class="mt-4 grid gap-6 lg:grid-cols-[260px_minmax(0,1fr)] sf-anim sf-d2">

        {{-- ── Sidebar Filter ── --}}
        <aside class="space-y-6 rounded-[2rem] border border-slate-200 bg-slate-50 p-6">
            <form method="GET" action="{{ route('products.index') }}" class="space-y-5">
                <div>
                    <label for="search" class="text-sm font-semibold text-slate-900">Cari Produk</label>
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
                    <label for="category" class="text-sm font-semibold text-slate-900">Kategori</label>
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
                    <label for="sort" class="text-sm font-semibold text-slate-900">Urutkan</label>
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
                        Terapkan
                    </button>

                    @if ($hasActiveFilters)
                        <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:text-slate-900">
                            Reset
                        </a>
                    @endif
                </div>
            </form>

            <div>
                <p class="text-sm font-semibold text-slate-900">Kategori Cepat</p>
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

        {{-- ── Area Produk ── --}}
        <div>

            {{-- Banner hasil --}}
            <div class="flex flex-col gap-4 rounded-[2rem] border border-slate-200 bg-slate-950 p-6 text-white sm:flex-row sm:items-center sm:justify-between sf-anim sf-d3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-400">Hasil Katalog</p>
                    <h2 class="mt-2 text-2xl font-black tracking-tight">
                        {{ $products->total() }} produk ditemukan
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
                                Pencarian: {{ $filters['search'] }}
                            </span>
                        @endif
                        @if ($selectedCategory)
                            <span class="rounded-full bg-white/10 px-4 py-2 text-sm font-medium text-slate-200">
                                Kategori: {{ $selectedCategory->name }}
                            </span>
                        @endif
                        @if (($sortOptions[$filters['sort']] ?? null) && $filters['sort'] !== 'latest')
                            <span class="rounded-full bg-white/10 px-4 py-2 text-sm font-medium text-slate-200">
                                Urutan: {{ $sortOptions[$filters['sort']] }}
                            </span>
                        @endif
                    </div>
                @endif
            </div>

            @if ($products->count())
                {{-- Grid produk dengan gambar --}}
                <div class="mt-6 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($products as $index => $product)
                        <div class="sf-product-card sf-anim" style="animation-delay: {{ 0.04 + ($index % 6) * 0.07 }}s">

                            {{-- Gambar produk --}}
                            @if ($product->image)
                                <img
                                    class="sf-product-img"
                                    src="{{ Storage::url($product->image) }}"
                                    alt="{{ $product->name }}"
                                    loading="lazy"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                >
                                <div class="sf-product-img-placeholder" style="display:none;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                                </div>
                            @elseif ($product->thumbnail)
                                <img
                                    class="sf-product-img"
                                    src="{{ Storage::url($product->thumbnail) }}"
                                    alt="{{ $product->name }}"
                                    loading="lazy"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                >
                                <div class="sf-product-img-placeholder" style="display:none;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                                </div>
                            @else
                                <div class="sf-product-img-placeholder">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
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
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $products->onEachSide(1)->links() }}
                </div>

            @else
                <div class="mt-6 rounded-[2rem] border border-dashed border-slate-200 bg-slate-50 p-10 text-center sf-anim sf-d4">
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Produk Tidak Ditemukan</p>
                    <h3 class="mt-4 text-2xl font-black tracking-tight text-slate-950">Tidak ada produk yang cocok.</h3>
                    <p class="mx-auto mt-4 max-w-xl text-sm leading-7 text-slate-600">
                        Coba ubah keyword pencarian, ganti kategori, atau reset filter untuk melihat semua katalog yang tersedia.
                    </p>
                    <a href="{{ route('products.index') }}" class="mt-6 inline-flex rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                        Reset Katalog
                    </a>
                </div>
            @endif
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