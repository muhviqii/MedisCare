<x-layouts.guest title="Lupa Kata Sandi">
    <h2 class="text-lg font-semibold text-slate-800 mb-2">Lupa Kata Sandi</h2>
    <p class="text-sm text-slate-500 mb-4">Masukkan email Anda, kami akan mengirimkan tautan untuk membuat kata sandi baru.</p>

    @if (session('status'))
        <div class="mb-4 rounded-xl bg-teal-50 text-teal-800 text-sm px-4 py-3">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
            @error('email') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <button type="submit" class="w-full bg-teal-600 text-white rounded-xl py-3 text-sm font-medium hover:bg-teal-700">
            Kirim Tautan Reset
        </button>
        <a href="{{ route('login') }}" class="block text-center text-sm text-slate-500">Kembali ke login</a>
    </form>
</x-layouts.guest>
