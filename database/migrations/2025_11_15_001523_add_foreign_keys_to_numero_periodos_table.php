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
        Schema::table('numero_periodos', function (Blueprint $table) {
            $table->foreign(['id_tipo_periodo'], 'numero_periodos_ibfk_1')->references(['id_tipo_periodo'])->on('tipos_periodos')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('numero_periodos', function (Blueprint $table) {
            $table->dropForeign('numero_periodos_ibfk_1');
        });
    }
};
