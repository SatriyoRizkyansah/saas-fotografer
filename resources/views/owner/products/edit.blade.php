<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-slate-900">{{ __('Edit Produk') }}</h2>
    </x-slot>

    <div>
            <div class="bg-white rounded-xl border border-slate-100 p-5 sm:p-6">
                <form action="{{ route('owner.products.update', $product) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-5">
                        <x-input-label for="category_id" :value="__('Kategori')" class="block text-sm font-medium text-slate-700 mb-1" />
                        <select id="category_id" name="category_id" class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-lg text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition" required>
                            <option value="">Pilih Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>

                    <div class="mb-5">
                        <x-input-label for="name" :value="__('Nama Produk')" class="block text-sm font-medium text-slate-700 mb-1" />
                        <x-text-input id="name" name="name" type="text" class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-lg text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition" :value="old('name', $product->name)" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mb-5">
                        <x-input-label for="description" :value="__('Deskripsi')" class="block text-sm font-medium text-slate-700 mb-1" />
                        <textarea id="description" name="description" rows="4" class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-lg text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition">{{ old('description', $product->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="mb-5">
                        <x-input-label for="price" :value="__('Harga (Rp)')" class="block text-sm font-medium text-slate-700 mb-1" />
                        <x-text-input id="price" name="price" type="number" step="0.01" min="0" class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-lg text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition" :value="old('price', $product->price)" required />
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-3">
                        <x-primary-button>{{ __('Update') }}</x-primary-button>
                        <a href="{{ route('owner.products.index') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 text-sm font-semibold rounded-lg hover:bg-slate-50 transition">Batal</a>
                    </div>
                </form>
            </div>
    </div>
</x-app-layout>
