@extends('layouts.storefront')

@section('title', 'Cart')

@section('content')
    <section class="grid gap-8 lg:grid-cols-[minmax(0,1.05fr)_minmax(360px,0.95fr)] lg:items-start">
        <div class="rounded-[2.2rem] border border-slate-200 bg-white p-8 shadow-sm">
            <x-frontend.section-heading
                eyebrow="Cart Review"
                title="A focused cart layout that keeps summary and line items readable."
                description="Layout cart ini cocok untuk quantity update, promo code, dan note pesanan tanpa terasa penuh."
            />

            <div class="mt-8 space-y-4">
                @foreach ($cart['items'] as $item)
                    <article class="flex flex-col gap-4 rounded-[1.8rem] border border-slate-200 p-5 sm:flex-row sm:items-center">
                        <div class="h-28 w-full rounded-[1.5rem] sm:w-28" style="{{ $item['cover_style'] }}"></div>

                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-medium text-slate-500">{{ $item['category'] }}</p>
                            <h2 class="mt-1 text-xl font-bold text-slate-950">{{ $item['name'] }}</h2>
                            <p class="mt-2 text-sm leading-7 text-slate-600">{{ $item['excerpt'] }}</p>
                        </div>

                        <div class="flex items-center justify-between gap-4 sm:flex-col sm:items-end">
                            <div class="rounded-full bg-slate-50 px-4 py-2 text-sm font-semibold text-slate-700">
                                Qty {{ $item['quantity'] }}
                            </div>
                            <p class="text-lg font-bold text-slate-950">{{ $item['line_total_label'] }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>

        <div class="space-y-6">
            <x-frontend.order-summary :summary="$cart" title="Cart Summary" />

            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-semibold text-slate-900">Promo / Notes</p>
                <div class="mt-4 rounded-3xl border border-dashed border-slate-200 bg-slate-50 p-4 text-sm leading-7 text-slate-500">
                    Area ini disiapkan untuk voucher, gift note, atau estimasi ongkir ketika backend cart sudah aktif.
                </div>
                <a href="{{ route('checkout.index') }}" class="mt-6 inline-flex w-full items-center justify-center rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                    Proceed to Checkout
                </a>
            </div>
        </div>
    </section>
@endsection
