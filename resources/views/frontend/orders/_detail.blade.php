@php
    $payment = $order->latestPayment;
    $paymentStatus = $payment?->status ?? $order->payment_status;
    $paymentType = $payment?->payment_type ?? 'snap';
    $hasSnapToken = filled($payment?->snap_token);
    $canPreparePayment = ! $order->is_paid
        && $order->order_status === \App\Models\Order::STATUS_PENDING
        && in_array($order->payment_status, [
            \App\Models\Order::PAYMENT_UNPAID,
            \App\Models\Order::PAYMENT_PENDING,
            \App\Models\Order::PAYMENT_FAILED,
            \App\Models\Order::PAYMENT_EXPIRED,
        ], true);
    $canLaunchSnap = $canPreparePayment && $hasSnapToken && filled(config('midtrans.client_key'));

    $orderTone = match ($order->order_status) {
        \App\Models\Order::STATUS_PAID, \App\Models\Order::STATUS_COMPLETED => 'success',
        \App\Models\Order::STATUS_PROCESSING, \App\Models\Order::STATUS_SHIPPED => 'info',
        \App\Models\Order::STATUS_CANCELLED, \App\Models\Order::STATUS_REFUNDED => 'danger',
        default => 'warning',
    };

    $paymentTone = match ($paymentStatus) {
        \App\Models\Payment::STATUS_PAID, \App\Models\Order::PAYMENT_PAID => 'success',
        \App\Models\Payment::STATUS_PENDING, \App\Models\Order::PAYMENT_PENDING, \App\Models\Order::PAYMENT_UNPAID => 'warning',
        \App\Models\Payment::STATUS_FAILED, \App\Models\Payment::STATUS_CANCELLED, \App\Models\Payment::STATUS_EXPIRED, \App\Models\Order::PAYMENT_FAILED, \App\Models\Order::PAYMENT_EXPIRED, \App\Models\Order::PAYMENT_REFUNDED => 'danger',
        default => 'neutral',
    };
@endphp

<div class="mb-6 flex flex-wrap items-center gap-3 text-sm text-slate-500">
    <a href="{{ route('home') }}" class="transition hover:text-slate-900">Beranda</a>
    <span>/</span>
    <a href="{{ route('orders.index') }}" class="transition hover:text-slate-900">Pesanan Saya</a>
    <span>/</span>
    <span class="font-medium text-slate-900">{{ $order->order_number }}</span>
</div>

<section class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_minmax(360px,0.92fr)] lg:items-start">
    <div class="space-y-6">
        <div class="rounded-[2.2rem] border border-slate-200 bg-white p-8 shadow-sm">
            <div class="flex flex-wrap items-center gap-3">
                <x-frontend.status-badge :label="'Order '.$order->order_status" :tone="$orderTone" size="md" />
                <x-frontend.status-badge :label="'Payment '.$order->payment_status" :tone="$paymentTone" size="md" />
            </div>

            <div class="mt-6 flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                <div class="max-w-2xl">
                    <p class="text-xs font-semibold uppercase tracking-[0.32em] text-slate-400">Detail Pesanan</p>
                    <h1 class="mt-3 text-4xl font-black tracking-tight text-slate-950">{{ $order->order_number }}</h1>
                    <p class="mt-5 text-base leading-8 text-slate-600">
                        Halaman ini menampilkan snapshot order, status pembayaran, status pesanan, detail alamat kirim, dan akses cepat untuk melanjutkan pembayaran bila order masih pending.
                    </p>
                </div>

                <div class="rounded-[1.8rem] bg-slate-950 px-6 py-5 text-white">
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400">Total Akhir</p>
                    <p class="mt-3 text-3xl font-black tracking-tight">{{ $order->grand_total_label }}</p>
                </div>
            </div>

            <div class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-3xl bg-slate-50 p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Waktu Dibuat</p>
                    <p class="mt-3 text-sm font-semibold text-slate-900">{{ optional($order->placed_at)->format('d M Y H:i') ?? '-' }}</p>
                </div>
                <div class="rounded-3xl bg-slate-50 p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Penerima</p>
                    <p class="mt-3 text-sm font-semibold text-slate-900">{{ $order->shipping_recipient_name }}</p>
                </div>
                <div class="rounded-3xl bg-slate-50 p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Telepon</p>
                    <p class="mt-3 text-sm font-semibold text-slate-900">{{ $order->shipping_phone }}</p>
                </div>
                <div class="rounded-3xl bg-slate-50 p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Metode</p>
                    <p class="mt-3 text-sm font-semibold text-slate-900">{{ $payment ? 'Midtrans '.strtoupper($paymentType) : 'Belum dibuat' }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-[2.2rem] border border-slate-200 bg-white p-8 shadow-sm">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-400">Info Pengiriman</p>
                    <h2 class="mt-2 text-2xl font-black tracking-tight text-slate-950">Alamat dan catatan pengiriman</h2>
                </div>
                <span class="rounded-full bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700">
                    {{ $order->shipping_city }}, {{ $order->shipping_postal_code }}
                </span>
            </div>

            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Alamat Lengkap</p>
                    <p class="mt-3 text-sm leading-7 text-slate-700">{{ $order->shipping_full_address }}</p>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Catatan</p>
                    <p class="mt-3 text-sm leading-7 text-slate-700">{{ $order->shipping_notes ?: 'Tidak ada catatan tambahan.' }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-[2.2rem] border border-slate-200 bg-white p-8 shadow-sm">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-400">Item Pesanan</p>
                    <h2 class="mt-2 text-2xl font-black tracking-tight text-slate-950">Snapshot item yang dibeli</h2>
                </div>
                <span class="rounded-full bg-slate-950 px-4 py-2 text-sm font-semibold text-white">
                    {{ $order->items->count() }} item
                </span>
            </div>

            <div class="mt-6 space-y-4">
                @foreach ($order->items as $item)
                    <article class="flex flex-col gap-4 rounded-[1.8rem] border border-slate-200 p-5 sm:flex-row sm:items-center sm:justify-between">
                        <div class="min-w-0">
                            <p class="text-lg font-bold text-slate-950">{{ $item->product_name }}</p>
                            <div class="mt-2 flex flex-wrap gap-2 text-sm text-slate-500">
                                <span>SKU: {{ $item->sku ?: '-' }}</span>
                                <span>/</span>
                                <span>{{ $item->quantity }} x Rp{{ number_format((float) $item->unit_price, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="rounded-full bg-slate-50 px-4 py-2 text-sm font-semibold text-slate-900">
                            Rp{{ number_format((float) $item->total_price, 0, ',', '.') }}
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <aside class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-bold text-slate-950">Ringkasan Pembayaran</h3>

            <div class="mt-6 space-y-3 border-t border-slate-100 pt-6 text-sm">
                <div class="flex items-center justify-between text-slate-600">
                    <span>Status Pesanan</span>
                    <span class="font-semibold text-slate-900">{{ strtoupper($order->order_status) }}</span>
                </div>
                <div class="flex items-center justify-between text-slate-600">
                    <span>Status Pembayaran</span>
                    <span class="font-semibold text-slate-900">{{ strtoupper($order->payment_status) }}</span>
                </div>
                <div class="flex items-center justify-between text-slate-600">
                    <span>ID Transaksi</span>
                    <span class="font-semibold text-slate-900">{{ $payment?->transaction_id ?? '-' }}</span>
                </div>
                <div class="flex items-center justify-between text-slate-600">
                    <span>Status Transaksi</span>
                    <span class="font-semibold text-slate-900">{{ $payment?->transaction_status ?? '-' }}</span>
                </div>
                <div class="flex items-center justify-between text-slate-600">
                    <span>Status Fraud</span>
                    <span class="font-semibold text-slate-900">{{ $payment?->fraud_status ?? '-' }}</span>
                </div>
                <div class="flex items-center justify-between text-slate-600">
                    <span>Total Tagihan</span>
                    <span>{{ $payment?->gross_amount_label ?? $order->grand_total_label }}</span>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-between rounded-3xl bg-slate-950 px-5 py-4 text-white">
                <span class="text-sm font-medium text-slate-300">Total Akhir</span>
                <span class="text-xl font-black tracking-tight">{{ $order->grand_total_label }}</span>
            </div>
        </aside>

        <div class="rounded-[2rem] border border-slate-200 bg-slate-950 p-6 text-white shadow-xl shadow-slate-900/10">
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-400">Aksi Pembayaran</p>

            @if ($order->is_paid)
                <h3 class="mt-4 text-2xl font-black tracking-tight">Pembayaran sudah berhasil diterima.</h3>
                <p class="mt-4 text-sm leading-7 text-slate-300">
                    Status pembayaran dan pesanan sudah sinkron. Pesanan ini sekarang tersimpan aman di riwayat akun kamu.
                </p>
            @elseif ($canLaunchSnap)
                <h3 class="mt-4 text-2xl font-black tracking-tight">Lanjutkan pembayaran sekarang.</h3>
                <p class="mt-4 text-sm leading-7 text-slate-300">
                    Snap token masih tersedia, jadi kamu bisa langsung membuka popup Midtrans untuk menyelesaikan pembayaran.
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
                    Payment detail tetap terlihat, tetapi tombol bayar ulang baru akan aktif setelah konfigurasi Midtrans dilengkapi.
                </p>
            @elseif ($canPreparePayment)
                <h3 class="mt-4 text-2xl font-black tracking-tight">Sesi pembayaran bisa disiapkan ulang.</h3>
                <p class="mt-4 text-sm leading-7 text-slate-300">
                    Pesanan ini masih menunggu, jadi kamu masih bisa meminta Snap token baru dan lanjut membayar dari halaman ini.
                </p>

                <form method="POST" action="{{ route('orders.pay', $order->order_number) }}" class="mt-6">
                    @csrf
                    <button type="submit" class="inline-flex w-full items-center justify-center rounded-full bg-white px-5 py-3 text-sm font-semibold text-slate-950 transition hover:bg-slate-100">
                        Siapkan Pembayaran Ulang
                    </button>
                </form>
            @else
                <h3 class="mt-4 text-2xl font-black tracking-tight">Pesanan ini tidak bisa dibayar ulang.</h3>
                <p class="mt-4 text-sm leading-7 text-slate-300">
                    Status pesanan atau pembayaran sudah final, jadi tombol bayar ulang tidak lagi ditampilkan untuk mencegah alur yang membingungkan.
                </p>
            @endif
        </div>

        <a href="{{ route('orders.index') }}" class="inline-flex w-full items-center justify-center rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:text-slate-900">
            Kembali ke Riwayat Pesanan
        </a>
    </div>
</section>

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
                            window.location.href = @js(route('orders.show', $order->order_number));
                        },
                        onPending: function () {
                            window.location.href = @js(route('orders.show', $order->order_number));
                        },
                        onError: function () {
                            window.location.href = @js(route('orders.show', $order->order_number));
                        },
                        onClose: function () {
                            window.location.href = @js(route('orders.show', $order->order_number));
                        }
                    });
                });
            });
        </script>
    @endpush
@endif
