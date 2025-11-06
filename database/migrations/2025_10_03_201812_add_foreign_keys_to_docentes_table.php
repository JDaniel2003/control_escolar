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
        Schema::table('docentes', function (Blueprint $table) {
            $table->foreign(['id_datos_docentes'], 'docentes_ibfk_1')->references(['id_datos_docentes'])->on('datos_docentes')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_usuario'], 'docentes_ibfk_2')->references(['id_usuario'])->on('usuarios')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('docentes', function (Blueprint $table) {
            $table->dropForeign('docentes_ibfk_1');
            $table->dropForeign('docentes_ibfk_2');
        });
    }
};
