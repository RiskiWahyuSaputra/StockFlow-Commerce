@props([
    'product',
    'variant' => 'card',
    'seed' => 0,
])

@php
    $isModel = $product instanceof \App\Models\Product;
    $name = $isModel ? $product->name : $product['name'];
    $categoryName = $isModel ? ($product->primary_category_name ?? 'Tanpa Kategori') : ($product['category'] ?? 'Katalog');
    $themeKey = \Illuminate\Support\Str::slug($isModel ? ($product->category?->slug ?? $categoryName) : $categoryName);

    $palettes = match (true) {
        str_contains($themeKey, 'smart') => [
            'background: linear-gradient(135deg, #0f766e 0%, #2dd4bf 52%, #ecfeff 100%);',
            'background: linear-gradient(135deg, #115e59 0%, #14b8a6 55%, #ccfbf1 100%);',
            'background: linear-gradient(135deg, #134e4a 0%, #5eead4 55%, #f0fdfa 100%);',
        ],
        str_contains($themeKey, 'laptop') || str_contains($themeKey, 'workstation') => [
            'background: linear-gradient(135deg, #0f172a 0%, #334155 50%, #e2e8f0 100%);',
            'background: linear-gradient(135deg, #111827 0%, #475569 55%, #f8fafc 100%);',
            'background: linear-gradient(135deg, #020617 0%, #64748b 55%, #cbd5e1 100%);',
        ],
        str_contains($themeKey, 'audio') || str_contains($themeKey, 'access') => [
            'background: linear-gradient(135deg, #c2410c 0%, #fb923c 52%, #fff7ed 100%);',
            'background: linear-gradient(135deg, #ea580c 0%, #fdba74 55%, #ffedd5 100%);',
            'background: linear-gradient(135deg, #9a3412 0%, #fb7185 55%, #fff1f2 100%);',
        ],
        str_contains($themeKey, 'home') || str_contains($themeKey, 'kitchen') || str_contains($themeKey, 'light') => [
            'background: linear-gradient(135deg, #166534 0%, #4ade80 48%, #f0fdf4 100%);',
            'background: linear-gradient(135deg, #15803d 0%, #86efac 55%, #dcfce7 100%);',
            'background: linear-gradient(135deg, #14532d 0%, #22c55e 55%, #f0fdf4 100%);',
        ],
        default => [
            'background: linear-gradient(135deg, #312e81 0%, #818cf8 52%, #eef2ff 100%);',
            'background: linear-gradient(135deg, #1e293b 0%, #94a3b8 55%, #f8fafc 100%);',
            'background: linear-gradient(135deg, #0f172a 0%, #6366f1 55%, #e0e7ff 100%);',
        ],
    };

    $style = $palettes[$seed % count($palettes)];
    $initials = \Illuminate\Support\Str::of($name)
        ->explode(' ')
        ->filter()
        ->take(2)
        ->map(fn (string $segment): string => \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($segment, 0, 1)))
        ->implode('');

    $wrapperClasses = match ($variant) {
        'hero' => 'aspect-[5/4] rounded-[2rem] p-6 sm:p-8',
        'thumb' => 'aspect-[4/3] rounded-[1.6rem] p-4',
        default => 'aspect-[4/3] p-5',
    };

    $panelClasses = match ($variant) {
        'hero' => 'rounded-[1.7rem] border border-white/30 bg-white/12 p-6 backdrop-blur-sm',
        'thumb' => 'rounded-[1.3rem] border border-white/35 bg-white/10 p-4 backdrop-blur-sm',
        default => 'rounded-[1.5rem] border border-white/40 bg-white/10 p-5 backdrop-blur-sm',
    };

    $headingSize = match ($variant) {
        'hero' => 'text-4xl sm:text-5xl',
        'thumb' => 'text-2xl',
        default => 'text-3xl',
    };

    $label = $variant === 'hero' ? 'Pratinjau Produk' : $categoryName;
@endphp

<div {{ $attributes->class([$wrapperClasses, 'relative overflow-hidden border border-slate-200 shadow-sm']) }} style="{{ $style }}">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.28),transparent_35%)]"></div>

    <div class="{{ $panelClasses }} relative flex h-full flex-col justify-between">
        <span class="inline-flex w-fit rounded-full bg-white/80 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.24em] text-slate-700">
            {{ $label }}
        </span>

        <div class="flex items-end justify-between gap-4">
            <div class="max-w-[14rem]">
                <p class="text-sm font-medium text-slate-800/80">{{ $categoryName }}</p>
                <p class="mt-2 text-sm leading-6 text-slate-900/75">{{ \Illuminate\Support\Str::limit($name, 48) }}</p>
            </div>

            <span class="{{ $headingSize }} font-black tracking-[0.18em] text-slate-950/90">
                {{ $initials }}
            </span>
        </div>
    </div>
</div>
