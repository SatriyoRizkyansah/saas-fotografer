<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-slate-900">{{ __('Detail Produk') }}</h2>
            <a href="{{ route('owner.products.index') }}" class="text-sm text-slate-500 hover:text-slate-700 font-medium transition">← Kembali ke Daftar Produk</a>
        </div>
    </x-slot>

    <div class="p-4 sm:p-6 lg:p-8">
        <div class="max-w-5xl mx-auto space-y-6">
            {{-- Product Details --}}
            <div class="bg-white rounded-xl border border-slate-100 p-5 sm:p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Informasi Produk</h3>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Nama Produk</dt>
                        <dd class="mt-1 text-sm text-slate-900 font-medium">{{ $product->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Kategori</dt>
                        <dd class="mt-1 text-sm text-slate-900">{{ $product->category->name ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Harga</dt>
                        <dd class="mt-1 text-sm text-slate-900 font-semibold">Rp {{ number_format($product->price, 0, ',', '.') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Deskripsi</dt>
                        <dd class="mt-1 text-sm text-slate-900">{{ $product->description ?? '-' }}</dd>
                    </div>
                </dl>
            </div>

            {{-- QR Code --}}
            <div class="bg-white rounded-xl border border-slate-100 p-5 sm:p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">QR Code Checkout</h3>
                <p class="text-sm text-slate-500 mb-4">Scan QR Code ini untuk menuju halaman checkout produk ini. Cetak QR Code ini pada banner atau stand Anda.</p>
                
                <div class="flex flex-col items-center gap-4">
                    <div class="border-2 border-slate-200 rounded-xl p-5 bg-white">
                        {!! $qrCode !!}
                    </div>
                    <div class="w-full max-w-md text-center">
                        <p class="text-sm text-slate-400 mb-2">Atau copy link berikut:</p>
                        <div class="flex items-center gap-2 bg-slate-50 rounded-lg px-4 py-2.5 border border-slate-100">
                            <input type="text" value="{{ $checkoutUrl }}" readonly id="checkout-url" class="bg-transparent text-sm text-slate-600 flex-1 outline-none font-mono">
                            <button onclick="navigator.clipboard.writeText(document.getElementById('checkout-url').value); this.textContent='Tersalin!'; setTimeout(() => this.textContent='Copy', 2000)" class="text-orange-600 hover:text-orange-800 text-sm font-semibold transition">Copy</button>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('owner.products.edit', $product) }}" class="px-5 py-2.5 bg-gradient-to-r from-orange-500 to-orange-600 text-white text-sm font-semibold rounded-lg hover:shadow-lg hover:shadow-orange-500/25 transition-all duration-200">Edit Produk</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
