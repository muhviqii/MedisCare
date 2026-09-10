<x-layouts.app title="Laporan">
    <div class="grid md:grid-cols-2 gap-4">
        @can('viewDetailed', \App\Models\Patient::class)
        <a href="{{ route('reports.patients') }}" class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="font-semibold text-slate-800">Laporan Pasien</h3>
            <p class="text-xs text-slate-500 mt-1">Data pasien dengan filter tanggal & status</p>
        </a>
        @endcan
        <a href="{{ route('reports.visits') }}" class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="font-semibold text-slate-800">Laporan Kunjungan</h3>
            <p class="text-xs text-slate-500 mt-1">Kunjungan rawat jalan per dokter, poli, status</p>
        </a>
        <a href="{{ route('reports.revenue') }}" class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="font-semibold text-slate-800">Laporan Pendapatan</h3>
            <p class="text-xs text-slate-500 mt-1">Invoice & pembayaran per periode</p>
        </a>
        <a href="{{ route('reports.bed-usage') }}" class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="font-semibold text-slate-800">Penggunaan Bed</h3>
            <p class="text-xs text-slate-500 mt-1">Okupansi kamar per kelas</p>
        </a>
    </div>
</x-layouts.app>
