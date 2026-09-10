<x-layouts.app title="Detail Rawat Inap">
    <div class="max-w-lg mx-auto space-y-4">
        <div class="bg-white rounded-2xl shadow-sm p-5">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <h2 class="font-semibold text-slate-800">{{ $admission->patient->full_name }}</h2>
                    <p class="text-xs text-slate-500">{{ $admission->admission_code }}</p>
                </div>
                <span class="text-xs px-2 py-0.5 rounded-full {{ $admission->status === 'discharged' ? 'bg-slate-100 text-slate-500' : 'bg-teal-50 text-teal-700' }}">
                    {{ ucfirst($admission->status) }}
                </span>
            </div>
            <dl class="grid grid-cols-2 gap-y-2 text-sm">
                <dt class="text-slate-400">Dokter</dt><dd>{{ $admission->doctor->name }}</dd>
                <dt class="text-slate-400">Ruangan / Bed</dt><dd>{{ $admission->bed->room->room_number }} / {{ $admission->bed->bed_number }}</dd>
                <dt class="text-slate-400">Tanggal Masuk</dt><dd>{{ $admission->admission_date->translatedFormat('d M Y H:i') }}</dd>
                <dt class="text-slate-400">Tanggal Keluar</dt><dd>{{ $admission->discharge_date?->translatedFormat('d M Y H:i') ?? '-' }}</dd>
                <dt class="text-slate-400">Diagnosis</dt><dd>{{ $admission->diagnosis ?: '-' }}</dd>
            </dl>
        </div>

        @if ($admission->status !== 'discharged')
        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="text-sm font-semibold text-slate-700 mb-3">Pulangkan Pasien</h3>
            <form method="POST" action="{{ route('inpatient.discharge', $admission) }}" class="space-y-3">
                @csrf
                <input type="datetime-local" name="discharge_date" value="{{ now()->format('Y-m-d\TH:i') }}" required
                       class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                <textarea name="discharge_notes" rows="2" placeholder="Catatan pemulangan" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4"></textarea>
                <button type="submit" class="w-full bg-slate-800 text-white rounded-xl py-3 text-sm font-medium hover:bg-slate-900">
                    Pulangkan Pasien
                </button>
            </form>
        </div>
        @else
            @can('create', \App\Models\Invoice::class)
            <form method="POST" action="{{ route('invoices.generate-from-admission', $admission) }}">
                @csrf
                <button class="w-full bg-teal-600 text-white rounded-xl py-3 text-sm font-medium hover:bg-teal-700">
                    Buat / Perbarui Invoice
                </button>
            </form>
            @endcan
        @endif
    </div>
</x-layouts.app>
