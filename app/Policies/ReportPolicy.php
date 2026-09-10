<?php

namespace App\Policies;

use App\Models\User;

class ReportPolicy
{
    /**
     * Manajemen dapat melihat statistik agregat TANPA otomatis
     * mendapatkan akses penuh terhadap data medis pasien per individu.
     */
    public function viewAggregate(User $user): bool
    {
        return $user->hasRole('super_admin', 'admin_rs', 'manajemen');
    }

    public function viewDetailed(User $user): bool
    {
        // Laporan rinci (menyentuh data pasien per individu) tidak untuk manajemen
        return $user->hasRole('super_admin', 'admin_rs');
    }

    public function export(User $user): bool
    {
        return $user->hasRole('super_admin', 'admin_rs', 'manajemen');
    }
}
