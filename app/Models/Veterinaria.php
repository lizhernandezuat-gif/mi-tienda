<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Veterinaria extends Model
{
    use HasFactory;

    // Aquí autorizamos todos los campos de tu nuevo formulario
    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'slogan',   // Nuevo
        'rfc',      // Nuevo
        'horario',  // Nuevo
        'activo'
    ];
}