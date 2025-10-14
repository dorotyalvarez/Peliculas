<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Verifica si el usuario está autenticado
        if (!auth()->check()) {
            abort(401, 'No autenticado.');
        }

        // Obtiene el rol del usuario autenticado
        $userRole = auth()->user()->role ?? 'user';

        // Si el rol del usuario NO está dentro de los roles permitidos
        if (!in_array($userRole, $roles)) {
            abort(403, 'Acceso denegado.');
        }

        // Si todo va bien, continúa
        return $next($request);
    }
}
