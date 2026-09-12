<x-guest-layout>
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm px-6 py-8 sm:px-8">
        <div class="text-center mb-7">
            <h1 class="text-2xl font-bold text-slate-900">Selamat Datang Kembali</h1>
            <p class="text-sm text-slate-500 mt-1">Masuk ke dashboard SnapPhoto Anda</p>
        </div>

        @if (session('status'))
            <div class="mb-5 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       required autofocus autocomplete="username"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900
                              placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500/30
                              focus:border-orange-500 focus:bg-white transition">
                @error('email')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div class="mt-4">
                <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">Password</label>
                <input id="password" type="password" name="password"
                       required autocomplete="current-password"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900
                              placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500/30
                              focus:border-orange-500 focus:bg-white transition">
                @error('password')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-center justify-between mt-4">
                <label class="inline-flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember"
                           class="rounded border-slate-300 text-orange-500 focus:ring-orange-500/30">
                    <span class="text-sm text-slate-600">Ingat saya</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       class="text-sm text-orange-500 hover:text-orange-600 font-medium transition">
                        Lupa password?
                    </a>
                @endif
            </div>

            <button type="submit"
                    class="w-full mt-6 px-4 py-2.5 bg-orange-500 hover:bg-orange-600 active:bg-orange-700
                           text-white text-sm font-semibold rounded-xl transition-colors duration-150
                           shadow-sm shadow-orange-500/25 focus:outline-none focus:ring-2 focus:ring-orange-500/50">
                Masuk
            </button>

            <p class="mt-5 text-center text-sm text-slate-500">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-orange-500 hover:text-orange-600 font-semibold transition">
                    Daftar sekarang
                </a>
            </p>
        </form>
    </div>
</x-guest-layout>
