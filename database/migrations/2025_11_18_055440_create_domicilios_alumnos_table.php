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
        Schema::create('domicilios_alumnos', function (Blueprint $table) {
            $table->integer('id_domicilio_alumno', true);
            $table->string('calle', 100)->nullable();
            $table->string('numero_exterior', 4)->nullable();
            $table->string('numero_interior', 4)->nullable();
            $table->string('colonia', 100)->nullable();
            $table->string('comunidad', 100)->nullable();
            $table->integer('id_distrito')->nullable()->index('id_distrito');
            $table->integer('id_estado')->nullable()->index('id_estado');
            $table->string('municipio', 100)->nullable();
            $table->string('codigo_postal', 5)->nullable();
            $table->json('datos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('domicilios_alumnos');
    }
};
