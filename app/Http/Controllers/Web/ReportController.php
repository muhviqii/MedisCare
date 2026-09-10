<?php

namespace App\Http\Controllers\Web;

use App\Exports\InvoicesExport;
use App\Exports\PatientsExport;
use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Modul Laporan (Bagian 21). Manajemen hanya boleh laporan agregat (Gate
 * 'reports.view-aggregate'); laporan rinci (menyentuh data pasien per individu)
 * dibatasi ke 'reports.view-detailed' (admin/super admin saja).
 */
class ReportController extends Controller
{
    public function index(): View
    {
        Gate::authorize('reports.view-aggregate');

        return view('reports.index');
    }

    public function patients(Request $request): View
    {
        Gate::authorize('reports.view-detailed');

        $patients = Patient::query()
            ->when($request->filled('from'), fn ($q) => $q->whereDate('created_at', '>=', $request->date('from')))
            ->when($request->filled('to'), fn ($q) => $q->whereDate('created_at', '<=', $request->date('to')))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->orderByDesc('id')
            ->paginate(30)
            ->withQueryString();

        return view('reports.patients', compact('patients'));
    }

    public function visits(Request $request): View
    {
        Gate::authorize('reports.view-aggregate');

        $visits = Appointment::query()
            ->with(['patient', 'doctor', 'polyclinic'])
            ->when($request->filled('from'), fn ($q) => $q->whereDate('appointment_date', '>=', $request->date('from')))
            ->when($request->filled('to'), fn ($q) => $q->whereDate('appointment_date', '<=', $request->date('to')))
            ->when($request->filled('doctor_id'), fn ($q) => $q->where('doctor_id', $request->integer('doctor_id')))
            ->when($request->filled('polyclinic_id'), fn ($q) => $q->where('polyclinic_id', $request->integer('polyclinic_id')))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->orderByDesc('appointment_date')
            ->paginate(30)
            ->withQueryString();

        $doctors = \App\Models\Doctor::orderBy('name')->get();
        $polyclinics = \App\Models\Polyclinic::orderBy('name')->get();

        return view('reports.visits', compact('visits', 'doctors', 'polyclinics'));
    }

    public function revenue(Request $request): View
    {
        Gate::authorize('reports.view-aggregate');

        $invoices = Invoice::query()
            ->with('patient')
            ->when($request->filled('from'), fn ($q) => $q->whereDate('created_at', '>=', $request->date('from')))
            ->when($request->filled('to'), fn ($q) => $q->whereDate('created_at', '<=', $request->date('to')))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->orderByDesc('id')
            ->paginate(30)
            ->withQueryString();

        $totalRevenue = (clone $invoices->getQuery())->sum('paid_amount');

        return view('reports.revenue', compact('invoices', 'totalRevenue'));
    }

    public function bedUsage(): View
    {
        Gate::authorize('reports.view-aggregate');

        $admissions = Admission::with(['patient', 'bed.room'])
            ->orderByDesc('admission_date')
            ->paginate(30);

        $occupancyByClass = \App\Models\Room::withCount(['beds as occupied_count' => fn ($q) => $q->where('status', 'occupied')])
            ->get()
            ->groupBy('room_class')
            ->map(fn ($rooms) => $rooms->sum('occupied_count'));

        return view('reports.bed-usage', compact('admissions', 'occupancyByClass'));
    }

    public function exportPatients()
    {
        Gate::authorize('reports.export');

        return Excel::download(new PatientsExport, 'laporan-pasien-'.now()->format('Ymd').'.xlsx');
    }

    public function exportInvoices(Request $request)
    {
        Gate::authorize('reports.export');

        return Excel::download(
            new InvoicesExport($request->only(['from', 'to', 'status'])),
            'laporan-pendapatan-'.now()->format('Ymd').'.xlsx'
        );
    }

    /**
     * Export PDF sederhana memakai barryvdh/laravel-dompdf.
     */
    public function exportRevenuePdf(Request $request)
    {
        Gate::authorize('reports.export');

        $invoices = Invoice::with('patient')
            ->when($request->filled('from'), fn ($q) => $q->whereDate('created_at', '>=', $request->date('from')))
            ->when($request->filled('to'), fn ($q) => $q->whereDate('created_at', '<=', $request->date('to')))
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.pdf.revenue', [
            'invoices' => $invoices,
            'total' => $invoices->sum('paid_amount'),
        ]);

        return $pdf->download('laporan-pendapatan-'.now()->format('Ymd').'.pdf');
    }
}
