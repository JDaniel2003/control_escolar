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
        Schema::create('alumnos', function (Blueprint $table) {
            $table->integer('id_alumno', true);
            $table->integer('id_datos_personales')->nullable()->index('id_datos_personales');
            $table->integer('id_datos_academicos')->nullable()->index('id_datos_academicos');
            $table->integer('id_generacion')->nullable()->index('id_generacion');
            $table->integer('id_status_academico')->nullable()->index('id_status_academico');
            $table->boolean('servicios_social')->nullable();
            $table->json('datos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnos');
    }
};
