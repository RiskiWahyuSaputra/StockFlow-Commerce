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
        linear-gradient(145deg, #000000 0%, #0a0a0a 46%, #111111 100%);
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
    text-shadow: 0 14px 40px rgba(0,0,0,0.5);
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
    text-shadow: 0 12px 30px rgba(0,0,0,0.5);
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
    background: #000000;
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
        linear-gradient(90deg, rgba(0,0,0,0.75) 0%, rgba(0,0,0,0.36) 36%, rgba(0,0,0,0.20) 60%, rgba(0,0,0,0.72) 100%),
        linear-gradient(180deg, rgba(0,0,0,0.08) 0%, rgba(0,0,0,0.52) 100%),
        radial-gradient(circle at top right, rgba(255,255,255,0.14), transparent 24%);
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
.sf-carousel-arrows { display: none; }
.sf-carousel-arrow { display: none; }
.sf-carousel-arrow:hover { display: none; }
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
    background: #ffffff;
    color: #000000;
    border: none;
    border-radius: 9999px;
    padding: 10px 22px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: background 0.18s;
}
.sf-btn-primary:hover { background: #e2e8f0; }
.sf-btn-outline {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: transparent;
    color: #94a3b8;
    border: 1px solid rgba(255,255,255,0.15);
    border-radius: 9999px;
    padding: 10px 22px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: border-color 0.18s, color 0.18s;
}
.sf-btn-outline:hover { border-color: rgba(255,255,255,0.30); color: #f8fafc; }

/* ─── Metrics ─── */
.sf-metrics {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
    margin-top: 28px;
    padding-top: 24px;
    border-top: 1px solid rgba(255,255,255,0.08);
}
.sf-metric {
    background: rgba(255,255,255,0.04);
    border-radius: 14px;
    padding: 14px 16px;
}
.sf-metric-label {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: #64748b;
}
.sf-metric-value {
    font-size: 24px;
    font-weight: 700;
    color: #f8fafc;
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
.sf-aside-img-wrap:hover .sf-aside-img { transform: scale(1.04); }
.sf-aside-img-gradient {
    position: absolute;
    inset: 0;
    background: linear-gradient(160deg, rgba(0,0,0,0.5) 0%, rgba(0,0,0,0.05) 60%);
    border-radius: 14px;
    pointer-events: none;
}
.sf-aside-glass {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    background: rgba(255,255,255,0.76);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    border-top: 1px solid rgba(255,255,255,0.4);
    border-radius: 0 0 14px 14px;
    padding: 14px 16px;
}
.sf-aside-cover { margin: 0 14px; border-radius: 14px; overflow: hidden; }
.sf-aside-cover-inner {
    background: rgba(255,255,255,0.72);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.3);
    border-radius: 14px;
    padding: 20px;
}
.sf-aside-cover-cat { font-size: 11px; font-weight: 600; color: #64748b; }
.sf-aside-cover-name { font-size: 20px; font-weight: 800; color: #0f172a; margin-top: 6px; line-height: 1.2; letter-spacing: -0.02em; }
.sf-aside-cover-desc { font-size: 13px; line-height: 1.65; color: #475569; margin-top: 8px; }
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
.sf-aside-price-label { font-size: 10px; font-weight: 600; letter-spacing: 0.16em; text-transform: uppercase; color: #64748b; }
.sf-aside-price-value { font-size: 22px; font-weight: 800; color: #f8fafc; margin-top: 4px; }
.sf-aside-price-btn {
    background: #ffffff;
    color: #000000;
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
.sf-aside-price-btn:hover { background: #e2e8f0; }

/* ─── Dark Wrapper — Section 2 ─── */
.sf-dark-wrapper {
    width: 100vw;
    margin-left: calc(50% - 50vw);
    background:
        radial-gradient(circle at top center, rgba(245, 158, 11, 0.18), transparent 18%),
        linear-gradient(180deg, #050505 0%, #0b0b0b 34%, #050505 100%);
    padding: 68px 0 72px;
}
.sf-dark-inner {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 2rem;
}

/* ─── Section Heading ─── */
.sf-section-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 24px;
}
.sf-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: #fbbf24;
    margin-bottom: 10px;
}
.sf-eyebrow::before {
    content: '';
    display: block;
    width: 18px;
    height: 2px;
    background: #f59e0b;
    border-radius: 9999px;
    flex-shrink: 0;
}
.sf-section-title {
    max-width: 16ch;
    font-size: clamp(1.8rem, 2.6vw, 2.7rem);
    font-weight: 800;
    color: #f8fafc;
    letter-spacing: -0.04em;
    line-height: 1.05;
}
.sf-section-copy {
    margin-top: 12px;
    max-width: 42rem;
    font-size: 15px;
    line-height: 1.75;
    color: #94a3b8;
}
.sf-link-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 9999px;
    padding: 10px 16px;
    font-size: 13px;
    font-weight: 600;
    color: #e2e8f0;
    text-decoration: none;
    transition: border-color 0.18s, color 0.18s, background 0.18s, transform 0.18s;
    white-space: nowrap;
}
.sf-link-pill:hover {
    border-color: rgba(245,158,11,0.34);
    background: rgba(245,158,11,0.12);
    color: #ffffff;
    transform: translateY(-1px);
}

/* ─── Promo Intro ─── */
.sf-promo-grid {
    display: grid;
    grid-template-columns: minmax(0, 1.35fr) minmax(320px, 0.95fr);
    gap: 18px;
    align-items: stretch;
}
.sf-sale-hero {
    position: relative;
    overflow: hidden;
    border-radius: 34px;
    border: 1px solid rgba(245,158,11,0.16);
    padding: clamp(2rem, 4vw, 3.25rem);
    background:
        radial-gradient(circle at top right, rgba(245,158,11,0.24), transparent 24%),
        linear-gradient(135deg, #221003 0%, #14110f 48%, #050505 100%);
    box-shadow: 0 30px 80px rgba(0,0,0,0.45);
}
.sf-sale-hero::after {
    content: '';
    position: absolute;
    inset: auto -10% -28% auto;
    width: min(34vw, 300px);
    aspect-ratio: 1;
    border-radius: 9999px;
    background: radial-gradient(circle, rgba(245,158,11,0.24) 0%, rgba(245,158,11,0) 72%);
    pointer-events: none;
}
.sf-sale-badge {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    border-radius: 9999px;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.1);
    padding: 8px 14px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    color: #ffffff;
}
.sf-sale-badge span {
    font-size: 20px;
    font-weight: 900;
    letter-spacing: -0.04em;
    color: #fbbf24;
}
.sf-sale-title {
    position: relative;
    z-index: 1;
    max-width: 7ch;
    margin-top: 20px;
    font-size: clamp(3.1rem, 7vw, 6.4rem);
    font-weight: 900;
    line-height: 0.88;
    letter-spacing: -0.07em;
    color: #ffffff;
}
.sf-sale-copy {
    position: relative;
    z-index: 1;
    margin-top: 20px;
    max-width: 34rem;
    font-size: 16px;
    line-height: 1.85;
    color: #cbd5e1;
}
.sf-sale-actions {
    position: relative;
    z-index: 1;
    margin-top: 30px;
}
.sf-sale-metrics {
    position: relative;
    z-index: 1;
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 12px;
    margin-top: 34px;
}
.sf-sale-metric {
    border-radius: 22px;
    border: 1px solid rgba(255,255,255,0.08);
    background: rgba(255,255,255,0.04);
    padding: 18px;
    backdrop-filter: blur(10px);
}
.sf-sale-metric-label {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    color: #94a3b8;
}
.sf-sale-metric-value {
    margin-top: 8px;
    font-size: 24px;
    font-weight: 800;
    line-height: 1;
    color: #ffffff;
}
.sf-promo-stack {
    display: grid;
    gap: 18px;
}
.sf-promo-note,
.sf-spotlight-panel {
    overflow: hidden;
    border-radius: 30px;
    border: 1px solid rgba(255,255,255,0.08);
    background: #111111;
    box-shadow: 0 18px 40px rgba(0,0,0,0.28);
}
.sf-promo-note {
    padding: 28px;
    background:
        radial-gradient(circle at top left, rgba(248, 113, 113, 0.18), transparent 28%),
        linear-gradient(180deg, rgba(255,255,255,0.06), rgba(255,255,255,0.03));
}
.sf-note-title {
    margin-top: 14px;
    font-size: clamp(1.6rem, 3vw, 2.25rem);
    font-weight: 800;
    line-height: 1.08;
    letter-spacing: -0.04em;
    color: #ffffff;
}
.sf-note-copy {
    margin-top: 14px;
    font-size: 14px;
    line-height: 1.8;
    color: #cbd5e1;
}
.sf-promo-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 22px;
}
.sf-promo-tag {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    border-radius: 9999px;
    border: 1px solid rgba(255,255,255,0.08);
    background: rgba(255,255,255,0.05);
    padding: 8px 14px;
    font-size: 12px;
    font-weight: 600;
    color: #f8fafc;
    text-decoration: none;
    transition: border-color 0.18s, background 0.18s, transform 0.18s;
}
.sf-promo-tag span {
    border-radius: 9999px;
    background: rgba(245,158,11,0.14);
    padding: 2px 8px;
    font-size: 10px;
    color: #fbbf24;
}
.sf-promo-tag:hover {
    border-color: rgba(245,158,11,0.3);
    background: rgba(245,158,11,0.08);
    transform: translateY(-1px);
}
.sf-promo-note .sf-link-pill {
    margin-top: 22px;
}
.sf-spotlight-media {
    position: relative;
    min-height: 232px;
    background: #151515;
}
.sf-spotlight-image,
.sf-deal-media img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}
.sf-spotlight-media::after,
.sf-deal-media::after {
    content: '';
    position: absolute;
    inset: 0;
    background:
        linear-gradient(180deg, rgba(0,0,0,0.12) 0%, rgba(0,0,0,0.52) 100%),
        radial-gradient(circle at top right, rgba(255,255,255,0.12), transparent 26%);
    pointer-events: none;
}
.sf-spotlight-placeholder,
.sf-deal-placeholder {
    position: relative;
    display: flex;
    align-items: flex-end;
    justify-content: flex-start;
    width: 100%;
    height: 100%;
    min-height: 232px;
    padding: 22px;
    color: rgba(255,255,255,0.94);
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.2em;
    text-transform: uppercase;
}
.sf-deal-placeholder {
    min-height: 0;
    aspect-ratio: 5 / 4;
}
.sf-spotlight-body {
    padding: 24px 28px 28px;
}
.sf-spotlight-label {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: #fbbf24;
}
.sf-spotlight-title {
    margin-top: 10px;
    font-size: clamp(1.5rem, 3vw, 2.1rem);
    font-weight: 800;
    line-height: 1.05;
    letter-spacing: -0.04em;
    color: #ffffff;
}
.sf-spotlight-copy {
    margin-top: 12px;
    font-size: 14px;
    line-height: 1.8;
    color: #cbd5e1;
}
.sf-spotlight-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    margin-top: 20px;
}
.sf-spotlight-price {
    font-size: 1.55rem;
    font-weight: 800;
    line-height: 1;
    letter-spacing: -0.04em;
    color: #ffffff;
}

/* ─── Deals Grid ─── */
.sf-deals-section {
    margin-top: 72px;
}
.sf-deals-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 16px;
}
.sf-deal-card {
    position: relative;
    overflow: hidden;
    border-radius: 28px;
    border: 1px solid rgba(255,255,255,0.08);
    background: linear-gradient(180deg, #101010 0%, #090909 100%);
    transition: transform 0.22s ease, border-color 0.22s ease, box-shadow 0.22s ease;
}
.sf-deal-card:hover {
    transform: translateY(-4px);
    border-color: rgba(245,158,11,0.24);
    box-shadow: 0 18px 46px rgba(0,0,0,0.45);
}
.sf-deal-discount {
    position: absolute;
    top: 16px;
    left: 16px;
    z-index: 2;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 9999px;
    background: #fbbf24;
    color: #111827;
    padding: 7px 12px;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.16em;
    text-transform: uppercase;
}
.sf-deal-media {
    position: relative;
    aspect-ratio: 5 / 4;
    background: #161616;
}
.sf-deal-body {
    padding: 20px;
}
.sf-deal-category {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    color: #fbbf24;
}
.sf-deal-name {
    margin-top: 10px;
    font-size: 20px;
    font-weight: 800;
    line-height: 1.1;
    letter-spacing: -0.04em;
    color: #ffffff;
}
.sf-deal-text {
    margin-top: 12px;
    font-size: 14px;
    line-height: 1.78;
    color: #94a3b8;
}
.sf-deal-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-top: 22px;
}
.sf-deal-price {
    font-size: 1.2rem;
    font-weight: 800;
    color: #ffffff;
}
.sf-deal-button {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    border-radius: 9999px;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.12);
    padding: 10px 14px;
    font-size: 13px;
    font-weight: 700;
    color: #f8fafc;
    text-decoration: none;
    transition: border-color 0.18s, background 0.18s, transform 0.18s;
}
.sf-deal-button:hover {
    border-color: rgba(245,158,11,0.3);
    background: rgba(245,158,11,0.12);
    transform: translateY(-1px);
}

/* ─── Category Offers ─── */
.sf-category-offers {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 18px;
    margin-top: 72px;
}
.sf-category-card {
    display: flex;
    flex-direction: column;
    min-height: 280px;
    border-radius: 32px;
    padding: 30px;
    border: 1px solid rgba(255,255,255,0.08);
    box-shadow: 0 18px 44px rgba(0,0,0,0.32);
}
.sf-category-sale {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.82);
}
.sf-category-title {
    max-width: 12ch;
    margin-top: 12px;
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 900;
    line-height: 0.95;
    letter-spacing: -0.06em;
    color: #ffffff;
}
.sf-category-copy {
    max-width: 28rem;
    margin-top: 14px;
    font-size: 14px;
    line-height: 1.82;
    color: rgba(255,255,255,0.78);
}
.sf-category-card .sf-link-pill {
    margin-top: auto;
    align-self: flex-start;
    border-color: rgba(255,255,255,0.18);
    background: rgba(255,255,255,0.08);
}

/* ─── Benefits ─── */
.sf-benefits-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 16px;
    margin-top: 72px;
}
.sf-benefit-card {
    border-radius: 26px;
    border: 1px solid rgba(255,255,255,0.08);
    background: linear-gradient(180deg, rgba(255,255,255,0.045), rgba(255,255,255,0.025));
    padding: 24px;
}
.sf-benefit-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 52px;
    height: 52px;
    border-radius: 16px;
    border: 1px solid rgba(245,158,11,0.18);
    background: rgba(245,158,11,0.08);
    color: #fbbf24;
}
.sf-benefit-title {
    margin-top: 16px;
    font-size: 18px;
    font-weight: 700;
    color: #f8fafc;
}
.sf-benefit-copy {
    margin-top: 10px;
    font-size: 14px;
    line-height: 1.8;
    color: #94a3b8;
}

/* ─── Closing CTA ─── */
.sf-closing-banner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 18px;
    margin-top: 72px;
    border-radius: 34px;
    border: 1px solid rgba(245,158,11,0.16);
    background:
        radial-gradient(circle at top right, rgba(255,255,255,0.16), transparent 18%),
        linear-gradient(135deg, #271301 0%, #a16207 52%, #78350f 100%);
    padding: clamp(1.75rem, 3vw, 2.6rem);
}
.sf-closing-title {
    max-width: 14ch;
    font-size: clamp(2rem, 4.2vw, 3.6rem);
    font-weight: 900;
    line-height: 0.95;
    letter-spacing: -0.06em;
    color: #ffffff;
}
.sf-closing-copy {
    max-width: 36rem;
    margin-top: 12px;
    font-size: 15px;
    line-height: 1.78;
    color: rgba(255,255,255,0.82);
}

/* ─── Footer bridge ─── */
.sf-footer-bridge {
    width: 100vw;
    margin-left: calc(50% - 50vw);
    height: 1px;
    background: rgba(255,255,255,0.06);
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
    line-height: 1;
}

/* ─── Responsive ─── */
@media (max-width: 1024px) {
    .sf-hero-grid { min-height: auto; padding-top: 0; }
    .sf-carousel-shell, .sf-carousel-slide { min-height: auto; }
    .sf-carousel-slide { padding: 6.5rem 2rem 2rem; }
    .sf-carousel-visual { inset: 0; }
    .sf-carousel-copy { min-height: calc(100vh - 8.5rem); max-width: 36rem; }
    .sf-carousel-visual-content { min-height: 100vh; padding: 6.5rem 2rem 2rem; }
    .sf-promo-grid,
    .sf-category-offers { grid-template-columns: 1fr; }
    .sf-deals-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    .sf-benefits-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    .sf-closing-banner { flex-direction: column; align-items: flex-start; }
}
@media (max-width: 640px) {
    .sf-hero-grid { padding-top: 0; }
    .sf-carousel-slide { padding: 6rem 1.2rem 1.2rem; gap: 1.25rem; }
    .sf-carousel-title { font-size: 42px; max-width: 100%; }
    .sf-carousel-copy .sf-lead { font-size: 15px; }
    .sf-carousel-copy { min-height: calc(100vh - 7.2rem); max-width: 100%; }
    .sf-carousel-visual-content { min-height: 100vh; padding: 6rem 1.2rem 1.2rem; }
    .sf-carousel-product { max-width: 100%; }
    .sf-carousel-product-footer { flex-direction: column; align-items: flex-start; }
    .sf-h1 { font-size: 30px; }
    .sf-metrics { grid-template-columns: repeat(3, 1fr); gap: 8px; }
    .sf-fab { bottom: 20px; right: 20px; padding: 11px 18px; font-size: 13px; }
    .sf-dark-inner { padding: 0 1.2rem; }
    .sf-dark-wrapper { padding: 42px 0 48px; }
    .sf-sale-hero,
    .sf-promo-note,
    .sf-spotlight-panel,
    .sf-category-card,
    .sf-closing-banner { border-radius: 24px; }
    .sf-sale-title { font-size: 54px; }
    .sf-sale-metrics,
    .sf-deals-grid,
    .sf-benefits-grid { grid-template-columns: 1fr; }
    .sf-spotlight-footer { flex-direction: column; align-items: flex-start; }
    .sf-section-title,
    .sf-closing-title { max-width: 100%; }
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
            'kicker'         => 'Kurasi Minggu Ini',
            'badge'          => 'Platform Modern',
            'title'          => 'Pengalaman belanja modern yang rapi dan siap dipresentasikan.',
            'description'    => 'Fondasi visual untuk katalog, detail produk, keranjang, dan checkout. Semua komponen dirancang reusable agar mudah di-scale.',
            'primary_label'  => 'Jelajahi Produk',
            'primary_href'   => route('products.index'),
            'secondary_label'=> 'Lihat Checkout',
            'secondary_href' => route('checkout.index'),
            'feature_label'  => $spotlightProduct['category'] ?? 'Sorotan',
            'feature_title'  => $spotlightProduct['name'] ?? 'StockFlow Commerce',
            'feature_text'   => $spotlightProduct['description'] ?? 'Kurasi produk siap pakai dengan presentasi visual yang terasa premium sejak layar pertama.',
            'price_label'    => $spotlightProduct['price_label'] ?? 'Mulai dari sekarang',
            'product_href'   => filled($spotlightProduct['slug'] ?? null) ? route('products.show', $spotlightProduct['slug']) : route('products.index'),
            'image_url'      => asset('img/parfum.jpg'),
        ],
        [
            'kicker'         => 'Footwear Edit',
            'badge'          => 'Highlight Produk',
            'title'          => 'Slide besar yang langsung membawa fokus ke kategori favorit.',
            'description'    => 'Header carousel ini dibuat untuk menampilkan koleksi unggulan dengan ritme visual yang lebih hidup daripada hero statis biasa.',
            'primary_label'  => 'Lihat Katalog',
            'primary_href'   => route('products.index'),
            'secondary_label'=> 'Buka Keranjang',
            'secondary_href' => route('cart.index'),
            'feature_label'  => 'Shoes',
            'feature_title'  => 'Pilihan sepatu yang tampil editorial sejak landing pertama.',
            'feature_text'   => 'Cocok untuk menonjolkan campaign, kategori baru, atau produk dengan foto yang ingin benar-benar dijual lewat visual.',
            'price_label'    => 'Explore now',
            'product_href'   => route('products.index'),
            'image_url'      => asset('img/soes.jpg'),
        ],
        [
            'kicker'         => 'Fashion Rail',
            'badge'          => 'Visual Display',
            'title'          => 'Hero satu layar dengan transisi halus bikin beranda terasa lebih premium.',
            'description'    => 'Navbar transparan dan carousel full-screen memberi kesan lebih modern saat halaman pertama kali dibuka, tanpa mengganggu flow katalog di bawahnya.',
            'primary_label'  => 'Mulai Belanja',
            'primary_href'   => route('products.index'),
            'secondary_label'=> 'Lihat Detail',
            'secondary_href' => filled($spotlightProduct['slug'] ?? null) ? route('products.show', $spotlightProduct['slug']) : route('products.index'),
            'feature_label'  => 'Clothes',
            'feature_title'  => 'Area hero sekarang punya ritme presentasi yang lebih dinamis.',
            'feature_text'   => 'Setiap slide bisa dipakai untuk memperlihatkan karakter produk yang berbeda, dari fashion sampai fragrance.',
            'price_label'    => 'New collection',
            'product_href'   => route('products.index'),
            'image_url'      => asset('img/chlotes.jpeg'),
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
                        <div class="sf-carousel-visual-content"></div>
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
    <div class="sf-hero-main">
        <span class="sf-badge">
            <span class="sf-badge-dot"></span>
            Platform Modern
        </span>
        <h1 class="sf-h1">Pengalaman belanja modern yang rapi dan siap dipresentasikan.</h1>
        <p class="sf-lead">Fondasi visual untuk katalog, detail produk, keranjang, dan checkout. Semua komponen dirancang reusable agar mudah di-scale.</p>
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

    <aside class="sf-hero-aside sf-anim sf-d2">
        <div class="sf-aside-header">
            <span class="sf-aside-eyebrow">Sorotan</span>
            <span class="sf-aside-cat-pill">{{ $spotlightProduct['category'] }}</span>
        </div>
        @if (!empty($spotlightProduct['image_url']))
            <div class="sf-aside-img-wrap">
                <img class="sf-aside-img" src="{{ $spotlightProduct['image_url'] }}" alt="{{ $spotlightProduct['name'] }}" loading="lazy">
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
            <a href="{{ route('products.show', $spotlightProduct['slug']) }}" class="sf-aside-price-btn">Lihat →</a>
        </div>
    </aside>
</section>


{{-- ══════════════════════════════════════════════════════
     DARK WRAPPER — SECTION 2 & 3
══════════════════════════════════════════════════════ --}}
@php
    $featuredDeals = collect($featuredProducts)
        ->values()
        ->map(function (array $product, int $index): array {
            $discounts = [55, 48, 42, 35];
            $product['deal_label'] = $discounts[$index] ?? 30;

            return $product;
        });

    $promoCategories = collect($categories)
        ->reject(fn (array $category): bool => ($category['slug'] ?? null) === 'all')
        ->take(3)
        ->values();

    $categoryOffers = collect($categories)
        ->reject(fn (array $category): bool => ($category['slug'] ?? null) === 'all')
        ->take(2)
        ->values()
        ->map(function (array $category, int $index): array {
            $themes = [
                [
                    'discount' => 'Up to 65% Off',
                    'headline' => 'Unlock exclusive Black Friday deals for '.$category['name'].'.',
                    'copy' => 'Kurasi kategori '.$category['name'].' dibuat lebih menonjol agar campaign terasa kuat sejak scroll pertama.',
                    'gradient' => 'linear-gradient(135deg, #241102 0%, #5b2a04 52%, #140a03 100%)',
                ],
                [
                    'discount' => 'Today only',
                    'headline' => 'Shop '.$category['name'].' picks before they sell out.',
                    'copy' => 'Blok promo sekunder ini mengikuti ritme template referensi: lebih clean, besar, dan fokus ke CTA kategori.',
                    'gradient' => 'linear-gradient(135deg, #111827 0%, #1f2937 46%, #020617 100%)',
                ],
            ];

            return array_merge($category, $themes[$index] ?? end($themes));
        });

    $spotlightHref = filled($spotlightProduct['slug'] ?? null)
        ? route('products.show', $spotlightProduct['slug'])
        : route('products.index');
@endphp
<div class="sf-dark-wrapper">
    <div class="sf-dark-inner">
        <section class="sf-promo-grid sf-anim sf-d3">
            <article class="sf-sale-hero">
                <div class="sf-sale-badge">
                    Save up to
                    <span>50%</span>
                </div>
                <h2 class="sf-sale-title">Discover Deals That Feel Like a Real Campaign.</h2>
                <p class="sf-sale-copy">
                    Section setelah carousel sekarang dibuat lebih dekat dengan ritme template referensi:
                    ada promo utama, kartu sorotan, dan jalur belanja yang terasa lebih editorial.
                </p>
                <div class="sf-cta-row sf-sale-actions">
                    <a href="{{ route('products.index') }}" class="sf-btn-primary">
                        Shop now
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                    <a href="{{ route('checkout.index') }}" class="sf-btn-outline">
                        Explore offers
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>
                <div class="sf-sale-metrics">
                    @foreach ($stats as $stat)
                        <div class="sf-sale-metric">
                            <p class="sf-sale-metric-label">{{ $stat['label'] }}</p>
                            <p class="sf-sale-metric-value">{{ $stat['value'] }}</p>
                        </div>
                    @endforeach
                </div>
            </article>

            <div class="sf-promo-stack">
                <article class="sf-promo-note">
                    <p class="sf-eyebrow">Flash Categories</p>
                    <h3 class="sf-note-title">Lebih clean, lebih terarah, dan langsung terasa seperti halaman promo.</h3>
                    <p class="sf-note-copy">
                        Carousel tetap saya biarkan, lalu area bawahnya saya susun ulang supaya scroll berikutnya
                        terasa lebih kuat dan rapi seperti demo referensi.
                    </p>
                    <div class="sf-promo-tags">
                        @foreach ($promoCategories as $category)
                            <a href="{{ route('products.index', ['category' => $category['slug'] ?? null]) }}" class="sf-promo-tag">
                                {{ $category['name'] }}
                                <span>{{ $category['count'] }}</span>
                            </a>
                        @endforeach
                    </div>
                    <a href="{{ route('products.index') }}" class="sf-link-pill">
                        Browse all collections
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </article>

                <article class="sf-spotlight-panel">
                    <div class="sf-spotlight-media">
                        @if (!empty($spotlightProduct['image_url']))
                            <img src="{{ $spotlightProduct['image_url'] }}" alt="{{ $spotlightProduct['name'] }}" class="sf-spotlight-image" loading="lazy">
                        @elseif (!empty($spotlightProduct['image']))
                            <img src="{{ Storage::url($spotlightProduct['image']) }}" alt="{{ $spotlightProduct['name'] }}" class="sf-spotlight-image" loading="lazy">
                        @else
                            <div class="sf-spotlight-placeholder" style="{{ $spotlightProduct['cover_style'] ?? 'background:linear-gradient(135deg,#1f2937 0%,#0f172a 100%);' }}">
                                Spotlight edit
                            </div>
                        @endif
                    </div>
                    <div class="sf-spotlight-body">
                        <p class="sf-spotlight-label">{{ $spotlightProduct['category'] ?? 'Spotlight' }}</p>
                        <h3 class="sf-spotlight-title">{{ $spotlightProduct['name'] ?? config('app.name') }}</h3>
                        <p class="sf-spotlight-copy">
                            {{ $spotlightProduct['description'] ?? 'Kurasi produk tetap jadi sorotan utama tanpa membuat layout terasa padat.' }}
                        </p>
                        <div class="sf-spotlight-footer">
                            <span class="sf-spotlight-price">{{ $spotlightProduct['price_label'] ?? 'Mulai sekarang' }}</span>
                            <a href="{{ $spotlightHref }}" class="sf-link-pill">
                                View highlight
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                </article>
            </div>
        </section>

        <section class="sf-deals-section sf-anim sf-d4">
            <div class="sf-section-header">
                <div>
                    <p class="sf-eyebrow">Featured Deals</p>
                    <h2 class="sf-section-title">Flash deals yang langsung terasa seperti landing promo Black Friday.</h2>
                    <p class="sf-section-copy">
                        Grid produk saya perbesar dan saya beri ritme promo, supaya pengunjung langsung dapat
                        konteks harga, kategori, dan aksi belanja tanpa terasa seperti daftar produk biasa.
                    </p>
                </div>
                <a href="{{ route('products.index') }}" class="sf-link-pill">
                    View all products
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="sf-deals-grid">
                @foreach ($featuredDeals as $product)
                    <article class="sf-deal-card">
                        <span class="sf-deal-discount">{{ $product['deal_label'] }}% Off</span>
                        <div class="sf-deal-media">
                            @if (!empty($product['image_url']))
                                <img src="{{ $product['image_url'] }}" alt="{{ $product['name'] }}" loading="lazy">
                            @elseif (!empty($product['image']))
                                <img src="{{ Storage::url($product['image']) }}" alt="{{ $product['name'] }}" loading="lazy">
                            @else
                                <div class="sf-deal-placeholder" style="{{ $product['cover_style'] ?? 'background:linear-gradient(135deg,#111827 0%,#1f2937 100%);' }}">
                                    {{ $product['tag'] ?? 'Hot deal' }}
                                </div>
                            @endif
                        </div>
                        <div class="sf-deal-body">
                            <p class="sf-deal-category">{{ $product['category'] }}</p>
                            <h3 class="sf-deal-name">{{ $product['name'] }}</h3>
                            <p class="sf-deal-text">{{ $product['excerpt'] ?? $product['description'] }}</p>
                            <div class="sf-deal-footer">
                                <span class="sf-deal-price">{{ $product['price_label'] }}</span>
                                <a href="{{ route('products.show', $product['slug']) }}" class="sf-deal-button">
                                    Shop now
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="sf-category-offers sf-anim sf-d5">
            @foreach ($categoryOffers as $category)
                <article class="sf-category-card" style="background: {{ $category['gradient'] }};">
                    <p class="sf-category-sale">{{ $category['discount'] }}</p>
                    <h3 class="sf-category-title">{{ $category['headline'] }}</h3>
                    <p class="sf-category-copy">{{ $category['copy'] }}</p>
                    <a href="{{ route('products.index', ['category' => $category['slug'] ?? null]) }}" class="sf-link-pill">
                        Shop {{ $category['name'] }}
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </article>
            @endforeach
        </section>

        <section class="sf-benefits-grid sf-anim sf-d6">
            <article class="sf-benefit-card">
                <div class="sf-benefit-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="16" height="13" x="4" y="5" rx="2"/>
                        <path d="M16 18h2a2 2 0 0 0 2-2v-3.34a2 2 0 0 0-.59-1.41l-1.66-1.66A2 2 0 0 0 16.34 9H14"/>
                        <circle cx="7.5" cy="18.5" r="1.5"/>
                        <circle cx="16.5" cy="18.5" r="1.5"/>
                    </svg>
                </div>
                <h3 class="sf-benefit-title">Pengiriman cepat</h3>
                <p class="sf-benefit-copy">Area promo tetap kuat tanpa menghilangkan informasi praktis seperti kecepatan kirim dan kesiapan checkout.</p>
            </article>

            <article class="sf-benefit-card">
                <div class="sf-benefit-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 7h-9"/>
                        <path d="M14 17H5"/>
                        <circle cx="17" cy="17" r="3"/>
                        <circle cx="7" cy="7" r="3"/>
                    </svg>
                </div>
                <h3 class="sf-benefit-title">Kurasi terarah</h3>
                <p class="sf-benefit-copy">Blok produk, kategori, dan CTA disusun supaya halaman utama terasa lebih fokus dan tidak pecah ke terlalu banyak arah.</p>
            </article>

            <article class="sf-benefit-card">
                <div class="sf-benefit-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2 4 5v6c0 5 3.4 9.74 8 11 4.6-1.26 8-6 8-11V5l-8-3Z"/>
                        <path d="m9 12 2 2 4-4"/>
                    </svg>
                </div>
                <h3 class="sf-benefit-title">Checkout lebih aman</h3>
                <p class="sf-benefit-copy">Narasi visual baru tetap mengarahkan user ke alur beli yang jelas, dari katalog hingga pembayaran.</p>
            </article>

            <article class="sf-benefit-card">
                <div class="sf-benefit-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        <path d="M8 10h8"/>
                        <path d="M8 7h5"/>
                    </svg>
                </div>
                <h3 class="sf-benefit-title">Support lebih jelas</h3>
                <p class="sf-benefit-copy">Footer dan area penutup saya buat lebih clean supaya informasi penting tetap terbaca tanpa rasa penuh.</p>
            </article>
        </section>

        <section class="sf-closing-banner sf-anim sf-d7">
            <div>
                <p class="sf-eyebrow" style="color: rgba(255,255,255,0.84);">Final Call</p>
                <h2 class="sf-closing-title">Don't miss out, shop the strongest deals now.</h2>
                <p class="sf-closing-copy">
                    Penutup halaman saya ubah jadi CTA besar agar transisi dari section promo ke footer terasa lebih halus,
                    lebih rapi, dan tetap punya tenaga sampai bagian paling bawah.
                </p>
            </div>
            <a href="{{ route('products.index') }}" class="sf-btn-primary">
                Shop deals
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </section>
    </div>
</div>

<div class="sf-footer-bridge"></div>


{{-- ══════════════════════════════════════════════════════
     FAB — Floating Cart Button
══════════════════════════════════════════════════════ --}}
<x-frontend.cart-fab />

@endsection



