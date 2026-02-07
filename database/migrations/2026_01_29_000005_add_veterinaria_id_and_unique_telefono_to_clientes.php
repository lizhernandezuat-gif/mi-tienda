<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Agregamos la columna para vincular clientes con veterinarias
        Schema::table('clientes', function (Blueprint $table) {
            $table->foreignId('veterinaria_id')
                  ->nullable() // Importante: permite estar vacío al inicio
                  ->constrained('veterinarias')
                  ->onDelete('cascade');
        });

        // 2. Hacemos el teléfono único (Directo, sin trucos raros)
        Schema::table('clientes', function (Blueprint $table) {
            $table->unique('telefono');
        });
    }

    public function down()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropForeign(['veterinaria_id']);
            $table->dropColumn('veterinaria_id');
            $table->dropUnique(['telefono']);
        });
    }
};