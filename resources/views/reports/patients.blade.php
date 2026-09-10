<x-layouts.app title="Laporan Pasien">
    <div class="flex items-center justify-between mb-4 flex-wrap gap-2">
        <form method="GET" class="flex gap-2 flex-wrap">
            <input type="date" name="from" value="{{ request('from') }}" class="rounded-xl border-slate-300 text-sm py-2 px-3">
            <input type="date" name="to" value="{{ request('to') }}" class="rounded-xl border-slate-300 text-sm py-2 px-3">
            <button class="px-4 py-2 bg-slate-800 text-white rounded-xl text-sm">Filter</button>
        </form>
        <a href="{{ route('reports.export.patients') }}" class="px-4 py-2 bg-teal-600 text-white rounded-xl text-sm">⬇ Export Excel</a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                <tr><th class="text-left px-4 py-3">No. RM</th><th class="text-left px-4 py-3">Nama</th><th class="text-left px-4 py-3">Status</th></tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($patients as $patient)
                    <tr><td class="px-4 py-3">{{ $patient->medical_record_number }}</td><td class="px-4 py-3">{{ $patient->full_name }}</td><td class="px-4 py-3">{{ ucfirst($patient->status) }}</td></tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $patients->links() }}</div>
</x-layouts.app>
