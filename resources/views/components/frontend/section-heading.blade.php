@props([
    'eyebrow' => null,
    'title' => null,
    'description' => null,
    'link' => null,
    'linkLabel' => null,
])

<div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div class="max-w-2xl">
        @if ($eyebrow)
            <p class="text-xs font-semibold uppercase tracking-[0.35em] text-slate-400">{{ $eyebrow }}</p>
        @endif

        @if ($title)
            <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-950">{{ $title }}</h2>
        @endif

        @if ($description)
            <p class="mt-3 text-sm leading-7 text-slate-600">{{ $description }}</p>
        @endif
    </div>

    @if ($link && $linkLabel)
        <a href="{{ $link }}" class="inline-flex rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:text-slate-900">
            {{ $linkLabel }}
        </a>
    @endif
</div>
