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
        Schema::table('historial', function (Blueprint $table) {
            $table->foreign(['id_alumno'], 'historial_ibfk_1')->references(['id_alumno'])->on('alumnos')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_grupo'], 'historial_ibfk_2')->references(['id_grupo'])->on('grupos')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_periodo_escolar'], 'historial_ibfk_3')->references(['id_periodo_escolar'])->on('periodos_escolares')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_historial_status'], 'historial_ibfk_4')->references(['id_historial_status'])->on('historial_status')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_status_inicio'], 'historial_ibfk_5')->references(['id_status_academico'])->on('status_academico')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_status_terminacion'], 'historial_ibfk_6')->references(['id_status_academico'])->on('status_academico')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historial', function (Blueprint $table) {
            $table->dropForeign('historial_ibfk_1');
            $table->dropForeign('historial_ibfk_2');
            $table->dropForeign('historial_ibfk_3');
            $table->dropForeign('historial_ibfk_4');
            $table->dropForeign('historial_ibfk_5');
            $table->dropForeign('historial_ibfk_6');
        });
    }
};
