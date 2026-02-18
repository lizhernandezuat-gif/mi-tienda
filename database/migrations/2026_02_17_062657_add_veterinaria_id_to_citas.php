<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            if (!Schema::hasColumn('citas', 'veterinaria_id')) {
                $table->foreignId('veterinaria_id')
                    ->nullable()
                    ->after('cliente_id')
                    ->constrained('veterinarias')
                    ->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            if (Schema::hasColumn('citas', 'veterinaria_id')) {
                $table->dropForeignKey(['veterinaria_id']);
                $table->dropColumn('veterinaria_id');
            }
        });
    }
};