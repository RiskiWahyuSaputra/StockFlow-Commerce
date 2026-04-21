<div
    x-data="{ open: false }"
    @open-cart-drawer.window="open = true"
    @keydown.escape.window="open = false"
    x-show="open"
    x-cloak
    class="fixed inset-0"
    style="z-index: 999999;"
>
    <!-- Background overlay -->
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="open = false"
        class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"
    ></div>

    <div class="fixed inset-y-0 right-0 flex max-w-full pl-10">
        <div
            x-show="open"
            x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="w-screen max-w-md pointer-events-auto"
        >
            <div class="flex h-full flex-col bg-white shadow-2xl overflow-hidden">
                <div class="flex-1 overflow-y-auto px-6 py-8 sm:px-8">
                    <div class="flex items-start justify-between border-b border-slate-100 pb-6">
                        <h2 class="text-xl font-black tracking-tight text-slate-950">Keranjang Belanja</h2>
                        <button type="button" @click="open = false" class="text-slate-400 hover:text-slate-500">
                            <span class="sr-only">Tutup</span>
                            <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="mt-8">
                        <ul role="list" class="-my-6 divide-y divide-slate-100">
                            @if(isset($cart) && $cart && $cart->items->count() > 0)
                                @foreach($cart->items as $item)
                                    <li class="flex py-6">
                                        <div class="size-20 shrink-0 overflow-hidden rounded-xl border border-slate-100 bg-slate-50">
                                            @if($item->product->primaryImage)
                                                <img src="{{ $item->product->primaryImage->image_url }}" alt="{{ $item->product->name }}" class="size-full object-cover">
                                            @else
                                                <div class="flex size-full items-center justify-center bg-slate-200 text-slate-400">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="ml-4 flex flex-1 flex-col">
                                            <div>
                                                <div class="flex justify-between text-sm font-bold text-slate-950">
                                                    <h3><a href="{{ route('products.show', $item->product->slug) }}">{{ $item->product->name }}</a></h3>
                                                    <p class="ml-4">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                                </div>
                                                <p class="mt-1 text-xs text-slate-500">{{ $item->product->category->name }}</p>
                                            </div>
                                            <div class="flex flex-1 items-end justify-between text-xs">
                                                <p class="text-slate-500 font-medium">Qty {{ $item->quantity }}</p>
                                                <form action="{{ route('cart.items.destroy', $item) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="font-bold text-teal-600 hover:text-teal-500">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            @else
                                <div class="flex flex-col items-center justify-center py-24 text-center">
                                    <div class="flex size-20 items-center justify-center rounded-full bg-slate-50 text-slate-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                                    </div>
                                    <h3 class="mt-5 text-base font-bold text-slate-950">Keranjang Kosong</h3>
                                    <p class="mt-2 text-sm text-slate-500">Mungkin saatnya mencari sesuatu yang spesial?</p>
                                    <a href="{{ route('products.index') }}" class="mt-8 inline-flex items-center justify-center rounded-full bg-slate-950 px-6 py-3 text-xs font-black text-white transition hover:bg-slate-800">
                                        Lihat Katalog
                                    </a>
                                </div>
                            @endif
                        </ul>
                    </div>
                </div>

                @if(isset($cart) && $cart && $cart->items->count() > 0)
                    <div class="border-t border-slate-100 bg-slate-50/50 px-6 py-8 sm:px-8">
                        <div class="flex justify-between text-base font-black text-slate-950">
                            <p>Subtotal</p>
                            <p>Rp{{ number_format($cart->subtotal, 0, ',', '.') }}</p>
                        </div>
                        <p class="mt-1 text-xs text-slate-500 font-medium">Pengiriman dihitung di halaman berikutnya.</p>
                        <div class="mt-8">
                            <a href="{{ route('cart.index') }}" class="flex items-center justify-center rounded-2xl bg-slate-950 px-6 py-4 text-sm font-black text-white shadow-xl shadow-slate-950/20 transition hover:bg-slate-800">
                                Lanjut ke Keranjang
                            </a>
                        </div>
                        <button type="button" @click="open = false" class="mt-4 w-full text-center text-xs font-bold text-slate-500 hover:text-slate-950">
                            Lanjutkan Belanja &rarr;
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
