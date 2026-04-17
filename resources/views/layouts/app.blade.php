<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', config('app.name'))</title>

        <meta
            name="description"
            content="Fondasi awal E-Commerce Platform berbasis Laravel, Blade, MySQL, dan Tailwind CSS."
        >

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>
    <body class="font-sans text-slate-900">
        <div class="relative min-h-screen">
            <x-frontend.navbar />

            <main class="mx-auto flex w-full max-w-7xl flex-1 flex-col px-4 pb-16 pt-8 sm:px-6 lg:px-8">
                @yield('content')
            </main>

            <x-frontend.footer />
        </div>

        @stack('scripts')
    </body>
</html>
