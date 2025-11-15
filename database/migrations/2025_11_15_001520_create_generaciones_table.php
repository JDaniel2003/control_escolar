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
        Schema::create('generaciones', function (Blueprint $table) {
            $table->integer('id_generacion', true);
            $table->string('nombre', 20)->nullable();
            $table->year('anio_inicio')->nullable();
            $table->year('anio_fin')->nullable();
            $table->json('datos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generaciones');
    }
};
