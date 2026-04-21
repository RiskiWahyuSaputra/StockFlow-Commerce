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

    $isDark = request()->routeIs('home') || request()->routeIs('products.*');

    $palettes = match (true) {
        str_contains($themeKey, 'smart') => [
            'background: linear-gradient(135deg, #0f766e 0%, #0d9488 52%, #115e59 100%);',
            'background: linear-gradient(135deg, #115e59 0%, #14b8a6 55%, #0f766e 100%);',
        ],
        str_contains($themeKey, 'laptop') || str_contains($themeKey, 'workstation') => [
            'background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);',
            'background: linear-gradient(135deg, #111827 0%, #334155 55%, #111827 100%);',
        ],
        str_contains($themeKey, 'audio') || str_contains($themeKey, 'access') => [
            'background: linear-gradient(135deg, #7c2d12 0%, #c2410c 52%, #7c2d12 100%);',
            'background: linear-gradient(135deg, #9a3412 0%, #ea580c 55%, #9a3412 100%);',
        ],
        default => [
            'background: linear-gradient(135deg, #1e1b4b 0%, #3730a3 52%, #1e1b4b 100%);',
            'background: linear-gradient(135deg, #111827 0%, #1f2937 55%, #111827 100%);',
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
        'hero' => 'aspect-[5/4] rounded-[2.5rem] p-6 sm:p-10',
        'thumb' => 'aspect-[4/3] rounded-[1.8rem] p-5',
        default => 'aspect-[4/3] p-6',
    };

    $panelClasses = match ($variant) {
        'hero' => 'rounded-[2rem] border border-white/10 bg-white/5 p-8 backdrop-blur-md',
        'thumb' => 'rounded-[1.4rem] border border-white/15 bg-white/8 p-5 backdrop-blur-md',
        default => 'rounded-[1.6rem] border border-white/20 bg-white/10 p-6 backdrop-blur-md',
    };

    $headingSize = match ($variant) {
        'hero' => 'text-5xl sm:text-6xl',
        'thumb' => 'text-2xl',
        default => 'text-3xl',
    };

    $label = $variant === 'hero' ? 'Premium Edit' : $categoryName;
    $image = null;

    if ($isModel) {
        if ($product->relationLoaded('images')) {
            $image = $product->images->firstWhere('is_primary', true) ?? $product->images->first();
        } elseif ($product->relationLoaded('primaryImage')) {
            $image = $product->primaryImage;
        } elseif ($product->primary_image_url) {
            $image = (object) [
                'image_url' => $product->primary_image_url,
                'alt_text' => $name,
            ];
        }
    } else {
        $image = ! empty($product['image_url'] ?? null)
            ? (object) [
                'image_url' => $product['image_url'],
                'alt_text' => $name,
            ]
            : null;
    }

    $imageUrl = $image?->image_url;
    $imageAlt = $image?->alt_text ?: $name;
@endphp

<div {{ $attributes->class([$wrapperClasses, 'relative overflow-hidden border border-white/5 shadow-2xl']) }} style="{{ $style }}">
    @if ($imageUrl)
        <div class="absolute inset-0 bg-black/20"></div>
        <img src="{{ $imageUrl }}" alt="{{ $imageAlt }}" class="absolute inset-0 h-full w-full object-contain mix-blend-lighten p-8">
        <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>

        <div class="absolute inset-x-0 bottom-0 p-6 sm:p-8">
            <div class="max-w-fit rounded-[1.5rem] border border-white/10 bg-black/40 px-5 py-4 text-white shadow-2xl backdrop-blur-md">
                <span class="inline-flex rounded-full bg-amber-400 px-3 py-1 text-[9px] font-bold uppercase tracking-[0.25em] text-black">
                    {{ $label }}
                </span>
                <p class="mt-4 text-[10px] font-bold uppercase tracking-[0.15em] text-slate-400">{{ $categoryName }}</p>
                <p class="mt-2 text-base font-black leading-tight text-white">{{ \Illuminate\Support\Str::limit($name, 48) }}</p>
            </div>
        </div>
    @else
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.1),transparent_40%)]"></div>

        <div class="{{ $panelClasses }} relative flex h-full flex-col justify-between overflow-hidden">
            <div class="absolute -right-4 -top-4 opacity-10">
                 <span class="text-9xl font-black tracking-tighter text-white">
                    {{ $initials }}
                </span>
            </div>

            <span class="inline-flex w-fit rounded-full bg-white/10 px-4 py-1.5 text-[10px] font-bold uppercase tracking-[0.2em] text-amber-400 border border-white/10">
                {{ $label }}
            </span>

            <div class="flex items-end justify-between gap-4">
                <div class="max-w-[15rem]">
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500">{{ $categoryName }}</p>
                    <p class="mt-3 text-lg font-black leading-tight text-white">{{ \Illuminate\Support\Str::limit($name, 48) }}</p>
                </div>

                <span class="{{ $headingSize }} font-black tracking-[0.1em] text-white/20">
                    {{ $initials }}
                </span>
            </div>
        </div>
    @endif
</div>
