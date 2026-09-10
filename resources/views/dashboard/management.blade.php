<x-layouts.app title="Dashboard Manajemen">
    <div class="bg-white rounded-2xl shadow-sm p-5 mb-4">
        <h2 class="font-semibold text-slate-800 mb-2">Statistik Agregat</h2>
        <p class="text-sm text-slate-500">Sesuai kebijakan otorisasi, akun Manajemen hanya melihat data agregat
            tanpa akses rinci ke rekam medis pasien individual.</p>
    </div>

    <div class="grid md:grid-cols-2 gap-4">
        <div class="bg-white rounded-2xl shadow-sm p-4">
            <h3 class="text-sm font-semibold text-slate-700 mb-3">Kunjungan Pasien (7 Hari Terakhir)</h3>
            <canvas id="visitsChart" height="180"></canvas>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-4">
            <h3 class="text-sm font-semibold text-slate-700 mb-3">Pendapatan (7 Hari Terakhir)</h3>
            <canvas id="revenueChart" height="180"></canvas>
        </div>
    </div>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const chartData = @json($charts);

        new Chart(document.getElementById('visitsChart'), {
            type: 'line',
            data: { labels: chartData.labels, datasets: [{ label: 'Kunjungan', data: chartData.visits, borderColor: '#0d9488', backgroundColor: 'rgba(13,148,136,0.1)', tension: 0.3, fill: true }] },
            options: { plugins: { legend: { display: false } } }
        });

        new Chart(document.getElementById('revenueChart'), {
            type: 'bar',
            data: { labels: chartData.labels, datasets: [{ label: 'Pendapatan', data: chartData.revenue, backgroundColor: '#0f766e' }] },
            options: { plugins: { legend: { display: false } } }
        });
    });
    </script>
    @endpush
</x-layouts.app>
