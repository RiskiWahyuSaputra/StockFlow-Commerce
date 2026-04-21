@extends('layouts.storefront')

@section('title', 'Kelola Profil')

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

/* ─── Force Dark Theme for Profile Partials ─── */
.sf-dark-inner h2 { color: #ffffff !important; }
.sf-dark-inner p { color: #94a3b8 !important; }
.sf-dark-inner .text-slate-900 { color: #ffffff !important; }
.sf-dark-inner .text-slate-600 { color: #94a3b8 !important; }
.sf-dark-inner .text-slate-700 { color: #cbd5e1 !important; }
</style>
@endpush

@section('content')
<div class="sf-dark-inner">
    {{-- Header --}}
    <div style="margin-bottom: 3rem;">
        <p class="sf-eyebrow">Pengaturan Akun</p>
        <h1 style="font-size: clamp(2rem, 4vw, 3rem); font-weight: 900; color: #ffffff; letter-spacing: -0.02em; line-height: 1;">
            Kelola Profil
        </h1>
    </div>

    <div class="space-y-8">
        <div class="sf-card">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="sf-card">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="sf-card">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
@endsection
