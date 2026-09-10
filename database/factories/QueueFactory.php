<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Polyclinic;
use App\Models\Queue;
use Illuminate\Database\Eloquent\Factories\Factory;

class QueueFactory extends Factory
{
    protected $model = Queue::class;

    public function definition(): array
    {
        static $seq = 0;
        $seq++;

        return [
            'appointment_id' => Appointment::factory(),
            'polyclinic_id' => Polyclinic::factory(),
            'queue_number' => 'A-'.str_pad((string) $seq, 3, '0', STR_PAD_LEFT),
            'queue_date' => now()->toDateString(),
            'status' => 'waiting',
        ];
    }
}
