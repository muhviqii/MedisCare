<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        static $seq = 0;
        $seq++;

        $subtotal = $this->faker->numberBetween(50000, 2000000);

        return [
            'invoice_number' => 'INV-'.date('Y')."-".str_pad((string) $seq, 6, '0', STR_PAD_LEFT),
            'patient_id' => Patient::factory(),
            'service_type' => 'outpatient',
            'subtotal' => $subtotal,
            'grand_total' => $subtotal,
            'paid_amount' => 0,
            'status' => 'unpaid',
        ];
    }
}
