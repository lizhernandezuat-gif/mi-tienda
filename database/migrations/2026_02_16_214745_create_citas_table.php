<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tabla Principal de Citas
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            
            // Relación con el Cliente (Dueño)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Fecha y Hora de la cita
            $table->dateTime('fecha_hora_inicio');
            
            // Motivo y Estado
            $table->text('motivo'); // Ej: "Vacuna y corte"
            $table->string('estado')->default('pendiente'); // pendiente, confirmada, cancelada, completada
            
            // Notas internas (Opcional para la veterinaria)
            $table->text('notas_internas')->nullable();
            
            $table->timestamps();
        });

        // 2. Tabla Pivote: Cita <-> Mascotas
        // Esto permite que una sola cita incluya a "Firulais" y a "Michi" al mismo tiempo
        Schema::create('cita_mascota', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cita_id')->constrained('citas')->onDelete('cascade');
            $table->foreignId('mascota_id')->constrained('mascotas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cita_mascota');
        Schema::dropIfExists('citas');
    }
};