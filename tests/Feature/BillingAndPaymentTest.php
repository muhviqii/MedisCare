<?php

namespace Tests\Feature;

use App\Models\Invoice;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BillingAndPaymentTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsRole(string $roleSlug): User
    {
        $role = Role::factory()->create(['slug' => $roleSlug]);
        $user = User::factory()->create(['role_id' => $role->id]);
        $this->actingAs($user);

        return $user;
    }

    public function test_payment_cannot_exceed_remaining_balance(): void
    {
        $this->actingAsRole('petugas_administrasi');
        $invoice = Invoice::factory()->create(['grand_total' => 100000, 'paid_amount' => 0, 'status' => 'unpaid']);

        $response = $this->post("/invoices/{$invoice->id}/payments", [
            'amount' => 150000,
            'method' => 'cash',
        ]);

        $response->assertSessionHasErrors('amount');
        $this->assertEquals(0, $invoice->fresh()->paid_amount);
    }

    public function test_full_payment_marks_invoice_as_paid(): void
    {
        $this->actingAsRole('petugas_administrasi');
        $invoice = Invoice::factory()->create(['grand_total' => 100000, 'paid_amount' => 0, 'status' => 'unpaid']);

        $this->post("/invoices/{$invoice->id}/payments", [
            'amount' => 100000,
            'method' => 'cash',
        ]);

        $invoice->refresh();
        $this->assertEquals('paid', $invoice->status);
        $this->assertEquals(100000, $invoice->paid_amount);
    }

    public function test_partial_payment_marks_invoice_as_partial(): void
    {
        $this->actingAsRole('petugas_administrasi');
        $invoice = Invoice::factory()->create(['grand_total' => 100000, 'paid_amount' => 0, 'status' => 'unpaid']);

        $this->post("/invoices/{$invoice->id}/payments", [
            'amount' => 40000,
            'method' => 'transfer',
        ]);

        $invoice->refresh();
        $this->assertEquals('partial', $invoice->status);
        $this->assertEquals(40000, $invoice->paid_amount);
    }

    public function test_no_sensitive_card_data_columns_exist_on_payments_table(): void
    {
        $columns = \Illuminate\Support\Facades\Schema::getColumnListing('payments');

        $this->assertNotContains('card_number', $columns);
        $this->assertNotContains('cvv', $columns);
    }
}
