<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Membuat 1 akun contoh per role untuk kebutuhan demo/testing.
     * SEMUA data dummy, bukan data nyata. Password default WAJIB diganti
     * setelah instalasi production.
     */
    public function run(): void
    {
        $accounts = [
            ['name' => 'Super Admin', 'email' => 'superadmin@mediscare.local', 'role' => 'super_admin'],
            ['name' => 'Admin RS Demo', 'email' => 'admin@mediscare.local', 'role' => 'admin_rs'],
            ['name' => 'dr. Andi Wijaya', 'email' => 'dr.andi@mediscare.local', 'role' => 'dokter'],
            ['name' => 'Perawat Sari', 'email' => 'perawat.sari@mediscare.local', 'role' => 'perawat'],
            ['name' => 'Petugas Daftar Rina', 'email' => 'pendaftaran@mediscare.local', 'role' => 'petugas_pendaftaran'],
            ['name' => 'Petugas Admin Budi', 'email' => 'administrasi@mediscare.local', 'role' => 'petugas_administrasi'],
            ['name' => 'Manajemen Dewi', 'email' => 'manajemen@mediscare.local', 'role' => 'manajemen'],
        ];

        foreach ($accounts as $account) {
            $role = Role::where('slug', $account['role'])->first();

            User::updateOrCreate(
                ['email' => $account['email']],
                [
                    'name' => $account['name'],
                    'password' => Hash::make('Password123'),
                    'role_id' => $role?->id,
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}
