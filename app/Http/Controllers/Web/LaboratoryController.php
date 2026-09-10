<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Laboratory\StoreLaboratoryOrderRequest;
use App\Http\Requests\Laboratory\StoreLaboratoryResultRequest;
use App\Models\LaboratoryOrder;
use App\Models\MedicalRecord;
use App\Services\AuditLogService;
use App\Services\NumberGeneratorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LaboratoryController extends Controller
{
    public function __construct(
        private readonly NumberGeneratorService $numberGenerator,
        private readonly AuditLogService $audit,
    ) {
    }

    public function index(Request $request): View
    {
        $orders = LaboratoryOrder::with(['patient', 'doctor'])
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->orderByDesc('order_date')
            ->paginate(20)
            ->withQueryString();

        return view('laboratory.index', compact('orders'));
    }

    public function create(Request $request): View
    {
        $medicalRecord = MedicalRecord::with('patient')->findOrFail($request->integer('medical_record_id'));

        return view('laboratory.create', compact('medicalRecord'));
    }

    public function store(StoreLaboratoryOrderRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $medicalRecord = MedicalRecord::findOrFail($validated['medical_record_id']);

        $order = LaboratoryOrder::create([
            'order_code' => $this->numberGenerator->generate('laboratory_orders', 'order_code', 'LAB'),
            'medical_record_id' => $medicalRecord->id,
            'patient_id' => $medicalRecord->patient_id,
            'doctor_id' => $medicalRecord->doctor_id,
            'examination_type' => $validated['examination_type'],
            'order_date' => now(),
            'status' => 'requested',
            'notes' => $validated['notes'] ?? null,
        ]);

        $this->audit->log('Created Laboratory Order', 'laboratory_orders', $order->id);

        return redirect()->route('laboratory.show', $order)->with('status', 'Permintaan laboratorium berhasil dibuat.');
    }

    public function show(LaboratoryOrder $laboratory): View
    {
        $laboratory->load(['patient', 'doctor', 'results']);

        return view('laboratory.show', ['order' => $laboratory]);
    }

    public function process(LaboratoryOrder $laboratory): RedirectResponse
    {
        $laboratory->update(['status' => 'processing']);
        $this->audit->log('Processing Laboratory Order', 'laboratory_orders', $laboratory->id);

        return back()->with('status', 'Status diubah menjadi diproses.');
    }

    public function storeResults(StoreLaboratoryResultRequest $request, LaboratoryOrder $laboratory): RedirectResponse
    {
        $validated = $request->validated();

        foreach ($validated['results'] as $result) {
            $laboratory->results()->create([...$result, 'recorded_by' => auth()->id()]);
        }

        $laboratory->update(['status' => 'completed']);

        $this->audit->log('Recorded Laboratory Results', 'laboratory_orders', $laboratory->id);

        return redirect()->route('laboratory.show', $laboratory)->with('status', 'Hasil laboratorium berhasil disimpan.');
    }
}
