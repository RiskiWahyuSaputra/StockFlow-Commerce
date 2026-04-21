@extends('layouts.admin')

@section('title', 'Detail Pesanan')
@section('heading', 'Detail Pesanan')

@section('content')
    <section class="grid gap-6 xl:grid-cols-[minmax(0,1.05fr)_minmax(360px,0.95fr)]">
        <div class="space-y-6">
            {{-- ── Ringkasan Pesanan ── --}}
            <article class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-[0.25em] text-slate-400">Referensi Pesanan</p>
                        <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-950">{{ $order->order_number }}</h2>
                        <div class="mt-3 flex items-center gap-2 text-sm text-slate-500">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            {{ $order->placed_at?->format('d M Y, H:i') }}
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <x-admin.badge :value="$order->order_status" :classes="match($order->order_status) { 'paid' => 'bg-emerald-50 text-emerald-700 border border-emerald-100', 'processing', 'shipped' => 'bg-sky-50 text-sky-700 border border-sky-100', 'completed' => 'bg-slate-900 text-white', 'cancelled', 'refunded' => 'bg-rose-50 text-rose-700 border border-rose-100', default => 'bg-amber-50 text-amber-700 border border-amber-100' }" />
                        <x-admin.badge :value="$order->payment_status" :classes="match($order->payment_status) { 'paid' => 'bg-emerald-50 text-emerald-700 border border-emerald-100', 'pending' => 'bg-amber-50 text-amber-700 border border-amber-100', 'failed', 'expired' => 'bg-rose-50 text-rose-700 border border-rose-100', 'refunded' => 'bg-slate-100 text-slate-700 border border-slate-200', default => 'bg-slate-100 text-slate-700 border border-slate-200' }" />
                    </div>
                </div>

                <div class="mt-8 grid gap-6 md:grid-cols-2">
                    <div class="rounded-[1.75rem] border border-slate-100 bg-slate-50/50 p-6">
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400">Data Pelanggan</p>
                        <div class="mt-4 space-y-2">
                            <p class="font-bold text-slate-900">{{ $order->customer_name }}</p>
                            <p class="text-sm text-slate-600">{{ $order->customer_email }}</p>
                            <p class="text-sm text-slate-600">{{ $order->customer_phone ?: 'No. Telepon tidak ada' }}</p>
                        </div>
                    </div>

                    <div class="rounded-[1.75rem] border border-slate-100 bg-slate-50/50 p-6">
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400">Informasi Pengiriman</p>
                        <div class="mt-4 space-y-2">
                            <p class="font-bold text-slate-900">{{ $order->shipping_recipient_name }}</p>
                            <p class="text-sm leading-7 text-slate-600">{{ $order->shipping_full_address }}</p>
                        </div>
                    </div>
                </div>
            </article>

            {{-- ── Daftar Item ── --}}
            <article class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-[0.25em] text-slate-400">Item Pesanan</p>
                        <h3 class="mt-2 text-2xl font-black tracking-tight text-slate-950">Snapshot produk</h3>
                    </div>
                    <span class="rounded-full bg-slate-100 px-4 py-1.5 text-xs font-bold text-slate-600">
                        {{ $order->items->sum('quantity') }} Item
                    </span>
                </div>

                <div class="mt-8 overflow-hidden rounded-[1.75rem] border border-slate-100">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500">Produk</th>
                                <th class="px-6 py-4 text-center text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500">Jumlah</th>
                                <th class="px-6 py-4 text-right text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500">Harga</th>
                                <th class="px-6 py-4 text-right text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($order->items as $item)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-4">
                                            <div class="h-16 w-16 shrink-0 overflow-hidden rounded-2xl border border-slate-100 bg-slate-50 p-1">
                                                @if ($item->product?->primary_image_url)
                                                    <img src="{{ $item->product->primary_image_url }}" alt="{{ $item->product_name }}" class="h-full w-full object-contain">
                                                @else
                                                    <div class="flex h-full w-full items-center justify-center bg-slate-100 text-slate-300">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <p class="font-bold text-slate-900">{{ $item->product_name }}</p>
                                                <p class="mt-1 text-xs text-slate-400">{{ $item->sku ?: 'No SKU' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        <span class="inline-flex h-8 min-w-[2rem] items-center justify-center rounded-lg bg-slate-100 px-2 text-sm font-bold text-slate-700">
                                            {{ $item->quantity }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 text-right text-sm text-slate-600">
                                        Rp{{ number_format((float) $item->unit_price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-5 text-right font-bold text-slate-900">
                                        Rp{{ number_format((float) $item->total_price, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </article>

            {{-- ── Log Inventaris ── --}}
            <article class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-[0.25em] text-slate-400">Jejak Inventaris</p>
                        <h3 class="mt-2 text-2xl font-black tracking-tight text-slate-950">Log stok otomatis</h3>
                    </div>
                </div>

                <div class="mt-6 space-y-3">
                    @forelse ($order->inventoryLogs as $log)
                        <div class="rounded-[1.5rem] border border-slate-100 bg-slate-50/30 p-4 transition hover:bg-slate-50">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <div class="flex items-center gap-3">
                                    <div @class([
                                        'flex h-10 w-10 shrink-0 items-center justify-center rounded-full',
                                        'bg-rose-50 text-rose-600' => $log->quantity_changed < 0,
                                        'bg-emerald-50 text-emerald-600' => $log->quantity_changed >= 0,
                                    ])>
                                        @if ($log->quantity_changed < 0)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m19 12-7 7-7-7"/><path d="M12 19V5"/></svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m5 12 7-7 7 7"/><path d="M12 19V5"/></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900">{{ $log->product?->name ?? $log->product_name }}</p>
                                        <p class="mt-0.5 text-xs text-slate-500">
                                            {{ $log->type_label }} • 
                                            <span class="font-bold">{{ $log->quantity_changed_label }}</span> • 
                                            Stok akhir: <span class="font-bold">{{ $log->quantity_after }}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">{{ $log->created_at?->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-[1.75rem] border border-dashed border-slate-200 bg-slate-50 p-10 text-center">
                            <p class="text-sm text-slate-500 italic">Belum ada inventory log yang terkait langsung.</p>
                        </div>
                    @endforelse
                </div>
            </article>
        </div>

        <div class="space-y-6">
            {{-- ── Aksi Update ── --}}
            <article class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                <p class="text-[11px] font-bold uppercase tracking-[0.25em] text-slate-400">Update Lifecycle</p>
                <h3 class="mt-2 text-2xl font-black tracking-tight text-slate-950">Status Pesanan</h3>

                <form method="POST" action="{{ route('admin.orders.update-status', $order) }}" class="mt-8 space-y-5">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label for="order_status" class="text-xs font-bold uppercase tracking-wider text-slate-500">Status Baru</label>
                        <div class="relative mt-2">
                            <select id="order_status" name="order_status" class="block w-full appearance-none rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4 text-sm font-semibold text-slate-700 focus:border-slate-900 focus:bg-white focus:outline-none focus:ring-0 transition">
                                @foreach ($statusOptions as $value => $label)
                                    <option value="{{ $value }}" @selected(old('order_status', $order->order_status) === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="inline-flex w-full items-center justify-center rounded-full bg-slate-900 px-6 py-4 text-sm font-bold text-white transition hover:bg-slate-800 shadow-lg shadow-slate-900/10">
                        Update Status
                    </button>
                </form>
            </article>

            {{-- ── Detail Pembayaran ── --}}
            <article class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                <p class="text-[11px] font-bold uppercase tracking-[0.25em] text-slate-400">Pembayaran Terakhir</p>
                <h3 class="mt-2 text-2xl font-black tracking-tight text-slate-950">Log Transaksi</h3>

                @if ($order->payments->isNotEmpty())
                    @foreach ($order->payments as $payment)
                        <div class="mt-6 rounded-[1.75rem] border border-slate-100 bg-slate-50/50 p-6">
                            <div class="flex flex-wrap gap-2">
                                <x-admin.badge :value="$payment->status" :classes="match($payment->status) { 'paid' => 'bg-emerald-50 text-emerald-700 border border-emerald-100', 'pending' => 'bg-amber-50 text-amber-700 border border-amber-100', 'failed', 'expired', 'cancelled' => 'bg-rose-50 text-rose-700 border border-rose-100', default => 'bg-slate-100 text-slate-700 border border-slate-200' }" />
                                <span class="inline-flex items-center rounded-full border border-slate-200 bg-white px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-slate-600">
                                    {{ $payment->payment_type ?? $payment->method }}
                                </span>
                            </div>

                            <div class="mt-6 space-y-4">
                                <div class="flex justify-between text-xs">
                                    <span class="font-bold text-slate-400 uppercase tracking-wider">ID Transaksi</span>
                                    <span class="font-bold text-slate-900">{{ $payment->transaction_id ?: '-' }}</span>
                                </div>
                                <div class="flex justify-between text-xs">
                                    <span class="font-bold text-slate-400 uppercase tracking-wider">Status Fraud</span>
                                    <span class="font-bold text-slate-900">{{ $payment->fraud_status ?: '-' }}</span>
                                </div>
                                <div class="border-t border-slate-100 pt-4">
                                    <div class="flex justify-between">
                                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total</span>
                                        <span class="text-base font-black text-slate-950">{{ $payment->gross_amount_label }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="mt-6 rounded-[1.75rem] border border-dashed border-slate-200 bg-slate-50 p-10 text-center">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Belum ada data</p>
                    </div>
                @endif
            </article>

            {{-- ── Total Akhir ── --}}
            <article class="rounded-[2.5rem] border border-slate-900 bg-slate-950 p-8 text-white shadow-2xl shadow-slate-900/20">
                <p class="text-[11px] font-bold uppercase tracking-[0.3em] text-slate-500">Ringkasan Finansial</p>
                <div class="mt-8 space-y-4">
                    <div class="flex items-center justify-between text-sm">
                        <span class="font-medium text-slate-400">Subtotal</span>
                        <span class="font-bold text-slate-200">{{ $order->subtotal_label }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="font-medium text-slate-400">Ongkos Kirim</span>
                        <span class="font-bold text-slate-200">Rp{{ number_format((float) $order->shipping_cost, 0, ',', '.') }}</span>
                    </div>
                    <div class="my-4 border-t border-white/10 pt-4">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold uppercase tracking-[0.2em] text-amber-400">Total Akhir</span>
                            <span class="text-3xl font-black tracking-tight text-white">{{ $order->grand_total_label }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
