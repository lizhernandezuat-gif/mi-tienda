<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mascota extends Model
{
    use HasFactory;

    // AQUI ES DONDE AUTORIZAMOS LOS CAMPOS
    protected $fillable = [
        'cliente_id',
        'nombre',
        'especie',
        'raza',
        'color',
        'peso',
        'edad',
        'notas_medicas',
        'foto',   // <--- ¡NUEVO! Para guardar la ruta de la imagen
        'estado', // <--- ¡NUEVO! Para guardar si está Sano/Hospitalizado
        'veterinaria_id',
        'user_id',

    ];

    // Relación con Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
    public function vacunas()
     { return $this->hasMany(Vacuna::class); }
}