<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    protected $table = 'docentes';
    protected $primaryKey = 'id_docente';
    
    public $timestamps = false;

    protected $fillable = [
        'id_datos_docentes',
        'id_usuario',
        'especialidad',
        'datos'
    ];

    // Relación con Usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    // Relación con DatosDocente - CORREGIDA
    public function datosDocentes()
{
    return $this->belongsTo(DatosDocente::class, 'id_datos_docentes', 'id_datos_docentes');
}

    // Relación con Asignaciones
    public function asignaciones()
    {
        return $this->hasMany(AsignacionDocente::class, 'id_docente');
    }

    public function getNombreCompletoAttribute()
{
    if ($this->datosDocentes) {
        return trim("{$this->datosDocentes->nombre} {$this->datosDocentes->apellido_paterno} {$this->datosDocentes->apellido_materno}");
    }
    return $this->usuario?->username ?? 'Docente sin nombre';
}

public function carreras()
{
    return $this->belongsToMany(
        \App\Models\Carrera::class,
        'administracion_carreras',
        'id_usuario',
        'id_carrera',
        'id_usuario',
        'id_carrera'
    );
}
    
}