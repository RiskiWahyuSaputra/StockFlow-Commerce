<nav x-data="{ open: false }" class="border-b border-slate-200/80 bg-white/80 backdrop-blur">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between gap-4 py-4">
            <div class="flex items-center gap-6">
                <div class="shrink-0">
                    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}" class="flex items-center gap-3">
                        <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-900 text-sm font-black text-white">
                            SC
                        </span>

                        <span>
                            <span class="block text-xs font-semibold uppercase tracking-[0.28em] text-slate-400">Area Masuk</span>
                            <span class="block text-lg font-bold text-slate-900">{{ config('app.name') }}</span>
                        </span>
                    </a>
                </div>

                <div class="hidden items-center gap-2 rounded-full border border-slate-200 bg-white p-1.5 shadow-sm sm:flex">
                    @if (auth()->user()->isCustomer())
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            Dasbor
                        </x-nav-link>
                        <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.*')">
                            Profil
                        </x-nav-link>
                    @endif

                    @if (auth()->user()->isAdmin())
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            Admin
                        </x-nav-link>
                    @endif

                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        Toko
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-600 shadow-sm transition hover:border-slate-300 hover:text-slate-900">
                            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-900 text-xs font-bold text-white">
                                {{ strtoupper(str(auth()->user()->name)->substr(0, 2)) }}
                            </span>
                            <span class="text-left">
                                <span class="block font-semibold text-slate-900">{{ Auth::user()->name }}</span>
                                <span class="block text-xs uppercase tracking-[0.2em] text-slate-400">{{ Auth::user()->role }}</span>
                            </span>

                            <div class="ms-1">
                                <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @if (auth()->user()->isCustomer())
                            <x-dropdown-link :href="route('profile.edit')">
                                Profil Saya
                            </x-dropdown-link>
                        @endif

                        @if (auth()->user()->isAdmin())
                            <x-dropdown-link :href="route('admin.dashboard')">
                                Panel Admin
                            </x-dropdown-link>
                        @endif

                        <x-dropdown-link :href="route('home')">
                            Kembali ke Toko
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                Keluar
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white p-2 text-slate-500 shadow-sm transition hover:text-slate-700">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="space-y-1 border-t border-slate-200 px-4 pb-4 pt-3">
            @if (auth()->user()->isCustomer())
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    Dasbor
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.*')">
                    Profil
                </x-responsive-nav-link>
            @endif

            @if (auth()->user()->isAdmin())
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    Panel Admin
                </x-responsive-nav-link>
            @endif

            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                Toko
            </x-responsive-nav-link>
        </div>

        <div class="border-t border-slate-200 px-4 pb-4 pt-4">
            <div class="px-4">
                <div class="font-medium text-base text-slate-900">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-slate-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                @if (auth()->user()->isCustomer())
                    <x-responsive-nav-link :href="route('profile.edit')">
                        Profil Saya
                    </x-responsive-nav-link>
                @endif

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        Keluar
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
