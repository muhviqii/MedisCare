<?php

namespace App\Policies;

use App\Models\MedicalRecord;
use App\Models\User;

class MedicalRecordPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('super_admin', 'admin_rs', 'dokter', 'perawat');
    }

    /**
     * Dokter hanya dapat melihat rekam medis pasien yang berkaitan
     * dengan pelayanan/tugasnya. Petugas administrasi TIDAK boleh
     * melihat detail rekam medis klinis sama sekali.
     */
    public function view(User $user, MedicalRecord $record): bool
    {
        if ($user->hasRole('super_admin', 'admin_rs')) {
            return true;
        }

        if ($user->hasRole('dokter')) {
            return $user->doctor && $record->doctor_id === $user->doctor->id;
        }

        if ($user->hasRole('perawat')) {
            return $user->nurse && $record->nurse_id === $user->nurse->id;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('super_admin', 'admin_rs', 'dokter');
    }

    public function update(User $user, MedicalRecord $record): bool
    {
        // Rekam medis tidak pernah dihapus permanen; update dicatat sebagai revisi (audit trail)
        if ($user->hasRole('super_admin')) {
            return true;
        }

        return $user->hasRole('dokter') && $user->doctor && $record->doctor_id === $user->doctor->id;
    }

    public function delete(User $user, MedicalRecord $record): bool
    {
        // Tidak ada hard delete rekam medis untuk siapa pun
        return false;
    }
}
