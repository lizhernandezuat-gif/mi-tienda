<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Procesa el Login (Plan kok: Unificado)
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

            // --- REDIRECCIÓN INTELIGENTE (Plan kok) ---
            
            // A. Si es Super Admin -> Al Dashboard Global (Futuro)
            if (Auth::user()->rol === 'super_admin') {
                return redirect()->intended('/admin/dashboard'); 
            }

            // B. Si es Dueño de Veterinaria -> A SU lista de clientes
            return redirect()->intended('/clientes');
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