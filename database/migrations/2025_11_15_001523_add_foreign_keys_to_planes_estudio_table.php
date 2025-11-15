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
        Schema::table('planes_estudio', function (Blueprint $table) {
            $table->foreign(['id_carrera'], 'planes_estudio_ibfk_1')->references(['id_carrera'])->on('carreras')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('planes_estudio', function (Blueprint $table) {
            $table->dropForeign('planes_estudio_ibfk_1');
        });
    }
};
