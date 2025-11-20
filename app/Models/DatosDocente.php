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
        'id_abreviatura',
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

 /**
     * Relación con Género
     */
    public function genero()
    {
        return $this->belongsTo(Genero::class, 'id_genero', 'id_genero');
    }

    /**
     * Relación con Domicilio
     */
    public function domicilioDocente()
    {
        return $this->belongsTo(DomicilioDocente::class, 'id_domicilio_docente', 'id_domicilio_docente');
    }

    /**
     * Obtener nombre completo
     */
    public function getNombreCompletoAttribute()
    {
        return trim($this->nombre . ' ' . $this->apellido_paterno . ' ' . $this->apellido_materno);
    }
public function abreviatura()
{
    return $this->belongsTo(Abreviatura::class, 'id_abreviatura', 'id_abreviatura');
}
public function getNombreConAbreviaturaAttribute()
{
    $abr = $this->abreviatura?->abreviatura ?? '';
    return trim("{$abr} {$this->nombre_completo}");
}

    /**
     * Obtener edad calculada desde fecha de nacimiento
     */
    public function getEdadCalculadaAttribute()
    {
        if ($this->fecha_nacimiento) {
            return $this->fecha_nacimiento->age;
        }
        return $this->edad;
    }
}