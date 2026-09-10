<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'Super Admin', 'slug' => 'super_admin', 'description' => 'Akses penuh seluruh sistem'],
            ['name' => 'Admin Rumah Sakit', 'slug' => 'admin_rs', 'description' => 'Mengelola operasional harian rumah sakit'],
            ['name' => 'Dokter', 'slug' => 'dokter', 'description' => 'Pelayanan medis & rekam medis pasien'],
            ['name' => 'Perawat', 'slug' => 'perawat', 'description' => 'Mendampingi pelayanan medis'],
            ['name' => 'Petugas Pendaftaran', 'slug' => 'petugas_pendaftaran', 'description' => 'Pendaftaran pasien & antrean'],
            ['name' => 'Petugas Administrasi', 'slug' => 'petugas_administrasi', 'description' => 'Invoice & pembayaran, tanpa akses rekam medis klinis'],
            ['name' => 'Manajemen', 'slug' => 'manajemen', 'description' => 'Statistik agregat, tanpa akses data medis individual'],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['slug' => $role['slug']], $role);
        }
    }
}
