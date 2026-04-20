<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased">
        <div class="relative min-h-screen overflow-hidden bg-slate-950">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(45,212,191,0.18),transparent_28%),radial-gradient(circle_at_bottom_right,rgba(249,115,22,0.16),transparent_26%)]"></div>
            <div class="absolute inset-x-0 top-0 h-px bg-white/10"></div>

            <div class="relative mx-auto grid min-h-screen max-w-7xl gap-10 px-4 py-8 lg:grid-cols-[minmax(0,1.05fr)_minmax(440px,0.95fr)] lg:px-8">
                <section class="flex flex-col justify-between rounded-[2rem] border border-white/10 bg-white/5 p-8 text-white shadow-2xl shadow-black/20 backdrop-blur lg:p-10">
                    <div>
                        <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                            <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-sm font-black text-slate-950">
                                SC
                            </span>

                            <span>
                                <span class="block text-xs font-semibold uppercase tracking-[0.35em] text-slate-400">Portal {{ config('app.name') }}</span>
                                <span class="block text-xl font-bold">{{ config('app.name') }}</span>
                            </span>
                        </a>

                        <div class="mt-12 max-w-xl">
                            <p class="text-sm font-semibold uppercase tracking-[0.35em] text-teal-300">Portal Autentikasi</p>
                            <h1 class="mt-5 text-4xl font-black tracking-tight sm:text-5xl">
                                Masuk ke workflow toko dan dashboard admin dengan alur yang rapi.
                            </h1>
                            <p class="mt-6 text-base leading-8 text-slate-300 sm:text-lg">
                                Kita memakai autentikasi resmi Laravel dengan session-based guard, role sederhana, dan redirect otomatis sesuai tipe user.
                            </p>
                        </div>
                    </div>

                    <div class="grid gap-4 md:grid-cols-3">
                        <div class="rounded-3xl border border-white/10 bg-white/5 p-4">
                            <p class="text-sm font-semibold text-white">Pelanggan</p>
                            <p class="mt-2 text-sm leading-6 text-slate-300">Login akan diarahkan ke dasbor pelanggan dan halaman toko.</p>
                        </div>
                        <div class="rounded-3xl border border-white/10 bg-white/5 p-4">
                            <p class="text-sm font-semibold text-white">Admin</p>
                            <p class="mt-2 text-sm leading-6 text-slate-300">Akun admin otomatis diarahkan ke `/admin` dan route admin diproteksi middleware.</p>
                        </div>
                        <div class="rounded-3xl border border-white/10 bg-white/5 p-4">
                            <p class="text-sm font-semibold text-white">Stack</p>
                            <p class="mt-2 text-sm leading-6 text-slate-300">Laravel Breeze, Blade, Tailwind CSS, Alpine, dan session auth.</p>
                        </div>
                    </div>
                </section>

                <section class="flex items-center justify-center">
                    <div class="w-full max-w-xl rounded-[2rem] border border-white/10 bg-white p-6 shadow-2xl shadow-black/20 sm:p-8">
                        {{ $slot }}
                    </div>
                </section>
            </div>
        </div>
    </body>
</html>
