<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-slate-400">Customer Area</p>
                <h1 class="mt-2 text-3xl font-black tracking-tight text-slate-950">Dashboard Customer</h1>
            </div>

            <div class="rounded-2xl bg-slate-900 px-4 py-3 text-sm font-medium text-white">
                Halo, {{ auth()->user()->name }}
            </div>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <section class="grid gap-6 xl:grid-cols-[minmax(0,1.15fr)_minmax(320px,0.85fr)]">
            <article class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-sm">
                <span class="inline-flex rounded-full bg-brand-50 px-4 py-2 text-sm font-semibold text-brand-700">
                    Session Auth Active
                </span>

                <h2 class="mt-6 text-3xl font-black tracking-tight text-slate-950">
                    Login berhasil dan route customer sudah terlindungi.
                </h2>

                <p class="mt-5 max-w-2xl text-base leading-8 text-slate-600">
                    Area ini adalah landing page untuk user customer setelah login. Nanti dashboard ini bisa kita
                    kembangkan menjadi riwayat order, status pembayaran, alamat pengiriman, dan wishlist.
                </p>

                <div class="mt-8 grid gap-4 md:grid-cols-3">
                    <div class="rounded-3xl bg-slate-50 p-5">
                        <p class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-400">Role</p>
                        <p class="mt-3 text-lg font-semibold text-slate-900">{{ auth()->user()->role }}</p>
                    </div>
                    <div class="rounded-3xl bg-slate-50 p-5">
                        <p class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-400">Email</p>
                        <p class="mt-3 break-all text-lg font-semibold text-slate-900">{{ auth()->user()->email }}</p>
                    </div>
                    <div class="rounded-3xl bg-slate-50 p-5">
                        <p class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-400">Status</p>
                        <p class="mt-3 text-lg font-semibold text-slate-900">{{ auth()->user()->status }}</p>
                    </div>
                </div>
            </article>

            <article class="rounded-[2rem] border border-slate-200 bg-slate-950 p-8 text-white shadow-xl shadow-slate-900/10">
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-400">Next Build</p>

                <ul class="mt-6 space-y-4">
                    <li class="rounded-3xl border border-white/10 bg-white/5 p-4 text-sm leading-6 text-slate-300">
                        Cart management dan mini checkout flow customer
                    </li>
                    <li class="rounded-3xl border border-white/10 bg-white/5 p-4 text-sm leading-6 text-slate-300">
                        Order history, payment status, dan detail transaksi
                    </li>
                    <li class="rounded-3xl border border-white/10 bg-white/5 p-4 text-sm leading-6 text-slate-300">
                        Update profil akun dan alamat pengiriman
                    </li>
                </ul>
            </article>
        </section>
    </div>
</x-app-layout>
