<x-layouts.app title="Konfirmasi Pendaftaran">
    <div class="max-w-md mx-auto bg-white rounded-2xl shadow-sm p-6 text-center">
        <p class="text-xs text-slate-400 uppercase tracking-wide mb-1">Nomor Antrean Anda</p>
        <p class="text-5xl font-bold text-teal-700 mb-4">{{ $appointment->queue->queue_number ?? '-' }}</p>

        <div class="text-left bg-slate-50 rounded-xl p-4 space-y-2 text-sm">
            <div class="flex justify-between"><span class="text-slate-400">Kode</span><span>{{ $appointment->appointment_code }}</span></div>
            <div class="flex justify-between"><span class="text-slate-400">Pasien</span><span>{{ $appointment->patient->full_name }}</span></div>
            <div class="flex justify-between"><span class="text-slate-400">Dokter</span><span>{{ $appointment->doctor->name }}</span></div>
            <div class="flex justify-between"><span class="text-slate-400">Poli</span><span>{{ $appointment->polyclinic->name }}</span></div>
            <div class="flex justify-between"><span class="text-slate-400">Tanggal</span><span>{{ $appointment->appointment_date->translatedFormat('d F Y') }}</span></div>
            <div class="flex justify-between"><span class="text-slate-400">Status</span><span>{{ ucfirst($appointment->status) }}</span></div>
        </div>

        <a href="{{ route('registration.create') }}" class="block mt-5 bg-teal-600 text-white rounded-xl py-3 text-sm font-medium hover:bg-teal-700">
            Daftar Pasien Lain
        </a>
        <a href="{{ route('registration.index') }}" class="block mt-2 text-sm text-slate-500">Kembali ke Daftar Pendaftaran</a>
    </div>
</x-layouts.app>
