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
        Schema::table('datos_personales', function (Blueprint $table) {
            $table->foreign(['id_estado_civil'], 'datos_personales_ibfk_1')->references(['id_estado_civil'])->on('estado_civil')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_tipo_sangre'], 'datos_personales_ibfk_2')->references(['id_tipo_sangre'])->on('tipos_sangre')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_domicilio_alumno'], 'datos_personales_ibfk_3')->references(['id_domicilio_alumno'])->on('domicilios_alumnos')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_lengua_indigena'], 'datos_personales_ibfk_4')->references(['id_lengua_indigena'])->on('lengua_indigena')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_discapacidad'], 'datos_personales_ibfk_5')->references(['id_discapacidad'])->on('discapacidades')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_datos_tutor'], 'datos_personales_ibfk_6')->references(['id_datos_tutor'])->on('datos_tutores')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_datos_escuela_procedencia'], 'datos_personales_ibfk_7')->references(['id_datos_escuela_procedencia'])->on('datos_escuela_procedencia')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_genero'], 'datos_personales_ibfk_8')->references(['id_genero'])->on('generos')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('datos_personales', function (Blueprint $table) {
            $table->dropForeign('datos_personales_ibfk_1');
            $table->dropForeign('datos_personales_ibfk_2');
            $table->dropForeign('datos_personales_ibfk_3');
            $table->dropForeign('datos_personales_ibfk_4');
            $table->dropForeign('datos_personales_ibfk_5');
            $table->dropForeign('datos_personales_ibfk_6');
            $table->dropForeign('datos_personales_ibfk_7');
            $table->dropForeign('datos_personales_ibfk_8');
        });
    }
};
