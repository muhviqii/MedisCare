<x-layouts.app title="Rawat Jalan">
    <form method="GET" class="mb-4">
        <input type="date" name="date" value="{{ request('date', now()->toDateString()) }}" onchange="this.form.submit()"
               class="rounded-xl border-slate-300 text-sm py-2.5 px-4">
    </form>

    <div class="space-y-2">
        @forelse ($appointments as $appointment)
            <a href="{{ route('outpatient.show', $appointment) }}" class="block bg-white rounded-2xl shadow-sm p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium text-slate-800">{{ $appointment->patient->full_name }}</p>
                        <p class="text-xs text-slate-500">{{ $appointment->doctor->name }} &middot; {{ $appointment->polyclinic->name }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-teal-700">{{ $appointment->queue->queue_number ?? '-' }}</p>
                        <span class="text-xs px-2 py-0.5 rounded-full
                            {{ match($appointment->status) { 'in_service' => 'bg-amber-50 text-amber-700', 'completed' => 'bg-teal-50 text-teal-700', default => 'bg-slate-100 text-slate-500' } }}">
                            {{ ucfirst(str_replace('_', ' ', $appointment->status)) }}
                        </span>
                    </div>
                </div>
            </a>
        @empty
            <p class="text-sm text-slate-400 text-center py-8">Tidak ada kunjungan rawat jalan pada tanggal ini.</p>
        @endforelse
    </div>
</x-layouts.app>
