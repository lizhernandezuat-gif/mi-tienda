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
    Schema::create('mascotas', function (Blueprint $table) {
        $table->id();
        
        // RELACIÓN: Esta línea conecta la mascota con el cliente (Dueño)
        // 'onDelete cascade' significa que si borras al dueño, se borran sus mascotas automáticamente.
        $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
        $table->foreignId('veterinaria_id')->constrained('veterinarias')->onDelete('cascade');
        $table->string('nombre');
        $table->string('especie'); // Perro, Gato, etc.
        $table->string('raza')->nullable();
        $table->string('color')->nullable(); // Detalle visual
        $table->decimal('peso', 5, 2)->nullable(); // Ej: 12.50 kg (Crucial para veterinarias)
        $table->integer('edad')->nullable(); // En años
        $table->text('notas_medicas')->nullable(); // Alergias, carácter, etc.
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mascotas');
    }
};
