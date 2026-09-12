<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Status Pesanan — {{ config('app.name', 'Sellflow') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-100 min-h-screen">

    {{-- Top bar --}}
    <div class="bg-white border-b border-slate-200 sticky top-0 z-10">
        <div class="max-w-lg mx-auto px-4 py-3 flex items-center gap-3">
            <a href="/" class="flex items-center gap-2 flex-shrink-0">
                <div class="w-7 h-7 bg-orange-500 rounded-lg flex items-center justify-center text-white font-bold text-xs">S</div>
                <span class="font-bold text-slate-900 text-sm">{{ config('app.name', 'Sellflow') }}</span>
            </a>
            <span class="text-slate-300">·</span>
            <span class="text-xs text-slate-400 truncate">Status Pesanan</span>
        </div>
    </div>

    <div class="max-w-lg mx-auto px-4 py-6 space-y-4">

        @if($transaction->status === 'pending')
            {{-- Pending state --}}
            <div class="bg-white rounded-2xl border border-amber-200 shadow-sm p-6 text-center">
                <div class="w-16 h-16 bg-amber-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-amber-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h1 class="text-xl font-bold text-slate-900 mb-1">Pesanan Diterima!</h1>
                <p class="text-sm text-slate-500 leading-relaxed">
                    Pesanan kamu sedang menunggu konfirmasi pembayaran. Halaman ini akan otomatis diperbarui.
                </p>
                <div class="mt-4 inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 border border-amber-200 rounded-full text-xs font-semibold text-amber-700">
                    <span class="w-1.5 h-1.5 bg-amber-400 rounded-full animate-pulse"></span>
                    Menunggu Konfirmasi
                </div>
            </div>

        @elseif($transaction->status === 'valid')
            {{-- Valid state --}}
            <div class="bg-white rounded-2xl border border-emerald-200 shadow-sm p-6 text-center">
                <div class="w-16 h-16 bg-emerald-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h1 class="text-xl font-bold text-slate-900 mb-1">Pembayaran Dikonfirmasi!</h1>
                <p class="text-sm text-slate-500 leading-relaxed">
                    Pesanan kamu telah diverifikasi. Terima kasih sudah melakukan pembelian.
                </p>
                <div class="mt-4 inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 border border-emerald-200 rounded-full text-xs font-semibold text-emerald-700">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                    </svg>
                    Pembayaran Valid
                </div>
            </div>

        @else
            {{-- Rejected state --}}
            <div class="bg-white rounded-2xl border border-red-200 shadow-sm p-6 text-center">
                <div class="w-16 h-16 bg-red-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                    </svg>
                </div>
                <h1 class="text-xl font-bold text-slate-900 mb-1">Pembayaran Ditolak</h1>
                <p class="text-sm text-slate-500 leading-relaxed">
                    Maaf, pembayaran kamu tidak dapat dikonfirmasi. Silakan hubungi penjual untuk informasi lebih lanjut.
                </p>
                <div class="mt-4 inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 border border-red-200 rounded-full text-xs font-semibold text-red-700">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Ditolak
                </div>
            </div>
        @endif

        {{-- Order Detail Card --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100">
                <h2 class="text-sm font-semibold text-slate-900">Detail Pesanan</h2>
            </div>
            <div class="px-5 py-4 space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500">Nomor Pesanan</span>
                    <span class="font-mono text-xs text-slate-700 text-right break-all max-w-[180px]">{{ $transaction->uuid }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500">Produk</span>
                    <span class="font-semibold text-slate-900 text-right">{{ $transaction->product->name ?? '-' }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500">Harga</span>
                    <span class="font-bold text-orange-600">Rp {{ number_format($transaction->product->price ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500">Nama</span>
                    <span class="text-slate-700">{{ $transaction->customer_name }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500">Tanggal</span>
                    <span class="text-slate-700">{{ $transaction->created_at->format('d M Y, H:i') }}</span>
                </div>
            </div>
        </div>

        {{-- Tracking link + copy --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100">
                <h2 class="text-sm font-semibold text-slate-900">Link Tracking Pesanan</h2>
                <p class="text-xs text-slate-400 mt-0.5">Simpan link ini untuk cek status pesanan kapan saja.</p>
            </div>
            <div class="px-5 py-4">
                <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 mb-3">
                    <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244"/>
                    </svg>
                    <span class="text-xs font-mono text-slate-600 flex-1 truncate" id="trackingUrl">{{ route('order.status', $transaction->uuid) }}</span>
                </div>
                <div class="flex gap-2">
                    <button onclick="copyTracking()"
                            class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2.5
                                   bg-orange-500 hover:bg-orange-600 active:bg-orange-700
                                   text-white text-xs font-semibold rounded-xl transition-colors shadow-sm shadow-orange-500/20
                                   focus:outline-none focus:ring-2 focus:ring-orange-500/40">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75"/>
                        </svg>
                        Salin Link
                    </button>
                    <a href="whatsapp://send?text={{ urlencode('Cek status pesanan saya: ' . route('order.status', $transaction->uuid)) }}"
                       class="inline-flex items-center justify-center gap-1.5 px-3 py-2.5
                              bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition-colors
                              focus:outline-none focus:ring-2 focus:ring-slate-400/40">
                        <svg class="w-3.5 h-3.5 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.197 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.876 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/><path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.477 2 12c0 1.89.524 3.655 1.437 5.163L2.01 22l4.962-1.407A9.96 9.96 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2zm0 18a7.96 7.96 0 01-4.073-1.115l-.292-.174-3.024.857.816-2.984-.19-.307A7.96 7.96 0 014 12c0-4.418 3.582-8 8-8s8 3.582 8 8-3.582 8-8 8z"/>
                        </svg>
                        Share
                    </a>
                </div>
            </div>
        </div>

        {{-- Tips --}}
        <div class="flex items-start gap-3 p-4 bg-blue-50 border border-blue-100 rounded-2xl text-sm">
            <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
            </svg>
            <p class="text-blue-700 text-xs leading-relaxed">
                <span class="font-semibold">Simpan link di atas</span> untuk memantau status pesanan kamu kapan saja.
                Halaman ini otomatis diperbarui setiap 30 detik.
            </p>
        </div>

        <p class="text-center text-xs text-slate-400 pb-4">
            Powered by <span class="font-semibold text-orange-500">{{ config('app.name', 'Sellflow') }}</span>
        </p>
    </div>

    <script>
    function copyTracking() {
        const url = document.getElementById('trackingUrl').textContent.trim();
        navigator.clipboard.writeText(url).then(() => showToast('Link berhasil disalin!')).catch(() => {
            const el = document.createElement('textarea');
            el.value = url;
            document.body.appendChild(el);
            el.select();
            document.execCommand('copy');
            document.body.removeChild(el);
            showToast('Link berhasil disalin!');
        });
    }

    function showToast(msg) {
        const t = document.createElement('div');
        t.textContent = msg;
        t.className = 'fixed bottom-6 left-1/2 -translate-x-1/2 bg-slate-900 text-white text-xs font-medium px-4 py-2.5 rounded-xl shadow-lg z-50 opacity-0 transition-opacity duration-200';
        document.body.appendChild(t);
        requestAnimationFrame(() => t.style.opacity = '1');
        setTimeout(() => { t.style.opacity = '0'; setTimeout(() => t.remove(), 200); }, 2500);
    }

    // Auto-refresh every 30 seconds only when pending
    @if($transaction->status === 'pending')
    setTimeout(() => location.reload(), 30000);
    @endif
    </script>
</body>
</html>
