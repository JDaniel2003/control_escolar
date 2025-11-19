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
        Schema::create('unidades', function (Blueprint $table) {
            $table->integer('id_unidad', true);
            $table->string('nombre', 100);
            $table->integer('numero_unidad')->nullable();
            $table->integer('horas_saber')->nullable();
            $table->integer('horas_saber_hacer')->nullable();
            $table->integer('horas_totales')->nullable();
            $table->integer('id_materia')->nullable()->index('id_materia');
            $table->json('datos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unidades');
    }
};
