<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    // Campos que permitimos guardar masivamente
    protected $fillable = [
        'user_id',
        'fecha_hora_inicio',
        'motivo',
        'estado',
        'notas_internas',
    ];

    // Le decimos a Laravel que 'fecha_hora_inicio' es una fecha real (Carbon), no texto
    protected $casts = [
        'fecha_hora_inicio' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    // Una cita pertenece a un Usuario (el Cliente)
    public function cliente()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Una cita puede tener MUCHAS mascotas (Relación Muchos a Muchos)
    // Usamos la tabla pivote 'cita_mascota'
    public function mascotas()
    {
        return $this->belongsToMany(Mascota::class, 'cita_mascota');
    }
}