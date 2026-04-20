@props([
    'label',
    'tone' => 'neutral',
    'size' => 'sm',
])

@php
    $toneClasses = match ($tone) {
        'success' => 'bg-emerald-50 text-emerald-700 ring-emerald-100',
        'warning' => 'bg-amber-50 text-amber-700 ring-amber-100',
        'danger' => 'bg-rose-50 text-rose-700 ring-rose-100',
        'info' => 'bg-sky-50 text-sky-700 ring-sky-100',
        default => 'bg-slate-100 text-slate-700 ring-slate-200',
    };

    $sizeClasses = match ($size) {
        'md' => 'px-4 py-2 text-sm',
        default => 'px-3 py-1.5 text-xs',
    };

    $normalizedLabel = \Illuminate\Support\Str::of((string) $label)->lower()->trim()->value();
    $translatedLabel = [
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
        'payment pending' => 'pembayaran menunggu',
        'payment unpaid' => 'pembayaran belum dibayar',
        'payment paid' => 'pembayaran dibayar',
        'payment failed' => 'pembayaran gagal',
        'payment expired' => 'pembayaran kedaluwarsa',
        'payment refunded' => 'pembayaran dikembalikan',
        'order pending' => 'pesanan menunggu',
        'order paid' => 'pesanan dibayar',
        'order processing' => 'pesanan diproses',
        'order shipped' => 'pesanan dikirim',
        'order completed' => 'pesanan selesai',
        'order cancelled' => 'pesanan dibatalkan',
        'order refunded' => 'pesanan dikembalikan',
    ][$normalizedLabel] ?? $label;
@endphp

<span {{ $attributes->class([$toneClasses, $sizeClasses, 'inline-flex items-center rounded-full font-semibold uppercase tracking-[0.22em] ring-1']) }}>
    {{ $translatedLabel }}
</span>
