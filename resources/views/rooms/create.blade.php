<x-layouts.app title="Tambah Ruangan">
    <div class="max-w-lg mx-auto bg-white rounded-2xl shadow-sm p-5">
        <h2 class="font-semibold text-slate-800 mb-4">Tambah Ruangan &amp; Bed</h2>
        <form method="POST" action="{{ route('rooms.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Gedung <span class="text-red-500">*</span></label>
                <input type="text" name="building" required class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Lantai <span class="text-red-500">*</span></label>
                    <input type="text" name="floor" required class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">No. Ruangan <span class="text-red-500">*</span></label>
                    <input type="text" name="room_number" required class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Kelas Kamar <span class="text-red-500">*</span></label>
                <select name="room_class" required class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                    @foreach (['vip' => 'VIP', 'class_1' => 'Kelas 1', 'class_2' => 'Kelas 2', 'class_3' => 'Kelas 3', 'icu' => 'ICU', 'isolation' => 'Isolasi'] as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Tarif per Hari (Rp) <span class="text-red-500">*</span></label>
                <input type="number" name="daily_rate" required min="0" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Jumlah Bed <span class="text-red-500">*</span></label>
                <input type="number" name="bed_count" required min="1" max="20" value="1" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
            </div>
            <button type="submit" class="w-full bg-teal-600 text-white rounded-xl py-3 text-sm font-medium hover:bg-teal-700">
                Simpan
            </button>
        </form>
    </div>
</x-layouts.app>
