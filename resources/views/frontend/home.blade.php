@extends('layouts.storefront')

@section('title', 'Beranda')
@section('meta_description', 'Beranda storefront modern untuk StockFlow Commerce berbasis Laravel Blade.')

@section('content')
    <section class="grid gap-8 lg:grid-cols-[minmax(0,1.2fr)_minmax(360px,0.8fr)] lg:items-start">
        <div class="rounded-[2.2rem] border border-slate-200 bg-white/90 p-8 shadow-sm backdrop-blur sm:p-10">
            <span class="inline-flex rounded-full border border-brand-100 bg-brand-50 px-4 py-2 text-xs font-semibold uppercase tracking-[0.28em] text-brand-700">
                StockFlow Commerce
            </span>

            <h1 class="mt-6 max-w-4xl text-5xl font-black tracking-tight text-slate-950 sm:text-6xl">
                Pengalaman belanja modern yang rapi, tenang, dan siap dipresentasikan.
            </h1>

            <p class="mt-6 max-w-2xl text-base leading-8 text-slate-600 sm:text-lg">
                Halaman ini menjadi fondasi visual untuk katalog produk, detail produk, cart, checkout, dan preview admin.
                Semua komponen dirancang reusable agar enak di-scale saat backend mulai terhubung penuh.
            </p>

            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('products.index') }}" class="rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                    Jelajahi Produk
                </a>
                <a href="{{ route('checkout.index') }}" class="rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:text-slate-900">
                    Lihat Checkout
                </a>
            </div>

            <div class="mt-10 grid gap-4 sm:grid-cols-3">
                @foreach ($stats as $stat)
                    <x-frontend.metric-card :label="$stat['label']" :value="$stat['value']" />
                @endforeach
            </div>
        </div>

        <aside class="overflow-hidden rounded-[2.2rem] border border-slate-200 bg-slate-950 p-6 text-white shadow-xl shadow-slate-900/10 sm:p-8">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Produk Sorotan</p>

            <div class="mt-6 rounded-[2rem] p-6" style="{{ $spotlightProduct['cover_style'] }}">
                <div class="rounded-[1.5rem] border border-white/30 bg-white/15 p-6 backdrop-blur-sm">
                    <p class="text-sm font-semibold text-slate-800/80">{{ $spotlightProduct['category'] }}</p>
                    <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-950">{{ $spotlightProduct['name'] }}</h2>
                    <p class="mt-4 max-w-md text-sm leading-7 text-slate-800/80">{{ $spotlightProduct['description'] }}</p>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-between rounded-3xl border border-white/10 bg-white/5 px-5 py-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.24em] text-slate-400">Harga Pratinjau</p>
                    <p class="mt-2 text-2xl font-black tracking-tight">{{ $spotlightProduct['price_label'] }}</p>
                </div>
                <a href="{{ route('products.show', $spotlightProduct['slug']) }}" class="rounded-full bg-white px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-slate-100">
                    Lihat Produk
                </a>
            </div>
        </aside>
    </section>

    <section class="mt-16">
        <x-frontend.section-heading
            eyebrow="Pilihan Unggulan"
            title="Produk disusun rapi untuk memberi kesan profesional sejak tampilan pertama."
            description="Kartu produk memakai struktur yang konsisten untuk listing page, recommendation block, dan section lain di storefront."
            :link="route('products.index')"
            link-label="Lihat semua produk"
        />

        <div class="mt-8 grid gap-6 md:grid-cols-2 xl:grid-cols-4">
            @foreach ($featuredProducts as $product)
                <x-frontend.product-card :product="$product" />
            @endforeach
        </div>
    </section>

    <section class="mt-16 grid gap-6 lg:grid-cols-[minmax(0,0.9fr)_minmax(0,1.1fr)] lg:items-start">
        <div class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-sm">
            <x-frontend.section-heading
                eyebrow="Pratinjau Kategori"
                title="Struktur storefront yang tetap enak dibaca saat katalog makin berkembang."
                description="Chip kategori ini sengaja dibuat ringan dan editorial agar tidak terasa seperti panel admin."
            />

            <div class="mt-8 flex flex-wrap gap-3">
                @foreach ($categories as $category)
                    <span class="rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-medium text-slate-700">
                        {{ $category['name'] }} <span class="text-slate-400">({{ $category['count'] }})</span>
                    </span>
                @endforeach
            </div>
        </div>

        <div class="grid gap-6 sm:grid-cols-2">
            <article class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Alur Keranjang</p>
                <h3 class="mt-4 text-2xl font-black tracking-tight text-slate-950">Tinjau keranjang dalam layout ringkas yang tetap fokus.</h3>
                <p class="mt-4 text-sm leading-7 text-slate-600">
                    Halaman keranjang dipersiapkan untuk review jumlah, input promo, dan ringkasan pesanan tanpa terasa padat.
                </p>
                <a href="{{ route('cart.index') }}" class="mt-6 inline-flex rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">
                    Buka Keranjang
                </a>
            </article>

            <article class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Alur Checkout</p>
                <h3 class="mt-4 text-2xl font-black tracking-tight text-slate-950">Halaman checkout rapi yang siap dipakai untuk integrasi Midtrans.</h3>
                <p class="mt-4 text-sm leading-7 text-slate-600">
                    Checkout didesain dengan summary tetap terlihat, tapi form dan payment selection tetap nyaman dibaca.
                </p>
                <a href="{{ route('checkout.index') }}" class="mt-6 inline-flex rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:text-slate-900">
                    Buka Checkout
                </a>
            </article>
        </div>
    </section>
@endsection
