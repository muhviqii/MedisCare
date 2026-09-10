<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Queue;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\DB;

/**
 * Mengorkestrasi alur pendaftaran (Bagian 10) end-to-end:
 * pasien lama/baru -> pilih poli/dokter/jadwal -> generate nomor antrean -> konfirmasi.
 */
class RegistrationService
{
    public function __construct(
        private readonly NumberGeneratorService $numberGenerator,
        private readonly AuditLogService $audit,
    ) {
    }

    public function register(array $data): Appointment
    {
        return DB::transaction(function () use ($data) {
            $patient = isset($data['patient_id'])
                ? Patient::findOrFail($data['patient_id'])
                : $this->createPatient($data['new_patient']);

            $appointment = Appointment::create([
                'appointment_code' => $this->numberGenerator->generate('appointments', 'appointment_code', 'APT'),
                'patient_id' => $patient->id,
                'doctor_id' => $data['doctor_id'],
                'polyclinic_id' => $data['polyclinic_id'],
                'doctor_schedule_id' => $data['doctor_schedule_id'] ?? null,
                'appointment_date' => $data['appointment_date'],
                'patient_type' => isset($data['patient_id']) ? 'returning' : 'new',
                'status' => 'registered',
                'notes' => $data['notes'] ?? null,
                'created_by' => auth()->id(),
            ]);

            $queueNumber = null;
            $queue = null;

            for ($attempt = 0; $attempt < 10; $attempt++) {
                $queueNumber = $this->numberGenerator->generateQueueNumber(
                    'queues',
                    'queue_number',
                    'A',
                    $data['polyclinic_id'],
                    $data['appointment_date'],
                );

                try {
                    $queue = Queue::create([
                        'appointment_id' => $appointment->id,
                        'polyclinic_id' => $data['polyclinic_id'],
                        'queue_number' => $queueNumber,
                        'queue_date' => $data['appointment_date'],
                        'status' => 'waiting',
                    ]);

                    break;
                } catch (UniqueConstraintViolationException $exception) {
                    if ($attempt === 9) {
                        throw $exception;
                    }
                }
            }

            if ($queue === null) {
                throw new \RuntimeException('Failed to allocate a queue number for this registration.');
            }

            $this->audit->log('Registered Appointment', 'appointments', $appointment->id);

            $recipients = \App\Models\User::whereHas('role', fn ($q) => $q->whereIn('slug', ['admin_rs', 'petugas_pendaftaran']))->get();
            \Illuminate\Support\Facades\Notification::send($recipients, new \App\Notifications\AppointmentRegisteredNotification($appointment));

            return $appointment->load('queue', 'patient', 'doctor', 'polyclinic');
        });
    }

    private function createPatient(array $data): Patient
    {
        return Patient::create([
            ...$data,
            'medical_record_number' => $this->numberGenerator->generate('patients', 'medical_record_number', 'MR'),
            'status' => 'active',
        ]);
    }
}
