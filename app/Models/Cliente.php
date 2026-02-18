<?php

namespace App\Models;

use App\Scopes\VeterinariaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'veterinaria_id',
        'nombre',
        'email',
        'telefono',
        'direccion',
        'ciudad',
        'notas',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Global Scopes (Seguridad Automática)
    |--------------------------------------------------------------------------
    */

    /**
     * Aplicar Global Scope al crear el modelo
     * Esto filtra AUTOMÁTICAMENTE todas las consultas por veterinaria_id
     */
   // --- PEGA ESTO ---
protected static function booted()
    {
        static::addGlobalScope('veterinaria', function ($builder) {
            if (auth()->check()) {
                $builder->where('veterinaria_id', auth()->user()->veterinaria_id);
            }
        });
    }
// -----------------

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    /**
     * Un Cliente pertenece a UNA Veterinaria
     */
    public function veterinaria()
    {
        return $this->belongsTo(Veterinaria::class);
    }

    /**
     * Un Cliente puede tener MUCHAS Mascotas
     */
    public function mascotas()
{
    return $this->hasMany(Mascota::class)->withoutGlobalScopes();
}

    /**
     * Un Cliente puede tener MUCHAS Citas
     */
    public function citas()
    {
        return $this->hasMany(Cita::class);
    }
}