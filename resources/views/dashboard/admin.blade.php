<x-layouts.app title="Dashboard">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-2xl shadow-sm p-4">
            <p class="text-xs text-slate-500">Total Pasien</p>
            <p class="text-2xl font-semibold text-slate-800 mt-1">{{ number_format($total_patients) }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-4">
            <p class="text-xs text-slate-500">Pasien Baru Hari Ini</p>
            <p class="text-2xl font-semibold text-slate-800 mt-1">{{ number_format($new_patients_today) }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-4">
            <p class="text-xs text-slate-500">Dokter Aktif</p>
            <p class="text-2xl font-semibold text-slate-800 mt-1">{{ $active_doctors }}/{{ $total_doctors }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-4">
            <p class="text-xs text-slate-500">Kunjungan Hari Ini</p>
            <p class="text-2xl font-semibold text-slate-800 mt-1">{{ $today_appointments }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-4">
            <p class="text-xs text-slate-500">Rawat Inap Aktif</p>
            <p class="text-2xl font-semibold text-slate-800 mt-1">{{ $inpatient_active }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-4">
            <p class="text-xs text-slate-500">Kamar Tersedia</p>
            <p class="text-2xl font-semibold text-slate-800 mt-1">{{ $beds_available }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-4">
            <p class="text-xs text-slate-500">Pendapatan Hari Ini</p>
            <p class="text-lg font-semibold text-slate-800 mt-1">Rp{{ number_format($admin_revenue_today, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-4">
            <p class="text-xs text-slate-500">Tagihan Belum Lunas</p>
            <p class="text-2xl font-semibold text-red-600 mt-1">{{ $unpaid_invoices }}</p>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-4 mb-4">
        <div class="bg-white rounded-2xl shadow-sm p-4">
            <h3 class="text-sm font-semibold text-slate-700 mb-3">Kunjungan Pasien (7 Hari Terakhir)</h3>
            <canvas id="visitsChart" height="180"></canvas>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-4">
            <h3 class="text-sm font-semibold text-slate-700 mb-3">Pendapatan (7 Hari Terakhir)</h3>
            <canvas id="revenueChart" height="180"></canvas>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-4">
        <div class="bg-white rounded-2xl shadow-sm p-4">
            <h3 class="text-sm font-semibold text-slate-700 mb-3">Distribusi Jenis Kelamin</h3>
            <canvas id="genderChart" height="180"></canvas>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-4">
            <h3 class="text-sm font-semibold text-slate-700 mb-3">Distribusi Kelompok Usia</h3>
            <canvas id="ageChart" height="180"></canvas>
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

        new Chart(document.getElementById('genderChart'), {
            type: 'doughnut',
            data: { labels: ['Laki-laki', 'Perempuan'], datasets: [{ data: [chartData.gender.male, chartData.gender.female], backgroundColor: ['#0d9488', '#f59e0b'] }] }
        });

        new Chart(document.getElementById('ageChart'), {
            type: 'pie',
            data: { labels: Object.keys(chartData.age_groups), datasets: [{ data: Object.values(chartData.age_groups), backgroundColor: ['#0d9488', '#14b8a6', '#5eead4', '#134e4a'] }] }
        });
    });
    </script>
    @endpush
</x-layouts.app>
