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
        'id_periodo_escolar',
        'id_grupo',
        'fecha_inscripcion',
        'id_status_inicio',
        'id_status_terminacion',
        'id_historial_status',
        
    ];

    protected $casts = [

        'fecha_inscripcion' => 'date'
    ];

    // Relación con Alumno
    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'id_alumno');
    }

    // Relación con PeriodoEscolar
    public function periodoEscolar()
    {
        return $this->belongsTo(PeriodoEscolar::class, 'id_periodo_escolar');
    }

    // Relación con Grupo
    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'id_grupo');
    }

    // Relación con StatusInicio
    // Status al iniciar
public function statusInicio()
{
    return $this->belongsTo(StatusAcademico::class, 'id_status_inicio', 'id_status_academico');
}

// Status al terminar
public function statusTerminacion()
{
    return $this->belongsTo(StatusAcademico::class, 'id_status_terminacion', 'id_status_academico');
}



    // Relación con HistorialStatus
    public function historialStatus()
    {
        return $this->belongsTo(HistorialStatus::class, 'id_historial_status');
    }
    public function getRouteKeyName()
{
    return 'id_historial';
}

}