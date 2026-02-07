<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacuna extends Model
{
    use HasFactory;

    protected $fillable = ['mascota_id', 'nombre', 'fecha_aplicacion', 'proxima_aplicacion'];
    
    // Le decimos que los campos de fecha son tipo Date para poder formatearlos
    protected $casts = [
        'fecha_aplicacion' => 'date',
        'proxima_aplicacion' => 'date',
    ];

    public function mascota()
    {
        return $this->belongsTo(Mascota::class);
    }
}