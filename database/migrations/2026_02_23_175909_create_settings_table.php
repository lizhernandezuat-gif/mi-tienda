<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('settings', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('veterinaria_id')->nullable(); // Para que cada sucursal tenga su estilo
        
        // 🎨 Identidad Visual
        $table->string('primary_color')->default('#9333ea'); // Morado/Rosa por defecto
        $table->boolean('dark_mode')->default(false);
        
        // 🏥 Perfil Profesional
        $table->string('slogan')->nullable();
        $table->string('rfc')->nullable();
        $table->string('direccion_completa')->nullable();
        
        // ⏰ Reglas de Agenda e Inteligencia
        $table->integer('duracion_cita_minutos')->default(30);
        $table->integer('max_mascotas_por_cita')->default(3);
        $table->time('hora_apertura')->default('09:00');
        $table->time('hora_cierre')->default('18:00');
        $table->boolean('agenda_abierta')->default(true);
        
        $table->timestamps();

        // Relación con tu tabla de veterinarias
        $table->foreign('veterinaria_id')->references('id')->on('veterinarias')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
