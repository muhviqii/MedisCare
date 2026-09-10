<?php

namespace Database\Factories;

use App\Models\Medication;
use Illuminate\Database\Eloquent\Factories\Factory;

class MedicationFactory extends Factory
{
    protected $model = Medication::class;

    public function definition(): array
    {
        static $seq = 0;
        $seq++;

        return [
            'code' => 'OBT-'.str_pad((string) $seq, 6, '0', STR_PAD_LEFT),
            'name' => $this->faker->unique()->word().' '.$this->faker->randomElement(['500mg', '250mg', '100mg']),
            'unit' => 'tablet',
            'price' => $this->faker->numberBetween(300, 2000),
            'stock' => $this->faker->numberBetween(0, 200),
            'is_active' => true,
        ];
    }
}
