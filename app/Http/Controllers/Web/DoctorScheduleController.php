<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\DoctorSchedule\StoreDoctorScheduleRequest;
use App\Http\Requests\DoctorSchedule\UpdateDoctorScheduleRequest;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Services\AuditLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DoctorScheduleController extends Controller
{
    public function __construct(private readonly AuditLogService $audit)
    {
    }

    /**
     * Tampilan daily/weekly/monthly (Bagian 9). Parameter `view` menentukan rentang tanggal;
     * kalender penuh (grid bulanan) dirender di Blade menggunakan data yang sama.
     */
    public function index(Request $request): View
    {
        $view = $request->string('view', 'weekly')->toString();
        $anchor = $request->date('date') ?? now();

        [$start, $end] = match ($view) {
            'daily' => [$anchor->copy()->startOfDay(), $anchor->copy()->endOfDay()],
            'monthly' => [$anchor->copy()->startOfMonth(), $anchor->copy()->endOfMonth()],
            default => [$anchor->copy()->startOfWeek(), $anchor->copy()->endOfWeek()],
        };

        $schedules = DoctorSchedule::with(['doctor', 'polyclinic'])
            ->whereBetween('schedule_date', [$start->toDateString(), $end->toDateString()])
            ->when($request->filled('doctor_id'), fn ($q) => $q->where('doctor_id', $request->integer('doctor_id')))
            ->orderBy('schedule_date')
            ->orderBy('start_time')
            ->get()
            ->groupBy(fn ($s) => $s->schedule_date->toDateString());

        $doctors = Doctor::orderBy('name')->get();

        return view('schedules.index', compact('schedules', 'doctors', 'view', 'anchor', 'start', 'end'));
    }

    public function create(): View
    {
        $doctors = Doctor::where('status', '!=', 'inactive')->orderBy('name')->get();

        return view('schedules.create', compact('doctors'));
    }

    public function store(StoreDoctorScheduleRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Deteksi bentrok jadwal (Bagian 9): tampilkan warning, tetap izinkan simpan
        // dengan konfirmasi eksplisit dari pengguna (checkbox `force`).
        $conflicts = DoctorSchedule::conflicting(
            $validated['doctor_id'],
            $validated['schedule_date'],
            $validated['start_time'],
            $validated['end_time'],
        )->get();

        if ($conflicts->isNotEmpty() && ! $request->boolean('force')) {
            return back()->withInput()->with('conflicts', $conflicts)->withErrors([
                'schedule_date' => 'Jadwal dokter ini bertabrakan dengan jadwal yang sudah ada. Periksa kembali atau centang "Tetap simpan" jika disengaja.',
            ]);
        }

        $schedule = DoctorSchedule::create($validated);

        $this->audit->log('Created Doctor Schedule', 'doctor_schedules', $schedule->id);

        return redirect()->route('schedules.index')->with('status', 'Jadwal dokter berhasil ditambahkan.');
    }

    public function edit(DoctorSchedule $schedule): View
    {
        $doctors = Doctor::orderBy('name')->get();

        return view('schedules.edit', compact('schedule', 'doctors'));
    }

    public function update(UpdateDoctorScheduleRequest $request, DoctorSchedule $schedule): RedirectResponse
    {
        $validated = $request->validated();

        $conflicts = DoctorSchedule::conflicting(
            $schedule->doctor_id,
            $validated['schedule_date'],
            $validated['start_time'],
            $validated['end_time'],
            ignoreId: $schedule->id,
        )->get();

        if ($conflicts->isNotEmpty() && ! $request->boolean('force')) {
            return back()->withInput()->with('conflicts', $conflicts)->withErrors([
                'schedule_date' => 'Jadwal dokter ini bertabrakan dengan jadwal yang sudah ada.',
            ]);
        }

        $schedule->update($validated);

        $this->audit->log('Updated Doctor Schedule', 'doctor_schedules', $schedule->id);

        return redirect()->route('schedules.index')->with('status', 'Jadwal dokter berhasil diperbarui.');
    }

    public function destroy(DoctorSchedule $schedule): RedirectResponse
    {
        $schedule->delete();

        $this->audit->log('Deleted Doctor Schedule', 'doctor_schedules', $schedule->id);

        return back()->with('status', 'Jadwal dokter dihapus.');
    }

    /**
     * Tandai cuti/libur dokter untuk rentang tanggal tertentu (Bagian 9).
     */
    public function markLeave(Request $request, Doctor $doctor): RedirectResponse
    {
        $validated = $request->validate([
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'notes' => ['nullable', 'string'],
        ]);

        $period = \Carbon\CarbonPeriod::create($validated['start_date'], $validated['end_date']);

        foreach ($period as $date) {
            DoctorSchedule::create([
                'doctor_id' => $doctor->id,
                'schedule_date' => $date->toDateString(),
                'start_time' => '00:00',
                'end_time' => '23:59',
                'status' => 'on_leave',
                'notes' => $validated['notes'] ?? 'Cuti dokter',
            ]);
        }

        $this->audit->log('Marked Doctor Leave', 'doctor_schedules', $doctor->id);

        return back()->with('status', 'Cuti dokter berhasil dicatat.');
    }
}
