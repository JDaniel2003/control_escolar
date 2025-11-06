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
        Schema::create('calificaciones', function (Blueprint $table) {
            $table->integer('id_calificacion', true);
            $table->decimal('calificacion', 4)->nullable();
            $table->integer('id_alumno')->nullable()->index('id_alumno');
            $table->integer('id_unidad')->nullable()->index('id_unidad');
            $table->integer('id_evaluacion')->nullable()->index('id_evaluacion');
            $table->integer('id_asignacion')->nullable()->index('id_asignacion');
            $table->decimal('calificacion_especial', 4)->nullable();
            $table->date('fecha')->nullable();
            $table->json('datos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calificaciones');
    }
};
