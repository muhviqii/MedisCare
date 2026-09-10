<?php

namespace Database\Factories;

use App\Models\Nurse;
use Illuminate\Database\Eloquent\Factories\Factory;

class NurseFactory extends Factory
{
    protected $model = Nurse::class;

    public function definition(): array
    {
        static $seq = 0;
        $seq++;

        return [
            'nurse_code' => 'NRS-'.str_pad((string) $seq, 6, '0', STR_PAD_LEFT),
            'name' => $this->faker->name(),
            'nip' => $this->faker->unique()->numerify('#################'),
            'status' => 'active',
        ];
    }
}
