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
        Schema::create('historial', function (Blueprint $table) {
            $table->integer('id_historial', true);
            $table->integer('id_alumno')->nullable()->index('id_alumno');
            $table->integer('id_periodo_escolar')->nullable()->index('id_periodo_escolar');
            $table->integer('id_grupo')->nullable()->index('id_grupo');
            $table->date('fecha_inscripcion')->nullable();
            $table->integer('id_status_inicio')->nullable()->index('id_status_inicio');
            $table->integer('id_status_terminacion')->nullable()->index('id_status_terminacion');
            $table->integer('id_historial_status')->nullable()->index('id_historial_status');
            $table->json('datos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial');
    }
};
