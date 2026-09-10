<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Registration\StoreAppointmentRequest;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Polyclinic;
use App\Services\RegistrationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    public function __construct(private readonly RegistrationService $registrationService)
    {
    }

    public function index(Request $request): View
    {
        $appointments = Appointment::query()
            ->with(['patient', 'doctor', 'polyclinic', 'queue'])
            ->when($request->filled('date'), fn ($q) => $q->whereDate('appointment_date', $request->date('date')), fn ($q) => $q->whereDate('appointment_date', now()))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->orderBy('appointment_date')
            ->paginate(20)
            ->withQueryString();

        return view('registration.index', compact('appointments'));
    }

    /**
     * Flow: Pasien lama/baru -> Cari/buat pasien -> Pilih poli -> Pilih dokter ->
     * Pilih tanggal -> Pilih jadwal -> Generate nomor antrean -> Konfirmasi (Bagian 10).
     */
    public function create(): View
    {
        $polyclinics = Polyclinic::where('is_active', true)->orderBy('name')->get();

        return view('registration.create', compact('polyclinics'));
    }

    public function doctorsByPolyclinic(Polyclinic $polyclinic)
    {
        return Doctor::where('polyclinic_id', $polyclinic->id)
            ->where('status', 'active')
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    public function store(StoreAppointmentRequest $request): RedirectResponse
    {
        $appointment = $this->registrationService->register($request->validated());

        return redirect()->route('registration.show', $appointment)
            ->with('status', "Pendaftaran berhasil. Nomor antrean Anda: {$appointment->queue->queue_number}");
    }

    public function show(Appointment $registration): View
    {
        $registration->load(['patient', 'doctor', 'polyclinic', 'queue']);

        return view('registration.show', ['appointment' => $registration]);
    }
}
