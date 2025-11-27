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
        Schema::create('historico_desercion', function (Blueprint $table) {
            $table->integer('id_desercion', true);
            $table->string('carrera', 100)->index('idx_carrera');
            $table->string('periodo_escolar', 100)->index('idx_periodo');
            $table->integer('alumnos_baja_definitiva');
            $table->integer('total_alumnos');
            $table->decimal('tasa_desercion_porcentaje', 5);
            $table->integer('mujeres_baja_definitiva');
            $table->integer('hombres_baja_definitiva');
            $table->decimal('tasa_desercion_mujeres', 5);
            $table->decimal('tasa_desercion_hombres', 5);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historico_desercion');
    }
};
