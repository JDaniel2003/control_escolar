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
        Schema::create('historial_aprobacion_grupos', function (Blueprint $table) {
            $table->integer('id_historial_aprobacion', true);
            $table->string('periodo_escolar', 100)->index('idx_periodo');
            $table->string('carrera', 100)->index('idx_carrera');
            $table->string('grupo', 50)->index('idx_grupo');
            $table->integer('total_aprobados_grupo')->default(0);
            $table->integer('mujeres_aprobadas_grupo')->default(0);
            $table->integer('hombres_aprobados_grupo')->default(0);
            $table->integer('total_alumnos_carrera')->default(0);
            $table->integer('mujeres_carrera')->default(0);
            $table->integer('hombres_carrera')->default(0);
            $table->decimal('tasa_aprobacion_carrera', 5)->default(0);
            $table->decimal('tasa_aprobacion_mujeres_carrera', 5)->default(0);
            $table->decimal('tasa_aprobacion_hombres_carrera', 5)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_aprobacion_grupos');
    }
};
