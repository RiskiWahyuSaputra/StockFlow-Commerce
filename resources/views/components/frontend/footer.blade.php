<footer class="border-t border-slate-200/80 bg-white/75 backdrop-blur">
    <div class="mx-auto grid w-full max-w-7xl gap-10 px-4 py-10 sm:px-6 lg:grid-cols-[1.1fr_0.9fr_0.8fr] lg:px-8">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.35em] text-slate-400">{{ config('app.name') }}</p>
            <h2 class="mt-3 text-2xl font-black tracking-tight text-slate-950">
                Fondasi storefront modern yang siap dipakai untuk demo portfolio maupun pengembangan lanjutan.
            </h2>
            <p class="mt-4 max-w-xl text-sm leading-7 text-slate-600">
                Dibangun dengan Laravel Blade, Tailwind CSS, dan struktur komponen reusable agar mudah berkembang dari mockup menjadi produk yang benar-benar jalan.
            </p>
        </div>

        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-1">
            <div>
                <p class="text-sm font-semibold text-slate-900">Jelajahi</p>
                <div class="mt-4 space-y-3 text-sm text-slate-600">
                    <a href="{{ route('home') }}" class="block transition hover:text-slate-950">Beranda</a>
                    <a href="{{ route('products.index') }}" class="block transition hover:text-slate-950">Katalog Produk</a>
                    <a href="{{ route('cart.index') }}" class="block transition hover:text-slate-950">Keranjang</a>
                    <a href="{{ route('checkout.index') }}" class="block transition hover:text-slate-950">Checkout</a>
                </div>
            </div>
        </div>

        <div>
            <p class="text-sm font-semibold text-slate-900">Sosial Media</p>
            <div class="mt-4 grid gap-3">
                <a href="https://instagram.com" target="_blank" rel="noreferrer" class="group flex items-center gap-4 rounded-3xl border border-slate-200 bg-slate-50 px-5 py-4 text-sm text-slate-600 transition hover:-translate-y-0.5 hover:border-slate-300 hover:bg-white hover:text-slate-950">
                    <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-slate-900 shadow-sm ring-1 ring-slate-200 transition group-hover:bg-slate-900 group-hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5 fill-current" aria-hidden="true">
                            <path d="M7.75 2h8.5A5.75 5.75 0 0 1 22 7.75v8.5A5.75 5.75 0 0 1 16.25 22h-8.5A5.75 5.75 0 0 1 2 16.25v-8.5A5.75 5.75 0 0 1 7.75 2Zm0 1.5A4.25 4.25 0 0 0 3.5 7.75v8.5a4.25 4.25 0 0 0 4.25 4.25h8.5a4.25 4.25 0 0 0 4.25-4.25v-8.5a4.25 4.25 0 0 0-4.25-4.25h-8.5Zm8.75 2.25a1 1 0 1 1 0 2 1 1 0 0 1 0-2ZM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10Zm0 1.5A3.5 3.5 0 1 0 12 15.5 3.5 3.5 0 0 0 12 8.5Z"/>
                        </svg>
                    </span>
                    <div>
                        <p class="font-semibold text-slate-900 transition group-hover:text-slate-950">Instagram</p>
                        <p class="mt-1 text-xs uppercase tracking-[0.24em] text-slate-400">@stockflowcommerce</p>
                    </div>
                </a>

                <a href="https://facebook.com" target="_blank" rel="noreferrer" class="group flex items-center gap-4 rounded-3xl border border-slate-200 bg-slate-50 px-5 py-4 text-sm text-slate-600 transition hover:-translate-y-0.5 hover:border-slate-300 hover:bg-white hover:text-slate-950">
                    <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-slate-900 shadow-sm ring-1 ring-slate-200 transition group-hover:bg-slate-900 group-hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5 fill-current" aria-hidden="true">
                            <path d="M13.5 22v-8h2.7l.4-3h-3.1V9.08c0-.9.28-1.5 1.58-1.5H16.8V4.9a23.1 23.1 0 0 0-2.57-.13c-2.54 0-4.28 1.55-4.28 4.4V11H7v3h2.95v8h3.55Z"/>
                        </svg>
                    </span>
                    <div>
                        <p class="font-semibold text-slate-900 transition group-hover:text-slate-950">Facebook</p>
                        <p class="mt-1 text-xs uppercase tracking-[0.24em] text-slate-400">StockFlow Commerce</p>
                    </div>
                </a>

                <a href="https://x.com" target="_blank" rel="noreferrer" class="group flex items-center gap-4 rounded-3xl border border-slate-200 bg-slate-50 px-5 py-4 text-sm text-slate-600 transition hover:-translate-y-0.5 hover:border-slate-300 hover:bg-white hover:text-slate-950">
                    <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-slate-900 shadow-sm ring-1 ring-slate-200 transition group-hover:bg-slate-900 group-hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5 fill-current" aria-hidden="true">
                            <path d="M18.9 2H22l-6.77 7.73L23 22h-6.1l-4.77-6.24L6.67 22H3.55l7.24-8.27L1 2h6.25l4.32 5.72L18.9 2Zm-1.07 18.17h1.72L6.3 3.74H4.46l13.37 16.43Z"/>
                        </svg>
                    </span>
                    <div>
                        <p class="font-semibold text-slate-900 transition group-hover:text-slate-950">X / Twitter</p>
                        <p class="mt-1 text-xs uppercase tracking-[0.24em] text-slate-400">@stockflowco</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</footer>
