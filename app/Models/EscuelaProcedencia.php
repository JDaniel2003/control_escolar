<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class EscuelaProcedencia extends Model
{
    use HasFactory;

    protected $table = 'datos_escuela_procedencia';
    protected $primaryKey = 'id_datos_escuela_procedencia';
    public $timestamps = false;

    protected $fillable = [
        'promedio_egreso',
        'id_area_especializacion',
        'id_subsistema',
        'localidad',
        'id_estado',
        'id_beca',
        'id_tipo_escuela',
    ];
    public function areaEspecializacion()
    {
        return $this->belongsTo(AreaEspecializacion::class, 'id_area_especializacion', 'id_area_especializacion');
    }
    public function subsistemas()
    {
        return $this->belongsTo(Subsistema::class, 'id_subsistema', 'id_subsistema');
    }
    public function estados()
    {
        return $this->belongsTo(Estado::class, 'id_estado', 'id_estado');
    }
    public function becas()
    {
        return $this->belongsTo(Beca::class, 'id_beca', 'id_beca');
    }
    public function tiposEscuela()
    {
        return $this->belongsTo(TipoEscuela::class, 'id_tipo_escuela', 'id_tipo_escuela');
    }
}
