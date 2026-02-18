<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource (CON GLOBAL SCOPE)
     * 
     * ✅ NOTA: El Global Scope filtra automáticamente por veterinaria_id
     * NO necesitamos escribir ->where('veterinaria_id', Auth::user()->veterinaria_id)
     */
    public function index(Request $request)
    {
        $busqueda = trim($request->input('search'));
        // ✅ Global Scope se aplica automáticamente aquí
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
            
            // Caso A: Solo hay 1 resultado
            if ($clientes->total() == 1) {
                return redirect()->route('clientes.show', $clientes->first()->id);
            }

            // Caso B: Hay varios, pero buscaremos si hay una COINCIDENCIA EXACTA
            if ($clientes->total() > 1) {
                $coincidenciaExacta = $clientes->first(function ($cliente) use ($busqueda) {
                    return strtolower($cliente->nombre) === strtolower($busqueda) || 
                           $cliente->telefono === $busqueda;
                });

                if ($coincidenciaExacta) {
                    return redirect()->route('clientes.show', $coincidenciaExacta->id);
                }
            }
        }

        return view('clientes.index', compact('clientes', 'busqueda'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telefono' => 'required|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:100',
            'notas' => 'nullable|string',
        ]);

        // ✅ Asignar automáticamente la veterinaria del usuario autenticado
        $validated['veterinaria_id'] = Auth::user()->veterinaria_id;

        Cliente::create($validated);

        return redirect()->route('clientes.index')->with('success', '✅ Cliente creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        // ✅ El Policy verifica que pertenezca a su veterinaria
        $this->authorize('view', $cliente);
        $cliente->load('mascotas');
        return view('clientes.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        // ✅ El Policy verifica que pertenezca a su veterinaria
        $this->authorize('update', $cliente);
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        // ✅ El Policy verifica que pertenezca a su veterinaria
        $this->authorize('update', $cliente);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telefono' => 'required|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:100',
            'notas' => 'nullable|string',
        ]);

        $cliente->update($validated);

        return redirect()->route('clientes.show', $cliente)->with('success', '✅ Cliente actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        // ✅ El Policy verifica que pertenezca a su veterinaria
        $this->authorize('delete', $cliente);
        $cliente->delete();

        return redirect()->route('clientes.index')->with('success', '🗑️ Cliente eliminado');
    }
}