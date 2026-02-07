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
    Schema::create('vacunas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('mascota_id')->constrained('mascotas')->onDelete('cascade');
        $table->string('nombre'); // Ej: Rabia, Quintuple, Desparasitación
        $table->date('fecha_aplicacion');
        $table->date('proxima_aplicacion')->nullable(); // Para calcular vencimiento
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacunas');
    }
};
