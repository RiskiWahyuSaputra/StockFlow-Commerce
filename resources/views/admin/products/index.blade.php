@extends('layouts.admin')

@section('title', 'Produk')
@section('heading', 'Manajemen Produk')

@section('content')
    <section class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-400">Admin Katalog</p>
                <h2 class="mt-2 text-2xl font-black tracking-tight text-slate-950">Kelola produk, gambar, dan stok</h2>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row">
                <form method="GET" action="{{ route('admin.products.index') }}" class="flex flex-wrap gap-3">
                    <input type="text" name="search" value="{{ $filters['search'] }}" placeholder="Cari nama / SKU" class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-slate-400 focus:outline-none focus:ring-0">
                    <select name="status" class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-slate-400 focus:outline-none focus:ring-0">
                        <option value="">Semua status</option>
                        @foreach ($statusOptions as $value => $label)
                            <option value="{{ $value }}" @selected($filters['status'] === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="rounded-full border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:text-slate-900">
                        Filter
                    </button>
                </form>

                <a href="{{ route('admin.products.create') }}" class="rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                    Buat Produk
                </a>
            </div>
        </div>

        <div class="mt-6 overflow-hidden rounded-[1.6rem] border border-slate-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-left text-slate-500">
                        <tr>
                            <th class="px-4 py-4 font-semibold">Produk</th>
                            <th class="px-4 py-4 font-semibold">Kategori</th>
                            <th class="px-4 py-4 font-semibold">Harga</th>
                            <th class="px-4 py-4 font-semibold">Stok</th>
                            <th class="px-4 py-4 font-semibold">Status</th>
                            <th class="px-4 py-4 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($products as $product)
                            <tr>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="h-16 w-16 overflow-hidden rounded-2xl bg-slate-100">
                                            @if ($product->primaryImage)
                                                <img src="{{ $product->primaryImage->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-semibold text-slate-900">{{ $product->name }}</p>
                                            <p class="mt-1 text-xs text-slate-500">{{ $product->sku }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-slate-600">{{ $product->category?->name ?? '-' }}</td>
                                <td class="px-4 py-4 font-semibold text-slate-900">{{ $product->price_label }}</td>
                                <td class="px-4 py-4">
                                    <div class="space-y-2">
                                        <p class="font-semibold text-slate-900">{{ $product->stock }}</p>
                                        @if ($product->stock <= $product->low_stock_threshold)
                                            <x-admin.badge value="low stock" classes="bg-amber-50 text-amber-700" />
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <x-admin.badge :value="$product->status" :classes="match($product->status) { 'active' => 'bg-emerald-50 text-emerald-700', 'draft' => 'bg-slate-100 text-slate-700', 'inactive' => 'bg-amber-50 text-amber-700', default => 'bg-rose-50 text-rose-700' }" />
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('admin.products.edit', $product) }}" class="rounded-full border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 transition hover:border-slate-300 hover:text-slate-900">
                                            Ubah
                                        </a>
                                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-full bg-rose-50 px-3 py-2 text-xs font-semibold text-rose-700 transition hover:bg-rose-100">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-slate-500">Belum ada produk yang tersimpan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $products->onEachSide(1)->links() }}
        </div>
    </section>
@endsection
