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
        Schema::create('mi_temporal', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('Carrera', 100);
            $table->string('Generacion', 100);
            $table->string('Inicio', 100);
            $table->string('Fin', 100);
            $table->string('Alumnos Totales', 100);
            $table->string('Activos', 100);
            $table->string('Egresados', 100);
            $table->string('Desertores', 100);
            $table->string('Promedio General', 100);
            $table->string('Eficiencia Terminal', 100);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mi_temporal');
    }
};
