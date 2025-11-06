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
        Schema::create('planes_estudio', function (Blueprint $table) {
            $table->integer('id_plan_estudio', true);
            $table->string('nombre', 100);
            $table->integer('id_carrera')->nullable()->index('id_carrera');
            $table->enum('vigencia', ['Vigente', 'No vigente'])->nullable()->default('Vigente');
            $table->json('datos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planes_estudio');
    }
};
