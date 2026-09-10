<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition(): array
    {
        $slug = $this->faker->unique()->word();

        return [
            'name' => ucfirst($slug),
            'slug' => $slug,
            'description' => $this->faker->sentence(),
        ];
    }
}
