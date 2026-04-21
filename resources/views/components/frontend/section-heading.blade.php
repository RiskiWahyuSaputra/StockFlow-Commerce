@props([
    'eyebrow' => null,
    'title' => null,
    'description' => null,
    'link' => null,
    'linkLabel' => null,
    'dark' => null,
])

@php
    $isDark = $dark ?? (request()->routeIs('home') || request()->routeIs('products.*'));
@endphp

<div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div class="max-w-2xl">
        @if ($eyebrow)
            <p @class([
                'text-[10px] font-bold uppercase tracking-[0.35em]',
                'text-amber-400' => $isDark,
                'text-slate-400' => ! $isDark,
            ])>{{ $eyebrow }}</p>
        @endif

        @if ($title)
            <h2 @class([
                'mt-4 text-3xl font-black tracking-tight sm:text-4xl',
                'text-white' => $isDark,
                'text-slate-950' => ! $isDark,
            ])>{{ $title }}</h2>
        @endif

        @if ($description)
            <p @class([
                'mt-4 text-sm leading-8',
                'text-slate-400' => $isDark,
                'text-slate-600' => ! $isDark,
            ])>{{ $description }}</p>
        @endif
    </div>

    @if ($link && $linkLabel)
        <a href="{{ $link }}" @class([
            'inline-flex rounded-full border px-5 py-2.5 text-sm font-bold transition shadow-sm',
            'border-white/10 bg-white/5 text-white hover:bg-white/10' => $isDark,
            'border-slate-200 bg-white text-slate-700 hover:border-slate-300 hover:text-slate-900' => ! $isDark,
        ])>
            {{ $linkLabel }}
        </a>
    @endif
</div>
