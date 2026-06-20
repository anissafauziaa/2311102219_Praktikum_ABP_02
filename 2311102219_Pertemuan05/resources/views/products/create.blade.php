<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Tambah produk
            </h2>
            <a href="{{ route('dashboard') }}" class="text-sm font-medium text-emerald-700 hover:text-emerald-800">
                &larr; Kembali ke dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white p-6 shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('products.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="name" value="Nama produk" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required
                            autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="stock" value="Stok" />
                        <x-text-input id="stock" name="stock" type="number" min="0" class="mt-1 block w-full"
                            :value="old('stock')" required />
                        <x-input-error class="mt-2" :messages="$errors->get('stock')" />
                    </div>

                    <div>
                        <x-input-label for="price" value="Harga (Rp)" />
                        <x-text-input id="price" name="price" type="number" min="0" class="mt-1 block w-full"
                            :value="old('price')" required />
                        <x-input-error class="mt-2" :messages="$errors->get('price')" />
                    </div>

                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold text-gray-700 shadow-sm hover:bg-gray-50">
                            Batal
                        </a>
                        <x-primary-button>
                            Simpan
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
