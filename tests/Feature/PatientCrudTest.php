<?php

namespace Tests\Feature;

use App\Models\Patient;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PatientCrudTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsRole(string $roleSlug): User
    {
        $role = Role::factory()->create(['slug' => $roleSlug]);
        $user = User::factory()->create(['role_id' => $role->id]);
        $this->actingAs($user);

        return $user;
    }

    public function test_registration_officer_can_create_patient_with_auto_generated_mr_number(): void
    {
        $this->actingAsRole('petugas_pendaftaran');

        $response = $this->post('/patients', [
            'nik' => '3201234567890001',
            'full_name' => 'Budi Santoso',
            'gender' => 'male',
            'birth_date' => '1990-01-01',
        ]);

        $patient = Patient::first();

        $response->assertRedirect(route('patients.show', $patient));
        $this->assertNotNull($patient);
        $this->assertStringStartsWith('MR-'.date('Y').'-', $patient->medical_record_number);
    }

    public function test_nik_must_be_16_digits(): void
    {
        $this->actingAsRole('petugas_pendaftaran');

        $response = $this->post('/patients', [
            'nik' => '12345',
            'full_name' => 'Test Pasien',
            'gender' => 'male',
            'birth_date' => '1990-01-01',
        ]);

        $response->assertSessionHasErrors('nik');
    }

    public function test_birth_date_cannot_be_in_the_future(): void
    {
        $this->actingAsRole('petugas_pendaftaran');

        $response = $this->post('/patients', [
            'nik' => '3201234567890002',
            'full_name' => 'Test Pasien',
            'gender' => 'male',
            'birth_date' => now()->addYear()->toDateString(),
        ]);

        $response->assertSessionHasErrors('birth_date');
    }

    public function test_petugas_administrasi_cannot_create_patient(): void
    {
        $this->actingAsRole('petugas_administrasi');

        $response = $this->post('/patients', [
            'nik' => '3201234567890003',
            'full_name' => 'Test Pasien',
            'gender' => 'male',
            'birth_date' => '1990-01-01',
        ]);

        $response->assertForbidden();
    }

    public function test_deleting_patient_only_deactivates_not_hard_deletes(): void
    {
        $this->actingAsRole('admin_rs');
        $patient = Patient::factory()->create(['status' => 'active']);

        $this->delete("/patients/{$patient->id}");

        $this->assertSoftDeleted('patients', ['id' => $patient->id]);
        $this->assertDatabaseHas('patients', ['id' => $patient->id, 'status' => 'inactive']);
    }
}
