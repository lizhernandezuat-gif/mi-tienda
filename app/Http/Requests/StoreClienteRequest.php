<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClienteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'nombre' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telefono' => 'required|string|max:50|unique:clientes,telefono',
            'telefono_alterno' => 'nullable|string|max:50',
            'nombre_mascota' => 'required|string|max:255',
            'tipo_mascota' => 'nullable|string|max:100',
            'raza_mascota' => 'nullable|string|max:100',
            'edad_mascota' => 'nullable|integer|min:0',
            'domicilio' => 'nullable|string|max:500',
            'fecha_nacimiento' => 'nullable|date',
            'preferencia_contacto' => 'nullable|string|max:100',
            'contacto_emergencia' => 'nullable|string|max:255',
            'activo' => 'nullable|boolean',
            'notas' => 'nullable|string',
        ];

        if (\Illuminate\Support\Facades\Schema::hasTable('veterinarias')) {
            $rules['veterinaria_id'] = 'required|exists:veterinarias,id';
        } else {
            $rules['veterinaria_id'] = 'nullable';
        }

        return $rules;
    }
}
