@props([
    'label',
    'value',
])

<article class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-400">{{ $label }}</p>
    <p class="mt-4 text-2xl font-black tracking-tight text-slate-950">{{ $value }}</p>
</article>
