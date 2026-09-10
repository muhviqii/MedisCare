<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name' => 'Lihat Pasien', 'slug' => 'patients.view', 'module' => 'patients'],
            ['name' => 'Kelola Pasien', 'slug' => 'patients.manage', 'module' => 'patients'],
            ['name' => 'Lihat Rekam Medis', 'slug' => 'medical_records.view', 'module' => 'medical_records'],
            ['name' => 'Kelola Rekam Medis', 'slug' => 'medical_records.manage', 'module' => 'medical_records'],
            ['name' => 'Kelola Dokter', 'slug' => 'doctors.manage', 'module' => 'doctors'],
            ['name' => 'Kelola Jadwal', 'slug' => 'schedules.manage', 'module' => 'schedules'],
            ['name' => 'Kelola Pendaftaran', 'slug' => 'registrations.manage', 'module' => 'registrations'],
            ['name' => 'Kelola Antrean', 'slug' => 'queues.manage', 'module' => 'queues'],
            ['name' => 'Kelola Rawat Inap', 'slug' => 'admissions.manage', 'module' => 'admissions'],
            ['name' => 'Kelola Resep & Obat', 'slug' => 'pharmacy.manage', 'module' => 'pharmacy'],
            ['name' => 'Kelola Laboratorium', 'slug' => 'laboratory.manage', 'module' => 'laboratory'],
            ['name' => 'Kelola Radiologi', 'slug' => 'radiology.manage', 'module' => 'radiology'],
            ['name' => 'Kelola Invoice & Pembayaran', 'slug' => 'billing.manage', 'module' => 'billing'],
            ['name' => 'Lihat Laporan Agregat', 'slug' => 'reports.aggregate', 'module' => 'reports'],
            ['name' => 'Lihat Laporan Rinci', 'slug' => 'reports.detailed', 'module' => 'reports'],
            ['name' => 'Kelola Pengguna', 'slug' => 'users.manage', 'module' => 'users'],
            ['name' => 'Lihat Audit Log', 'slug' => 'audit_logs.view', 'module' => 'audit_logs'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['slug' => $permission['slug']], $permission);
        }

        $map = [
            'admin_rs' => ['patients.view', 'patients.manage', 'medical_records.view', 'doctors.manage', 'schedules.manage', 'registrations.manage', 'queues.manage', 'admissions.manage', 'pharmacy.manage', 'laboratory.manage', 'radiology.manage', 'billing.manage', 'reports.aggregate', 'reports.detailed', 'users.manage', 'audit_logs.view'],
            'dokter' => ['patients.view', 'medical_records.view', 'medical_records.manage', 'pharmacy.manage', 'laboratory.manage', 'radiology.manage', 'queues.manage'],
            'perawat' => ['patients.view', 'medical_records.view', 'admissions.manage'],
            'petugas_pendaftaran' => ['patients.view', 'patients.manage', 'registrations.manage', 'queues.manage'],
            'petugas_administrasi' => ['patients.view', 'billing.manage'], // TIDAK diberi medical_records.view
            'manajemen' => ['reports.aggregate'], // TIDAK diberi reports.detailed / medical_records.view
        ];

        foreach ($map as $roleSlug => $permissionSlugs) {
            $role = Role::where('slug', $roleSlug)->first();
            if (! $role) {
                continue;
            }
            $ids = Permission::whereIn('slug', $permissionSlugs)->pluck('id');
            $role->permissions()->syncWithoutDetaching($ids);
        }
    }
}
