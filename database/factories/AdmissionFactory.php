<?php

namespace Database\Factories;

use App\Models\Admission;
use App\Models\Bed;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdmissionFactory extends Factory
{
    protected $model = Admission::class;

    public function definition(): array
    {
        static $seq = 0;
        $seq++;

        return [
            'admission_code' => 'ADM-'.date('Y')."-".str_pad((string) $seq, 6, '0', STR_PAD_LEFT),
            'patient_id' => Patient::factory(),
            'doctor_id' => Doctor::factory(),
            'bed_id' => Bed::factory(),
            'admission_date' => now(),
            'status' => 'admitted',
        ];
    }
}
