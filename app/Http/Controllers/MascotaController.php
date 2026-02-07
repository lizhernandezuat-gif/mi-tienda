<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <--- ¡MUY IMPORTANTE! Sin esto falla el login

class MascotaController extends Controller
{
    /**
     * Muestra TODAS las mascotas de la veterinaria actual.
     * (Esta es la función que te faltaba para ver el listado general)
     */
    public function index()
    {
        // 1. Obtenemos el ID de la veterinaria del usuario conectado
        $veterinariaId = Auth::user()->veterinaria_id;

        // 2. Traemos SOLO las mascotas de ESTA empresa
        // Usamos 'with'('cliente') para que la consulta sea más rápida al mostrar el dueño
        $mascotas = Mascota::where('veterinaria_id', $veterinariaId)
                            ->with('cliente') 
                            ->get();

        return view('mascotas.index', compact('mascotas'));
    }

    // Muestra el formulario para crear mascota (vinculada a un cliente)
    public function create($cliente_id)
    {
        // Seguridad: Verificar que el cliente pertenezca a mi veterinaria
        $cliente = Cliente::where('veterinaria_id', Auth::user()->veterinaria_id)
                          ->findOrFail($cliente_id);

        return view('mascotas.create', compact('cliente'));
    }

    // GUARDAR (Store)
    public function store(Request $request, $cliente_id)
    {
        // 1. Verificar seguridad del cliente
        $cliente = Cliente::where('veterinaria_id', Auth::user()->veterinaria_id)
                          ->findOrFail($cliente_id);

        $request->validate([
            'nombre' => 'required|string|max:100',
            'especie' => 'required|string',
            'foto' => 'nullable|image|max:2048',
            'estado' => 'required|string',
        ]);

        $rutaFoto = null;
        if ($request->hasFile('foto')) {
            $rutaFoto = $request->file('foto')->store('mascotas', 'public');
        }

        // 2. CREAR LA MASCOTA CON EL "ADN" DE LA VETERINARIA
        $cliente->mascotas()->create([
            'nombre' => $request->nombre,
            'especie' => $request->especie,
            'raza' => $request->raza,
            'color' => $request->color,
            'peso' => $request->peso,
            'edad' => $request->edad,
            'notas_medicas' => $request->notas_medicas,
            'foto' => $rutaFoto,
            'estado' => $request->estado,
            
            // --- CAMPOS CRÍTICOS MULTI-TENANCY ---
            'veterinaria_id' => Auth::user()->veterinaria_id, // ¡Aquí está la magia!
            'user_id' => Auth::id(), // Guardamos qué empleado la creó
        ]);

        return redirect()->route('clientes.show', $cliente->id);
    }

    // EDITAR: Muestra el formulario
    public function edit($id)
    {
        // Seguridad: Solo busco mascotas que coincidan con MI veterinaria_id
        $mascota = Mascota::where('veterinaria_id', Auth::user()->veterinaria_id)
                          ->findOrFail($id);
                          
        return view('mascotas.edit', compact('mascota'));
    }

    // ACTUALIZAR (Update)
    public function update(Request $request, $id)
    {
        // Seguridad: Primero busco la mascota filtrando por mi veterinaria
        $mascota = Mascota::where('veterinaria_id', Auth::user()->veterinaria_id)
                          ->findOrFail($id);

        $request->validate([
            'nombre' => 'required|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        $datos = $request->except(['foto']);

        if ($request->hasFile('foto')) {
            $datos['foto'] = $request->file('foto')->store('mascotas', 'public');
        }

        $mascota->update($datos);

        return redirect()->route('clientes.show', $mascota->cliente_id);
    }

    // ELIMINAR
    public function destroy($id)
    {
        // Seguridad: Solo puedo borrar mis propias mascotas
        $mascota = Mascota::where('veterinaria_id', Auth::user()->veterinaria_id)
                          ->findOrFail($id);
                          
        $cliente_id = $mascota->cliente_id;
        $mascota->delete();

        return redirect()->route('clientes.show', $cliente_id);
    }
}