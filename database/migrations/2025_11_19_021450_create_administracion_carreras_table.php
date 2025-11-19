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
        Schema::create('administracion_carreras', function (Blueprint $table) {
            $table->integer('id_administracion_carrera', true);
            $table->integer('id_area')->index('id_area');
            $table->integer('id_usuario')->index('id_usuario');
            $table->integer('id_carrera')->index('id_carrera');
            $table->json('datos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('administracion_carreras');
    }
};
