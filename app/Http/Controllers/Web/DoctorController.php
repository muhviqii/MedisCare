<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\StoreDoctorRequest;
use App\Http\Requests\Doctor\UpdateDoctorRequest;
use App\Models\Doctor;
use App\Models\Specialty;
use App\Services\AuditLogService;
use App\Services\NumberGeneratorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DoctorController extends Controller
{
    public function __construct(
        private readonly NumberGeneratorService $numberGenerator,
        private readonly AuditLogService $audit,
    ) {
    }

    public function index(Request $request): View
    {
        $this->authorize('viewAny', Doctor::class);

        $doctors = Doctor::query()
            ->with(['specialty', 'polyclinic'])
            ->when($request->filled('search'), fn ($q) => $q->where('name', 'like', '%'.$request->string('search').'%'))
            ->when($request->filled('specialty_id'), fn ($q) => $q->where('specialty_id', $request->integer('specialty_id')))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        $specialties = Specialty::orderBy('name')->get();

        return view('doctors.index', compact('doctors', 'specialties'));
    }

    public function create(): View
    {
        $this->authorize('create', Doctor::class);

        $specialties = Specialty::orderBy('name')->get();
        $polyclinics = \App\Models\Polyclinic::orderBy('name')->get();

        return view('doctors.create', compact('specialties', 'polyclinics'));
    }

    public function store(StoreDoctorRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('doctors', 'public');
        }

        $doctor = Doctor::create([
            ...$validated,
            'doctor_code' => $this->numberGenerator->generate('doctors', 'doctor_code', 'DOK'),
        ]);

        $this->audit->log('Created Doctor', 'doctors', $doctor->id);

        return redirect()->route('doctors.show', $doctor)->with('status', 'Data dokter berhasil ditambahkan.');
    }

    public function show(Doctor $doctor): View
    {
        $this->authorize('view', $doctor);

        $doctor->load(['specialty', 'polyclinic', 'schedules' => fn ($q) => $q->where('schedule_date', '>=', now()->toDateString())->orderBy('schedule_date')->limit(10)]);

        return view('doctors.show', compact('doctor'));
    }

    public function edit(Doctor $doctor): View
    {
        $this->authorize('update', $doctor);

        $specialties = Specialty::orderBy('name')->get();
        $polyclinics = \App\Models\Polyclinic::orderBy('name')->get();

        return view('doctors.edit', compact('doctor', 'specialties', 'polyclinics'));
    }

    public function update(UpdateDoctorRequest $request, Doctor $doctor): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('doctors', 'public');
        }

        $doctor->update($validated);

        $this->audit->log('Updated Doctor', 'doctors', $doctor->id);

        return redirect()->route('doctors.show', $doctor)->with('status', 'Data dokter berhasil diperbarui.');
    }

    public function destroy(Doctor $doctor): RedirectResponse
    {
        $this->authorize('delete', $doctor);

        $doctor->update(['status' => 'inactive']);
        $doctor->delete();

        $this->audit->log('Deactivated Doctor', 'doctors', $doctor->id);

        return redirect()->route('doctors.index')->with('status', 'Data dokter dinonaktifkan.');
    }
}
