<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Polyclinic;
use App\Models\Specialty;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * 5-10 dokter dummy sesuai Bagian 34.
     */
    public function run(): void
    {
        $doctors = [
            ['name' => 'dr. Andi Wijaya', 'specialty' => 'umum', 'polyclinic' => 'POLI-UMM'],
            ['name' => 'dr. Siti Rahma, Sp.A', 'specialty' => 'anak', 'polyclinic' => 'POLI-ANK'],
            ['name' => 'drg. Rina Kartika', 'specialty' => 'gigi', 'polyclinic' => 'POLI-GIG'],
            ['name' => 'dr. Bambang Sutrisno, Sp.PD', 'specialty' => 'penyakit-dalam', 'polyclinic' => 'POLI-PDL'],
            ['name' => 'dr. Yusuf Hidayat, Sp.B', 'specialty' => 'bedah', 'polyclinic' => 'POLI-BDH'],
            ['name' => 'dr. Maria Angelina', 'specialty' => 'umum', 'polyclinic' => 'POLI-UMM'],
            ['name' => 'dr. Fajar Nugroho, Sp.A', 'specialty' => 'anak', 'polyclinic' => 'POLI-ANK'],
        ];

        foreach ($doctors as $i => $doc) {
            $specialty = Specialty::where('slug', $doc['specialty'])->first();
            $polyclinic = Polyclinic::where('code', $doc['polyclinic'])->first();

            Doctor::updateOrCreate(
                ['doctor_code' => 'DOK-'.str_pad((string) ($i + 1), 6, '0', STR_PAD_LEFT)],
                [
                    'name' => $doc['name'],
                    'nip' => '198'.str_pad((string) ($i + 1), 12, '0', STR_PAD_LEFT),
                    'str_number' => 'STR-'.str_pad((string) ($i + 1), 8, '0', STR_PAD_LEFT),
                    'sip_number' => 'SIP-'.str_pad((string) ($i + 1), 8, '0', STR_PAD_LEFT),
                    'specialty_id' => $specialty?->id,
                    'polyclinic_id' => $polyclinic?->id,
                    'email' => 'dokter'.($i + 1).'@mediscare.local',
                    'phone' => '0812000000'.($i + 1),
                    'status' => 'active',
                ]
            );
        }
    }
}
