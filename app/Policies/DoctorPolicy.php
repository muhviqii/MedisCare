<?php

namespace App\Policies;

use App\Models\Doctor;
use App\Models\User;

class DoctorPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // semua role login dapat melihat daftar dokter (untuk pendaftaran, dsb)
    }

    public function view(User $user, Doctor $doctor): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('super_admin', 'admin_rs');
    }

    public function update(User $user, Doctor $doctor): bool
    {
        return $user->hasRole('super_admin', 'admin_rs');
    }

    public function delete(User $user, Doctor $doctor): bool
    {
        return $user->hasRole('super_admin');
    }
}
