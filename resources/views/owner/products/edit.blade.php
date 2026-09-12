<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-slate-900">Edit Produk</h2>
            <a href="{{ route('owner.products.show', $product) }}"
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
                <p class="text-xs text-slate-500 mt-0.5">Perbarui detail produk kamu.</p>
            </div>

            <form action="{{ route('owner.products.update', $product) }}" method="POST"
                  enctype="multipart/form-data" class="px-6 py-5 space-y-5">
                @csrf
                @method('PUT')

                {{-- Foto Produk --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Foto Produk</label>
                    <div class="flex items-start gap-4">
                        {{-- Preview --}}
                        <div id="imagePreviewWrap"
                             class="w-24 h-24 rounded-xl border-2 flex-shrink-0 overflow-hidden
                                    {{ $product->image ? 'border-solid border-orange-300' : 'border-dashed border-slate-200 bg-slate-50' }}
                                    flex items-center justify-center">
                            @if($product->image)
                                <img id="imagePreview" src="{{ Storage::url($product->image) }}"
                                     alt="{{ $product->name }}" class="w-full h-full object-cover">
                                <svg id="imagePlaceholderIcon" class="w-8 h-8 text-slate-300 hidden" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 001.5-1.5V5.25a1.5 1.5 0 00-1.5-1.5H3.75a1.5 1.5 0 00-1.5 1.5v14.25a1.5 1.5 0 001.5 1.5z"/>
                                </svg>
                            @else
                                <svg id="imagePlaceholderIcon" class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 001.5-1.5V5.25a1.5 1.5 0 00-1.5-1.5H3.75a1.5 1.5 0 00-1.5 1.5v14.25a1.5 1.5 0 001.5 1.5z"/>
                                </svg>
                                <img id="imagePreview" src="" alt="Preview" class="hidden w-full h-full object-cover">
                            @endif
                        </div>

                        <div class="flex-1 space-y-2">
                            <label for="image"
                                   class="flex items-center gap-2 px-4 py-2.5 border border-slate-200 rounded-xl bg-slate-50
                                          hover:bg-orange-50 hover:border-orange-300 cursor-pointer transition text-sm text-slate-600">
                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                                </svg>
                                <span id="imageLabel">{{ $product->image ? 'Ganti foto...' : 'Pilih foto...' }}</span>
                            </label>
                            <input type="file" id="image" name="image" accept="image/jpg,image/jpeg,image/png,image/webp"
                                   class="sr-only" onchange="previewImage(this)">
                            <p class="text-xs text-slate-400">JPG, PNG, WebP — Maks 5MB.</p>

                            {{-- Tombol hapus foto --}}
                            @if($product->image)
                            <label id="removeImageLabel" class="flex items-center gap-2 cursor-pointer select-none group">
                                <input type="checkbox" name="remove_image" value="1" id="remove_image"
                                       class="rounded border-slate-300 text-red-500 focus:ring-red-400/30"
                                       onchange="toggleRemoveImage(this)">
                                <span class="text-xs text-red-500 group-hover:text-red-600">Hapus foto saat ini</span>
                            </label>
                            @endif

                            @error('image')<p class="text-xs text-red-500">{{ $message }}</p>@enderror
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
                            <option value="{{ $category->id }}"
                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                {{-- Nama --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1.5">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}"
                           required autofocus
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900
                                  placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500/30
                                  focus:border-orange-500 focus:bg-white transition">
                    @error('name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700 mb-1.5">Deskripsi</label>
                    <textarea id="description" name="description" rows="4"
                              class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900
                                     placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500/30
                                     focus:border-orange-500 focus:bg-white transition resize-none">{{ old('description', $product->description) }}</textarea>
                    @error('description')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                {{-- Harga --}}
                <div>
                    <label for="price" class="block text-sm font-medium text-slate-700 mb-1.5">Harga (Rp) <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm text-slate-400 font-medium">Rp</span>
                        <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}"
                               step="1000" min="0" required
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
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0120.25 6v12A2.25 2.25 0 0118 20.25H6A2.25 2.25 0 013.75 18V6A2.25 2.25 0 016 3.75h1.5m9 0h-9"/>
                        </svg>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('owner.products.show', $product) }}"
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
            const preview = document.getElementById('imagePreview');
            const icon    = document.getElementById('imagePlaceholderIcon');
            const wrap    = document.getElementById('imagePreviewWrap');
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            icon.classList.add('hidden');
            document.getElementById('imageLabel').textContent = file.name;
            wrap.classList.remove('border-dashed', 'border-slate-200', 'bg-slate-50');
            wrap.classList.add('border-solid', 'border-orange-300');
            // Uncheck remove kalau ada
            const rm = document.getElementById('remove_image');
            if (rm) rm.checked = false;
        };
        reader.readAsDataURL(file);
    }

    function toggleRemoveImage(cb) {
        const wrap    = document.getElementById('imagePreviewWrap');
        const preview = document.getElementById('imagePreview');
        const icon    = document.getElementById('imagePlaceholderIcon');
        if (cb.checked) {
            wrap.classList.add('opacity-40');
            preview.style.filter = 'grayscale(1)';
        } else {
            wrap.classList.remove('opacity-40');
            preview.style.filter = '';
        }
    }
    </script>
</x-app-layout>
