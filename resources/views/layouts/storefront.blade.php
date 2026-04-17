<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name'))</title>
        <meta name="description" content="@yield('meta_description', 'Modern ecommerce storefront built with Laravel Blade and Tailwind CSS.')">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>
    <body class="font-sans text-slate-900">
        <div class="relative min-h-screen overflow-hidden">
            <div class="pointer-events-none absolute inset-x-0 top-0 h-[34rem] bg-[radial-gradient(circle_at_top_left,rgba(15,118,110,0.16),transparent_32%),radial-gradient(circle_at_top_right,rgba(249,115,22,0.1),transparent_28%)]"></div>

            <x-frontend.navbar />

            @if (session('status'))
                <div class="mx-auto mt-4 w-full max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                        {{ session('status') }}
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="mx-auto mt-4 w-full max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-700">
                        {{ $errors->first() }}
                    </div>
                </div>
            @endif

            <main class="relative mx-auto w-full max-w-7xl px-4 pb-20 pt-8 sm:px-6 lg:px-8">
                @yield('content')
            </main>

            <x-frontend.footer />
        </div>

        @stack('scripts')
    </body>
</html>
