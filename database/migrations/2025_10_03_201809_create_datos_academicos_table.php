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
        Schema::create('datos_academicos', function (Blueprint $table) {
            $table->integer('id_datos_academicos', true);
            $table->string('matricula', 20)->unique('matricula');
            $table->integer('id_carrera')->nullable()->index('id_carrera');
            $table->integer('id_plan_estudio')->nullable()->index('id_plan_estudio');
            $table->json('datos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datos_academicos');
    }
};
