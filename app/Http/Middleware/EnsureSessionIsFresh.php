<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Session timeout tambahan di luar konfigurasi session.lifetime,
 * agar sesi yang idle terlalu lama dipaksa logout (mis. shared komputer di RS).
 */
class EnsureSessionIsFresh
{
    private const IDLE_TIMEOUT_MINUTES = 30;

    public function handle(Request $request, Closure $next): Response
    {
        $lastActivity = $request->session()->get('last_activity_at');

        if ($lastActivity && now()->diffInMinutes($lastActivity) > self::IDLE_TIMEOUT_MINUTES) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('status', 'Sesi Anda telah berakhir karena tidak aktif. Silakan login kembali.');
        }

        $request->session()->put('last_activity_at', now());

        return $next($request);
    }
}
