<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-slate-900">Metode Pembayaran</h2>
    </x-slot>

    <div class="space-y-6">

        @if(session('success'))
            <div class="flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Add Form --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100">
                <h3 class="text-sm font-semibold text-slate-900">Tambah Metode Pembayaran</h3>
                <p class="text-xs text-slate-500 mt-0.5">Tambahkan rekening bank atau dompet digital yang akan ditampilkan ke pelanggan.</p>
            </div>
            <form action="{{ route('owner.payment-methods.store') }}" method="POST" class="px-6 py-5">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Jenis <span class="text-red-500">*</span></label>
                        <select name="type" required
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900
                                       focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-500 focus:bg-white transition">
                            <option value="">Pilih jenis...</option>
                            <option value="bank">Bank Transfer</option>
                            <option value="gopay">GoPay</option>
                            <option value="ovo">OVO</option>
                            <option value="dana">DANA</option>
                            <option value="shopeepay">ShopeePay</option>
                            <option value="qris">QRIS</option>
                            <option value="other">Lainnya</option>
                        </select>
                        @error('type')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Bank / Provider <span class="text-red-500">*</span></label>
                        <input type="text" name="bank_name" value="{{ old('bank_name') }}" placeholder="BCA, Mandiri, GoPay..."
                               required
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900
                                      placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500/30
                                      focus:border-orange-500 focus:bg-white transition">
                        @error('bank_name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Nomor Rekening / Akun <span class="text-red-500">*</span></label>
                        <input type="text" name="account_number" value="{{ old('account_number') }}" placeholder="081234567890"
                               required
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 font-mono
                                      placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500/30
                                      focus:border-orange-500 focus:bg-white transition">
                        @error('account_number')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Atas Nama <span class="text-red-500">*</span></label>
                        <input type="text" name="account_name" value="{{ old('account_name') }}" placeholder="Nama pemilik rekening"
                               required
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900
                                      placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500/30
                                      focus:border-orange-500 focus:bg-white transition">
                        @error('account_name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="mt-4 flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" name="is_default" value="1"
                               class="rounded border-slate-300 text-orange-500 focus:ring-orange-500/30">
                        <span class="text-sm text-slate-600">Jadikan metode utama</span>
                    </label>
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-orange-500 hover:bg-orange-600 text-white
                                   text-sm font-semibold rounded-xl transition shadow-sm shadow-orange-500/20
                                   focus:outline-none focus:ring-2 focus:ring-orange-500/50">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                        Tambah
                    </button>
                </div>
            </form>
        </div>

        {{-- List --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100">
                <h3 class="text-sm font-semibold text-slate-900">Daftar Metode Pembayaran</h3>
                <p class="text-xs text-slate-500 mt-0.5">{{ $methods->count() }} metode terdaftar</p>
            </div>

            @forelse($methods as $method)
            <div class="px-6 py-4 border-b border-slate-100 last:border-0 flex items-center gap-4"
                 x-data="{ editing: false }">

                {{-- Type badge --}}
                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0
                            {{ $method->type === 'bank' ? 'bg-blue-100 text-blue-700' :
                               ($method->type === 'gopay' ? 'bg-emerald-100 text-emerald-700' :
                               ($method->type === 'ovo' ? 'bg-violet-100 text-violet-700' :
                               ($method->type === 'dana' ? 'bg-sky-100 text-sky-700' :
                               ($method->type === 'qris' ? 'bg-orange-100 text-orange-700' : 'bg-slate-100 text-slate-600')))) }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/>
                    </svg>
                </div>

                {{-- Info --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 flex-wrap">
                        <p class="text-sm font-semibold text-slate-900">{{ $method->bank_name }}</p>
                        @if($method->is_default)
                            <span class="px-2 py-0.5 text-[10px] font-bold bg-orange-100 text-orange-700 rounded-full uppercase tracking-wide">Utama</span>
                        @endif
                        @if(!$method->is_active)
                            <span class="px-2 py-0.5 text-[10px] font-bold bg-slate-100 text-slate-500 rounded-full uppercase tracking-wide">Nonaktif</span>
                        @endif
                    </div>
                    <p class="text-xs text-slate-500 mt-0.5 font-mono">{{ $method->account_number }} &mdash; {{ $method->account_name }}</p>
                    <p class="text-xs text-slate-400 capitalize">{{ $method->type }}</p>
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-1.5 flex-shrink-0">
                    {{-- Set default --}}
                    @unless($method->is_default)
                    <form method="POST" action="{{ route('owner.payment-methods.default', $method) }}">
                        @csrf @method('PATCH')
                        <button type="submit" title="Jadikan utama"
                                class="p-2 text-slate-400 hover:text-orange-500 hover:bg-orange-50 rounded-lg transition">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.562.562 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/>
                            </svg>
                        </button>
                    </form>
                    @endunless

                    {{-- Toggle active --}}
                    <form method="POST" action="{{ route('owner.payment-methods.toggle', $method) }}">
                        @csrf @method('PATCH')
                        <button type="submit" title="{{ $method->is_active ? 'Nonaktifkan' : 'Aktifkan' }}"
                                class="p-2 rounded-lg transition {{ $method->is_active ? 'text-slate-400 hover:text-slate-600 hover:bg-slate-100' : 'text-emerald-500 hover:bg-emerald-50' }}">
                            @if($method->is_active)
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                            </svg>
                            @else
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            @endif
                        </button>
                    </form>

                    {{-- Edit (inline) --}}
                    <button onclick="openEdit({{ $method->id }}, '{{ addslashes($method->type) }}', '{{ addslashes($method->bank_name) }}', '{{ addslashes($method->account_number) }}', '{{ addslashes($method->account_name) }}', {{ $method->is_default ? 'true' : 'false' }})"
                            class="p-2 text-slate-400 hover:text-orange-500 hover:bg-orange-50 rounded-lg transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                        </svg>
                    </button>

                    {{-- Delete --}}
                    <form method="POST" action="{{ route('owner.payment-methods.destroy', $method) }}"
                          onsubmit="return confirm('Hapus metode pembayaran ini?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="px-6 py-12 text-center">
                <div class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                    <svg class="w-7 h-7 text-slate-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/>
                    </svg>
                </div>
                <p class="text-sm font-medium text-slate-500">Belum ada metode pembayaran</p>
                <p class="text-xs text-slate-400 mt-1">Tambahkan rekening atau dompet digital di atas.</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Edit Modal --}}
    <div id="editModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeEdit()"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <h3 class="text-sm font-semibold text-slate-900">Edit Metode Pembayaran</h3>
                <button onclick="closeEdit()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg hover:bg-slate-100 transition">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <form id="editForm" method="POST" class="px-6 py-5">
                @csrf @method('PUT')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Jenis</label>
                        <select name="type" id="edit_type" required
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900
                                       focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-500 focus:bg-white transition">
                            <option value="bank">Bank Transfer</option>
                            <option value="gopay">GoPay</option>
                            <option value="ovo">OVO</option>
                            <option value="dana">DANA</option>
                            <option value="shopeepay">ShopeePay</option>
                            <option value="qris">QRIS</option>
                            <option value="other">Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Bank / Provider</label>
                        <input type="text" name="bank_name" id="edit_bank_name" required
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900
                                      focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-500 focus:bg-white transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Nomor Rekening / Akun</label>
                        <input type="text" name="account_number" id="edit_account_number" required
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 font-mono
                                      focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-500 focus:bg-white transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Atas Nama</label>
                        <input type="text" name="account_name" id="edit_account_name" required
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900
                                      focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-500 focus:bg-white transition">
                    </div>
                </div>
                <div class="mt-4 flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" name="is_default" id="edit_is_default" value="1"
                               class="rounded border-slate-300 text-orange-500 focus:ring-orange-500/30">
                        <span class="text-sm text-slate-600">Jadikan metode utama</span>
                    </label>
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-orange-500 hover:bg-orange-600 text-white
                                   text-sm font-semibold rounded-xl transition shadow-sm shadow-orange-500/20">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function openEdit(id, type, bankName, accountNumber, accountName, isDefault) {
        const form = document.getElementById('editForm');
        form.action = `/owner/payment-methods/${id}`;
        document.getElementById('edit_type').value = type;
        document.getElementById('edit_bank_name').value = bankName;
        document.getElementById('edit_account_number').value = accountNumber;
        document.getElementById('edit_account_name').value = accountName;
        document.getElementById('edit_is_default').checked = isDefault;
        document.getElementById('editModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function closeEdit() {
        document.getElementById('editModal').classList.add('hidden');
        document.body.style.overflow = '';
    }
    </script>
</x-app-layout>
