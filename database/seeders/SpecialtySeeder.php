<?php

namespace Database\Seeders;

use App\Models\Specialty;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SpecialtySeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Umum', 'Anak', 'Gigi', 'Penyakit Dalam', 'Bedah'] as $name) {
            Specialty::updateOrCreate(['slug' => Str::slug($name)], ['name' => $name, 'slug' => Str::slug($name)]);
        }
    }
}
