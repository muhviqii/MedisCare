<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\LaboratoryOrder;
use App\Models\MedicalRecord;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

class LaboratoryOrderFactory extends Factory
{
    protected $model = LaboratoryOrder::class;

    public function definition(): array
    {
        static $seq = 0;
        $seq++;

        return [
            'order_code' => 'LAB-'.date('Y')."-".str_pad((string) $seq, 6, '0', STR_PAD_LEFT),
            'medical_record_id' => MedicalRecord::factory(),
            'patient_id' => Patient::factory(),
            'doctor_id' => Doctor::factory(),
            'examination_type' => 'Darah Lengkap',
            'order_date' => now(),
            'status' => 'requested',
        ];
    }
}
