<?php

namespace Tests\Feature;

use App\Models\Doctor;
use App\Models\Role;
use App\Models\Specialty;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DoctorCrudTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsRole(string $roleSlug): User
    {
        $role = Role::factory()->create(['slug' => $roleSlug]);
        $user = User::factory()->create(['role_id' => $role->id]);
        $this->actingAs($user);

        return $user;
    }

    public function test_admin_can_create_doctor_with_auto_generated_code(): void
    {
        $this->actingAsRole('admin_rs');
        $specialty = Specialty::factory()->create();

        $response = $this->post('/doctors', [
            'name' => 'dr. Test Dokter',
            'specialty_id' => $specialty->id,
            'status' => 'active',
        ]);

        $doctor = Doctor::first();
        $response->assertRedirect(route('doctors.show', $doctor));
        $this->assertStringStartsWith('DOK-', $doctor->doctor_code);
    }

    public function test_dokter_role_cannot_create_new_doctor(): void
    {
        $this->actingAsRole('dokter');
        $specialty = Specialty::factory()->create();

        $response = $this->post('/doctors', [
            'name' => 'dr. Test Dokter',
            'specialty_id' => $specialty->id,
            'status' => 'active',
        ]);

        $response->assertForbidden();
    }
}
