<x-layouts.app title="Edit Pengguna">
    <div class="max-w-lg mx-auto bg-white rounded-2xl shadow-sm p-5">
        <h2 class="font-semibold text-slate-800 mb-4">Edit Pengguna — {{ $user->name }}</h2>
        <form method="POST" action="{{ route('users.update', $user) }}" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                @error('email') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Role <span class="text-red-500">*</span></label>
                <select name="role_id" required class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" @selected(old('role_id', $user->role_id) == $role->id)>{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                <select name="is_active" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                    <option value="1" @selected($user->is_active)>Aktif</option>
                    <option value="0" @selected(!$user->is_active)>Nonaktif</option>
                </select>
            </div>
            <button type="submit" class="w-full bg-teal-600 text-white rounded-xl py-3 text-sm font-medium hover:bg-teal-700">Simpan Perubahan</button>
        </form>

        <form method="POST" action="{{ route('users.destroy', $user) }}" class="mt-3" onsubmit="return confirm('Nonaktifkan pengguna ini?')">
            @csrf @method('DELETE')
            <button type="submit" class="w-full text-red-600 text-sm py-2">Nonaktifkan Pengguna</button>
        </form>
    </div>
</x-layouts.app>
