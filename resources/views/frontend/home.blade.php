@extends('layouts.storefront')

@section('title', 'Storefront Home')

@section('content')
    <section class="grid gap-8 lg:grid-cols-[minmax(0,1.35fr)_minmax(320px,0.85fr)] lg:items-start">
        <div class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-sm">
            <span class="inline-flex rounded-full bg-brand-50 px-4 py-2 text-sm font-semibold text-brand-700">
                Stage 2 • Authentication Setup
            </span>

            <h1 class="mt-6 max-w-3xl text-4xl font-black tracking-tight text-slate-950 sm:text-5xl">
                Storefront sekarang punya auth flow yang rapi untuk customer dan admin.
            </h1>

            <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-600">
                Project ini sudah memakai autentikasi resmi Laravel, route grouping yang jelas, middleware role-based,
                dan redirect otomatis sesuai tipe akun setelah login.
            </p>

            <div class="mt-8 flex flex-wrap gap-3">
                @guest
                    <a href="{{ route('login') }}" class="rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:text-slate-900">
                        Buat Akun
                    </a>
                @else
                    <a href="{{ route(auth()->user()->homeRoute()) }}" class="rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                        Buka Dashboard
                    </a>
                @endguest
            </div>

            <div class="mt-8 grid gap-4 sm:grid-cols-2">
                <div class="rounded-3xl bg-slate-50 p-5">
                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-400">Auth Stack</p>
                    <p class="mt-3 text-lg font-semibold text-slate-900">Laravel Breeze + Session Guard</p>
                </div>

                <div class="rounded-3xl bg-slate-50 p-5">
                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-400">Role Access</p>
                    <p class="mt-3 text-lg font-semibold text-slate-900">Customer Dashboard + Admin Dashboard</p>
                </div>
            </div>
        </div>

        <div class="rounded-[2rem] border border-slate-200 bg-slate-950 p-8 text-white shadow-xl shadow-slate-900/10">
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-400">Route Structure</p>

            <div class="mt-6 space-y-4">
                <div class="rounded-3xl border border-white/10 bg-white/5 p-4">
                    <p class="font-semibold">Public routes</p>
                    <p class="mt-2 text-sm leading-6 text-slate-300">Landing page dan storefront tetap bisa diakses tanpa login.</p>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/5 p-4">
                    <p class="font-semibold">Customer routes</p>
                    <p class="mt-2 text-sm leading-6 text-slate-300">User biasa diarahkan ke dashboard customer dan area profil setelah login.</p>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/5 p-4">
                    <p class="font-semibold">Admin routes</p>
                    <p class="mt-2 text-sm leading-6 text-slate-300">Akun admin otomatis diarahkan ke `/admin` dan dibatasi middleware admin.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="mt-8 grid gap-4 lg:grid-cols-3">
        <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-400">Frontend</p>
            <h2 class="mt-4 text-xl font-bold text-slate-900">Public storefront</h2>
            <p class="mt-3 text-sm leading-6 text-slate-600">
                Halaman toko tetap public, sementara area customer yang butuh login dipisah ke route customer.
            </p>
        </article>

        <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-400">Authorization</p>
            <h2 class="mt-4 text-xl font-bold text-slate-900">Role-based redirect</h2>
            <p class="mt-3 text-sm leading-6 text-slate-600">
                Setelah login, admin masuk ke dashboard admin dan customer masuk ke dashboard customer tanpa package tambahan.
            </p>
        </article>

        <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-400">Middleware</p>
            <h2 class="mt-4 text-xl font-bold text-slate-900">Admin & customer guards</h2>
            <p class="mt-3 text-sm leading-6 text-slate-600">
                Route admin dan customer sekarang dibatasi dengan middleware role sederhana yang mudah dikembangkan.
            </p>
        </article>
    </section>
@endsection
