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
        Schema::table('materias', function (Blueprint $table) {
            $table->foreign(['id_tipo_competencia'], 'materias_ibfk_1')->references(['id_tipo_competencia'])->on('tipos_competencia')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_modalidad'], 'materias_ibfk_2')->references(['id_modalidad'])->on('modalidades')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_espacio_formativo'], 'materias_ibfk_3')->references(['id_espacio_formativo'])->on('espacios_formativos')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_plan_estudio'], 'materias_ibfk_4')->references(['id_plan_estudio'])->on('planes_estudio')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_numero_periodo'], 'materias_ibfk_5')->references(['id_numero_periodo'])->on('numero_periodos')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materias', function (Blueprint $table) {
            $table->dropForeign('materias_ibfk_1');
            $table->dropForeign('materias_ibfk_2');
            $table->dropForeign('materias_ibfk_3');
            $table->dropForeign('materias_ibfk_4');
            $table->dropForeign('materias_ibfk_5');
        });
    }
};
