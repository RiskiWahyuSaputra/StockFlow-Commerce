@props([
    'label',
    'value',
    'description' => null,
])

<article class="rounded-[1.8rem] border border-slate-200 bg-white p-6 shadow-sm">
    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-400">{{ $label }}</p>
    <p class="mt-4 text-3xl font-black tracking-tight text-slate-950">{{ $value }}</p>

    @if ($description)
        <p class="mt-2 text-sm text-slate-500">{{ $description }}</p>
    @endif
</article>
