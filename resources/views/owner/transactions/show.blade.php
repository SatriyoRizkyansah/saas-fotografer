@php
use Illuminate\Support\Facades\Storage;
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Transaksi') }}
            </h2>
            <a href="{{ route('owner.transactions.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">← Kembali ke Daftar Transaksi</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Customer Info --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Customer</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nama</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $transaction->customer_name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $transaction->customer_email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">WhatsApp</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $transaction->customer_phone }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1">
                                @if ($transaction->status === 'pending')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                @elseif ($transaction->status === 'valid')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Valid</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            {{-- Product Info --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Produk</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Produk</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $transaction->product->name ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Harga</dt>
                            <dd class="mt-1 text-sm text-gray-900">Rp {{ number_format($transaction->product->price ?? 0, 0, ',', '.') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tanggal</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $transaction->created_at->format('d/m/Y H:i') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            {{-- Payment Proof --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Bukti Transfer</h3>
                    <div class="flex justify-center">
                        <img src="{{ Storage::url($transaction->payment_proof) }}" alt="Bukti Transfer" class="max-w-full h-auto rounded-lg border border-gray-200 shadow-sm max-h-96 object-contain">
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            @if ($transaction->status === 'pending')
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Validasi Transaksi</h3>
                        <div class="flex gap-4">
                            <form action="{{ route('owner.transactions.update-status', $transaction) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="valid">
                                <button type="submit" class="inline-flex items-center px-6 py-3 bg-green-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150" onclick="return confirm('Yakin ingin memvalidasi transaksi ini?')">
                                    <svg class="w-5 h-5 me-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Valid
                                </button>
                            </form>
                            <form action="{{ route('owner.transactions.update-status', $transaction) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="inline-flex items-center px-6 py-3 bg-red-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150" onclick="return confirm('Yakin ingin menolak transaksi ini?')">
                                    <svg class="w-5 h-5 me-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Tolak
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
