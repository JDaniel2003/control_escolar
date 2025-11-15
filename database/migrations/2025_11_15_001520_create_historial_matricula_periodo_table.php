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
        Schema::create('historial_matricula_periodo', function (Blueprint $table) {
            $table->integer('id_historial_matricula', true);
            $table->integer('id_carrera')->nullable()->index('id_carrera');
            $table->integer('id_grupo')->nullable()->index('id_grupo');
            $table->integer('id_periodo_escolar')->nullable()->index('id_periodo_escolar');
            $table->integer('total_alumnos')->nullable();
            $table->integer('mujeres')->nullable();
            $table->integer('hombres')->nullable();
            $table->integer('solteros')->nullable();
            $table->integer('casados')->nullable();
            $table->integer('union_libre')->nullable();
            $table->timestamp('fecha_registro')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_matricula_periodo');
    }
};
