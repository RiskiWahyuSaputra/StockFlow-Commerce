<footer class="border-t border-neutral-200 bg-white">
    <div class="mx-auto grid w-full max-w-7xl gap-10 px-4 py-10 sm:px-6 lg:grid-cols-[1.1fr_0.9fr_0.8fr] lg:px-8">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.35em] text-neutral-500">{{ config('app.name') }}</p>
            <h2 class="mt-3 text-2xl font-black tracking-tight text-neutral-950">
                Fondasi storefront modern yang siap dipakai untuk demo portfolio maupun pengembangan lanjutan.
            </h2>
            <p class="mt-4 max-w-xl text-sm leading-7 text-neutral-600">
                Dibangun dengan Laravel Blade, Tailwind CSS, dan struktur komponen reusable agar mudah berkembang dari mockup menjadi produk yang benar-benar jalan.
            </p>
        </div>

        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-1">
            <div>
                <p class="text-sm font-semibold text-neutral-950">Jelajahi</p>
                <div class="mt-4 space-y-3 text-sm text-neutral-600">
                    <a href="{{ route('home') }}" class="block transition hover:text-black">Beranda</a>
                    <a href="{{ route('products.index') }}" class="block transition hover:text-black">Katalog Produk</a>
                    <a href="{{ route('cart.index') }}" class="block transition hover:text-black">Keranjang</a>
                    <a href="{{ route('checkout.index') }}" class="block transition hover:text-black">Checkout</a>
                </div>
            </div>
        </div>

        <div>
            <p class="text-sm font-semibold text-neutral-950">Sosial Media</p>
            <div class="mt-4 grid gap-3">
                <a href="https://instagram.com" target="_blank" rel="noreferrer" class="group flex items-center gap-4 rounded-3xl border border-neutral-200 bg-white px-5 py-4 text-sm text-neutral-600 transition hover:-translate-y-0.5 hover:border-black hover:bg-black hover:text-white">
                    <span class="flex h-11 w-11 items-center justify-center rounded-2xl border border-neutral-200 bg-white text-neutral-900 transition group-hover:border-white group-hover:bg-white group-hover:text-black">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5 fill-current" aria-hidden="true">
                            <path d="M7.75 2h8.5A5.75 5.75 0 0 1 22 7.75v8.5A5.75 5.75 0 0 1 16.25 22h-8.5A5.75 5.75 0 0 1 2 16.25v-8.5A5.75 5.75 0 0 1 7.75 2Zm0 1.5A4.25 4.25 0 0 0 3.5 7.75v8.5a4.25 4.25 0 0 0 4.25 4.25h8.5a4.25 4.25 0 0 0 4.25-4.25v-8.5a4.25 4.25 0 0 0-4.25-4.25h-8.5Zm8.75 2.25a1 1 0 1 1 0 2 1 1 0 0 1 0-2ZM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10Zm0 1.5A3.5 3.5 0 1 0 12 15.5 3.5 3.5 0 0 0 12 8.5Z"/>
                        </svg>
                    </span>
                    <div>
                        <p class="font-semibold text-neutral-950 transition group-hover:text-white">Instagram</p>
                        <p class="mt-1 text-xs uppercase tracking-[0.24em] text-neutral-400 transition group-hover:text-neutral-300">@stockflowcommerce</p>
                    </div>
                </a>

                <a href="https://facebook.com" target="_blank" rel="noreferrer" class="group flex items-center gap-4 rounded-3xl border border-neutral-200 bg-white px-5 py-4 text-sm text-neutral-600 transition hover:-translate-y-0.5 hover:border-black hover:bg-black hover:text-white">
                    <span class="flex h-11 w-11 items-center justify-center rounded-2xl border border-neutral-200 bg-white text-neutral-900 transition group-hover:border-white group-hover:bg-white group-hover:text-black">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5 fill-current" aria-hidden="true">
                            <path d="M13.5 22v-8h2.7l.4-3h-3.1V9.08c0-.9.28-1.5 1.58-1.5H16.8V4.9a23.1 23.1 0 0 0-2.57-.13c-2.54 0-4.28 1.55-4.28 4.4V11H7v3h2.95v8h3.55Z"/>
                        </svg>
                    </span>
                    <div>
                        <p class="font-semibold text-neutral-950 transition group-hover:text-white">Facebook</p>
                        <p class="mt-1 text-xs uppercase tracking-[0.24em] text-neutral-400 transition group-hover:text-neutral-300">StockFlow Commerce</p>
                    </div>
                </a>

                <a href="https://x.com" target="_blank" rel="noreferrer" class="group flex items-center gap-4 rounded-3xl border border-neutral-200 bg-white px-5 py-4 text-sm text-neutral-600 transition hover:-translate-y-0.5 hover:border-black hover:bg-black hover:text-white">
                    <span class="flex h-11 w-11 items-center justify-center rounded-2xl border border-neutral-200 bg-white text-neutral-900 transition group-hover:border-white group-hover:bg-white group-hover:text-black">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5 fill-current" aria-hidden="true">
                            <path d="M18.9 2H22l-6.77 7.73L23 22h-6.1l-4.77-6.24L6.67 22H3.55l7.24-8.27L1 2h6.25l4.32 5.72L18.9 2Zm-1.07 18.17h1.72L6.3 3.74H4.46l13.37 16.43Z"/>
                        </svg>
                    </span>
                    <div>
                        <p class="font-semibold text-neutral-950 transition group-hover:text-white">X / Twitter</p>
                        <p class="mt-1 text-xs uppercase tracking-[0.24em] text-neutral-400 transition group-hover:text-neutral-300">@stockflowco</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</footer>
