<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name'))</title>

        <meta
            name="description"
            content="Storefront E-Commerce Platform dengan Laravel, Blade, Tailwind CSS, dan autentikasi role-based."
        >

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>
    <body class="font-sans text-slate-900">
        <div class="relative min-h-screen">
            <x-frontend.navbar />

            @if (session('status'))
                <div class="mx-auto mt-4 w-full max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                        {{ session('status') }}
                    </div>
                </div>
            @endif

            <main class="mx-auto flex w-full max-w-7xl flex-1 flex-col px-4 pb-16 pt-8 sm:px-6 lg:px-8">
                @yield('content')
            </main>

            <x-frontend.footer />
        </div>

        @stack('scripts')
    </body>
</html>
