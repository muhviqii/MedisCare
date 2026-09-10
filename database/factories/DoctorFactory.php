<?php

namespace Database\Factories;

use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;

class DoctorFactory extends Factory
{
    protected $model = Doctor::class;

    public function definition(): array
    {
        return [
            'doctor_code' => 'DOK-'.str_pad((string) $this->faker->unique()->numberBetween(1, 999999), 6, '0', STR_PAD_LEFT),
            'name' => 'dr. '.$this->faker->name(),
            'nip' => $this->faker->unique()->numerify('#################'),
            'str_number' => $this->faker->numerify('STR-########'),
            'sip_number' => $this->faker->numerify('SIP-########'),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->numerify('08##########'),
            'status' => 'active',
        ];
    }
}
