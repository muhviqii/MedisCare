<x-layouts.app title="Data Pasien">
    <div class="flex items-center justify-between mb-4">
        <form method="GET" class="flex-1 flex gap-2 max-w-md">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, NIK, atau no. RM..."
                   class="flex-1 rounded-xl border-slate-300 text-sm py-2.5 px-4 focus:ring-teal-600 focus:border-teal-600">
            <button class="px-4 py-2.5 bg-slate-800 text-white rounded-xl text-sm">Cari</button>
        </form>
        @can('create', \App\Models\Patient::class)
            <a href="{{ route('patients.create') }}" class="ml-3 px-4 py-2.5 bg-teal-600 text-white rounded-xl text-sm font-medium whitespace-nowrap">
                + Tambah Pasien
            </a>
        @endcan
    </div>

    {{-- Mobile: card list. Desktop: table. (Bagian 30 - hindari tabel sulit dipakai di smartphone) --}}
    <div class="md:hidden space-y-3">
        @forelse ($patients as $patient)
            <a href="{{ route('patients.show', $patient) }}" class="block bg-white rounded-2xl shadow-sm p-4">
                <div class="flex items-center justify-between">
                    <p class="font-medium text-slate-800">{{ $patient->full_name }}</p>
                    <span class="text-xs px-2 py-0.5 rounded-full {{ $patient->status === 'active' ? 'bg-teal-50 text-teal-700' : 'bg-slate-100 text-slate-500' }}">
                        {{ $patient->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1">{{ $patient->medical_record_number }} &middot; NIK {{ $patient->nik }}</p>
                <p class="text-xs text-slate-400 mt-1">{{ $patient->phone }}</p>
            </a>
        @empty
            <p class="text-center text-sm text-slate-400 py-8">Belum ada data pasien.</p>
        @endforelse
    </div>

    <div class="hidden md:block bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                <tr>
                    <th class="text-left px-4 py-3">No. RM</th>
                    <th class="text-left px-4 py-3">Nama</th>
                    <th class="text-left px-4 py-3">NIK</th>
                    <th class="text-left px-4 py-3">Telepon</th>
                    <th class="text-left px-4 py-3">Status</th>
                    <th class="text-right px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($patients as $patient)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 text-slate-500">{{ $patient->medical_record_number }}</td>
                        <td class="px-4 py-3 font-medium text-slate-800">{{ $patient->full_name }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ $patient->nik }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ $patient->phone }}</td>
                        <td class="px-4 py-3">
                            <span class="text-xs px-2 py-0.5 rounded-full {{ $patient->status === 'active' ? 'bg-teal-50 text-teal-700' : 'bg-slate-100 text-slate-500' }}">
                                {{ $patient->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('patients.show', $patient) }}" class="text-teal-700 text-sm">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-slate-400 py-8">Belum ada data pasien.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $patients->links() }}</div>
</x-layouts.app>
