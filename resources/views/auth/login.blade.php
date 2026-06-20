<x-guest-layout>
    <div class="mb-6 text-center">
        <p class="text-xs font-semibold uppercase tracking-wide text-emerald-700">Akun Anda</p>
        <h1 class="mt-2 text-2xl font-bold tracking-tight text-slate-900">Masuk ke toko</h1>
        <p class="mt-2 text-sm text-slate-600">Silakan isi email dan kata sandi untuk melanjutkan.</p>
    </div>

    <x-auth-session-status class="mb-4 text-sm text-emerald-700" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" value="Kata sandi" />
            <x-text-input id="password" class="mt-1 block w-full" type="password" name="password" required
                autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between gap-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-emerald-300 text-emerald-600 shadow-sm focus:ring-emerald-500"
                    name="remember">
                <span class="ms-2 text-sm text-slate-600">Ingat saya</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-emerald-700 underline decoration-emerald-200 underline-offset-2 transition hover:text-emerald-800"
                    href="{{ route('password.request') }}">
                    Lupa kata sandi?
                </a>
            @endif
        </div>

        <div class="flex flex-col-reverse gap-3 pt-2 sm:flex-row sm:justify-end">
            <a href="{{ route('register') }}"
                class="inline-flex items-center justify-center rounded-xl border border-emerald-200 bg-white px-4 py-2.5 text-sm font-semibold text-emerald-800 transition hover:border-emerald-300 hover:bg-emerald-50 sm:min-w-[8rem]">
                Buat akun
            </a>
            <x-primary-button class="w-full justify-center sm:w-auto sm:min-w-[8rem]">
                Masuk
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
