<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EspacioFormativo extends Model
{
    use HasFactory;

    protected $table = 'espacios_formativos';
    protected $primaryKey = 'id_espacio_formativo';
    public $timestamps = false;

    protected $fillable = [
        'nombre'
    ];
     public function materias()
    {
        return $this->hasMany(Materia::class, 'id_numero_periodo');
    }
}
