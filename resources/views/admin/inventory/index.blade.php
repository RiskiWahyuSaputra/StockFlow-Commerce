@extends('layouts.admin')

@section('title', 'Log Inventaris')
@section('heading', 'Pelacakan Inventaris')

@section('content')
    <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <article class="rounded-[1.8rem] border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-400">Total Log</p>
            <p class="mt-4 text-3xl font-black tracking-tight text-slate-950">{{ number_format($summary['total_logs']) }}</p>
            <p class="mt-2 text-sm text-slate-500">Semua histori pergerakan stok yang tersimpan.</p>
        </article>

        <article class="rounded-[1.8rem] border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-400">Aktivitas Restok</p>
            <p class="mt-4 text-3xl font-black tracking-tight text-slate-950">{{ number_format($summary['restock_logs']) }}</p>
            <p class="mt-2 text-sm text-slate-500">Penambahan stok dari admin/manual restock.</p>
        </article>

        <article class="rounded-[1.8rem] border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-400">Aktivitas Reservasi</p>
            <p class="mt-4 text-3xl font-black tracking-tight text-slate-950">{{ number_format($summary['reserved_logs']) }}</p>
            <p class="mt-2 text-sm text-slate-500">Reservasi stok ketika order dibuat dari checkout.</p>
        </article>

        <article class="rounded-[1.8rem] border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-400">Produk Stok Menipis</p>
            <p class="mt-4 text-3xl font-black tracking-tight text-slate-950">{{ number_format($summary['low_stock_products']) }}</p>
            <p class="mt-2 text-sm text-slate-500">Produk yang stoknya sudah menyentuh threshold.</p>
        </article>
    </section>

    <section class="mt-6 grid gap-6 xl:grid-cols-[minmax(0,1.2fr)_minmax(360px,0.8fr)]">
        <article class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-400">Buku Besar Inventaris</p>
                    <h2 class="mt-2 text-2xl font-black tracking-tight text-slate-950">Riwayat pergerakan stok yang bisa diaudit.</h2>
                </div>

                <form method="GET" action="{{ route('admin.inventory.index') }}" class="grid gap-3 sm:grid-cols-[minmax(0,1fr)_200px_auto]">
                    <input
                        type="text"
                        name="search"
                        value="{{ $filters['search'] }}"
                        placeholder="Cari produk / SKU"
                        class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-slate-400 focus:outline-none focus:ring-0"
                    >

                    <select
                        name="type"
                        class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-slate-400 focus:outline-none focus:ring-0"
                    >
                        <option value="">Semua tipe</option>
                        @foreach ($typeOptions as $value => $label)
                            <option value="{{ $value }}" @selected($filters['type'] === $value)>{{ $label }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                        Filter
                    </button>
                </form>
            </div>

            <div class="mt-6 overflow-hidden rounded-[1.6rem] border border-slate-200">
                <div class="overflow-x-auto">
                    <table class="w-full table-fixed divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-50">
                            <tr class="text-left text-slate-500">
                                <th class="px-4 py-4 font-semibold">Produk</th>
                                <th class="px-4 py-4 font-semibold">Tipe</th>
                                <th class="px-4 py-4 font-semibold">Sebelum</th>
                                <th class="px-4 py-4 font-semibold">Perubahan</th>
                                <th class="px-4 py-4 font-semibold">Sesudah</th>
                                <th class="px-4 py-4 font-semibold">Referensi</th>
                                <th class="px-4 py-4 font-semibold">Pelaku</th>
                                <th class="px-4 py-4 font-semibold">Waktu</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse ($logs as $log)
                                @php
                                    $typeClasses = match ($log->type) {
                                        \App\Models\InventoryLog::TYPE_RESTOCK, \App\Models\InventoryLog::TYPE_RELEASED, \App\Models\InventoryLog::TYPE_RETURNED => 'bg-emerald-50 text-emerald-700',
                                        \App\Models\InventoryLog::TYPE_RESERVED, \App\Models\InventoryLog::TYPE_DEDUCTED => 'bg-amber-50 text-amber-700',
                                        default => 'bg-slate-100 text-slate-700',
                                    };

                                    $changeClasses = ($log->quantity_changed ?? $log->quantity_change ?? 0) >= 0
                                        ? 'text-emerald-600'
                                        : 'text-rose-600';
                                @endphp

                                <tr class="align-top">
                                    <td class="px-4 py-4">
                                        <p class="font-semibold text-slate-900">{{ $log->product?->name ?? 'Produk dihapus' }}</p>
                                        <p class="mt-1 text-xs text-slate-500">{{ $log->product?->sku ?? '-' }}</p>
                                        @if ($log->display_note)
                                            <p class="mt-2 max-w-xs text-xs leading-6 text-slate-500">{{ $log->display_note }}</p>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4">
                                        <span @class(['inline-flex rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em]', $typeClasses])>
                                            {{ $log->type }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 font-semibold text-slate-700">{{ $log->quantity_before }}</td>
                                    <td class="px-4 py-4 font-semibold {{ $changeClasses }}">{{ $log->quantity_changed_label }}</td>
                                    <td class="px-4 py-4 font-semibold text-slate-900">{{ $log->quantity_after }}</td>
                                    <td class="px-4 py-4 text-slate-500">
                                        <p>{{ $log->reference_type ?? '-' }}</p>
                                        <p class="mt-1 text-xs">{{ $log->reference ?? ($log->reference_id ? '#'.$log->reference_id : '-') }}</p>
                                    </td>
                                    <td class="px-4 py-4 text-slate-500">
                                        {{ $log->user?->name ?? 'Sistem' }}
                                    </td>
                                    <td class="px-4 py-4 text-slate-500">
                                        {{ $log->created_at?->format('d M Y H:i') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-10 text-center text-slate-500">
                                        Belum ada inventory log yang tersimpan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6">
                {{ $logs->onEachSide(1)->links() }}
            </div>
        </article>

        <div class="space-y-6">
            <article class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-400">Restok Manual</p>
                <h3 class="mt-2 text-2xl font-black tracking-tight text-slate-950">Tambahkan stok tanpa mengubah harga produk.</h3>

                <form method="POST" action="{{ route('admin.inventory.restock') }}" class="mt-6 space-y-4">
                    @csrf

                    <div>
                        <label for="restock_product_id" class="text-sm font-semibold text-slate-900">Produk</label>
                        <select id="restock_product_id" name="product_id" class="mt-2 block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-slate-400 focus:outline-none focus:ring-0">
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->sku }}) - stock {{ $product->stock }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="restock_quantity" class="text-sm font-semibold text-slate-900">Jumlah</label>
                        <input id="restock_quantity" type="number" min="1" name="quantity" value="1" class="mt-2 block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-slate-400 focus:outline-none focus:ring-0">
                    </div>

                    <div>
                        <label for="restock_note" class="text-sm font-semibold text-slate-900">Catatan</label>
                        <textarea id="restock_note" name="note" rows="3" class="mt-2 block w-full rounded-[1.4rem] border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-slate-400 focus:outline-none focus:ring-0" placeholder="Contoh: barang datang dari supplier batch April"></textarea>
                    </div>

                    <button type="submit" class="inline-flex w-full items-center justify-center rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                        Simpan Restock
                    </button>
                </form>
            </article>

            <article class="rounded-[2rem] border border-slate-200 bg-slate-950 p-6 text-white shadow-xl shadow-slate-900/10">
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-400">Sinkronisasi Stok</p>
                <h3 class="mt-2 text-2xl font-black tracking-tight">Sesuaikan stok aktual saat ada audit gudang.</h3>

                <form method="POST" action="{{ route('admin.inventory.sync-stock') }}" class="mt-6 space-y-4">
                    @csrf

                    <div>
                        <label for="sync_product_id" class="text-sm font-semibold text-white">Produk</label>
                        <select id="sync_product_id" name="product_id" class="mt-2 block w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white focus:border-white/30 focus:outline-none focus:ring-0">
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" class="text-slate-900">{{ $product->name }} ({{ $product->sku }}) - stock {{ $product->stock }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="sync_stock" class="text-sm font-semibold text-white">Target Stok</label>
                        <input id="sync_stock" type="number" min="0" name="stock" value="0" class="mt-2 block w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white placeholder:text-slate-400 focus:border-white/30 focus:outline-none focus:ring-0">
                    </div>

                    <div>
                        <label for="sync_note" class="text-sm font-semibold text-white">Catatan</label>
                        <textarea id="sync_note" name="note" rows="3" class="mt-2 block w-full rounded-[1.4rem] border border-white/10 bg-white/5 px-4 py-3 text-sm text-white placeholder:text-slate-400 focus:border-white/30 focus:outline-none focus:ring-0" placeholder="Contoh: penyesuaian hasil stock opname"></textarea>
                    </div>

                    <button type="submit" class="inline-flex w-full items-center justify-center rounded-full bg-white px-5 py-3 text-sm font-semibold text-slate-950 transition hover:bg-slate-100">
                        Sinkronkan Stok
                    </button>
                </form>
            </article>
        </div>
    </section>
@endsection
