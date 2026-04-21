<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'Admin Panel').' | '.config('app.name')</title>
        <meta name="description" content="Panel admin modern untuk StockFlow Commerce.">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>
    <body class="font-sans text-white" style="background:#000000;">
        <div class="min-h-screen">
            <div class="mx-auto grid min-h-screen max-w-[1600px] gap-6 px-4 py-6 sm:px-6 lg:grid-cols-[280px_minmax(0,1fr)] lg:px-8">
                <x-admin.sidebar />

                <div class="flex min-w-0 flex-col gap-6">
                    <x-admin.header />

                    <x-shared.flash-messages class="flex flex-col gap-3" />

                    <main class="min-w-0">
                        @yield('content')
                    </main>
                </div>
            </div>
        </div>

        @stack('scripts')
    </body>
</html>
