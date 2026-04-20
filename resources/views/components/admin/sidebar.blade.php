@php
    $items = [
        ['label' => 'Dasbor', 'route' => 'admin.dashboard', 'state' => 'ready'],
        ['label' => 'Kategori', 'route' => 'admin.categories.index', 'state' => 'ready'],
        ['label' => 'Produk', 'route' => 'admin.products.index', 'state' => 'ready'],
        ['label' => 'Pesanan', 'route' => 'admin.orders.index', 'state' => 'ready'],
        ['label' => 'Inventaris', 'route' => 'admin.inventory.index', 'state' => 'ready'],
    ];
@endphp

<aside class="flex min-h-[calc(100vh-3rem)] flex-col justify-between rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
    <div>
        <div class="mb-8 flex justify-center">
            <img
                src="/img/stock-icon.png"
                alt="{{ config('app.name') }}"
                class="h-16 w-auto object-contain"
            >
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
                        <span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-semibold text-emerald-700">Siap</span>
                    </a>
                @else
                    <div class="flex items-center justify-between rounded-2xl border border-dashed border-slate-200 px-4 py-3 text-sm font-medium text-slate-400">
                        <span>{{ $item['label'] }}</span>
                        <span class="rounded-full bg-amber-100 px-2 py-1 text-xs font-semibold text-amber-700">Berikutnya</span>
                    </div>
                @endif
            @endforeach
        </nav>
    </div>
    <div class="pt-6 space-y-3">
        <a href="{{ route('home') }}" class="flex items-center justify-center rounded-2xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
            Lihat Toko
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex w-full items-center justify-center rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                Keluar
            </button>
        </form>
    </div>
</aside>
