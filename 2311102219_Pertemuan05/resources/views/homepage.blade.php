@extends('app')

@section('page-title')
    Cokomi Store
@endsection

@section('content')
<div class="min-h-screen bg-gradient-to-b from-blue-50 via-white to-blue-100">

    <!-- Header -->
    <header class="border-b border-blue-100 bg-white/90 backdrop-blur-sm shadow-sm">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
            <a href="{{ url('/') }}" class="text-2xl font-bold text-blue-700">
                Cokomi Store
            </a>

            <nav class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="rounded-lg bg-blue-600 px-5 py-2 text-white font-medium hover:bg-blue-700 transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="rounded-lg px-4 py-2 text-blue-700 hover:bg-blue-50 transition">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                        class="rounded-lg bg-blue-600 px-5 py-2 text-white font-medium hover:bg-blue-700 transition">
                        Register
                    </a>
                @endauth
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="mx-auto max-w-6xl px-6 py-24">
        <div class="text-center">

            <span class="rounded-full bg-blue-100 px-4 py-2 text-sm font-semibold text-blue-700">
                Platform Belanja Online Modern
            </span>

            <h1 class="mt-8 text-5xl font-extrabold text-slate-900 leading-tight">
                Temukan Produk Terbaik
                <span class="text-blue-600">Untuk Kebutuhan Anda</span>
            </h1>

            <p class="mx-auto mt-6 max-w-3xl text-lg text-slate-600">
                Selamat datang di Cokomi Store. Kami menyediakan berbagai produk
                berkualitas dengan harga terbaik, proses pemesanan yang mudah,
                serta pengalaman berbelanja yang cepat, aman, dan nyaman.
            </p>

            <div class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">

                @guest
                    <a href="{{ route('register') }}"
                        class="rounded-xl bg-blue-600 px-8 py-4 text-white font-semibold shadow-lg hover:bg-blue-700 transition">
                        Mulai Belanja
                    </a>

                    <a href="{{ route('login') }}"
                        class="rounded-xl border border-blue-200 bg-white px-8 py-4 text-blue-700 font-semibold hover:bg-blue-50 transition">
                        Sudah Punya Akun?
                    </a>
                @else
                    <a href="{{ route('dashboard') }}"
                        class="rounded-xl bg-blue-600 px-8 py-4 text-white font-semibold shadow-lg hover:bg-blue-700 transition">
                        Buka Dashboard
                    </a>
                @endguest

            </div>
        </div>

        <!-- Features -->
        <div class="mt-24 grid gap-8 md:grid-cols-3">

            <div class="rounded-2xl bg-white p-8 shadow-lg border border-blue-100">
                <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100">
                    📦
                </div>

                <h3 class="text-xl font-bold text-slate-900">
                    Produk Berkualitas
                </h3>

                <p class="mt-3 text-slate-600">
                    Berbagai pilihan produk terbaik dengan kualitas terjamin
                    untuk memenuhi kebutuhan sehari-hari Anda.
                </p>
            </div>

            <div class="rounded-2xl bg-white p-8 shadow-lg border border-blue-100">
                <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100">
                    🔒
                </div>

                <h3 class="text-xl font-bold text-slate-900">
                    Transaksi Aman
                </h3>

                <p class="mt-3 text-slate-600">
                    Sistem keamanan modern membantu menjaga data pengguna
                    dan aktivitas transaksi tetap terlindungi.
                </p>
            </div>

            <div class="rounded-2xl bg-white p-8 shadow-lg border border-blue-100">
                <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100">
                    🚚
                </div>

                <h3 class="text-xl font-bold text-slate-900">
                    Pelayanan Cepat
                </h3>

                <p class="mt-3 text-slate-600">
                    Kelola pesanan dengan mudah melalui dashboard dan nikmati
                    pengalaman belanja yang lebih efisien.
                </p>
            </div>

        </div>

        <!-- Stats -->
        <div class="mt-24 rounded-3xl bg-blue-600 p-10 text-white shadow-xl">
            <div class="grid gap-8 text-center md:grid-cols-3">

                <div>
                    <h2 class="text-4xl font-bold">100+</h2>
                    <p class="mt-2 text-blue-100">Produk Tersedia</p>
                </div>

                <div>
                    <h2 class="text-4xl font-bold">500+</h2>
                    <p class="mt-2 text-blue-100">Pelanggan Puas</p>
                </div>

                <div>
                    <h2 class="text-4xl font-bold">24/7</h2>
                    <p class="mt-2 text-blue-100">Layanan Online</p>
                </div>

            </div>
        </div>

    </section>

    <!-- Footer -->
    <footer class="border-t border-blue-100 bg-white py-8">
        <div class="text-center text-slate-500">
            © {{ date('Y') }} Cokomi Store - Belanja Mudah, Cepat, dan Aman.
        </div>
    </footer>

</div>
@endsection

