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
        Schema::table('grupos', function (Blueprint $table) {
            $table->foreign(['id_turno'], 'grupos_ibfk_1')->references(['id_turno'])->on('turnos')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_carrera'], 'grupos_ibfk_2')->references(['id_carrera'])->on('carreras')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grupos', function (Blueprint $table) {
            $table->dropForeign('grupos_ibfk_1');
            $table->dropForeign('grupos_ibfk_2');
        });
    }
};
