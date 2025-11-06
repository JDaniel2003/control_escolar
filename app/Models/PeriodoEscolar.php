<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodoEscolar extends Model
{
    use HasFactory;

    protected $table = 'periodos_escolares';
    protected $primaryKey = 'id_periodo_escolar';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'id_tipo_periodo',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'datos',
    ];

    public function tipoPeriodo()
{
    return $this->belongsTo(TipoPeriodo::class, 'id_tipo_periodo');
}

}
