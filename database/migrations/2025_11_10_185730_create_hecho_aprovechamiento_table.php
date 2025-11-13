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
        Schema::create('hecho_aprovechamiento', function (Blueprint $table) {
            $table->integer('id_aprovechamiento', true);
            $table->string('carrera', 150)->index('idx_aprovechamiento_carrera');
            $table->string('grupo', 50)->index('idx_aprovechamiento_grupo');
            $table->string('periodo_escolar', 100)->index('idx_aprovechamiento_periodo');
            $table->integer('semestre');
            $table->string('semestre_completo', 100);
            $table->integer('total_alumnos_grupo');
            $table->decimal('promedio_general_grupo', 5);
            $table->integer('total_alumnos_carrera');
            $table->decimal('aprovechamiento_carrera', 5);
            $table->timestamp('fecha_registro')->useCurrent()->index('idx_aprovechamiento_fecha');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hecho_aprovechamiento');
    }
};
