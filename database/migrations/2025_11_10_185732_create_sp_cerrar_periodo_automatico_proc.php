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
        DB::unprepared("CREATE DEFINER=`root`@`%` PROCEDURE `sp_cerrar_periodo_automatico`(IN `p_id_periodo_escolar` INT)
BEGIN
    DECLARE v_periodo_nombre VARCHAR(100);
    DECLARE v_fecha_fin DATE;
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;


    SELECT nombre, fecha_fin INTO v_periodo_nombre, v_fecha_fin
    FROM periodos_escolares 
    WHERE id_periodo_escolar = p_id_periodo_escolar 
    AND estado = 'Abierto';

    IF v_periodo_nombre IS NOT NULL THEN
        START TRANSACTION;
        

        INSERT INTO historial_matricula_periodo (
            id_carrera, id_grupo, id_periodo_escolar, total_alumnos,
            mujeres, hombres, solteros, casados, union_libre, tipo_registro
        )
        SELECT 
            c.id_carrera,
            g.id_grupo,
            p_id_periodo_escolar,
            COUNT(DISTINCT a.id_alumno) AS total_alumnos,
            COUNT(DISTINCT CASE WHEN gen.nombre = 'Femenino' THEN a.id_alumno END) AS mujeres,
            COUNT(DISTINCT CASE WHEN gen.nombre = 'Masculino' THEN a.id_alumno END) AS hombres,
            COUNT(DISTINCT CASE WHEN ec.nombre = 'Soltero(a)' THEN a.id_alumno END) AS solteros,
            COUNT(DISTINCT CASE WHEN ec.nombre = 'Casado(a)' THEN a.id_alumno END) AS casados,
            COUNT(DISTINCT CASE WHEN ec.nombre = 'Unión libre' THEN a.id_alumno END) AS union_libre,
            'AUTOMATICO'
        FROM historial h
        INNER JOIN alumnos a ON h.id_alumno = a.id_alumno
        INNER JOIN datos_personales dp ON a.id_datos_personales = dp.id_datos_personales
        INNER JOIN datos_academicos da ON a.id_datos_academicos = da.id_datos_academicos
        INNER JOIN carreras c ON da.id_carrera = c.id_carrera
        INNER JOIN grupos g ON h.id_grupo = g.id_grupo
        INNER JOIN periodos_escolares pe ON h.id_periodo_escolar = pe.id_periodo_escolar
        INNER JOIN historial_status hs ON h.id_historial_status = hs.id_historial_status
        INNER JOIN generos gen ON dp.id_genero = gen.id_genero
        INNER JOIN estado_civil ec ON dp.id_estado_civil = ec.id_estado_civil
        WHERE h.id_periodo_escolar = p_id_periodo_escolar
        AND hs.nombre = 'Activo'
        GROUP BY c.id_carrera, g.id_grupo
        ON DUPLICATE KEY UPDATE
            total_alumnos = VALUES(total_alumnos),
            mujeres = VALUES(mujeres),
            hombres = VALUES(hombres),
            solteros = VALUES(solteros),
            casados = VALUES(casados),
            union_libre = VALUES(union_libre),
            tipo_registro = 'AUTOMATICO';


        UPDATE periodos_escolares 
        SET estado = 'Cerrado' 
        WHERE id_periodo_escolar = p_id_periodo_escolar;

        INSERT INTO logs_sistema (accion, descripcion, usuario)
        VALUES (
            'CIERRE_PERIODO',
            CONCAT('Cierre automático del período: ', v_periodo_nombre),
            'SISTEMA'
        );

        COMMIT;
        
        SELECT 'OK' AS resultado, 
               CONCAT('Período ', v_periodo_nombre, ' cerrado exitosamente. Datos de matrícula guardados.') AS mensaje;
    ELSE
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Período no encontrado o ya está cerrado';
    END IF;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_cerrar_periodo_automatico");
    }
};
