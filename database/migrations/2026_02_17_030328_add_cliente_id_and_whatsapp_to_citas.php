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
        Schema::table('citas', function (Blueprint $table) {
            
            // Agregar cliente_id si no existe (para la relación correcta)
            if (!Schema::hasColumn('citas', 'cliente_id')) {
                $table->foreignId('cliente_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('clientes')
                    ->onDelete('cascade');
            }

            // Agregar campos de WhatsApp si no existen
            if (!Schema::hasColumn('citas', 'mensaje_whatsapp')) {
                $table->text('mensaje_whatsapp')
                    ->nullable()
                    ->after('notas_internas');
            }

            if (!Schema::hasColumn('citas', 'enlace_whatsapp')) {
                $table->text('enlace_whatsapp')
                    ->nullable()
                    ->after('mensaje_whatsapp');
            }

            if (!Schema::hasColumn('citas', 'whatsapp_enviado')) {
                $table->boolean('whatsapp_enviado')
                    ->default(false)
                    ->after('enlace_whatsapp');
            }

            if (!Schema::hasColumn('citas', 'fecha_envio_whatsapp')) {
                $table->timestamp('fecha_envio_whatsapp')
                    ->nullable()
                    ->after('whatsapp_enviado');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            // Borrar columnas (en orden inverso)
            $columnas = [
                'fecha_envio_whatsapp',
                'whatsapp_enviado',
                'enlace_whatsapp',
                'mensaje_whatsapp',
                'cliente_id',
            ];

            foreach ($columnas as $columna) {
                if (Schema::hasColumn('citas', $columna)) {
                    $table->dropColumn($columna);
                }
            }
        });
    }
};