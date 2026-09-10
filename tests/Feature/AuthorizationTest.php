<?php

namespace Tests\Feature;

use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_doctor_cannot_view_medical_record_of_another_doctors_patient(): void
    {
        $doctorRole = Role::factory()->create(['slug' => 'dokter']);
        $userA = User::factory()->create(['role_id' => $doctorRole->id]);
        $userB = User::factory()->create(['role_id' => $doctorRole->id]);
        $doctorA = Doctor::factory()->create(['user_id' => $userA->id]);
        $doctorB = Doctor::factory()->create(['user_id' => $userB->id]);

        $patient = Patient::factory()->create();
        $record = MedicalRecord::factory()->create(['patient_id' => $patient->id, 'doctor_id' => $doctorB->id]);

        $this->assertFalse($userA->can('view', $record));
        $this->assertTrue($userB->can('view', $record));
    }

    public function test_petugas_administrasi_cannot_view_medical_records(): void
    {
        $role = Role::factory()->create(['slug' => 'petugas_administrasi']);
        $user = User::factory()->create(['role_id' => $role->id]);

        $this->assertFalse($user->can('viewAny', MedicalRecord::class));
    }
}
