@push('styles')
<style>
/* ─── FAB ─── */
.sf-fab {
    position: fixed;
    bottom: 32px;
    right: 32px;
    z-index: 100;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #111111;
    color: #ffffff;
    text-decoration: none;
    border-radius: 9999px;
    padding: 13px 22px;
    font-size: 14px;
    font-weight: 600;
    border: 1px solid rgba(255,255,255,0.12);
    box-shadow: 0 4px 24px rgba(0,0,0,0.6);
    transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.15s;
    animation: sf-fab-in .6s cubic-bezier(.34,1.56,.64,1) .8s both;
    cursor: pointer;
}
@keyframes sf-fab-in {
    from { transform: translateY(50px) scale(.8); opacity: 0; }
    to   { transform: none; opacity: 1; }
}
.sf-fab:hover {
    background: #1a1a1a;
    transform: translateY(-3px);
    box-shadow: 0 12px 36px rgba(0,0,0,0.7);
}
.sf-fab:active { transform: translateY(-1px); }
.sf-fab-badge {
    background: #5eead4;
    color: #000000;
    border-radius: 9999px;
    padding: 2px 7px;
    font-size: 11px;
    font-weight: 700;
    min-width: 20px;
    height: 20px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

@media (max-width: 640px) {
    .sf-fab { bottom: 20px; right: 20px; padding: 11px 18px; font-size: 13px; }
}
</style>
@endpush

<button
    type="button"
    onclick="window.dispatchEvent(new CustomEvent('open-cart-drawer'))"
    class="sf-fab"
    aria-label="Buka Keranjang"
>
    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/>
        <line x1="3" y1="6" x2="21" y2="6"/>
        <path d="M16 10a4 4 0 0 1-8 0"/>
    </svg>
    <span>Keranjang</span>
    @if (($cartCount ?? 0) > 0)
        <span class="sf-fab-badge">{{ $cartCount > 99 ? '99+' : $cartCount }}</span>
    @endif
</button>
