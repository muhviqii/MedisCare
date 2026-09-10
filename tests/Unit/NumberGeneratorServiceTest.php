<?php

namespace Tests\Unit;

use App\Models\Patient;
use App\Services\NumberGeneratorService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NumberGeneratorServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_generates_sequential_numbers_with_correct_format(): void
    {
        $service = new NumberGeneratorService;

        $first = $service->generate('patients', 'medical_record_number', 'MR');
        Patient::factory()->create(['medical_record_number' => $first]);

        $second = $service->generate('patients', 'medical_record_number', 'MR');

        $this->assertEquals('MR-'.now()->year.'-000001', $first);
        $this->assertEquals('MR-'.now()->year.'-000002', $second);
    }

    public function test_queue_number_resets_per_polyclinic_and_date(): void
    {
        $service = new NumberGeneratorService;

        $numberA = $service->generateQueueNumber('queues', 'queue_number', 'A', 1, now()->toDateString());
        $numberB = $service->generateQueueNumber('queues', 'queue_number', 'A', 2, now()->toDateString());

        // Poli berbeda -> keduanya mulai dari A-001 karena belum ada data tersimpan untuk masing-masing.
        $this->assertEquals('A-001', $numberA);
        $this->assertEquals('A-001', $numberB);
    }

    public function test_queue_number_increments_for_same_polyclinic_and_date(): void
    {
        $service = new NumberGeneratorService;

        $polyclinic = \App\Models\Polyclinic::factory()->create();
        $doctor = \App\Models\Doctor::factory()->create(['polyclinic_id' => $polyclinic->id]);
        $patient = \App\Models\Patient::factory()->create();

        $first = $service->generateQueueNumber('queues', 'queue_number', 'A', $polyclinic->id, now()->toDateString());
        $this->assertEquals('A-001', $first);

        $appointment = \App\Models\Appointment::factory()->create([
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'polyclinic_id' => $polyclinic->id,
            'appointment_date' => now()->toDateString(),
        ]);

        \Illuminate\Support\Facades\DB::table('queues')->insert([
            'appointment_id' => $appointment->id,
            'polyclinic_id' => $polyclinic->id,
            'queue_number' => $first,
            'queue_date' => now()->toDateString(),
            'status' => 'waiting',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $second = $service->generateQueueNumber('queues', 'queue_number', 'A', $polyclinic->id, now()->toDateString());

        $this->assertEquals('A-002', $second);
    }
}
