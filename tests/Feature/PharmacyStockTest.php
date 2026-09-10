<?php

namespace Tests\Feature;

use App\Models\MedicalRecord;
use App\Models\Medication;
use App\Models\Prescription;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PharmacyStockTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsRole(string $roleSlug): User
    {
        $role = Role::factory()->create(['slug' => $roleSlug]);
        $user = User::factory()->create(['role_id' => $role->id]);
        $this->actingAs($user);

        return $user;
    }

    public function test_prescription_is_rejected_when_stock_is_insufficient_and_validation_enabled(): void
    {
        config(['pharmacy.validate_stock' => true]);
        $this->actingAsRole('dokter');
        $record = MedicalRecord::factory()->create();
        $medication = Medication::factory()->create(['stock' => 2]);

        $response = $this->post('/prescriptions', [
            'medical_record_id' => $record->id,
            'items' => [
                ['medication_id' => $medication->id, 'dosage' => '500mg', 'frequency' => '3x1', 'quantity' => 10],
            ],
        ]);

        $response->assertSessionHasErrors('items');
        $this->assertEquals(0, Prescription::count());
    }

    public function test_prescription_allowed_when_stock_validation_disabled_via_config(): void
    {
        config(['pharmacy.validate_stock' => false]);
        $this->actingAsRole('dokter');
        $record = MedicalRecord::factory()->create();
        $medication = Medication::factory()->create(['stock' => 2]);

        $response = $this->post('/prescriptions', [
            'medical_record_id' => $record->id,
            'items' => [
                ['medication_id' => $medication->id, 'dosage' => '500mg', 'frequency' => '3x1', 'quantity' => 10],
            ],
        ]);

        $response->assertRedirect();
        $this->assertEquals(1, Prescription::count());
    }

    public function test_dispensing_prescription_deducts_stock(): void
    {
        config(['pharmacy.validate_stock' => true]);
        $this->actingAsRole('dokter');
        $medication = Medication::factory()->create(['stock' => 50]);
        $record = MedicalRecord::factory()->create();

        $prescription = Prescription::create([
            'prescription_code' => 'RSP-2026-000001',
            'medical_record_id' => $record->id,
            'patient_id' => $record->patient_id,
            'doctor_id' => $record->doctor_id,
            'status' => 'pending',
        ]);
        $prescription->items()->create(['medication_id' => $medication->id, 'dosage' => '500mg', 'frequency' => '3x1', 'quantity' => 10]);

        $this->post("/prescriptions/{$prescription->id}/dispense");

        $this->assertEquals(40, $medication->fresh()->stock);
        $this->assertEquals('dispensed', $prescription->fresh()->status);
    }
}
