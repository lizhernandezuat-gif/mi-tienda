<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <--- OBLIGATORIO para saber quién eres

class ClienteController extends Controller
{
    /**
     * Muestra la lista de clientes (SOLO los de mi veterinaria)
     */
    public function index(Request $request)
    {
        $busqueda = trim($request->input('search'));
        $query = Cliente::with('mascotas');

        if ($busqueda) {
            // 1. Buscamos coincidencias
            $query->where(function ($q) use ($busqueda) {
                $q->where('nombre', 'LIKE', '%' . $busqueda . '%')
                  ->orWhere('telefono', 'LIKE', '%' . $busqueda . '%')
                  ->orWhereHas('mascotas', function ($queryMascota) use ($busqueda) {
                      $queryMascota->where('nombre', 'LIKE', '%' . $busqueda . '%');
                  });
            });

            // 2. Ordenamos para que los que empiezan con tu texto salgan primero
            $query->orderByRaw("
                CASE 
                    WHEN nombre LIKE ? THEN 1 
                    WHEN telefono LIKE ? THEN 2
                    ELSE 3 
                END ASC
            ", ["{$busqueda}%", "{$busqueda}%"]);
        } else {
            $query->orderBy('id', 'desc');
        }

        $clientes = $query->paginate(10);

        // --- LA MAGIA MEJORADA (El Francotirador) ---
        if ($busqueda) {
            
            // Caso A: Solo hay 1 resultado en toda la base de datos (Ej. Teléfono único)
            if ($clientes->total() == 1) {
                return redirect()->route('clientes.show', $clientes->first()->id);
            }

            // Caso B: Hay varios, pero buscaremos si hay una COINCIDENCIA EXACTA.
            // Ej: Buscaste "Ana". Encontró a "Ana", "Mariana" y "Ana Silvia".
            if ($clientes->total() > 1) {
                $coincidenciaExacta = $clientes->first(function ($cliente) use ($busqueda) {
                    // Verificamos si el nombre o el teléfono es exactamente igual (sin importar mayúsculas)
                    return strtolower($cliente->nombre) === strtolower($busqueda) || 
                           $cliente->telefono === $busqueda;
                });

                // Si encontramos a la "Ana" exacta, vamos directo a ella.
                if ($coincidenciaExacta) {
                    return redirect()->route('clientes.show', $coincidenciaExacta->id);
                }
            }
        }

        // Si buscaste una mascota repetida o coincidencias parciales, mostramos la lista.
        return view('clientes.index', compact('clientes', 'busqueda'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Guarda un nuevo cliente vinculado a mi empresa
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email', // Quitamos 'unique' simple para permitir repetir email en DIFERENTES veterinarias
            'telefono' => 'required|string',
        ]);

        // Crear el cliente inyectando el ID de la empresa
        Cliente::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'mascota' => 'Sin asignar', // Valor por defecto para cumplir con tu base de datos
            'veterinaria_id' => Auth::user()->veterinaria_id, // <--- LA CLAVE
        ]);

        return redirect()->route('clientes.index')->with('success', 'Cliente registrado correctamente.');
    }

    public function show($id)
    {
        // Seguridad: Solo ver si es mio
        $cliente = Cliente::where('veterinaria_id', Auth::user()->veterinaria_id)->findOrFail($id);
        return view('clientes.show', compact('cliente'));
    }

    public function edit($id)
    {
        // Seguridad: Solo editar si es mio
        $cliente = Cliente::where('veterinaria_id', Auth::user()->veterinaria_id)->findOrFail($id);
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, $id)
    {
        // Seguridad: Buscar primero con el filtro
        $cliente = Cliente::where('veterinaria_id', Auth::user()->veterinaria_id)->findOrFail($id);

        $request->validate([
            'nombre' => 'required',
            'email' => 'required|email',
        ]);

        $cliente->update($request->all());

        return redirect()->route('clientes.index');
    }

    public function destroy($id)
    {
        // Seguridad: Solo borrar si es mio
        $cliente = Cliente::where('veterinaria_id', Auth::user()->veterinaria_id)->findOrFail($id);
        
        $cliente->delete();
        return redirect()->route('clientes.index');
    }
}