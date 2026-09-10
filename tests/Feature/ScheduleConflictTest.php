<?php

namespace Tests\Feature;

use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScheduleConflictTest extends TestCase
{
    use RefreshDatabase;

    public function test_overlapping_schedule_is_flagged_as_conflict_and_blocked_by_default(): void
    {
        $role = Role::factory()->create(['slug' => 'admin_rs']);
        $user = User::factory()->create(['role_id' => $role->id]);
        $doctor = Doctor::factory()->create();

        DoctorSchedule::factory()->create([
            'doctor_id' => $doctor->id,
            'schedule_date' => '2026-09-10',
            'start_time' => '08:00',
            'end_time' => '12:00',
        ]);

        $response = $this->actingAs($user)->post('/schedules', [
            'doctor_id' => $doctor->id,
            'schedule_date' => '2026-09-10',
            'start_time' => '10:00',
            'end_time' => '14:00',
            'status' => 'available',
        ]);

        $response->assertSessionHasErrors('schedule_date');
        $this->assertEquals(1, DoctorSchedule::count());
    }

    public function test_conflict_can_be_forced_through_with_explicit_confirmation(): void
    {
        $role = Role::factory()->create(['slug' => 'admin_rs']);
        $user = User::factory()->create(['role_id' => $role->id]);
        $doctor = Doctor::factory()->create();

        DoctorSchedule::factory()->create([
            'doctor_id' => $doctor->id,
            'schedule_date' => '2026-09-10',
            'start_time' => '08:00',
            'end_time' => '12:00',
        ]);

        $response = $this->actingAs($user)->post('/schedules', [
            'doctor_id' => $doctor->id,
            'schedule_date' => '2026-09-10',
            'start_time' => '10:00',
            'end_time' => '14:00',
            'status' => 'available',
            'force' => '1',
        ]);

        $response->assertRedirect(route('schedules.index'));
        $this->assertEquals(2, DoctorSchedule::count());
    }

    public function test_end_time_must_be_after_start_time(): void
    {
        $role = Role::factory()->create(['slug' => 'admin_rs']);
        $user = User::factory()->create(['role_id' => $role->id]);
        $doctor = Doctor::factory()->create();

        $response = $this->actingAs($user)->post('/schedules', [
            'doctor_id' => $doctor->id,
            'schedule_date' => '2026-09-10',
            'start_time' => '14:00',
            'end_time' => '10:00',
            'status' => 'available',
        ]);

        $response->assertSessionHasErrors('end_time');
    }
}
