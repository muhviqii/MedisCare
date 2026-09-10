<?php

namespace Tests\Unit;

use App\Models\Invoice;
use App\Services\AuditLogService;
use App\Services\BillingService;
use App\Services\NumberGeneratorService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BillingServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_recalculate_totals_sums_items_and_resolves_status(): void
    {
        $service = new BillingService(new NumberGeneratorService, new AuditLogService);
        $invoice = Invoice::factory()->create(['subtotal' => 0, 'grand_total' => 0, 'paid_amount' => 0, 'status' => 'pending']);

        $invoice->items()->create(['item_type' => 'medical_action', 'description' => 'Konsultasi', 'quantity' => 1, 'unit_price' => 100000, 'total_price' => 100000]);
        $invoice->items()->create(['item_type' => 'medication', 'description' => 'Obat', 'quantity' => 2, 'unit_price' => 5000, 'total_price' => 10000]);

        $updated = $service->recalculateTotals($invoice);

        $this->assertEquals(110000, $updated->subtotal);
        $this->assertEquals(110000, $updated->grand_total);
        $this->assertEquals('unpaid', $updated->status);
    }

    public function test_fully_paid_invoice_resolves_to_paid_status(): void
    {
        $service = new BillingService(new NumberGeneratorService, new AuditLogService);
        $invoice = Invoice::factory()->create(['subtotal' => 0, 'grand_total' => 0, 'paid_amount' => 50000, 'status' => 'unpaid']);
        $invoice->items()->create(['item_type' => 'medical_action', 'description' => 'Tindakan', 'quantity' => 1, 'unit_price' => 50000, 'total_price' => 50000]);

        $updated = $service->recalculateTotals($invoice);

        $this->assertEquals('paid', $updated->status);
    }
}
