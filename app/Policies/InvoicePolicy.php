<?php

namespace App\Policies;

use App\Models\Invoice;
use App\Models\User;

class InvoicePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('super_admin', 'admin_rs', 'petugas_administrasi', 'manajemen');
    }

    public function view(User $user, Invoice $invoice): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->hasRole('super_admin', 'admin_rs', 'petugas_administrasi');
    }

    public function processPayment(User $user): bool
    {
        return $user->hasRole('super_admin', 'admin_rs', 'petugas_administrasi');
    }
}
