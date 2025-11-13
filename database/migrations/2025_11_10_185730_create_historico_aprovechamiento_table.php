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
        Schema::create('historico_aprovechamiento', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('periodo_escolar')->index('idx_periodo_escolar');
            $table->string('carrera')->index('idx_carrera');
            $table->integer('semestre');
            $table->string('semestre_completo');
            $table->string('grupo')->index('idx_grupo');
            $table->integer('total_alumnos_grupo');
            $table->decimal('promedio_general_grupo', 5);
            $table->integer('total_alumnos_carrera');
            $table->decimal('aprovechamiento_carrera', 5);

            $table->index(['periodo_escolar', 'carrera'], 'idx_periodo_carrera');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historico_aprovechamiento');
    }
};
