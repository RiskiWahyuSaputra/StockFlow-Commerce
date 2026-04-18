@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('heading', 'Admin Dashboard')

@section('content')
    <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        @foreach ($stats as $stat)
            <x-admin.stat-card
                :label="$stat['label']"
                :value="$stat['value']"
                :description="$stat['delta']"
            />
        @endforeach
    </section>

    <section class="mt-6 grid gap-6 xl:grid-cols-[minmax(0,1.15fr)_minmax(360px,0.85fr)]">
        <article class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-400">Recent Orders</p>
                    <h2 class="mt-2 text-2xl font-black tracking-tight text-slate-950">Ringkasan order terbaru</h2>
                </div>

                <a href="{{ route('admin.orders.index') }}" class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:text-slate-900">
                    Lihat Semua
                </a>
            </div>

            <div class="mt-6 overflow-hidden rounded-[1.6rem] border border-slate-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-50 text-left text-slate-500">
                            <tr>
                                <th class="px-4 py-4 font-semibold">Order</th>
                                <th class="px-4 py-4 font-semibold">Customer</th>
                                <th class="px-4 py-4 font-semibold">Total</th>
                                <th class="px-4 py-4 font-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse ($recentOrders as $order)
                                <tr>
                                    <td class="px-4 py-4">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="font-semibold text-slate-900 transition hover:text-slate-700">
                                            {{ $order->order_number }}
                                        </a>
                                        <p class="mt-1 text-xs text-slate-500">{{ $order->placed_at?->format('d M Y H:i') }}</p>
                                    </td>
                                    <td class="px-4 py-4 text-slate-600">{{ $order->customer_name }}</td>
                                    <td class="px-4 py-4 font-semibold text-slate-900">{{ $order->grand_total_label }}</td>
                                    <td class="px-4 py-4">
                                        <div class="flex flex-wrap gap-2">
                                            <x-admin.badge :value="$order->order_status" classes="bg-slate-100 text-slate-700" />
                                            <x-admin.badge :value="$order->payment_status" classes="bg-amber-50 text-amber-700" />
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-10 text-center text-slate-500">Belum ada order yang tersimpan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </article>

        <article class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-400">Low Stock Watch</p>
                    <h2 class="mt-2 text-2xl font-black tracking-tight text-slate-950">Produk yang perlu perhatian</h2>
                </div>

                <a href="{{ route('admin.inventory.index') }}" class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:text-slate-900">
                    Inventory
                </a>
            </div>

            <div class="mt-6 space-y-3">
                @forelse ($lowStockProducts as $product)
                    <div class="flex items-center justify-between rounded-3xl border border-slate-200 px-4 py-4">
                        <div>
                            <p class="font-semibold text-slate-900">{{ $product->name }}</p>
                            <p class="mt-1 text-sm text-slate-500">{{ $product->sku }}</p>
                        </div>
                        <div class="text-right">
                            <div class="rounded-full bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-700">
                                {{ $product->stock }} / {{ $product->low_stock_threshold }}
                            </div>
                            <p class="mt-2 text-xs text-slate-400">{{ $product->status }}</p>
                        </div>
                    </div>
                @empty
                    <div class="rounded-3xl border border-dashed border-slate-200 bg-slate-50 px-5 py-8 text-center text-sm text-slate-500">
                        Semua produk masih berada di atas batas low stock.
                    </div>
                @endforelse
            </div>
        </article>
    </section>
@endsection
