<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout - {{ $product->name }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>
                <p class="text-gray-500 mt-2">{{ $product->description }}</p>
            </div>

            {{-- Product Card --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-sm text-gray-500">Kategori</span>
                        <span class="text-sm font-medium text-gray-900">{{ $product->category->name ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center border-t pt-4">
                        <span class="text-lg font-semibold text-gray-900">Harga</span>
                        <span class="text-2xl font-bold text-blue-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- Payment Instructions --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">🏦 Informasi Pembayaran</h2>
                    <p class="text-sm text-gray-500 mb-3">Silakan transfer ke rekening berikut:</p>
                    <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Bank</span>
                            <span class="text-sm font-medium text-gray-900">{{ $product->owner->bank_name ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">No. Rekening</span>
                            <span class="text-sm font-medium text-gray-900">{{ $product->owner->bank_account_number ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Atas Nama</span>
                            <span class="text-sm font-medium text-gray-900">{{ $product->owner->bank_account_name ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between border-t pt-2">
                            <span class="text-sm font-semibold text-gray-700">Total Bayar</span>
                            <span class="text-sm font-bold text-blue-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Checkout Form --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">📋 Formulir Checkout</h2>
                    
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-700 rounded-lg">
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
                                <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required autofocus
                                    class="block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                            </div>

                            <div>
                                <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                                <input type="email" id="customer_email" name="customer_email" value="{{ old('customer_email') }}" required
                                    class="block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                            </div>

                            <div>
                                <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp <span class="text-red-500">*</span></label>
                                <input type="text" id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}" placeholder="08xxxxxxxxxx" required
                                    class="block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                            </div>

                            <div>
                                <label for="payment_proof" class="block text-sm font-medium text-gray-700 mb-1">Bukti Transfer <span class="text-red-500">*</span></label>
                                <input type="file" id="payment_proof" name="payment_proof" accept="image/jpg,image/jpeg,image/png" required
                                    class="block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm text-sm">
                                <p class="mt-1 text-xs text-gray-500">Format: JPG, JPEG, PNG. Maks 2MB.</p>
                            </div>

                            <div>
                                <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Kirim Pesanan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
