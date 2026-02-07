<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            
            // Datos del Dueño
            $table->string('nombre');
            $table->string('email')->nullable();
            $table->string('telefono'); // Se hará único en la otra migración, aquí déjalo simple
            $table->string('telefono_alterno')->nullable();
            $table->string('domicilio')->nullable();
            $table->string('preferencia_contacto')->nullable();
            $table->string('contacto_emergencia')->nullable();

            // Datos de la Mascota (¡Estos eran los que faltaban!)
            $table->string('mascota');          // Nombre de la mascota
            $table->string('tipo')->nullable(); // Perro, Gato...
            $table->string('raza')->nullable();
            $table->integer('edad')->nullable();
            $table->date('fecha_nacimiento')->nullable();

            // Extras
            $table->text('notas')->nullable();
            $table->boolean('activo')->default(true);
            
            // Relaciones (Foreign Keys)
            // Nota: La columna 'veterinaria_id' se agrega en el otro archivo de migración
            // así que aquí no hace falta ponerla, o si quieres evitar errores futuros,
            // puedes ponerla aquí y borrar el otro archivo. 
            // Pero para no enredarnos, dejémoslo así que funcionará con tus otros archivos.

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clientes');
    }
};