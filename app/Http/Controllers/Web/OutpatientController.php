<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Services\AuditLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Modul Rawat Jalan (Bagian 13). Alur: Pendaftaran -> Antrean -> Pemeriksaan ->
 * Diagnosis -> Tindakan -> Resep -> Administrasi -> Selesai. Sebagian besar tahapan
 * ini sudah ditangani modul Pendaftaran/Antrean (Tahap 5) dan Rekam Medis (Tahap 3);
 * controller ini menjadi "pusat" tampilan satu kunjungan rawat jalan dari awal sampai akhir.
 */
class OutpatientController extends Controller
{
    public function __construct(private readonly AuditLogService $audit)
    {
    }

    public function index(Request $request): View
    {
        $appointments = Appointment::with(['patient', 'doctor', 'polyclinic', 'queue', 'medicalRecords' => fn ($q) => $q->latest()->limit(1)])
            ->whereDate('appointment_date', $request->date('date') ?? now())
            ->whereIn('status', ['registered', 'waiting', 'called', 'in_service'])
            ->orderBy('appointment_date')
            ->get();

        return view('outpatient.index', compact('appointments'));
    }

    /**
     * Layar satu kunjungan: ringkasan pasien + tautan cepat ke rekam medis, resep, lab, radiologi.
     */
    public function show(Appointment $outpatient): View
    {
        $outpatient->load(['patient', 'doctor', 'polyclinic', 'queue', 'medicalRecords.diagnoses', 'medicalRecords.actions', 'medicalRecords.prescriptions']);

        return view('outpatient.show', ['appointment' => $outpatient]);
    }

    public function markInService(Appointment $outpatient): RedirectResponse
    {
        $outpatient->update(['status' => 'in_service']);
        $this->audit->log('Started Outpatient Service', 'appointments', $outpatient->id);

        return back()->with('status', 'Pemeriksaan dimulai.');
    }

    public function complete(Appointment $outpatient): RedirectResponse
    {
        $outpatient->update(['status' => 'completed']);
        $outpatient->queue()->update(['status' => 'completed', 'completed_at' => now()]);
        $this->audit->log('Completed Outpatient Visit', 'appointments', $outpatient->id);

        return redirect()->route('outpatient.index')->with('status', 'Kunjungan rawat jalan selesai. Lanjutkan ke Administrasi untuk pembayaran.');
    }
}
