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
        Schema::create('datos_personales', function (Blueprint $table) {
            $table->integer('id_datos_personales', true);
            $table->string('correo', 100)->nullable()->unique('correo');
            $table->string('telefono', 10)->nullable();
            $table->string('nombres', 50)->nullable();
            $table->string('primer_apellido', 50)->nullable();
            $table->string('segundo_apellido', 50)->nullable();
            $table->string('curp', 18)->nullable()->unique('curp');
            $table->date('fecha_nacimiento')->nullable();
            $table->integer('edad')->nullable();
            $table->string('lugar_nacimiento', 100)->nullable();
            $table->integer('id_estado_civil')->nullable()->index('id_estado_civil');
            $table->integer('id_tipo_sangre')->nullable()->index('id_tipo_sangre');
            $table->integer('id_domicilio_alumno')->nullable()->index('id_domicilio_alumno');
            $table->integer('id_lengua_indigena')->nullable()->index('id_lengua_indigena');
            $table->integer('id_discapacidad')->nullable()->index('id_discapacidad');
            $table->integer('id_datos_tutor')->nullable()->index('id_datos_tutor');
            $table->integer('hijos')->nullable();
            $table->integer('id_datos_escuela_procedencia')->nullable()->index('id_datos_escuela_procedencia');
            $table->integer('id_genero')->nullable()->index('id_genero');
            $table->string('numero_seguridad_social', 11)->nullable();
            $table->json('datos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datos_personales');
    }
};
