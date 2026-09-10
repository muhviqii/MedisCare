<x-layouts.app title="Rawat Inap">
    <div class="flex items-center justify-between mb-4">
        <select onchange="location.href=this.value" class="rounded-xl border-slate-300 text-sm py-2.5 px-4">
            <option value="{{ route('inpatient.index') }}">Sedang Dirawat</option>
            <option value="{{ route('inpatient.index', ['status' => 'discharged']) }}">Sudah Pulang</option>
        </select>
        <a href="{{ route('inpatient.create') }}" class="px-4 py-2.5 bg-teal-600 text-white rounded-xl text-sm font-medium">+ Rawat Inap Baru</a>
    </div>

    <div class="space-y-2">
        @forelse ($admissions as $admission)
            <a href="{{ route('inpatient.show', $admission) }}" class="block bg-white rounded-2xl shadow-sm p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium text-slate-800">{{ $admission->patient->full_name }}</p>
                        <p class="text-xs text-slate-500">{{ $admission->admission_code }} &middot; {{ $admission->bed->room->room_number }} / Bed {{ $admission->bed->bed_number }}</p>
                    </div>
                    <span class="text-xs px-2 py-0.5 rounded-full {{ $admission->status === 'discharged' ? 'bg-slate-100 text-slate-500' : 'bg-teal-50 text-teal-700' }}">
                        {{ ucfirst($admission->status) }}
                    </span>
                </div>
            </a>
        @empty
            <p class="text-sm text-slate-400 text-center py-8">Tidak ada data.</p>
        @endforelse
    </div>

    <div class="mt-4">{{ $admissions->links() }}</div>
</x-layouts.app>
