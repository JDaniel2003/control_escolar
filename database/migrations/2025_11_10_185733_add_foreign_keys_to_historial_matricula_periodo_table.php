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
        Schema::table('historial_matricula_periodo', function (Blueprint $table) {
            $table->foreign(['id_carrera'], 'historial_matricula_periodo_ibfk_1')->references(['id_carrera'])->on('carreras')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_grupo'], 'historial_matricula_periodo_ibfk_2')->references(['id_grupo'])->on('grupos')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_periodo_escolar'], 'historial_matricula_periodo_ibfk_3')->references(['id_periodo_escolar'])->on('periodos_escolares')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historial_matricula_periodo', function (Blueprint $table) {
            $table->dropForeign('historial_matricula_periodo_ibfk_1');
            $table->dropForeign('historial_matricula_periodo_ibfk_2');
            $table->dropForeign('historial_matricula_periodo_ibfk_3');
        });
    }
};
