<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    protected $table = 'evaluaciones';
    protected $primaryKey = 'id_evaluacion';
    public $timestamps = false;

    protected $fillable = ['nombre', 'porcentaje', 'orden', 'tipo', 'id_unidad'];

    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class, 'id_evaluacion', 'id_evaluacion');
    }
    public function unidad()
    {
        return $this->belongsTo(Unidad::class, 'id_unidad', 'id_unidad');
    }
}

