<?php

namespace Tests\Unit;

use App\Models\Medication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MedicationStockTest extends TestCase
{
    use RefreshDatabase;

    public function test_has_sufficient_stock_returns_true_when_stock_covers_quantity(): void
    {
        $medication = Medication::factory()->create(['stock' => 10]);

        $this->assertTrue($medication->hasSufficientStock(10));
        $this->assertTrue($medication->hasSufficientStock(5));
        $this->assertFalse($medication->hasSufficientStock(11));
    }
}
