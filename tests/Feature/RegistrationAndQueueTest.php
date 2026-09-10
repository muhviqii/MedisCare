<?php

namespace Tests\Feature;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Polyclinic;
use App\Models\Queue;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationAndQueueTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsRole(string $roleSlug): User
    {
        $role = Role::factory()->create(['slug' => $roleSlug]);
        $user = User::factory()->create(['role_id' => $role->id]);
        $this->actingAs($user);

        return $user;
    }

    public function test_registering_existing_patient_generates_sequential_queue_numbers(): void
    {
        $this->actingAsRole('petugas_pendaftaran');
        $polyclinic = Polyclinic::factory()->create();
        $doctor = Doctor::factory()->create(['polyclinic_id' => $polyclinic->id]);
        $patientA = Patient::factory()->create();
        $patientB = Patient::factory()->create();

        $this->post('/registration', [
            'patient_id' => $patientA->id,
            'polyclinic_id' => $polyclinic->id,
            'doctor_id' => $doctor->id,
            'appointment_date' => now()->toDateString(),
        ]);

        $this->post('/registration', [
            'patient_id' => $patientB->id,
            'polyclinic_id' => $polyclinic->id,
            'doctor_id' => $doctor->id,
            'appointment_date' => now()->toDateString(),
        ]);

        $queues = Queue::orderBy('id')->pluck('queue_number')->toArray();

        $this->assertEquals(['A-001', 'A-002'], $queues);
    }

    public function test_registering_new_patient_creates_patient_with_mr_number_and_appointment(): void
    {
        $this->actingAsRole('petugas_pendaftaran');
        $polyclinic = Polyclinic::factory()->create();
        $doctor = Doctor::factory()->create(['polyclinic_id' => $polyclinic->id]);

        $response = $this->post('/registration', [
            'new_patient' => [
                'nik' => '3201234567890099',
                'full_name' => 'Pasien Baru Test',
                'gender' => 'female',
                'birth_date' => '1995-05-05',
            ],
            'polyclinic_id' => $polyclinic->id,
            'doctor_id' => $doctor->id,
            'appointment_date' => now()->toDateString(),
        ]);

        $patient = Patient::where('nik', '3201234567890099')->first();

        $this->assertNotNull($patient);
        $this->assertStringStartsWith('MR-', $patient->medical_record_number);
        $response->assertRedirect();
    }

    public function test_queue_dashboard_call_skip_complete_flow(): void
    {
        $user = $this->actingAsRole('petugas_pendaftaran');
        $polyclinic = Polyclinic::factory()->create();
        $queue = Queue::factory()->create(['polyclinic_id' => $polyclinic->id, 'queue_date' => now()->toDateString()]);

        $this->post(route('queue.call', $queue));
        $this->assertEquals('called', $queue->fresh()->status);

        $this->post(route('queue.complete', $queue));
        $queue->refresh();
        $this->assertEquals('completed', $queue->status);
        $this->assertEquals('completed', $queue->appointment->fresh()->status);
    }
}
