@props([
    'summary',
    'title' => 'Order Summary',
])

<aside class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
    <h3 class="text-lg font-bold text-slate-950">{{ $title }}</h3>

    <div class="mt-6 space-y-4">
        @foreach ($summary['items'] as $item)
            <div class="flex items-center gap-4 rounded-3xl bg-slate-50 p-4">
                <div class="h-18 w-18 shrink-0 rounded-2xl" style="{{ $item['cover_style'] }}"></div>
                <div class="min-w-0 flex-1">
                    <p class="truncate font-semibold text-slate-900">{{ $item['name'] }}</p>
                    <p class="mt-1 text-sm text-slate-500">{{ $item['quantity'] }} x {{ $item['price_label'] }}</p>
                </div>
                <p class="text-sm font-semibold text-slate-900">{{ $item['line_total_label'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="mt-6 space-y-3 border-t border-slate-100 pt-6 text-sm">
        <div class="flex items-center justify-between text-slate-600">
            <span>Subtotal</span>
            <span>{{ $summary['subtotal_label'] }}</span>
        </div>
        <div class="flex items-center justify-between text-slate-600">
            <span>Shipping</span>
            <span>{{ $summary['shipping_label'] }}</span>
        </div>
        <div class="flex items-center justify-between text-slate-600">
            <span>Tax</span>
            <span>{{ $summary['tax_label'] }}</span>
        </div>
    </div>

    <div class="mt-6 flex items-center justify-between rounded-3xl bg-slate-950 px-5 py-4 text-white">
        <span class="text-sm font-medium text-slate-300">Grand Total</span>
        <span class="text-xl font-black tracking-tight">{{ $summary['total_label'] }}</span>
    </div>
</aside>
