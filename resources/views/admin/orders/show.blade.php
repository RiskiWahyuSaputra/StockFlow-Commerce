@extends('layouts.admin')

@section('title', 'Detail Pesanan')
@section('heading', 'Detail Pesanan')

@section('content')
    <section class="grid gap-6 xl:grid-cols-[minmax(0,1.05fr)_minmax(360px,0.95fr)]">
        <div class="space-y-6">
            <article class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-400">Referensi Pesanan</p>
                        <h2 class="mt-2 text-3xl font-black tracking-tight text-slate-950">{{ $order->order_number }}</h2>
                        <p class="mt-2 text-sm text-slate-500">{{ $order->placed_at?->format('d M Y H:i') }}</p>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <x-admin.badge :value="$order->order_status" :classes="match($order->order_status) { 'paid' => 'bg-emerald-50 text-emerald-700', 'processing', 'shipped' => 'bg-sky-50 text-sky-700', 'completed' => 'bg-slate-900 text-white', 'cancelled', 'refunded' => 'bg-rose-50 text-rose-700', default => 'bg-amber-50 text-amber-700' }" />
                        <x-admin.badge :value="$order->payment_status" :classes="match($order->payment_status) { 'paid' => 'bg-emerald-50 text-emerald-700', 'pending' => 'bg-amber-50 text-amber-700', 'failed', 'expired' => 'bg-rose-50 text-rose-700', 'refunded' => 'bg-slate-100 text-slate-700', default => 'bg-slate-100 text-slate-700' }" />
                    </div>
                </div>

                <div class="mt-6 grid gap-4 md:grid-cols-2">
                    <div class="rounded-3xl bg-slate-50 p-5">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400">Pelanggan</p>
                        <p class="mt-3 font-semibold text-slate-900">{{ $order->customer_name }}</p>
                        <p class="mt-1 text-sm text-slate-500">{{ $order->customer_email }}</p>
                        <p class="mt-1 text-sm text-slate-500">{{ $order->customer_phone }}</p>
                    </div>

                    <div class="rounded-3xl bg-slate-50 p-5">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400">Pengiriman</p>
                        <p class="mt-3 font-semibold text-slate-900">{{ $order->shipping_recipient_name }}</p>
                        <p class="mt-1 text-sm leading-7 text-slate-500">{{ $order->shipping_full_address }}</p>
                    </div>
                </div>
            </article>

            <article class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-400">Item Pesanan</p>
                        <h3 class="mt-2 text-2xl font-black tracking-tight text-slate-950">Snapshot item pesanan</h3>
                    </div>
                </div>

                <div class="mt-6 space-y-4">
                    @foreach ($order->items as $item)
                        <div class="flex items-center justify-between gap-4 rounded-3xl border border-slate-200 p-4">
                            <div>
                                <p class="font-semibold text-slate-900">{{ $item->product_name }}</p>
                                <p class="mt-1 text-sm text-slate-500">{{ $item->sku }} • {{ $item->quantity }} x Rp{{ number_format((float) $item->unit_price, 0, ',', '.') }}</p>
                            </div>
                            <p class="font-semibold text-slate-900">Rp{{ number_format((float) $item->total_price, 0, ',', '.') }}</p>
                        </div>
                    @endforeach
                </div>
            </article>

            <article class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-400">Jejak Inventaris</p>
                        <h3 class="mt-2 text-2xl font-black tracking-tight text-slate-950">Log inventaris terkait pesanan ini</h3>
                    </div>
                </div>

                <div class="mt-6 space-y-3">
                    @forelse ($order->inventoryLogs as $log)
                        <div class="rounded-3xl border border-slate-200 px-4 py-4">
                            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <p class="font-semibold text-slate-900">{{ $log->product?->name ?? 'Produk' }}</p>
                                    <p class="mt-1 text-sm text-slate-500">{{ $log->type }} • {{ $log->quantity_changed_label }} • setelah {{ $log->quantity_after }}</p>
                                </div>
                                <p class="text-xs text-slate-400">{{ $log->created_at?->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-3xl border border-dashed border-slate-200 bg-slate-50 px-5 py-8 text-center text-sm text-slate-500">
                            Belum ada inventory log yang terkait langsung dengan pesanan ini.
                        </div>
                    @endforelse
                </div>
            </article>
        </div>

        <div class="space-y-6">
            <article class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-400">Perbarui Status</p>
                <h3 class="mt-2 text-2xl font-black tracking-tight text-slate-950">Ubah lifecycle pesanan</h3>

                <form method="POST" action="{{ route('admin.orders.update-status', $order) }}" class="mt-6 space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label for="order_status" class="text-sm font-semibold text-slate-900">Status Pesanan</label>
                        <select id="order_status" name="order_status" class="mt-2 block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-slate-400 focus:outline-none focus:ring-0">
                            @foreach ($statusOptions as $value => $label)
                                <option value="{{ $value }}" @selected(old('order_status', $order->order_status) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="inline-flex w-full items-center justify-center rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                        Perbarui Status
                    </button>
                </form>
            </article>

            <article class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-400">Status Pembayaran</p>
                <h3 class="mt-2 text-2xl font-black tracking-tight text-slate-950">Detail pembayaran terakhir</h3>

                @if ($order->payments->isNotEmpty())
                    @foreach ($order->payments as $payment)
                        <div class="mt-4 rounded-3xl bg-slate-50 p-5">
                            <div class="flex flex-wrap gap-2">
                                <x-admin.badge :value="$payment->status" :classes="match($payment->status) { 'paid' => 'bg-emerald-50 text-emerald-700', 'pending' => 'bg-amber-50 text-amber-700', 'failed', 'expired', 'cancelled' => 'bg-rose-50 text-rose-700', default => 'bg-slate-100 text-slate-700' }" />
                                <x-admin.badge :value="$payment->payment_type ?? $payment->method" classes="bg-slate-100 text-slate-700" />
                            </div>

                            <div class="mt-4 space-y-2 text-sm text-slate-600">
                                <p><span class="font-semibold text-slate-900">ID Transaksi:</span> {{ $payment->transaction_id ?? '-' }}</p>
                                <p><span class="font-semibold text-slate-900">Status Transaksi:</span> {{ $payment->transaction_status ?? '-' }}</p>
                                <p><span class="font-semibold text-slate-900">Status Fraud:</span> {{ $payment->fraud_status ?? '-' }}</p>
                                <p><span class="font-semibold text-slate-900">Total Tagihan:</span> {{ $payment->gross_amount_label }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="mt-4 rounded-3xl border border-dashed border-slate-200 bg-slate-50 px-5 py-8 text-center text-sm text-slate-500">
                        Belum ada data pembayaran untuk pesanan ini.
                    </div>
                @endif
            </article>

            <article class="rounded-[2rem] border border-slate-200 bg-slate-950 p-6 text-white shadow-xl shadow-slate-900/10">
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-400">Ringkasan Finansial</p>
                <div class="mt-4 space-y-3 text-sm">
                    <div class="flex items-center justify-between text-slate-300">
                        <span>Subtotal</span>
                        <span>{{ $order->subtotal_label }}</span>
                    </div>
                    <div class="flex items-center justify-between text-slate-300">
                        <span>Pengiriman</span>
                        <span>Rp{{ number_format((float) $order->shipping_cost, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex items-center justify-between text-white">
                        <span class="font-semibold">Total Akhir</span>
                        <span class="text-xl font-black tracking-tight">{{ $order->grand_total_label }}</span>
                    </div>
                </div>
            </article>
        </div>
    </section>
@endsection
