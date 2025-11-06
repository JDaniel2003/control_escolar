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
        Schema::create('tipos_periodos', function (Blueprint $table) {
            $table->integer('id_tipo_periodo', true);
            $table->string('nombre', 50);
            $table->string('duracion', 50)->nullable();
            $table->json('datos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipos_periodos');
    }
};
