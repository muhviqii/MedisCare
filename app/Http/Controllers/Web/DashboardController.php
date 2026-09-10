<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\Appointment;
use App\Models\Bed;
use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Statistik dashboard berbeda per role (Bagian 5):
     * Manajemen -> hanya agregat (Gate 'reports.view-aggregate').
     * Dokter -> ringkasan jadwal & antrean pribadi.
     * Admin/Super Admin -> statistik operasional penuh + grafik Chart.js.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        if ($user->hasRole('dokter')) {
            return view('dashboard.doctor', ['user' => $user]);
        }

        if ($user->hasRole('manajemen')) {
            return view('dashboard.management', $this->aggregateStats());
        }

        return view('dashboard.admin', $this->fullStats());
    }

    private function fullStats(): array
    {
        $today = now()->toDateString();

        $stats = [
            'total_patients' => Patient::count(),
            'new_patients_today' => Patient::whereDate('created_at', $today)->count(),
            'total_doctors' => Doctor::count(),
            'active_doctors' => Doctor::where('status', 'active')->count(),
            'today_appointments' => Appointment::whereDate('appointment_date', $today)->count(),
            'outpatient_today' => Appointment::whereDate('appointment_date', $today)->count(),
            'inpatient_active' => Admission::whereIn('status', ['admitted', 'active'])->count(),
            'beds_available' => Bed::where('status', 'available')->count(),
            'beds_occupied' => Bed::where('status', 'occupied')->count(),
            'admin_revenue_today' => Invoice::whereDate('created_at', $today)->sum('paid_amount'),
            'unpaid_invoices' => Invoice::whereIn('status', ['unpaid', 'partial'])->count(),
        ];

        return [...$stats, 'charts' => $this->chartData()];
    }

    private function aggregateStats(): array
    {
        // Manajemen: hanya angka agregat, tanpa daftar pasien/rekam medis individual.
        return ['charts' => $this->chartData()];
    }

    private function chartData(): array
    {
        $last7Days = collect(range(6, 0))->map(fn ($i) => now()->subDays($i)->toDateString());

        $visitsPerDay = Appointment::selectRaw('DATE(appointment_date) as date, count(*) as total')
            ->whereBetween('appointment_date', [$last7Days->first(), $last7Days->last()])
            ->groupBy('date')
            ->pluck('total', 'date');

        $revenuePerDay = Invoice::selectRaw('DATE(created_at) as date, sum(paid_amount) as total')
            ->whereBetween('created_at', [$last7Days->first().' 00:00:00', $last7Days->last().' 23:59:59'])
            ->groupBy('date')
            ->pluck('total', 'date');

        $genderDistribution = Patient::selectRaw('gender, count(*) as total')->groupBy('gender')->pluck('total', 'gender');

        $ageGroups = Patient::query()
            ->select('birth_date')
            ->get()
            ->reduce(function (array $carry, $patient) {
                if (! $patient->birth_date) {
                    return $carry;
                }

                $age = \Illuminate\Support\Carbon::parse($patient->birth_date)->age;

                if ($age < 12) {
                    $key = 'Anak (0-11)';
                } elseif ($age < 18) {
                    $key = 'Remaja (12-17)';
                } elseif ($age < 60) {
                    $key = 'Dewasa (18-59)';
                } else {
                    $key = 'Lansia (60+)';
                }

                $carry[$key] = ($carry[$key] ?? 0) + 1;

                return $carry;
            }, [
                'Anak (0-11)' => 0,
                'Remaja (12-17)' => 0,
                'Dewasa (18-59)' => 0,
                'Lansia (60+)' => 0,
            ]);

        return [
            'labels' => $last7Days->map(fn ($d) => \Illuminate\Support\Carbon::parse($d)->translatedFormat('d M'))->toArray(),
            'visits' => $last7Days->map(fn ($d) => $visitsPerDay[$d] ?? 0)->toArray(),
            'revenue' => $last7Days->map(fn ($d) => (float) ($revenuePerDay[$d] ?? 0))->toArray(),
            'gender' => ['male' => $genderDistribution['male'] ?? 0, 'female' => $genderDistribution['female'] ?? 0],
            'age_groups' => $ageGroups,
        ];
    }
}
