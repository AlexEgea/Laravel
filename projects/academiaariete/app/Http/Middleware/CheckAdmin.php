<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdmin
{
    /**
     * Maneja la petición entrante.
     */
    public function handle(Request $request, Closure $next)
    {
        // Usuario autenticado (puede ser null)
        $user = $request->user();

        // ❌ Si NO hay usuario o NO tiene rol admin → 403
        if (!$user || !$user->hasRole('admin')) {
            abort(403, 'Acceso no autorizado');
        }

        // ✅ Solo admins pasan
        return $next($request);
    }
}
