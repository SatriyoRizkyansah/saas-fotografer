<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-slate-900">{{ __('Tambah Kategori') }}</h2>
    </x-slot>

    <div class="p-4 sm:p-6 lg:p-8">
        <div class="max-w-5xl mx-auto">
            <div class="bg-white rounded-xl border border-slate-100 p-5 sm:p-6">
                <form action="{{ route('owner.categories.store') }}" method="POST">
                    @csrf

                    <div class="mb-5">
                        <x-input-label for="name" :value="__('Nama Kategori')" class="block text-sm font-medium text-slate-700 mb-1" />
                        <x-text-input id="name" name="name" type="text" class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-lg text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-violet-500/20 focus:border-violet-500 transition" :value="old('name')" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-3">
                        <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                        <a href="{{ route('owner.categories.index') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 text-sm font-semibold rounded-lg hover:bg-slate-50 transition">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
