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

        {{-- Pilih metode pembayaran --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Pilih Metode Pembayaran</p>
                <p class="text-xs text-slate-400 mt-0.5">Pilih rekening tujuan transfer, lalu upload bukti di bawah.</p>
            </div>
            <form action="{{ route('checkout.store', $product->id) }}" method="POST" enctype="multipart/form-data" id="checkoutForm">
                @csrf

                @if($paymentMethods->isEmpty())
                    <div class="px-5 py-6 text-center text-sm text-slate-400">
                        Belum ada metode pembayaran yang tersedia.
                    </div>
                @else
                <div class="divide-y divide-slate-100">
                    @foreach($paymentMethods as $pm)
                    <label class="flex items-center gap-4 px-5 py-4 cursor-pointer hover:bg-orange-50/50 transition group">
                        <input type="radio" name="payment_method_id" value="{{ $pm->id }}"
                               {{ (old('payment_method_id', $paymentMethods->where('is_default',true)->first()?->id) == $pm->id) ? 'checked' : '' }}
                               required
                               class="w-4 h-4 text-orange-500 border-slate-300 focus:ring-orange-500/30"
                               onchange="updatePaymentInfo({{ $pm->id }}, '{{ addslashes($pm->bank_name) }}', '{{ addslashes($pm->account_number) }}', '{{ addslashes($pm->account_name) }}')">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <p class="text-sm font-semibold text-slate-900">{{ $pm->bank_name }}</p>
                                @if($pm->is_default)
                                    <span class="text-[10px] font-bold px-1.5 py-0.5 bg-orange-100 text-orange-600 rounded-full">Utama</span>
                                @endif
                                <span class="text-[10px] font-medium px-1.5 py-0.5 bg-slate-100 text-slate-500 rounded-full capitalize">{{ $pm->type }}</span>
                            </div>
                            <p class="text-xs text-slate-500 font-mono mt-0.5">{{ $pm->account_number }}</p>
                            <p class="text-xs text-slate-400">a/n {{ $pm->account_name }}</p>
                        </div>
                    </label>
                    @endforeach
                </div>

                {{-- Info rekening terpilih --}}
                <div id="paymentInfoBox" class="mx-5 mb-4 mt-1 p-4 bg-orange-50 border border-orange-100 rounded-xl text-sm">
                    <p class="text-xs font-semibold text-orange-700 mb-2">Transfer ke rekening berikut:</p>
                    <div class="space-y-1">
                        <div class="flex justify-between">
                            <span class="text-slate-500 text-xs">Bank</span>
                            <span class="font-semibold text-slate-900 text-xs" id="info_bank">
                                {{ $paymentMethods->where('is_default',true)->first()?->bank_name ?? $paymentMethods->first()?->bank_name ?? '-' }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500 text-xs">Nomor</span>
                            <span class="font-mono font-bold text-slate-900 text-xs" id="info_number">
                                {{ $paymentMethods->where('is_default',true)->first()?->account_number ?? $paymentMethods->first()?->account_number ?? '-' }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500 text-xs">Atas Nama</span>
                            <span class="font-semibold text-slate-900 text-xs" id="info_name">
                                {{ $paymentMethods->where('is_default',true)->first()?->account_name ?? $paymentMethods->first()?->account_name ?? '-' }}
                            </span>
                        </div>
                        <div class="flex justify-between border-t border-orange-200 pt-1 mt-1">
                            <span class="text-xs font-semibold text-slate-700">Total</span>
                            <span class="text-xs font-bold text-orange-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Data pemesan --}}
                <div class="px-5 pb-5 space-y-4 border-t border-slate-100 pt-4">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Data Pemesan</p>

                    <div>
                        <label for="customer_name" class="block text-sm font-medium text-slate-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name') }}"
                               placeholder="Masukkan nama lengkap" required autocomplete="name"
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900
                                      placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500/30
                                      focus:border-orange-500 focus:bg-white transition">
                    </div>
                    <div>
                        <label for="customer_email" class="block text-sm font-medium text-slate-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                        <input type="email" id="customer_email" name="customer_email" value="{{ old('customer_email') }}"
                               placeholder="contoh@email.com" required autocomplete="email"
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900
                                      placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500/30
                                      focus:border-orange-500 focus:bg-white transition">
                    </div>
                    <div>
                        <label for="customer_phone" class="block text-sm font-medium text-slate-700 mb-1.5">Nomor WhatsApp <span class="text-red-500">*</span></label>
                        <input type="tel" id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}"
                               placeholder="08xxxxxxxxxx" required autocomplete="tel"
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900
                                      placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500/30
                                      focus:border-orange-500 focus:bg-white transition">
                    </div>
                    <div>
                        <label for="payment_proof" class="block text-sm font-medium text-slate-700 mb-1.5">Bukti Transfer <span class="text-red-500">*</span></label>
                        <label for="payment_proof"
                               class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-slate-200 rounded-xl
                                      cursor-pointer bg-slate-50 hover:bg-orange-50 hover:border-orange-300 transition group">
                            <div id="proofPlaceholder" class="flex flex-col items-center gap-2 text-slate-400 group-hover:text-orange-500 transition">
                                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                                </svg>
                                <span class="text-xs font-medium">Upload bukti transfer</span>
                                <span class="text-xs">JPG, PNG — Maks 5MB</span>
                            </div>
                            <div id="proofPreview" class="hidden items-center gap-3 px-4">
                                <img id="proofThumb" src="" alt="Preview" class="w-14 h-14 object-cover rounded-xl border border-slate-200">
                                <div>
                                    <p id="proofFileName" class="text-sm font-semibold text-slate-700 truncate max-w-[200px]"></p>
                                    <p class="text-xs text-slate-400 mt-0.5">Klik untuk ganti</p>
                                </div>
                            </div>
                        </label>
                        <input type="file" id="payment_proof" name="payment_proof"
                               accept="image/jpg,image/jpeg,image/png" required class="sr-only"
                               onchange="handleFileSelect(this)">
                    </div>

                    <button type="submit" id="submitBtn"
                            class="mt-2 w-full flex items-center justify-center gap-2 px-5 py-3
                                   bg-orange-500 hover:bg-orange-600 active:bg-orange-700
                                   text-white text-sm font-bold rounded-xl transition-colors shadow-sm shadow-orange-500/25
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
    function updatePaymentInfo(id, bank, number, name) {
        document.getElementById('info_bank').textContent   = bank;
        document.getElementById('info_number').textContent = number;
        document.getElementById('info_name').textContent   = name;
    }

    function handleFileSelect(input) {
        const file = input.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('proofThumb').src = e.target.result;
            document.getElementById('proofFileName').textContent = file.name;
            document.getElementById('proofPlaceholder').classList.add('hidden');
            const p = document.getElementById('proofPreview');
            p.classList.remove('hidden'); p.classList.add('flex');
        };
        reader.readAsDataURL(file);
    }

    document.getElementById('checkoutForm').addEventListener('submit', () => {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = `<svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg> Mengirim...`;
    });
    </script>
</body>
</html>
