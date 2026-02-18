<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserBelongsToVeterinaria
{
    /**
     * Handle an incoming request.
     * 
     * Verifica que el usuario autenticado pertenezca a una veterinaria
     * y que tenga acceso a los datos que está intentando ver.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Si no hay usuario autenticado, dejar pasar (será manejado por 'auth' middleware)
        if (!$user) {
            return $next($request);
        }

        // Si es super_admin, dejar pasar sin restricciones
        if ($user->rol === 'super_admin') {
            return $next($request);
        }

        // Si el usuario no tiene veterinaria asignada, redirigir a crear una
        if (!$user->tieneVeterinaria()) {
            return redirect()->route('veterinarias.create')
                ->with('error', 'Debes asignar una veterinaria a tu cuenta primero.');
        }

        // ✅ El usuario tiene veterinaria: permitir acceso
        // Los controladores usarán $user->veterinaria_id para filtrar datos
        return $next($request);
    }
}