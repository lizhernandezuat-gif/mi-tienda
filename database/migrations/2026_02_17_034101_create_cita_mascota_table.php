<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Solo crear la tabla si no existe
        if (!Schema::hasTable('cita_mascota')) {
            Schema::create('cita_mascota', function (Blueprint $table) {
                $table->id();
                $table->foreignId('cita_id')->constrained('citas')->onDelete('cascade');
                $table->foreignId('mascota_id')->constrained('mascotas')->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('cita_mascota');
    }
};