<x-layouts.app title="Edit Jadwal Dokter">
    <div class="max-w-xl mx-auto bg-white rounded-2xl shadow-sm p-5">
        <h2 class="font-semibold text-slate-800 mb-4">Edit Jadwal — {{ $schedule->doctor->name }}</h2>

        @if (session('conflicts'))
            <div class="mb-4 rounded-xl bg-amber-50 text-amber-800 text-sm px-4 py-3">
                <p class="font-medium mb-1">⚠ Jadwal bertabrakan terdeteksi.</p>
                <label class="flex items-center gap-2 mt-2">
                    <input type="checkbox" form="schedule-edit-form" name="force" value="1" class="rounded border-amber-400">
                    Tetap simpan meskipun bertabrakan
                </label>
            </div>
        @endif

        <form method="POST" action="{{ route('schedules.update', $schedule) }}" id="schedule-edit-form" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal <span class="text-red-500">*</span></label>
                <input type="date" name="schedule_date" value="{{ old('schedule_date', $schedule->schedule_date->toDateString()) }}" required
                       class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Jam Mulai <span class="text-red-500">*</span></label>
                    <input type="time" name="start_time" value="{{ old('start_time', $schedule->start_time) }}" required
                           class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Jam Selesai <span class="text-red-500">*</span></label>
                    <input type="time" name="end_time" value="{{ old('end_time', $schedule->end_time) }}" required
                           class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                </div>
            </div>
            @error('end_time') <p class="text-red-600 text-xs -mt-2">{{ $message }}</p> @enderror
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Status <span class="text-red-500">*</span></label>
                <select name="status" required class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                    @foreach (['available' => 'Tersedia', 'on_leave' => 'Cuti', 'holiday' => 'Libur', 'cancelled' => 'Dibatalkan'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('status', $schedule->status) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="w-full bg-teal-600 text-white rounded-xl py-3 text-sm font-medium hover:bg-teal-700">
                Simpan Perubahan
            </button>
        </form>

        <form method="POST" action="{{ route('schedules.destroy', $schedule) }}" class="mt-3" onsubmit="return confirm('Hapus jadwal ini?')">
            @csrf @method('DELETE')
            <button type="submit" class="w-full text-red-600 text-sm py-2">Hapus Jadwal</button>
        </form>
    </div>
</x-layouts.app>
