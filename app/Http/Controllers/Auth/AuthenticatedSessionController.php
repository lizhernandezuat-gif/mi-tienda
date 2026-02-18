<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Procesa el Login con redirección inteligente por veterinaria
     */
    public function store(Request $request)
    {
        // 1. Validar datos
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Intentar entrar
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // --- REDIRECCIÓN INTELIGENTE BASADA EN ROL Y VETERINARIA ---
            
            // A. Si es Super Admin -> Al Dashboard Global
            if ($user->rol === 'super_admin') {
                return redirect()->intended('/admin/dashboard');
            }

            // B. Si es Dueño de Veterinaria -> A SU lista de clientes
            // (Pero verifica que tenga veterinaria asignada)
            if ($user->tieneVeterinaria()) {
                // El middleware EnsureVeterinariaExists asegura que exista
                // Ahora el usuario verá solo los clientes de SU veterinaria
                return redirect()->intended('/clientes');
            }

            // C. Si no tiene veterinaria asignada -> Crear una
            return redirect()->route('veterinarias.create')
                ->with('warning', 'Primero debes crear tu sucursal (veterinaria) antes de continuar.');
        }

        // 3. Si falla (contraseña mal)
        return back()->withErrors([
            'email' => 'Las credenciales no coinciden.',
        ])->onlyInput('email');
    }

    /**
     * Cerrar Sesión
     */
    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}