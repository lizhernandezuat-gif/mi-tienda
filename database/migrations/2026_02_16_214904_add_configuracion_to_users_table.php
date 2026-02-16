<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Aquí guardaremos: max_mascotas, horarios, mensajes de whatsapp, etc.
            // Usamos 'text' porque SQLite a veces da problemas con 'json' nativo en versiones viejas, 
            // pero Laravel lo maneja igual de bien como Array.
            $table->text('configuracion')->nullable()->after('email'); 
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('configuracion');
        });
    }
};