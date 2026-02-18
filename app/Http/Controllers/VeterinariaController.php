<?php

namespace App\Http\Controllers;

// --- ZONA DE IMPORTACIONES ---
use App\Models\Veterinaria;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; // <--- VITAL para saber quién está conectado

class VeterinariaController extends Controller
{
    // 1. Pantalla de Bienvenida / Redirección Inteligente
    public function welcome()
    {
        // Si el usuario YA está logueado...
        if (Auth::check()) {
            // ... y tiene una veterinaria asignada, lo mandamos a su panel
            if (Auth::user()->veterinaria) {
                return redirect()->route('clientes.index');
            }
        }

        // Si no, mostramos la página de bienvenida (login/registro)
        return view('welcome'); 
    }

    // 2. Muestra el formulario de configuración inicial (Solo si vas a registrar vets manualmente)
    public function setup()
    {
        return view('veterinarias.setup');
    }

    // 3. Guarda la Veterinaria Y el Usuario (Registro)
    public function store(Request $request)
    {
        // Validar
        $request->validate([
            'nombre_veterinaria' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        // Crear la Veterinaria
        $veterinaria = Veterinaria::create([
            'nombre' => $request->nombre_veterinaria,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'ciudad' => $request->ciudad ?? 'Sin definir', // Agregamos ciudad por si acaso
        ]);

        // Crear el Usuario Dueño vinculado
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => 'owner', // Opcional si usas roles
            'veterinaria_id' => $veterinaria->id, // ¡Aquí está la magia!
        ]);

        // Autologin
        Auth::login($user);

        return redirect()->route('clientes.index');
    }

    // 4. Muestra la configuración (PERFIL) de TU veterinaria
    public function show()
    {
        // CORREGIDO: Usamos Auth para traer SOLO la tuya
        $veterinaria = Auth::user()->veterinaria;

        // Si por alguna razón el usuario no tiene veterinaria, lo mandamos a crear una
        if (!$veterinaria) {
            return redirect()->route('veterinarias.setup');
        }

        return view('veterinarias.show', compact('veterinaria'));
    }

    // 5. Muestra formulario de EDICIÓN de TU veterinaria
    public function edit()
    {
        // CORREGIDO: Solo puedes editar la tuya
        $veterinaria = Auth::user()->veterinaria;
        return view('veterinarias.edit', compact('veterinaria'));
    }

    // 6. GUARDAR CAMBIOS (El arreglo del "Efecto Espejo")
    public function update(Request $request)
    {
        // CORREGIDO: Buscamos la veterinaria del usuario conectado, NO la primera de la BD
        $veterinaria = Auth::user()->veterinaria;

        // Validamos
        $datos = $request->validate([
            'nombre'    => 'required|string|max:255',
            'telefono'  => 'required|string|max:50',
            'direccion' => 'required|string|max:255',
            'slogan'    => 'nullable|string|max:255',
            'rfc'       => 'nullable|string|max:20',
            'horario'   => 'nullable|string|max:100',
            'ciudad'    => 'nullable|string|max:100', // Agregamos ciudad
        ], [
            'nombre.required' => 'El nombre de la veterinaria es obligatorio.',
        ]);

        // Actualizamos SOLO la veterinaria del usuario
        $veterinaria->update($datos);

        // Regresamos al perfil con éxito
        return back()->with('success', 'Información actualizada correctamente');
    }
}