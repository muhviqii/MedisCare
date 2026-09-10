<x-layouts.app :title="$doctor->name">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h2 class="font-semibold text-slate-800 text-lg">{{ $doctor->name }}</h2>
            <p class="text-xs text-slate-500">{{ $doctor->doctor_code }} &middot; {{ $doctor->specialty?->name }} &middot; {{ $doctor->polyclinic?->name }}</p>
        </div>
        @can('update', $doctor)
            <a href="{{ route('doctors.edit', $doctor) }}" class="px-4 py-2 bg-slate-800 text-white rounded-xl text-sm">Edit</a>
        @endcan
    </div>

    <div class="grid md:grid-cols-2 gap-4">
        <div class="bg-white rounded-2xl shadow-sm p-4">
            <h3 class="text-sm font-semibold text-slate-700 mb-3">Informasi</h3>
            <dl class="grid grid-cols-2 gap-y-2 text-sm">
                <dt class="text-slate-400">NIP</dt><dd>{{ $doctor->nip ?: '-' }}</dd>
                <dt class="text-slate-400">STR</dt><dd>{{ $doctor->str_number ?: '-' }}</dd>
                <dt class="text-slate-400">SIP</dt><dd>{{ $doctor->sip_number ?: '-' }}</dd>
                <dt class="text-slate-400">Email</dt><dd>{{ $doctor->email ?: '-' }}</dd>
                <dt class="text-slate-400">Telepon</dt><dd>{{ $doctor->phone ?: '-' }}</dd>
            </dl>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-4">
            <h3 class="text-sm font-semibold text-slate-700 mb-3">Jadwal Mendatang</h3>
            @forelse ($doctor->schedules as $schedule)
                <div class="flex items-center justify-between py-2 border-b last:border-0 border-slate-100 text-sm">
                    <span>{{ \Illuminate\Support\Carbon::parse($schedule->schedule_date)->translatedFormat('d M Y') }} &middot; {{ $schedule->start_time }}-{{ $schedule->end_time }}</span>
                    <span class="text-xs text-slate-500">{{ ucfirst($schedule->status) }}</span>
                </div>
            @empty
                <p class="text-sm text-slate-400">Belum ada jadwal mendatang.</p>
            @endforelse
        </div>
    </div>
</x-layouts.app>
