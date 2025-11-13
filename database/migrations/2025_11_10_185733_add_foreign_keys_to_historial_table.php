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
            $table->foreign(['id_asignacion_6'], 'historial_ibfk_10')->references(['id_asignacion'])->on('asignaciones_docentes')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_asignacion_7'], 'historial_ibfk_11')->references(['id_asignacion'])->on('asignaciones_docentes')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_asignacion_8'], 'historial_ibfk_12')->references(['id_asignacion'])->on('asignaciones_docentes')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_asignacion_9'], 'historial_ibfk_13')->references(['id_asignacion'])->on('asignaciones_docentes')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_asignacion_10'], 'historial_ibfk_14')->references(['id_asignacion'])->on('asignaciones_docentes')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_historial_status'], 'historial_ibfk_2')->references(['id_historial_status'])->on('historial_status')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_status_inicio'], 'historial_ibfk_3')->references(['id_status_academico'])->on('status_academico')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_status_terminacion'], 'historial_ibfk_4')->references(['id_status_academico'])->on('status_academico')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_asignacion_1'], 'historial_ibfk_5')->references(['id_asignacion'])->on('asignaciones_docentes')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_asignacion_2'], 'historial_ibfk_6')->references(['id_asignacion'])->on('asignaciones_docentes')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_asignacion_3'], 'historial_ibfk_7')->references(['id_asignacion'])->on('asignaciones_docentes')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_asignacion_4'], 'historial_ibfk_8')->references(['id_asignacion'])->on('asignaciones_docentes')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_asignacion_5'], 'historial_ibfk_9')->references(['id_asignacion'])->on('asignaciones_docentes')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historial', function (Blueprint $table) {
            $table->dropForeign('historial_ibfk_1');
            $table->dropForeign('historial_ibfk_10');
            $table->dropForeign('historial_ibfk_11');
            $table->dropForeign('historial_ibfk_12');
            $table->dropForeign('historial_ibfk_13');
            $table->dropForeign('historial_ibfk_14');
            $table->dropForeign('historial_ibfk_2');
            $table->dropForeign('historial_ibfk_3');
            $table->dropForeign('historial_ibfk_4');
            $table->dropForeign('historial_ibfk_5');
            $table->dropForeign('historial_ibfk_6');
            $table->dropForeign('historial_ibfk_7');
            $table->dropForeign('historial_ibfk_8');
            $table->dropForeign('historial_ibfk_9');
        });
    }
};
