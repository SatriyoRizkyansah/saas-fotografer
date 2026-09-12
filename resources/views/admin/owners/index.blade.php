@extends('layouts.admin')

@section('content')
<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
        <h1 class="text-2xl font-bold text-slate-900 mb-4 sm:mb-0">Manajemen Owner</h1>
        
        {{-- Search --}}
        <form method="GET" action="{{ route('admin.owners.index') }}" class="flex gap-2">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama atau email..." 
                   class="border border-slate-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none w-full sm:w-64">
            <button type="submit" class="bg-slate-900 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-slate-800 transition">
                Cari
            </button>
        </form>
    </div>

    {{-- Owners Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Owner</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status Langganan</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Berlaku Hingga</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal Daftar</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-100">
                    @forelse($owners as $owner)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center text-orange-700 font-bold text-sm flex-shrink-0">
                                    {{ substr($owner->name, 0, 1) }}
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-semibold text-slate-900">{{ $owner->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $owner->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($owner->subscription_status)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5"></span>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                                    <span class="w-1.5 h-1.5 bg-amber-500 rounded-full mr-1.5"></span>
                                    {{ $owner->subscription_status === false ? 'Nonaktif' : 'Belum Ditetapkan' }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                            {{ $owner->subscription_valid_until ? \Carbon\Carbon::parse($owner->subscription_valid_until)->format('d M Y') : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                            {{ $owner->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                            <div class="flex items-center justify-end gap-2">
                                {{-- Toggle Subscription --}}
                                <form method="POST" action="{{ route('admin.owners.toggle-subscription', $owner->id) }}" class="inline">
                                    @csrf
                                    <button type="submit" 
                                        class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ $owner->subscription_status ? 'bg-red-50 text-red-700 hover:bg-red-100' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' }}">
                                        {{ $owner->subscription_status ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>
                                {{-- Set Expiration --}}
                                <form method="POST" action="{{ route('admin.owners.set-expiration', $owner->id) }}" class="inline" id="exp-form-{{ $owner->id }}">
                                    @csrf
                                    <input type="date" name="valid_until" min="{{ date('Y-m-d', strtotime('+1 day')) }}" 
                                           class="border border-slate-300 rounded-lg px-2 py-1.5 text-xs focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none"
                                           onchange="if(this.value) this.form.submit()">
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                            <p class="text-sm text-slate-500">Tidak ada owner yang ditemukan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Pagination --}}
        @if($owners->hasPages())
        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
            {{ $owners->withQueryString()->links('pagination::tailwind') }}
        </div>
        @endif
    </div>
</div>
@endsection
