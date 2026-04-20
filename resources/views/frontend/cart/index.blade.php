@extends('layouts.storefront')

@section('title', 'Keranjang')

@push('styles')
<style>
/* ─── Animasi masuk (konsisten dengan home & katalog) ─── */
@keyframes sf-fade-up {
    from { opacity: 0; transform: translateY(18px); }
    to   { opacity: 1; transform: none; }
}
.sf-anim { animation: sf-fade-up .48s cubic-bezier(.22,1,.36,1) both; }
.sf-d1 { animation-delay: .04s; }
.sf-d2 { animation-delay: .10s; }
.sf-d3 { animation-delay: .17s; }
.sf-d4 { animation-delay: .24s; }
.sf-d5 { animation-delay: .31s; }

/* ─── Badge dot pulse ─── */
@keyframes sf-pulse { 0%,100%{opacity:1} 50%{opacity:.35} }

/* ─── Eyebrow (sama persis dengan home) ─── */
.sf-eyebrow {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: #94a3b8;
    margin-bottom: 6px;
}
.sf-eyebrow::before {
    content: '';
    display: block;
    width: 16px;
    height: 2px;
    background: #10b981;
    border-radius: 2px;
    flex-shrink: 0;
}

/* ─── Item Card ─── */
.sf-item-card {
    border: 1px solid #e2e8f0;
    border-radius: 18px;
    overflow: hidden;
    background: #ffffff;
    transition: box-shadow 0.22s ease, transform 0.22s ease;
}
.sf-item-card:hover {
    box-shadow: 0 10px 28px rgba(0,0,0,.08);
    transform: translateY(-2px);
}

/* Gambar item */
.sf-item-img-wrap {
    width: 90px;
    height: 90px;
    border-radius: 12px;
    overflow: hidden;
    flex-shrink: 0;
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
}
.sf-item-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.35s ease;
}
.sf-item-card:hover .sf-item-img { transform: scale(1.07); }
.sf-item-img-placeholder {
    width: 90px;
    height: 90px;
    border-radius: 12px;
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

/* Konten item */
.sf-item-inner {
    display: flex;
    gap: 16px;
    padding: 18px 20px;
    align-items: flex-start;
}
.sf-item-body { flex: 1; min-width: 0; }
.sf-item-cat {
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: #94a3b8;
}
.sf-item-name {
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
    margin-top: 3px;
    line-height: 1.3;
}
.sf-item-desc {
    font-size: 12px;
    line-height: 1.7;
    color: #64748b;
    margin-top: 4px;
}
.sf-item-subtotal {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 9999px;
    padding: 5px 14px;
    font-size: 13px;
    font-weight: 700;
    color: #0f172a;
    white-space: nowrap;
    flex-shrink: 0;
}

/* Actions bar */
.sf-item-actions {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
    padding: 12px 20px;
    border-top: 1px solid #f1f5f9;
    background: #fafafa;
}
.sf-qty-wrap { display: flex; align-items: center; gap: 8px; }
.sf-qty-label { font-size: 12px; font-weight: 600; color: #64748b; }
.sf-qty-box {
    display: flex;
    align-items: center;
    border: 1px solid #e2e8f0;
    border-radius: 9999px;
    overflow: hidden;
    background: #fff;
}
.sf-qty-btn {
    width: 30px;
    height: 30px;
    background: none;
    border: none;
    font-size: 16px;
    cursor: pointer;
    color: #475569;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: background 0.15s;
}
.sf-qty-btn:hover { background: #f1f5f9; }
.sf-qty-num {
    min-width: 30px;
    text-align: center;
    font-size: 13px;
    font-weight: 700;
    color: #0f172a;
}
.sf-update-btn {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 9999px;
    padding: 6px 14px;
    font-size: 12px;
    font-weight: 600;
    color: #475569;
    cursor: pointer;
    transition: border-color 0.15s, color 0.15s;
}
.sf-update-btn:hover { border-color: #94a3b8; color: #0f172a; }
.sf-right-actions { display: flex; align-items: center; gap: 10px; }
.sf-unit-price { font-size: 12px; color: #94a3b8; }
.sf-delete-btn {
    background: #fef2f2;
    border: none;
    border-radius: 9999px;
    padding: 6px 14px;
    font-size: 12px;
    font-weight: 600;
    color: #991b1b;
    cursor: pointer;
    transition: background 0.15s;
}
.sf-delete-btn:hover { background: #fee2e2; }

/* ─── Ringkasan sidebar ─── */
.sf-sum-row {
    background: #f8fafc;
    border-radius: 14px;
    padding: 12px 14px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
}
.sf-sum-row-name {
    font-size: 13px;
    font-weight: 600;
    color: #0f172a;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.sf-sum-row-qty { font-size: 12px; color: #94a3b8; margin-top: 2px; }
.sf-sum-row-price { font-size: 13px; font-weight: 700; color: #0f172a; white-space: nowrap; }

/* Total bar */
.sf-total-bar {
    background: #0f172a;
    border-radius: 16px;
    padding: 14px 18px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 16px;
}
.sf-total-label { font-size: 12px; font-weight: 500; color: #94a3b8; }
.sf-total-val { font-size: 20px; font-weight: 800; color: #fff; letter-spacing: -.02em; }

/* Checkout button */
.sf-checkout-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    background: #0f172a;
    color: #fff;
    border: none;
    border-radius: 9999px;
    padding: 13px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    margin-top: 14px;
    text-decoration: none;
    transition: background 0.18s;
}
.sf-checkout-btn:hover { background: #1e293b; }
.sf-checkout-btn svg { transition: transform 0.2s; }
.sf-checkout-btn:hover svg { transform: translateX(4px); }

/* ─── Shared buttons ─── */
.sf-btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: #0f172a;
    color: #ffffff;
    border: none;
    border-radius: 9999px;
    padding: 10px 22px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: background 0.18s;
}
.sf-btn-primary:hover { background: #1e293b; }

/* ─── Responsive ─── */
@media (max-width: 768px) {
    .sf-item-inner { flex-wrap: wrap; }
    .sf-item-subtotal { align-self: flex-end; }
    .sf-item-actions { flex-direction: column; align-items: flex-start; }
    .sf-right-actions { align-self: flex-end; }
}
</style>
@endpush

@section('content')
<section class="grid gap-6 lg:grid-cols-[minmax(0,1.1fr)_minmax(320px,0.9fr)] lg:items-start">

    {{-- ══════════════════════════════════
         PANEL KIRI — Daftar Item
    ══════════════════════════════════ --}}
    <div class="rounded-[2.2rem] border border-slate-200 bg-white p-8 shadow-sm sf-anim sf-d1">

        <p class="sf-eyebrow">Kelola Keranjang</p>
        <h1 class="mt-1 text-xl font-black tracking-tight text-slate-950">Keranjang Belanja</h1>
        <p class="mt-2 text-sm leading-7 text-slate-500">
            Database-backed cart yang terpisah dari checkout aktif.
            Item baru tetap aman di keranjang dan baru masuk ke checkout saat tombol lanjut ditekan.
        </p>

        @if ($cart->items->isNotEmpty())
            <div class="mt-7 flex flex-col gap-4">
                @foreach ($cart->items as $index => $item)
                    <article class="sf-item-card sf-anim" style="animation-delay: {{ 0.08 + $index * 0.08 }}s">

                        <div class="sf-item-inner">

                            {{-- Gambar produk --}}
                            @if ($item->product->primary_image_url)
                                <div class="sf-item-img-wrap">
                                    <img
                                        class="sf-item-img"
                                        src="{{ $item->product->primary_image_url }}"
                                        alt="{{ $item->product->name }}"
                                        loading="lazy"
                                        onerror="this.parentElement.innerHTML='<div class=\'sf-item-img-placeholder\'><svg xmlns=\'http://www.w3.org/2000/svg\' width=\'24\' height=\'24\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'#cbd5e1\' stroke-width=\'1.5\' stroke-linecap=\'round\' stroke-linejoin=\'round\'><rect x=\'2\' y=\'7\' width=\'20\' height=\'14\' rx=\'2\'/><path d=\'M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2\'/></svg></div>'"
                                    >
                                </div>
                            @else
                                <div class="sf-item-img-placeholder">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="2" y="7" width="20" height="14" rx="2"/>
                                        <path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/>
                                    </svg>
                                </div>
                            @endif

                            {{-- Konten item --}}
                            <div class="sf-item-body">
                                <p class="sf-item-cat">{{ $item->product->primary_category_name }}</p>
                                <h2 class="sf-item-name">{{ $item->product->name }}</h2>
                                @if ($item->product->summary)
                                    <p class="sf-item-desc">{{ Str::limit($item->product->summary, 90) }}</p>
                                @endif
                            </div>

                            <div class="sf-item-subtotal">{{ $item->subtotal_label }}</div>
                        </div>

                        {{-- Actions bar --}}
                        <div class="sf-item-actions">
                            <form method="POST" action="{{ route('cart.items.update', $item) }}" class="sf-qty-wrap">
                                @csrf
                                @method('PATCH')
                                <span class="sf-qty-label">Qty</span>
                                <div class="sf-qty-box">
                                    <button
                                        type="button"
                                        class="sf-qty-btn"
                                        onclick="adjustQty('qty-{{ $item->id }}', -1)"
                                        aria-label="Kurangi"
                                    >−</button>
                                    <span class="sf-qty-num" id="qty-display-{{ $item->id }}">{{ $item->quantity }}</span>
                                    <input
                                        type="hidden"
                                        id="qty-{{ $item->id }}"
                                        name="quantity"
                                        value="{{ $item->quantity }}"
                                        min="1"
                                        max="{{ $item->product->stock }}"
                                    >
                                    <button
                                        type="button"
                                        class="sf-qty-btn"
                                        onclick="adjustQty('qty-{{ $item->id }}', 1, {{ $item->product->stock }})"
                                        aria-label="Tambah"
                                    >+</button>
                                </div>
                                <button type="submit" class="sf-update-btn">Perbarui</button>
                            </form>

                            <div class="sf-right-actions">
                                <span class="sf-unit-price">{{ $item->quantity }} × {{ $item->unit_price_label }}</span>
                                <form method="POST" action="{{ route('cart.items.destroy', $item) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="sf-delete-btn">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

        @else
            {{-- Keranjang kosong --}}
            <div class="mt-8 rounded-[2rem] border border-dashed border-slate-200 bg-slate-50 p-10 text-center sf-anim sf-d2">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/>
                        <line x1="3" y1="6" x2="21" y2="6"/>
                        <path d="M16 10a4 4 0 0 1-8 0"/>
                    </svg>
                </div>
                <p class="mt-5 text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Keranjang Kosong</p>
                <h3 class="mt-3 text-2xl font-black tracking-tight text-slate-950">Keranjang kamu masih kosong.</h3>
                <p class="mx-auto mt-4 max-w-sm text-sm leading-7 text-slate-500">
                    Tambahkan produk dari katalog untuk mulai checkout. Semua item disimpan di database berdasarkan user yang login.
                </p>
                <a href="{{ route('products.index') }}" class="sf-btn-primary mx-auto mt-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                    Jelajahi Produk
                </a>
            </div>
        @endif
    </div>

    {{-- ══════════════════════════════════
         PANEL KANAN — Ringkasan & Checkout
    ══════════════════════════════════ --}}
    <div class="flex flex-col gap-4 sf-anim sf-d3">

        {{-- Ringkasan --}}
        <aside class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-base font-bold text-slate-950">Ringkasan Keranjang</h3>

            <div class="mt-5 flex flex-col gap-3">
                @forelse ($cart->items as $item)
                    <div class="sf-sum-row">
                        <div class="min-w-0">
                            <p class="sf-sum-row-name">{{ $item->product->name }}</p>
                            <p class="sf-sum-row-qty">{{ $item->quantity }} × {{ $item->unit_price_label }}</p>
                        </div>
                        <p class="sf-sum-row-price">{{ $item->subtotal_label }}</p>
                    </div>
                @empty
                    <div class="rounded-2xl bg-slate-50 p-4 text-sm text-slate-500">
                        Belum ada item aktif di keranjang.
                    </div>
                @endforelse
            </div>

            <div class="mt-5 space-y-3 border-t border-slate-100 pt-5 text-sm">
                <div class="flex items-center justify-between text-slate-600">
                    <span>Total item</span>
                    <span class="font-semibold text-slate-800">{{ $cart->total_items }}</span>
                </div>
                <div class="flex items-center justify-between text-slate-600">
                    <span>Subtotal</span>
                    <span class="font-semibold text-slate-800">{{ $cart->subtotal_label }}</span>
                </div>
            </div>

            <div class="sf-total-bar">
                <span class="sf-total-label">Total Keranjang</span>
                <span class="sf-total-val">{{ $cart->total_label }}</span>
            </div>
        </aside>

        {{-- Lanjut Checkout --}}
        <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sf-anim sf-d4">
            <p class="text-sm font-bold text-slate-950">Langkah Berikutnya</p>
            <div class="mt-3 rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-4 text-sm leading-7 text-slate-500">
                Checkout akan memakai snapshot terbaru dari keranjang saat tombol ini ditekan, jadi item yang baru ditambahkan tidak otomatis ikut.
            </div>
            <form method="POST" action="{{ route('checkout.prepare') }}">
                @csrf
                <button type="submit" class="sf-checkout-btn">
                    Lanjut ke Checkout
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </button>
            </form>
        </div>
    </div>
</section>

{{-- ── FAB Keranjang (konsisten dengan home & katalog) ── --}}
<a href="{{ route('cart.index') }}" class="sf-fab" aria-label="Buka Keranjang" style="
    position: fixed; bottom: 32px; right: 32px; z-index: 100;
    display: inline-flex; align-items: center; gap: 8px;
    background: #0f172a; color: #fff; text-decoration: none;
    border-radius: 9999px; padding: 13px 22px;
    font-size: 14px; font-weight: 600;
    box-shadow: 0 4px 20px rgba(15,23,42,.30), 0 1px 4px rgba(15,23,42,.15);
    animation: sf-fab-in .6s cubic-bezier(.34,1.56,.64,1) .7s both;
    transition: transform .2s, box-shadow .2s, background .15s;
">
    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24"
         fill="none" stroke="currentColor" stroke-width="2"
         stroke-linecap="round" stroke-linejoin="round">
        <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/>
        <line x1="3" y1="6" x2="21" y2="6"/>
        <path d="M16 10a4 4 0 0 1-8 0"/>
    </svg>
    <span>Keranjang</span>
    @if ($cartCount > 0)
        <span style="
            background: #10b981; color: #fff; border-radius: 9999px;
            padding: 2px 7px; font-size: 11px; font-weight: 700;
            min-width: 20px; height: 20px;
            display: inline-flex; align-items: center; justify-content: center;
        ">{{ $cartCount > 99 ? '99+' : $cartCount }}</span>
    @endif
</a>

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
