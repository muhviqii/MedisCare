<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as RequestFacade;

/**
 * Service terpusat untuk mencatat aktivitas sensitif (Bagian 24 - Audit Log).
 * Jangan menyimpan informasi sensitif yang tidak diperlukan di audit log:
 * hanya user, role, action, module, record id, timestamp, ip, user agent.
 */
class AuditLogService
{
    public function log(string $action, string $module, ?int $recordId = null): AuditLog
    {
        $user = Auth::user();

        return AuditLog::create([
            'user_id' => $user?->id,
            'role_snapshot' => $user?->role?->slug,
            'action' => $action,
            'module' => $module,
            'record_id' => $recordId,
            'ip_address' => RequestFacade::ip(),
            'user_agent' => substr((string) RequestFacade::userAgent(), 0, 255),
            'created_at' => now(),
        ]);
    }
}
