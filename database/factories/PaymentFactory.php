<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        static $seq = 0;
        $seq++;

        return [
            'payment_code' => 'PAY-'.date('Y')."-".str_pad((string) $seq, 6, '0', STR_PAD_LEFT),
            'invoice_id' => Invoice::factory(),
            'amount' => 50000,
            'method' => 'cash',
            'status' => 'success',
        ];
    }
}
