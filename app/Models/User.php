<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'veterinaria_id',
        'user_id',
        'rol',
        'configuracion',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'configuracion' => 'array',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    /**
     * Un Usuario pertenece a UNA Veterinaria
     */
    public function veterinaria()
    {
        return $this->belongsTo(Veterinaria::class);
    }

    /**
     * Un Usuario puede tener muchas citas
     */
    public function citas()
    {
        return $this->hasMany(Cita::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Métodos Helper
    |--------------------------------------------------------------------------
    */

    /**
     * Obtener configuración con valor por defecto
     */
    public function getConfig($clave, $valorPorDefecto = null)
    {
        if (empty($this->configuracion)) {
            return $valorPorDefecto;
        }

        return $this->configuracion[$clave] ?? $valorPorDefecto;
    }

    /**
     * Verificar si el usuario pertenece a una veterinaria
     */
    public function tieneVeterinaria()
    {
        return !is_null($this->veterinaria_id);
    }
}