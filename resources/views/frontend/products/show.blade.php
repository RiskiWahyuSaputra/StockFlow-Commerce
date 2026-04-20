@extends('layouts.storefront')

@section('title', $product->name)
@section('meta_description', $product->summary)

@section('content')
    @php
        $galleryImages = $product->images->map(function ($image): array {
            return [
                'id' => $image->id,
                'url' => $image->image_url,
                'alt' => $image->alt_text ?: $product->name,
                'is_primary' => $image->is_primary,
            ];
        })->values();

        $primaryImage = $galleryImages->firstWhere('is_primary', true)
            ?? $galleryImages->first();

        $specs = [
            ['label' => 'Kategori', 'value' => $product->primary_category_name],
            ['label' => 'SKU', 'value' => $product->sku ?: 'Belum tersedia'],
            ['label' => 'Berat', 'value' => $product->weight ? $product->weight.' gr' : 'Tidak ada'],
            ['label' => 'Diperbarui', 'value' => optional($product->updated_at)->format('d M Y') ?: 'Tidak ada'],
        ];
    @endphp

    <div class="mb-8 flex flex-wrap items-center gap-3 text-sm text-slate-500">
        <a href="{{ route('home') }}" class="rounded-full border border-slate-200 bg-white px-4 py-2 transition hover:border-slate-300 hover:text-slate-900">Beranda</a>
        <span>/</span>
        <a href="{{ route('products.index') }}" class="rounded-full border border-slate-200 bg-white px-4 py-2 transition hover:border-slate-300 hover:text-slate-900">Produk</a>
        <span>/</span>
        <span class="font-medium text-slate-900">{{ $product->name }}</span>
    </div>

    <section class="grid gap-8 xl:grid-cols-[minmax(0,1.1fr)_minmax(360px,0.9fr)] xl:items-start">
        <div class="space-y-5">
            @if ($primaryImage)
                <div
                    x-data="{ activeImage: @js($primaryImage) }"
                    class="rounded-[2rem] border border-slate-200 bg-white p-4 shadow-sm sm:p-5"
                >
                    <div class="rounded-[1.75rem] bg-[radial-gradient(circle_at_top,#f8fafc_0%,#eff6ff_55%,#e2e8f0_100%)] p-4 sm:p-6">
                        <div class="relative overflow-hidden rounded-[1.5rem] border border-white/70 bg-white shadow-[0_24px_60px_rgba(15,23,42,0.08)]">
                            <div class="absolute inset-x-0 top-0 z-10 flex items-center justify-between px-5 py-4">
                                <span class="rounded-full border border-slate-200/80 bg-white/90 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.28em] text-slate-500 shadow-sm">
                                    {{ $product->primary_category_name }}
                                </span>
                                @if ($galleryImages->count() > 1)
                                    <span class="rounded-full bg-slate-950 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.24em] text-white">
                                        {{ $galleryImages->count() }} Foto
                                    </span>
                                @endif
                            </div>

                            <div class="aspect-[4/4.2] p-6 sm:p-10">
                                <img
                                    x-bind:src="activeImage.url"
                                    x-bind:alt="activeImage.alt"
                                    class="h-full w-full object-contain"
                                >
                            </div>
                        </div>
                    </div>

                    @if ($galleryImages->count() > 1)
                        <div class="mt-4 flex gap-3 overflow-x-auto pb-1">
                            @foreach ($galleryImages as $image)
                                <button
                                    type="button"
                                    x-on:click='activeImage = @js($image)'
                                    class="group shrink-0 rounded-[1.3rem] border border-slate-200 bg-white p-2 text-left shadow-sm transition hover:-translate-y-0.5 hover:border-slate-300"
                                    x-bind:class="activeImage.id === {{ $image['id'] }} ? 'border-slate-900 ring-2 ring-slate-900/10' : ''"
                                >
                                    <div class="flex h-20 w-20 items-center justify-center overflow-hidden rounded-[1rem] bg-slate-50 sm:h-24 sm:w-24">
                                        <img src="{{ $image['url'] }}" alt="{{ $image['alt'] }}" class="h-full w-full object-contain">
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            @else
                <x-frontend.product-visual :product="$product" variant="hero" :seed="0" />
            @endif

            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-7">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="rounded-full bg-slate-950 px-4 py-2 text-xs font-semibold uppercase tracking-[0.28em] text-white">
                        Detail Produk
                    </span>
                    @if ($product->published_at)
                        <span class="rounded-full bg-slate-100 px-4 py-2 text-sm font-medium text-slate-600">
                            Terbit {{ $product->published_at->format('d M Y') }}
                        </span>
                    @endif
                </div>

                @if ($product->short_description)
                    <p class="mt-5 text-lg leading-8 text-slate-700">
                        {{ $product->short_description }}
                    </p>
                @endif

                <div class="mt-6 rounded-[1.6rem] bg-slate-50 p-5 sm:p-6">
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-400">Deskripsi</p>
                    <div class="mt-4 space-y-4 text-base leading-8 text-slate-600">
                        @foreach (preg_split("/\r\n|\n|\r/", trim((string) $product->description)) as $paragraph)
                            @if (filled($paragraph))
                                <p>{{ $paragraph }}</p>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6 xl:sticky xl:top-24">
            <div class="overflow-hidden rounded-[2.2rem] border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-100 bg-[linear-gradient(135deg,#f8fafc_0%,#ffffff_60%,#eff6ff_100%)] px-6 py-6 sm:px-8">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.34em] text-slate-400">{{ $product->primary_category_name }}</p>
                            <h1 class="mt-4 max-w-xl text-4xl font-black tracking-tight text-slate-950 sm:text-[2.85rem] sm:leading-[1.05]">
                                {{ $product->name }}
                            </h1>
                        </div>

                        <span @class([
                            'shrink-0 rounded-[1.4rem] px-4 py-3 text-sm font-semibold',
                            'bg-emerald-50 text-emerald-700' => $product->is_in_stock,
                            'bg-rose-50 text-rose-700' => ! $product->is_in_stock,
                        ])>
                            {{ $product->stock_badge_label }}
                        </span>
                    </div>

                    <div class="mt-6 flex flex-wrap items-end gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-400">Harga</p>
                            <p class="mt-2 text-4xl font-black tracking-tight text-slate-950">{{ $product->price_label }}</p>
                        </div>

                        <div class="rounded-full bg-white px-4 py-3 text-sm font-semibold text-slate-600 shadow-sm ring-1 ring-slate-200">
                            {{ $product->stock_label }}
                        </div>
                    </div>
                </div>

                <div class="px-6 py-6 sm:px-8">
                    <div class="grid gap-3 sm:grid-cols-2">
                        @foreach ($specs as $spec)
                            <div class="rounded-[1.5rem] border border-slate-200 bg-slate-50 px-4 py-4">
                                <p class="text-[11px] font-semibold uppercase tracking-[0.26em] text-slate-400">{{ $spec['label'] }}</p>
                                <p class="mt-2 text-sm font-semibold text-slate-900">{{ $spec['value'] }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 rounded-[1.8rem] border border-slate-200 bg-slate-50 p-5 sm:p-6">
                        @if ($product->is_in_stock)
                            <form method="POST" action="{{ route('cart.items.store') }}" class="space-y-5">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                <div class="flex flex-wrap items-center justify-between gap-4">
                                    <div>
                                        <p class="text-base font-bold text-slate-950">Siap dimasukkan ke keranjang</p>
                                        <p class="mt-2 max-w-md text-sm leading-7 text-slate-500">
                                            Atur jumlah produk, lalu lanjut belanja atau langsung menuju checkout.
                                        </p>
                                    </div>
                                    <div class="inline-flex items-center justify-center rounded-full bg-white px-4 py-2 text-sm font-semibold text-slate-600 shadow-sm ring-1 ring-slate-200">
                                        Maksimal {{ $product->stock }} item
                                    </div>
                                </div>

                                <div class="grid gap-4 lg:grid-cols-[auto_minmax(0,1fr)] lg:items-center">
                                    <div class="flex items-center">
                                        <x-frontend.quantity-picker
                                            name="quantity"
                                            :value="1"
                                            :min="1"
                                            :max="$product->stock"
                                            size="md"
                                            id="product-quantity"
                                        />
                                    </div>

                                    <div class="grid gap-3 sm:grid-cols-2">
                                        <button type="submit" class="inline-flex min-h-12 items-center justify-center rounded-full bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                                            Tambah ke Keranjang
                                        </button>
                                        <a href="{{ route('checkout.index') }}" class="inline-flex min-h-12 items-center justify-center rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:text-slate-900">
                                            Beli Sekarang
                                        </a>
                                    </div>
                                </div>
                            </form>
                        @else
                            <div class="space-y-4">
                                <p class="text-base font-bold text-slate-950">Produk sedang tidak tersedia</p>
                                <p class="text-sm leading-7 text-slate-500">
                                    Stok untuk produk ini sedang habis. Kamu tetap bisa jelajahi katalog untuk melihat produk lain yang tersedia.
                                </p>
                                <a href="{{ route('products.index') }}" class="inline-flex rounded-full bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                                    Kembali ke Katalog
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Catatan Belanja</p>
                <div class="mt-4 grid gap-3">
                    <div class="rounded-[1.4rem] bg-slate-50 px-4 py-4 text-sm leading-7 text-slate-600">
                        Produk aktif ini sudah terhubung dengan stok real-time dari cart dan checkout.
                    </div>
                    <div class="rounded-[1.4rem] bg-slate-50 px-4 py-4 text-sm leading-7 text-slate-600">
                        Jumlah item yang ditambahkan akan otomatis tercermin pada badge FAB keranjang.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mt-16">
        <x-frontend.section-heading
            eyebrow="Produk Terkait"
            title="Pilihan lain yang masih sejalur dengan katalog ini"
            description="Disusun tetap ringan dan rapi supaya halaman detail terasa fokus, tapi kamu tetap punya jalur eksplorasi berikutnya."
        />

        <div class="mt-8 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($relatedProducts as $related)
                <x-frontend.product-card :product="$related" />
            @endforeach
        </div>
    </section>
@endsection
