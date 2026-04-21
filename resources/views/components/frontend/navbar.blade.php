@php
    $navItems = [
        ['label' => 'Beranda', 'route' => 'home'],
        ['label' => 'Produk', 'route' => 'products.index'],
        ['label' => 'Checkout', 'route' => 'checkout.index'],
    ];

    $isTransparent = request()->routeIs('home') || 
                     request()->routeIs('products.*') || 
                     request()->routeIs('cart.*') || 
                     request()->routeIs('checkout.*') ||
                     request()->routeIs('dashboard') ||
                     request()->routeIs('profile.*');
@endphp

<header @class([
    'inset-x-0 top-0 z-30',
    'absolute' => $isTransparent,
    'sticky border-b border-white/10 bg-black/80 backdrop-blur-xl' => ! $isTransparent,
])>
    <div class="mx-auto flex w-full max-w-7xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:grid lg:grid-cols-[15rem_minmax(0,1fr)_15rem] lg:gap-6 lg:px-8">
        <a
            href="{{ route('home') }}"
            @class([
                'flex items-center shrink-0',
                'bg-transparent px-0 py-0 shadow-none backdrop-blur-none' => $isTransparent,
            ])
        >
            <img src="/img/stock-icon.png" alt="{{ config('app.name') }}" class="h-[3.9rem] w-48 object-contain drop-shadow-md lg:h-[4.1rem] lg:w-52">
        </a>

        <nav class="hidden justify-center lg:flex">
            <div @class([
                'flex items-center gap-12 xl:gap-16',
            ])>
                @foreach ($navItems as $item)
                    <a
                        href="{{ route($item['route']) }}"
                        @class([
                            'px-4 text-sm font-medium transition',
                            'text-white' => request()->routeIs($item['route']),
                            'text-white hover:text-white/80' => ! request()->routeIs($item['route']),
                        ])
                    >
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </div>
        </nav>

        <div class="flex items-center justify-end gap-3">
            @auth
                <a
                    href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}"
                    @class([
                        'hidden rounded-full px-4 py-2 text-sm font-semibold transition sm:inline-flex',
                        'border border-white/15 bg-white/10 text-white shadow-[0_18px_40px_rgba(15,23,42,0.22)] backdrop-blur hover:bg-white/15' => $isTransparent,
                        'border border-slate-200 bg-white text-slate-700 shadow-sm hover:border-slate-300 hover:text-slate-900' => ! $isTransparent,
                    ])
                >
                    {{ auth()->user()->isAdmin() ? 'Panel Admin' : 'Dasbor Saya' }}
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        type="submit"
                        @class([
                            'rounded-full px-4 py-2 text-sm font-semibold transition',
                            'bg-white text-slate-950 hover:bg-slate-100' => $isTransparent,
                            'bg-slate-900 text-white hover:bg-slate-800' => ! $isTransparent,
                        ])
                    >
                        Keluar
                    </button>
                </form>
            @else
                <a
                    href="{{ route('login') }}"
                    @class([
                        'rounded-full px-4 py-2 text-sm font-semibold transition',
                        'border border-white/15 bg-white/10 text-white shadow-[0_18px_40px_rgba(15,23,42,0.22)] backdrop-blur hover:bg-white/15' => $isTransparent,
                        'border border-slate-200 bg-white text-slate-700 shadow-sm hover:border-slate-300 hover:text-slate-900' => ! $isTransparent,
                    ])
                >
                    Masuk
                </a>
                <a
                    href="{{ route('register') }}"
                    @class([
                        'rounded-full px-4 py-2 text-sm font-semibold transition',
                        'bg-white text-slate-950 hover:bg-slate-100' => $isTransparent,
                        'bg-slate-900 text-white hover:bg-slate-800' => ! $isTransparent,
                    ])
                >
                    Daftar
                </a>
            @endauth
        </div>
    </div>
</header>
