@extends('layouts.storefront')

@section('title', 'Riwayat Pesanan')
@section('meta_description', 'Riwayat pesanan customer beserta status order dan pembayaran.')

@section('content')
    <section class="space-y-8">
        <div class="rounded-[2.4rem] border border-slate-200 bg-white p-8 shadow-sm sm:p-10">
            <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_420px] lg:items-end">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.34em] text-slate-400">Riwayat Pesanan</p>
                    <h1 class="mt-4 max-w-3xl text-4xl font-black tracking-tight text-slate-950 sm:text-5xl">
                        Semua order kamu tersusun rapi dalam satu timeline yang mudah dipantau.
                    </h1>
                    <p class="mt-5 max-w-2xl text-base leading-8 text-slate-600">
                        Halaman ini menampilkan daftar pesanan milik akun yang sedang login, lengkap dengan status order, status pembayaran, total belanja, dan akses cepat ke halaman detail.
                    </p>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <x-frontend.metric-card
                        label="Total Pesanan"
                        :value="number_format($summary['total_orders'])"
                        description="Semua order yang pernah dibuat akun ini."
                    />
                    <x-frontend.metric-card
                        label="Menunggu Pembayaran"
                        :value="number_format($summary['pending_payment'])"
                        description="Pesanan yang masih menunggu pembayaran."
                    />
                    <x-frontend.metric-card
                        label="Selesai"
                        :value="number_format($summary['completed_orders'])"
                        description="Pesanan yang sudah selesai diproses."
                    />
                    <x-frontend.metric-card
                        label="Total Belanja"
                        :value="'Rp'.number_format((float) $summary['total_spent'], 0, ',', '.')"
                        description="Akumulasi order dengan pembayaran sukses."
                    />
                </div>
            </div>
        </div>

        <section class="rounded-[2.2rem] border border-slate-200 bg-white p-8 shadow-sm">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-400">Pesanan Saya</p>
                    <h2 class="mt-2 text-3xl font-black tracking-tight text-slate-950">Riwayat pesanan terbaru</h2>
                </div>

                <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:text-slate-900">
                    Belanja Lagi
                </a>
            </div>

            @if ($orders->count())
                <div class="mt-8 space-y-4">
                    @foreach ($orders as $order)
                        @php
                            $latestPayment = $order->latestPayment;

                            $orderTone = match ($order->order_status) {
                                \App\Models\Order::STATUS_COMPLETED, \App\Models\Order::STATUS_PAID => 'success',
                                \App\Models\Order::STATUS_PROCESSING, \App\Models\Order::STATUS_SHIPPED => 'info',
                                \App\Models\Order::STATUS_CANCELLED, \App\Models\Order::STATUS_REFUNDED => 'danger',
                                default => 'warning',
                            };

                            $paymentTone = match ($order->payment_status) {
                                \App\Models\Order::PAYMENT_PAID => 'success',
                                \App\Models\Order::PAYMENT_PENDING, \App\Models\Order::PAYMENT_UNPAID => 'warning',
                                \App\Models\Order::PAYMENT_FAILED, \App\Models\Order::PAYMENT_EXPIRED, \App\Models\Order::PAYMENT_REFUNDED => 'danger',
                                default => 'neutral',
                            };
                        @endphp

                        <article class="rounded-[2rem] border border-slate-200 bg-[linear-gradient(135deg,#ffffff_0%,#f8fafc_100%)] p-6 shadow-sm transition hover:border-slate-300 hover:shadow-lg hover:shadow-slate-900/5">
                            <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                                <div class="min-w-0 flex-1">
                                    <div class="flex flex-wrap items-center gap-3">
                                        <p class="text-xl font-black tracking-tight text-slate-950">{{ $order->order_number }}</p>
                                        <x-frontend.status-badge :label="$order->order_status" :tone="$orderTone" />
                                        <x-frontend.status-badge :label="'Payment '.$order->payment_status" :tone="$paymentTone" />
                                    </div>

                                    <div class="mt-4 grid gap-4 text-sm text-slate-600 sm:grid-cols-3">
                                        <div class="rounded-2xl bg-white/80 px-4 py-3 ring-1 ring-slate-200/80">
                                            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Dibuat</p>
                                            <p class="mt-2 font-semibold text-slate-900">{{ optional($order->placed_at)->format('d M Y H:i') ?? '-' }}</p>
                                        </div>
                                        <div class="rounded-2xl bg-white/80 px-4 py-3 ring-1 ring-slate-200/80">
                                            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Penerima</p>
                                            <p class="mt-2 font-semibold text-slate-900">{{ $order->shipping_recipient_name }}</p>
                                        </div>
                                        <div class="rounded-2xl bg-white/80 px-4 py-3 ring-1 ring-slate-200/80">
                                            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Pembayaran</p>
                                            <p class="mt-2 font-semibold text-slate-900">
                                                {{ $latestPayment ? 'Midtrans '.strtoupper($latestPayment->payment_type ?? 'snap') : 'Belum dibuat' }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="mt-5 flex flex-wrap gap-2">
                                        @foreach ($order->items->take(3) as $item)
                                            <span class="rounded-full bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700">
                                                {{ $item->product_name }} x{{ $item->quantity }}
                                            </span>
                                        @endforeach

                                        @if ($order->items->count() > 3)
                                            <span class="rounded-full bg-slate-950 px-4 py-2 text-sm font-medium text-white">
                                                +{{ $order->items->count() - 3 }} item lain
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex w-full flex-col gap-4 lg:w-[240px]">
                                    <div class="rounded-[1.8rem] bg-slate-950 px-5 py-5 text-white">
                                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Total Akhir</p>
                                        <p class="mt-3 text-2xl font-black tracking-tight">{{ $order->grand_total_label }}</p>
                                    </div>

                                    <a href="{{ route('orders.show', $order->order_number) }}" class="inline-flex items-center justify-center rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                                        Lihat Detail Pesanan
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $orders->onEachSide(1)->links() }}
                </div>
            @else
                <div class="mt-8 rounded-[2rem] border border-dashed border-slate-200 bg-slate-50 p-12 text-center">
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Belum Ada Pesanan</p>
                    <h3 class="mt-4 text-2xl font-black tracking-tight text-slate-950">Belum ada order di akun ini.</h3>
                    <p class="mx-auto mt-4 max-w-2xl text-sm leading-7 text-slate-600">
                        Setelah checkout pertama berhasil dibuat, riwayat order akan muncul di sini lengkap dengan status pembayaran dan status pesanan.
                    </p>
                    <a href="{{ route('products.index') }}" class="mt-6 inline-flex rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                        Mulai Belanja
                    </a>
                </div>
            @endif
        </section>
    </section>
@endsection
