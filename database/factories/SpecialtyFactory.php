<?php

namespace Database\Factories;

use App\Models\Specialty;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SpecialtyFactory extends Factory
{
    protected $model = Specialty::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->randomElement([
            'Penyakit Dalam', 'Anak', 'Bedah', 'Mata', 'THT', 'Kandungan', 'Kulit dan Kelamin', 'Jantung', 'Saraf', 'Gigi',
        ]);

        return ['name' => $name, 'slug' => Str::slug($name)];
    }
}
