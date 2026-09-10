<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
    protected $model = Patient::class;

    public function definition(): array
    {
        static $sequence = 0;
        $sequence++;

        return [
            'medical_record_number' => 'MR-'.date('Y')."-".str_pad((string) $sequence, 6, '0', STR_PAD_LEFT),
            'nik' => $this->faker->unique()->numerify('################'),
            'full_name' => $this->faker->name(),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'birth_date' => $this->faker->date(),
            'address' => $this->faker->address(),
            'phone' => $this->faker->numerify('08##########'),
            'status' => 'active',
        ];
    }
}
