<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-slate-900">{{ __('Produk') }}</h2>
            <a href="{{ route('owner.products.create') }}" class="inline-flex items-center px-5 py-2.5 bg-orange-600 text-white text-sm font-semibold rounded-lg hover:bg-orange-700 transition-all duration-200 shadow-sm hover:shadow">
                <svg class="w-4 h-4 me-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah
            </a>
        </div>
    </x-slot>

    <div class="p-4 sm:p-6 lg:p-8">
        <div class="max-w-5xl mx-auto">
            @if (session('success'))
                <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-xl border border-slate-100 overflow-hidden">
                @if ($products->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-100">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Kategori</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Harga</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($products as $product)
                                    <tr class="hover:bg-slate-50/50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">{{ $product->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $product->category->name ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($product->is_active)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5"></span>Aktif
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                                                    <span class="w-1.5 h-1.5 bg-slate-400 rounded-full mr-1.5"></span>Nonaktif
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-3">
                                            <a href="{{ route('owner.products.show', $product) }}" class="text-orange-600 hover:text-orange-800 transition">Detail</a>
                                            <a href="{{ route('owner.products.edit', $product) }}" class="text-orange-600 hover:text-orange-800 transition">Edit</a>
                                            <form action="{{ route('owner.products.toggle-active', $product) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-amber-600 hover:text-amber-800 transition">
                                                    {{ $product->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                                </button>
                                            </form>
                                            <form action="{{ route('owner.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 transition">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-4 border-t border-slate-100">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="p-6 text-center">
                        <p class="text-slate-400 text-sm py-8">Belum ada produk. <a href="{{ route('owner.products.create') }}" class="text-orange-600 hover:text-orange-800 font-medium hover:underline">Tambah produk baru</a></p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
