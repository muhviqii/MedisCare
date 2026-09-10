<x-layouts.guest title="Login">
    <h2 class="text-lg font-semibold text-slate-800 mb-4">Masuk ke Akun Anda</h2>

    @if (session('status'))
        <div class="mb-4 rounded-xl bg-teal-50 text-teal-800 text-sm px-4 py-3">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
            @error('email') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Kata Sandi</label>
            <input type="password" name="password" required
                   class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
        </div>
        <div class="flex items-center justify-between text-sm">
            <label class="flex items-center gap-2">
                <input type="checkbox" name="remember" class="rounded border-slate-300 text-teal-600">
                Ingat saya
            </label>
            <a href="{{ route('password.request') }}" class="text-teal-700">Lupa kata sandi?</a>
        </div>
        <button type="submit" class="w-full bg-teal-600 text-white rounded-xl py-3 text-sm font-medium hover:bg-teal-700 active:scale-[0.99] transition">
            Masuk
        </button>
    </form>
</x-layouts.guest>
