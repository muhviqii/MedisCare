<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admission\DischargeAdmissionRequest;
use App\Http\Requests\Admission\StoreAdmissionRequest;
use App\Models\Admission;
use App\Models\Bed;
use App\Services\AuditLogService;
use App\Services\NumberGeneratorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdmissionController extends Controller
{
    public function __construct(
        private readonly NumberGeneratorService $numberGenerator,
        private readonly AuditLogService $audit,
    ) {
    }

    public function index(Request $request): View
    {
        $admissions = Admission::with(['patient', 'doctor', 'bed.room'])
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')), fn ($q) => $q->whereIn('status', ['admitted', 'active']))
            ->orderByDesc('admission_date')
            ->paginate(20)
            ->withQueryString();

        return view('inpatient.index', compact('admissions'));
    }

    public function create(): View
    {
        $availableBeds = Bed::with('room')->where('status', 'available')->get();

        return view('inpatient.create', compact('availableBeds'));
    }

    /**
     * Rawat inap: pasien masuk -> bed langsung ditandai occupied (Bagian 14 & 15).
     */
    public function store(StoreAdmissionRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $admission = DB::transaction(function () use ($validated) {
            $bed = Bed::lockForUpdate()->findOrFail($validated['bed_id']);

            if ($bed->status !== 'available') {
                abort(422, 'Bed yang dipilih sudah tidak tersedia.');
            }

            $admission = Admission::create([
                ...$validated,
                'admission_code' => $this->numberGenerator->generate('admissions', 'admission_code', 'ADM'),
                'status' => 'admitted',
            ]);

            $bed->update(['status' => 'occupied']);

            return $admission;
        });

        $this->audit->log('Created Admission', 'admissions', $admission->id);

        return redirect()->route('inpatient.show', $admission)->with('status', 'Pasien berhasil didaftarkan rawat inap.');
    }

    public function show(Admission $inpatient): View
    {
        $inpatient->load(['patient', 'doctor', 'bed.room']);

        return view('inpatient.show', ['admission' => $inpatient]);
    }

    /**
     * Pasien keluar -> bed berubah ke 'cleaning' (bukan langsung available; Bagian 15).
     */
    public function discharge(DischargeAdmissionRequest $request, Admission $inpatient): RedirectResponse
    {
        $validated = $request->validated();

        DB::transaction(function () use ($inpatient, $validated) {
            $inpatient->update([
                ...$validated,
                'status' => 'discharged',
            ]);

            $inpatient->bed()->update(['status' => 'cleaning']);
        });

        $this->audit->log('Discharged Patient', 'admissions', $inpatient->id);

        return redirect()->route('inpatient.index')->with('status', 'Pasien berhasil dipulangkan.');
    }
}
