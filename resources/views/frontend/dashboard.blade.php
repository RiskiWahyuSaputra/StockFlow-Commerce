@extends('layouts.storefront')

@section('title', 'Dasbor Pelanggan')

@push('styles')
<style>
/* ─── Wrapper ─── */
.sf-dark-inner {
    max-width: 1280px;
    margin: 0 auto;
    padding: 100px 2rem 80px;
}
@media (max-width: 640px) {
    .sf-dark-inner { padding: 80px 1.25rem 60px; }
}

/* ─── Eyebrow ─── */
.sf-eyebrow {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: #475569;
    margin-bottom: 6px;
}
.sf-eyebrow::before {
    content: '';
    display: block;
    width: 16px;
    height: 2px;
    background: #10b981;
    border-radius: 2px;
}

/* ─── Cards ─── */
.sf-card {
    border-radius: 2rem;
    border: 1px solid rgba(255,255,255,0.08);
    background: rgba(255,255,255,0.03);
    padding: 2.5rem;
}

.sf-card-dark {
    border-radius: 2rem;
    border: 1px solid rgba(255,255,255,0.06);
    background: rgba(255,255,255,0.01);
    padding: 2.5rem;
}

/* ─── Stats / Grid ─── */
.sf-stat-box {
    border-radius: 1.5rem;
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(255,255,255,0.06);
    padding: 1.5rem;
}
</style>
@endpush

@section('content')
<div class="sf-dark-inner">
    {{-- Header --}}
    <div style="margin-bottom: 3rem;">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="sf-eyebrow">Area Pelanggan</p>
                <h1 style="font-size: clamp(2rem, 4vw, 3rem); font-weight: 900; color: #ffffff; letter-spacing: -0.02em; line-height: 1;">
                    Dasbor Kamu
                </h1>
            </div>
            <div style="border-radius:9999px; border:1px solid rgba(255,255,255,0.1); background:rgba(255,255,255,0.05); padding:10px 24px; font-size:14px; font-weight:600; color:#ffffff; backdrop-blur:md;">
                Halo, {{ auth()->user()->name }}
            </div>
        </div>
    </div>

    <section class="grid gap-8 xl:grid-cols-[1.15fr_0.85fr]">
        <div style="display:flex; flex-direction:column; gap:2rem;">
            {{-- Welcome Card --}}
            <article class="sf-card">
                <span style="display:inline-flex; border-radius:9999px; background:rgba(16,185,129,0.1); border:1px solid rgba(16,185,129,0.2); padding:6px 16px; font-size:12px; font-weight:700; color:#10b981; text-transform:uppercase; letter-spacing:0.05em;">
                    Sesi Aktif
                </span>

                <h2 style="margin-top:2rem; font-size:1.75rem; font-weight:800; color:#ffffff; line-height:1.2;">
                    Selamat datang kembali. Akses belanja kamu sudah siap.
                </h2>

                <p style="margin-top:1.5rem; font-size:15px; color:#94a3b8; line-height:1.8;">
                    Ini adalah pusat kendali belanja kamu. Dari sini kamu bisa memantau pesanan, 
                    mengelola alamat pengiriman, dan memperbarui preferensi akun.
                </p>

                <div class="mt-10 grid gap-4 md:grid-cols-3">
                    <div class="sf-stat-box">
                        <p style="font-size:10px; font-weight:700; color:#475569; text-transform:uppercase; letter-spacing:0.2em;">Akun</p>
                        <p style="margin-top:0.75rem; font-size:15px; font-weight:700; color:#ffffff;">{{ auth()->user()->role }}</p>
                    </div>
                    <div class="sf-stat-box">
                        <p style="font-size:10px; font-weight:700; color:#475569; text-transform:uppercase; letter-spacing:0.2em;">Email</p>
                        <p style="margin-top:0.75rem; font-size:15px; font-weight:700; color:#ffffff; overflow:hidden; text-overflow:ellipsis;">{{ auth()->user()->email }}</p>
                    </div>
                    <div class="sf-stat-box">
                        <p style="font-size:10px; font-weight:700; color:#475569; text-transform:uppercase; letter-spacing:0.2em;">Status</p>
                        <p style="margin-top:0.75rem; font-size:15px; font-weight:700; color:#ffffff;">{{ auth()->user()->status }}</p>
                    </div>
                </div>
            </article>

            {{-- Quick Links --}}
            <div class="grid gap-4 sm:grid-cols-2">
                <a href="{{ route('profile.edit') }}" class="sf-card-dark" style="text-decoration:none; transition:all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.04)'" onmouseout="this.style.background='rgba(255,255,255,0.01)'">
                    <h3 style="font-size:1.1rem; font-weight:800; color:#ffffff;">Kelola Profil &rarr;</h3>
                    <p style="margin-top:0.5rem; font-size:13px; color:#64748b;">Perbarui informasi pribadi dan kata sandi.</p>
                </a>
                <a href="{{ route('cart.index') }}" class="sf-card-dark" style="text-decoration:none; transition:all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.04)'" onmouseout="this.style.background='rgba(255,255,255,0.01)'">
                    <h3 style="font-size:1.1rem; font-weight:800; color:#ffffff;">Lihat Keranjang &rarr;</h3>
                    <p style="margin-top:0.5rem; font-size:13px; color:#64748b;">Selesaikan pesanan yang tertunda.</p>
                </a>
            </div>
        </div>

        {{-- Sidebar Info --}}
        <aside class="sf-card-dark">
            <p class="sf-eyebrow" style="margin-bottom:1.5rem;">Roadmap Fitur</p>
            <ul style="display:flex; flex-direction:column; gap:1rem;">
                <li style="border-radius:1.25rem; border:1px solid rgba(255,255,255,0.04); background:rgba(255,255,255,0.02); padding:1rem; font-size:13px; color:#cbd5e1; line-height:1.6;">
                    <span style="color:#ffffff; font-weight:700;">Pesanan:</span> Histori transaksi dan tracking kurir.
                </li>
                <li style="border-radius:1.25rem; border:1px solid rgba(255,255,255,0.04); background:rgba(255,255,255,0.02); padding:1rem; font-size:13px; color:#cbd5e1; line-height:1.6;">
                    <span style="color:#ffffff; font-weight:700;">Pembayaran:</span> Integrasi status real-time Midtrans.
                </li>
                <li style="border-radius:1.25rem; border:1px solid rgba(255,255,255,0.04); background:rgba(255,255,255,0.02); padding:1rem; font-size:13px; color:#cbd5e1; line-height:1.6;">
                    <span style="color:#ffffff; font-weight:700;">Alamat:</span> Buku alamat untuk checkout lebih cepat.
                </li>
            </ul>

            <div style="margin-top:2.5rem; padding-top:2rem; border-top:1px solid rgba(255,255,255,0.06);">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" style="width:100%; border-radius:9999px; border:1px solid rgba(239,68,68,0.2); background:rgba(239,68,68,0.05); color:#f87171; padding:12px; font-size:13px; font-weight:700; cursor:pointer; transition:all 0.2s;" onmouseover="this.style.background='rgba(239,68,68,0.1)'" onmouseout="this.style.background='rgba(239,68,68,0.05)'">
                        Keluar dari Sesi
                    </button>
                </form>
            </div>
        </aside>
    </section>
</div>
@endsection
