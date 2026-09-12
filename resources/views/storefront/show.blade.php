<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $setting->store_name ?? config('app.name', 'Sellflow') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root { --brand: {{ $setting->brand_color ?? '#f97316' }}; }
        .btn-brand { background-color: var(--brand); }
        .btn-brand:hover { filter: brightness(0.9); }
        .text-brand { color: var(--brand); }
        .border-brand { border-color: var(--brand); }
        .bg-brand { background-color: var(--brand); }
        .ring-brand:focus { --tw-ring-color: var(--brand); }
        .hero-gradient { background: linear-gradient(135deg, var(--brand) 0%, color-mix(in srgb, var(--brand) 70%, black) 100%); }
    </style>
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-800">

{{-- ─── NAVBAR ─────────────────────────────────────────── --}}
<header class="bg-white shadow-sm sticky top-0 z-30">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-3 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl btn-brand flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                {{ strtoupper(substr($setting->store_name ?? 'S', 0, 1)) }}
            </div>
            <div>
                <p class="font-bold text-slate-900 leading-tight">{{ $setting->store_name ?? config('app.name', 'Sellflow') }}</p>
                <p class="text-xs text-slate-400 leading-tight">Official Store</p>
            </div>
        </div>

        {{-- Social links --}}
        <div class="flex items-center gap-3">
            @php $links = is_array($setting->social_links) ? $setting->social_links : (json_decode($setting->social_links ?? '{}', true) ?? []); @endphp
            @if(!empty($links['instagram']))
                <a href="{{ $links['instagram'] }}" target="_blank" class="text-slate-400 hover:text-pink-500 transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                </a>
            @endif
            @if(!empty($links['whatsapp']))
                <a href="{{ $links['whatsapp'] }}" target="_blank" class="text-slate-400 hover:text-green-500 transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.197 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.876 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/><path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.477 2 12c0 1.89.524 3.655 1.437 5.163L2.01 22l4.962-1.407A9.96 9.96 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2zm0 18a7.96 7.96 0 01-4.073-1.115l-.292-.174-3.024.857.816-2.984-.19-.307A7.96 7.96 0 014 12c0-4.418 3.582-8 8-8s8 3.582 8 8-3.582 8-8 8z"/></svg>
                </a>
            @endif
        </div>
    </div>
</header>

{{-- ─── HERO ────────────────────────────────────────────── --}}
<section class="hero-gradient py-16 sm:py-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 text-center">
        <h1 class="text-4xl sm:text-5xl font-extrabold text-white mb-4 leading-tight">
            {{ $setting->store_name ?? config('app.name', 'Sellflow') }}
        </h1>
        @if($setting->store_description)
            <p class="text-white/80 text-lg max-w-xl mx-auto mb-8">{{ $setting->store_description }}</p>
        @else
            <p class="text-white/70 text-lg max-w-xl mx-auto mb-8">Abadikan momen berharga Anda bersama kami.</p>
        @endif
        <a href="#layanan" class="inline-flex items-center gap-2 bg-white/15 hover:bg-white/25 text-white border border-white/30 px-6 py-3 rounded-full font-semibold transition backdrop-blur-sm">
            Lihat Layanan
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
            </svg>
        </a>
    </div>
</section>

{{-- ─── PRODUCT GRID ────────────────────────────────────── --}}
<section id="layanan" class="py-16 sm:py-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-slate-900 mb-2">Layanan Kami</h2>
            <p class="text-slate-500">Pilih paket yang sesuai dengan kebutuhan Anda</p>
        </div>

        @if($products && $products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($products as $product)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow overflow-hidden flex flex-col">
                {{-- Placeholder image / icon --}}
                <div class="h-44 bg-gradient-to-br from-slate-100 to-slate-50 flex items-center justify-center">
                    <svg class="w-16 h-16 text-slate-200" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                    </svg>
                </div>

                <div class="p-5 flex flex-col flex-1">
                    {{-- Category badge --}}
                    @if($product->category)
                        <span class="text-xs font-medium text-brand inline-block mb-2">{{ $product->category->name }}</span>
                    @endif

                    <h3 class="text-base font-bold text-slate-900 mb-1">{{ $product->name }}</h3>

                    @if($product->description)
                        <p class="text-sm text-slate-500 leading-relaxed mb-4 flex-1">
                            {{ Str::limit($product->description, 100) }}
                        </p>
                    @else
                        <div class="flex-1"></div>
                    @endif

                    <div class="flex items-center justify-between mt-2 pt-4 border-t border-slate-100">
                        <div>
                            <p class="text-xs text-slate-400">Mulai dari</p>
                            <p class="text-xl font-extrabold text-brand">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                        <button
                            onclick="openBookingModal({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, '{{ addslashes($product->description ?? '') }}', '{{ route('storefront.book', [$setting->owner->store_uuid, $product->id]) }}')"
                            class="btn-brand text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-all duration-150 shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-1 ring-brand">
                            Book Now
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($products->hasPages())
            <div class="mt-10">{{ $products->links() }}</div>
        @endif

        @else
        <div class="text-center py-20">
            <svg class="w-16 h-16 mx-auto text-slate-200 mb-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
            </svg>
            <p class="text-slate-400 font-medium">Belum ada layanan yang tersedia.</p>
        </div>
        @endif
    </div>
</section>

{{-- ─── FOOTER ──────────────────────────────────────────── --}}
<footer class="bg-slate-900 text-white py-8 mt-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 text-center">
        <p class="text-slate-400 text-sm">&copy; {{ date('Y') }} {{ $setting->store_name ?? 'SnapPhoto' }}. All rights reserved.</p>
        <p class="text-slate-600 text-xs mt-1">Powered by SnapPhoto</p>
    </div>
</footer>

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- BOOKING MODAL                                          --}}
{{-- ═══════════════════════════════════════════════════════ --}}
<div id="bookingModal"
     class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-0 sm:p-4 hidden"
     role="dialog" aria-modal="true" aria-labelledby="modalTitle">

    {{-- Backdrop --}}
    <div id="modalBackdrop"
         class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"
         onclick="closeBookingModal()"></div>

    {{-- Sheet --}}
    <div id="modalSheet"
         class="relative bg-white w-full sm:max-w-lg sm:rounded-2xl rounded-t-2xl shadow-2xl overflow-hidden
                translate-y-full sm:translate-y-0 sm:scale-95 sm:opacity-0
                transition-all duration-300 ease-out max-h-[95dvh] flex flex-col">

        {{-- Modal Header --}}
        <div class="flex items-start justify-between px-5 pt-5 pb-4 border-b border-slate-100 flex-shrink-0">
            {{-- Drag handle (mobile) --}}
            <div class="absolute top-2.5 left-1/2 -translate-x-1/2 w-10 h-1 bg-slate-200 rounded-full sm:hidden"></div>
            <div class="pt-2 sm:pt-0">
                <h2 id="modalTitle" class="text-base font-bold text-slate-900" x-text="selectedProduct.name">Nama Produk</h2>
                <p id="modalPrice" class="text-sm font-semibold text-brand mt-0.5"></p>
            </div>
            <button onclick="closeBookingModal()"
                    class="text-slate-400 hover:text-slate-600 transition p-1 rounded-lg hover:bg-slate-100 flex-shrink-0 ml-4">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Scrollable body --}}
        <div class="overflow-y-auto flex-1">

            {{-- Validation errors (shown when redirected back with errors) --}}
            @if($errors->any())
            <div class="mx-5 mt-4 p-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
                <p class="font-semibold mb-1">Ada kesalahan pada form:</p>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Booking form --}}
            <form id="bookingForm" method="POST" enctype="multipart/form-data" action="#" class="px-5 pb-6">
                @csrf
                {{-- Action di-set via JS. Hidden field untuk restore saat validation error --}}
                <input type="hidden" id="hiddenActionUrl" name="_action_url" value="{{ old('_action_url', '') }}">

                {{-- Pilih Rekening — di dalam form supaya ikut submit --}}
                <div class="mt-4">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">Pilih Rekening Tujuan</p>
                    @if($paymentMethods->isEmpty())
                        <p class="text-xs text-slate-400 py-2">Belum ada metode pembayaran tersedia.</p>
                    @else
                    <div class="space-y-2">
                        @foreach($paymentMethods as $pm)
                        <label class="flex items-center gap-3 p-3 border border-slate-200 rounded-xl cursor-pointer hover:bg-orange-50 hover:border-orange-200 transition">
                            <input type="radio" name="payment_method_id" value="{{ $pm->id }}"
                                   {{ (old('payment_method_id', $pm->is_default ? $pm->id : ($loop->first ? $pm->id : '')) == $pm->id) ? 'checked' : '' }}
                                   required
                                   class="w-4 h-4 text-orange-500 border-slate-300 focus:ring-orange-500/30"
                                   onchange="updateModalInfo('{{ addslashes($pm->bank_name) }}', '{{ addslashes($pm->account_number) }}', '{{ addslashes($pm->account_name) }}')">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-slate-900">{{ $pm->bank_name }}
                                    @if($pm->is_default)<span class="text-[10px] font-bold px-1.5 py-0.5 bg-orange-100 text-orange-600 rounded-full ml-1">Utama</span>@endif
                                </p>
                                <p class="text-xs text-slate-500 font-mono">{{ $pm->account_number }} &mdash; {{ $pm->account_name }}</p>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    <div class="mt-2 p-3 bg-orange-50 border border-orange-100 rounded-xl space-y-1">
                        <div class="flex justify-between text-xs">
                            <span class="text-slate-500">Bank</span>
                            <span class="font-semibold text-slate-900" id="modalInfoBank">{{ $paymentMethods->where('is_default', true)->first()?->bank_name ?? $paymentMethods->first()?->bank_name ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between text-xs">
                            <span class="text-slate-500">Nomor</span>
                            <span class="font-mono font-bold text-slate-900" id="modalInfoNumber">{{ $paymentMethods->where('is_default', true)->first()?->account_number ?? $paymentMethods->first()?->account_number ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between text-xs border-t border-orange-200 pt-1 mt-1">
                            <span class="font-semibold text-slate-700">Total</span>
                            <span id="modalTotalPay" class="font-bold text-brand"></span>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="mt-5 space-y-4">
                    {{-- Name --}}
                    <div>
                        <label for="modal_customer_name" class="block text-sm font-medium text-slate-700 mb-1.5">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="modal_customer_name" name="customer_name"
                               value="{{ old('customer_name') }}"
                               placeholder="Masukkan nama lengkap Anda"
                               required autocomplete="name"
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 placeholder-slate-400
                                      focus:outline-none focus:ring-2 focus:border-transparent transition"
                               style="--tw-ring-color: var(--brand)">
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="modal_customer_email" class="block text-sm font-medium text-slate-700 mb-1.5">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" id="modal_customer_email" name="customer_email"
                               value="{{ old('customer_email') }}"
                               placeholder="contoh@email.com"
                               required autocomplete="email"
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 placeholder-slate-400
                                      focus:outline-none focus:ring-2 focus:border-transparent transition"
                               style="--tw-ring-color: var(--brand)">
                    </div>

                    {{-- WhatsApp --}}
                    <div>
                        <label for="modal_customer_phone" class="block text-sm font-medium text-slate-700 mb-1.5">
                            Nomor WhatsApp <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" id="modal_customer_phone" name="customer_phone"
                               value="{{ old('customer_phone') }}"
                               placeholder="08xxxxxxxxxx"
                               required autocomplete="tel"
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 placeholder-slate-400
                                      focus:outline-none focus:ring-2 focus:border-transparent transition"
                               style="--tw-ring-color: var(--brand)">
                    </div>

                    {{-- Payment proof --}}
                    <div>
                        <label for="modal_payment_proof" class="block text-sm font-medium text-slate-700 mb-1.5">
                            Bukti Transfer <span class="text-red-500">*</span>
                        </label>
                        <label for="modal_payment_proof"
                               class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-slate-200 rounded-xl cursor-pointer
                                      bg-slate-50 hover:bg-slate-100 transition group"
                               id="proofDropzone">
                            <div id="proofPlaceholder" class="flex flex-col items-center gap-2 text-slate-400 group-hover:text-slate-500">
                                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                                </svg>
                                <span class="text-xs font-medium">Klik atau seret foto bukti transfer</span>
                                <span class="text-xs text-slate-400">JPG, JPEG, PNG — Maks 2MB</span>
                            </div>
                            <div id="proofPreview" class="hidden items-center gap-3">
                                <img id="proofThumb" src="" alt="Preview" class="w-12 h-12 object-cover rounded-lg border border-slate-200">
                                <div>
                                    <p id="proofFileName" class="text-sm font-medium text-slate-700 truncate max-w-[180px]"></p>
                                    <p class="text-xs text-slate-400 mt-0.5">Klik untuk ganti</p>
                                </div>
                            </div>
                        </label>
                        <input type="file" id="modal_payment_proof" name="payment_proof"
                               accept="image/jpg,image/jpeg,image/png" required class="sr-only"
                               onchange="handleFileSelect(this)">
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit" id="submitBtn"
                        class="btn-brand mt-6 w-full flex items-center justify-center gap-2 py-3 text-white text-sm font-bold rounded-xl
                               transition-all duration-150 shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 ring-brand">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/>
                    </svg>
                    Kirim Pesanan
                </button>
            </form>
        </div>
    </div>
</div>

<script>
const modal   = document.getElementById('bookingModal');
const sheet   = document.getElementById('modalSheet');
const form    = document.getElementById('bookingForm');

function formatRupiah(n) {
    return 'Rp ' + Number(n).toLocaleString('id-ID');
}

function updateModalInfo(bank, number, name) {
    const b = document.getElementById('modalInfoBank');
    const n = document.getElementById('modalInfoNumber');
    if (b) b.textContent = bank;
    if (n) n.textContent = number;
}

function openBookingModal(id, name, price, desc, actionUrl) {
    // Populate header
    document.getElementById('modalTitle').textContent  = name;
    document.getElementById('modalPrice').textContent  = formatRupiah(price);
    document.getElementById('modalTotalPay').textContent = formatRupiah(price);

    // Set form action + simpan di hidden field (untuk restore saat validation error)
    form.action = actionUrl;
    document.getElementById('hiddenActionUrl').value = actionUrl;

    // Show modal
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';

    // Animate in (next frame so transition fires)
    requestAnimationFrame(() => {
        sheet.classList.remove('translate-y-full', 'sm:scale-95', 'sm:opacity-0');
        sheet.classList.add('translate-y-0', 'sm:scale-100', 'sm:opacity-100');
    });
}

function closeBookingModal() {
    sheet.classList.add('translate-y-full', 'sm:scale-95', 'sm:opacity-0');
    sheet.classList.remove('translate-y-0', 'sm:scale-100', 'sm:opacity-100');
    setTimeout(() => {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }, 300);
}

// Close on Escape
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeBookingModal();
});

// File preview
function handleFileSelect(input) {
    const file = input.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('proofThumb').src = e.target.result;
        document.getElementById('proofFileName').textContent = file.name;
        document.getElementById('proofPlaceholder').classList.add('hidden');
        document.getElementById('proofPreview').classList.remove('hidden');
        document.getElementById('proofPreview').classList.add('flex');
    };
    reader.readAsDataURL(file);
}

// Loading state on submit
form.addEventListener('submit', () => {
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = `
        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
        </svg>
        Mengirim...`;
});

// Re-open modal jika ada validation errors (form sudah disubmit)
@if($errors->any())
    window.addEventListener('DOMContentLoaded', () => {
        // Restore form action dari hidden field
        const savedAction = document.getElementById('hiddenActionUrl').value;
        if (savedAction && savedAction !== '') {
            form.action = savedAction;
        }
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        requestAnimationFrame(() => {
            sheet.classList.remove('translate-y-full', 'sm:scale-95', 'sm:opacity-0');
            sheet.classList.add('translate-y-0', 'sm:scale-100', 'sm:opacity-100');
        });
    });
@endif
</script>
</body>
</html>
