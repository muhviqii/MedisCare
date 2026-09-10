<?php

namespace App\Policies;

use App\Models\Patient;
use App\Models\User;

class PatientPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('super_admin', 'admin_rs', 'dokter', 'perawat', 'petugas_pendaftaran', 'petugas_administrasi');
    }

    public function view(User $user, Patient $patient): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->hasRole('super_admin', 'admin_rs', 'petugas_pendaftaran');
    }

    public function update(User $user, Patient $patient): bool
    {
        return $user->hasRole('super_admin', 'admin_rs', 'petugas_pendaftaran');
    }

    public function delete(User $user, Patient $patient): bool
    {
        // Soft delete/nonaktifkan saja, hanya admin
        return $user->hasRole('super_admin', 'admin_rs');
    }
}
