<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Patient\StorePatientRequest;
use App\Http\Requests\Patient\UpdatePatientRequest;
use App\Models\Patient;
use App\Services\AuditLogService;
use App\Services\NumberGeneratorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PatientController extends Controller
{
    public function __construct(
        private readonly NumberGeneratorService $numberGenerator,
        private readonly AuditLogService $audit,
    ) {
    }

    public function index(Request $request): View
    {
        $this->authorize('viewAny', Patient::class);

        $patients = Patient::query()
            ->when($request->filled('search'), function ($q) use ($request) {
                $term = $request->string('search');
                $q->where(function ($q2) use ($term) {
                    $q2->where('full_name', 'like', "%{$term}%")
                        ->orWhere('nik', 'like', "%{$term}%")
                        ->orWhere('medical_record_number', 'like', "%{$term}%");
                });
            })
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('patients.index', compact('patients'));
    }

    public function create(): View
    {
        $this->authorize('create', Patient::class);

        return view('patients.create');
    }

    public function store(StorePatientRequest $request): RedirectResponse
    {
        $patient = Patient::create([
            ...$request->validated(),
            'medical_record_number' => $this->numberGenerator->generate('patients', 'medical_record_number', 'MR'),
            'status' => 'active',
        ]);

        $this->audit->log('Created Patient', 'patients', $patient->id);

        return redirect()->route('patients.show', $patient)->with('status', 'Data pasien berhasil ditambahkan.');
    }

    public function show(Patient $patient): View
    {
        $this->authorize('view', $patient);

        $patient->load([
            'appointments' => fn ($q) => $q->latest('appointment_date')->limit(10),
            'medicalRecords' => fn ($q) => $q->latest('examination_date')->limit(10),
            'invoices' => fn ($q) => $q->latest()->limit(10),
        ]);

        $this->audit->log('Viewed Patient', 'patients', $patient->id);

        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient): View
    {
        $this->authorize('update', $patient);

        return view('patients.edit', compact('patient'));
    }

    public function update(UpdatePatientRequest $request, Patient $patient): RedirectResponse
    {
        $patient->update($request->validated());

        $this->audit->log('Updated Patient', 'patients', $patient->id);

        return redirect()->route('patients.show', $patient)->with('status', 'Data pasien berhasil diperbarui.');
    }

    /**
     * Nonaktifkan (soft delete), bukan hard delete — data medis pasien harus tetap tersimpan.
     */
    public function destroy(Patient $patient): RedirectResponse
    {
        $this->authorize('delete', $patient);

        $patient->update(['status' => 'inactive']);
        $patient->delete();

        $this->audit->log('Deactivated Patient', 'patients', $patient->id);

        return redirect()->route('patients.index')->with('status', 'Data pasien dinonaktifkan.');
    }
}
