<x-layouts.app title="Profil Saya">
    <div class="max-w-lg mx-auto space-y-6">
        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h2 class="font-semibold text-slate-800 mb-4">Informasi Profil</h2>
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PATCH')
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                           class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                    <input type="email" value="{{ $user->email }}" disabled
                           class="w-full rounded-xl border-slate-200 bg-slate-100 text-sm py-3 px-4 text-slate-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nomor Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                           class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Foto Profil</label>
                    <input type="file" name="avatar" accept="image/*" class="w-full text-sm">
                </div>
                <button type="submit" class="w-full bg-teal-600 text-white rounded-xl py-3 text-sm font-medium hover:bg-teal-700">
                    Simpan Perubahan
                </button>
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h2 class="font-semibold text-slate-800 mb-4">Ubah Kata Sandi</h2>
            <form method="POST" action="{{ route('profile.password') }}" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Kata Sandi Saat Ini</label>
                    <input type="password" name="current_password" required
                           class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
                    @error('current_password') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Kata Sandi Baru</label>
                    <input type="password" name="password" required
                           class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
                    @error('password') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Kata Sandi Baru</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
                </div>
                <button type="submit" class="w-full bg-slate-800 text-white rounded-xl py-3 text-sm font-medium hover:bg-slate-900">
                    Ubah Kata Sandi
                </button>
            </form>
        </div>
    </div>
</x-layouts.app>
