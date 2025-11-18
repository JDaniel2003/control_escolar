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
        Schema::create('materias', function (Blueprint $table) {
            $table->integer('id_materia', true);
            $table->string('nombre', 150);
            $table->integer('id_tipo_competencia')->nullable()->index('id_tipo_competencia');
            $table->integer('id_modalidad')->nullable()->index('id_modalidad');
            $table->integer('creditos')->nullable();
            $table->integer('horas')->nullable();
            $table->integer('id_espacio_formativo')->nullable()->index('id_espacio_formativo');
            $table->integer('id_plan_estudio')->nullable()->index('id_plan_estudio');
            $table->integer('id_numero_periodo')->nullable()->index('id_numero_periodo');
            $table->json('datos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materias');
    }
};
