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
        'configuracion', // <--- NUEVO: La "mochila" de ajustes dinámicos
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
            'configuracion' => 'array', // <--- MAGIA: Convierte el JSON de la BD en un Array PHP usable
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relaciones (Fase 1: Lógica del Negocio)
    |--------------------------------------------------------------------------
    */

    // Un Usuario (Cliente o Admin) puede tener muchas citas
    public function citas()
    {
        return $this->hasMany(Cita::class);
    }

    /*
    |--------------------------------------------------------------------------
    | El "Guardia" de Configuración (Propuesta C)
    |--------------------------------------------------------------------------
    | Esta función nos permite pedir un ajuste y, si la veterinaria no lo ha
    | configurado, devuelve un valor por defecto para que el sistema no falle.
    |
    | Uso: $user->getConfig('max_mascotas', 3);
    */
    public function getConfig($clave, $valorPorDefecto = null)
    {
        // Si no hay configuración guardada, devolver el default
        if (empty($this->configuracion)) {
            return $valorPorDefecto;
        }

        // Si existe la clave específica (ej: 'max_mascotas'), la devolvemos
        return $this->configuracion[$clave] ?? $valorPorDefecto;
    }
}