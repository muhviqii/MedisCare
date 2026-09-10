<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Polyclinic;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition(): array
    {
        static $seq = 0;
        $seq++;

        return [
            'appointment_code' => 'APT-'.date('Y')."-".str_pad((string) $seq, 6, '0', STR_PAD_LEFT),
            'patient_id' => Patient::factory(),
            'doctor_id' => Doctor::factory(),
            'polyclinic_id' => Polyclinic::factory(),
            'appointment_date' => now()->toDateString(),
            'status' => 'registered',
        ];
    }
}
