@extends('layouts.storefront')

@section('title', 'Checkout')

@section('content')
    <section class="grid gap-8 lg:grid-cols-[minmax(0,1.05fr)_minmax(360px,0.95fr)] lg:items-start">
        <div class="space-y-6">
            <div class="rounded-[2.2rem] border border-slate-200 bg-white p-8 shadow-sm">
                <x-frontend.section-heading
                    eyebrow="Checkout"
                    title="Designed for a calm final step before payment."
                    description="Halaman ini sudah menyiapkan pola visual untuk alamat, pengiriman, payment method, dan order summary di samping."
                />

                <div class="mt-8 grid gap-6">
                    <section class="rounded-[1.8rem] border border-slate-200 bg-slate-50 p-6">
                        <p class="text-sm font-semibold text-slate-900">Shipping Address</p>
                        <div class="mt-4 grid gap-4 md:grid-cols-2">
                            @foreach ([
                                ['label' => 'Full Name', 'value' => 'Riski Wahyu'],
                                ['label' => 'Phone', 'value' => '0812-3456-7890'],
                                ['label' => 'City', 'value' => 'Bandar Lampung'],
                                ['label' => 'Postal Code', 'value' => '35141'],
                            ] as $field)
                                <div class="rounded-2xl border border-slate-200 bg-white px-4 py-4">
                                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400">{{ $field['label'] }}</p>
                                    <p class="mt-2 text-sm font-medium text-slate-800">{{ $field['value'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    <section class="rounded-[1.8rem] border border-slate-200 bg-slate-50 p-6">
                        <p class="text-sm font-semibold text-slate-900">Shipping Method</p>
                        <div class="mt-4 space-y-3">
                            @foreach ($checkout['shipping_methods'] as $method)
                                <div @class([
                                    'flex items-center justify-between rounded-2xl border px-4 py-4 text-sm transition',
                                    'border-slate-900 bg-white shadow-sm' => $method['active'],
                                    'border-slate-200 bg-white' => ! $method['active'],
                                ])>
                                    <div>
                                        <p class="font-semibold text-slate-900">{{ $method['name'] }}</p>
                                        <p class="mt-1 text-slate-500">{{ $method['eta'] }}</p>
                                    </div>
                                    <p class="font-semibold text-slate-900">{{ $method['price'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    <section class="rounded-[1.8rem] border border-slate-200 bg-slate-50 p-6">
                        <p class="text-sm font-semibold text-slate-900">Payment Method</p>
                        <div class="mt-4 space-y-3">
                            @foreach ($checkout['payment_methods'] as $method)
                                <div @class([
                                    'rounded-2xl border px-4 py-4 transition',
                                    'border-brand-200 bg-brand-50/60' => $method['active'],
                                    'border-slate-200 bg-white' => ! $method['active'],
                                ])>
                                    <div class="flex items-center justify-between gap-4">
                                        <div>
                                            <p class="font-semibold text-slate-900">{{ $method['name'] }}</p>
                                            <p class="mt-1 text-sm text-slate-500">{{ $method['detail'] }}</p>
                                        </div>
                                        @if ($method['active'])
                                            <span class="rounded-full bg-white px-3 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-brand-700">Selected</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <x-frontend.order-summary :summary="$checkout['summary']" title="Final Summary" />

            <div class="rounded-[2rem] border border-slate-200 bg-slate-950 p-6 text-white shadow-xl shadow-slate-900/10">
                <p class="text-sm font-semibold uppercase tracking-[0.28em] text-slate-400">Next Integration</p>
                <h3 class="mt-4 text-2xl font-black tracking-tight">Midtrans payment flow can plug into this screen cleanly.</h3>
                <p class="mt-4 text-sm leading-7 text-slate-300">
                    Tombol final nanti bisa diarahkan ke Snap token response dan callback status pembayaran tanpa perlu merombak layout utama.
                </p>
                <button type="button" class="mt-6 inline-flex w-full items-center justify-center rounded-full bg-white px-5 py-3 text-sm font-semibold text-slate-950 transition hover:bg-slate-100">
                    Pay with Midtrans Preview
                </button>
            </div>
        </div>
    </section>
@endsection
