<x-layouts.guest title="Reset Kata Sandi">
    <h2 class="text-lg font-semibold text-slate-800 mb-4">Buat Kata Sandi Baru</h2>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $email) }}" required
                   class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
            @error('email') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Kata Sandi Baru</label>
            <input type="password" name="password" required
                   class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
            @error('password') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Kata Sandi</label>
            <input type="password" name="password_confirmation" required
                   class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
        </div>
        <button type="submit" class="w-full bg-teal-600 text-white rounded-xl py-3 text-sm font-medium hover:bg-teal-700">
            Reset Kata Sandi
        </button>
    </form>
</x-layouts.guest>
