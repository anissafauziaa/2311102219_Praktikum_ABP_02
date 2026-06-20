<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        @php
            $onLogin = request()->routeIs('login');
            $onRegister = request()->routeIs('register');
        @endphp

        <div class="flex min-h-screen flex-col bg-gradient-to-b from-emerald-50 via-white to-slate-50">
            <header class="border-b border-emerald-100/80 bg-white/70 backdrop-blur-sm">
                <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
                    <a href="{{ url('/') }}" class="text-lg font-semibold tracking-tight text-emerald-900">
                        Toko Pak Cokomi
                    </a>
                    <nav class="flex items-center gap-2 text-sm font-medium sm:gap-3">
                        @auth
                            <a href="{{ route('dashboard') }}"
                                class="rounded-lg bg-emerald-600 px-4 py-2 text-white shadow-sm transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                @class([
                                    'rounded-lg px-3 py-2 transition focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2',
                                    'bg-emerald-50 font-semibold text-emerald-900' => $onLogin,
                                    'text-emerald-800 hover:bg-emerald-50' => ! $onLogin,
                                ])>
                                Masuk
                            </a>
                            <a href="{{ route('register') }}"
                                @class([
                                    'rounded-lg px-4 py-2 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2',
                                    'bg-emerald-700 text-white ring-2 ring-emerald-400 ring-offset-2 ring-offset-white' => $onRegister,
                                    'bg-emerald-600 text-white hover:bg-emerald-700' => ! $onRegister,
                                ])>
                                Daftar
                            </a>
                        @endauth
                    </nav>
                </div>
            </header>

            <main class="flex flex-1 flex-col items-center justify-center px-4 py-10 sm:px-6 sm:py-14 lg:px-8">
                <div class="w-full max-w-md rounded-2xl border border-emerald-100 bg-white p-8 shadow-sm">
                    {{ $slot }}
                </div>
            </main>

            <footer class="border-t border-emerald-100 bg-white/80 py-8 text-center text-sm text-slate-500">
                <p>&copy; {{ date('Y') }} Toko Pak Cokomi. All Rights Reserved.</p>
            </footer>
        </div>
    </body>
</html>
