<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = $request->user();

        if (! $user || ! $user->is_active) {
            abort(403, 'Akun tidak aktif atau tidak terautentikasi.');
        }

        // Super admin selalu lolos
        if ($user->hasRole('super_admin')) {
            return $next($request);
        }

        if (! $user->hasPermission($permission)) {
            abort(403, 'Anda tidak memiliki akses untuk melihat data ini.');
        }

        return $next($request);
    }
}
