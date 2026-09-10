<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Polyclinic\StorePolyclinicRequest;
use App\Models\Polyclinic;
use App\Models\Specialty;
use App\Services\AuditLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Master data Poli (Bagian 12). Admin dapat menambahkan poli baru.
 */
class PolyclinicController extends Controller
{
    public function __construct(private readonly AuditLogService $audit)
    {
    }

    public function index(): View
    {
        $polyclinics = Polyclinic::with('specialty')->orderBy('name')->paginate(20);

        return view('polyclinics.index', compact('polyclinics'));
    }

    public function create(): View
    {
        $specialties = Specialty::orderBy('name')->get();

        return view('polyclinics.create', compact('specialties'));
    }

    public function store(StorePolyclinicRequest $request): RedirectResponse
    {
        $polyclinic = Polyclinic::create([...$request->validated(), 'is_active' => true]);

        $this->audit->log('Created Polyclinic', 'polyclinics', $polyclinic->id);

        return redirect()->route('polyclinics.index')->with('status', 'Poli baru berhasil ditambahkan.');
    }

    public function toggleActive(Polyclinic $polyclinic): RedirectResponse
    {
        $polyclinic->update(['is_active' => ! $polyclinic->is_active]);
        $this->audit->log('Toggled Polyclinic Active', 'polyclinics', $polyclinic->id);

        return back()->with('status', 'Status poli diperbarui.');
    }
}
