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
    Schema::table('mascotas', function (Blueprint $table) {
        $table->string('foto')->nullable()->after('especie'); // Ruta del archivo
        $table->string('estado')->default('Sano')->after('edad'); // Sano, Hospitalizado, etc.
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mascotas', function (Blueprint $table) {
            //
        });
    }
};
