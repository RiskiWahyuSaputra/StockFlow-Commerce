@props([
    'value',
    'classes' => 'bg-slate-100 text-slate-700',
])

@php
    $normalizedValue = \Illuminate\Support\Str::of((string) $value)->lower()->trim()->value();
    $translatedValue = [
        'active' => 'aktif',
        'inactive' => 'nonaktif',
        'draft' => 'draft',
        'archived' => 'arsip',
        'pending' => 'menunggu',
        'paid' => 'dibayar',
        'processing' => 'diproses',
        'shipped' => 'dikirim',
        'completed' => 'selesai',
        'cancelled' => 'dibatalkan',
        'failed' => 'gagal',
        'expired' => 'kedaluwarsa',
        'refunded' => 'dikembalikan',
        'unpaid' => 'belum dibayar',
        'low stock' => 'stok menipis',
        'initial' => 'awal',
        'restock' => 'restok',
        'adjustment' => 'penyesuaian',
        'reserved' => 'reservasi',
        'deducted' => 'finalisasi',
        'released' => 'dilepas',
        'returned' => 'retur',
    ][$normalizedValue] ?? $value;
@endphp

<span {{ $attributes->class(['inline-flex rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em]', $classes]) }}>
    {{ $translatedValue }}
</span>
