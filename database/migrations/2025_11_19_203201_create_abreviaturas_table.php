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
        Schema::create('abreviaturas', function (Blueprint $table) {
            $table->integer('id_abreviatura', true);
            $table->string('nombre', 100)->nullable();
            $table->string('abreviatura', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abreviaturas');
    }
};
