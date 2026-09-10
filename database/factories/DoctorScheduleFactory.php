<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\DoctorSchedule;
use Illuminate\Database\Eloquent\Factories\Factory;

class DoctorScheduleFactory extends Factory
{
    protected $model = DoctorSchedule::class;

    public function definition(): array
    {
        return [
            'doctor_id' => Doctor::factory(),
            'schedule_date' => $this->faker->dateTimeBetween('now', '+30 days')->format('Y-m-d'),
            'start_time' => '08:00',
            'end_time' => '12:00',
            'status' => 'available',
        ];
    }
}
