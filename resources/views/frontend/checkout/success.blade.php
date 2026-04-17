@extends('layouts.storefront')

@section('title', 'Order Payment')

@section('content')
    @php
        $payment = $order->latestPayment;
        $paymentStatus = $payment?->status ?? 'unpaid';
        $paymentType = $payment?->payment_type ?? 'snap';
        $hasSnapToken = filled($payment?->snap_token);
        $canPreparePayment = ! $order->is_paid && $order->order_status === \App\Models\Order::STATUS_PENDING;
        $canLaunchSnap = $canPreparePayment && $hasSnapToken && filled(config('midtrans.client_key'));

        $orderStatusClasses = match ($order->order_status) {
            \App\Models\Order::STATUS_PAID => 'bg-emerald-50 text-emerald-700',
            \App\Models\Order::STATUS_CANCELLED => 'bg-rose-50 text-rose-700',
            \App\Models\Order::STATUS_REFUNDED => 'bg-amber-50 text-amber-700',
            default => 'bg-slate-100 text-slate-700',
        };

        $paymentStatusClasses = match ($paymentStatus) {
            \App\Models\Payment::STATUS_PAID => 'bg-emerald-50 text-emerald-700',
            \App\Models\Payment::STATUS_PENDING => 'bg-amber-50 text-amber-700',
            \App\Models\Payment::STATUS_FAILED, \App\Models\Payment::STATUS_CANCELLED, \App\Models\Payment::STATUS_EXPIRED => 'bg-rose-50 text-rose-700',
            \App\Models\Payment::STATUS_REFUNDED => 'bg-slate-100 text-slate-700',
            default => 'bg-slate-100 text-slate-700',
        };
    @endphp

    <section class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_minmax(360px,0.9fr)] lg:items-start">
        <div class="rounded-[2.2rem] border border-slate-200 bg-white p-8 shadow-sm">
            <div class="flex flex-wrap items-center gap-3">
                <span @class(['inline-flex rounded-full px-4 py-2 text-sm font-semibold', $orderStatusClasses])>
                    Order {{ strtoupper($order->order_status) }}
                </span>

                <span @class(['inline-flex rounded-full px-4 py-2 text-sm font-semibold', $paymentStatusClasses])>
                    Payment {{ strtoupper($order->payment_status) }}
                </span>
            </div>

            <h1 class="mt-6 text-4xl font-black tracking-tight text-slate-950">
                Order {{ $order->order_number }} siap diselesaikan.
            </h1>

            <p class="mt-5 max-w-2xl text-base leading-8 text-slate-600">
                Order sudah berhasil dibuat dari cart, item sudah disimpan ke <code>order_items</code>, dan stok sudah direservasi.
                Pembayaran sekarang menggunakan Midtrans Sandbox lewat Snap popup agar flow web app tetap simpel dan production-like.
            </p>

            <div class="mt-8 grid gap-4 sm:grid-cols-2">
                <div class="rounded-3xl bg-slate-50 p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400">Recipient</p>
                    <p class="mt-3 text-lg font-semibold text-slate-900">{{ $order->shipping_recipient_name }}</p>
                    <p class="mt-2 text-sm text-slate-500">{{ $order->shipping_phone }}</p>
                </div>

                <div class="rounded-3xl bg-slate-50 p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400">Shipping Address</p>
                    <p class="mt-3 text-sm leading-7 text-slate-700">{{ $order->shipping_full_address }}</p>
                </div>
            </div>

            <div class="mt-8 space-y-4">
                @foreach ($order->items as $item)
                    <div class="flex items-center justify-between gap-4 rounded-3xl border border-slate-200 p-4">
                        <div>
                            <p class="font-semibold text-slate-900">{{ $item->product_name }}</p>
                            <p class="mt-1 text-sm text-slate-500">{{ $item->quantity }} x Rp{{ number_format((float) $item->unit_price, 0, ',', '.') }}</p>
                        </div>
                        <p class="text-sm font-semibold text-slate-900">Rp{{ number_format((float) $item->total_price, 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="space-y-6">
            <aside class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-bold text-slate-950">Payment Summary</h3>

                <div class="mt-6 space-y-3 border-t border-slate-100 pt-6 text-sm">
                    <div class="flex items-center justify-between text-slate-600">
                        <span>Order Status</span>
                        <span class="font-semibold text-slate-900">{{ $order->order_status }}</span>
                    </div>
                    <div class="flex items-center justify-between text-slate-600">
                        <span>Payment Status</span>
                        <span class="font-semibold text-slate-900">{{ $order->payment_status }}</span>
                    </div>
                    <div class="flex items-center justify-between text-slate-600">
                        <span>Payment Gateway</span>
                        <span class="font-semibold text-slate-900">{{ $payment ? 'Midtrans '.strtoupper($paymentType) : 'Belum dibuat' }}</span>
                    </div>
                    <div class="flex items-center justify-between text-slate-600">
                        <span>Transaction ID</span>
                        <span class="font-semibold text-slate-900">{{ $payment?->transaction_id ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between text-slate-600">
                        <span>Transaction Status</span>
                        <span class="font-semibold text-slate-900">{{ $payment?->transaction_status ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between text-slate-600">
                        <span>Fraud Status</span>
                        <span class="font-semibold text-slate-900">{{ $payment?->fraud_status ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between text-slate-600">
                        <span>Gross Amount</span>
                        <span>{{ $payment?->gross_amount_label ?? $order->grand_total_label }}</span>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-between rounded-3xl bg-slate-950 px-5 py-4 text-white">
                    <span class="text-sm font-medium text-slate-300">Grand Total</span>
                    <span class="text-xl font-black tracking-tight">{{ $order->grand_total_label }}</span>
                </div>
            </aside>

            <div class="rounded-[2rem] border border-slate-200 bg-slate-950 p-6 text-white shadow-xl shadow-slate-900/10">
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-400">Midtrans Snap</p>

                @if ($order->is_paid)
                    <h3 class="mt-4 text-2xl font-black tracking-tight">Pembayaran sudah berhasil diterima.</h3>
                    <p class="mt-4 text-sm leading-7 text-slate-300">
                        Midtrans sudah mengirim callback sukses dan status order sudah disinkronkan menjadi paid.
                    </p>
                @elseif ($canLaunchSnap)
                    <h3 class="mt-4 text-2xl font-black tracking-tight">Popup pembayaran siap dibuka.</h3>
                    <p class="mt-4 text-sm leading-7 text-slate-300">
                        Klik tombol di bawah untuk membuka Midtrans Snap. Status final pembayaran tetap disinkronkan dari webhook agar lebih aman.
                    </p>

                    <div class="mt-6 space-y-3">
                        <button
                            id="pay-button"
                            type="button"
                            class="inline-flex w-full items-center justify-center rounded-full bg-white px-5 py-3 text-sm font-semibold text-slate-950 transition hover:bg-slate-100"
                        >
                            Bayar Sekarang
                        </button>

                        @if (filled($payment?->snap_redirect_url))
                            <a
                                href="{{ $payment->snap_redirect_url }}"
                                target="_blank"
                                rel="noreferrer"
                                class="inline-flex w-full items-center justify-center rounded-full border border-white/15 bg-white/5 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/10"
                            >
                                Buka Redirect URL Midtrans
                            </a>
                        @endif
                    </div>
                @elseif (! filled(config('midtrans.client_key')))
                    <h3 class="mt-4 text-2xl font-black tracking-tight">Client key Midtrans belum dikonfigurasi.</h3>
                    <p class="mt-4 text-sm leading-7 text-slate-300">
                        Isi <code>MIDTRANS_CLIENT_KEY</code> dan <code>MIDTRANS_SERVER_KEY</code> di environment agar tombol bayar bisa aktif.
                    </p>
                @elseif ($canPreparePayment)
                    <h3 class="mt-4 text-2xl font-black tracking-tight">Sesi pembayaran belum tersedia.</h3>
                    <p class="mt-4 text-sm leading-7 text-slate-300">
                        Order sudah tersimpan, tetapi Snap token belum tersedia. Kamu bisa menyiapkan sesi payment lagi dari tombol di bawah.
                    </p>

                    <form method="POST" action="{{ route('orders.pay', $order) }}" class="mt-6">
                        @csrf
                        <button type="submit" class="inline-flex w-full items-center justify-center rounded-full bg-white px-5 py-3 text-sm font-semibold text-slate-950 transition hover:bg-slate-100">
                            Siapkan Pembayaran Ulang
                        </button>
                    </form>
                @else
                    <h3 class="mt-4 text-2xl font-black tracking-tight">Order ini tidak bisa dibayar ulang.</h3>
                    <p class="mt-4 text-sm leading-7 text-slate-300">
                        Status order sudah final atau reservasi stok sudah dirilis. Untuk melanjutkan pembelian, silakan checkout ulang dari cart.
                    </p>
                @endif
            </div>

            <a href="{{ route('products.index') }}" class="inline-flex w-full items-center justify-center rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:text-slate-900">
                Kembali ke Katalog
            </a>
        </div>
    </section>
@endsection

@if ($canLaunchSnap)
    @push('scripts')
        <script
            src="{{ config('midtrans.snap_url') }}"
            data-client-key="{{ config('midtrans.client_key') }}"
        ></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const payButton = document.getElementById('pay-button');

                if (! payButton || typeof window.snap === 'undefined') {
                    return;
                }

                payButton.addEventListener('click', function () {
                    window.snap.pay(@js($payment->snap_token), {
                        onSuccess: function () {
                            window.location.href = @js(route('checkout.success', $order));
                        },
                        onPending: function () {
                            window.location.href = @js(route('checkout.success', $order));
                        },
                        onError: function () {
                            window.location.href = @js(route('checkout.success', $order));
                        },
                        onClose: function () {
                            window.location.href = @js(route('checkout.success', $order));
                        }
                    });
                });
            });
        </script>
    @endpush
@endif
