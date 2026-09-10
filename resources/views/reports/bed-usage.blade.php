<x-layouts.app title="Penggunaan Bed">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
        @foreach ($occupancyByClass as $class => $count)
            <div class="bg-white rounded-2xl shadow-sm p-4 text-center">
                <p class="text-xl font-bold text-slate-800">{{ $count }}</p>
                <p class="text-xs text-slate-500">{{ strtoupper(str_replace('_',' ',$class)) }}</p>
            </div>
        @endforeach
    </div>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                <tr><th class="text-left px-4 py-3">Pasien</th><th class="text-left px-4 py-3">Kamar/Bed</th><th class="text-left px-4 py-3">Masuk</th><th class="text-left px-4 py-3">Keluar</th></tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($admissions as $admission)
                    <tr>
                        <td class="px-4 py-3">{{ $admission->patient->full_name }}</td>
                        <td class="px-4 py-3">{{ $admission->bed->room->room_number }}/{{ $admission->bed->bed_number }}</td>
                        <td class="px-4 py-3">{{ $admission->admission_date->translatedFormat('d M Y') }}</td>
                        <td class="px-4 py-3">{{ $admission->discharge_date?->translatedFormat('d M Y') ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $admissions->links() }}</div>
</x-layouts.app>
