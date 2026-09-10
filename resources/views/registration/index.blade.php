<x-layouts.app title="Pendaftaran">
    <div class="flex items-center justify-between mb-4">
        <form method="GET" class="flex gap-2">
            <input type="date" name="date" value="{{ request('date', now()->toDateString()) }}"
                   class="rounded-xl border-slate-300 text-sm py-2.5 px-4">
            <select name="status" class="rounded-xl border-slate-300 text-sm py-2.5 px-4">
                <option value="">Semua Status</option>
                @foreach (['registered' => 'Terdaftar', 'waiting' => 'Menunggu', 'called' => 'Dipanggil', 'in_service' => 'Dilayani', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'] as $value => $label)
                    <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <button class="px-4 py-2.5 bg-slate-800 text-white rounded-xl text-sm">Filter</button>
        </form>
        <a href="{{ route('registration.create') }}" class="px-4 py-2.5 bg-teal-600 text-white rounded-xl text-sm font-medium">+ Daftar Pasien</a>
    </div>

    <div class="space-y-2">
        @forelse ($appointments as $appointment)
            <a href="{{ route('registration.show', $appointment) }}" class="block bg-white rounded-2xl shadow-sm p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium text-slate-800">{{ $appointment->patient->full_name }}</p>
                        <p class="text-xs text-slate-500">{{ $appointment->doctor->name }} &middot; {{ $appointment->polyclinic->name }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-teal-700">{{ $appointment->queue->queue_number ?? '-' }}</p>
                        <p class="text-xs text-slate-500">{{ ucfirst($appointment->status) }}</p>
                    </div>
                </div>
            </a>
        @empty
            <p class="text-sm text-slate-400 text-center py-8">Belum ada pendaftaran pada tanggal ini.</p>
        @endforelse
    </div>

    <div class="mt-4">{{ $appointments->links() }}</div>
</x-layouts.app>
