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
        Schema::create('datos_escuela_procedencia', function (Blueprint $table) {
            $table->integer('id_datos_escuela_procedencia', true);
            $table->decimal('promedio_egreso', 3)->nullable();
            $table->integer('id_area_especializacion')->nullable()->index('id_area_especializacion');
            $table->integer('id_subsistema')->nullable()->index('id_subsistema');
            $table->string('localidad', 100)->nullable();
            $table->integer('id_estado')->nullable()->index('id_estado');
            $table->integer('id_beca')->nullable()->index('id_beca');
            $table->integer('id_tipo_escuela')->nullable()->index('id_tipo_escuela');
            $table->json('datos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datos_escuela_procedencia');
    }
};
