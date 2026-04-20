@extends('layouts.storefront')

@section('title', 'Checkout')

@section('content')
    <section class="grid gap-8 lg:grid-cols-[minmax(0,1.05fr)_minmax(380px,0.95fr)] lg:items-start">
        <div class="space-y-6">
            <div class="rounded-[2.2rem] border border-slate-200 bg-white p-8 shadow-sm">
                <x-frontend.section-heading
                    eyebrow="Alur Checkout"
                    title="Finalisasi order dengan struktur yang siap di-scale ke payment flow."
                    description="Form ini menyimpan snapshot alamat pengiriman ke tabel order, mengecek stok ulang, lalu membuat order secara transactional."
                />

                <form method="POST" action="{{ route('checkout.store') }}" class="mt-8 space-y-6">
                    @csrf

                    <section class="rounded-[1.8rem] border border-slate-200 bg-slate-50 p-6">
                        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                            <div>
                                <p class="text-sm font-semibold text-slate-900">Data Pengiriman</p>
                                <p class="mt-1 text-sm text-slate-500">Data ini akan disimpan ke snapshot order agar histori tetap konsisten.</p>
                            </div>
                            <div class="rounded-full bg-white px-4 py-2 text-sm font-medium text-slate-600 shadow-sm">
                                Akun: {{ auth()->user()->email }}
                            </div>
                        </div>

                        <div class="mt-6 grid gap-4 md:grid-cols-2">
                            <div class="md:col-span-2">
                                <label for="recipient_name" class="text-sm font-semibold text-slate-900">Nama Penerima</label>
                                <input
                                    id="recipient_name"
                                    name="recipient_name"
                                    type="text"
                                    value="{{ old('recipient_name', auth()->user()->name) }}"
                                    class="mt-3 block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-slate-400 focus:outline-none focus:ring-0"
                                    required
                                >
                            </div>

                            <div>
                                <label for="phone" class="text-sm font-semibold text-slate-900">Nomor Telepon</label>
                                <input
                                    id="phone"
                                    name="phone"
                                    type="text"
                                    value="{{ old('phone', auth()->user()->phone) }}"
                                    class="mt-3 block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-slate-400 focus:outline-none focus:ring-0"
                                    required
                                >
                            </div>

                            <div>
                                <label for="city" class="text-sm font-semibold text-slate-900">Kota</label>
                                <input
                                    id="city"
                                    name="city"
                                    type="text"
                                    value="{{ old('city') }}"
                                    class="mt-3 block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-slate-400 focus:outline-none focus:ring-0"
                                    required
                                >
                            </div>

                            <div class="md:col-span-2">
                                <label for="address" class="text-sm font-semibold text-slate-900">Alamat</label>
                                <textarea
                                    id="address"
                                    name="address"
                                    rows="4"
                                    class="mt-3 block w-full rounded-[1.6rem] border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-slate-400 focus:outline-none focus:ring-0"
                                    required
                                >{{ old('address') }}</textarea>
                            </div>

                            <div>
                                <label for="postal_code" class="text-sm font-semibold text-slate-900">Kode Pos</label>
                                <input
                                    id="postal_code"
                                    name="postal_code"
                                    type="text"
                                    value="{{ old('postal_code') }}"
                                    class="mt-3 block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-slate-400 focus:outline-none focus:ring-0"
                                    required
                                >
                            </div>

                            <div>
                                <label for="note" class="text-sm font-semibold text-slate-900">Catatan</label>
                                <input
                                    id="note"
                                    name="note"
                                    type="text"
                                    value="{{ old('note') }}"
                                    placeholder="Opsional, misalnya patokan rumah"
                                    class="mt-3 block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-slate-400 focus:outline-none focus:ring-0"
                                >
                            </div>
                        </div>
                    </section>

                    <section class="rounded-[1.8rem] border border-slate-200 bg-slate-50 p-6">
                        <p class="text-sm font-semibold text-slate-900">Metode Pengiriman</p>
                        <div class="mt-4 space-y-3">
                            @foreach ($shippingMethods as $method)
                                <div @class([
                                    'rounded-2xl border px-4 py-4 transition',
                                    'border-slate-900 bg-white shadow-sm' => $method['active'],
                                    'border-slate-200 bg-white' => ! $method['active'],
                                ])>
                                    <div class="flex items-center justify-between gap-4">
                                        <div>
                                            <p class="font-semibold text-slate-900">{{ $method['name'] }}</p>
                                            <p class="mt-1 text-sm text-slate-500">{{ $method['detail'] }}</p>
                                        </div>
                                        <span class="text-sm font-semibold text-slate-900">{{ $method['price_label'] }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    <section class="rounded-[1.8rem] border border-slate-200 bg-slate-950 p-6 text-white">
                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-400">Checkout + Pembayaran</p>
                        <h3 class="mt-3 text-2xl font-black tracking-tight">Stok direservasi saat order dibuat, lalu dibayar lewat Midtrans.</h3>
                        <p class="mt-4 text-sm leading-7 text-slate-300">
                            Pendekatan ini dipilih untuk mencegah overselling. Saat checkout berhasil, stok langsung direservasi dan dicatat ke `inventory_logs`. Setelah itu user menyelesaikan pembayaran di Midtrans Snap. Jika payment gagal, expired, atau dibatalkan, stok akan direlease kembali lewat webhook Midtrans.
                        </p>
                    </section>

                    <button type="submit" class="inline-flex w-full items-center justify-center rounded-full bg-slate-900 px-5 py-4 text-sm font-semibold text-white transition hover:bg-slate-800">
                        Buat Order & Lanjut Bayar
                    </button>
                </form>
            </div>
        </div>

        <div class="space-y-6">
            <aside class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-bold text-slate-950">Ringkasan Akhir</h3>

                <div class="mt-6 space-y-4">
                    @foreach ($cart->items as $item)
                        <div class="flex items-center justify-between gap-4 rounded-3xl bg-slate-50 p-4">
                            <div class="min-w-0">
                                <p class="truncate font-semibold text-slate-900">{{ $item->product->name }}</p>
                                <p class="mt-1 text-sm text-slate-500">{{ $item->quantity }} x {{ $item->unit_price_label }}</p>
                            </div>
                            <p class="text-sm font-semibold text-slate-900">{{ $item->subtotal_label }}</p>
                        </div>
                    @endforeach
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
                    <div class="flex items-center justify-between text-slate-600">
                        <span>Pengiriman</span>
                        <span>Rp0</span>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-between rounded-3xl bg-slate-950 px-5 py-4 text-white">
                    <span class="text-sm font-medium text-slate-300">Total Akhir</span>
                    <span class="text-xl font-black tracking-tight">{{ $cart->total_label }}</span>
                </div>
            </aside>

            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-semibold text-slate-900">Langkah Pembayaran</p>
                <div class="mt-4 rounded-3xl border border-dashed border-slate-200 bg-slate-50 p-4">
                    <p class="font-semibold text-slate-900">{{ $paymentMethod['name'] }}</p>
                    <p class="mt-2 text-sm leading-7 text-slate-500">{{ $paymentMethod['detail'] }}</p>
                </div>
            </div>
        </div>
    </section>
@endsection
