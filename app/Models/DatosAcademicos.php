<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatosAcademicos extends Model
{
    use HasFactory;

    protected $table = 'datos_academicos';
    protected $primaryKey = 'id_datos_academicos';
    public $timestamps = false;

    protected $fillable = [
        'matricula',
        'id_carrera',
        'id_plan_estudio',
        'fecha_inscripcion',
    ];
        public function carrera()
{
    return $this->belongsTo(Carrera::class, 'id_carrera');
}
}
