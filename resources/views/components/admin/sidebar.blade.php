@php
    $items = [
        ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'state' => 'ready'],
        ['label' => 'Products', 'route' => null, 'state' => 'next'],
        ['label' => 'Orders', 'route' => null, 'state' => 'next'],
        ['label' => 'Inventory', 'route' => null, 'state' => 'next'],
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
                        'bg-slate-900 text-white shadow-lg shadow-slate-900/10' => request()->routeIs($item['route']),
                        'text-slate-600 hover:bg-slate-100' => ! request()->routeIs($item['route']),
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
            Route admin ini masih berupa preview layout. Middleware auth dan role admin akan kita aktifkan di tahap autentikasi.
        </p>
    </div>
</aside>
