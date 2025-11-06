<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanEstudio extends Model
{
    use HasFactory;

    protected $table = 'planes_estudio';
    protected $primaryKey = 'id_plan_estudio';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'id_carrera',
        'vigencia',
        'datos',
    ];

    public function carrera()
{
    return $this->belongsTo(Carrera::class, 'id_carrera');
}
public function materias()
    {
        return $this->hasMany(Materia::class, 'id_plan_estudio', 'id_plan_estudio');
    }
}
