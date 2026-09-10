<x-layouts.app title="Daftar Resep">
    <form method="GET" class="mb-4">
        <select name="status" onchange="this.form.submit()" class="rounded-xl border-slate-300 text-sm py-2.5 px-4">
            <option value="">Semua Status</option>
            <option value="pending" @selected(request('status') === 'pending')>Menunggu</option>
            <option value="dispensed" @selected(request('status') === 'dispensed')>Sudah Diserahkan</option>
        </select>
    </form>

    <div class="space-y-2">
        @forelse ($prescriptions as $prescription)
            <div class="bg-white rounded-2xl shadow-sm p-4">
                <div class="flex items-center justify-between mb-2">
                    <div>
                        <p class="font-medium text-slate-800">{{ $prescription->patient->full_name }}</p>
                        <p class="text-xs text-slate-500">{{ $prescription->prescription_code }} &middot; {{ $prescription->doctor->name }}</p>
                    </div>
                    <span class="text-xs px-2 py-0.5 rounded-full {{ $prescription->status === 'dispensed' ? 'bg-teal-50 text-teal-700' : 'bg-amber-50 text-amber-700' }}">
                        {{ $prescription->status === 'dispensed' ? 'Sudah Diserahkan' : 'Menunggu' }}
                    </span>
                </div>
                <ul class="text-xs text-slate-500 list-disc list-inside mb-2">
                    @foreach ($prescription->items as $item)
                        <li>{{ $item->medication->name }} — {{ $item->dosage }}, {{ $item->frequency }} ({{ $item->quantity }} {{ $item->medication->unit }})</li>
                    @endforeach
                </ul>
                @if ($prescription->status === 'pending')
                    <form method="POST" action="{{ route('prescriptions.dispense', $prescription) }}">
                        @csrf
                        <button class="px-3 py-1.5 bg-teal-600 text-white rounded-lg text-xs">Serahkan ke Pasien</button>
                    </form>
                @endif
            </div>
        @empty
            <p class="text-sm text-slate-400 text-center py-8">Belum ada resep.</p>
        @endforelse
    </div>
    <div class="mt-4">{{ $prescriptions->links() }}</div>
</x-layouts.app>
