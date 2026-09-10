<x-layouts.app :title="$patient->full_name">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h2 class="font-semibold text-slate-800 text-lg">{{ $patient->full_name }}</h2>
            <p class="text-xs text-slate-500">{{ $patient->medical_record_number }} &middot; NIK {{ $patient->nik }} &middot; {{ $patient->age() }} tahun</p>
        </div>
        @can('update', $patient)
            <a href="{{ route('patients.edit', $patient) }}" class="px-4 py-2 bg-slate-800 text-white rounded-xl text-sm">Edit</a>
        @endcan
    </div>

    <div class="grid md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-2xl shadow-sm p-4 md:col-span-2">
            <h3 class="text-sm font-semibold text-slate-700 mb-3">Informasi Pasien</h3>
            <dl class="grid grid-cols-2 gap-y-2 text-sm">
                <dt class="text-slate-400">Jenis Kelamin</dt><dd>{{ $patient->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</dd>
                <dt class="text-slate-400">Tanggal Lahir</dt><dd>{{ $patient->birth_date->translatedFormat('d F Y') }}</dd>
                <dt class="text-slate-400">Golongan Darah</dt><dd>{{ $patient->blood_type }}</dd>
                <dt class="text-slate-400">Alergi</dt><dd>{{ $patient->allergies ?: '-' }}</dd>
                <dt class="text-slate-400">Telepon</dt><dd>{{ $patient->phone ?: '-' }}</dd>
                <dt class="text-slate-400">Alamat</dt><dd>{{ $patient->address ?: '-' }}</dd>
                <dt class="text-slate-400">Kontak Darurat</dt><dd>{{ $patient->emergency_contact_name ?: '-' }} ({{ $patient->emergency_contact_phone ?: '-' }})</dd>
            </dl>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-4">
            <h3 class="text-sm font-semibold text-slate-700 mb-3">Status</h3>
            <span class="text-xs px-3 py-1 rounded-full {{ $patient->status === 'active' ? 'bg-teal-50 text-teal-700' : 'bg-slate-100 text-slate-500' }}">
                {{ $patient->status === 'active' ? 'Aktif' : 'Nonaktif' }}
            </span>
            @can('create', \App\Models\MedicalRecord::class)
                <a href="{{ route('medical-records.create', ['patient_id' => $patient->id]) }}"
                   class="mt-4 block text-center bg-teal-600 text-white rounded-xl py-2.5 text-sm font-medium hover:bg-teal-700">
                    + Rekam Medis Baru
                </a>
            @endcan
        </div>
    </div>

    @can('viewAny', \App\Models\MedicalRecord::class)
    <div class="bg-white rounded-2xl shadow-sm p-4 mb-4">
        <h3 class="text-sm font-semibold text-slate-700 mb-3">Riwayat Rekam Medis</h3>
        @forelse ($patient->medicalRecords as $record)
            <a href="{{ route('medical-records.show', $record) }}" class="flex items-center justify-between py-2 border-b last:border-0 border-slate-100">
                <span class="text-sm text-slate-700">{{ $record->examination_date->translatedFormat('d M Y') }} &middot; {{ $record->record_code }}</span>
                <span class="text-xs text-teal-700">Lihat &rarr;</span>
            </a>
        @empty
            <p class="text-sm text-slate-400">Belum ada rekam medis.</p>
        @endforelse
    </div>
    @endcan

    <div class="bg-white rounded-2xl shadow-sm p-4">
        <h3 class="text-sm font-semibold text-slate-700 mb-3">Riwayat Kunjungan</h3>
        @forelse ($patient->appointments as $appointment)
            <div class="flex items-center justify-between py-2 border-b last:border-0 border-slate-100 text-sm">
                <span>{{ $appointment->appointment_date->translatedFormat('d M Y') }} &middot; {{ $appointment->appointment_code }}</span>
                <span class="text-xs text-slate-500">{{ ucfirst($appointment->status) }}</span>
            </div>
        @empty
            <p class="text-sm text-slate-400">Belum ada riwayat kunjungan.</p>
        @endforelse
    </div>
</x-layouts.app>
