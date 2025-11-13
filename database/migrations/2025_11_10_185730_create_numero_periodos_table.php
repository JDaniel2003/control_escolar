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
        Schema::create('numero_periodos', function (Blueprint $table) {
            $table->integer('id_numero_periodo', true);
            $table->integer('numero');
            $table->integer('id_tipo_periodo')->index('id_tipo_periodo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('numero_periodos');
    }
};
