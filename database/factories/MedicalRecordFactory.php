<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

class MedicalRecordFactory extends Factory
{
    protected $model = MedicalRecord::class;

    public function definition(): array
    {
        static $sequence = 0;
        $sequence++;

        return [
            'record_code' => 'EMR-'.date('Y')."-".str_pad((string) $sequence, 6, '0', STR_PAD_LEFT),
            'patient_id' => Patient::factory(),
            'doctor_id' => Doctor::factory(),
            'examination_date' => now(),
            'chief_complaint' => $this->faker->sentence(),
        ];
    }
}
