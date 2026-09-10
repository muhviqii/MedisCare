<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Radiology\StoreRadiologyOrderRequest;
use App\Http\Requests\Radiology\StoreRadiologyResultRequest;
use App\Models\MedicalRecord;
use App\Models\RadiologyOrder;
use App\Services\AuditLogService;
use App\Services\NumberGeneratorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class RadiologyController extends Controller
{
    public function __construct(
        private readonly NumberGeneratorService $numberGenerator,
        private readonly AuditLogService $audit,
    ) {
    }

    public function index(Request $request): View
    {
        $orders = RadiologyOrder::with(['patient', 'doctor'])
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->orderByDesc('order_date')
            ->paginate(20)
            ->withQueryString();

        return view('radiology.index', compact('orders'));
    }

    public function create(Request $request): View
    {
        $medicalRecord = MedicalRecord::with('patient')->findOrFail($request->integer('medical_record_id'));

        return view('radiology.create', compact('medicalRecord'));
    }

    public function store(StoreRadiologyOrderRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $medicalRecord = MedicalRecord::findOrFail($validated['medical_record_id']);

        $order = RadiologyOrder::create([
            'order_code' => $this->numberGenerator->generate('radiology_orders', 'order_code', 'RAD'),
            'medical_record_id' => $medicalRecord->id,
            'patient_id' => $medicalRecord->patient_id,
            'doctor_id' => $medicalRecord->doctor_id,
            'examination_type' => $validated['examination_type'],
            'order_date' => now(),
            'status' => 'requested',
        ]);

        $this->audit->log('Created Radiology Order', 'radiology_orders', $order->id);

        return redirect()->route('radiology.show', $order)->with('status', 'Permintaan radiologi berhasil dibuat.');
    }

    public function show(RadiologyOrder $radiology): View
    {
        $radiology->load(['patient', 'doctor', 'result']);

        return view('radiology.show', ['order' => $radiology]);
    }

    /**
     * File hasil radiologi disimpan pada disk 'local' (bukan 'public') dan hanya
     * dapat diunduh lewat route terautentikasi `radiology.download` (Bagian 18 & 28).
     */
    public function storeResult(StoreRadiologyResultRequest $request, RadiologyOrder $radiology): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('result_file')) {
            $validated['result_file'] = $request->file('result_file')->store('radiology-results', 'local');
        }

        $radiology->result()->updateOrCreate([], [...$validated, 'recorded_by' => auth()->id()]);
        $radiology->update(['status' => 'completed']);

        $this->audit->log('Recorded Radiology Result', 'radiology_orders', $radiology->id);

        return redirect()->route('radiology.show', $radiology)->with('status', 'Hasil radiologi berhasil disimpan.');
    }

    public function downloadResult(RadiologyOrder $radiology)
    {
        abort_unless($radiology->result?->result_file, 404);

        $this->audit->log('Downloaded Radiology Result', 'radiology_orders', $radiology->id);

        return Storage::disk('local')->download($radiology->result->result_file);
    }
}
