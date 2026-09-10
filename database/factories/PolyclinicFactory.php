<?php

namespace Database\Factories;

use App\Models\Polyclinic;
use App\Models\Specialty;
use Illuminate\Database\Eloquent\Factories\Factory;

class PolyclinicFactory extends Factory
{
    protected $model = Polyclinic::class;

    public function definition(): array
    {
        static $seq = 0;
        $seq++;

        return [
            'name' => 'Poli '.$this->faker->unique()->word(),
            'code' => 'POLI-'.str_pad((string) $seq, 3, '0', STR_PAD_LEFT),
            'specialty_id' => Specialty::factory(),
            'is_active' => true,
        ];
    }
}
