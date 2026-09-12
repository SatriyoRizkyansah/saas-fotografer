<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-slate-900">{{ __('Pengaturan Toko') }}</h2>
    </x-slot>

    <div>

            @if(session('success'))
                <div class="mb-6 flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- ── Form Column ── --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Store Info Card --}}
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-100">
                            <h3 class="text-sm font-semibold text-slate-900">Informasi Toko</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Nama dan deskripsi yang akan tampil di storefront publik kamu.</p>
                        </div>
                        <form id="settingsForm" action="{{ route('owner.settings.store') }}" method="POST">
                            @csrf
                            <div class="px-6 py-5 space-y-5">

                                {{-- Store Name --}}
                                <div>
                                    <label for="store_name" class="block text-sm font-medium text-slate-700 mb-1.5">Nama Toko</label>
                                    <input type="text" id="store_name" name="store_name"
                                           value="{{ $setting->store_name ?? '' }}"
                                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-500 focus:bg-white transition"
                                           placeholder="Toko Fotografi Saya">
                                </div>

                                {{-- Store Description --}}
                                <div>
                                    <label for="store_description" class="block text-sm font-medium text-slate-700 mb-1.5">Deskripsi</label>
                                    <textarea id="store_description" name="store_description" rows="4"
                                              class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-500 focus:bg-white transition resize-none"
                                              placeholder="Deskripsikan layanan fotografi Anda...">{{ $setting->store_description ?? '' }}</textarea>
                                </div>

                                {{-- Brand Color --}}
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Warna Brand</label>
                                    <div class="flex items-center gap-3">
                                        <div class="relative">
                                            <input type="color" id="brand_color" name="brand_color"
                                                   value="{{ $setting->brand_color ?? '#f97316' }}"
                                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer rounded-xl">
                                            <div id="color_preview"
                                                 class="w-11 h-11 rounded-xl border-2 border-slate-200 shadow-sm cursor-pointer flex items-center justify-center"
                                                 style="background-color: {{ $setting->brand_color ?? '#f97316' }}">
                                            </div>
                                        </div>
                                        <input type="text" id="brand_color_text"
                                               value="{{ $setting->brand_color ?? '#f97316' }}"
                                               class="flex-1 px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 font-mono focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-500 focus:bg-white transition"
                                               placeholder="#f97316"
                                               maxlength="7">
                                        <div id="color_dot" class="w-8 h-8 rounded-full border border-slate-200 flex-shrink-0"
                                             style="background-color: {{ $setting->brand_color ?? '#f97316' }}">
                                        </div>
                                    </div>
                                    <p class="text-xs text-slate-400 mt-1.5">Warna ini akan digunakan sebagai tema utama toko kamu.</p>
                                </div>

                            </div>

                            {{-- Social Links Card --}}
                            <div class="border-t border-slate-100 px-6 py-5">
                                <h4 class="text-sm font-semibold text-slate-900 mb-1">Link Sosial Media</h4>
                                <p class="text-xs text-slate-500 mb-4">Tampilkan media sosial kamu di halaman toko.</p>

                                @php
                                    $socialLinks = $setting->social_links ? json_decode($setting->social_links, true) : [];
                                    $defaultLinks = ['instagram' => '', 'facebook' => '', 'twitter' => '', 'whatsapp' => ''];
                                    $socialLinks = array_merge($defaultLinks, $socialLinks);

                                    $socialIcons = [
                                        'instagram' => ['label' => 'Instagram', 'color' => 'text-pink-500', 'placeholder' => 'https://instagram.com/username'],
                                        'facebook'  => ['label' => 'Facebook',  'color' => 'text-blue-600', 'placeholder' => 'https://facebook.com/username'],
                                        'twitter'   => ['label' => 'Twitter',   'color' => 'text-sky-500',  'placeholder' => 'https://twitter.com/username'],
                                        'whatsapp'  => ['label' => 'WhatsApp',  'color' => 'text-green-500','placeholder' => 'https://wa.me/628123456789'],
                                    ];
                                @endphp

                                <div class="space-y-3">
                                    @foreach($socialIcons as $key => $info)
                                    <div class="flex items-center gap-3">
                                        <span class="w-28 text-sm font-medium text-slate-600 flex-shrink-0">{{ $info['label'] }}</span>
                                        <input type="url" name="social_links[{{ $key }}]"
                                               value="{{ $socialLinks[$key] ?? '' }}"
                                               class="flex-1 px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-500 focus:bg-white transition"
                                               placeholder="{{ $info['placeholder'] }}">
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Publish + Submit --}}
                            <div class="border-t border-slate-100 px-6 py-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                {{-- Publish Toggle --}}
                                <label class="flex items-center gap-3 cursor-pointer group select-none">
                                    <div class="relative">
                                        <input type="checkbox" name="is_published" value="1"
                                               id="is_published"
                                               {{ ($setting->is_published ?? false) ? 'checked' : '' }}
                                               class="sr-only peer">
                                        <div class="w-11 h-6 bg-slate-200 peer-checked:bg-orange-500 rounded-full transition-colors duration-200 peer-focus:ring-2 peer-focus:ring-orange-500/30"></div>
                                        <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform duration-200 peer-checked:translate-x-5"></div>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-slate-700">Publikasikan Toko</span>
                                        <p class="text-xs text-slate-400">Toko kamu akan bisa diakses publik</p>
                                    </div>
                                </label>

                                {{-- Submit Button --}}
                                <button type="submit"
                                        class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-orange-500 hover:bg-orange-600 active:bg-orange-700 text-white text-sm font-semibold rounded-xl transition-colors duration-150 shadow-sm shadow-orange-500/25 focus:outline-none focus:ring-2 focus:ring-orange-500/50 whitespace-nowrap">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0120.25 6v12A2.25 2.25 0 0118 20.25H6A2.25 2.25 0 013.75 18V6A2.25 2.25 0 016 3.75h1.5m9 0h-9" />
                                    </svg>
                                    Simpan Pengaturan
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

                {{-- ── Sidebar ── --}}
                <div class="lg:col-span-1 space-y-5">

                    {{-- Store URL Card --}}
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="px-5 py-4 border-b border-slate-100">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-orange-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                                </svg>
                                <h3 class="text-sm font-semibold text-slate-900">URL Toko</h3>
                            </div>
                        </div>

                        <div class="px-5 py-4">
                            @if($setting && $setting->owner && $setting->owner->store_uuid)
                                <p class="text-xs text-slate-500 mb-3">Bagikan URL ini ke klien kamu:</p>
                                <div class="bg-slate-50 border border-slate-200 rounded-xl p-3 mb-3">
                                    <p class="text-xs font-mono text-slate-600 break-all leading-relaxed">{{ $storeUrl ?? '' }}</p>
                                </div>
                                <div class="flex gap-2">
                                    <button onclick="copyToClipboard(`{{ $storeUrl ?? '' }}`)"
                                            class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-orange-500 hover:bg-orange-600 active:bg-orange-700 text-white text-xs font-semibold rounded-lg transition-colors duration-150 shadow-sm shadow-orange-500/20 focus:outline-none focus:ring-2 focus:ring-orange-500/40">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75" />
                                        </svg>
                                        Salin URL
                                    </button>
                                    <a href="{{ $storeUrl ?? '#' }}" target="_blank"
                                       class="inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-slate-100 hover:bg-slate-200 active:bg-slate-300 text-slate-700 text-xs font-semibold rounded-lg transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-slate-400/40">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                        </svg>
                                        Buka
                                    </a>
                                </div>
                            @else
                                <p class="text-xs text-slate-500 mb-4">Buat URL unik untuk toko kamu yang bisa dibagikan ke klien.</p>
                                <button onclick="generateStoreUrl()"
                                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-orange-500 hover:bg-orange-600 active:bg-orange-700 text-white text-sm font-semibold rounded-xl transition-colors duration-150 shadow-sm shadow-orange-500/20 focus:outline-none focus:ring-2 focus:ring-orange-500/40">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                                    </svg>
                                    Buat URL Toko
                                </button>
                            @endif
                        </div>
                    </div>

                    {{-- QR Code Card --}}
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="px-5 py-4 border-b border-slate-100">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-orange-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 18.75h.75v.75h-.75v-.75zM18 13.5h.75v.75H18v-.75zM18 18.75h.75v.75H18v-.75zM16.5 16.5h.75v.75h-.75v-.75z" />
                                </svg>
                                <h3 class="text-sm font-semibold text-slate-900">QR Code Toko</h3>
                            </div>
                        </div>

                        <div class="px-5 py-5">
                            @if($setting && $setting->owner && $setting->owner->store_uuid && $storeQrCode)
                                <p class="text-xs text-slate-500 mb-4">Cetak QR code ini di banner atau stand foto kamu. Pelanggan tinggal scan untuk langsung ke toko kamu.</p>

                                {{-- QR Code display --}}
                                <div class="flex justify-center mb-4">
                                    <div class="bg-white border-2 border-slate-100 rounded-2xl p-4 shadow-sm" id="qrWrapper">
                                        <div class="text-center mb-3">
                                            <p class="text-xs font-bold text-slate-700">{{ $setting->store_name ?? 'Toko Saya' }}</p>
                                            <p class="text-[10px] text-slate-400">Scan untuk melihat layanan</p>
                                        </div>
                                        {!! $storeQrCode !!}
                                        <p class="text-[9px] text-slate-400 text-center mt-2 font-mono break-all">{{ Str::limit($storeUrl, 35) }}</p>
                                    </div>
                                </div>

                                {{-- Actions --}}
                                <div class="flex gap-2">
                                    <button onclick="printQr()"
                                            class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-orange-500 hover:bg-orange-600 text-white text-xs font-semibold rounded-lg transition-colors shadow-sm shadow-orange-500/20 focus:outline-none focus:ring-2 focus:ring-orange-500/40">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                                        </svg>
                                        Print
                                    </button>
                                    <button onclick="downloadQr()"
                                            class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-slate-400/40">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                        </svg>
                                        Download
                                    </button>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5z" />
                                        </svg>
                                    </div>
                                    <p class="text-xs text-slate-500 font-medium">Buat URL toko dulu</p>
                                    <p class="text-xs text-slate-400 mt-0.5">QR code akan muncul setelah URL toko dibuat.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Preview Card --}}
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="px-5 py-4 border-b border-slate-100">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <h3 class="text-sm font-semibold text-slate-900">Preview Toko</h3>
                            </div>
                        </div>

                        <div class="px-5 py-4">
                            <div class="rounded-xl overflow-hidden border border-slate-200">
                                <div id="preview_header" class="px-4 py-3 flex items-center gap-2" style="background-color: {{ $setting->brand_color ?? '#f97316' }}">
                                    <div class="w-6 h-6 bg-white/20 rounded-lg"></div>
                                    <span id="preview_name" class="text-white text-xs font-semibold truncate">
                                        {{ $setting->store_name ?: 'Nama Toko' }}
                                    </span>
                                </div>
                                <div class="bg-slate-50 px-4 py-4">
                                    <div class="h-2 bg-slate-200 rounded-full mb-2 w-3/4"></div>
                                    <div class="h-2 bg-slate-200 rounded-full mb-2 w-1/2"></div>
                                    <div class="grid grid-cols-2 gap-2 mt-3">
                                        <div class="h-14 bg-slate-200 rounded-lg"></div>
                                        <div class="h-14 bg-slate-200 rounded-lg"></div>
                                    </div>
                                </div>
                            </div>
                            <p class="text-xs text-slate-400 mt-2.5 text-center">Tampilan akan berubah sesuai pengaturan kamu.</p>
                        </div>
                    </div>

                </div>
            </div>
    </div>

    <script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            // Show toast instead of alert
            showToast('URL berhasil disalin!');
        }).catch(() => {
            // Fallback
            const el = document.createElement('textarea');
            el.value = text;
            document.body.appendChild(el);
            el.select();
            document.execCommand('copy');
            document.body.removeChild(el);
            showToast('URL berhasil disalin!');
        });
    }

    function showToast(msg) {
        const toast = document.createElement('div');
        toast.textContent = msg;
        toast.className = 'fixed bottom-24 lg:bottom-6 left-1/2 -translate-x-1/2 bg-slate-900 text-white text-sm font-medium px-5 py-2.5 rounded-xl shadow-lg z-50 transition-all duration-300 opacity-0';
        document.body.appendChild(toast);
        requestAnimationFrame(() => toast.style.opacity = '1');
        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 300);
        }, 2000);
    }

    function generateStoreUrl() {
        const btn = event.currentTarget;
        btn.disabled = true;
        btn.innerHTML = `<svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg> Membuat...`;

        fetch('{{ route("owner.settings.generate-url") }}', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(r => r.json())
        .then(() => window.location.reload())
        .catch(() => {
            btn.disabled = false;
            btn.innerHTML = 'Coba Lagi';
        });
    }

    // Sync color picker ↔ text input ↔ preview
    const colorPicker = document.getElementById('brand_color');
    const colorText   = document.getElementById('brand_color_text');
    const colorPreview = document.getElementById('color_preview');
    const colorDot    = document.getElementById('color_dot');
    const previewHeader = document.getElementById('preview_header');

    function updateColor(hex) {
        colorPicker.value = hex;
        colorText.value   = hex;
        if (colorPreview)  colorPreview.style.backgroundColor = hex;
        if (colorDot)      colorDot.style.backgroundColor = hex;
        if (previewHeader) previewHeader.style.backgroundColor = hex;
    }

    colorPicker.addEventListener('input', () => updateColor(colorPicker.value));

    colorText.addEventListener('input', function() {
        const val = this.value.trim();
        if (/^#([0-9a-f]{3}){1,2}$/i.test(val)) updateColor(val);
    });

    // Live preview store name
    const nameInput = document.getElementById('store_name');
    const previewName = document.getElementById('preview_name');
    if (nameInput && previewName) {
        nameInput.addEventListener('input', () => {
            previewName.textContent = nameInput.value || 'Nama Toko';
        });
    }

    function printQr() {
        const wrapper = document.getElementById('qrWrapper');
        if (!wrapper) return;
        const win = window.open('', '_blank', 'width=400,height=500');
        win.document.write(`
            <!DOCTYPE html><html><head>
            <title>QR Code — {{ $setting->store_name ?? 'Toko' }}</title>
            <style>
                body { margin: 0; display: flex; align-items: center; justify-content: center; min-height: 100vh; background: #fff; font-family: sans-serif; }
                .wrap { text-align: center; padding: 24px; border: 2px solid #e2e8f0; border-radius: 16px; display: inline-block; }
                .wrap p { margin: 0; }
                .title { font-weight: 700; font-size: 14px; color: #1e293b; margin-bottom: 4px; }
                .sub { font-size: 11px; color: #94a3b8; margin-bottom: 12px; }
                .url { font-size: 9px; color: #94a3b8; margin-top: 8px; font-family: monospace; word-break: break-all; max-width: 200px; }
            </style></head><body>
            <div class="wrap">
                <p class="title">{{ $setting->store_name ?? 'Toko Saya' }}</p>
                <p class="sub">Scan untuk melihat layanan</p>
                ${wrapper.querySelector('svg').outerHTML}
                <p class="url">{{ $storeUrl ?? '' }}</p>
            </div>
            <script>window.onload=()=>{window.print();window.close();}<\/script>
            </body></html>
        `);
        win.document.close();
    }

    function downloadQr() {
        const svg = document.querySelector('#qrWrapper svg');
        if (!svg) return;
        const svgData = new XMLSerializer().serializeToString(svg);
        const blob = new Blob([svgData], { type: 'image/svg+xml' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'qr-toko-{{ Str::slug($setting->store_name ?? "toko") }}.svg';
        a.click();
        URL.revokeObjectURL(url);
    }
    </script>
</x-app-layout>
