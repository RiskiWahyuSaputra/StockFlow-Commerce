@extends('layouts.storefront')

@section('title', 'Checkout Success')

@section('content')
    <section class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_minmax(360px,0.9fr)] lg:items-start">
        <div class="rounded-[2.2rem] border border-slate-200 bg-white p-8 shadow-sm">
            <span class="inline-flex rounded-full bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700">
                Order Created
            </span>

            <h1 class="mt-6 text-4xl font-black tracking-tight text-slate-950">
                Order {{ $order->order_number }} berhasil dibuat.
            </h1>

            <p class="mt-5 max-w-2xl text-base leading-8 text-slate-600">
                Cart sudah dikonversi menjadi order, snapshot item sudah tersimpan di `order_items`, dan stok sudah direservasi agar tidak terjadi overselling. Status awal order adalah `{{ $order->order_status }}` dengan payment status `{{ $order->payment_status }}`.
            </p>

            <div class="mt-8 grid gap-4 sm:grid-cols-2">
                <div class="rounded-3xl bg-slate-50 p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400">Recipient</p>
                    <p class="mt-3 text-lg font-semibold text-slate-900">{{ $order->shipping_recipient_name }}</p>
                    <p class="mt-2 text-sm text-slate-500">{{ $order->shipping_phone }}</p>
                </div>

                <div class="rounded-3xl bg-slate-50 p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400">Shipping Address</p>
                    <p class="mt-3 text-sm leading-7 text-slate-700">{{ $order->shipping_full_address }}</p>
                </div>
            </div>

            <div class="mt-8 space-y-4">
                @foreach ($order->items as $item)
                    <div class="flex items-center justify-between gap-4 rounded-3xl border border-slate-200 p-4">
                        <div>
                            <p class="font-semibold text-slate-900">{{ $item->product_name }}</p>
                            <p class="mt-1 text-sm text-slate-500">{{ $item->quantity }} x Rp{{ number_format((float) $item->unit_price, 0, ',', '.') }}</p>
                        </div>
                        <p class="text-sm font-semibold text-slate-900">Rp{{ number_format((float) $item->total_price, 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="space-y-6">
            <aside class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-bold text-slate-950">Order Summary</h3>

                <div class="mt-6 space-y-3 border-t border-slate-100 pt-6 text-sm">
                    <div class="flex items-center justify-between text-slate-600">
                        <span>Order Status</span>
                        <span class="font-semibold text-slate-900">{{ $order->order_status }}</span>
                    </div>
                    <div class="flex items-center justify-between text-slate-600">
                        <span>Payment Status</span>
                        <span class="font-semibold text-slate-900">{{ $order->payment_status }}</span>
                    </div>
                    <div class="flex items-center justify-between text-slate-600">
                        <span>Subtotal</span>
                        <span>{{ $order->subtotal_label }}</span>
                    </div>
                    <div class="flex items-center justify-between text-slate-600">
                        <span>Shipping</span>
                        <span>Rp0</span>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-between rounded-3xl bg-slate-950 px-5 py-4 text-white">
                    <span class="text-sm font-medium text-slate-300">Grand Total</span>
                    <span class="text-xl font-black tracking-tight">{{ $order->grand_total_label }}</span>
                </div>
            </aside>

            <div class="rounded-[2rem] border border-slate-200 bg-slate-950 p-6 text-white shadow-xl shadow-slate-900/10">
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-400">Next Step</p>
                <h3 class="mt-4 text-2xl font-black tracking-tight">Order siap dihubungkan ke Midtrans.</h3>
                <p class="mt-4 text-sm leading-7 text-slate-300">
                    Tahap berikutnya adalah membuat payment initiation dan callback agar order pending ini bisa berubah ke paid/failed/expired secara otomatis.
                </p>
                <a href="{{ route('products.index') }}" class="mt-6 inline-flex w-full items-center justify-center rounded-full bg-white px-5 py-3 text-sm font-semibold text-slate-950 transition hover:bg-slate-100">
                    Kembali ke Katalog
                </a>
            </div>
        </div>
    </section>
@endsection
