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
        Schema::create('domicilios_tutores', function (Blueprint $table) {
            $table->integer('id_domicilio_tutor', true);
            $table->string('calle', 100)->nullable();
            $table->string('numero_exterior', 4)->nullable();
            $table->string('numero_interior', 4)->nullable();
            $table->integer('id_estado')->nullable()->index('id_estado');
            $table->string('municipio', 100)->nullable();
            $table->integer('id_distrito')->nullable()->index('id_distrito');
            $table->string('colonia', 100)->nullable();
            $table->json('datos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('domicilios_tutores');
    }
};
