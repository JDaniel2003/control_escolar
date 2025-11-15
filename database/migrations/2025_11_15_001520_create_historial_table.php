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
            $table->date('fecha_inscripcion')->nullable();
            $table->integer('id_status_inicio')->nullable()->index('id_status_inicio');
            $table->integer('id_status_terminacion')->nullable()->index('id_status_terminacion');
            $table->integer('id_asignacion_1')->nullable()->index('id_asignacion_1');
            $table->integer('id_asignacion_2')->nullable()->index('id_asignacion_2');
            $table->integer('id_asignacion_3')->nullable()->index('id_asignacion_3');
            $table->integer('id_asignacion_4')->nullable()->index('id_asignacion_4');
            $table->integer('id_asignacion_5')->nullable()->index('id_asignacion_5');
            $table->integer('id_asignacion_6')->nullable()->index('id_asignacion_6');
            $table->integer('id_asignacion_7')->nullable()->index('id_asignacion_7');
            $table->integer('id_asignacion_8')->nullable()->index('id_asignacion_8');
            $table->integer('id_asignacion_9')->nullable()->index('id_asignacion_9');
            $table->integer('id_asignacion_10')->nullable()->index('id_asignacion_10');
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
