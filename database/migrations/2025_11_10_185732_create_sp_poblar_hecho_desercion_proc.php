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
        DB::unprepared("CREATE DEFINER=`root`@`%` PROCEDURE `sp_poblar_hecho_desercion`()
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;
    
    START TRANSACTION;
    
    INSERT INTO historico_desercion (
        carrera,
        periodo_escolar,
        alumnos_baja_definitiva,
        total_alumnos,
        tasa_desercion_porcentaje,
        mujeres_baja_definitiva,
        hombres_baja_definitiva,
        tasa_desercion_mujeres,
        tasa_desercion_hombres
    )
    SELECT 
        carrera,
        periodo_escolar,
        alumnos_baja_definitiva,
        total_alumnos,
        tasa_desercion_porcentaje,        
        mujeres_baja_definitiva,
        hombres_baja_definitiva,
        tasa_desercion_mujeres,
        tasa_desercion_hombres
    FROM vista_tasa_desercion_periodo;
    
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
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_poblar_hecho_desercion");
    }
};
