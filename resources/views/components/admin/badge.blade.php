@props([
    'value',
    'classes' => 'bg-slate-100 text-slate-700',
])

<span {{ $attributes->class(['inline-flex rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em]', $classes]) }}>
    {{ $value }}
</span>
