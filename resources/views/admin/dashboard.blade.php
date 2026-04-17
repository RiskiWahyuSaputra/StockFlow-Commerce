@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('heading', 'Admin Dashboard')

@section('content')
    <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-400">Products</p>
            <p class="mt-4 text-3xl font-black text-slate-950">0</p>
            <p class="mt-2 text-sm text-slate-500">Model dan migration akan dibuat pada tahap katalog produk.</p>
        </article>

        <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-400">Orders</p>
            <p class="mt-4 text-3xl font-black text-slate-950">0</p>
            <p class="mt-2 text-sm text-slate-500">Order flow dan Midtrans akan diintegrasikan setelah checkout setup.</p>
        </article>

        <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-400">Inventory</p>
            <p class="mt-4 text-3xl font-black text-slate-950">Sync</p>
            <p class="mt-2 text-sm text-slate-500">Tracking stok real-time akan dipersiapkan di modul inventory.</p>
        </article>

        <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-400">Auth</p>
            <p class="mt-4 text-3xl font-black text-slate-950">Pending</p>
            <p class="mt-2 text-sm text-slate-500">Auth user dan admin sengaja belum diaktifkan pada stage setup.</p>
        </article>
    </section>

    <section class="mt-6 grid gap-6 xl:grid-cols-[minmax(0,1.15fr)_minmax(320px,0.85fr)]">
        <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-bold text-slate-900">Apa yang sudah siap</h2>

            <div class="mt-5 grid gap-4 md:grid-cols-2">
                <div class="rounded-2xl bg-slate-50 p-5">
                    <p class="font-semibold text-slate-900">Routing terpisah</p>
                    <p class="mt-2 text-sm leading-6 text-slate-600">Frontend dan admin dipisah ke file route masing-masing agar scaling lebih rapi.</p>
                </div>

                <div class="rounded-2xl bg-slate-50 p-5">
                    <p class="font-semibold text-slate-900">Blade layout modular</p>
                    <p class="mt-2 text-sm leading-6 text-slate-600">Setiap area punya layout sendiri dan reusable components terstruktur.</p>
                </div>

                <div class="rounded-2xl bg-slate-50 p-5">
                    <p class="font-semibold text-slate-900">Database MySQL</p>
                    <p class="mt-2 text-sm leading-6 text-slate-600">Environment sudah diarahkan ke MySQL dan migration dasar siap dipakai.</p>
                </div>

                <div class="rounded-2xl bg-slate-50 p-5">
                    <p class="font-semibold text-slate-900">Tailwind asset pipeline</p>
                    <p class="mt-2 text-sm leading-6 text-slate-600">Vite dan Tailwind CSS 4 sudah terpasang dan siap untuk pengembangan UI.</p>
                </div>
            </div>
        </article>

        <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-bold text-slate-900">Next stage</h2>
            <ul class="mt-5 space-y-3 text-sm leading-6 text-slate-600">
                <li class="rounded-2xl bg-slate-50 px-4 py-3">Product catalog dan product detail</li>
                <li class="rounded-2xl bg-slate-50 px-4 py-3">Search, filter, dan cart management</li>
                <li class="rounded-2xl bg-slate-50 px-4 py-3">Auth user/admin dan proteksi route admin</li>
                <li class="rounded-2xl bg-slate-50 px-4 py-3">Checkout flow dan integrasi Midtrans</li>
            </ul>
        </article>
    </section>
@endsection
