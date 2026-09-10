<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Prescription\StorePrescriptionRequest;
use App\Models\Medication;
use App\Models\MedicalRecord;
use App\Models\Prescription;
use App\Services\AuditLogService;
use App\Services\NumberGeneratorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PrescriptionController extends Controller
{
    public function __construct(
        private readonly NumberGeneratorService $numberGenerator,
        private readonly AuditLogService $audit,
    ) {
    }

    public function create(Request $request): View
    {
        $medicalRecord = MedicalRecord::with('patient')->findOrFail($request->integer('medical_record_id'));
        $medications = Medication::where('is_active', true)->orderBy('name')->get();

        return view('pharmacy.prescriptions.create', compact('medicalRecord', 'medications'));
    }

    /**
     * Validasi stok dapat dimatikan lewat config('pharmacy.validate_stock') (Bagian 16).
     */
    public function store(StorePrescriptionRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if (config('pharmacy.validate_stock')) {
            $insufficient = [];
            foreach ($validated['items'] as $item) {
                $medication = Medication::find($item['medication_id']);
                if (! $medication->hasSufficientStock($item['quantity'])) {
                    $insufficient[] = "{$medication->name} (stok tersisa: {$medication->stock})";
                }
            }

            if (! empty($insufficient)) {
                return back()->withInput()->withErrors([
                    'items' => 'Stok obat tidak mencukupi untuk: '.implode(', ', $insufficient),
                ]);
            }
        }

        $prescription = DB::transaction(function () use ($validated) {
            $medicalRecord = MedicalRecord::findOrFail($validated['medical_record_id']);

            $prescription = Prescription::create([
                'prescription_code' => $this->numberGenerator->generate('prescriptions', 'prescription_code', 'RSP'),
                'medical_record_id' => $medicalRecord->id,
                'patient_id' => $medicalRecord->patient_id,
                'doctor_id' => $medicalRecord->doctor_id,
                'status' => 'pending',
            ]);

            foreach ($validated['items'] as $item) {
                $prescription->items()->create($item);
            }

            return $prescription;
        });

        $this->audit->log('Created Prescription', 'prescriptions', $prescription->id);

        return redirect()->route('medical-records.show', $prescription->medical_record_id)
            ->with('status', 'Resep berhasil dibuat.');
    }

    /**
     * Serah-terima obat ke pasien: mengurangi stok secara atomic (Bagian 16).
     */
    public function dispense(Prescription $prescription): RedirectResponse
    {
        DB::transaction(function () use ($prescription) {
            foreach ($prescription->items()->with('medication')->get() as $item) {
                $medication = Medication::lockForUpdate()->find($item->medication_id);
                if ($medication->stock < $item->quantity) {
                    abort(422, "Stok {$medication->name} tidak mencukupi.");
                }
                $medication->decrement('stock', $item->quantity);
            }

            $prescription->update(['status' => 'dispensed']);
        });

        $this->audit->log('Dispensed Prescription', 'prescriptions', $prescription->id);

        return back()->with('status', 'Resep berhasil diserahkan ke pasien, stok diperbarui.');
    }
}
