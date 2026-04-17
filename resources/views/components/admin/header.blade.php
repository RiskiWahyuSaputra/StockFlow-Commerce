<header class="rounded-3xl border border-slate-200 bg-white px-6 py-5 shadow-sm">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-slate-400">Admin Overview</p>
            <h1 class="mt-2 text-2xl font-bold text-slate-900">@yield('heading', 'Dashboard')</h1>
        </div>

        <div class="flex flex-col gap-3 lg:items-end">
            <div class="rounded-2xl bg-slate-50 px-4 py-3 text-sm text-slate-600">
                {{ now()->translatedFormat('l, d F Y') }}
            </div>

            <div class="text-sm text-slate-500">
                Login sebagai <span class="font-semibold text-slate-900">{{ auth()->user()->name }}</span>
            </div>
        </div>
    </div>
</header>
