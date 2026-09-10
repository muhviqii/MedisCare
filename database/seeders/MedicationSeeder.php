<?php

namespace Database\Seeders;

use App\Models\Medication;
use Illuminate\Database\Seeder;

class MedicationSeeder extends Seeder
{
    public function run(): void
    {
        $medications = [
            ['name' => 'Paracetamol 500mg', 'category' => 'Analgesik', 'unit' => 'tablet', 'price' => 500, 'stock' => 500, 'dosage' => '500mg'],
            ['name' => 'Amoxicillin 500mg', 'category' => 'Antibiotik', 'unit' => 'kapsul', 'price' => 1200, 'stock' => 300, 'dosage' => '500mg'],
            ['name' => 'Vitamin C 100mg', 'category' => 'Vitamin', 'unit' => 'tablet', 'price' => 300, 'stock' => 400, 'dosage' => '100mg'],
            ['name' => 'Omeprazole 20mg', 'category' => 'Lambung', 'unit' => 'kapsul', 'price' => 1500, 'stock' => 200, 'dosage' => '20mg'],
            ['name' => 'Cetirizine 10mg', 'category' => 'Antihistamin', 'unit' => 'tablet', 'price' => 800, 'stock' => 250, 'dosage' => '10mg'],
            ['name' => 'Ibuprofen 400mg', 'category' => 'Analgesik', 'unit' => 'tablet', 'price' => 700, 'stock' => 300, 'dosage' => '400mg'],
            ['name' => 'Salbutamol Inhaler', 'category' => 'Pernapasan', 'unit' => 'botol', 'price' => 45000, 'stock' => 50, 'dosage' => '100mcg/dosis'],
            ['name' => 'Metformin 500mg', 'category' => 'Diabetes', 'unit' => 'tablet', 'price' => 600, 'stock' => 350, 'dosage' => '500mg'],
            ['name' => 'Amlodipine 5mg', 'category' => 'Hipertensi', 'unit' => 'tablet', 'price' => 900, 'stock' => 280, 'dosage' => '5mg'],
            ['name' => 'ORS (Oralit)', 'category' => 'Rehidrasi', 'unit' => 'sachet', 'price' => 2000, 'stock' => 150, 'dosage' => '1 sachet/200ml air'],
        ];

        foreach ($medications as $i => $med) {
            Medication::updateOrCreate(
                ['code' => 'OBT-'.str_pad((string) ($i + 1), 6, '0', STR_PAD_LEFT)],
                [...$med, 'is_active' => true]
            );
        }
    }
}
