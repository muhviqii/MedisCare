<?php

namespace App\Providers;

use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Policies\DoctorPolicy;
use App\Policies\InvoicePolicy;
use App\Policies\MedicalRecordPolicy;
use App\Policies\PatientPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Patient::class => PatientPolicy::class,
        MedicalRecord::class => MedicalRecordPolicy::class,
        Doctor::class => DoctorPolicy::class,
        Invoice::class => InvoicePolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        // Gate tambahan untuk laporan (tidak terikat satu Model spesifik)
        Gate::define('reports.view-aggregate', fn ($user) => (new \App\Policies\ReportPolicy)->viewAggregate($user));
        Gate::define('reports.view-detailed', fn ($user) => (new \App\Policies\ReportPolicy)->viewDetailed($user));
        Gate::define('reports.export', fn ($user) => (new \App\Policies\ReportPolicy)->export($user));
        Gate::define('audit-logs.view', fn ($user) => (new \App\Policies\AuditLogPolicy)->viewAny($user));

        // Super admin selalu diizinkan untuk aksi normal, kecuali hard delete rekam medis.
        Gate::before(function ($user, $ability, $arguments = []) {
            if (in_array($ability, ['delete', 'forceDelete'], true)) {
                $model = $arguments[0] ?? null;

                if ($model instanceof \App\Models\MedicalRecord) {
                    return false;
                }
            }

            return $user->hasRole('super_admin') ? true : null;
        });
    }
}
