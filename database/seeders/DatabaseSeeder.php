<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            SpecialtySeeder::class,
            PolyclinicSeeder::class,
            DoctorSeeder::class,
            RoomSeeder::class,
            MedicationSeeder::class,
            DemoDataSeeder::class,
            // Seeder modul lain ditambahkan pada tahap-tahap berikutnya.
        ]);
    }
}
