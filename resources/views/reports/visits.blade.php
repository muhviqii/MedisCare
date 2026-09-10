<x-layouts.app title="Laporan Kunjungan">
    <form method="GET" class="flex gap-2 flex-wrap mb-4">
        <input type="date" name="from" value="{{ request('from') }}" class="rounded-xl border-slate-300 text-sm py-2 px-3">
        <input type="date" name="to" value="{{ request('to') }}" class="rounded-xl border-slate-300 text-sm py-2 px-3">
        <select name="doctor_id" class="rounded-xl border-slate-300 text-sm py-2 px-3">
            <option value="">Semua Dokter</option>
            @foreach ($doctors as $doctor)
                <option value="{{ $doctor->id }}" @selected(request('doctor_id') == $doctor->id)>{{ $doctor->name }}</option>
            @endforeach
        </select>
        <select name="polyclinic_id" class="rounded-xl border-slate-300 text-sm py-2 px-3">
            <option value="">Semua Poli</option>
            @foreach ($polyclinics as $poly)
                <option value="{{ $poly->id }}" @selected(request('polyclinic_id') == $poly->id)>{{ $poly->name }}</option>
            @endforeach
        </select>
        <button class="px-4 py-2 bg-slate-800 text-white rounded-xl text-sm">Filter</button>
    </form>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                <tr><th class="text-left px-4 py-3">Tanggal</th><th class="text-left px-4 py-3">Pasien</th><th class="text-left px-4 py-3">Dokter</th><th class="text-left px-4 py-3">Poli</th><th class="text-left px-4 py-3">Status</th></tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($visits as $visit)
                    <tr>
                        <td class="px-4 py-3">{{ $visit->appointment_date->translatedFormat('d M Y') }}</td>
                        <td class="px-4 py-3">{{ $visit->patient->full_name }}</td>
                        <td class="px-4 py-3">{{ $visit->doctor->name }}</td>
                        <td class="px-4 py-3">{{ $visit->polyclinic->name }}</td>
                        <td class="px-4 py-3">{{ ucfirst(str_replace('_',' ',$visit->status)) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $visits->links() }}</div>
</x-layouts.app>
