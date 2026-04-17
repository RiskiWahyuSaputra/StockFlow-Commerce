<x-guest-layout>
    <div>
        <p class="text-sm font-semibold uppercase tracking-[0.3em] text-slate-400">Register</p>
        <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-950">Buat akun customer baru</h2>
        <p class="mt-3 text-sm leading-7 text-slate-600">
            Akun yang dibuat dari halaman ini otomatis menjadi `customer` dan akan diarahkan ke dashboard customer setelah login.
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-5">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="mt-2 block w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" class="mt-2 block w-full" type="text" name="phone" :value="old('phone')" autocomplete="tel" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-2 block w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="mt-2 block w-full"
                type="password"
                name="password"
                required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="mt-2 block w-full"
                type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="space-y-4">
            <x-primary-button class="w-full justify-center">
                {{ __('Register') }}
            </x-primary-button>

            <p class="text-center text-sm text-slate-500">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-semibold text-brand-700 transition hover:text-brand-600">
                    Login di sini
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
