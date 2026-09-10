<x-layouts.app title="Tambah Pengguna">
    <div class="max-w-lg mx-auto bg-white rounded-2xl shadow-sm p-5">
        <h2 class="font-semibold text-slate-800 mb-4">Tambah Pengguna</h2>
        <form method="POST" action="{{ route('users.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama <span class="text-red-500">*</span></label>
                <input type="text" name="name" required class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" required class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                @error('email') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Role <span class="text-red-500">*</span></label>
                <select name="role_id" required class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                    <option value="">-- Pilih Role --</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Kata Sandi <span class="text-red-500">*</span></label>
                <input type="password" name="password" required class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                @error('password') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Kata Sandi <span class="text-red-500">*</span></label>
                <input type="password" name="password_confirmation" required class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
            </div>
            <button type="submit" class="w-full bg-teal-600 text-white rounded-xl py-3 text-sm font-medium hover:bg-teal-700">Simpan</button>
        </form>
    </div>
</x-layouts.app>
