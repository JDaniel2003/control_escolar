<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competencia extends Model
{
    use HasFactory;

    protected $table = 'tipos_competencia';
    protected $primaryKey = 'id_tipo_competencia';
    public $timestamps = false;

    protected $fillable = [
        'nombre'
    ];
     public function materias()
    {
        return $this->hasMany(Materia::class, 'id_numero_periodo');
    }
}
