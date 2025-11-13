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
        Schema::table('datos_escuela_procedencia', function (Blueprint $table) {
            $table->foreign(['id_area_especializacion'], 'datos_escuela_procedencia_ibfk_1')->references(['id_area_especializacion'])->on('area_especializacion')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_subsistema'], 'datos_escuela_procedencia_ibfk_2')->references(['id_subsistema'])->on('subsistemas')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_estado'], 'datos_escuela_procedencia_ibfk_3')->references(['id_estado'])->on('estado')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_beca'], 'datos_escuela_procedencia_ibfk_4')->references(['id_beca'])->on('becas')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_tipo_escuela'], 'datos_escuela_procedencia_ibfk_5')->references(['id_tipo_escuela'])->on('tipos_escuela')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('datos_escuela_procedencia', function (Blueprint $table) {
            $table->dropForeign('datos_escuela_procedencia_ibfk_1');
            $table->dropForeign('datos_escuela_procedencia_ibfk_2');
            $table->dropForeign('datos_escuela_procedencia_ibfk_3');
            $table->dropForeign('datos_escuela_procedencia_ibfk_4');
            $table->dropForeign('datos_escuela_procedencia_ibfk_5');
        });
    }
};
