<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware role-check. Ini HANYA lapisan pertama (UX/routing).
 * Otorisasi sesungguhnya tetap wajib melalui Policy/Gate di setiap Controller
 * agar tidak bergantung pada "menyembunyikan tombol di frontend" saja.
 */
class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user || ! $user->is_active) {
            abort(403, 'Akun tidak aktif atau tidak terautentikasi.');
        }

        if (! $user->hasRole(...$roles)) {
            abort(403, 'Anda tidak memiliki akses untuk melihat data ini.');
        }

        return $next($request);
    }
}
