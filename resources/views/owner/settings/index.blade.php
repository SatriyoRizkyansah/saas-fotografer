<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-slate-900">{{ __('Pengaturan Toko') }}</h2>
    </x-slot>

    <div class="p-4 sm:p-6 lg:p-8">
        <div class="max-w-5xl mx-auto">
            @if(session('success'))
                <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Form Column --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl border border-slate-100 p-5 sm:p-6">
                        <form id="settingsForm" action="{{ route('owner.settings.store') }}" method="POST">
                            @csrf

                            {{-- Store Name --}}
                            <div class="mb-5">
                                <label for="store_name" class="block text-sm font-medium text-slate-700 mb-1">Nama Toko</label>
                                <input type="text" id="store_name" name="store_name" value="{{ $setting->store_name ?? '' }}"
                                       class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-lg text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition"
                                       placeholder="Toko Fotografi Saya">
                            </div>

                            {{-- Store Description --}}
                            <div class="mb-5">
                                <label for="store_description" class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
                                <textarea id="store_description" name="store_description" rows="4"
                                          class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-lg text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition"
                                          placeholder="Deskripsikan layanan fotografi Anda...">{{ $setting->store_description ?? '' }}</textarea>
                            </div>

                            {{-- Brand Color --}}
                            <div class="mb-5">
                                <label for="brand_color" class="block text-sm font-medium text-slate-700 mb-1">Warna Brand</label>
                                <div class="flex items-center gap-3">
                                    <input type="color" id="brand_color" name="brand_color"
                                           value="{{ $setting->brand_color ?? '#f97316' }}"
                                           class="h-10 w-20 px-2 py-1 border border-slate-200 rounded-lg cursor-pointer">
                                    <input type="text" id="brand_color_text"
                                           value="{{ $setting->brand_color ?? '#f97316' }}"
                                           class="flex-1 px-4 py-2.5 bg-white border border-slate-200 rounded-lg text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition"
                                           placeholder="#f97316"
                                           oninput="document.getElementById('brand_color').value = this.value">
                                </div>
                            </div>

                            {{-- Social Links --}}
                            <div class="mb-5">
                                <label class="block text-sm font-medium text-slate-700 mb-2">Link Sosial Media</label>
                                @php
                                    $socialLinks = $setting->social_links ? json_decode($setting->social_links, true) : [];
                                    $defaultLinks = ['instagram' => '', 'facebook' => '', 'twitter' => '', 'whatsapp' => ''];
                                    $socialLinks = array_merge($defaultLinks, $socialLinks);
                                @endphp

                                @foreach(['instagram' => 'Instagram', 'facebook' => 'Facebook', 'twitter' => 'Twitter', 'whatsapp' => 'WhatsApp'] as $key => $label)
                                <div class="flex items-center mb-2">
                                    <span class="w-24 text-sm text-slate-500">{{ $label }}</span>
                                    <input type="url" name="social_links[{{ $key }}]"
                                           value="{{ $socialLinks[$key] ?? '' }}"
                                           class="flex-1 px-4 py-2.5 bg-white border border-slate-200 rounded-lg text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition"
                                           placeholder="https://...">
                                </div>
                                @endforeach
                            </div>

                            {{-- Publish Toggle --}}
                            <div class="mb-6">
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_published" value="1"
                                           {{ ($setting->is_published ?? false) ? 'checked' : '' }}
                                           class="form-checkbox h-5 w-5 text-orange-600 focus:ring-orange-500 border-slate-300 rounded">
                                    <span class="ml-2 text-sm text-slate-700">Publikasikan Toko</span>
                                </label>
                            </div>

                            <div class="flex items-center gap-3">
                                <button type="submit" class="px-6 py-2.5 bg-orange-600 text-white text-sm font-semibold rounded-lg hover:bg-orange-700 transition-all duration-200 shadow-sm">
                                    Simpan Pengaturan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="lg:col-span-1 space-y-6">
                    {{-- Store URL Card --}}
                    <div class="bg-white rounded-xl border border-slate-100 p-5 sm:p-6">
                        <h3 class="text-sm font-semibold text-slate-900 mb-3">URL Toko Anda</h3>
                        @if($setting && $setting->owner && $setting->owner->store_uuid)
                            <div class="bg-slate-50 p-3 rounded-lg mb-3 border border-slate-100">
                                <p class="text-xs text-slate-500 mb-2">URL publik toko Anda:</p>
                                <div class="flex items-center gap-2">
                                    <input type="text" readonly value="{{ $storeUrl ?? '' }}" class="flex-1 px-3 py-1.5 text-xs bg-white border border-slate-200 rounded-lg outline-none font-mono text-slate-600">
                                    <button onclick="copyToClipboard(`{{ $storeUrl ?? '' }}`)" class="px-3 py-1.5 text-xs bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition font-medium">
                                        Copy
                                    </button>
                                </div>
                            </div>
                            <p class="text-xs text-slate-400">Bagikan URL ini kepada klien Anda untuk mengakses toko publik Anda.</p>
                        @else
                            <p class="text-sm text-slate-500 mb-3">Buat URL toko Anda untuk dibagikan kepada klien.</p>
                            <button onclick="generateStoreUrl()"
                                    class="w-full px-4 py-2.5 bg-orange-600 text-white text-sm font-semibold rounded-lg hover:bg-orange-700 transition-all duration-200">
                                Buat URL Toko
                            </button>
                        @endif
                    </div>

                    {{-- Preview Card --}}
                    <div class="bg-white rounded-xl border border-slate-100 p-5 sm:p-6">
                        <h3 class="text-sm font-semibold text-slate-900 mb-3">Preview Toko</h3>
                        <div class="bg-slate-50 h-40 rounded-lg flex items-center justify-center border border-slate-100">
                            <p class="text-slate-400 text-xs">Preview toko akan muncul di sini</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            alert('URL berhasil disalin!');
        }).catch(err => {
            console.error('Gagal menyalin: ', err);
        });
    }

    function generateStoreUrl() {
        fetch('{{ route("owner.settings.generate-url") }}', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            alert('URL Toko berhasil dibuat!');
            window.location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    // Sync color picker and text input
    document.getElementById('brand_color').addEventListener('input', function() {
        document.getElementById('brand_color_text').value = this.value;
    });
    </script>
</x-app-layout>
