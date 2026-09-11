<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout - {{ $product->name }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700;800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50">
    <div class="min-h-screen p-4 sm:p-6 lg:p-8">
        <div class="max-w-lg mx-auto">
            {{-- SnapPhoto Branding Header --}}
            <div class="text-center mb-8">
                <div class="inline-flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg flex items-center justify-center text-white font-bold text-xs">S</div>
                    <span class="font-bold text-slate-900 text-lg">SnapPhoto</span>
                </div>
            </div>

            {{-- Product Card --}}
            <div class="bg-white rounded-xl border border-slate-100 p-5 sm:p-6 mb-5">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-sm text-slate-500">Kategori</span>
                    <span class="text-sm font-medium text-slate-900">{{ $product->category->name ?? '-' }}</span>
                </div>
                <div class="flex justify-between items-center border-t border-slate-100 pt-4">
                    <span class="text-lg font-semibold text-slate-900">{{ $product->name }}</span>
                    <span class="text-2xl font-bold text-orange-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                </div>
                @if ($product->description)
                    <p class="mt-3 text-sm text-slate-500">{{ $product->description }}</p>
                @endif
            </div>

            {{-- Payment Instructions --}}
            <div class="bg-white rounded-xl border border-slate-100 p-5 sm:p-6 mb-5">
                <h2 class="text-lg font-semibold text-slate-900 mb-4">Informasi Pembayaran</h2>
                <p class="text-sm text-slate-500 mb-3">Silakan transfer ke rekening berikut:</p>
                <div class="bg-slate-50 rounded-lg p-4 space-y-2 border border-slate-100">
                    <div class="flex justify-between">
                        <span class="text-sm text-slate-500">Bank</span>
                        <span class="text-sm font-medium text-slate-900">{{ $product->owner->bank_name ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-slate-500">No. Rekening</span>
                        <span class="text-sm font-medium text-slate-900">{{ $product->owner->bank_account_number ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-slate-500">Atas Nama</span>
                        <span class="text-sm font-medium text-slate-900">{{ $product->owner->bank_account_name ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between border-t border-slate-200 pt-2">
                        <span class="text-sm font-semibold text-slate-700">Total Bayar</span>
                        <span class="text-sm font-bold text-orange-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- Checkout Form --}}
            <div class="bg-white rounded-xl border border-slate-100 p-5 sm:p-6">
                <h2 class="text-lg font-semibold text-slate-900 mb-4">Formulir Checkout</h2>
                
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('checkout.store', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="space-y-4">
                        <div>
                            <label for="customer_name" class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required autofocus
                                class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-lg text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-violet-500/20 focus:border-violet-500 transition">
                        </div>

                        <div>
                            <label for="customer_email" class="block text-sm font-medium text-slate-700 mb-1">Email <span class="text-red-500">*</span></label>
                            <input type="email" id="customer_email" name="customer_email" value="{{ old('customer_email') }}" required
                                class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-lg text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-violet-500/20 focus:border-violet-500 transition">
                        </div>

                        <div>
                            <label for="customer_phone" class="block text-sm font-medium text-slate-700 mb-1">Nomor WhatsApp <span class="text-red-500">*</span></label>
                            <input type="text" id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}" placeholder="08xxxxxxxxxx" required
                                class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-lg text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-violet-500/20 focus:border-violet-500 transition">
                        </div>

                        <div>
                            <label for="payment_proof" class="block text-sm font-medium text-slate-700 mb-1">Bukti Transfer <span class="text-red-500">*</span></label>
                            <input type="file" id="payment_proof" name="payment_proof" accept="image/jpg,image/jpeg,image/png" required
                                class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-lg text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
                            <p class="mt-1 text-xs text-slate-400">Format: JPG, JPEG, PNG. Maks 2MB.</p>
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="w-full px-5 py-3 bg-gradient-to-r from-orange-500 to-orange-600 text-white text-sm font-semibold rounded-lg hover:shadow-lg hover:shadow-orange-500/25 transition-all duration-200">
                                Kirim Pesanan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
