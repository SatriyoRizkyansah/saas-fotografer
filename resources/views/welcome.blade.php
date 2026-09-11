<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SnapPhoto') }} — Jual Foto Mudah & Cepat</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700;800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white text-slate-800">

    {{-- Navigation --}}
    <nav class="fixed top-0 inset-x-0 z-50 bg-white/80 backdrop-blur-xl border-b border-slate-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-gradient-to-br from-violet-500 to-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-xs">S</div>
                    <span class="font-bold text-slate-900 text-lg">SnapPhoto</span>
                </div>
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('owner.dashboard') }}" class="px-4 py-2 bg-slate-900 text-white text-sm font-medium rounded-lg hover:bg-slate-800 transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-slate-600 text-sm font-medium hover:text-slate-900 transition">Masuk</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-slate-900 text-white text-sm font-medium rounded-lg hover:bg-slate-800 transition">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Hero --}}
    <section class="pt-32 pb-20 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto text-center">
        <div class="inline-flex items-center gap-2 px-3 py-1 bg-violet-50 border border-violet-100 rounded-full text-violet-700 text-xs font-medium mb-6">
            <span class="w-1.5 h-1.5 bg-violet-500 rounded-full animate-pulse"></span>
            Untuk Fotografer Profesional
        </div>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 leading-tight tracking-tight">
            Jual Foto <span class="bg-gradient-to-r from-violet-600 to-indigo-600 bg-clip-text text-transparent">Cepat & Mudah</span>
            <br class="hidden sm:block"> di Lokasi Acara
        </h1>
        <p class="mt-6 text-lg text-slate-500 max-w-2xl mx-auto leading-relaxed">
            Cetak QR Code pada banner, customer scan &amp; upload bukti transfer. Tanpa ribet, tanpa login. Transaksi langsung jalan.
        </p>
        <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
            @auth
                <a href="{{ route('owner.dashboard') }}" class="w-full sm:w-auto px-8 py-3.5 bg-gradient-to-r from-violet-600 to-indigo-600 text-white font-semibold rounded-xl hover:shadow-lg hover:shadow-violet-500/25 transition-all duration-200">
                    Buka Dashboard →
                </a>
            @else
                <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-3.5 bg-gradient-to-r from-violet-600 to-indigo-600 text-white font-semibold rounded-xl hover:shadow-lg hover:shadow-violet-500/25 transition-all duration-200">
                    Mulai Gratis →
                </a>
                <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-3.5 bg-white border border-slate-200 text-slate-700 font-semibold rounded-xl hover:bg-slate-50 transition">
                    Sudah Punya Akun?
                </a>
            @endauth
        </div>
    </section>

    {{-- How It Works --}}
    <section class="py-20 bg-slate-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14">
                <h2 class="text-3xl font-bold text-slate-900">Cara Kerjanya</h2>
                <p class="mt-3 text-slate-500">Tiga langkah sederhana untuk mulai berjualan</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="relative bg-white rounded-2xl p-8 border border-slate-100 hover:border-violet-200 hover:shadow-lg hover:shadow-violet-500/5 transition-all duration-300">
                    <div class="w-12 h-12 bg-gradient-to-br from-violet-500 to-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-lg mb-5">1</div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-2">Buat Produk</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Tambahkan produk foto dengan harga, lalu generate QR Code untuk masing-masing produk.</p>
                </div>
                <div class="relative bg-white rounded-2xl p-8 border border-slate-100 hover:border-violet-200 hover:shadow-lg hover:shadow-violet-500/5 transition-all duration-300">
                    <div class="w-12 h-12 bg-gradient-to-br from-violet-500 to-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-lg mb-5">2</div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-2">Cetak QR di Banner</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Tempel QR Code pada banner atau stand di lokasi acara. Customer tinggal scan.</p>
                </div>
                <div class="relative bg-white rounded-2xl p-8 border border-slate-100 hover:border-violet-200 hover:shadow-lg hover:shadow-violet-500/5 transition-all duration-300">
                    <div class="w-12 h-12 bg-gradient-to-br from-violet-500 to-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-lg mb-5">3</div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-2">Validasi &amp; Selesai</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Customer upload bukti transfer, Anda tinggal cek dan validasi. Done!</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Features --}}
    <section class="py-20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14">
                <h2 class="text-3xl font-bold text-slate-900">Fitur Utama</h2>
                <p class="mt-3 text-slate-500">Semua yang Anda butuhkan untuk berjualan foto</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="flex items-start gap-4 p-6 rounded-xl hover:bg-slate-50 transition">
                    <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5z" /></svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-slate-900">QR Code Otomatis</h3>
                        <p class="text-sm text-slate-500 mt-1">Generate QR Code unik untuk setiap produk secara otomatis.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4 p-6 rounded-xl hover:bg-slate-50 transition">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-slate-900">Tanpa Login</h3>
                        <p class="text-sm text-slate-500 mt-1">Customer langsung checkout tanpa perlu buat akun.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4 p-6 rounded-xl hover:bg-slate-50 transition">
                    <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-slate-900">Tracking Real-time</h3>
                        <p class="text-sm text-slate-500 mt-1">Customer bisa cek status pesanan langsung dari HP.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4 p-6 rounded-xl hover:bg-slate-50 transition">
                    <div class="w-10 h-10 bg-rose-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-rose-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 001.5-1.5V5.25a1.5 1.5 0 00-1.5-1.5H3.75a1.5 1.5 0 00-1.5 1.5v14.25a1.5 1.5 0 001.5 1.5z" /></svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-slate-900">Bukti Transfer</h3>
                        <p class="text-sm text-slate-500 mt-1">Customer upload bukti transfer langsung dari form.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4 p-6 rounded-xl hover:bg-slate-50 transition">
                    <div class="w-10 h-10 bg-violet-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-violet-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-slate-900">Validasi Mudah</h3>
                        <p class="text-sm text-slate-500 mt-1">Cek bukti transfer dan validasi dengan sekali klik.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4 p-6 rounded-xl hover:bg-slate-50 transition">
                    <div class="w-10 h-10 bg-cyan-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-cyan-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" /></svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-slate-900">Dashboard Lengkap</h3>
                        <p class="text-sm text-slate-500 mt-1">Lihat ringkasan penjualan dan kelola semua dari satu tempat.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="border-t border-slate-100 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="flex items-center justify-center gap-2 mb-3">
                <div class="w-6 h-6 bg-gradient-to-br from-violet-500 to-indigo-600 rounded-md flex items-center justify-center text-white font-bold text-[8px]">S</div>
                <span class="font-semibold text-slate-900">SnapPhoto</span>
            </div>
            <p class="text-sm text-slate-400">&copy; {{ date('Y') }} SnapPhoto. Dibuat untuk fotografer Indonesia.</p>
        </div>
    </footer>

</body>
</html>
