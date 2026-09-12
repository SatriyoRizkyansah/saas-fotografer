<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-slate-900">{{ __('Transaksi') }}</h2>
    </x-slot>

    <div>
            @if (session('success'))
                <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-xl border border-slate-100 overflow-hidden">
                @if ($transactions->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-100">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Customer</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Produk</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($transactions as $transaction)
                                    <tr class="hover:bg-slate-50/50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ ($transactions->currentPage() - 1) * $transactions->perPage() + $loop->iteration }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">{{ $transaction->customer_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $transaction->product->name ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($transaction->status === 'pending')
                                                <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-lg bg-amber-50 text-amber-700 border border-amber-200">Pending</span>
                                            @elseif ($transaction->status === 'valid')
                                                <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200">Valid</span>
                                            @else
                                                <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-lg bg-red-50 text-red-700 border border-red-200">Ditolak</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('owner.transactions.show', $transaction) }}" class="text-orange-600 hover:text-orange-800 transition">Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-4 border-t border-slate-100">
                        {{ $transactions->links() }}
                    </div>
                @else
                    <div class="p-6 text-center">
                        <p class="text-slate-400 text-sm py-8">Belum ada transaksi masuk.</p>
                    </div>
                @endif
            </div>
    </div>
</x-app-layout>
