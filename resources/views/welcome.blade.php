<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SnapPhoto') }} — Platform Penjualan Digital</title>
    <meta name="description" content="Platform SaaS untuk menjual produk digital secara online. QR Code, checkout instan, tanpa ribet.">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700;800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .gradient-text { background: linear-gradient(135deg, #ea580c, #f97316, #fb923c); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .hero-glow { background: radial-gradient(ellipse 80% 50% at 50% -20%, rgba(249,115,22,0.10), transparent); }
        .feature-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .feature-card:hover { transform: translateY(-4px); box-shadow: 0 20px 40px -12px rgba(0,0,0,0.08); }
    </style>
</head>
<body class="font-sans antialiased bg-white text-slate-800">

    {{-- Navigation --}}
    <nav class="fixed top-0 inset-x-0 z-50 bg-white/80 backdrop-blur-xl border-b border-slate-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="/" class="flex items-center gap-2.5">
                    <div class="w-8 h-8 bg-orange-600 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" /><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z" /></svg>
                    </div>
                    <span class="font-bold text-slate-900 text-lg tracking-tight">SnapPhoto</span>
                </a>
                <div class="flex items-center gap-2 sm:gap-3">
                    @auth
                        <a href="{{ route('owner.dashboard') }}" class="px-4 py-2 bg-orange-600 text-white text-sm font-medium rounded-lg hover:bg-orange-700 transition shadow-sm">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-slate-600 text-sm font-medium hover:text-slate-900 transition">Masuk</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-orange-600 text-white text-sm font-medium rounded-lg hover:bg-orange-700 transition shadow-sm">Daftar Gratis</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Hero --}}
    <section class="relative pt-32 pb-16 sm:pt-40 sm:pb-24 overflow-hidden hero-glow">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-orange-50 border border-orange-100 rounded-full text-orange-700 text-xs font-medium mb-6">
                <span class="w-1.5 h-1.5 bg-orange-500 rounded-full animate-pulse"></span>
                Platform SaaS Modern
            </div>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 leading-[1.1] tracking-tight">
                Jual Produk Digital<br>
                <span class="gradient-text">Langsung dari Satu Platform</span>
            </h1>
            <p class="mt-6 text-lg sm:text-xl text-slate-500 max-w-2xl mx-auto leading-relaxed">
                Buat toko online Anda, kelola produk, dan terima pembayaran. Tanpa ribet, tanpa teknis. Semua terkelola dari satu dashboard.
            </p>
            <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-4">
                @auth
                    <a href="{{ route('owner.dashboard') }}" class="w-full sm:w-auto px-8 py-3.5 bg-orange-600 text-white font-semibold rounded-xl hover:bg-orange-700 shadow-lg shadow-orange-500/20 transition-all duration-200 text-center">
                        Buka Dashboard →
                    </a>
                @else
                    <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-3.5 bg-orange-600 text-white font-semibold rounded-xl hover:bg-orange-700 shadow-lg shadow-orange-500/20 transition-all duration-200 text-center">
                        Mulai Gratis →
                    </a>
                    <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-3.5 bg-white border border-slate-200 text-slate-700 font-semibold rounded-xl hover:bg-slate-50 transition text-center">
                        Sudah Punya Akun?
                    </a>
                @endauth
            </div>
            <p class="mt-5 text-sm text-slate-400">Gratis selamanya. Tanpa kartu kredit.</p>
        </div>
    </section>

    {{-- How It Works --}}
    <section class="py-16 sm:py-20 bg-slate-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 sm:mb-14">
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Cara Kerjanya</h2>
                <p class="mt-3 text-slate-500">Tiga langkah sederhana untuk mulai berjualan</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
                <div class="feature-card bg-white rounded-2xl p-7 border border-slate-100 text-center">
                    <div class="w-14 h-14 bg-orange-100 rounded-2xl flex items-center justify-center mx-auto mb-5">
                        <svg class="w-7 h-7 text-orange-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div class="text-xs font-bold text-orange-600 tracking-wider uppercase mb-2">Langkah 1</div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-2">Buat Toko</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Daftar gratis, lengkapi profil toko Anda, dan mulai unggah produk digital.</p>
                </div>
                <div class="feature-card bg-white rounded-2xl p-7 border border-slate-100 text-center">
                    <div class="w-14 h-14 bg-orange-100 rounded-2xl flex items-center justify-center mx-auto mb-5">
                        <svg class="w-7 h-7 text-orange-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5z" /></svg>
                    </div>
                    <div class="text-xs font-bold text-orange-600 tracking-wider uppercase mb-2">Langkah 2</div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-2">Bagikan Toko</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Bagikan link toko Anda ke customer. Mereka bisa browse dan beli kapan saja.</p>
                </div>
                <div class="feature-card bg-white rounded-2xl p-7 border border-slate-100 text-center">
                    <div class="w-14 h-14 bg-orange-100 rounded-2xl flex items-center justify-center mx-auto mb-5">
                        <svg class="w-7 h-7 text-orange-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div class="text-xs font-bold text-orange-600 tracking-wider uppercase mb-2">Langkah 3</div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-2">Terima Pembayaran</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Customer bayar, Anda terima notifikasi dan validasi pesanan. Selesai!</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Features --}}
    <section class="py-16 sm:py-20">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 sm:mb-14">
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Fitur Unggulan</h2>
                <p class="mt-3 text-slate-500">Semua yang Anda butuhkan dalam satu platform</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                <div class="flex items-start gap-4 p-5 rounded-xl border border-slate-100 hover:border-orange-200 hover:bg-orange-50/30 transition-all duration-200">
                    <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5z" /></svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-slate-900">QR Code Otomatis</h3>
                        <p class="text-sm text-slate-500 mt-1">Generate QR Code unik untuk setiap produk secara otomatis.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4 p-5 rounded-xl border border-slate-100 hover:border-orange-200 hover:bg-orange-50/30 transition-all duration-200">
                    <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-slate-900">Tanpa Login Customer</h3>
                        <p class="text-sm text-slate-500 mt-1">Customer langsung checkout tanpa perlu buat akun.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4 p-5 rounded-xl border border-slate-100 hover:border-orange-200 hover:bg-orange-50/30 transition-all duration-200">
                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-slate-900">Tracking Real-time</h3>
                        <p class="text-sm text-slate-500 mt-1">Customer bisa cek status pesanan langsung dari HP.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4 p-5 rounded-xl border border-slate-100 hover:border-orange-200 hover:bg-orange-50/30 transition-all duration-200">
                    <div class="w-10 h-10 bg-rose-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-rose-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 001.5-1.5V5.25a1.5 1.5 0 00-1.5-1.5H3.75a1.5 1.5 0 00-1.5 1.5v14.25a1.5 1.5 0 001.5 1.5z" /></svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-slate-900">Upload Bukti Transfer</h3>
                        <p class="text-sm text-slate-500 mt-1">Customer upload bukti transfer langsung dari form checkout.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4 p-5 rounded-xl border border-slate-100 hover:border-orange-200 hover:bg-orange-50/30 transition-all duration-200">
                    <div class="w-10 h-10 bg-violet-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-violet-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-slate-900">Validasi Mudah</h3>
                        <p class="text-sm text-slate-500 mt-1">Cek bukti transfer dan validasi transaksi dengan sekali klik.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4 p-5 rounded-xl border border-slate-100 hover:border-orange-200 hover:bg-orange-50/30 transition-all duration-200">
                    <div class="w-10 h-10 bg-cyan-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-cyan-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" /></svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-slate-900">Dashboard Lengkap</h3>
                        <p class="text-sm text-slate-500 mt-1">Kelola produk, transaksi, dan pembayaran dari satu tempat.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-16 sm:py-20 bg-slate-900">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl sm:text-3xl font-bold text-white">Siap Mulai Berjualan?</h2>
            <p class="mt-4 text-slate-400 text-lg">Daftar gratis sekarang dan mulai jual produk digital dalam hitungan menit.</p>
            <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
                @auth
                    <a href="{{ route('owner.dashboard') }}" class="w-full sm:w-auto px-8 py-3.5 bg-orange-600 text-white font-semibold rounded-xl hover:bg-orange-500 transition shadow-lg shadow-orange-600/20">
                        Buka Dashboard →
                    </a>
                @else
                    <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-3.5 bg-orange-600 text-white font-semibold rounded-xl hover:bg-orange-500 transition shadow-lg shadow-orange-600/20">
                        Daftar Gratis Sekarang →
                    </a>
                @endauth
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="border-t border-slate-100 py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 bg-orange-600 rounded-md flex items-center justify-center">
                    <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" /><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z" /></svg>
                </div>
                <span class="font-semibold text-slate-900 text-sm">SnapPhoto</span>
            </div>
            <p class="text-sm text-slate-400">&copy; {{ date('Y') }} SnapPhoto. Platform penjualan digital modern.</p>
        </div>
    </footer>

</body>
</html>
