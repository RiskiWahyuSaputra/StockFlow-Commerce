@extends('layouts.app')

@section('title', 'Frontend Setup')

@section('content')
    <section class="grid gap-8 lg:grid-cols-[minmax(0,1.35fr)_minmax(320px,0.85fr)] lg:items-start">
        <div class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-sm">
            <span class="inline-flex rounded-full bg-brand-50 px-4 py-2 text-sm font-semibold text-brand-700">
                Stage 1 • Project Setup
            </span>

            <h1 class="mt-6 max-w-3xl text-4xl font-black tracking-tight text-slate-950 sm:text-5xl">
                Fondasi e-commerce fullstack yang siap dikembangkan secara bertahap.
            </h1>

            <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-600">
                Pada tahap ini kita fokus ke arsitektur dasar Laravel, konfigurasi MySQL, asset pipeline Tailwind CSS,
                serta struktur Blade yang terpisah untuk storefront user dan admin panel.
            </p>

            <div class="mt-8 grid gap-4 sm:grid-cols-2">
                <div class="rounded-3xl bg-slate-50 p-5">
                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-400">Stack</p>
                    <p class="mt-3 text-lg font-semibold text-slate-900">Laravel 12 + Blade + Tailwind CSS 4</p>
                </div>

                <div class="rounded-3xl bg-slate-50 p-5">
                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-400">Database</p>
                    <p class="mt-3 text-lg font-semibold text-slate-900">MySQL `e_commerce_platform`</p>
                </div>
            </div>
        </div>

        <div class="rounded-[2rem] border border-slate-200 bg-slate-950 p-8 text-white shadow-xl shadow-slate-900/10">
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-400">Roadmap Setup</p>

            <div class="mt-6 space-y-4">
                <div class="rounded-3xl border border-white/10 bg-white/5 p-4">
                    <p class="font-semibold">Frontend storefront</p>
                    <p class="mt-2 text-sm leading-6 text-slate-300">Folder, layout, dan komponen inti sudah disiapkan.</p>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/5 p-4">
                    <p class="font-semibold">Admin workspace</p>
                    <p class="mt-2 text-sm leading-6 text-slate-300">Route dan layout admin siap dipakai untuk dashboard dan modul operasional.</p>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/5 p-4">
                    <p class="font-semibold">Feature modules</p>
                    <p class="mt-2 text-sm leading-6 text-slate-300">Subfolder produk, cart, checkout, orders, dan inventory sudah disiapkan sebagai placeholder.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="mt-8 grid gap-4 lg:grid-cols-3">
        <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-400">Frontend</p>
            <h2 class="mt-4 text-xl font-bold text-slate-900">User-facing views</h2>
            <p class="mt-3 text-sm leading-6 text-slate-600">
                Semua halaman customer akan ditempatkan di namespace `resources/views/frontend`.
            </p>
        </article>

        <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-400">Admin</p>
            <h2 class="mt-4 text-xl font-bold text-slate-900">Back-office views</h2>
            <p class="mt-3 text-sm leading-6 text-slate-600">
                Seluruh halaman internal admin dipisah di `resources/views/admin` agar boundary antar area tetap jelas.
            </p>
        </article>

        <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-400">Components</p>
            <h2 class="mt-4 text-xl font-bold text-slate-900">Reusable Blade parts</h2>
            <p class="mt-3 text-sm leading-6 text-slate-600">
                Komponen anonymous Blade ditempatkan di `resources/views/components` untuk navbar, footer, sidebar, dan header.
            </p>
        </article>
    </section>
@endsection
