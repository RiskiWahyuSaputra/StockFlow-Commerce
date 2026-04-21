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
    @php
        $isHomeRoute = request()->routeIs('home');
    @endphp
    <body class="font-sans text-slate-900" style="{{ $isHomeRoute ? 'background:#000000;' : '' }}">
        <div class="relative min-h-screen overflow-hidden" style="{{ $isHomeRoute ? 'background:#000000;' : '' }}">
            <x-frontend.navbar />

            <x-shared.flash-messages class="mx-auto {{ $isHomeRoute ? 'mt-24' : 'mt-4' }} flex w-full max-w-7xl flex-col gap-3 px-4 sm:px-6 lg:px-8" />

            @if($isHomeRoute)
                <main class="relative w-full" style="background:#000000; padding:0; overflow:hidden;">
                    @yield('content')
                </main>
            @else
                <main class="relative mx-auto w-full max-w-7xl px-4 pb-20 pt-8 sm:px-6 lg:px-8">
                    @yield('content')
                </main>
            @endif

            <x-frontend.footer />
        </div>

        @stack('scripts')
    </body>
</html>