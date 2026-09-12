<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checkout — {{ $product->name }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-100 min-h-screen">

    {{-- Top bar --}}
    <div class="bg-white border-b border-slate-200 sticky top-0 z-10">
        <div class="max-w-lg mx-auto px-4 py-3 flex items-center gap-3">
            <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center text-white font-bold text-xs flex-shrink-0">S</div>
            <div class="flex-1 min-w-0">
                <p class="text-xs text-slate-400 leading-none">Checkout untuk</p>
                <p class="text-sm font-semibold text-slate-900 truncate">{{ $product->name }}</p>
            </div>
            <span class="text-sm font-bold text-orange-600 whitespace-nowrap">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="max-w-lg mx-auto px-4 py-6 space-y-4">

        {{-- Validation errors --}}
        @if($errors->any())
            <div class="p-4 bg-red-50 border border-red-200 rounded-2xl text-sm text-red-700">
                <p class="font-semibold mb-2">Ada kesalahan, periksa kembali:</p>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Product summary --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-3">Detail Produk</p>
            <div class="flex items-start justify-between gap-4">
                <div>
                    @if($product->category)
                        <span class="text-xs font-medium text-orange-500">{{ $product->category->name }}</span>
                    @endif
                    <h2 class="text-base font-bold text-slate-900 mt-0.5">{{ $product->name }}</h2>
                    @if($product->description)
                        <p class="text-sm text-slate-500 mt-1 leading-relaxed">{{ $product->description }}</p>
                    @endif
                </div>
                <div class="text-right flex-shrink-0">
                    <p class="text-xs text-slate-400">Harga</p>
                    <p class="text-xl font-extrabold text-orange-600 whitespace-nowrap">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        {{-- Payment info --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-3">Informasi Pembayaran</p>
            <div class="bg-slate-50 rounded-xl border border-slate-100 p-4 space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500">Bank</span>
                    <span class="font-semibold text-slate-900">{{ $product->owner->bank_name ?? '-' }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500">No. Rekening</span>
                    <div class="flex items-center gap-2">
                        <span class="font-mono font-bold text-slate-900" id="accNum">{{ $product->owner->bank_account_number ?? '-' }}</span>
                        <button onclick="copyAccNum()" class="text-orange-500 hover:text-orange-600 transition" title="Salin">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500">Atas Nama</span>
                    <span class="font-semibold text-slate-900">{{ $product->owner->bank_account_name ?? '-' }}</span>
                </div>
                <div class="flex justify-between text-sm font-bold border-t border-slate-200 pt-2 mt-1">
                    <span class="text-slate-700">Total Bayar</span>
                    <span class="text-orange-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                </div>
            </div>
            <p class="text-xs text-slate-400 mt-2">Lakukan transfer terlebih dahulu, lalu isi form di bawah dan upload bukti transfer.</p>
        </div>

        {{-- Form --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-4">Data Pemesan</p>

            <form action="{{ route('checkout.store', $product->id) }}" method="POST" enctype="multipart/form-data" id="checkoutForm">
                @csrf
                <div class="space-y-4">

                    <div>
                        <label for="customer_name" class="block text-sm font-medium text-slate-700 mb-1.5">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="customer_name" name="customer_name"
                               value="{{ old('customer_name') }}"
                               placeholder="Masukkan nama lengkap Anda"
                               required autofocus autocomplete="name"
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 placeholder-slate-400
                                      focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-500 focus:bg-white transition">
                    </div>

                    <div>
                        <label for="customer_email" class="block text-sm font-medium text-slate-700 mb-1.5">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" id="customer_email" name="customer_email"
                               value="{{ old('customer_email') }}"
                               placeholder="contoh@email.com"
                               required autocomplete="email"
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 placeholder-slate-400
                                      focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-500 focus:bg-white transition">
                    </div>

                    <div>
                        <label for="customer_phone" class="block text-sm font-medium text-slate-700 mb-1.5">
                            Nomor WhatsApp <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" id="customer_phone" name="customer_phone"
                               value="{{ old('customer_phone') }}"
                               placeholder="08xxxxxxxxxx"
                               required autocomplete="tel"
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 placeholder-slate-400
                                      focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-500 focus:bg-white transition">
                    </div>

                    <div>
                        <label for="payment_proof" class="block text-sm font-medium text-slate-700 mb-1.5">
                            Bukti Transfer <span class="text-red-500">*</span>
                        </label>
                        <label for="payment_proof"
                               class="flex flex-col items-center justify-center w-full h-36 border-2 border-dashed border-slate-200 rounded-xl
                                      cursor-pointer bg-slate-50 hover:bg-orange-50 hover:border-orange-300 transition group">
                            <div id="proofPlaceholder" class="flex flex-col items-center gap-2 text-slate-400 group-hover:text-orange-500 transition">
                                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                                </svg>
                                <span class="text-xs font-medium">Upload bukti transfer</span>
                                <span class="text-xs">JPG, JPEG, PNG — Maks 2MB</span>
                            </div>
                            <div id="proofPreview" class="hidden items-center gap-3 px-4">
                                <img id="proofThumb" src="" alt="Preview" class="w-14 h-14 object-cover rounded-xl border border-slate-200">
                                <div>
                                    <p id="proofFileName" class="text-sm font-semibold text-slate-700 truncate max-w-[200px]"></p>
                                    <p class="text-xs text-slate-400 mt-0.5">Klik untuk ganti foto</p>
                                </div>
                            </div>
                        </label>
                        <input type="file" id="payment_proof" name="payment_proof"
                               accept="image/jpg,image/jpeg,image/png" required class="sr-only"
                               onchange="handleFileSelect(this)">
                    </div>

                    <button type="submit" id="submitBtn"
                            class="mt-2 w-full flex items-center justify-center gap-2 px-5 py-3
                                   bg-gradient-to-r from-orange-500 to-orange-600 text-white text-sm font-bold rounded-xl
                                   hover:from-orange-600 hover:to-orange-700 transition-all duration-150 shadow-sm shadow-orange-500/25
                                   focus:outline-none focus:ring-2 focus:ring-orange-500/50">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/>
                        </svg>
                        Kirim Pesanan
                    </button>
                </div>
            </form>
        </div>

        <p class="text-center text-xs text-slate-400 pb-4">Powered by <span class="font-semibold text-orange-500">{{ config('app.name', 'Sellflow') }}</span></p>
    </div>

    <script>
    function handleFileSelect(input) {
        const file = input.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('proofThumb').src = e.target.result;
            document.getElementById('proofFileName').textContent = file.name;
            document.getElementById('proofPlaceholder').classList.add('hidden');
            const preview = document.getElementById('proofPreview');
            preview.classList.remove('hidden');
            preview.classList.add('flex');
        };
        reader.readAsDataURL(file);
    }

    document.getElementById('checkoutForm').addEventListener('submit', () => {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = `
            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
            </svg>
            Mengirim...`;
    });

    function copyAccNum() {
        const text = document.getElementById('accNum').textContent.trim();
        navigator.clipboard.writeText(text).then(() => {
            const toast = document.createElement('div');
            toast.textContent = 'Nomor rekening disalin!';
            toast.className = 'fixed bottom-6 left-1/2 -translate-x-1/2 bg-slate-900 text-white text-xs font-medium px-4 py-2 rounded-lg shadow-lg z-50 opacity-0 transition-opacity duration-200';
            document.body.appendChild(toast);
            requestAnimationFrame(() => toast.style.opacity = '1');
            setTimeout(() => { toast.style.opacity = '0'; setTimeout(() => toast.remove(), 200); }, 2000);
        });
    }
    </script>
</body>
</html>
