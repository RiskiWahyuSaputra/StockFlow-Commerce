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
            <p class="text-sm font-semibold text-slate-900">Catatan Sistem</p>
            <div class="mt-4 space-y-3 rounded-3xl border border-slate-200 bg-slate-50 p-5 text-sm leading-7 text-slate-600">
                <p>Antarmuka ini dibangun agar storefront, admin, checkout, dan riwayat pesanan terasa konsisten dalam satu alur.</p>
                <p>Flow pembayaran Midtrans, manajemen stok, dan panel admin sudah terhubung agar cocok dipresentasikan sebagai project portfolio.</p>
            </div>
        </div>
    </div>
</footer>
