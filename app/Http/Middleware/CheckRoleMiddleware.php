<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware untuk cek role user sebelum akses route
 */
class CheckRoleMiddleware
{
    /**
     * Handle request: cek apakah user punya role yang diizinkan
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Redirect ke login jika belum login
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // Forbidden jika role tidak sesuai
        if (!in_array($request->user()->role, $roles)) {
            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }
}
