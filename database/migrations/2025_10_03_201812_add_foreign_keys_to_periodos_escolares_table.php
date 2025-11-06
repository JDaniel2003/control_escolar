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
        Schema::table('periodos_escolares', function (Blueprint $table) {
            $table->foreign(['id_tipo_periodo'], 'periodos_escolares_ibfk_1')->references(['id_tipo_periodo'])->on('tipos_periodos')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('periodos_escolares', function (Blueprint $table) {
            $table->dropForeign('periodos_escolares_ibfk_1');
        });
    }
};
