<?php

namespace Tests\Feature;

use App\Models\Bed;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Role;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InpatientAndBedTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsRole(string $roleSlug): User
    {
        $role = Role::factory()->create(['slug' => $roleSlug]);
        $user = User::factory()->create(['role_id' => $role->id]);
        $this->actingAs($user);

        return $user;
    }

    public function test_admitting_patient_marks_bed_as_occupied(): void
    {
        $this->actingAsRole('perawat');
        $room = Room::factory()->create();
        $bed = Bed::factory()->create(['room_id' => $room->id, 'status' => 'available']);
        $patient = Patient::factory()->create();
        $doctor = Doctor::factory()->create();

        $response = $this->post('/inpatient', [
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'bed_id' => $bed->id,
            'admission_date' => now()->toDateTimeString(),
        ]);

        $response->assertRedirect();
        $this->assertEquals('occupied', $bed->fresh()->status);
        $this->assertDatabaseHas('admissions', ['patient_id' => $patient->id, 'bed_id' => $bed->id, 'status' => 'admitted']);
    }

    public function test_discharging_patient_marks_bed_as_cleaning_not_directly_available(): void
    {
        $user = $this->actingAsRole('perawat');
        $room = Room::factory()->create();
        $bed = Bed::factory()->create(['room_id' => $room->id, 'status' => 'occupied']);
        $admission = \App\Models\Admission::factory()->create(['bed_id' => $bed->id, 'status' => 'admitted']);

        $response = $this->post("/inpatient/{$admission->id}/discharge", [
            'discharge_date' => now()->toDateTimeString(),
        ]);

        $response->assertRedirect(route('inpatient.index'));
        $this->assertEquals('discharged', $admission->fresh()->status);
        $this->assertEquals('cleaning', $bed->fresh()->status);
    }

    public function test_occupied_bed_cannot_be_double_booked(): void
    {
        $this->actingAsRole('perawat');
        $room = Room::factory()->create();
        $bed = Bed::factory()->create(['room_id' => $room->id, 'status' => 'occupied']);
        $patient = Patient::factory()->create();
        $doctor = Doctor::factory()->create();

        $response = $this->post('/inpatient', [
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'bed_id' => $bed->id,
            'admission_date' => now()->toDateTimeString(),
        ]);

        $response->assertStatus(422);
    }
}
