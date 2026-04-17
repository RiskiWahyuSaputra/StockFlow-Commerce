@php
    $links = [
        ['label' => 'Beranda', 'route' => 'home'],
        ['label' => 'Admin Preview', 'route' => 'admin.dashboard'],
    ];
@endphp

<header class="border-b border-slate-200/80 bg-white/80 backdrop-blur">
    <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-brand-600 text-sm font-bold text-white">
                EC
            </span>

            <span>
                <span class="block text-sm font-semibold tracking-[0.2em] text-slate-500 uppercase">Laravel Fullstack</span>
                <span class="block text-lg font-bold text-slate-900">{{ config('app.name') }}</span>
            </span>
        </a>

        <nav class="flex items-center gap-2 rounded-full border border-slate-200 bg-white p-1.5 shadow-sm">
            @foreach ($links as $link)
                <a
                    href="{{ route($link['route']) }}"
                    @class([
                        'rounded-full px-4 py-2 text-sm font-medium transition',
                        'bg-slate-900 text-white' => request()->routeIs($link['route']),
                        'text-slate-600 hover:bg-slate-100' => ! request()->routeIs($link['route']),
                    ])
                >
                    {{ $link['label'] }}
                </a>
            @endforeach
        </nav>
    </div>
</header>
