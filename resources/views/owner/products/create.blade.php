<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-slate-900">Tambah Produk</h2>
            <a href="{{ route('owner.products.index') }}"
               class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-700 font-medium transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="max-w-2xl">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100">
                <h3 class="text-sm font-semibold text-slate-900">Informasi Produk</h3>
                <p class="text-xs text-slate-500 mt-0.5">Isi detail produk yang akan ditampilkan di toko kamu.</p>
            </div>

            <form action="{{ route('owner.products.store') }}" method="POST" enctype="multipart/form-data" class="px-6 py-5 space-y-5">
                @csrf

                {{-- Foto Produk --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Foto Produk</label>
                    <div class="flex items-start gap-4">
                        {{-- Preview --}}
                        <div id="imagePreviewWrap" class="w-24 h-24 rounded-xl border-2 border-dashed border-slate-200 bg-slate-50 flex items-center justify-center flex-shrink-0 overflow-hidden">
                            <svg id="imagePlaceholderIcon" class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 001.5-1.5V5.25a1.5 1.5 0 00-1.5-1.5H3.75a1.5 1.5 0 00-1.5 1.5v14.25a1.5 1.5 0 001.5 1.5z"/>
                            </svg>
                            <img id="imagePreview" src="" alt="Preview" class="hidden w-full h-full object-cover">
                        </div>
                        {{-- Upload area --}}
                        <div class="flex-1">
                            <label for="image"
                                   class="flex items-center gap-2 px-4 py-2.5 border border-slate-200 rounded-xl bg-slate-50
                                          hover:bg-orange-50 hover:border-orange-300 cursor-pointer transition text-sm text-slate-600">
                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                                </svg>
                                <span id="imageLabel">Pilih foto...</span>
                            </label>
                            <input type="file" id="image" name="image" accept="image/jpg,image/jpeg,image/png,image/webp"
                                   class="sr-only" onchange="previewImage(this)">
                            <p class="text-xs text-slate-400 mt-1.5">JPG, PNG, WebP — Maks 5MB. Rasio 1:1 atau 4:3 terbaik.</p>
                            @error('image')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                {{-- Kategori --}}
                <div>
                    <label for="category_id" class="block text-sm font-medium text-slate-700 mb-1.5">Kategori <span class="text-red-500">*</span></label>
                    <select id="category_id" name="category_id" required
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900
                                   focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-500 focus:bg-white transition">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                {{-- Nama --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1.5">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                           required autofocus placeholder="Contoh: Paket Premium"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900
                                  placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500/30
                                  focus:border-orange-500 focus:bg-white transition">
                    @error('name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700 mb-1.5">Deskripsi</label>
                    <textarea id="description" name="description" rows="4"
                              placeholder="Jelaskan detail produk atau layanan kamu..."
                              class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900
                                     placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500/30
                                     focus:border-orange-500 focus:bg-white transition resize-none">{{ old('description') }}</textarea>
                    @error('description')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                {{-- Harga --}}
                <div>
                    <label for="price" class="block text-sm font-medium text-slate-700 mb-1.5">Harga (Rp) <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm text-slate-400 font-medium">Rp</span>
                        <input type="number" id="price" name="price" value="{{ old('price') }}"
                               step="1000" min="0" required placeholder="0"
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900
                                      placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500/30
                                      focus:border-orange-500 focus:bg-white transition">
                    </div>
                    @error('price')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                <div class="pt-2 flex items-center gap-3">
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-6 py-2.5 bg-orange-500 hover:bg-orange-600
                                   text-white text-sm font-semibold rounded-xl transition shadow-sm shadow-orange-500/20
                                   focus:outline-none focus:ring-2 focus:ring-orange-500/50">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                        Simpan Produk
                    </button>
                    <a href="{{ route('owner.products.index') }}"
                       class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
    function previewImage(input) {
        const file = input.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('imagePreview').src = e.target.result;
            document.getElementById('imagePreview').classList.remove('hidden');
            document.getElementById('imagePlaceholderIcon').classList.add('hidden');
            document.getElementById('imageLabel').textContent = file.name;
            document.getElementById('imagePreviewWrap').classList.remove('border-dashed');
            document.getElementById('imagePreviewWrap').classList.add('border-solid', 'border-orange-300');
        };
        reader.readAsDataURL(file);
    }
    </script>
</x-app-layout>
