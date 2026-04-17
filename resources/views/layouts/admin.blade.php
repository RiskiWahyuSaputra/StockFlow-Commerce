<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Admin Panel').' | '.config('app.name')</title>
        <meta name="description" content="Minimal admin dashboard preview for the E-Commerce Platform.">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>
    <body class="font-sans text-slate-900">
        <div class="min-h-screen bg-[linear-gradient(180deg,#e2e8f0_0%,#f8fafc_100%)]">
            <div class="mx-auto grid min-h-screen max-w-[1600px] gap-6 px-4 py-6 sm:px-6 lg:grid-cols-[280px_minmax(0,1fr)] lg:px-8">
                <x-admin.sidebar />

                <div class="flex min-w-0 flex-col gap-6">
                    <x-admin.header />

                    <main class="min-w-0">
                        @yield('content')
                    </main>
                </div>
            </div>
        </div>

        @stack('scripts')
    </body>
</html>
