<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('veterinaria_id')->nullable()->after('id');
            $table->foreign('veterinaria_id')->references('id')->on('veterinarias')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['veterinaria_id']);
            $table->dropColumn('veterinaria_id');
        });
    }
};