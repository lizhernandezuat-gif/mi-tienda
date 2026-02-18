<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('veterinarias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('direccion')->nullable();
            $table->string('telefono')->nullable();
            $table->string('slogan')->nullable(); // Agregué esto por si acaso
            $table->string('rfc')->nullable();    // Agregué esto por si acaso
            $table->string('horario')->nullable(); // Agregué esto por si acaso
            $table->boolean('activo')->default(true);
            $table->string('ciudad')->nullable();
            $table->timestamps();
        });
        
        // ¡Aquí ya NO hay código que cree la veterinaria Central!
    }

    public function down()
    {
        Schema::dropIfExists('veterinarias');
    }
};