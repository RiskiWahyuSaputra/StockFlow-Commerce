<footer class="border-t border-white/10 bg-black text-slate-300">
    <div class="mx-auto w-full max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-[1.2fr_0.8fr_0.95fr]">
            <div class="rounded-[28px] border border-white/10 bg-white/[0.03] p-8 sm:p-10">
                <p class="text-[11px] font-semibold uppercase tracking-[0.35em] text-amber-300">{{ config('app.name') }}</p>
                <h2 class="mt-4 max-w-2xl text-2xl font-black leading-tight tracking-[-0.04em] text-white sm:text-3xl">
                    Storefront modern dengan presentasi promo yang lebih rapi dan siap dipakai.
                </h2>
                <p class="mt-4 max-w-xl text-sm leading-7 text-slate-400">
                    Footer ini dibuat lebih clean supaya transisi dari halaman promo ke informasi penting terasa ringan,
                    tetap premium, dan tidak seramai versi sebelumnya.
                </p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('products.index') }}" class="inline-flex items-center rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm font-semibold text-white transition hover:border-amber-300/40 hover:bg-amber-300/10">
                        Katalog Produk
                    </a>
                    <a href="{{ route('checkout.index') }}" class="inline-flex items-center rounded-full border border-white/10 bg-transparent px-4 py-2 text-sm font-semibold text-slate-300 transition hover:border-white/20 hover:text-white">
                        Checkout
                    </a>
                </div>
            </div>

            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-1">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-500">Navigate</p>
                    <div class="mt-5 flex flex-col gap-3 text-sm">
                        <a href="{{ route('home') }}" class="transition hover:text-white">Beranda</a>
                        <a href="{{ route('products.index') }}" class="transition hover:text-white">Katalog</a>
                        <a href="{{ route('cart.index') }}" class="transition hover:text-white">Keranjang</a>
                        <a href="{{ route('checkout.index') }}" class="transition hover:text-white">Checkout</a>
                    </div>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-500">Quick Access</p>
                    <div class="mt-5 flex flex-col gap-3 text-sm">
                        @guest
                            <a href="{{ route('login') }}" class="transition hover:text-white">Masuk</a>
                            <a href="{{ route('register') }}" class="transition hover:text-white">Daftar</a>
                        @else
                            <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}" class="transition hover:text-white">
                                {{ auth()->user()->isAdmin() ? 'Panel Admin' : 'Dasbor Saya' }}
                            </a>
                        @endguest
                        <a href="{{ route('products.index') }}" class="transition hover:text-white">Promo Minggu Ini</a>
                        <a href="{{ route('cart.index') }}" class="transition hover:text-white">Review Pesanan</a>
                    </div>
                </div>
            </div>

            <div class="rounded-[28px] border border-white/10 bg-white/[0.03] p-8">
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-500">Stay Connected</p>
                <div class="mt-5 space-y-3">
                    <a href="https://instagram.com" target="_blank" rel="noreferrer" class="flex items-center justify-between rounded-2xl border border-white/10 bg-white/[0.04] px-4 py-3 text-sm transition hover:border-white/20 hover:bg-white/[0.08] hover:text-white">
                        <span>Instagram</span>
                        <span class="text-xs uppercase tracking-[0.24em] text-slate-500">@stockflowcommerce</span>
                    </a>
                    <a href="https://facebook.com" target="_blank" rel="noreferrer" class="flex items-center justify-between rounded-2xl border border-white/10 bg-white/[0.04] px-4 py-3 text-sm transition hover:border-white/20 hover:bg-white/[0.08] hover:text-white">
                        <span>Facebook</span>
                        <span class="text-xs uppercase tracking-[0.24em] text-slate-500">follow</span>
                    </a>
                    <a href="https://x.com" target="_blank" rel="noreferrer" class="flex items-center justify-between rounded-2xl border border-white/10 bg-white/[0.04] px-4 py-3 text-sm transition hover:border-white/20 hover:bg-white/[0.08] hover:text-white">
                        <span>X / Twitter</span>
                        <span class="text-xs uppercase tracking-[0.24em] text-slate-500">@stockflowco</span>
                    </a>
                </div>

                <div class="mt-6 rounded-2xl border border-amber-300/15 bg-amber-300/10 p-4">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.28em] text-amber-200">Support</p>
                    <p class="mt-2 text-sm leading-6 text-slate-300">
                        Siap untuk pertanyaan katalog, checkout, dan status pesanan dengan alur yang lebih jelas.
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-10 flex flex-wrap items-center justify-between gap-3 border-t border-white/10 pt-5 text-xs text-slate-500">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p>Built with Laravel &amp; Tailwind CSS</p>
        </div>
    </div>
</footer>
