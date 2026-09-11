<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Status Pesanan - {{ $transaction->uuid }}</title>
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

            @if (session('success'))
                <div class="mb-5 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Thank You Card --}}
            <div class="bg-white rounded-xl border border-slate-100 p-5 sm:p-6 mb-5 text-center">
                <div class="text-5xl mb-4">🎉</div>
                <h1 class="text-2xl font-bold text-slate-900 mb-2">Terima Kasih!</h1>
                <p class="text-slate-500 text-sm">Pesanan Anda berhasil dikirim. Silakan tunggu validasi dari fotografer.</p>
            </div>

            {{-- Order Status --}}
            <div class="bg-white rounded-xl border border-slate-100 p-5 sm:p-6 mb-5">
                <h2 class="text-lg font-semibold text-slate-900 mb-4">Status Pesanan</h2>
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm text-slate-500">Status</span>
                    @if ($transaction->status === 'pending')
                        <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-lg bg-amber-50 text-amber-700 border border-amber-200">
                            ⏳ Menunggu Validasi
                        </span>
                    @elseif ($transaction->status === 'valid')
                        <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200">
                            ✅ Pembayaran Divalidasi
                        </span>
                    @else
                        <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-lg bg-red-50 text-red-700 border border-red-200">
                            ❌ Pembayaran Ditolak
                        </span>
                    @endif
                </div>
                <div class="border-t border-slate-100 pt-4 space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-slate-500">Nomor Pesanan</span>
                        <span class="text-sm font-mono text-slate-900">{{ $transaction->uuid }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-slate-500">Produk</span>
                        <span class="text-sm font-medium text-slate-900">{{ $transaction->product->name ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-slate-500">Harga</span>
                        <span class="text-sm font-bold text-orange-600">Rp {{ number_format($transaction->product->price ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-slate-500">Tanggal</span>
                        <span class="text-sm text-slate-900">{{ $transaction->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>

            {{-- Info --}}
            <div class="bg-orange-50 rounded-xl border border-orange-100 p-5 sm:p-6">
                <div class="flex items-start gap-3">
                    <span class="text-xl">💡</span>
                    <div>
                        <h3 class="text-sm font-semibold text-orange-900">Tips</h3>
                        <p class="text-sm text-orange-700 mt-1">Simpan halaman ini atau catat nomor pesanan Anda. Anda dapat memeriksa status pesanan kapan saja dengan merefresh halaman ini.</p>
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
