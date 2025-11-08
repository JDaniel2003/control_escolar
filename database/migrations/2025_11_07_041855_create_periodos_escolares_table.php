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
        Schema::create('periodos_escolares', function (Blueprint $table) {
            $table->integer('id_periodo_escolar', true);
            $table->string('nombre', 100)->nullable();
            $table->integer('id_tipo_periodo')->nullable()->index('id_tipo_periodo');
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->enum('estado', ['Cerrado', 'Abierto'])->nullable();
            $table->json('datos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periodos_escolares');
    }
};
