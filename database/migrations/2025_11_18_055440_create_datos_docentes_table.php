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
        Schema::create('datos_docentes', function (Blueprint $table) {
            $table->integer('id_datos_docentes', true);
            $table->string('nombre', 100)->nullable();
            $table->string('apellido_paterno', 50)->nullable();
            $table->string('apellido_materno', 50)->nullable();
            $table->integer('edad')->nullable();
            $table->integer('id_genero')->nullable()->index('id_genero');
            $table->date('fecha_nacimiento')->nullable();
            $table->string('cedula_profesional', 7)->nullable()->unique('cedula_profesional');
            $table->string('rfc', 13)->nullable()->unique('rfc');
            $table->string('telefono', 10)->nullable();
            $table->string('correo', 100)->nullable()->unique('correo');
            $table->string('curp', 18)->nullable()->unique('curp');
            $table->integer('id_domicilio_docente')->nullable()->index('id_domicilio_docente');
            $table->string('numero_seguridad_social', 11)->nullable()->unique('numero_seguridad_social');
            $table->json('datos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datos_docentes');
    }
};
