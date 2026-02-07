<?php

namespace App\Http\Controllers;

use App\Models\Vacuna;
use App\Models\Mascota;
use Illuminate\Http\Request;

class VacunaController extends Controller
{
    // Ver la cartilla
    public function index($mascota_id)
    {
        $mascota = Mascota::with(['vacunas' => function($query) {
            $query->orderBy('fecha_aplicacion', 'desc'); // Las más recientes primero
        }])->findOrFail($mascota_id);
        
        return view('vacunas.index', compact('mascota'));
    }

    // Guardar nueva vacuna
    public function store(Request $request, $mascota_id)
    {
        $request->validate([
            'nombre' => 'required|string',
            'fecha_aplicacion' => 'required|date',
            'proxima_aplicacion' => 'nullable|date|after:fecha_aplicacion',
        ]);

        Vacuna::create([
            'mascota_id' => $mascota_id,
            'nombre' => $request->nombre,
            'fecha_aplicacion' => $request->fecha_aplicacion,
            'proxima_aplicacion' => $request->proxima_aplicacion,
        ]);

        return back()->with('success', 'Vacuna registrada');
    }

    // Borrar vacuna (por si hay error)
    public function destroy($id)
    {
        $vacuna = Vacuna::findOrFail($id);
        $vacuna->delete();
        return back();
    }
}