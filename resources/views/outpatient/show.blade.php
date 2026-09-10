<x-layouts.app title="Kunjungan Rawat Jalan">
    <div class="max-w-xl mx-auto space-y-4">
        <div class="bg-white rounded-2xl shadow-sm p-5">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <h2 class="font-semibold text-slate-800">{{ $appointment->patient->full_name }}</h2>
                    <p class="text-xs text-slate-500">{{ $appointment->doctor->name }} &middot; {{ $appointment->polyclinic->name }} &middot; Antrean {{ $appointment->queue->queue_number ?? '-' }}</p>
                </div>
                <span class="text-xs px-2 py-0.5 rounded-full
                    {{ match($appointment->status) { 'in_service' => 'bg-amber-50 text-amber-700', 'completed' => 'bg-teal-50 text-teal-700', default => 'bg-slate-100 text-slate-500' } }}">
                    {{ ucfirst(str_replace('_', ' ', $appointment->status)) }}
                </span>
            </div>

            <div class="flex gap-2">
                @if ($appointment->status !== 'in_service' && $appointment->status !== 'completed')
                    <form method="POST" action="{{ route('outpatient.start', $appointment) }}">
                        @csrf
                        <button class="px-4 py-2 bg-amber-500 text-white rounded-xl text-sm">Mulai Pemeriksaan</button>
                    </form>
                @endif
                @can('create', \App\Models\MedicalRecord::class)
                    <a href="{{ route('medical-records.create', ['patient_id' => $appointment->patient_id]) }}"
                       class="px-4 py-2 bg-teal-600 text-white rounded-xl text-sm">+ Rekam Medis</a>
                @endcan
                @if ($appointment->status !== 'completed')
                    <form method="POST" action="{{ route('outpatient.complete', $appointment) }}">
                        @csrf
                        <button class="px-4 py-2 bg-slate-800 text-white rounded-xl text-sm">Selesai &rarr; Administrasi</button>
                    </form>
                @else
                    @can('create', \App\Models\Invoice::class)
                        <form method="POST" action="{{ route('invoices.generate-from-appointment', $appointment) }}">
                            @csrf
                            <button class="px-4 py-2 bg-teal-600 text-white rounded-xl text-sm">Buat / Perbarui Invoice</button>
                        </form>
                    @endcan
                @endif
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="text-sm font-semibold text-slate-700 mb-3">Rekam Medis Kunjungan Ini</h3>
            @forelse ($appointment->medicalRecords as $record)
                <a href="{{ route('medical-records.show', $record) }}" class="block py-2 border-b last:border-0 border-slate-100 text-sm">
                    {{ $record->record_code }} — {{ $record->diagnoses->pluck('diagnosis_name')->join(', ') ?: 'Belum ada diagnosis' }}
                </a>
            @empty
                <p class="text-sm text-slate-400">Belum ada rekam medis untuk kunjungan ini.</p>
            @endforelse
        </div>
    </div>
</x-layouts.app>
