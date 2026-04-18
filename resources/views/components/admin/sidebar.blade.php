@php
    $items = [
        ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'state' => 'ready'],
        ['label' => 'Categories', 'route' => 'admin.categories.index', 'state' => 'ready'],
        ['label' => 'Products', 'route' => 'admin.products.index', 'state' => 'ready'],
        ['label' => 'Orders', 'route' => 'admin.orders.index', 'state' => 'ready'],
        ['label' => 'Inventory', 'route' => 'admin.inventory.index', 'state' => 'ready'],
    ];
@endphp

<aside class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
    <div class="mb-8 flex items-center gap-3">
        <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-900 text-sm font-bold text-white">
            AD
        </span>

        <div>
            <p class="text-sm font-semibold text-slate-500">Admin Workspace</p>
            <h2 class="text-lg font-bold text-slate-900">{{ config('app.name') }}</h2>
        </div>
    </div>

    <nav class="space-y-2">
        @foreach ($items as $item)
            @if ($item['route'])
                <a
                    href="{{ route($item['route']) }}"
                    @class([
                        'flex items-center justify-between rounded-2xl px-4 py-3 text-sm font-medium transition',
                        'bg-slate-900 text-white shadow-lg shadow-slate-900/10' => request()->routeIs($item['route']) || request()->routeIs(str_replace('.index', '.*', $item['route'])),
                        'text-slate-600 hover:bg-slate-100' => ! (request()->routeIs($item['route']) || request()->routeIs(str_replace('.index', '.*', $item['route']))),
                    ])
                >
                    <span>{{ $item['label'] }}</span>
                    <span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-semibold text-emerald-700">Ready</span>
                </a>
            @else
                <div class="flex items-center justify-between rounded-2xl border border-dashed border-slate-200 px-4 py-3 text-sm font-medium text-slate-400">
                    <span>{{ $item['label'] }}</span>
                    <span class="rounded-full bg-amber-100 px-2 py-1 text-xs font-semibold text-amber-700">Next</span>
                </div>
            @endif
        @endforeach
    </nav>

    <div class="mt-8 rounded-2xl bg-slate-50 p-4">
        <p class="text-sm font-semibold text-slate-900">Catatan setup</p>
        <p class="mt-2 text-sm leading-6 text-slate-600">
            Panel admin ini sudah tersambung ke CRUD kategori, produk, order management, payment status, dan inventory tracking.
        </p>
    </div>

    <div class="mt-4 space-y-3">
        <a href="{{ route('home') }}" class="flex items-center justify-center rounded-2xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
            Lihat Storefront
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex w-full items-center justify-center rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                Logout
            </button>
        </form>
    </div>
</aside>
