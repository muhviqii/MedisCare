<x-layouts.app title="Dashboard Antrean">
    <form method="GET" class="mb-4">
        <select name="polyclinic_id" onchange="this.form.submit()" class="rounded-xl border-slate-300 text-sm py-2.5 px-4">
            <option value="">Semua Poli</option>
            @foreach ($polyclinics as $polyclinic)
                <option value="{{ $polyclinic->id }}" @selected($polyclinicId == $polyclinic->id)>{{ $polyclinic->name }}</option>
            @endforeach
        </select>
    </form>

    <div class="grid md:grid-cols-2 gap-4 mb-6">
        <div class="bg-teal-600 text-white rounded-2xl shadow-sm p-6 text-center">
            <p class="text-xs uppercase tracking-wide opacity-80 mb-1">Nomor Saat Ini</p>
            <p class="text-5xl font-bold">{{ $current->queue_number ?? '-' }}</p>
            <p class="text-sm opacity-80 mt-1">{{ $current?->appointment?->patient?->full_name ?? 'Belum ada panggilan' }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-6 text-center">
            <p class="text-xs uppercase tracking-wide text-slate-400 mb-1">Berikutnya</p>
            <p class="text-5xl font-bold text-slate-700">{{ $waiting->first()->queue_number ?? '-' }}</p>
            <p class="text-sm text-slate-400 mt-1">{{ $waiting->first()?->appointment?->patient?->full_name ?? 'Tidak ada antrean' }}</p>
        </div>
    </div>

    @if ($current)
        <div class="flex gap-2 mb-6">
            <form method="POST" action="{{ route('queue.recall', $current) }}">
                @csrf
                <button class="px-4 py-2.5 bg-slate-800 text-white rounded-xl text-sm">🔁 Panggil Ulang</button>
            </form>
            <form method="POST" action="{{ route('queue.complete', $current) }}">
                @csrf
                <button class="px-4 py-2.5 bg-teal-600 text-white rounded-xl text-sm">✓ Selesaikan</button>
            </form>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm p-4">
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-sm font-semibold text-slate-700">Daftar Menunggu ({{ $waiting->count() }})</h3>
            <span class="text-xs text-slate-400">{{ $completedCount }} selesai hari ini</span>
        </div>
        <div class="space-y-2">
            @forelse ($waiting as $queue)
                <div class="flex items-center justify-between border-b last:border-0 border-slate-100 py-2 text-sm">
                    <div>
                        <span class="font-semibold text-teal-700">{{ $queue->queue_number }}</span>
                        <span class="text-slate-600 ml-2">{{ $queue->appointment->patient->full_name }}</span>
                    </div>
                    <div class="flex gap-2">
                        <form method="POST" action="{{ route('queue.call', $queue) }}">
                            @csrf
                            <button class="px-3 py-1.5 bg-teal-600 text-white rounded-lg text-xs">Panggil</button>
                        </form>
                        <form method="POST" action="{{ route('queue.skip', $queue) }}">
                            @csrf
                            <button class="px-3 py-1.5 bg-slate-100 text-slate-600 rounded-lg text-xs">Lewati</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-sm text-slate-400 text-center py-6">Tidak ada antrean menunggu.</p>
            @endforelse
        </div>
    </div>
</x-layouts.app>
