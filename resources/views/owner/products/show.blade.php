<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Produk') }}
            </h2>
            <a href="{{ route('owner.products.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">← Kembali ke Daftar Produk</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Product Details --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Produk</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nama Produk</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $product->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Kategori</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $product->category->name ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Harga</dt>
                            <dd class="mt-1 text-sm text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Deskripsi</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $product->description ?? '-' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            {{-- QR Code --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">QR Code Checkout</h3>
                    <p class="text-sm text-gray-500 mb-4">Scan QR Code ini untuk menuju halaman checkout produk ini. Cetak QR Code ini pada banner atau stand Anda.</p>
                    
                    <div class="flex flex-col items-center gap-4">
                        <div class="border-2 border-gray-200 rounded-lg p-4 bg-white">
                            {!! $qrCode !!}
                        </div>
                        <div class="text-center">
                            <p class="text-sm text-gray-500 mb-2">Atau copy link berikut:</p>
                            <div class="flex items-center gap-2 bg-gray-100 rounded-lg px-4 py-2">
                                <input type="text" value="{{ $checkoutUrl }}" readonly id="checkout-url" class="bg-transparent text-sm text-gray-700 flex-1 outline-none">
                                <button onclick="navigator.clipboard.writeText(document.getElementById('checkout-url').value); this.textContent='Tersalin!'; setTimeout(() => this.textContent='Copy', 2000)" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Copy</button>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <a href="{{ route('owner.products.edit', $product) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">Edit Produk</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
