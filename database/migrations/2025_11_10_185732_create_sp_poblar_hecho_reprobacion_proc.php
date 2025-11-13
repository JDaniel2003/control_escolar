<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared("CREATE DEFINER=`root`@`%` PROCEDURE `sp_poblar_hecho_reprobacion`()
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;
    
    START TRANSACTION;
    
    INSERT INTO Historico_reprobacion (
        periodo_escolar,
        carrera,
        materia,
        total_alumnos,
        alumnos_reprobados,
        mujeres_reprobadas_materia,
        hombres_reprobados_materia,
        tasa_reprobacion_porcentaje

    )
    SELECT 
        periodo_escolar,
        carrera,
        materia,
        total_alumnos,
        alumnos_reprobados,
        mujeres_reprobadas_materia,
        hombres_reprobados_materia,
        tasa_reprobacion_porcentaje
    FROM vista_tasa_reprobacion_por_materia;
    
    COMMIT;
    
    INSERT INTO logs_sistema (accion, descripcion, usuario)
        VALUES (
            'CIERRE_PERIODO',
            'Cierre automático del período: ',
            'SISTEMA'
        );
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_poblar_hecho_reprobacion");
    }
};
