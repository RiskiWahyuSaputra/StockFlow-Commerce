@php
    $navItems = [
        ['label' => 'Beranda', 'route' => 'home'],
        ['label' => 'Produk', 'route' => 'products.index'],
        ['label' => 'Checkout', 'route' => 'checkout.index'],
    ];

    $isTransparent = request()->routeIs('home') || request()->routeIs('products.*');
@endphp

<header @class([
    'inset-x-0 top-0 z-30',
    'absolute' => $isTransparent,
    'sticky border-b border-white/60 bg-white/75 backdrop-blur-xl' => ! $isTransparent,
])>
    <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
        <a
            href="{{ route('home') }}"
            @class([
                'flex items-center',
                'bg-transparent px-0 py-0 shadow-none backdrop-blur-none' => $isTransparent,
            ])
        >
            <img src="/img/stock-icon.png" alt="{{ config('app.name') }}" class="h-14 w-48 object-contain drop-shadow-md">
        </a>

        <nav class="flex-1 flex justify-center items-center max-w-md">
            <div @class([
                'hidden items-center gap-2 rounded-full p-1.5 lg:flex',
                'bg-transparent shadow-none backdrop-blur-none' => $isTransparent,
                'border border-slate-200/80 bg-white shadow-sm' => ! $isTransparent,
            ])>
                @foreach ($navItems as $item)
                    <a
                        href="{{ route($item['route']) }}"
                        @class([
                            'rounded-full px-4 py-2 text-sm font-medium transition',
                            'bg-transparent text-white' => $isTransparent && request()->routeIs($item['route']),
                            'bg-transparent text-white hover:text-white/80' => $isTransparent && ! request()->routeIs($item['route']),
                            'bg-slate-900 text-white' => ! $isTransparent && request()->routeIs($item['route']),
                            'text-slate-600 hover:bg-slate-100 hover:text-slate-900' => ! $isTransparent && ! request()->routeIs($item['route']),
                        ])
                    >
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </div>
        </nav>

        <div class="flex items-center gap-3">
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
