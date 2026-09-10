<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardReportsNotificationsTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsRole(string $roleSlug): User
    {
        $role = Role::factory()->create(['slug' => $roleSlug]);
        $user = User::factory()->create(['role_id' => $role->id]);
        $this->actingAs($user);

        return $user;
    }

    public function test_management_role_cannot_access_detailed_patient_report(): void
    {
        $this->actingAsRole('manajemen');

        $response = $this->get('/reports/patients');

        $response->assertForbidden();
    }

    public function test_management_role_can_access_aggregate_visit_report(): void
    {
        $this->actingAsRole('manajemen');

        $response = $this->get('/reports/visits');

        $response->assertOk();
    }

    public function test_admin_dashboard_loads_with_real_statistics(): void
    {
        $this->actingAsRole('admin_rs');

        $response = $this->get('/dashboard');

        $response->assertOk();
        $response->assertViewIs('dashboard.admin');
        $response->assertViewHas('total_patients');
        $response->assertViewHas('charts');
    }

    public function test_only_super_admin_and_admin_rs_can_view_audit_logs(): void
    {
        $this->actingAsRole('dokter');
        $response = $this->get('/audit-logs');
        $response->assertForbidden();

        $this->actingAsRole('super_admin');
        $response = $this->get('/audit-logs');
        $response->assertOk();
    }

    public function test_appointment_registration_creates_a_database_notification(): void
    {
        $adminRole = Role::factory()->create(['slug' => 'admin_rs']);
        $admin = User::factory()->create(['role_id' => $adminRole->id]);

        $petugasRole = Role::factory()->create(['slug' => 'petugas_pendaftaran']);
        $petugas = User::factory()->create(['role_id' => $petugasRole->id]);
        $this->actingAs($petugas);

        $polyclinic = \App\Models\Polyclinic::factory()->create();
        $doctor = \App\Models\Doctor::factory()->create();
        $patient = \App\Models\Patient::factory()->create();

        $this->post('/registration', [
            'patient_id' => $patient->id,
            'polyclinic_id' => $polyclinic->id,
            'doctor_id' => $doctor->id,
            'appointment_date' => now()->toDateString(),
        ]);

        $this->assertGreaterThan(0, $admin->fresh()->notifications()->count());
    }
}
