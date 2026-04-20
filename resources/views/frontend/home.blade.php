@extends('layouts.storefront')

@section('title', 'Beranda')
@section('meta_description', 'Beranda storefront modern untuk StockFlow Commerce berbasis Laravel Blade.')

@push('styles')
<style>
/* ─── Animasi masuk ─── */
@keyframes sf-fade-up {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: none; }
}
.sf-anim {
    animation: sf-fade-up .5s cubic-bezier(.22,1,.36,1) both;
}
.sf-d1 { animation-delay: .04s; }
.sf-d2 { animation-delay: .12s; }
.sf-d3 { animation-delay: .20s; }
.sf-d4 { animation-delay: .28s; }
.sf-d5 { animation-delay: .36s; }
.sf-d6 { animation-delay: .44s; }
.sf-d7 { animation-delay: .52s; }
[x-cloak] { display: none !important; }

/* ─── Hero ─── */
.sf-hero-grid {
    position: relative;
    width: 100vw;
    margin-left: calc(50% - 50vw);
    min-height: 100vh;
    padding-top: 0;
}
.sf-hero-main {
    background: transparent;
    border: 0;
    border-radius: 0;
    padding: 0;
}
.sf-hero-aside {
    display: none;
}
.sf-carousel-shell {
    position: relative;
    min-height: 100vh;
    overflow: hidden;
    border-radius: 0;
    border: 0;
    background:
        radial-gradient(circle at top left, rgba(45, 212, 191, 0.28), transparent 24%),
        radial-gradient(circle at 88% 18%, rgba(251, 146, 60, 0.22), transparent 18%),
        linear-gradient(145deg, #020617 0%, #0f172a 46%, #111827 100%);
    box-shadow: none;
}
.sf-carousel-slide {
    position: absolute;
    inset: 0;
    min-height: 100vh;
    padding: 7.25rem 4.5rem 3rem;
    transition: transform .75s cubic-bezier(.22,1,.36,1);
    will-change: transform;
}
.sf-carousel-copy {
    position: relative;
    z-index: 2;
    display: flex;
    min-width: 0;
    flex-direction: column;
    justify-content: center;
    min-height: calc(100vh - 10.25rem);
    max-width: 44rem;
}
.sf-carousel-copy-top {
    max-width: 42rem;
}
.sf-carousel-kicker {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    color: #cbd5e1;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.32em;
    text-transform: uppercase;
}
.sf-carousel-kicker::before {
    content: '';
    width: 26px;
    height: 1px;
    background: rgba(255,255,255,.45);
}
.sf-carousel-title {
    margin-top: 18px;
    max-width: 10ch;
    font-size: clamp(3.25rem, 6vw, 5.8rem);
    line-height: .95;
    letter-spacing: -0.06em;
    font-weight: 900;
    color: #f8fafc;
    text-shadow: 0 14px 40px rgba(2, 6, 23, 0.38);
}
.sf-carousel-copy .sf-badge {
    margin-top: 26px;
    background: rgba(240, 253, 249, 0.1);
    border-color: rgba(110, 231, 183, 0.28);
    color: #99f6e4;
}
.sf-carousel-copy .sf-lead {
    margin-top: 18px;
    max-width: 34rem;
    color: #cbd5e1;
    font-size: 16px;
    text-shadow: 0 12px 30px rgba(2, 6, 23, 0.34);
}
.sf-carousel-copy .sf-cta-row {
    margin-top: 30px;
}
.sf-carousel-copy .sf-btn-primary {
    background: #f8fafc;
    color: #0f172a;
}
.sf-carousel-copy .sf-btn-primary:hover { background: #e2e8f0; }
.sf-carousel-copy .sf-btn-outline {
    background: rgba(255,255,255,0.06);
    color: #f8fafc;
    border-color: rgba(255,255,255,0.16);
    backdrop-filter: blur(12px);
}
.sf-carousel-copy .sf-btn-outline:hover {
    border-color: rgba(255,255,255,0.28);
    color: #ffffff;
}
.sf-carousel-visual {
    position: absolute;
    inset: 0;
    z-index: 0;
}
.sf-carousel-visual-card {
    position: relative;
    width: 100%;
    height: 100%;
    overflow: hidden;
    border-radius: 0;
    border: 0;
    background: #0f172a;
    box-shadow: none;
}
.sf-carousel-visual-media {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transform: scale(1.01);
}
.sf-carousel-visual-overlay {
    position: absolute;
    inset: 0;
    background:
        linear-gradient(90deg, rgba(2,6,23,0.72) 0%, rgba(2,6,23,0.34) 36%, rgba(2,6,23,0.18) 60%, rgba(2,6,23,0.7) 100%),
        linear-gradient(180deg, rgba(15,23,42,0.08) 0%, rgba(2,6,23,0.5) 100%),
        radial-gradient(circle at top right, rgba(255,255,255,0.16), transparent 24%);
}
.sf-carousel-visual-content {
    position: relative;
    z-index: 1;
    display: flex;
    min-height: 100vh;
    flex-direction: column;
    justify-content: flex-start;
    padding: 7.25rem 4.5rem 3rem;
}
.sf-carousel-visual-tag {
    display: inline-flex;
    width: fit-content;
    align-items: center;
    gap: 8px;
    border-radius: 9999px;
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.14);
    padding: 8px 14px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    color: #f8fafc;
    backdrop-filter: blur(14px);
}
.sf-carousel-visual-tag::before {
    content: '';
    width: 7px;
    height: 7px;
    border-radius: 9999px;
    background: #5eead4;
}
.sf-carousel-product {
    width: 100%;
    max-width: 25rem;
    margin-left: auto;
    border-radius: 1.5rem;
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.12);
    padding: 1.25rem;
    backdrop-filter: blur(18px);
}
.sf-carousel-product-label {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.24em;
    text-transform: uppercase;
    color: #cbd5e1;
}
.sf-carousel-product-title {
    margin-top: 10px;
    font-size: clamp(1.6rem, 3vw, 2.5rem);
    line-height: 1.05;
    letter-spacing: -0.04em;
    font-weight: 800;
    color: #ffffff;
}
.sf-carousel-product-text {
    margin-top: 10px;
    max-width: 24rem;
    font-size: 14px;
    line-height: 1.8;
    color: #e2e8f0;
}
.sf-carousel-product-footer {
    margin-top: 18px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
}
.sf-carousel-product-price {
    font-size: 1.55rem;
    font-weight: 800;
    letter-spacing: -0.04em;
    color: #ffffff;
}
.sf-carousel-product-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    border-radius: 9999px;
    background: #ffffff;
    color: #0f172a;
    padding: 10px 16px;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    transition: background 0.18s ease, transform 0.18s ease;
}
.sf-carousel-product-link:hover {
    background: #e2e8f0;
    transform: translateY(-1px);
}
.sf-carousel-arrows {
    display: none;
}
.sf-carousel-arrow {
    display: none;
}
.sf-carousel-arrow:hover {
    display: none;
}
.sf-carousel-hotspot-next {
    position: absolute;
    inset: 0 0 0 auto;
    z-index: 4;
    width: min(32vw, 320px);
    height: 100%;
    cursor: e-resize;
}

/* ─── Badge ─── */
.sf-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #f0fdf9;
    border: 1px solid #6ee7b7;
    border-radius: 9999px;
    padding: 5px 14px;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: #065f46;
}
.sf-badge-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #10b981;
    flex-shrink: 0;
    animation: sf-pulse 2s ease-in-out infinite;
}
@keyframes sf-pulse {
    0%, 100% { opacity: 1; }
    50%       { opacity: .35; }
}

/* ─── Typography ─── */
.sf-h1 {
    margin-top: 20px;
    font-size: 40px;
    font-weight: 700;
    line-height: 1.08;
    letter-spacing: -0.03em;
    color: #0f172a;
    max-width: 480px;
}
.sf-lead {
    margin-top: 14px;
    font-size: 15px;
    line-height: 1.75;
    color: #64748b;
    max-width: 420px;
}

/* ─── CTA ─── */
.sf-cta-row {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 24px;
}
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
.sf-btn-outline {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: #ffffff;
    color: #475569;
    border: 1px solid #cbd5e1;
    border-radius: 9999px;
    padding: 10px 22px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: border-color 0.18s, color 0.18s;
}
.sf-btn-outline:hover { border-color: #94a3b8; color: #0f172a; }

/* ─── Metrics ─── */
.sf-metrics {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
    margin-top: 28px;
    padding-top: 24px;
    border-top: 1px solid #f1f5f9;
}
.sf-metric {
    background: #f8fafc;
    border-radius: 14px;
    padding: 14px 16px;
}
.sf-metric-label {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: #94a3b8;
}
.sf-metric-value {
    font-size: 24px;
    font-weight: 700;
    color: #0f172a;
    margin-top: 5px;
    line-height: 1;
}

/* ─── Spotlight Aside ─── */
.sf-aside-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 20px 14px;
}
.sf-aside-eyebrow {
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: #64748b;
}
.sf-aside-cat-pill {
    background: rgba(255,255,255,0.08);
    color: #94a3b8;
    border-radius: 9999px;
    padding: 4px 12px;
    font-size: 10px;
    font-weight: 500;
    letter-spacing: 0.1em;
}

/* Gambar spotlight dengan glass overlay */
.sf-aside-img-wrap {
    margin: 0 14px;
    border-radius: 14px;
    overflow: hidden;
    position: relative;
}
.sf-aside-img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    display: block;
    border-radius: 14px;
    transition: transform 0.4s ease;
}
.sf-aside-img-wrap:hover .sf-aside-img {
    transform: scale(1.04);
}
.sf-aside-img-gradient {
    position: absolute;
    inset: 0;
    background: linear-gradient(160deg, rgba(15,23,42,.5) 0%, rgba(15,23,42,.05) 60%);
    border-radius: 14px;
    pointer-events: none;
}
.sf-aside-glass {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(255,255,255,0.76);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    border-top: 1px solid rgba(255,255,255,0.4);
    border-radius: 0 0 14px 14px;
    padding: 14px 16px;
}

/* Fallback jika gambar gagal dimuat */
.sf-aside-cover {
    margin: 0 14px;
    border-radius: 14px;
    overflow: hidden;
}
.sf-aside-cover-inner {
    background: rgba(255,255,255,0.72);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.3);
    border-radius: 14px;
    padding: 20px;
}
.sf-aside-cover-cat {
    font-size: 11px;
    font-weight: 600;
    color: #64748b;
}
.sf-aside-cover-name {
    font-size: 20px;
    font-weight: 800;
    color: #0f172a;
    margin-top: 6px;
    line-height: 1.2;
    letter-spacing: -0.02em;
}
.sf-aside-cover-desc {
    font-size: 13px;
    line-height: 1.65;
    color: #475569;
    margin-top: 8px;
}
.sf-aside-price-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin: 12px 14px 14px;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 14px;
    padding: 14px 16px;
}
.sf-aside-price-label {
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    color: #64748b;
}
.sf-aside-price-value {
    font-size: 22px;
    font-weight: 800;
    color: #f8fafc;
    margin-top: 4px;
}
.sf-aside-price-btn {
    background: #ffffff;
    color: #0f172a;
    border: none;
    border-radius: 9999px;
    padding: 9px 18px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: background 0.15s;
    white-space: nowrap;
}
.sf-aside-price-btn:hover { background: #f1f5f9; }

/* ─── Section Heading ─── */
.sf-section-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 18px;
}
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
    width: 18px;
    height: 2px;
    background: #0f172a;
    border-radius: 2px;
    flex-shrink: 0;
}
.sf-section-title {
    font-size: 18px;
    font-weight: 700;
    color: #0f172a;
    letter-spacing: -0.015em;
    line-height: 1.3;
}
.sf-link-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 9999px;
    padding: 8px 16px;
    font-size: 13px;
    font-weight: 600;
    color: #64748b;
    text-decoration: none;
    transition: border-color 0.15s, color 0.15s;
    white-space: nowrap;
}
.sf-link-pill:hover { border-color: #94a3b8; color: #0f172a; }

/* ─── Product Grid ─── */
.sf-product-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
}
.sf-product-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 18px;
    overflow: hidden;
    transition: transform 0.22s ease, box-shadow 0.22s ease;
    cursor: pointer;
}
.sf-product-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 36px rgba(0,0,0,0.10);
}

/* Gambar produk */
.sf-product-img {
    width: 100%;
    height: 130px;
    object-fit: cover;
    display: block;
    background: #f8fafc;
    transition: transform 0.35s ease;
}
.sf-product-card:hover .sf-product-img {
    transform: scale(1.05);
}
.sf-product-img-placeholder {
    width: 100%;
    height: 130px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    font-size: 40px;
}

.sf-product-body {
    padding: 16px 18px;
}
.sf-product-name {
    font-size: 14px;
    font-weight: 700;
    color: #0f172a;
    line-height: 1.3;
}
.sf-product-price {
    margin-top: 4px;
    font-size: 13px;
    color: #94a3b8;
}
.sf-product-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 14px;
}
.sf-stock-green {
    background: #f1f5f9;
    color: #0f172a;
    border-radius: 9999px;
    padding: 3px 10px;
    font-size: 11px;
    font-weight: 600;
}
.sf-stock-amber {
    background: #e2e8f0;
    color: #0f172a;
    border-radius: 9999px;
    padding: 3px 10px;
    font-size: 11px;
    font-weight: 600;
}
.sf-stock-red {
    background: #0f172a;
    color: #ffffff;
    border-radius: 9999px;
    padding: 3px 10px;
    font-size: 11px;
    font-weight: 600;
}
.sf-arrow-btn {
    width: 30px;
    height: 30px;
    background: #0f172a;
    border: none;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    text-decoration: none;
    transition: background 0.15s, transform 0.15s;
    flex-shrink: 0;
}
.sf-arrow-btn:hover { background: #334155; transform: scale(1.1); }

/* ─── Bottom Section ─── */
.sf-bottom-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    align-items: start;
}
.sf-card-white {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    padding: 28px 30px;
}
.sf-cat-chips {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 18px;
}
.sf-cat-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #fafafa;
    border: 1px solid #e5e5e5;
    border-radius: 9999px;
    padding: 7px 14px;
    font-size: 13px;
    font-weight: 500;
    color: #262626;
    text-decoration: none;
    cursor: pointer;
    transition: background 0.15s, border-color 0.15s, transform 0.15s;
}
.sf-cat-chip:hover { background: #ffffff; border-color: #171717; transform: translateY(-1px); }
.sf-cat-count {
    background: #0f172a;
    color: #ffffff;
    border-radius: 9999px;
    padding: 1px 7px;
    font-size: 10px;
    font-weight: 700;
}

/* Flow cards */
.sf-flow-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
}
.sf-flow-card {
    background: #ffffff;
    border: 1px solid #e5e5e5;
    border-radius: 18px;
    padding: 22px;
    display: flex;
    flex-direction: column;
    transition: transform 0.2s, box-shadow 0.2s;
}
.sf-flow-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 28px rgba(0,0,0,0.07);
}
.sf-flow-icon {
    width: 38px;
    height: 38px;
    background: #fafafa;
    border: 1px solid #e5e5e5;
    color: #0f172a;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.sf-flow-eyebrow {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    color: #737373;
    margin-top: 14px;
}
.sf-flow-title {
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
    line-height: 1.35;
    margin-top: 6px;
    flex: 1;
}
.sf-flow-desc {
    font-size: 13px;
    line-height: 1.65;
    color: #525252;
    margin-top: 8px;
}

/* ─── FAB ─── */
.sf-fab {
    position: fixed;
    bottom: 32px;
    right: 32px;
    z-index: 100;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #0f172a;
    color: #ffffff;
    text-decoration: none;
    border-radius: 9999px;
    padding: 13px 22px;
    font-size: 14px;
    font-weight: 600;
    box-shadow: 0 4px 20px rgba(15,23,42,.30), 0 1px 4px rgba(15,23,42,.15);
    transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.15s;
    animation: sf-fab-in .6s cubic-bezier(.34,1.56,.64,1) .8s both;
}
@keyframes sf-fab-in {
    from { transform: translateY(50px) scale(.8); opacity: 0; }
    to   { transform: none; opacity: 1; }
}
.sf-fab:hover {
    background: #1e293b;
    transform: translateY(-3px);
    box-shadow: 0 12px 36px rgba(15,23,42,.35), 0 2px 6px rgba(15,23,42,.18);
}
.sf-fab:active { transform: translateY(-1px); }
.sf-fab-badge {
    background: #ffffff;
    color: #0f172a;
    border-radius: 9999px;
    padding: 2px 7px;
    font-size: 11px;
    font-weight: 700;
    min-width: 20px;
    height: 20px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    line-height: 1;
}

/* ─── Responsive ─── */
@media (max-width: 1024px) {
    .sf-hero-grid {
        min-height: auto;
        padding-top: 0;
    }
    .sf-carousel-shell,
    .sf-carousel-slide {
        min-height: auto;
    }
    .sf-carousel-slide {
        padding: 6.5rem 2rem 2rem;
    }
    .sf-carousel-visual {
        inset: 0;
    }
    .sf-carousel-copy {
        min-height: calc(100vh - 8.5rem);
        max-width: 36rem;
    }
    .sf-carousel-visual-content {
        min-height: 100vh;
        padding: 6.5rem 2rem 2rem;
    }
    .sf-product-grid { grid-template-columns: repeat(2, 1fr); }
    .sf-bottom-grid { grid-template-columns: 1fr; }
}
@media (max-width: 640px) {
    .sf-hero-grid {
        padding-top: 0;
    }
    .sf-carousel-slide {
        padding: 6rem 1.2rem 1.2rem;
        gap: 1.25rem;
    }
    .sf-carousel-title {
        font-size: 42px;
        max-width: 100%;
    }
    .sf-carousel-copy .sf-lead {
        font-size: 15px;
    }
    .sf-carousel-copy {
        min-height: calc(100vh - 7.2rem);
        max-width: 100%;
    }
    .sf-carousel-visual-content {
        min-height: 100vh;
        padding: 6rem 1.2rem 1.2rem;
    }
    .sf-carousel-product {
        max-width: 100%;
    }
    .sf-carousel-product-footer {
        flex-direction: column;
        align-items: flex-start;
    }
    .sf-carousel-arrows {
        right: 14px;
        bottom: 14px;
    }
    .sf-h1 { font-size: 30px; }
    .sf-metrics { grid-template-columns: repeat(3, 1fr); gap: 8px; }
    .sf-product-grid { grid-template-columns: repeat(2, 1fr); }
    .sf-flow-grid { grid-template-columns: 1fr; }
    .sf-fab { bottom: 20px; right: 20px; padding: 11px 18px; font-size: 13px; }
}
</style>
@endpush

@section('content')

{{-- ══════════════════════════════════════════════════════
     SECTION 1 — HERO
══════════════════════════════════════════════════════ --}}
@php
    $heroSlides = collect([
        [
            'kicker' => 'Kurasi Minggu Ini',
            'badge' => 'Platform Modern',
            'title' => 'Pengalaman belanja modern yang rapi dan siap dipresentasikan.',
            'description' => 'Fondasi visual untuk katalog, detail produk, keranjang, dan checkout. Semua komponen dirancang reusable agar mudah di-scale.',
            'primary_label' => 'Jelajahi Produk',
            'primary_href' => route('products.index'),
            'secondary_label' => 'Lihat Checkout',
            'secondary_href' => route('checkout.index'),
            'feature_label' => $spotlightProduct['category'] ?? 'Sorotan',
            'feature_title' => $spotlightProduct['name'] ?? 'StockFlow Commerce',
            'feature_text' => $spotlightProduct['description'] ?? 'Kurasi produk siap pakai dengan presentasi visual yang terasa premium sejak layar pertama.',
            'price_label' => $spotlightProduct['price_label'] ?? 'Mulai dari sekarang',
            'product_href' => filled($spotlightProduct['slug'] ?? null) ? route('products.show', $spotlightProduct['slug']) : route('products.index'),
            'image_url' => asset('img/parfum.jpg'),
        ],
        [
            'kicker' => 'Footwear Edit',
            'badge' => 'Highlight Produk',
            'title' => 'Slide besar yang langsung membawa fokus ke kategori favorit.',
            'description' => 'Header carousel ini dibuat untuk menampilkan koleksi unggulan dengan ritme visual yang lebih hidup daripada hero statis biasa.',
            'primary_label' => 'Lihat Katalog',
            'primary_href' => route('products.index'),
            'secondary_label' => 'Buka Keranjang',
            'secondary_href' => route('cart.index'),
            'feature_label' => 'Shoes',
            'feature_title' => 'Pilihan sepatu yang tampil editorial sejak landing pertama.',
            'feature_text' => 'Cocok untuk menonjolkan campaign, kategori baru, atau produk dengan foto yang ingin benar-benar dijual lewat visual.',
            'price_label' => 'Explore now',
            'product_href' => route('products.index'),
            'image_url' => asset('img/soes.jpg'),
        ],
        [
            'kicker' => 'Fashion Rail',
            'badge' => 'Visual Display',
            'title' => 'Hero satu layar dengan transisi halus bikin beranda terasa lebih premium.',
            'description' => 'Navbar transparan dan carousel full-screen memberi kesan lebih modern saat halaman pertama kali dibuka, tanpa mengganggu flow katalog di bawahnya.',
            'primary_label' => 'Mulai Belanja',
            'primary_href' => route('products.index'),
            'secondary_label' => 'Lihat Detail',
            'secondary_href' => filled($spotlightProduct['slug'] ?? null) ? route('products.show', $spotlightProduct['slug']) : route('products.index'),
            'feature_label' => 'Clothes',
            'feature_title' => 'Area hero sekarang punya ritme presentasi yang lebih dinamis.',
            'feature_text' => 'Setiap slide bisa dipakai untuk memperlihatkan karakter produk yang berbeda, dari fashion sampai fragrance.',
            'price_label' => 'New collection',
            'product_href' => route('products.index'),
            'image_url' => asset('img/chlotes.jpeg'),
        ],
    ])->values();
@endphp

<section
    class="sf-hero-grid sf-anim sf-d1"
    x-data="{
        active: 0,
        total: {{ $heroSlides->count() }},
        timer: null,
        next() { this.active = (this.active + 1) % this.total; },
        prev() { this.active = (this.active - 1 + this.total) % this.total; },
        start() {
            if (this.total < 2 || this.timer) return;
            this.timer = setInterval(() => this.next(), 5200);
        },
        stop() {
            if (! this.timer) return;
            clearInterval(this.timer);
            this.timer = null;
        },
    }"
    x-init="start()"
    @mouseenter="stop()"
    @mouseleave="start()"
>
    <div class="sf-carousel-shell">
        @foreach ($heroSlides as $index => $slide)
            <article
                x-cloak
                class="sf-carousel-slide"
                :style="{ transform: 'translateX(' + (({{ $index }} - active) * 100) + '%)' }"
            >
                <div class="sf-carousel-visual">
                    <div class="sf-carousel-visual-card">
                        <img src="{{ $slide['image_url'] }}" alt="{{ $slide['feature_title'] }}" class="sf-carousel-visual-media" loading="eager">
                        <div class="sf-carousel-visual-overlay"></div>

                        <div class="sf-carousel-visual-content">
                        </div>
                    </div>
                </div>
            </article>
        @endforeach

        <button
            type="button"
            class="sf-carousel-hotspot-next"
            x-on:click="next(); stop(); start();"
            aria-label="Slide berikutnya"
        ></button>
    </div>
</section>

<section class="hidden">

    {{-- Konten Utama --}}
    <div class="sf-hero-main">
        <span class="sf-badge">
            <span class="sf-badge-dot"></span>
            Platform Modern
        </span>

        <h1 class="sf-h1">
            Pengalaman belanja modern yang rapi dan siap dipresentasikan.
        </h1>

        <p class="sf-lead">
            Fondasi visual untuk katalog, detail produk, keranjang, dan checkout.
            Semua komponen dirancang reusable agar mudah di-scale.
        </p>

        <div class="sf-cta-row">
            <a href="{{ route('products.index') }}" class="sf-btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                Jelajahi Produk
            </a>
            <a href="{{ route('checkout.index') }}" class="sf-btn-outline">
                Lihat Checkout
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="sf-metrics">
            @foreach ($stats as $stat)
                <div class="sf-metric">
                    <p class="sf-metric-label">{{ $stat['label'] }}</p>
                    <p class="sf-metric-value">{{ $stat['value'] }}</p>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Spotlight Card --}}
    <aside class="sf-hero-aside sf-anim sf-d2">
        <div class="sf-aside-header">
            <span class="sf-aside-eyebrow">Sorotan</span>
            <span class="sf-aside-cat-pill">{{ $spotlightProduct['category'] }}</span>
        </div>

        {{-- Gunakan image jika ada, fallback ke glass card --}}
        @if (!empty($spotlightProduct['image_url']))
            <div class="sf-aside-img-wrap">
                <img
                    class="sf-aside-img"
                    src="{{ $spotlightProduct['image_url'] }}"
                    alt="{{ $spotlightProduct['name'] }}"
                    loading="lazy"
                >
                <div class="sf-aside-img-gradient"></div>
                <div class="sf-aside-glass">
                    <p class="sf-aside-cover-cat">{{ $spotlightProduct['category'] }}</p>
                    <h2 class="sf-aside-cover-name">{{ $spotlightProduct['name'] }}</h2>
                </div>
            </div>
        @else
            <div class="sf-aside-cover" style="{{ $spotlightProduct['cover_style'] ?? '' }}">
                <div class="sf-aside-cover-inner">
                    <p class="sf-aside-cover-cat">{{ $spotlightProduct['category'] }}</p>
                    <h2 class="sf-aside-cover-name">{{ $spotlightProduct['name'] }}</h2>
                    <p class="sf-aside-cover-desc">{{ $spotlightProduct['description'] }}</p>
                </div>
            </div>
        @endif

        <div class="sf-aside-price-row">
            <div>
                <p class="sf-aside-price-label">Harga</p>
                <p class="sf-aside-price-value">{{ $spotlightProduct['price_label'] }}</p>
            </div>
            <a href="{{ route('products.show', $spotlightProduct['slug']) }}" class="sf-aside-price-btn">
                Lihat →
            </a>
        </div>
    </aside>
</section>


{{-- ══════════════════════════════════════════════════════
     SECTION 2 — FEATURED PRODUCTS
══════════════════════════════════════════════════════ --}}
<section class="sf-anim sf-d3" style="margin-top: 28px;">
    <div class="sf-section-header">
        <div>
            <p class="sf-eyebrow">Pilihan Unggulan</p>
            <h2 class="sf-section-title">Produk disusun rapi untuk kesan profesional sejak tampilan pertama.</h2>
        </div>
        <a href="{{ route('products.index') }}" class="sf-link-pill">
            Lihat semua
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
    </div>

    <div class="sf-product-grid">
        @foreach ($featuredProducts as $index => $product)
            <div class="sf-product-card sf-anim sf-d{{ min($index + 4, 7) }}">

                {{-- Gambar produk --}}
                @if (!empty($product['image_url']))
                    <img
                        class="sf-product-img"
                        src="{{ $product['image_url'] }}"
                        alt="{{ $product['name'] }}"
                        loading="lazy"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                    >
                    <div class="sf-product-img-placeholder" style="display:none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                    </div>
                @elseif (!empty($product['image']))
                    {{-- Support gambar dari relasi model Product --}}
                    <img
                        class="sf-product-img"
                        src="{{ Storage::url($product['image']) }}"
                        alt="{{ $product['name'] }}"
                        loading="lazy"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                    >
                    <div class="sf-product-img-placeholder" style="display:none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                    </div>
                @else
                    <div class="sf-product-img-placeholder">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                    </div>
                @endif

                <div class="sf-product-body">
                    <p class="sf-product-name">{{ $product['name'] }}</p>
                    <p class="sf-product-price">{{ $product['price_label'] }}</p>

                    <div class="sf-product-footer">
                        @if(isset($product['stock']))
                            @if($product['stock'] > 10)
                                <span class="sf-stock-green">Stok {{ $product['stock'] }}</span>
                            @elseif($product['stock'] > 0)
                                <span class="sf-stock-amber">Stok {{ $product['stock'] }}</span>
                            @else
                                <span class="sf-stock-red">Habis</span>
                            @endif
                        @else
                            <span></span>
                        @endif

                        <a href="{{ route('products.show', $product['slug']) }}" class="sf-arrow-btn" aria-label="Lihat {{ $product['name'] }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>


{{-- ══════════════════════════════════════════════════════
     SECTION 3 — KATEGORI + FLOW CARDS
══════════════════════════════════════════════════════ --}}
<section class="sf-bottom-grid sf-anim sf-d6" style="margin-top: 28px;">

    {{-- Kategori --}}
    <div class="sf-card-white">
        <p class="sf-eyebrow">Kategori</p>
        <h3 class="sf-section-title">Katalog yang tetap nyaman dibaca saat produk makin banyak.</h3>
        <p style="margin-top:10px; font-size:14px; line-height:1.7; color:#525252;">
            Chip kategori dirancang ringan dan editorial — jauh dari kesan panel admin.
        </p>

        <div class="sf-cat-chips">
            @foreach ($categories as $category)
                <a href="{{ route('products.index', ['category' => $category['slug'] ?? '']) }}" class="sf-cat-chip">
                    {{ $category['name'] }}
                    <span class="sf-cat-count">{{ $category['count'] }}</span>
                </a>
            @endforeach
        </div>
    </div>

    {{-- Cart & Checkout --}}
    <div class="sf-flow-grid">

        {{-- Cart --}}
        <article class="sf-flow-card">
            <div class="sf-flow-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/>
                    <line x1="3" y1="6" x2="21" y2="6"/>
                    <path d="M16 10a4 4 0 0 1-8 0"/>
                </svg>
            </div>
            <p class="sf-flow-eyebrow">Keranjang</p>
            <h3 class="sf-flow-title">Review pesanan sebelum lanjut ke pembayaran.</h3>
            <p class="sf-flow-desc">Review jumlah, input promo, dan ringkasan pesanan tanpa terasa padat.</p>
            <a href="{{ route('cart.index') }}" class="sf-btn-primary" style="margin-top: 18px; width: fit-content;">
                Buka
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </article>

        {{-- Checkout --}}
        <article class="sf-flow-card">
            <div class="sf-flow-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="20" height="14" x="2" y="5" rx="2"/>
                    <line x1="2" y1="10" x2="22" y2="10"/>
                </svg>
            </div>
            <p class="sf-flow-eyebrow">Checkout</p>
            <h3 class="sf-flow-title">Siap integrasi Midtrans payment gateway.</h3>
            <p class="sf-flow-desc">Summary tetap terlihat, form dan pilihan bayar nyaman dibaca.</p>
            <a href="{{ route('checkout.index') }}" class="sf-btn-outline" style="margin-top: 18px; width: fit-content;">
                Buka
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </article>
    </div>
</section>


{{-- ══════════════════════════════════════════════════════
     FAB — Floating Cart Button
══════════════════════════════════════════════════════ --}}
<a href="{{ route('cart.index') }}" class="sf-fab" aria-label="Buka Keranjang">
    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24"
         fill="none" stroke="currentColor" stroke-width="2"
         stroke-linecap="round" stroke-linejoin="round">
        <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/>
        <line x1="3" y1="6" x2="21" y2="6"/>
        <path d="M16 10a4 4 0 0 1-8 0"/>
    </svg>
    <span>Keranjang</span>
    @if ($cartCount > 0)
        <span class="sf-fab-badge">{{ $cartCount > 99 ? '99+' : $cartCount }}</span>
    @endif
</a>

@endsection
