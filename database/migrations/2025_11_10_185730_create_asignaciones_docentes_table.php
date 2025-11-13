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
        Schema::create('asignaciones_docentes', function (Blueprint $table) {
            $table->integer('id_asignacion', true);
            $table->integer('id_docente')->nullable()->index('id_docente');
            $table->integer('id_materia')->nullable()->index('id_materia');
            $table->integer('id_grupo')->nullable()->index('id_grupo');
            $table->integer('id_periodo_escolar')->nullable()->index('id_periodo_escolar');
            $table->json('datos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignaciones_docentes');
    }
};
