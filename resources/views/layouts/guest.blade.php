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

            <div class="relative mx-auto flex min-h-screen max-w-7xl items-center justify-center px-4 py-8 lg:px-8">
                <section class="flex w-full items-center justify-center">
                    <div class="w-full max-w-xl rounded-[2rem] border border-white/10 bg-white p-6 shadow-2xl shadow-black/20 sm:p-8">
                        <div class="mb-8 flex justify-center">
                            <a href="{{ route('home') }}" class="inline-flex items-center justify-center">
                                <img
                                    src="/img/stock-icon.png"
                                    alt="{{ config('app.name') }}"
                                    class="h-16 w-auto object-contain"
                                >
                            </a>
                        </div>

                        {{ $slot }}
                    </div>
                </section>
            </div>
        </div>
    </body>
</html>
