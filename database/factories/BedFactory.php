<?php

namespace Database\Factories;

use App\Models\Bed;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class BedFactory extends Factory
{
    protected $model = Bed::class;

    public function definition(): array
    {
        return [
            'room_id' => Room::factory(),
            'bed_number' => '01',
            'status' => 'available',
        ];
    }
}
