<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Buscamos los ajustes o creamos unos por defecto si no existen
        $settings = Setting::firstOrCreate(
            ['veterinaria_id' => $user->veterinaria_id],
            [
                'primary_color' => '#9333ea',
                'max_mascotas_por_cita' => 3,
                'duracion_cita_minutos' => 30
            ]
        );

        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $settings = Setting::where('veterinaria_id', $user->veterinaria_id)->first();

        $settings->update($request->all());

        return back()->with('success', '✅ Configuración actualizada correctamente.');
    }
}