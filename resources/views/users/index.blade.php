<x-layouts.app title="Manajemen Pengguna">
    <div class="flex items-center justify-between mb-4 flex-wrap gap-2">
        <form method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama..." class="rounded-xl border-slate-300 text-sm py-2.5 px-4">
            <select name="role_id" class="rounded-xl border-slate-300 text-sm py-2.5 px-4">
                <option value="">Semua Role</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" @selected(request('role_id') == $role->id)>{{ $role->name }}</option>
                @endforeach
            </select>
            <button class="px-4 py-2.5 bg-slate-800 text-white rounded-xl text-sm">Filter</button>
        </form>
        <a href="{{ route('users.create') }}" class="px-4 py-2.5 bg-teal-600 text-white rounded-xl text-sm font-medium">+ Tambah Pengguna</a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                <tr><th class="text-left px-4 py-3">Nama</th><th class="text-left px-4 py-3">Email</th><th class="text-left px-4 py-3">Role</th><th class="text-left px-4 py-3">Status</th><th class="text-right px-4 py-3">Aksi</th></tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($users as $user)
                    <tr>
                        <td class="px-4 py-3 font-medium text-slate-800">{{ $user->name }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ $user->email }}</td>
                        <td class="px-4 py-3">{{ $user->role?->name }}</td>
                        <td class="px-4 py-3">
                            <span class="text-xs px-2 py-0.5 rounded-full {{ $user->is_active ? 'bg-teal-50 text-teal-700' : 'bg-slate-100 text-slate-500' }}">
                                {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('users.edit', $user) }}" class="text-teal-700">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $users->links() }}</div>
</x-layouts.app>
