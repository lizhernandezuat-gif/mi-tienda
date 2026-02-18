<?php

namespace App\Models;

use App\Scopes\VeterinariaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $table = 'citas';

    protected $fillable = [
        'cliente_id',
        'user_id',
        'fecha_hora_inicio',
        'motivo',
        'estado',
        'notas_internas',
        'mensaje_whatsapp',
        'enlace_whatsapp',
        'whatsapp_enviado',
        'fecha_envio_whatsapp',
    ];

    protected $casts = [
        'fecha_hora_inicio' => 'datetime',
        'fecha_envio_whatsapp' => 'datetime',
        'whatsapp_enviado' => 'boolean',
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
     * Filtra AUTOMÁTICAMENTE todas las consultas por veterinaria_id del usuario
     */
    protected static function boot()
    {
        parent::boot();
        
        // Agregar Global Scope
        static::addGlobalScope(new VeterinariaScope());

        // Cuando se crea una cita, asignar automáticamente la veterinaria del usuario
        static::creating(function ($model) {
            if (!$model->cliente_id) {
                return;
            }
            
            $cliente = Cliente::withoutGlobalScopes()->find($model->cliente_id);
            if ($cliente && !$model->veterinaria_id) {
                $model->veterinaria_id = $cliente->veterinaria_id;
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    /**
     * Una Cita pertenece a UN Cliente
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Una Cita pertenece a UN Usuario (veterinario que la creó)
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Una Cita puede tener MUCHAS Mascotas (Relación Muchos a Muchos)
     */
    public function mascotas()
    {
        return $this->belongsToMany(Mascota::class, 'cita_mascota');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes (Búsquedas comunes)
    |--------------------------------------------------------------------------
    */

    /**
     * Filtrar citas pendientes
     */
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    /**
     * Filtrar citas confirmadas
     */
    public function scopeConfirmadas($query)
    {
        return $query->where('estado', 'confirmada');
    }

    /**
     * Filtrar citas completadas
     */
    public function scopeCompletadas($query)
    {
        return $query->where('estado', 'completada');
    }

    /**
     * Filtrar citas próximas (siguientes 7 días)
     */
    public function scopeProximas($query)
    {
        return $query->whereBetween('fecha_hora_inicio', [now(), now()->addDays(7)])
            ->orderBy('fecha_hora_inicio', 'asc');
    }

    /*
    |--------------------------------------------------------------------------
    | Accesores
    |--------------------------------------------------------------------------
    */

    /**
     * Obtener fecha formateada
     */
    public function getFechaFormateadaAttribute()
    {
        return $this->fecha_hora_inicio->format('d/m/Y H:i');
    }

    /**
     * Obtener estado con emoji
     */
    public function getEstadoEmojiAttribute()
    {
        $emojis = [
            'pendiente' => '🟠 Pendiente',
            'confirmada' => '🟢 Confirmada',
            'completada' => '🔵 Completada',
        ];
        return $emojis[$this->estado] ?? $this->estado;
    }

    /**
     * Obtener cantidad de mascotas
     */
    public function getCantidadMascotasAttribute()
    {
        return $this->mascotas->count();
    }
}