<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'phone', 'avatar', 'is_active',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function doctor(): HasOne
    {
        return $this->hasOne(Doctor::class);
    }

    public function nurse(): HasOne
    {
        return $this->hasOne(Nurse::class);
    }

    public function hasRole(string ...$slugs): bool
    {
        return $this->role && in_array($this->role->slug, $slugs, true);
    }

    public function hasPermission(string $slug): bool
    {
        $role = $this->role;

        if (! $role) {
            return false;
        }

        if ($role->hasPermission($slug)) {
            return true;
        }

        $fallbackPermissions = [
            'super_admin' => ['patients.view', 'patients.manage', 'medical_records.view', 'medical_records.manage', 'doctors.manage', 'schedules.manage', 'registrations.manage', 'queues.manage', 'admissions.manage', 'pharmacy.manage', 'laboratory.manage', 'radiology.manage', 'billing.manage', 'reports.aggregate', 'reports.detailed', 'users.manage', 'audit_logs.view'],
            'admin_rs' => ['patients.view', 'patients.manage', 'medical_records.view', 'doctors.manage', 'schedules.manage', 'registrations.manage', 'queues.manage', 'admissions.manage', 'pharmacy.manage', 'laboratory.manage', 'radiology.manage', 'billing.manage', 'reports.aggregate', 'reports.detailed', 'users.manage', 'audit_logs.view'],
            'dokter' => ['patients.view', 'medical_records.view', 'medical_records.manage', 'pharmacy.manage', 'laboratory.manage', 'radiology.manage', 'queues.manage'],
            'perawat' => ['patients.view', 'medical_records.view', 'admissions.manage'],
            'petugas_pendaftaran' => ['patients.view', 'patients.manage', 'registrations.manage', 'queues.manage'],
            'petugas_administrasi' => ['patients.view', 'billing.manage'],
            'manajemen' => ['reports.aggregate'],
        ];

        return in_array($slug, $fallbackPermissions[$role->slug] ?? [], true);
    }
}
