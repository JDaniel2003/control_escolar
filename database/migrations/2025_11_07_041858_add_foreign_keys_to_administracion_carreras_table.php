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
        Schema::table('administracion_carreras', function (Blueprint $table) {
            $table->foreign(['id_usuario'], 'administracion_carreras_ibfk_1')->references(['id_usuario'])->on('usuarios')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_carrera'], 'administracion_carreras_ibfk_2')->references(['id_carrera'])->on('carreras')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('administracion_carreras', function (Blueprint $table) {
            $table->dropForeign('administracion_carreras_ibfk_1');
            $table->dropForeign('administracion_carreras_ibfk_2');
        });
    }
};
