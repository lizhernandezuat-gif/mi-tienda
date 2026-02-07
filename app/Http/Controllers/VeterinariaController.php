<?php
namespace App\Http\Controllers;

// --- ZONA DE IMPORTACIONES (Las Herramientas) ---
use App\Models\Veterinaria;
use App\Models\User;                 // <--- Para crear usuarios
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // <--- Para encriptar contraseñas (Arregla tu error actual)
use Illuminate\Support\Facades\Auth; // <--- Para hacer autologin

class VeterinariaController extends Controller
{
    // Esta función decide a dónde vas cuando entras a la app
    public function welcome()
    {
        $veterinaria = Veterinaria::first();

        if ($veterinaria) {
            // CASO 1: Ya existe veterinaria -> ¡Vamos directo a los clientes!
            // (Simulando entrar al feed de una red social)
            return redirect()->route('clientes.index');
        } else {
            // CASO 2: No existe -> Te mando a configurar (Setup)
            return redirect()->route('veterinarias.setup');
        }
    }

    // Muestra el formulario de configuración
   public function setup()
    {
        return view('veterinarias.setup');
    }

    // Guarda la Veterinaria Y el Usuario al mismo tiempo
    public function store(Request $request)
    {
        // 1. Validar
        $request->validate([
            'nombre_veterinaria' => 'required',
            'direccion' => 'required',
            'telefono' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        // 2. Crear la Veterinaria
        $veterinaria = Veterinaria::create([
            'nombre' => $request->nombre_veterinaria,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
        ]);

        // 3. Crear el Usuario Dueño vinculado a esa veterinaria
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => 'owner',
            'veterinaria_id' => $veterinaria->id, // ¡Aquí está la magia!
        ]);

        // 4. Autologin (Entrar directo)
        Auth::login($user);

        // 5. Redirigir a clientes
        return redirect('/clientes');
    }


    // Muestra el perfil (Tu círculo MT)
    public function show()
    {
        $veterinaria = Veterinaria::first();

        // Protección extra: Si intenta ver perfil y no existe, va al setup
        if (!$veterinaria) {
            return redirect()->route('veterinarias.setup');
        }

        return view('veterinarias.show', compact('veterinaria'));
    }

    // MOSTRAR FORMULARIO DE EDICIÓN
    public function edit()
    {
        $veterinaria = Veterinaria::firstOrFail();
        return view('veterinarias.edit', compact('veterinaria'));
    }

    // GUARDAR CAMBIOS
    public function update(Request $request)
    {
        $veterinaria = Veterinaria::firstOrFail();

        // Validamos igual que en el Setup
        $datos = $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:50',
            'direccion' => 'required|string|max:255',
            'slogan' => 'nullable|string|max:255',
            'rfc' => 'nullable|string|max:20',
            'horario' => 'nullable|string|max:100',
        ], [
            'nombre.required' => 'El nombre de la veterinaria es obligatorio.',
            'telefono.required' => 'El teléfono es necesario.',
            'direccion.required' => 'La dirección es obligatoria.'
        ]);

        // Actualizamos
        $veterinaria->update($datos);

        // Regresamos al perfil con éxito
        return redirect()->route('veterinarias.show');
    }
}