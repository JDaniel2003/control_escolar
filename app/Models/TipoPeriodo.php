<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoPeriodo extends Model
{
    protected $table = 'tipos_periodos';
    protected $primaryKey = 'id_tipo_periodo';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'duracion',
        'datos',
    ];

    public function periodos()
    {
        return $this->hasMany(PeriodoEscolar::class, 'id_tipo_periodo');
    }
}


