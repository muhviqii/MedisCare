<x-layouts.app title="Jadwal Dokter">
    <div class="flex flex-wrap items-center gap-2 mb-4">
        <div class="flex bg-white rounded-xl shadow-sm p-1 text-sm">
            @foreach (['daily' => 'Harian', 'weekly' => 'Mingguan', 'monthly' => 'Bulanan'] as $key => $label)
                <a href="{{ route('schedules.index', ['view' => $key]) }}"
                   class="px-3 py-1.5 rounded-lg {{ $view === $key ? 'bg-teal-600 text-white' : 'text-slate-500' }}">{{ $label }}</a>
            @endforeach
        </div>
        <select onchange="location.href='{{ route('schedules.index') }}?view={{ $view }}&doctor_id='+this.value"
                class="rounded-xl border-slate-300 text-sm py-2 px-3">
            <option value="">Semua Dokter</option>
            @foreach ($doctors as $doctor)
                <option value="{{ $doctor->id }}" @selected(request('doctor_id') == $doctor->id)>{{ $doctor->name }}</option>
            @endforeach
        </select>
        @can('create', \App\Models\DoctorSchedule::class)
        @endcan
        <a href="{{ route('schedules.create') }}" class="ml-auto px-4 py-2 bg-teal-600 text-white rounded-xl text-sm font-medium">+ Tambah Jadwal</a>
    </div>

    <p class="text-xs text-slate-500 mb-3">{{ $start->translatedFormat('d M Y') }} &ndash; {{ $end->translatedFormat('d M Y') }}</p>

    <div class="space-y-4">
        @forelse ($schedules as $date => $daySchedules)
            <div class="bg-white rounded-2xl shadow-sm p-4">
                <h3 class="text-sm font-semibold text-slate-700 mb-2">{{ \Illuminate\Support\Carbon::parse($date)->translatedFormat('l, d F Y') }}</h3>
                <div class="space-y-2">
                    @foreach ($daySchedules as $schedule)
                        <div class="flex items-center justify-between text-sm py-2 border-b last:border-0 border-slate-100">
                            <div>
                                <p class="font-medium text-slate-800">{{ $schedule->doctor->name }}</p>
                                <p class="text-xs text-slate-500">{{ $schedule->start_time }}-{{ $schedule->end_time }} &middot; {{ $schedule->polyclinic?->name ?? $schedule->doctor->polyclinic?->name }}</p>
                            </div>
                            <span class="text-xs px-2 py-0.5 rounded-full
                                {{ match($schedule->status) { 'available' => 'bg-teal-50 text-teal-700', 'on_leave' => 'bg-amber-50 text-amber-700', 'cancelled' => 'bg-red-50 text-red-700', default => 'bg-slate-100 text-slate-500' } }}">
                                {{ match($schedule->status) { 'available' => 'Tersedia', 'on_leave' => 'Cuti', 'holiday' => 'Libur', 'cancelled' => 'Dibatalkan', default => $schedule->status } }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <p class="text-sm text-slate-400 text-center py-8">Tidak ada jadwal pada rentang ini.</p>
        @endforelse
    </div>
</x-layouts.app>
