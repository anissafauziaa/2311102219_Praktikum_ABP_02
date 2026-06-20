@php
    use App\Models\Order;

    $orderStatusClasses = [
        Order::STATUS_PENDING => 'bg-amber-100 text-amber-800 ring-1 ring-amber-200',
        Order::STATUS_PROCESSING => 'bg-sky-100 text-sky-800 ring-1 ring-sky-200',
        Order::STATUS_SHIPPED => 'bg-violet-100 text-violet-800 ring-1 ring-violet-200',
        Order::STATUS_COMPLETED => 'bg-emerald-100 text-emerald-800 ring-1 ring-emerald-200',
        Order::STATUS_CANCELLED => 'bg-gray-100 text-gray-700 ring-1 ring-gray-200',
    ];

    $orderStatusLabels = [
        Order::STATUS_PENDING => 'Menunggu konfirmasi',
        Order::STATUS_PROCESSING => 'Diproses',
        Order::STATUS_SHIPPED => 'Dikirim',
        Order::STATUS_COMPLETED => 'Selesai',
        Order::STATUS_CANCELLED => 'Dibatalkan',
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                    <ul class="list-inside list-disc space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (Auth::user()->isAdmin())
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="flex flex-col gap-4 border-b border-gray-100 p-6 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Produk</h3>
                            <p class="mt-1 text-sm text-gray-600">Kelola katalog toko: tambah, ubah, atau hapus produk.</p>
                        </div>
                        <a href="{{ route('products.create') }}"
                            class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                            Tambah produk
                        </a>
                    </div>

                    <div class="overflow-x-auto p-6 pt-0">
                        @if ($products->isEmpty())
                            <p class="py-8 text-center text-sm text-gray-500">Belum ada produk. Klik &ldquo;Tambah produk&rdquo; untuk memulai.</p>
                        @else
                            <table class="w-full divide-y divide-gray-200 text-left text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-4 py-3 text-left font-semibold text-gray-700">Nama</th>
                                        <th scope="col" class="px-4 py-3 text-left font-semibold text-gray-700">Stok</th>
                                        <th scope="col" class="px-4 py-3 text-left font-semibold text-gray-700">Harga</th>
                                        <th scope="col" class="px-4 py-3 text-right font-semibold text-gray-700">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach ($products as $product)
                                        <tr class="hover:bg-gray-50">
                                            <td class="whitespace-nowrap px-4 py-3 font-medium text-gray-900">
                                                {{ $product->name }}</td>
                                            <td class="whitespace-nowrap px-4 py-3 text-gray-700">{{ $product->stock }}</td>
                                            <td class="whitespace-nowrap px-4 py-3 text-gray-700">Rp
                                                {{ number_format($product->price, 0, ',', '.') }}</td>
                                            <td class="whitespace-nowrap px-4 py-3 text-right">
                                                <div class="flex flex-wrap items-center justify-end gap-2">
                                                    <a href="{{ route('products.edit', $product) }}"
                                                        class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-1">
                                                        Ubah
                                                    </a>
                                                    <form action="{{ route('products.destroy', $product) }}" method="post"
                                                        class="inline"
                                                        onsubmit="return confirm('Hapus produk ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="inline-flex items-center rounded-md border border-transparent bg-red-600 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>

                <div class="mt-10 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="border-b border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-900">Pesanan pelanggan</h3>
                        <p class="mt-1 text-sm text-gray-600">Perbarui status pengiriman atau batalkan (stok dikembalikan jika dibatalkan).</p>
                    </div>
                    <div class="overflow-x-auto p-6 pt-0">
                        @if ($allOrders->isEmpty())
                            <p class="py-8 text-center text-sm text-gray-500">Belum ada pesanan.</p>
                        @else
                            <table class="w-full min-w-[640px] divide-y divide-gray-200 text-left text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 font-semibold text-gray-700">ID</th>
                                        <th class="px-4 py-3 font-semibold text-gray-700">Pembeli</th>
                                        <th class="px-4 py-3 font-semibold text-gray-700">Item</th>
                                        <th class="px-4 py-3 font-semibold text-gray-700">Total</th>
                                        <th class="px-4 py-3 font-semibold text-gray-700">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach ($allOrders as $order)
                                        <tr class="align-top hover:bg-gray-50">
                                            <td class="px-4 py-3 font-mono text-xs text-gray-600">#{{ $order->id }}</td>
                                            <td class="px-4 py-3">
                                                <div class="font-medium text-gray-900">{{ $order->user->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $order->user->email }}</div>
                                                <div class="text-xs text-gray-400">{{ $order->created_at->format('d M Y, H:i') }}</div>
                                            </td>
                                            <td class="max-w-xs px-4 py-3 text-gray-700">
                                                <ul class="list-inside list-disc text-xs">
                                                    @foreach ($order->items as $item)
                                                        <li>{{ $item->product->name }} &times; {{ $item->quantity }}</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-3 font-medium text-gray-900">Rp
                                                {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                            <td class="px-4 py-3">
                                                <span
                                                    class="mb-2 inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $orderStatusClasses[$order->status] ?? 'bg-gray-100 text-gray-700' }}">
                                                    {{ $order->status_label }}
                                                </span>
                                                @if ($order->status === Order::STATUS_CANCELLED)
                                                    <p class="text-xs text-gray-500">Tidak dapat diubah</p>
                                                @else
                                                    <form method="POST" action="{{ route('orders.update-status', $order) }}"
                                                        class="mt-2 flex flex-col gap-2 sm:flex-row sm:items-center">
                                                        @csrf
                                                        @method('PATCH')
                                                        <select name="status"
                                                            class="block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:max-w-[11rem]">
                                                            @foreach (Order::STATUSES as $st)
                                                                <option value="{{ $st }}" @selected($order->status === $st)>
                                                                    {{ $orderStatusLabels[$st] ?? $st }}</option>
                                                            @endforeach
                                                        </select>
                                                        <x-primary-button class="shrink-0 justify-center py-2 text-xs">
                                                            Simpan
                                                        </x-primary-button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            @else
                <div class="mb-10">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Belanja</h3>
                        <p class="mt-1 text-sm text-gray-600">Atur jumlah per produk, lalu kirim pesanan sekaligus.</p>
                    </div>

                    @if ($products->isEmpty())
                        <div class="rounded-lg border border-dashed border-gray-300 bg-white p-10 text-center text-sm text-gray-500">
                            Belum ada produk di toko. Silakan cek lagi nanti.
                        </div>
                    @else
                        <form action="{{ route('orders.store') }}" method="POST" class="space-y-8">
                            @csrf
                            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                                @foreach ($products as $product)
                                    <div
                                        class="flex flex-col rounded-2xl border border-emerald-100 bg-white p-5 shadow-sm transition hover:border-emerald-200 hover:shadow-md">
                                        <div
                                            class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 text-lg font-bold text-white">
                                            {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($product->name, 0, 1)) }}
                                        </div>
                                        <h4 class="mt-4 text-base font-semibold text-gray-900">{{ $product->name }}</h4>
                                        <p class="mt-1 text-sm text-gray-500">Stok: <span
                                                class="font-medium text-gray-800">{{ $product->stock }}</span></p>
                                        <p class="mt-2 text-lg font-semibold text-emerald-700">Rp
                                            {{ number_format($product->price, 0, ',', '.') }}</p>
                                        <div class="mt-4 flex items-end justify-between gap-3 border-t border-gray-100 pt-4">
                                            <label class="block flex-1 text-xs font-medium text-gray-600" for="qty-{{ $product->id }}">
                                                Jumlah
                                            </label>
                                            <input id="qty-{{ $product->id }}" type="number" name="quantities[{{ $product->id }}]"
                                                value="{{ old('quantities.'.$product->id, 0) }}" min="0"
                                                max="{{ $product->stock }}"
                                                class="w-24 rounded-lg border-emerald-200 text-right text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                                @disabled($product->stock === 0)>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="flex justify-end">
                                <x-primary-button class="px-8 py-3 text-base">
                                    Buat pesanan
                                </x-primary-button>
                            </div>
                        </form>
                    @endif
                </div>

                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="border-b border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-900">Pesanan saya</h3>
                        <p class="mt-1 text-sm text-gray-600">Lacak status pesanan Anda.</p>
                    </div>
                    <div class="divide-y divide-gray-100 p-6">
                        @if ($orders->isEmpty())
                            <p class="py-6 text-center text-sm text-gray-500">Anda belum memiliki pesanan.</p>
                        @else
                            @foreach ($orders as $order)
                                <div class="py-6 first:pt-0 last:pb-0">
                                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                        <div>
                                            <div class="flex flex-wrap items-center gap-2">
                                                <span class="font-mono text-sm text-gray-500">#{{ $order->id }}</span>
                                                <span
                                                    class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $orderStatusClasses[$order->status] ?? 'bg-gray-100 text-gray-700' }}">
                                                    {{ $order->status_label }}
                                                </span>
                                            </div>
                                            <p class="mt-1 text-xs text-gray-400">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                            <ul class="mt-3 space-y-1 text-sm text-gray-700">
                                                @foreach ($order->items as $item)
                                                    <li>{{ $item->product->name }} &times; {{ $item->quantity }} <span
                                                            class="text-gray-400">(Rp
                                                            {{ number_format($item->lineTotal(), 0, ',', '.') }})</span></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="flex shrink-0 flex-col items-start gap-3 sm:items-end">
                                            <p class="text-base font-semibold text-gray-900">Total: Rp
                                                {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                            @if ($order->status === Order::STATUS_PENDING)
                                                <form action="{{ route('orders.cancel', $order) }}" method="POST"
                                                    onsubmit="return confirm('Batalkan pesanan ini? Stok akan dikembalikan.');">
                                                    @csrf
                                                    <button type="submit"
                                                        class="text-sm font-medium text-red-600 underline decoration-red-200 underline-offset-2 hover:text-red-700">
                                                        Batalkan pesanan
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
