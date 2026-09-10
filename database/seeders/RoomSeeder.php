<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            ['building' => 'Gedung A', 'floor' => '1', 'room_number' => 'A101', 'room_class' => 'class_3', 'daily_rate' => 250000, 'beds' => 4],
            ['building' => 'Gedung A', 'floor' => '1', 'room_number' => 'A102', 'room_class' => 'class_2', 'daily_rate' => 450000, 'beds' => 2],
            ['building' => 'Gedung A', 'floor' => '2', 'room_number' => 'A201', 'room_class' => 'class_1', 'daily_rate' => 750000, 'beds' => 1],
            ['building' => 'Gedung B', 'floor' => '1', 'room_number' => 'B101', 'room_class' => 'vip', 'daily_rate' => 1500000, 'beds' => 1],
            ['building' => 'Gedung B', 'floor' => '2', 'room_number' => 'B201', 'room_class' => 'icu', 'daily_rate' => 2000000, 'beds' => 2],
        ];

        foreach ($rooms as $roomData) {
            $bedCount = $roomData['beds'];
            unset($roomData['beds']);

            $room = Room::updateOrCreate(
                ['building' => $roomData['building'], 'floor' => $roomData['floor'], 'room_number' => $roomData['room_number']],
                [...$roomData, 'is_active' => true]
            );

            if ($room->beds()->count() === 0) {
                for ($i = 1; $i <= $bedCount; $i++) {
                    $room->beds()->create(['bed_number' => str_pad((string) $i, 2, '0', STR_PAD_LEFT), 'status' => 'available']);
                }
            }
        }
    }
}
