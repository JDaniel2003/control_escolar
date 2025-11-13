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
        DB::unprepared("CREATE DEFINER=`root`@`%` PROCEDURE `sp_poblar_historial_matricula`()
BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE v_id_periodo INT;
    DECLARE cur_periodos CURSOR FOR 
        SELECT id_periodo_escolar 
        FROM periodos_escolares 
        WHERE estado = 'Cerrado';
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    OPEN cur_periodos;
    read_loop: LOOP
        FETCH cur_periodos INTO v_id_periodo;
        IF done THEN
            LEAVE read_loop;
        END IF;
        
        -- Insertar datos para este período cerrado
        INSERT INTO historial_matricula_periodo (
            id_carrera, id_grupo, id_periodo_escolar, total_alumnos, 
            mujeres, hombres, solteros, casados, union_libre
        )
        SELECT 
            c.id_carrera,
            g.id_grupo,
            v_id_periodo,
            COUNT(DISTINCT a.id_alumno) AS total_alumnos,
            COUNT(DISTINCT CASE WHEN gen.nombre = 'Femenino' THEN a.id_alumno END) AS mujeres,
            COUNT(DISTINCT CASE WHEN gen.nombre = 'Masculino' THEN a.id_alumno END) AS hombres,
            COUNT(DISTINCT CASE WHEN ec.nombre = 'Soltero(a)' THEN a.id_alumno END) AS solteros,
            COUNT(DISTINCT CASE WHEN ec.nombre = 'Casado(a)' THEN a.id_alumno END) AS casados,
            COUNT(DISTINCT CASE WHEN ec.nombre = 'Unión libre' THEN a.id_alumno END) AS union_libre
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
        WHERE h.id_periodo_escolar = v_id_periodo
        AND hs.nombre = 'Activo'
        GROUP BY c.id_carrera, g.id_grupo
        ON DUPLICATE KEY UPDATE
            total_alumnos = VALUES(total_alumnos),
            mujeres = VALUES(mujeres),
            hombres = VALUES(hombres),
            solteros = VALUES(solteros),
            casados = VALUES(casados),
            union_libre = VALUES(union_libre);
        
    END LOOP;
    CLOSE cur_periodos;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_poblar_historial_matricula");
    }
};
