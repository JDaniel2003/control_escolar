<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DatosDocente extends Model
{
    protected $table = 'datos_docentes';
    protected $primaryKey = 'id_datos_docentes';
    
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'edad',
        'id_genero',
        'fecha_nacimiento',
        'cedula_profesional',
        'rfc',
        'telefono',
        'correo',
        'curp',
        'id_domicilio_docente',
        'numero_seguridad_social',
        'datos'
    ];

    // Relación con Docente - CORREGIDA
    public function docente()
    {
        return $this->hasOne(Docente::class, 'id_datos_docentes', 'id_datos_docentes');
    }

    // Método para obtener nombre completo
   public function getDatosDocenteAttribute()
{
    if ($this->id_datos_docentes) {
        return DatosDocente::find($this->id_datos_docentes);
    }
    return null;
}
}