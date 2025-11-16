<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    use HasFactory;

    protected $table = 'calificaciones';
    protected $primaryKey = 'id_calificacion';
     public $timestamps = false;
    protected $fillable = [
        'id_alumno',
        'id_unidad',
        'id_evaluacion',
        'id_asignacion',
        'calificacion',
        'calificacion_especial',
        'fecha'
    ];

    /**
     * Relación con Alumno
     */
    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'id_alumno', 'id_alumno');
    }

    /**
     * Relación con Unidad
     */
    public function unidad()
    {
        return $this->belongsTo(Unidad::class, 'id_unidad', 'id_unidad');
    }

    /**
     * Relación con Evaluacion
     */
    public function evaluacion()
    {
        return $this->belongsTo(Evaluacion::class, 'id_evaluacion', 'id_evaluacion');
    }

    /**
     * Relación con AsignacionDocente
     */
    public function asignacionDocente()
    {
        return $this->belongsTo(AsignacionDocente::class, 'id_asignacion', 'id_asignacion');
    }
}