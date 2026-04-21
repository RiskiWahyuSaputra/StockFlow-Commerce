@extends('layouts.storefront')

@section('title', $product->name)
@section('meta_description', $product->summary)

@push('styles')
<style>
/* ─── Dark Theme Wrapper ─── */
.sf-dark-inner {
    max-width: 1280px;
    margin: 0 auto;
    padding: 100px 2rem 80px;
}

@media (max-width: 640px) {
    .sf-dark-inner { padding: 80px 1.25rem 60px; }
}

/* ─── Breadcrumb ─── */
.sf-breadcrumb-link {
    border-radius: 9999px;
    border: 1px solid rgba(255,255,255,0.1);
    background: rgba(255,255,255,0.05);
    padding: 8px 16px;
    color: #94a3b8;
    text-decoration: none;
    transition: all 0.2s;
}
.sf-breadcrumb-link:hover {
    border-color: rgba(255,255,255,0.2);
    background: rgba(255,255,255,0.1);
    color: #ffffff;
}

/* ─── MAIN GRID ─── */
.sf-product-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2.5rem;
    align-items: start;
}

@media (max-width: 1024px) {
    .sf-product-grid {
        grid-template-columns: 1fr;
    }
}

/* ─── Kolom Kiri ─── */
.sf-col-left {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    min-width: 0;
}

/* ─── Kolom Kanan ─── */
.sf-col-right {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    min-width: 0;
    position: sticky;
    top: 7rem;
}

/* ─── Image Box ─── */
.sf-detail-img-box {
    position: relative;
    overflow: hidden;
    border-radius: 1.5rem;
    border: 1px solid rgba(255,255,255,0.08);
    background: #0d0d0d;
    width: 100%;
    aspect-ratio: 1 / 1;
}
.sf-detail-img-box img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 2rem;
    display: block;
}

/* ─── Gallery Thumbnails ─── */
.sf-gallery-row {
    display: flex;
    gap: 0.75rem;
    overflow-x: auto;
    padding-bottom: 4px;
}
.sf-gallery-btn {
    flex-shrink: 0;
    border-radius: 0.875rem;
    border: 2px solid transparent;
    background: rgba(255,255,255,0.04);
    padding: 5px;
    transition: all 0.2s;
    cursor: pointer;
}
.sf-gallery-btn:hover {
    background: rgba(255,255,255,0.09);
    transform: translateY(-2px);
}
.sf-gallery-btn.active {
    border-color: #fbbf24;
    background: rgba(245,158,11,0.08);
}
.sf-gallery-thumb {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 72px;
    height: 72px;
    overflow: hidden;
    border-radius: 0.75rem;
    background: rgba(0,0,0,0.6);
}
.sf-gallery-thumb img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 4px;
}

/* ─── Cards ─── */
.sf-detail-card {
    border-radius: 1.75rem;
    border: 1px solid rgba(255,255,255,0.07);
    background: rgba(255,255,255,0.025);
    padding: 1.25rem;
}
.sf-info-card {
    overflow: hidden;
    border-radius: 2rem;
    border: 1px solid rgba(255,255,255,0.10);
    background: rgba(255,255,255,0.03);
}
.sf-info-header {
    border-bottom: 1px solid rgba(255,255,255,0.07);
    background: linear-gradient(135deg, rgba(255,255,255,0.06) 0%, transparent 100%);
    padding: 2rem 1.75rem;
}

/* ─── Spec Grid ─── */
.sf-spec-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.75rem;
    padding: 1.5rem 1.75rem 0;
}
.sf-spec-card {
    border-radius: 1.1rem;
    border: 1px solid rgba(255,255,255,0.07);
    background: rgba(255,255,255,0.02);
    padding: 0.875rem 1rem;
}

/* ─── CTA Area ─── */
.sf-cta-area {
    padding: 1.5rem 1.75rem;
}
.sf-qty-row {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 0.75rem;
}
.sf-btn-group {
    display: flex;
    flex: 1;
    gap: 0.75rem;
}

/* ─── Buttons ─── */
.sf-btn-primary {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 9999px;
    background: #ffffff;
    padding: 11px 22px;
    font-size: 13px;
    font-weight: 700;
    color: #000000;
    text-decoration: none;
    transition: all 0.2s;
    white-space: nowrap;
    cursor: pointer;
    border: none;
    flex: 1;
}
.sf-btn-primary:hover {
    background: #e2e8f0;
    transform: translateY(-1px);
}
.sf-btn-outline {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 9999px;
    border: 1px solid rgba(255,255,255,0.18);
    background: transparent;
    padding: 11px 22px;
    font-size: 13px;
    font-weight: 700;
    color: #ffffff;
    text-decoration: none;
    transition: all 0.2s;
    white-space: nowrap;
    cursor: pointer;
    flex: 1;
}
.sf-btn-outline:hover {
    border-color: rgba(255,255,255,0.35);
    background: rgba(255,255,255,0.06);
}

/* ─── Badge ─── */
.sf-badge-stock-in {
    flex-shrink: 0;
    border-radius: 0.75rem;
    padding: 6px 12px;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    background: rgba(16,185,129,0.1);
    color: #34d399;
    border: 1px solid rgba(16,185,129,0.2);
}
.sf-badge-stock-out {
    flex-shrink: 0;
    border-radius: 0.75rem;
    padding: 6px 12px;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    background: rgba(244,63,94,0.1);
    color: #fb7185;
    border: 1px solid rgba(244,63,94,0.2);
}

/* ─── Deskripsi ─── */
.sf-desc-card {
    border-radius: 1.75rem;
    border: 1px solid rgba(255,255,255,0.07);
    background: rgba(255,255,255,0.025);
    padding: 1.5rem;
}

/* ─── Notes ─── */
.sf-note-item {
    border-radius: 0.875rem;
    border: 1px solid rgba(255,255,255,0.05);
    background: rgba(255,255,255,0.02);
    padding: 0.875rem 1rem;
    font-size: 12px;
    line-height: 1.7;
    color: #64748b;
}

/* ─── Related Products ─── */
.sf-related-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
    margin-top: 2.5rem;
}
@media (max-width: 1024px) {
    .sf-related-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 640px) {
    .sf-related-grid { grid-template-columns: 1fr; }
}

/* ─── Label / Eyebrow ─── */
.sf-eyebrow {
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.25em;
    color: #64748b;
}
</style>
@endpush

@section('content')
<div class="sf-dark-inner">

    @php
        $galleryImages = $product->images->map(fn($image) => [
            'id'         => $image->id,
            'url'        => $image->image_url,
            'alt'        => $image->alt_text ?: $product->name,
            'is_primary' => $image->is_primary,
        ])->values();

        $primaryImage = $galleryImages->firstWhere('is_primary', true)
            ?? $galleryImages->first();

        $specs = [
            ['label' => 'Kategori',   'value' => $product->primary_category_name],
            ['label' => 'SKU',        'value' => $product->sku ?: 'Belum tersedia'],
            ['label' => 'Berat',      'value' => $product->weight ? $product->weight.' gr' : 'Tidak ada'],
            ['label' => 'Diperbarui', 'value' => optional($product->updated_at)->format('d M Y') ?: 'Tidak ada'],
        ];
    @endphp

    {{-- ── Breadcrumb ── --}}
    <div style="display:flex; flex-wrap:wrap; align-items:center; gap:0.75rem; margin-bottom:2rem; font-size:14px;">
        <a href="{{ route('home') }}" class="sf-breadcrumb-link">Beranda</a>
        <span style="color:#475569;">/</span>
        <a href="{{ route('products.index') }}" class="sf-breadcrumb-link">Produk</a>
        <span style="color:#475569;">/</span>
        <span style="font-weight:600; color:#ffffff;">{{ $product->name }}</span>
    </div>

    {{-- ══════════════════════════════════════════
         MAIN LAYOUT — Foto Kiri | Info Kanan
    ══════════════════════════════════════════ --}}
    <section class="sf-product-grid">

        {{-- ━━━━━━━━━━━━━━━━━━━━
             KOLOM KIRI — Foto
        ━━━━━━━━━━━━━━━━━━━━ --}}
        <div
            x-data="{ activeImage: @js($primaryImage) }"
            class="sf-col-left"
        >
            @if ($primaryImage)

                {{-- Foto Utama --}}
                <div class="sf-detail-img-box">
                    {{-- Badge Kategori --}}
                    <div style="position:absolute; left:1rem; top:1rem; z-index:10;">
                        <span style="border-radius:9999px; border:1px solid rgba(255,255,255,0.1); background:rgba(0,0,0,0.6); padding:6px 12px; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.2em; color:#fbbf24; backdrop-filter:blur(8px);">
                            {{ $product->primary_category_name }}
                        </span>
                    </div>
                    {{-- Badge Jumlah Foto --}}
                    @if ($galleryImages->count() > 1)
                        <div style="position:absolute; right:1rem; top:1rem; z-index:10;">
                            <span style="border-radius:9999px; background:#ffffff; padding:6px 12px; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.15em; color:#000000;">
                                {{ $galleryImages->count() }} Foto
                            </span>
                        </div>
                    @endif

                    <img
                        x-bind:src="activeImage.url"
                        x-bind:alt="activeImage.alt"
                    >
                </div>

                {{-- Thumbnail Gallery --}}
                @if ($galleryImages->count() > 1)
                    <div class="sf-gallery-row">
                        @foreach ($galleryImages as $image)
                            <button
                                type="button"
                                x-on:click="activeImage = @js($image)"
                                class="sf-gallery-btn"
                                x-bind:class="activeImage.id === {{ $image['id'] }} ? 'active' : ''"
                            >
                                <div class="sf-gallery-thumb">
                                    <img src="{{ $image['url'] }}" alt="{{ $image['alt'] }}">
                                </div>
                            </button>
                        @endforeach
                    </div>
                @endif

            @else
                <div class="sf-detail-card">
                    <x-frontend.product-visual :product="$product" variant="hero" :seed="0" />
                </div>
            @endif

            {{-- Deskripsi di bawah foto — desktop only --}}
            <div class="sf-desc-card" style="display:none;" id="sf-desc-desktop">
                <p class="sf-eyebrow" style="margin-bottom:1rem;">Deskripsi</p>
                <div style="display:flex; flex-direction:column; gap:0.75rem; font-size:14px; line-height:1.8; color:#94a3b8;">
                    @foreach (preg_split("/\r\n|\n|\r/", trim((string) $product->description)) as $paragraph)
                        @if (filled($paragraph))
                            <p>{{ $paragraph }}</p>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ━━━━━━━━━━━━━━━━━━━━━━━━━━
             KOLOM KANAN — Info Produk
        ━━━━━━━━━━━━━━━━━━━━━━━━━━ --}}
        <div class="sf-col-right">

            {{-- Card Info Utama --}}
            <div class="sf-info-card">

                {{-- Header: Kategori + Nama + Status + Harga --}}
                <div class="sf-info-header">

                    <p style="font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.35em; color:#fbbf24;">
                        {{ $product->primary_category_name }}
                    </p>

                    <div style="display:flex; align-items:flex-start; justify-content:space-between; gap:1rem; margin-top:0.75rem;">
                        <h1 style="font-size:clamp(1.75rem, 3vw, 2.5rem); font-weight:900; color:#ffffff; line-height:1.1; letter-spacing:-0.02em;">
                            {{ $product->name }}
                        </h1>
                        @if ($product->is_in_stock)
                            <span class="sf-badge-stock-in">{{ $product->stock_badge_label }}</span>
                        @else
                            <span class="sf-badge-stock-out">{{ $product->stock_badge_label }}</span>
                        @endif
                    </div>

                    @if ($product->short_description)
                        <p style="margin-top:0.75rem; font-size:13px; line-height:1.7; color:#94a3b8;">
                            {{ $product->short_description }}
                        </p>
                    @endif

                    {{-- Harga --}}
                    <div style="display:flex; flex-wrap:wrap; align-items:center; gap:1rem; margin-top:1.5rem;">
                        <p style="font-size:clamp(2rem, 4vw, 2.5rem); font-weight:900; color:#ffffff; letter-spacing:-0.02em; line-height:1;">
                            {{ $product->price_label }}
                        </p>
                        <span style="border-radius:9999px; border:1px solid rgba(255,255,255,0.1); background:rgba(255,255,255,0.05); padding:8px 16px; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; color:#cbd5e1;">
                            {{ $product->stock_label }}
                        </span>
                    </div>
                </div>

                {{-- Specs --}}
                <div class="sf-spec-grid">
                    @foreach ($specs as $spec)
                        <div class="sf-spec-card">
                            <p style="font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.2em; color:#475569;">
                                {{ $spec['label'] }}
                            </p>
                            <p style="margin-top:6px; font-size:13px; font-weight:700; color:#ffffff;">
                                {{ $spec['value'] }}
                            </p>
                        </div>
                    @endforeach
                </div>

                {{-- CTA --}}
                <div class="sf-cta-area">
                    @if ($product->is_in_stock)
                        <form method="POST" action="{{ route('cart.items.store') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <p style="font-size:12px; color:#64748b; margin-bottom:1rem;">
                                Atur jumlah lalu simpan ke keranjang atau langsung checkout.
                            </p>

                            <div class="sf-qty-row">
                                <x-frontend.quantity-picker
                                    name="quantity"
                                    :value="1"
                                    :min="1"
                                    :max="$product->stock"
                                    size="md"
                                    id="product-quantity"
                                    class="dark-theme"
                                />
                                <div class="sf-btn-group">
                                    <button type="submit" class="sf-btn-primary">
                                        Add to Cart
                                    </button>
                                    <button
                                        type="submit"
                                        name="intent"
                                        value="checkout"
                                        class="sf-btn-outline"
                                    >
                                        Buy Now
                                    </button>
                                </div>
                            </div>
                        </form>
                    @else
                        <div style="display:flex; flex-direction:column; gap:1rem;">
                            <p style="font-size:14px; font-weight:700; color:#ffffff;">
                                Produk sedang tidak tersedia
                            </p>
                            <p style="font-size:13px; line-height:1.7; color:#94a3b8;">
                                Stok habis. Jelajahi katalog untuk produk lain yang tersedia.
                            </p>
                            <a href="{{ route('products.index') }}" class="sf-btn-primary" style="text-align:center;">
                                Kembali ke Katalog
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Shopping Notes --}}
            <div class="sf-detail-card" style="display:flex; flex-direction:column; gap:0.75rem;">
                <p class="sf-eyebrow">Shopping Notes</p>
                <p class="sf-note-item">
                    Produk yang ditambahkan akan masuk ke keranjang, lalu bisa di-checkout saat flow tersedia.
                </p>
                <p class="sf-note-item">
                    Jumlah item akan tercermin pada badge FAB keranjang di beranda atau katalog.
                </p>
            </div>

            {{-- Deskripsi — mobile only --}}
            <div class="sf-desc-card" id="sf-desc-mobile">
                <p class="sf-eyebrow" style="margin-bottom:1rem;">Deskripsi</p>
                <div style="display:flex; flex-direction:column; gap:0.75rem; font-size:14px; line-height:1.8; color:#94a3b8;">
                    @foreach (preg_split("/\r\n|\n|\r/", trim((string) $product->description)) as $paragraph)
                        @if (filled($paragraph))
                            <p>{{ $paragraph }}</p>
                        @endif
                    @endforeach
                </div>
            </div>

        </div>
    </section>

    {{-- ── Related Products ── --}}
    <section style="margin-top:5rem;">
        <x-frontend.section-heading
            eyebrow="Produk Terkait"
            title="Pilihan lain yang masih sejalur dengan katalog ini"
            description="Disusun tetap ringan dan rapi supaya halaman detail terasa fokus, tapi kamu tetap punya jalur eksplorasi berikutnya."
        />

        <div class="sf-related-grid">
            @foreach ($relatedProducts as $related)
                <x-frontend.product-card :product="$related" />
            @endforeach
        </div>
    </section>

</div>

{{-- Script: tampilkan deskripsi desktop/mobile sesuai lebar layar --}}
<script>
    (function() {
        var desktop = document.getElementById('sf-desc-desktop');
        var mobile  = document.getElementById('sf-desc-mobile');
        function toggle() {
            if (window.innerWidth >= 1024) {
                desktop.style.display = 'block';
                mobile.style.display  = 'none';
            } else {
                desktop.style.display = 'none';
                mobile.style.display  = 'block';
            }
        }
        toggle();
        window.addEventListener('resize', toggle);
    })();
</script>

@endsection