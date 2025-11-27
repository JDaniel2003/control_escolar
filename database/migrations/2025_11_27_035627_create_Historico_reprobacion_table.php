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
        Schema::create('Historico_reprobacion', function (Blueprint $table) {
            $table->integer('id_tasa_reprobacion', true);
            $table->string('periodo_escolar', 100)->index('idx_periodo');
            $table->string('carrera', 100)->index('idx_carrera');
            $table->string('materia', 100)->index('idx_materia');
            $table->integer('total_alumnos')->default(0);
            $table->integer('alumnos_reprobados')->default(0);
            $table->integer('mujeres_reprobadas_materia')->default(0);
            $table->integer('hombres_reprobados_materia')->default(0);
            $table->decimal('tasa_reprobacion_porcentaje', 5)->default(0)->index('idx_tasa_reprobacion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Historico_reprobacion');
    }
};
