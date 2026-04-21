@extends('layouts.storefront')

@section('title', 'Checkout')

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

/* ─── MAIN GRID ─── */
.sf-checkout-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
}
@media (min-width: 1024px) {
    .sf-checkout-grid {
        grid-template-columns: 1.1fr 0.9fr;
        align-items: start;
    }
}

/* ─── Cards ─── */
.sf-card {
    border-radius: 2rem;
    border: 1px solid rgba(255,255,255,0.08);
    background: rgba(255,255,255,0.03);
    padding: 2rem;
}
.sf-card-section {
    border-radius: 1.5rem;
    border: 1px solid rgba(255,255,255,0.07);
    background: rgba(255,255,255,0.02);
    padding: 1.5rem;
}

/* ─── Eyebrow / Label ─── */
.sf-eyebrow {
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.3em;
    color: #475569;
}
.sf-label {
    font-size: 13px;
    font-weight: 600;
    color: #cbd5e1;
    display: block;
    margin-bottom: 0.5rem;
}

/* ─── Inputs ─── */
.sf-input {
    display: block;
    width: 100%;
    border-radius: 1rem;
    border: 1px solid rgba(255,255,255,0.1);
    background: rgba(255,255,255,0.04);
    padding: 12px 16px;
    font-size: 13px;
    color: #ffffff;
    outline: none;
    transition: border-color 0.2s, background 0.2s;
    box-sizing: border-box;
}
.sf-input::placeholder { color: #475569; }
.sf-input:focus {
    border-color: rgba(255,255,255,0.25);
    background: rgba(255,255,255,0.07);
}
.sf-textarea {
    display: block;
    width: 100%;
    border-radius: 1.25rem;
    border: 1px solid rgba(255,255,255,0.1);
    background: rgba(255,255,255,0.04);
    padding: 12px 16px;
    font-size: 13px;
    color: #ffffff;
    outline: none;
    transition: border-color 0.2s, background 0.2s;
    resize: vertical;
    box-sizing: border-box;
}
.sf-textarea::placeholder { color: #475569; }
.sf-textarea:focus {
    border-color: rgba(255,255,255,0.25);
    background: rgba(255,255,255,0.07);
}

/* ─── Form Grid ─── */
.sf-form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-top: 1.5rem;
}
@media (max-width: 640px) {
    .sf-form-grid { grid-template-columns: 1fr; }
}
.sf-col-span-2 { grid-column: span 2; }
@media (max-width: 640px) {
    .sf-col-span-2 { grid-column: span 1; }
}

/* ─── Shipping Method ─── */
.sf-shipping-item {
    border-radius: 1.25rem;
    border: 1px solid rgba(255,255,255,0.07);
    background: rgba(255,255,255,0.02);
    padding: 1rem 1.25rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    transition: all 0.2s;
}
.sf-shipping-item.active {
    border-color: rgba(251,191,36,0.4);
    background: rgba(251,191,36,0.06);
}

/* ─── Info Banner ─── */
.sf-info-banner {
    border-radius: 1.5rem;
    border: 1px solid rgba(255,255,255,0.07);
    background: rgba(255,255,255,0.02);
    padding: 1.5rem;
}

/* ─── Submit Button ─── */
.sf-btn-submit {
    display: flex;
    width: 100%;
    align-items: center;
    justify-content: center;
    border-radius: 9999px;
    background: #ffffff;
    padding: 14px 24px;
    font-size: 14px;
    font-weight: 700;
    color: #000000;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
}
.sf-btn-submit:hover {
    background: #e2e8f0;
    transform: translateY(-1px);
}

/* ─── Sidebar: Cart Summary ─── */
.sf-summary-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    border-radius: 1.5rem;
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(255,255,255,0.06);
    padding: 1rem 1.25rem;
}
.sf-summary-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 13px;
    color: #64748b;
}
.sf-total-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-radius: 1.5rem;
    background: #ffffff;
    padding: 1rem 1.5rem;
    margin-top: 1.25rem;
}

/* ─── Payment Step ─── */
.sf-payment-box {
    border-radius: 1.25rem;
    border: 1px dashed rgba(255,255,255,0.1);
    background: rgba(255,255,255,0.02);
    padding: 1.25rem;
}

/* ─── Divider ─── */
.sf-divider {
    border: none;
    border-top: 1px solid rgba(255,255,255,0.06);
    margin: 1.25rem 0;
}

/* ─── Col Right Sticky ─── */
.sf-col-right {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}
@media (min-width: 1024px) {
    .sf-col-right {
        position: sticky;
        top: 7rem;
    }
}
</style>
@endpush

@section('content')
<div class="sf-dark-inner">

    {{-- Page Heading --}}
    <div style="margin-bottom: 2.5rem;">
        <p class="sf-eyebrow" style="margin-bottom:0.75rem;">Checkout</p>
        <h1 style="font-size: clamp(1.75rem, 3vw, 2.5rem); font-weight: 900; color: #ffffff; letter-spacing: -0.02em; line-height: 1.1;">
            Finalisasi Order
        </h1>
        <p style="margin-top: 0.75rem; font-size: 13px; color: #64748b; line-height: 1.7;">
            Isi data pengiriman, cek ringkasan, lalu buat order untuk dilanjutkan ke pembayaran.
        </p>
    </div>

    <div class="sf-checkout-grid">

        {{-- ════════════════════════════
             KOLOM KIRI — Form
        ════════════════════════════ --}}
        <div style="display:flex; flex-direction:column; gap:1.5rem;">

            <form method="POST" action="{{ route('checkout.store') }}" style="display:flex; flex-direction:column; gap:1.5rem;">
                @csrf

                {{-- ── Data Pengiriman ── --}}
                <div class="sf-card">
                    <div style="display:flex; flex-wrap:wrap; align-items:flex-end; justify-content:space-between; gap:1rem;">
                        <div>
                            <p class="sf-eyebrow" style="margin-bottom:0.5rem;">Data Pengiriman</p>
                            <p style="font-size:13px; color:#64748b; line-height:1.6;">
                                Data ini disimpan sebagai snapshot order agar histori tetap konsisten.
                            </p>
                        </div>
                        <span style="border-radius:9999px; border:1px solid rgba(255,255,255,0.08); background:rgba(255,255,255,0.04); padding:8px 16px; font-size:12px; font-weight:600; color:#94a3b8;">
                            {{ auth()->user()->email }}
                        </span>
                    </div>

                    <div class="sf-form-grid">
                        {{-- Nama Penerima --}}
                        <div class="sf-col-span-2">
                            <label for="recipient_name" class="sf-label">Nama Penerima</label>
                            <input
                                id="recipient_name"
                                name="recipient_name"
                                type="text"
                                value="{{ old('recipient_name', auth()->user()->name) }}"
                                class="sf-input"
                                required
                            >
                        </div>

                        {{-- Telepon --}}
                        <div>
                            <label for="phone" class="sf-label">Nomor Telepon</label>
                            <input
                                id="phone"
                                name="phone"
                                type="text"
                                value="{{ old('phone', auth()->user()->phone) }}"
                                class="sf-input"
                                required
                            >
                        </div>

                        {{-- Kota --}}
                        <div>
                            <label for="city" class="sf-label">Kota</label>
                            <input
                                id="city"
                                name="city"
                                type="text"
                                value="{{ old('city') }}"
                                class="sf-input"
                                required
                            >
                        </div>

                        {{-- Alamat --}}
                        <div class="sf-col-span-2">
                            <label for="address" class="sf-label">Alamat</label>
                            <textarea
                                id="address"
                                name="address"
                                rows="4"
                                class="sf-textarea"
                                required
                            >{{ old('address') }}</textarea>
                        </div>

                        {{-- Kode Pos --}}
                        <div>
                            <label for="postal_code" class="sf-label">Kode Pos</label>
                            <input
                                id="postal_code"
                                name="postal_code"
                                type="text"
                                value="{{ old('postal_code') }}"
                                class="sf-input"
                                required
                            >
                        </div>

                        {{-- Catatan --}}
                        <div>
                            <label for="note" class="sf-label">Catatan</label>
                            <input
                                id="note"
                                name="note"
                                type="text"
                                value="{{ old('note') }}"
                                placeholder="Opsional, misalnya patokan rumah"
                                class="sf-input"
                            >
                        </div>
                    </div>
                </div>

                {{-- ── Metode Pengiriman ── --}}
                <div class="sf-card">
                    <p class="sf-eyebrow" style="margin-bottom:1.25rem;">Metode Pengiriman</p>
                    <div style="display:flex; flex-direction:column; gap:0.75rem;">
                        @foreach ($shippingMethods as $method)
                            <div class="sf-shipping-item {{ $method['active'] ? 'active' : '' }}">
                                <div>
                                    <p style="font-size:14px; font-weight:700; color:#ffffff;">
                                        {{ $method['name'] }}
                                    </p>
                                    <p style="margin-top:4px; font-size:12px; color:#64748b;">
                                        {{ $method['detail'] }}
                                    </p>
                                </div>
                                <span style="font-size:13px; font-weight:700; color:#ffffff; white-space:nowrap;">
                                    {{ $method['price_label'] }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- ── Info Pembayaran ── --}}
                <div class="sf-card">
                    <p class="sf-eyebrow" style="margin-bottom:0.75rem;">Checkout & Pembayaran</p>
                    <p style="font-size:1.1rem; font-weight:800; color:#ffffff; line-height:1.4; margin-bottom:1rem;">
                        Stok direservasi saat order dibuat, lalu dibayar lewat Midtrans.
                    </p>
                    <p style="font-size:13px; line-height:1.8; color:#64748b;">
                        Saat checkout berhasil, stok langsung direservasi dan dicatat ke
                        <code style="background:rgba(255,255,255,0.06); border-radius:6px; padding:2px 6px; font-size:12px; color:#94a3b8;">inventory_logs</code>.
                        Setelah itu user menyelesaikan pembayaran di Midtrans Snap.
                        Jika payment gagal, expired, atau dibatalkan, stok akan direlease kembali lewat webhook Midtrans.
                    </p>
                </div>

                {{-- ── Submit ── --}}
                <button type="submit" class="sf-btn-submit">
                    Buat Order &amp; Lanjut Bayar
                </button>

            </form>
        </div>

        {{-- ════════════════════════════
             KOLOM KANAN — Ringkasan
        ════════════════════════════ --}}
        <div class="sf-col-right">

            {{-- Cart Summary --}}
            <div class="sf-card">
                <p class="sf-eyebrow" style="margin-bottom:1.25rem;">Ringkasan Order</p>

                <div style="display:flex; flex-direction:column; gap:0.75rem;">
                    @foreach ($cart->items as $item)
                        <div class="sf-summary-item">
                            <div style="min-width:0;">
                                <p style="font-size:14px; font-weight:700; color:#ffffff; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                    {{ $item->product->name }}
                                </p>
                                <p style="margin-top:4px; font-size:12px; color:#64748b;">
                                    {{ $item->quantity }} × {{ $item->unit_price_label }}
                                </p>
                            </div>
                            <p style="font-size:13px; font-weight:700; color:#ffffff; white-space:nowrap;">
                                {{ $item->subtotal_label }}
                            </p>
                        </div>
                    @endforeach
                </div>

                <hr class="sf-divider">

                <div style="display:flex; flex-direction:column; gap:0.625rem;">
                    <div class="sf-summary-row">
                        <span>Total item</span>
                        <span style="color:#ffffff; font-weight:600;">{{ $cart->total_items }}</span>
                    </div>
                    <div class="sf-summary-row">
                        <span>Subtotal</span>
                        <span style="color:#ffffff; font-weight:600;">{{ $cart->subtotal_label }}</span>
                    </div>
                    <div class="sf-summary-row">
                        <span>Pengiriman</span>
                        <span style="color:#ffffff; font-weight:600;">Rp0</span>
                    </div>
                </div>

                <div class="sf-total-bar">
                    <span style="font-size:13px; font-weight:600; color:#000000;">Total Akhir</span>
                    <span style="font-size:1.25rem; font-weight:900; color:#000000; letter-spacing:-0.02em;">
                        {{ $cart->total_label }}
                    </span>
                </div>
            </div>

            {{-- Langkah Pembayaran --}}
            <div class="sf-card">
                <p class="sf-eyebrow" style="margin-bottom:1.25rem;">Langkah Pembayaran</p>
                <div class="sf-payment-box">
                    <p style="font-size:14px; font-weight:700; color:#ffffff;">
                        {{ $paymentMethod['name'] }}
                    </p>
                    <p style="margin-top:0.625rem; font-size:13px; line-height:1.7; color:#64748b;">
                        {{ $paymentMethod['detail'] }}
                    </p>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection