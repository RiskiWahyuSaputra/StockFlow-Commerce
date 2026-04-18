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
@endphp

<span {{ $attributes->class([$toneClasses, $sizeClasses, 'inline-flex items-center rounded-full font-semibold uppercase tracking-[0.22em] ring-1']) }}>
    {{ $label }}
</span>
