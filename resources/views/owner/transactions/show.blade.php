@php
use Illuminate\Support\Facades\Storage;
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-slate-900">{{ __('Detail Transaksi') }}</h2>
            <a href="{{ route('owner.transactions.index') }}" class="text-sm text-slate-500 hover:text-slate-700 font-medium transition">← Kembali ke Daftar Transaksi</a>
        </div>
    </x-slot>

    <div class="p-4 sm:p-6 lg:p-8">
        <div class="max-w-5xl mx-auto space-y-6">
            {{-- Customer Info --}}
            <div class="bg-white rounded-xl border border-slate-100 p-5 sm:p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Informasi Customer</h3>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Nama</dt>
                        <dd class="mt-1 text-sm text-slate-900 font-medium">{{ $transaction->customer_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Email</dt>
                        <dd class="mt-1 text-sm text-slate-900">{{ $transaction->customer_email }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-slate-500">WhatsApp</dt>
                        <dd class="mt-1 text-sm text-slate-900">{{ $transaction->customer_phone }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Status</dt>
                        <dd class="mt-1">
                            @if ($transaction->status === 'pending')
                                <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-lg bg-amber-50 text-amber-700 border border-amber-200">Pending</span>
                            @elseif ($transaction->status === 'valid')
                                <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200">Valid</span>
                            @else
                                <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-lg bg-red-50 text-red-700 border border-red-200">Ditolak</span>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>

            {{-- Product Info --}}
            <div class="bg-white rounded-xl border border-slate-100 p-5 sm:p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Informasi Produk</h3>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Produk</dt>
                        <dd class="mt-1 text-sm text-slate-900 font-medium">{{ $transaction->product->name ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Harga</dt>
                        <dd class="mt-1 text-sm text-slate-900 font-semibold">Rp {{ number_format($transaction->product->price ?? 0, 0, ',', '.') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Tanggal</dt>
                        <dd class="mt-1 text-sm text-slate-900">{{ $transaction->created_at->format('d/m/Y H:i') }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Payment Proof --}}
            <div class="bg-white rounded-xl border border-slate-100 p-5 sm:p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Bukti Transfer</h3>
                <div class="flex justify-center">
                    <img src="{{ Storage::url($transaction->payment_proof) }}" alt="Bukti Transfer" class="max-w-full h-auto rounded-xl border border-slate-200 shadow-sm max-h-96 object-contain">
                </div>
            </div>

            {{-- Action Buttons --}}
            @if ($transaction->status === 'pending')
                <div class="bg-white rounded-xl border border-slate-100 p-5 sm:p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Validasi Transaksi</h3>
                    <div class="flex flex-wrap gap-3">
                        <form action="{{ route('owner.transactions.update-status', $transaction) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="valid">
                            <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white text-sm font-semibold rounded-lg hover:shadow-lg hover:shadow-emerald-500/25 transition-all duration-200" onclick="return confirm('Yakin ingin memvalidasi transaksi ini?')">
                                <svg class="w-4 h-4 me-1.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Valid
                            </button>
                        </form>
                        <form action="{{ route('owner.transactions.update-status', $transaction) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-red-500 to-red-600 text-white text-sm font-semibold rounded-lg hover:shadow-lg hover:shadow-red-500/25 transition-all duration-200" onclick="return confirm('Yakin ingin menolak transaksi ini?')">
                                <svg class="w-4 h-4 me-1.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Tolak
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
