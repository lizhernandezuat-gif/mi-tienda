<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    // Campos que permitimos guardar
    protected $fillable = [
        'veterinaria_id',
        'primary_color',
        'dark_mode',
        'slogan',
        'rfc',
        'direccion_completa',
        'duracion_cita_minutos',
        'max_mascotas_por_cita',
        'hora_apertura',
        'hora_cierre',
        'agenda_abierta'
    ];

    // Relación: Una configuración pertenece a una veterinaria
    public function veterinaria()
    {
        return $this->belongsTo(Veterinaria::class);
    }
}