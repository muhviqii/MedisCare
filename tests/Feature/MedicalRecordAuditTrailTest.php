<?php

namespace Tests\Feature;

use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MedicalRecordAuditTrailTest extends TestCase
{
    use RefreshDatabase;

    public function test_updating_medical_record_creates_a_revision_instead_of_overwriting_silently(): void
    {
        $role = Role::factory()->create(['slug' => 'dokter']);
        $user = User::factory()->create(['role_id' => $role->id]);
        $doctor = Doctor::factory()->create(['user_id' => $user->id]);
        $record = MedicalRecord::factory()->create(['doctor_id' => $doctor->id, 'chief_complaint' => 'Demam']);

        $this->actingAs($user)->put("/medical-records/{$record->id}", [
            'chief_complaint' => 'Demam tinggi 3 hari',
        ]);

        $record->refresh();

        $this->assertEquals('Demam tinggi 3 hari', $record->chief_complaint);
        $this->assertDatabaseCount('medical_record_revisions', 1);
        $this->assertDatabaseHas('medical_record_revisions', [
            'medical_record_id' => $record->id,
            'changed_by' => $user->id,
        ]);
    }

    public function test_medical_record_can_never_be_hard_deleted_via_policy(): void
    {
        $role = Role::factory()->create(['slug' => 'super_admin']);
        $user = User::factory()->create(['role_id' => $role->id]);
        $record = MedicalRecord::factory()->create();

        $this->assertFalse($user->can('delete', $record));
    }
}
