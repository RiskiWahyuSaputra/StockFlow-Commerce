<x-guest-layout>
    <div>
        <p class="text-sm font-semibold uppercase tracking-[0.3em] text-slate-400">Masuk</p>
        <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-950">Akses akun customer atau admin</h2>
        <p class="mt-3 text-sm leading-7 text-slate-600">
            Gunakan email dan kata sandi yang terdaftar. Admin akan diarahkan ke panel admin, pelanggan ke dasbor akun.
        </p>
    </div>

    <x-auth-session-status class="mt-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-2 block w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="mt-2 block w-full"
                type="password"
                name="password"
                required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between gap-4">
            <label for="remember_me" class="inline-flex items-center gap-3">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-brand-600 shadow-sm focus:ring-brand-500" name="remember">
                <span class="text-sm text-slate-600">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-brand-700 transition hover:text-brand-600" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <div class="space-y-4">
            <x-primary-button class="w-full justify-center">
                {{ __('Log in') }}
            </x-primary-button>

            <p class="text-center text-sm text-slate-500">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-semibold text-brand-700 transition hover:text-brand-600">
                    Daftar sekarang
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
