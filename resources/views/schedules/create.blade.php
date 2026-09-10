<x-layouts.app title="Tambah Jadwal Dokter">
    <div class="max-w-xl mx-auto bg-white rounded-2xl shadow-sm p-5">
        <h2 class="font-semibold text-slate-800 mb-4">Tambah Jadwal Dokter</h2>

        @if (session('conflicts'))
            <div class="mb-4 rounded-xl bg-amber-50 text-amber-800 text-sm px-4 py-3">
                <p class="font-medium mb-1">⚠ Jadwal bertabrakan terdeteksi:</p>
                <ul class="list-disc list-inside">
                    @foreach (session('conflicts') as $conflict)
                        <li>{{ $conflict->start_time }}-{{ $conflict->end_time }} ({{ ucfirst($conflict->status) }})</li>
                    @endforeach
                </ul>
                <label class="flex items-center gap-2 mt-2">
                    <input type="checkbox" form="schedule-form" name="force" value="1" class="rounded border-amber-400">
                    Tetap simpan meskipun bertabrakan
                </label>
            </div>
        @endif

        <form method="POST" action="{{ route('schedules.store') }}" id="schedule-form" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Dokter <span class="text-red-500">*</span></label>
                <select name="doctor_id" required class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                    <option value="">-- Pilih Dokter --</option>
                    @foreach ($doctors as $doctor)
                        <option value="{{ $doctor->id }}" @selected(old('doctor_id') == $doctor->id)>{{ $doctor->name }}</option>
                    @endforeach
                </select>
                @error('doctor_id') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal <span class="text-red-500">*</span></label>
                <input type="date" name="schedule_date" value="{{ old('schedule_date') }}" required
                       class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                @error('schedule_date') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Jam Mulai <span class="text-red-500">*</span></label>
                    <input type="time" name="start_time" value="{{ old('start_time') }}" required
                           class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Jam Selesai <span class="text-red-500">*</span></label>
                    <input type="time" name="end_time" value="{{ old('end_time') }}" required
                           class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                </div>
            </div>
            @error('end_time') <p class="text-red-600 text-xs -mt-2">{{ $message }}</p> @enderror
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Ruangan</label>
                <input type="text" name="room" value="{{ old('room') }}" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Status <span class="text-red-500">*</span></label>
                <select name="status" required class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                    @foreach (['available' => 'Tersedia', 'on_leave' => 'Cuti', 'holiday' => 'Libur', 'cancelled' => 'Dibatalkan'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('status', 'available') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="w-full bg-teal-600 text-white rounded-xl py-3 text-sm font-medium hover:bg-teal-700">
                Simpan Jadwal
            </button>
        </form>
    </div>
</x-layouts.app>
