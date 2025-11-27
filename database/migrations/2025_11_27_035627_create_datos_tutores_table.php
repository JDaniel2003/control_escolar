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
        Schema::create('datos_tutores', function (Blueprint $table) {
            $table->integer('id_datos_tutor', true);
            $table->string('nombres', 100)->nullable();
            $table->integer('id_parentesco')->nullable()->index('id_parentesco');
            $table->integer('id_domicilio_tutor')->nullable()->index('id_domicilio_tutor');
            $table->string('telefono', 10)->nullable();
            $table->json('datos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datos_tutores');
    }
};
