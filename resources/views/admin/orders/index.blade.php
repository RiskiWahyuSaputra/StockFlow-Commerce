@extends('layouts.admin')

@section('title', 'Pesanan')
@section('heading', 'Manajemen Pesanan')

@section('content')
    <section class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-400">Antrian Pesanan</p>
                <h2 class="mt-2 text-2xl font-black tracking-tight text-slate-950">Pantau order dan payment status</h2>
            </div>

            <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-wrap gap-3">
                <input type="text" name="search" value="{{ $filters['search'] }}" placeholder="Nomor pesanan / pelanggan" class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-slate-400 focus:outline-none focus:ring-0">
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
        </div>

        <div class="mt-6 overflow-hidden rounded-[1.6rem] border border-slate-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-left text-slate-500">
                        <tr>
                            <th class="px-4 py-4 font-semibold">Pesanan</th>
                            <th class="px-4 py-4 font-semibold">Pelanggan</th>
                            <th class="px-4 py-4 font-semibold">Total</th>
                            <th class="px-4 py-4 font-semibold">Status Pesanan</th>
                            <th class="px-4 py-4 font-semibold">Pembayaran</th>
                            <th class="px-4 py-4 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($orders as $order)
                            <tr>
                                <td class="px-4 py-4">
                                    <p class="font-semibold text-slate-900">{{ $order->order_number }}</p>
                                    <p class="mt-1 text-xs text-slate-500">{{ $order->placed_at?->format('d M Y H:i') }}</p>
                                </td>
                                <td class="px-4 py-4">
                                    <p class="font-medium text-slate-900">{{ $order->customer_name }}</p>
                                    <p class="mt-1 text-xs text-slate-500">{{ $order->customer_email }}</p>
                                </td>
                                <td class="px-4 py-4 font-semibold text-slate-900">{{ $order->grand_total_label }}</td>
                                <td class="px-4 py-4">
                                    <x-admin.badge :value="$order->order_status" :classes="match($order->order_status) { 'paid' => 'bg-emerald-50 text-emerald-700', 'processing', 'shipped' => 'bg-sky-50 text-sky-700', 'completed' => 'bg-slate-900 text-white', 'cancelled', 'refunded' => 'bg-rose-50 text-rose-700', default => 'bg-amber-50 text-amber-700' }" />
                                </td>
                                <td class="px-4 py-4">
                                    <div class="space-y-2">
                                        <x-admin.badge :value="$order->payment_status" :classes="match($order->payment_status) { 'paid' => 'bg-emerald-50 text-emerald-700', 'pending' => 'bg-amber-50 text-amber-700', 'failed', 'expired' => 'bg-rose-50 text-rose-700', 'refunded' => 'bg-slate-100 text-slate-700', default => 'bg-slate-100 text-slate-700' }" />
                                        @if ($order->latestPayment)
                                            <p class="text-xs text-slate-500">{{ $order->latestPayment->payment_type ?? $order->latestPayment->method }}</p>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="rounded-full border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 transition hover:border-slate-300 hover:text-slate-900">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-slate-500">Belum ada order yang tersimpan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $orders->onEachSide(1)->links() }}
        </div>
    </section>
@endsection
