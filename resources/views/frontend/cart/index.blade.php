@extends('layouts.storefront')

@section('title', 'Keranjang')

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

/* ─── Animasi masuk ─── */
@keyframes sf-fade-up {
    from { opacity: 0; transform: translateY(18px); }
    to   { opacity: 1; transform: none; }
}
.sf-anim { animation: sf-fade-up .48s cubic-bezier(.22,1,.36,1) both; }
.sf-d1 { animation-delay: .04s; }
.sf-d2 { animation-delay: .10s; }
.sf-d3 { animation-delay: .17s; }
.sf-d4 { animation-delay: .24s; }

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
    padding: 2rem;
}

/* ─── Item Card ─── */
.sf-item-card {
    border: 1px solid rgba(255,255,255,0.06);
    border-radius: 1.5rem;
    overflow: hidden;
    background: rgba(255,255,255,0.02);
    transition: all 0.22s ease;
}
.sf-item-card:hover {
    border-color: rgba(255,255,255,0.12);
    background: rgba(255,255,255,0.04);
    transform: translateY(-2px);
}

.sf-item-img-wrap {
    width: 90px;
    height: 90px;
    border-radius: 12px;
    overflow: hidden;
    flex-shrink: 0;
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(255,255,255,0.05);
}
.sf-item-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.sf-item-inner {
    display: flex;
    gap: 1.25rem;
    padding: 1.25rem 1.5rem;
    align-items: flex-start;
}
.sf-item-body { flex: 1; min-width: 0; }
.sf-item-cat {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: #475569;
}
.sf-item-name {
    font-size: 15px;
    font-weight: 700;
    color: #ffffff;
    margin-top: 2px;
}
.sf-item-subtotal {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 9999px;
    padding: 6px 14px;
    font-size: 13px;
    font-weight: 700;
    color: #ffffff;
}

/* Actions bar */
.sf-item-actions {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 1.5rem;
    border-top: 1px solid rgba(255,255,255,0.04);
    background: rgba(0,0,0,0.2);
}
.sf-qty-box {
    display: flex;
    align-items: center;
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 9999px;
    background: rgba(255,255,255,0.02);
}
.sf-qty-btn {
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #94a3b8;
    font-size: 16px;
    border: none;
    background: none;
    cursor: pointer;
}
.sf-qty-btn:hover { color: #ffffff; }
.sf-qty-num {
    min-width: 32px;
    text-align: center;
    font-size: 13px;
    font-weight: 700;
    color: #ffffff;
}
.sf-update-btn {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 9999px;
    padding: 6px 14px;
    font-size: 11px;
    font-weight: 700;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    cursor: pointer;
    transition: all 0.2s;
}
.sf-update-btn:hover {
    border-color: rgba(255,255,255,0.2);
    color: #ffffff;
}
.sf-delete-btn {
    background: rgba(239,68,68,0.1);
    border: 1px solid rgba(239,68,68,0.2);
    border-radius: 9999px;
    padding: 6px 14px;
    font-size: 11px;
    font-weight: 700;
    color: #f87171;
    text-transform: uppercase;
    cursor: pointer;
}
.sf-delete-btn:hover { background: rgba(239,68,68,0.2); }

/* ─── Summary ─── */
.sf-sum-card {
    background: rgba(255,255,255,0.02);
    border: 1px solid rgba(255,255,255,0.06);
    border-radius: 1.5rem;
    padding: 1.25rem;
}
.sf-sum-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
}
.sf-sum-label { font-size: 13px; color: #64748b; }
.sf-sum-val { font-size: 13px; font-weight: 700; color: #ffffff; }

.sf-total-bar {
    background: #ffffff;
    border-radius: 1.25rem;
    padding: 1.25rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 1rem;
}
.sf-total-label { font-size: 12px; font-weight: 700; color: #000000; text-transform: uppercase; letter-spacing: 0.05em; }
.sf-total-val { font-size: 20px; font-weight: 900; color: #000000; letter-spacing: -0.02em; }

.sf-checkout-btn {
    display: flex;
    width: 100%;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    background: #ffffff;
    color: #000000;
    border-radius: 9999px;
    padding: 14px;
    font-size: 14px;
    font-weight: 800;
    text-decoration: none;
    transition: all 0.2s;
    margin-top: 1.5rem;
}
.sf-checkout-btn:hover { background: #e2e8f0; transform: translateY(-1px); }

@media (max-width: 640px) {
    .sf-item-inner { flex-direction: column; }
    .sf-item-img-wrap { width: 100%; height: 160px; }
    .sf-item-subtotal { align-self: flex-start; }
}
</style>
@endpush

@section('content')
<div class="sf-dark-inner">
    <div style="margin-bottom: 2.5rem;">
        <p class="sf-eyebrow">Keranjang Belanja</p>
        <h1 style="font-size: clamp(1.75rem, 3vw, 2.5rem); font-weight: 900; color: #ffffff; letter-spacing: -0.02em; line-height: 1.1;">
            Kelola Item Kamu
        </h1>
    </div>

    <section class="grid gap-8 lg:grid-cols-[1.1fr_0.9fr] lg:items-start">

        {{-- ── LEFT: Items List ── --}}
        <div class="sf-anim sf-d1" style="display:flex; flex-direction:column; gap:1.5rem;">            @if ($cart->items->isNotEmpty())
                @foreach ($cart->items as $index => $item)
                    <article class="sf-item-card sf-anim" style="animation-delay: {{ 0.1 + $index * 0.05 }}s">
                        <div class="sf-item-inner">
                            <div class="sf-item-img-wrap">
                                <img class="sf-item-img" src="{{ $item->product->primary_image_url }}" alt="{{ $item->product->name }}">
                            </div>

                            <div class="sf-item-body">
                                <p class="sf-item-cat">{{ $item->product->primary_category_name }}</p>
                                <h2 class="sf-item-name">{{ $item->product->name }}</h2>
                                <p style="font-size:12px; color:#64748b; margin-top:6px; line-height:1.6;">
                                    {{ Str::limit($item->product->summary, 80) }}
                                </p>
                            </div>

                            <div class="sf-item-subtotal">{{ $item->subtotal_label }}</div>
                        </div>

                        <div class="sf-item-actions">
                            <form method="POST" action="{{ route('cart.items.update', $item) }}" style="display:flex; align-items:center; gap:0.75rem;">
                                @csrf
                                @method('PATCH')
                                <div class="sf-qty-box">
                                    <button type="button" class="sf-qty-btn" onclick="adjustQty('qty-{{ $item->id }}', -1)">−</button>
                                    <span class="sf-qty-num" id="qty-display-{{ $item->id }}">{{ $item->quantity }}</span>
                                    <input type="hidden" id="qty-{{ $item->id }}" name="quantity" value="{{ $item->quantity }}">
                                    <button type="button" class="sf-qty-btn" onclick="adjustQty('qty-{{ $item->id }}', 1, {{ $item->product->stock }})">+</button>
                                </div>
                                <button type="submit" class="sf-update-btn">Update</button>
                            </form>

                            <form method="POST" action="{{ route('cart.items.destroy', $item) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="sf-delete-btn">Hapus</button>
                            </form>
                        </div>
                    </article>
                @endforeach
            @else
                <div style="padding: 4rem 2rem; text-align: center;">
                    <p style="color: #64748b; font-size: 14px;">Keranjang kamu masih kosong.</p>
                    <a href="{{ route('products.index') }}" class="sf-checkout-btn" style="max-width: 200px; margin: 1.5rem auto 0;">Mulai Belanja</a>
                </div>
            @endif
        </div>

        {{-- ── RIGHT: Summary ── --}}
        <div class="flex flex-col gap-6 sf-anim sf-d2">
            <div class="sf-card">
                <p class="sf-eyebrow" style="margin-bottom:1.5rem;">Ringkasan</p>

                <div class="flex flex-col gap-2">
                    <div class="sf-sum-row">
                        <span class="sf-sum-label">Total Item</span>
                        <span class="sf-sum-val">{{ $cart->total_items }} Unit</span>
                    </div>
                    <div class="sf-sum-row" style="border-bottom: 1px solid rgba(255,255,255,0.04); padding-bottom: 1rem; margin-bottom: 0.5rem;">
                        <span class="sf-sum-label">Subtotal</span>
                        <span class="sf-sum-val">{{ $cart->subtotal_label }}</span>
                    </div>
                </div>

                <div class="sf-total-bar">
                    <span class="sf-total-label">Total Estimasi</span>
                    <span class="sf-total-val">{{ $cart->total_label }}</span>
                </div>

                <form method="POST" action="{{ route('checkout.prepare') }}">
                    @csrf
                    <button type="submit" class="sf-checkout-btn">
                        Lanjut ke Checkout
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </button>
                </form>
            </div>

            <div class="sf-card" style="padding: 1.5rem;">
                <p style="font-size: 12px; color: #475569; line-height: 1.8; text-align: center;">
                    Harga belum termasuk ongkos kirim yang akan dihitung otomatis saat checkout berdasarkan alamat pengiriman Anda.
                </p>
            </div>
        </div>

    </section>
</div>

<x-frontend.cart-fab />

@push('scripts')
<script>
function adjustQty(inputId, delta, max) {
    const input   = document.getElementById(inputId);
    const display = document.getElementById('qty-display-' + inputId.replace('qty-', ''));
    if (!input) return;
    let val = parseInt(input.value) + delta;
    val = Math.max(1, max ? Math.min(val, max) : val);
    input.value   = val;
    display.textContent = val;
}
</script>
@endpush
@endsection
