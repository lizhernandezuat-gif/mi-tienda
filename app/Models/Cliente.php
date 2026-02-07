<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'telefono_alterno',
        'domicilio',
        'preferencia_contacto',
        'contacto_emergencia',
        'mascota', // Nombre de la mascota
        'raza',
        'edad',
        'fecha_nacimiento',
        'tipo', // Perro, Gato, etc.
        'notas',
        'activo',
        'veterinaria_id',
        'user_id',

    ];

    public function veterinaria()
    {
        return $this->belongsTo(Veterinaria::class);
    }

    public function mascotas()
    {
        return $this->hasMany(Mascota::class);
    }
}