<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    protected $table = 'carreras';
    protected $primaryKey = 'id_carrera';
    public $timestamps = false; // tu tabla no tiene created_at ni updated_at

    protected $fillable = [
        'nombre',
        'duracion',
        'datos'
    ];

     public function planesEstudio()
    {
        return $this->hasMany(PlanEstudio::class, 'id_carrera', 'id_carrera');
    }

    public function planVigente()
{
    return $this->hasOne(PlanEstudio::class, 'id_carrera')
                ->where('vigencia', 'vigente');
}

public function datosAcademicos()
    {
        return $this->belongsTo(DatosAcademicos::class, 'id_datos_academicos');
    }
}
