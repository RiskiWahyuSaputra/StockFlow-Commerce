@props([
    'product',
])

<article class="group overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-900/5">
    <a href="{{ route('products.show', $product['slug']) }}" class="block">
        <div class="relative aspect-[4/3] overflow-hidden p-5" style="{{ $product['cover_style'] }}">
            <div class="flex h-full flex-col justify-between rounded-[1.5rem] border border-white/40 bg-white/10 p-5 backdrop-blur-sm">
                <span class="inline-flex w-fit rounded-full bg-white/80 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.24em] text-slate-700">
                    {{ $product['tag'] }}
                </span>

                <div class="max-w-[14rem]">
                    <p class="text-sm font-medium text-slate-700/80">{{ $product['category'] }}</p>
                    <h3 class="mt-2 text-2xl font-black tracking-tight text-slate-950">{{ $product['name'] }}</h3>
                </div>
            </div>
        </div>

        <div class="space-y-4 p-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold text-slate-950">{{ $product['price_label'] }}</p>
                    <p class="mt-1 text-sm text-slate-500">{{ $product['stock_label'] }}</p>
                </div>
                <div class="rounded-full bg-slate-50 px-3 py-1 text-sm font-semibold text-slate-700">
                    {{ $product['rating'] }} / 5
                </div>
            </div>

            <p class="text-sm leading-7 text-slate-600">{{ $product['excerpt'] }}</p>

            <div class="flex items-center justify-between border-t border-slate-100 pt-4 text-sm font-semibold">
                <span class="text-slate-500">{{ $product['reviews'] }} reviews</span>
                <span class="text-brand-700 transition group-hover:text-brand-600">View details</span>
            </div>
        </div>
    </a>
</article>
