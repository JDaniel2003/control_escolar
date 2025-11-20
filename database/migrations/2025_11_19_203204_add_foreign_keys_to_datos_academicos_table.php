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
        Schema::table('datos_academicos', function (Blueprint $table) {
            $table->foreign(['id_carrera'], 'datos_academicos_ibfk_1')->references(['id_carrera'])->on('carreras')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_plan_estudio'], 'datos_academicos_ibfk_2')->references(['id_plan_estudio'])->on('planes_estudio')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('datos_academicos', function (Blueprint $table) {
            $table->dropForeign('datos_academicos_ibfk_1');
            $table->dropForeign('datos_academicos_ibfk_2');
        });
    }
};
