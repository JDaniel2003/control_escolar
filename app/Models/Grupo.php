<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    protected $table = 'grupos';

    protected $primaryKey = 'id_grupo';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'id_turno',
        'id_carrera',
        'periodo' // llave foranea de tabla periodos_escolares.id_periodo_escolar
    ];

    /**
     * Relación con el modelo Turno
     */
    public function turno()
    {
        return $this->belongsTo(Turno::class, 'id_turno');
    }

    /**
     * Relación con el modelo Carrera
     */
    public function carrera()
{
    return $this->belongsTo(Carrera::class, 'id_carrera', 'id_carrera');
}


    /**
     * Relación con el modelo Historial
     */
    public function historiales()
    {
        return $this->hasMany(Historial::class, 'id_grupo');
    }

    /**
     * Relación con el modelo PeriodoEscolar a través de Historial
     */
    public function periodosEscolares()
    {
        return $this->hasManyThrough(
            PeriodoEscolar::class,
            Historial::class,
            'id_grupo', // Foreign key on historial table
            'id_periodo_escolar', // Foreign key on periodos_escolares table
            'id_grupo', // Local key on grupos table
            'id_periodo_escolar' // Local key on historial table
        );
    }
 

    /**
     * Scope para grupos por carrera
     */
    public function scopePorCarrera($query, $carreraId)
    {
        return $carreraId ? $query->where('id_carrera', $carreraId) : $query;
    }

    /**
     * Scope para grupos por turno
     */
    public function scopePorTurno($query, $turnoId)
    {
        return $turnoId ? $query->where('id_turno', $turnoId) : $query;
    }

    /**
     * Obtener el nombre completo del grupo
     */
    public function getNombreCompletoAttribute()
    {
        $nombre = $this->nombre;
        
        if ($this->carrera) {
            $nombre .= ' - ' . $this->carrera->nombre;
        }
        
        if ($this->turno) {
            $nombre .= ' (' . $this->turno->nombre . ')';
        }
        
        return $nombre;
    }

    /**
     * Obtener la cantidad de alumnos inscritos en el grupo
     */
    public function getCantidadAlumnosAttribute()
    {
        return $this->historiales()
            ->whereHas('historialStatus', function($query) {
                $query->where('incorporacion', false); // Solo alumnos activos
            })
            ->count();
    }

    /**
     * Verificar si el grupo tiene capacidad disponible
     */
    public function tieneCapacidad()
    {
        if (isset($this->datos['capacidad_maxima'])) {
            $capacidadMaxima = $this->datos['capacidad_maxima'];
            $alumnosInscritos = $this->getCantidadAlumnosAttribute();
            return $alumnosInscritos < $capacidadMaxima;
        }
        
        return true; // Si no tiene capacidad definida, siempre tiene espacio
    }

    /**
     * Obtener alumnos activos del grupo
     */
    public function alumnosActivos()
    {
        return $this->hasManyThrough(
            Alumno::class,
            Historial::class,
            'id_grupo',
            'id_alumno',
            'id_grupo',
            'id_alumno'
        )->whereHas('historialStatus', function($query) {
            $query->where('incorporacion', false);
        });
    }

    public function numeroPeriodo()
{
    return $this->belongsTo(NumeroPeriodo::class, 'id_numero_periodo');
}

// Relación con PeriodoEscolar
    public function periodoEscolar()
    {
        return $this->belongsTo(PeriodoEscolar::class, 'periodo');
    }

    // Alias para usar en el controlador (opcional pero recomendado)
    public function periodo()
{
    return $this->belongsTo(PeriodoEscolar::class, 'periodo', 'id_periodo_escolar');
}
}