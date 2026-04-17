@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('heading', 'Admin Dashboard')

@section('content')
    <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        @foreach ($dashboard['stats'] as $stat)
            <article class="rounded-[1.8rem] border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-400">{{ $stat['label'] }}</p>
                <p class="mt-4 text-3xl font-black tracking-tight text-slate-950">{{ $stat['value'] }}</p>
                <p class="mt-2 text-sm font-medium text-emerald-600">{{ $stat['delta'] }}</p>
            </article>
        @endforeach
    </section>

    <section class="mt-6 grid gap-6 xl:grid-cols-[minmax(0,1.1fr)_minmax(360px,0.9fr)]">
        <article class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-bold text-slate-950">Recent Activity</h2>

            <div class="mt-6 space-y-4">
                @foreach ($dashboard['activities'] as $activity)
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                        <p class="font-semibold text-slate-900">{{ $activity['title'] }}</p>
                        <p class="mt-2 text-sm leading-7 text-slate-600">{{ $activity['meta'] }}</p>
                    </div>
                @endforeach
            </div>
        </article>

        <article class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-bold text-slate-950">Low Stock Watch</h2>

            <div class="mt-6 space-y-3">
                @foreach ($dashboard['low_stock'] as $item)
                    <div class="flex items-center justify-between rounded-3xl border border-slate-200 px-4 py-4">
                        <div>
                            <p class="font-semibold text-slate-900">{{ $item['name'] }}</p>
                            <p class="mt-1 text-sm text-slate-500">{{ $item['sku'] }}</p>
                        </div>
                        <div class="rounded-full bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-700">
                            {{ $item['stock'] }} left
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 rounded-3xl bg-slate-950 px-5 py-5 text-white">
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-400">Dashboard Note</p>
                <p class="mt-3 text-sm leading-7 text-slate-300">
                    Admin layout ini sengaja dibuat clean dan ringan supaya cocok untuk portfolio, tapi masih realistis untuk berkembang ke order management, inventory, dan reporting.
                </p>
            </div>
        </article>
    </section>
@endsection
