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
        $busqueda = $request->input('search');

        $clientes = Cliente::query()
            // 1. EL FILTRO DE SEGURIDAD (GAFAS)
            ->where('veterinaria_id', Auth::user()->veterinaria_id)
            
            // 2. La lógica del buscador
            ->when($busqueda, function ($query, $busqueda) {
                return $query->where('nombre', 'like', "%{$busqueda}%")
                             ->orWhere('email', 'like', "%{$busqueda}%");
            })
            ->paginate(10); // <--- ¡AQUÍ ESTÁ EL CAMBIO! (Antes decía get)

        return view('clientes.index', compact('clientes'));
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