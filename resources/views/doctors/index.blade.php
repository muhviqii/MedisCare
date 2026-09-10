<x-layouts.app title="Data Dokter">
    <form method="GET" class="flex flex-wrap gap-2 mb-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama dokter..."
               class="flex-1 min-w-[150px] rounded-xl border-slate-300 text-sm py-2.5 px-4">
        <select name="specialty_id" class="rounded-xl border-slate-300 text-sm py-2.5 px-4">
            <option value="">Semua Spesialisasi</option>
            @foreach ($specialties as $specialty)
                <option value="{{ $specialty->id }}" @selected(request('specialty_id') == $specialty->id)>{{ $specialty->name }}</option>
            @endforeach
        </select>
        <button class="px-4 py-2.5 bg-slate-800 text-white rounded-xl text-sm">Filter</button>
        @can('create', \App\Models\Doctor::class)
            <a href="{{ route('doctors.create') }}" class="px-4 py-2.5 bg-teal-600 text-white rounded-xl text-sm font-medium">+ Tambah Dokter</a>
        @endcan
    </form>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse ($doctors as $doctor)
            <a href="{{ route('doctors.show', $doctor) }}" class="bg-white rounded-2xl shadow-sm p-4 flex gap-3 items-start">
                <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center font-semibold">
                    {{ strtoupper(substr($doctor->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-slate-800 truncate">{{ $doctor->name }}</p>
                    <p class="text-xs text-slate-500">{{ $doctor->specialty?->name }} &middot; {{ $doctor->polyclinic?->name }}</p>
                    <span class="inline-block mt-1 text-xs px-2 py-0.5 rounded-full
                        {{ match($doctor->status) { 'active' => 'bg-teal-50 text-teal-700', 'on_leave' => 'bg-amber-50 text-amber-700', default => 'bg-slate-100 text-slate-500' } }}">
                        {{ match($doctor->status) { 'active' => 'Aktif', 'on_leave' => 'Cuti', default => 'Nonaktif' } }}
                    </span>
                </div>
            </a>
        @empty
            <p class="text-sm text-slate-400 col-span-full text-center py-8">Belum ada data dokter.</p>
        @endforelse
    </div>

    <div class="mt-4">{{ $doctors->links() }}</div>
</x-layouts.app>
