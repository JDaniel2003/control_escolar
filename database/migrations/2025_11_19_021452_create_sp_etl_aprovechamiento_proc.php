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
        DB::unprepared("CREATE DEFINER=`root`@`%` PROCEDURE `sp_etl_aprovechamiento`()
BEGIN
    DECLARE v_fecha_carga DATE;
    DECLARE v_registros_procesados INT;
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;
    
    SET v_fecha_carga = CURDATE();
    
    -- Iniciar transacción
    START TRANSACTION;
    
    -- Eliminar datos duplicados del mismo día (para idempotencia)
    DELETE FROM hecho_aprovechamiento 
    WHERE DATE(fecha_registro) = v_fecha_carga;
    
    -- Insertar datos desde la vista
    INSERT INTO hecho_aprovechamiento (
        carrera,
        grupo,
        periodo_escolar,
        semestre,
        semestre_completo,
        total_alumnos_grupo,
        promedio_general_grupo,
        total_alumnos_carrera,
        aprovechamiento_carrera,
        fecha_registro
    )
    SELECT 
        carrera,
        grupo,
        periodo_escolar,
        semestre,
        semestre_completo,
        total_alumnos_grupo,
        promedio_general_grupo,
        total_alumnos_carrera,
        aprovechamiento_carrera,
        NOW()
    FROM vista_aprovechamiento;
    
    -- Obtener número de registros insertados
    SET v_registros_procesados = ROW_COUNT();
    
    -- Confirmar transacción
    COMMIT;
    
    -- Retornar resultados
    SELECT 
        v_registros_procesados AS registros_insertados,
        v_fecha_carga AS fecha_carga,
        'Proceso ETL completado exitosamente' AS mensaje;
        
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_etl_aprovechamiento");
    }
};
