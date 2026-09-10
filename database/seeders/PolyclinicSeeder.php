<?php

namespace Database\Seeders;

use App\Models\Polyclinic;
use App\Models\Specialty;
use Illuminate\Database\Seeder;

class PolyclinicSeeder extends Seeder
{
    public function run(): void
    {
        $polyclinics = [
            ['name' => 'Poli Umum', 'code' => 'POLI-UMM', 'specialty' => 'umum'],
            ['name' => 'Poli Anak', 'code' => 'POLI-ANK', 'specialty' => 'anak'],
            ['name' => 'Poli Gigi', 'code' => 'POLI-GIG', 'specialty' => 'gigi'],
            ['name' => 'Poli Penyakit Dalam', 'code' => 'POLI-PDL', 'specialty' => 'penyakit-dalam'],
            ['name' => 'Poli Bedah', 'code' => 'POLI-BDH', 'specialty' => 'bedah'],
        ];

        foreach ($polyclinics as $poly) {
            $specialty = Specialty::where('slug', $poly['specialty'])->first();
            Polyclinic::updateOrCreate(
                ['code' => $poly['code']],
                ['name' => $poly['name'], 'specialty_id' => $specialty?->id, 'is_active' => true]
            );
        }
    }
}
