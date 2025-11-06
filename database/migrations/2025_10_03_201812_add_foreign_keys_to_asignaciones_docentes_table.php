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
        Schema::table('asignaciones_docentes', function (Blueprint $table) {
            $table->foreign(['id_docente'], 'asignaciones_docentes_ibfk_1')->references(['id_docente'])->on('docentes')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_materia'], 'asignaciones_docentes_ibfk_2')->references(['id_materia'])->on('materias')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_grupo'], 'asignaciones_docentes_ibfk_3')->references(['id_grupo'])->on('grupos')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_periodo_escolar'], 'asignaciones_docentes_ibfk_4')->references(['id_periodo_escolar'])->on('periodos_escolares')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asignaciones_docentes', function (Blueprint $table) {
            $table->dropForeign('asignaciones_docentes_ibfk_1');
            $table->dropForeign('asignaciones_docentes_ibfk_2');
            $table->dropForeign('asignaciones_docentes_ibfk_3');
            $table->dropForeign('asignaciones_docentes_ibfk_4');
        });
    }
};
