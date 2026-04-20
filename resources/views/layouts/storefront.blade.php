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
            <x-frontend.navbar />

            <x-shared.flash-messages class="mx-auto mt-4 flex w-full max-w-7xl flex-col gap-3 px-4 sm:px-6 lg:px-8" />

            <main class="relative mx-auto w-full max-w-7xl px-4 pb-20 pt-8 sm:px-6 lg:px-8">
                @yield('content')
            </main>

            <x-frontend.footer />
        </div>

        @stack('scripts')
    </body>
</html>
