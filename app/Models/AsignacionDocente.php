<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignacionDocente extends Model
{
    use HasFactory;

    protected $table = 'asignaciones_docentes';
    protected $primaryKey = 'id_asignacion';
    public $timestamps = false;

    protected $fillable = [
        'id_docente',
        'id_materia',
        'id_grupo',
        'id_periodo_escolar'
    ];
    /*/ Relación con Docente (Usuario con rol docente)
    public function docente()
    {
        return $this->belongsTo(Usuario::class, 'id_docente', 'id_usuario');
    }*/
    // En el modelo AsignacionDocente
public function docente()
{
    return $this->belongsTo(Docente::class, 'id_docente');
}

    // Relación con Materia
    public function materia()
    {
        return $this->belongsTo(Materia::class, 'id_materia', 'id_materia');
    }

    // Relación con Grupo
    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'id_grupo', 'id_grupo');
    }

    // Relación con Período Escolar
    public function periodoEscolar()
    {
        return $this->belongsTo(PeriodoEscolar::class, 'id_periodo_escolar', 'id_periodo_escolar');
    }
}