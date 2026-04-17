@extends('layouts.storefront')

@section('title', 'Cart')

@section('content')
    <section class="grid gap-8 lg:grid-cols-[minmax(0,1.05fr)_minmax(360px,0.95fr)] lg:items-start">
        <div class="rounded-[2.2rem] border border-slate-200 bg-white p-8 shadow-sm">
            <x-frontend.section-heading
                eyebrow="Cart Management"
                title="Database-backed cart yang siap untuk flow checkout."
                description="User bisa menambah produk, update quantity, hapus item, dan semua total dihitung ulang dari database."
            />

            @if ($cart->items->isNotEmpty())
                <div class="mt-8 space-y-4">
                    @foreach ($cart->items as $item)
                        <article class="flex flex-col gap-5 rounded-[1.8rem] border border-slate-200 p-5">
                            <div class="flex flex-col gap-4 sm:flex-row sm:items-start">
                                <div class="w-full sm:w-32">
                                    <x-frontend.product-visual :product="$item->product" variant="thumb" :seed="$loop->index" />
                                </div>

                                <div class="min-w-0 flex-1">
                                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                        <div class="min-w-0">
                                            <p class="text-sm font-medium text-slate-500">{{ $item->product->primary_category_name }}</p>
                                            <h2 class="mt-1 text-xl font-bold text-slate-950">{{ $item->product->name }}</h2>
                                            <p class="mt-2 text-sm leading-7 text-slate-600">{{ $item->product->summary }}</p>
                                        </div>

                                        <div class="rounded-full bg-slate-50 px-4 py-2 text-sm font-semibold text-slate-700">
                                            {{ $item->subtotal_label }}
                                        </div>
                                    </div>

                                    <div class="mt-5 flex flex-col gap-4 border-t border-slate-100 pt-4 lg:flex-row lg:items-center lg:justify-between">
                                        <form method="POST" action="{{ route('cart.items.update', $item) }}" class="flex flex-wrap items-center gap-3">
                                            @csrf
                                            @method('PATCH')

                                            <label for="quantity-{{ $item->id }}" class="text-sm font-semibold text-slate-700">
                                                Qty
                                            </label>
                                            <input
                                                id="quantity-{{ $item->id }}"
                                                type="number"
                                                name="quantity"
                                                value="{{ $item->quantity }}"
                                                min="1"
                                                max="{{ $item->product->stock }}"
                                                class="w-24 rounded-full border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 focus:border-slate-400 focus:outline-none focus:ring-0"
                                            >

                                            <button type="submit" class="rounded-full border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:text-slate-900">
                                                Update
                                            </button>
                                        </form>

                                        <div class="flex items-center gap-3">
                                            <p class="text-sm text-slate-500">
                                                {{ $item->quantity }} x {{ $item->unit_price_label }}
                                            </p>

                                            <form method="POST" action="{{ route('cart.items.destroy', $item) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rounded-full bg-rose-50 px-4 py-2.5 text-sm font-semibold text-rose-700 transition hover:bg-rose-100">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="mt-8 rounded-[2rem] border border-dashed border-slate-200 bg-slate-50 p-10 text-center">
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Cart Empty</p>
                    <h3 class="mt-4 text-2xl font-black tracking-tight text-slate-950">Cart kamu masih kosong.</h3>
                    <p class="mx-auto mt-4 max-w-xl text-sm leading-7 text-slate-600">
                        Tambahkan produk dari katalog untuk mulai checkout. Semua item akan disimpan di database berdasarkan user yang login.
                    </p>
                    <a href="{{ route('products.index') }}" class="mt-6 inline-flex rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                        Explore Products
                    </a>
                </div>
            @endif
        </div>

        <div class="space-y-6">
            <aside class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-bold text-slate-950">Cart Summary</h3>

                <div class="mt-6 space-y-4">
                    @forelse ($cart->items as $item)
                        <div class="flex items-center justify-between gap-4 rounded-3xl bg-slate-50 p-4">
                            <div class="min-w-0">
                                <p class="truncate font-semibold text-slate-900">{{ $item->product->name }}</p>
                                <p class="mt-1 text-sm text-slate-500">{{ $item->quantity }} x {{ $item->unit_price_label }}</p>
                            </div>
                            <p class="text-sm font-semibold text-slate-900">{{ $item->subtotal_label }}</p>
                        </div>
                    @empty
                        <div class="rounded-3xl bg-slate-50 p-4 text-sm leading-7 text-slate-500">
                            Belum ada item aktif di cart.
                        </div>
                    @endforelse
                </div>

                <div class="mt-6 space-y-3 border-t border-slate-100 pt-6 text-sm">
                    <div class="flex items-center justify-between text-slate-600">
                        <span>Total item</span>
                        <span>{{ $cart->total_items }}</span>
                    </div>
                    <div class="flex items-center justify-between text-slate-600">
                        <span>Subtotal</span>
                        <span>{{ $cart->subtotal_label }}</span>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-between rounded-3xl bg-slate-950 px-5 py-4 text-white">
                    <span class="text-sm font-medium text-slate-300">Total Cart</span>
                    <span class="text-xl font-black tracking-tight">{{ $cart->total_label }}</span>
                </div>
            </aside>

            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-semibold text-slate-900">Next Step</p>
                <div class="mt-4 rounded-3xl border border-dashed border-slate-200 bg-slate-50 p-4 text-sm leading-7 text-slate-500">
                    Cart ini sudah siap disambungkan ke checkout database-based. Saat ini tombol checkout masih menuju preview halaman checkout.
                </div>
                <a href="{{ route('checkout.index') }}" class="mt-6 inline-flex w-full items-center justify-center rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                    Proceed to Checkout
                </a>
            </div>
        </div>
    </section>
@endsection
