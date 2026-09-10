<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Medication\StoreMedicationRequest;
use App\Http\Requests\Medication\UpdateMedicationRequest;
use App\Models\Medication;
use App\Services\AuditLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MedicationController extends Controller
{
    public function __construct(private readonly AuditLogService $audit)
    {
    }

    public function index(Request $request): View
    {
        $medications = Medication::query()
            ->when($request->filled('search'), fn ($q) => $q->where('name', 'like', '%'.$request->string('search').'%'))
            ->when($request->filled('category'), fn ($q) => $q->where('category', $request->string('category')))
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('pharmacy.medications.index', compact('medications'));
    }

    public function create(): View
    {
        return view('pharmacy.medications.create');
    }

    public function store(StoreMedicationRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $medication = Medication::create([
            ...$validated,
            'code' => 'OBT-'.str_pad((string) (Medication::withTrashed()->count() + 1), 6, '0', STR_PAD_LEFT),
            'is_active' => true,
        ]);

        $this->audit->log('Created Medication', 'medications', $medication->id);

        return redirect()->route('medications.index')->with('status', 'Obat berhasil ditambahkan.');
    }

    public function edit(Medication $medication): View
    {
        return view('pharmacy.medications.edit', compact('medication'));
    }

    public function update(UpdateMedicationRequest $request, Medication $medication): RedirectResponse
    {
        $medication->update($request->validated());
        $this->audit->log('Updated Medication', 'medications', $medication->id);

        return redirect()->route('medications.index')->with('status', 'Data obat berhasil diperbarui.');
    }
}
