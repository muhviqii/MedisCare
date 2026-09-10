<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\MedicalRecord\StoreMedicalRecordRequest;
use App\Http\Requests\MedicalRecord\UpdateMedicalRecordRequest;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Services\AuditLogService;
use App\Services\NumberGeneratorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MedicalRecordController extends Controller
{
    public function __construct(
        private readonly NumberGeneratorService $numberGenerator,
        private readonly AuditLogService $audit,
    ) {
    }

    public function create(Request $request): View
    {
        $this->authorize('create', MedicalRecord::class);

        $patient = Patient::findOrFail($request->integer('patient_id'));

        return view('medical-records.create', compact('patient'));
    }

    public function store(StoreMedicalRecordRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $record = DB::transaction(function () use ($validated) {
            $record = MedicalRecord::create([
                ...collect($validated)->except(['diagnoses', 'actions'])->toArray(),
                'record_code' => $this->numberGenerator->generate('medical_records', 'record_code', 'EMR'),
            ]);

            foreach ($validated['diagnoses'] ?? [] as $diagnosis) {
                $record->diagnoses()->create($diagnosis);
            }

            foreach ($validated['actions'] ?? [] as $action) {
                $record->actions()->create($action);
            }

            return $record;
        });

        $this->audit->log('Created Medical Record', 'medical_records', $record->id);

        return redirect()->route('patients.show', $record->patient_id)
            ->with('status', 'Rekam medis berhasil disimpan.');
    }

    public function show(MedicalRecord $medicalRecord): View
    {
        $this->authorize('view', $medicalRecord);

        $medicalRecord->load(['patient', 'doctor', 'nurse', 'diagnoses', 'actions', 'prescriptions.items.medication']);

        $this->audit->log('Viewed Medical Record', 'medical_records', $medicalRecord->id);

        return view('medical-records.show', ['medicalRecord' => $medicalRecord]);
    }

    public function edit(MedicalRecord $medicalRecord): View
    {
        $this->authorize('update', $medicalRecord);

        return view('medical-records.edit', ['medicalRecord' => $medicalRecord]);
    }

    /**
     * Setiap perubahan dicatat sebagai revisi (audit trail).
     * Rekam medis TIDAK PERNAH dihapus permanen — lihat MedicalRecordPolicy::delete().
     */
    public function update(UpdateMedicalRecordRequest $request, MedicalRecord $medicalRecord): RedirectResponse
    {
        $validated = $request->validated();
        $previousData = $medicalRecord->only(array_keys($validated));

        DB::transaction(function () use ($medicalRecord, $validated, $previousData) {
            $medicalRecord->update($validated);

            $medicalRecord->revisions()->create([
                'changed_by' => auth()->id(),
                'previous_data' => $previousData,
                'new_data' => $validated,
                'created_at' => now(),
            ]);
        });

        $this->audit->log('Updated Medical Record', 'medical_records', $medicalRecord->id);

        return redirect()->route('medical-records.show', $medicalRecord)
            ->with('status', 'Rekam medis berhasil diperbarui. Perubahan telah dicatat pada riwayat revisi.');
    }
}
