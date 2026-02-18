<?php

namespace App\Models;

use App\Scopes\VeterinariaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mascota extends Model
{
    use HasFactory;

    protected $table = 'mascotas';

    protected $fillable = [
        'cliente_id',
        'veterinaria_id',
        'nombre',
        'especie',
        'raza',
        'color',
        'edad',
        'peso',
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
     * Filtra AUTOMÁTICAMENTE todas las consultas por veterinaria_id
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new VeterinariaScope());
    }

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    /**
     * Una Mascota pertenece a UN Cliente
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Una Mascota pertenece a UNA Veterinaria
     */
    public function veterinaria()
    {
        return $this->belongsTo(Veterinaria::class);
    }

    /**
     * Una Mascota puede tener MUCHAS Vacunas
     */
    public function vacunas()
    {
        return $this->hasMany(Vacuna::class);
    }

    /**
     * Una Mascota puede estar en MUCHAS Citas (Relación Muchos a Muchos)
     */
    public function citas()
    {
        return $this->belongsToMany(Cita::class, 'cita_mascota');
    }
}