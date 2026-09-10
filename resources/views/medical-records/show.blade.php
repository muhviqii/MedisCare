<x-layouts.app title="Detail Rekam Medis">
    <div class="max-w-2xl mx-auto space-y-4">
        <div class="bg-white rounded-2xl shadow-sm p-5">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <h2 class="font-semibold text-slate-800">{{ $medicalRecord->record_code }}</h2>
                    <p class="text-xs text-slate-500">{{ $medicalRecord->patient->full_name }} &middot; {{ $medicalRecord->examination_date->translatedFormat('d F Y H:i') }}</p>
                </div>
                @can('update', $medicalRecord)
                    <a href="{{ route('medical-records.edit', $medicalRecord) }}" class="px-3 py-2 bg-slate-800 text-white rounded-xl text-xs">Edit</a>
                @endcan
            </div>

            <dl class="grid grid-cols-2 gap-y-2 text-sm">
                <dt class="text-slate-400">Dokter</dt><dd>{{ $medicalRecord->doctor->name ?? '-' }}</dd>
                <dt class="text-slate-400">Keluhan Utama</dt><dd>{{ $medicalRecord->chief_complaint ?: '-' }}</dd>
                <dt class="text-slate-400">Tekanan Darah</dt><dd>{{ $medicalRecord->blood_pressure ?: '-' }}</dd>
                <dt class="text-slate-400">Denyut Nadi</dt><dd>{{ $medicalRecord->pulse_rate ?: '-' }}</dd>
                <dt class="text-slate-400">Suhu</dt><dd>{{ $medicalRecord->temperature ?: '-' }} &deg;C</dd>
                <dt class="text-slate-400">Saturasi O2</dt><dd>{{ $medicalRecord->oxygen_saturation ?: '-' }}%</dd>
                <dt class="text-slate-400">Berat/Tinggi</dt><dd>{{ $medicalRecord->weight_kg ?: '-' }} kg / {{ $medicalRecord->height_cm ?: '-' }} cm</dd>
            </dl>
        </div>

        @if ($medicalRecord->diagnoses->isNotEmpty())
        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="text-sm font-semibold text-slate-700 mb-2">Diagnosis</h3>
            @foreach ($medicalRecord->diagnoses as $diagnosis)
                <p class="text-sm py-1">{{ $diagnosis->diagnosis_name }} @if($diagnosis->icd10_code) <span class="text-xs text-slate-400">({{ $diagnosis->icd10_code }})</span>@endif</p>
            @endforeach
        </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="text-sm font-semibold text-slate-700 mb-2">Catatan Dokter & Rencana Terapi</h3>
            <p class="text-sm text-slate-600 whitespace-pre-line">{{ $medicalRecord->doctor_notes ?: '-' }}</p>
            <p class="text-sm text-slate-600 whitespace-pre-line mt-2">{{ $medicalRecord->treatment_plan ?: '-' }}</p>
        </div>
    </div>
</x-layouts.app>
