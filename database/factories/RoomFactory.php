<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition(): array
    {
        static $seq = 0;
        $seq++;

        return [
            'building' => 'Gedung '.$this->faker->randomElement(['A', 'B', 'C']),
            'floor' => (string) $this->faker->numberBetween(1, 3),
            'room_number' => 'R'.str_pad((string) $seq, 3, '0', STR_PAD_LEFT),
            'room_class' => 'class_3',
            'daily_rate' => 250000,
            'is_active' => true,
        ];
    }
}
