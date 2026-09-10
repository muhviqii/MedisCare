<x-layouts.app title="Kamar & Bed">
    {{-- Dashboard visual status bed (Bagian 15) --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
        <div class="bg-white rounded-2xl shadow-sm p-4 text-center">
            <p class="text-2xl">🟢</p>
            <p class="text-xl font-bold text-slate-800">{{ $summary['available'] ?? 0 }}</p>
            <p class="text-xs text-slate-500">Tersedia</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-4 text-center">
            <p class="text-2xl">🔴</p>
            <p class="text-xl font-bold text-slate-800">{{ $summary['occupied'] ?? 0 }}</p>
            <p class="text-xs text-slate-500">Terisi</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-4 text-center">
            <p class="text-2xl">🟡</p>
            <p class="text-xl font-bold text-slate-800">{{ $summary['cleaning'] ?? 0 }}</p>
            <p class="text-xs text-slate-500">Dibersihkan</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-4 text-center">
            <p class="text-2xl">⚫</p>
            <p class="text-xl font-bold text-slate-800">{{ $summary['maintenance'] ?? 0 }}</p>
            <p class="text-xs text-slate-500">Maintenance</p>
        </div>
    </div>

    <div class="flex justify-end mb-4">
        @can('create', \App\Models\Room::class)
        @endcan
        <a href="{{ route('rooms.create') }}" class="px-4 py-2.5 bg-teal-600 text-white rounded-xl text-sm font-medium">+ Tambah Ruangan</a>
    </div>

    <div class="space-y-3">
        @foreach ($rooms as $room)
            <div class="bg-white rounded-2xl shadow-sm p-4">
                <div class="flex items-center justify-between mb-2">
                    <p class="font-medium text-slate-800">{{ $room->building }} — Lt. {{ $room->floor }} — {{ $room->room_number }}</p>
                    <span class="text-xs px-2 py-0.5 rounded-full bg-slate-100 text-slate-600">{{ strtoupper(str_replace('_', ' ', $room->room_class)) }}</span>
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach ($room->beds as $bed)
                        <form method="POST" action="{{ route('beds.update-status', $bed) }}" class="inline">
                            @csrf
                            <select name="status" onchange="this.form.submit()"
                                    class="text-xs rounded-lg px-2 py-1 border
                                        {{ match($bed->status) { 'available' => 'bg-teal-50 border-teal-200 text-teal-700', 'occupied' => 'bg-red-50 border-red-200 text-red-700', 'cleaning' => 'bg-amber-50 border-amber-200 text-amber-700', default => 'bg-slate-100 border-slate-200 text-slate-500' } }}">
                                @foreach (['available' => 'Tersedia', 'occupied' => 'Terisi', 'cleaning' => 'Dibersihkan', 'maintenance' => 'Maintenance'] as $value => $label)
                                    <option value="{{ $value }}" @selected($bed->status === $value)>Bed {{ $bed->bed_number }} — {{ $label }}</option>
                                @endforeach
                            </select>
                        </form>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">{{ $rooms->links() }}</div>
</x-layouts.app>
