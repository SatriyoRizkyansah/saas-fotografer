<x-guest-layout>
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm px-6 py-8 sm:px-8">
        <div class="text-center mb-7">
            <h1 class="text-2xl font-bold text-slate-900">Reset Password</h1>
            <p class="text-sm text-slate-500 mt-1">Buat password baru untuk akun kamu.</p>
        </div>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}"
                       required autofocus autocomplete="username"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900
                              placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500/30
                              focus:border-orange-500 focus:bg-white transition">
                @error('email')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div class="mt-4">
                <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">Password Baru</label>
                <input id="password" type="password" name="password"
                       required autocomplete="new-password"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900
                              placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500/30
                              focus:border-orange-500 focus:bg-white transition">
                @error('password')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div class="mt-4">
                <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1.5">Konfirmasi Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation"
                       required autocomplete="new-password"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900
                              placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500/30
                              focus:border-orange-500 focus:bg-white transition">
                @error('password_confirmation')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <button type="submit"
                    class="w-full mt-6 px-4 py-2.5 bg-orange-500 hover:bg-orange-600 active:bg-orange-700
                           text-white text-sm font-semibold rounded-xl transition-colors duration-150
                           shadow-sm shadow-orange-500/25 focus:outline-none focus:ring-2 focus:ring-orange-500/50">
                Reset Password
            </button>
        </form>
    </div>
</x-guest-layout>
