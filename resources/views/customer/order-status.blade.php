<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Status Pesanan - {{ $transaction->uuid }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Thank You Card --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-center">
                    <div class="text-6xl mb-4">🎉</div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">Terima Kasih!</h1>
                    <p class="text-gray-500">Pesanan Anda berhasil dikirim. Silakan tunggu validasi dari fotografer.</p>
                </div>
            </div>

            {{-- Order Status --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Status Pesanan</h2>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm text-gray-500">Status</span>
                        @if ($transaction->status === 'pending')
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                ⏳ Menunggu Validasi
                            </span>
                        @elseif ($transaction->status === 'valid')
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                ✅ Pembayaran Divalidasi
                            </span>
                        @else
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                ❌ Pembayaran Ditolak
                            </span>
                        @endif
                    </div>
                    <div class="border-t pt-4 space-y-2">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Nomor Pesanan</span>
                            <span class="text-sm font-mono text-gray-900">{{ $transaction->uuid }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Produk</span>
                            <span class="text-sm font-medium text-gray-900">{{ $transaction->product->name ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Harga</span>
                            <span class="text-sm font-bold text-blue-600">Rp {{ number_format($transaction->product->price ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Tanggal</span>
                            <span class="text-sm text-gray-900">{{ $transaction->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Info --}}
            <div class="bg-blue-50 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-start gap-3">
                        <span class="text-xl">💡</span>
                        <div>
                            <h3 class="text-sm font-semibold text-blue-900">Tips</h3>
                            <p class="text-sm text-blue-700 mt-1">Simpan halaman ini atau catat nomor pesanan Anda. Anda dapat memeriksa status pesanan kapan saja dengan merefresh halaman ini.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-refresh every 30 seconds
        setTimeout(function() {
            location.reload();
        }, 30000);
    </script>
</body>
</html>
