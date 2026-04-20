@php
    $navItems = [
        ['label' => 'Beranda', 'route' => 'home'],
        ['label' => 'Produk', 'route' => 'products.index'],
        ['label' => 'Keranjang', 'route' => 'cart.index'],
        ['label' => 'Checkout', 'route' => 'checkout.index'],
    ];

    if (auth()->check() && auth()->user()->isCustomer()) {
        $navItems[] = ['label' => 'Pesanan', 'route' => 'orders.index'];
    }
@endphp

<header class="sticky top-0 z-30 border-b border-white/60 bg-white/75 backdrop-blur-xl">
    <div class="mx-auto flex w-full max-w-7xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-8">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-900 text-sm font-black text-white shadow-lg shadow-slate-900/10">
                    SC
                </span>

                <span>
                    <span class="block text-[11px] font-semibold uppercase tracking-[0.35em] text-slate-400">Platform E-Commerce</span>
                    <span class="block text-lg font-bold text-slate-950">{{ config('app.name') }}</span>
                </span>
            </a>

            <nav class="hidden items-center gap-2 rounded-full border border-slate-200/80 bg-white p-1.5 shadow-sm lg:flex">
                @foreach ($navItems as $item)
                    <a
                        href="{{ route($item['route']) }}"
                        @class([
                            'rounded-full px-4 py-2 text-sm font-medium transition',
                            'bg-slate-900 text-white' => request()->routeIs($item['route']),
                            'text-slate-600 hover:bg-slate-100 hover:text-slate-900' => ! request()->routeIs($item['route']),
                        ])
                    >
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>
        </div>

        <div class="flex items-center gap-3">
            @auth
                <a
                    href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}"
                    class="hidden rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:text-slate-900 sm:inline-flex"
                >
                    {{ auth()->user()->isAdmin() ? 'Panel Admin' : 'Dasbor Saya' }}
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">
                        Keluar
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:text-slate-900">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">
                    Daftar
                </a>
            @endauth
        </div>
    </div>
</header>
