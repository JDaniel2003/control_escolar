<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historial extends Model
{
    use HasFactory;

    protected $table = 'historial';
    protected $primaryKey = 'id_historial';
    public $timestamps = false;

    protected $fillable = [
        'id_alumno',
        'fecha_inscripcion',
        'id_status_inicio',
        'id_status_terminacion',
        'id_historial_status',
        'id_asignacion_1',
        'id_asignacion_2',
        'id_asignacion_3',
        'id_asignacion_4',
        'id_asignacion_5',
        'id_asignacion_6',
        'id_asignacion_7',
        'id_asignacion_8',
    ];

    protected $casts = [
        'fecha_inscripcion' => 'date'
    ];

    // ==================== RELACIONES PRINCIPALES ====================

    /**
     * Relación con Alumno
     */
    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'id_alumno', 'id_alumno');
    }

    /**
     * Relación con Periodo Escolar
     */
    public function periodoEscolar()
    {
        return $this->belongsTo(PeriodoEscolar::class, 'id_periodo_escolar', 'id_periodo_escolar');
    }

    /**
     * Relación con Grupo
     */
    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'id_grupo', 'id_grupo');
    }

    /**
     * Relación con Número de Periodo
     */
    public function numeroPeriodo()
    {
        return $this->belongsTo(NumeroPeriodo::class, 'id_numero_periodo', 'id_numero_periodo');
    }

    /**
     * Relación con Status Academico (Inicio)
     */
    public function statusInicio()
    {
        return $this->belongsTo(StatusAcademico::class, 'id_status_inicio', 'id_status_academico');
    }

    /**
     * Relación con Status Academico (Terminación)
     */
    public function statusTerminacion()
    {
        return $this->belongsTo(StatusAcademico::class, 'id_status_terminacion', 'id_status_academico');
    }

    /**
     * Relación con Historial Status
     */
    public function historialStatus()
    {
        return $this->belongsTo(HistorialStatus::class, 'id_historial_status', 'id_historial_status');
    }

    // ==================== RELACIONES CON ASIGNACIONES DOCENTES ====================

    /**
     * Relación con Asignación Docente 1
     */
    public function asignacion1()
    {
        return $this->belongsTo(AsignacionDocente::class, 'id_asignacion_1', 'id_asignacion');
    }

    /**
     * Relación con Asignación Docente 2
     */
    public function asignacion2()
    {
        return $this->belongsTo(AsignacionDocente::class, 'id_asignacion_2', 'id_asignacion');
    }

    /**
     * Relación con Asignación Docente 3
     */
    public function asignacion3()
    {
        return $this->belongsTo(AsignacionDocente::class, 'id_asignacion_3', 'id_asignacion');
    }

    /**
     * Relación con Asignación Docente 4
     */
    public function asignacion4()
    {
        return $this->belongsTo(AsignacionDocente::class, 'id_asignacion_4', 'id_asignacion');
    }

    /**
     * Relación con Asignación Docente 5
     */
    public function asignacion5()
    {
        return $this->belongsTo(AsignacionDocente::class, 'id_asignacion_5', 'id_asignacion');
    }

    /**
     * Relación con Asignación Docente 6
     */
    public function asignacion6()
    {
        return $this->belongsTo(AsignacionDocente::class, 'id_asignacion_6', 'id_asignacion');
    }

    /**
     * Relación con Asignación Docente 7
     */
    public function asignacion7()
    {
        return $this->belongsTo(AsignacionDocente::class, 'id_asignacion_7', 'id_asignacion');
    }

    /**
     * Relación con Asignación Docente 8
     */
    public function asignacion8()
    {
        return $this->belongsTo(AsignacionDocente::class, 'id_asignacion_8', 'id_asignacion');
    }

    // ==================== ACCESSORS & MUTATORS ====================

    /**
     * Obtener datos como array
     */
    public function getDatosAttribute($value)
    {
        if (is_null($value)) {
            return null;
        }
        
        if (is_array($value)) {
            return $value;
        }
        
        $decoded = json_decode($value, true);
        return $decoded;
    }

    /**
     * Guardar datos como JSON
     */
    public function setDatosAttribute($value)
    {
        if (is_null($value) || empty($value)) {
            $this->attributes['datos'] = null;
        } elseif (is_array($value)) {
            $this->attributes['datos'] = json_encode($value);
        } else {
            $this->attributes['datos'] = $value;
        }
    }

    // ==================== MÉTODOS HELPER ====================

    /**
     * Obtener todas las asignaciones del historial
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getAsignacionesAttribute()
    {
        $asignaciones = collect();
        
        for ($i = 1; $i <= 8; $i++) {
            $asignacion = $this->{"asignacion$i"};
            if ($asignacion) {
                $asignaciones->push($asignacion);
            }
        }
        
        return $asignaciones;
    }

    /**
     * Obtener todas las materias asignadas a través de las asignaciones
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getMateriasAttribute()
    {
        return $this->asignaciones->map(function($asignacion) {
            return $asignacion->materia;
        })->filter();
    }

    /**
     * Obtener todos los docentes asignados
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getDocentesAttribute()
    {
        return $this->asignaciones->map(function($asignacion) {
            return $asignacion->docente;
        })->filter();
    }

    /**
     * Obtener array de IDs de asignaciones
     * 
     * @return array
     */
    public function getAsignacionesIdsAttribute()
    {
        $ids = [];
        
        for ($i = 1; $i <= 8; $i++) {
            $idAsignacion = $this->{"id_asignacion_$i"};
            if ($idAsignacion) {
                $ids[] = $idAsignacion;
            }
        }
        
        return $ids;
    }

    /**
     * Verificar si el historial está activo
     * 
     * @return bool
     */
    public function isActivo()
    {
        return $this->id_historial_status == 1;
    }

    /**
     * Verificar si tiene asignaciones
     * 
     * @return bool
     */
    public function tieneAsignaciones()
    {
        return $this->asignaciones->isNotEmpty();
    }

    /**
     * Contar asignaciones
     * 
     * @return int
     */
    public function contarAsignaciones()
    {
        return $this->asignaciones->count();
    }

    /**
     * Agregar una asignación en la primera posición disponible
     * 
     * @param int $idAsignacion
     * @return bool
     */
    public function agregarAsignacion($idAsignacion)
    {
        for ($i = 1; $i <= 8; $i++) {
            if (is_null($this->{"id_asignacion_$i"})) {
                $this->{"id_asignacion_$i"} = $idAsignacion;
                $this->save();
                return true;
            }
        }
        
        return false; // No hay espacio disponible
    }

    /**
     * Remover una asignación específica
     * 
     * @param int $idAsignacion
     * @return void
     */
    public function removerAsignacion($idAsignacion)
    {
        for ($i = 1; $i <= 8; $i++) {
            if ($this->{"id_asignacion_$i"} == $idAsignacion) {
                $this->{"id_asignacion_$i"} = null;
            }
        }
        
        $this->save();
    }

    /**
     * Limpiar todas las asignaciones
     * 
     * @return void
     */
    public function limpiarAsignaciones()
    {
        for ($i = 1; $i <= 8; $i++) {
            $this->{"id_asignacion_$i"} = null;
        }
        
        $this->save();
    }

    /**
     * Establecer asignaciones desde un array
     * 
     * @param array $asignaciones Array de IDs de asignaciones
     * @return void
     */
    public function establecerAsignaciones(array $asignaciones)
    {
        // Limpiar primero
        $this->limpiarAsignaciones();
        
        // Asignar nuevas (máximo 8)
        foreach (array_slice($asignaciones, 0, 8) as $index => $idAsignacion) {
            $posicion = $index + 1;
            $this->{"id_asignacion_$posicion"} = $idAsignacion;
        }
        
        $this->save();
    }

    /**
     * Verificar si tiene espacios disponibles para más asignaciones
     * 
     * @return bool
     */
    public function tieneEspacioDisponible()
    {
        return $this->contarAsignaciones() < 8;
    }

    /**
     * Obtener número de espacios disponibles
     * 
     * @return int
     */
    public function espaciosDisponibles()
    {
        return 8 - $this->contarAsignaciones();
    }

    // ==================== SCOPES ====================

    /**
     * Scope para historial activo
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActivo($query)
    {
        return $query->where('id_historial_status', 1);
    }

    /**
     * Scope para historial inactivo
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInactivo($query)
    {
        return $query->where('id_historial_status', '!=', 1);
    }

    /**
     * Scope para historial por alumno
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $idAlumno
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePorAlumno($query, $idAlumno)
    {
        return $query->where('id_alumno', $idAlumno);
    }

    /**
     * Scope para historial por periodo
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $idPeriodo
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePorPeriodo($query, $idPeriodo)
    {
        return $query->where('id_periodo_escolar', $idPeriodo);
    }

    /**
     * Scope para historial por grupo
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $idGrupo
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePorGrupo($query, $idGrupo)
    {
        return $query->where('id_grupo', $idGrupo);
    }

    /**
     * Scope para historial por número de periodo
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $idNumeroPeriodo
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePorNumeroPeriodo($query, $idNumeroPeriodo)
    {
        return $query->where('id_numero_periodo', $idNumeroPeriodo);
    }

    /**
     * Scope para ordenar por fecha más reciente
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecientes($query)
    {
        return $query->orderBy('fecha_inscripcion', 'desc');
    }

    /**
     * Scope para historial con asignaciones cargadas
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeConAsignaciones($query)
    {
        return $query->with([
            'asignacion1.materia',
            'asignacion1.docente.datosPersonales',
            'asignacion2.materia',
            'asignacion2.docente.datosPersonales',
            'asignacion3.materia',
            'asignacion3.docente.datosPersonales',
            'asignacion4.materia',
            'asignacion4.docente.datosPersonales',
            'asignacion5.materia',
            'asignacion5.docente.datosPersonales',
            'asignacion6.materia',
            'asignacion6.docente.datosPersonales',
            'asignacion7.materia',
            'asignacion7.docente.datosPersonales',
            'asignacion8.materia',
            'asignacion8.docente.datosPersonales',
        ]);
    }

    /**
     * Scope para eager loading completo
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeConRelaciones($query)
    {
        return $query->with([
            'alumno.datosPersonales',
            'alumno.datosAcademicos.carrera',
            'periodoEscolar',
            'grupo.carrera',
            'grupo.turno',
            'numeroPeriodo.tipoPeriodo',
            'statusInicio',
            'statusTerminacion',
            'historialStatus',
        ])->conAsignaciones();
    }
}