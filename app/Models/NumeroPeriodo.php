<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NumeroPeriodo extends Model
{
    use HasFactory;

    protected $table = 'numero_periodos';
    protected $primaryKey = 'id_numero_periodo';
    public $timestamps = false;

    protected $fillable = [
        'numero',
        'id_tipo_periodo'
    ];

    // 🔹 Relaciones
    public function tipoPeriodo()
    {
        return $this->belongsTo(TipoPeriodo::class, 'id_tipo_periodo');
    }

    public function materias()
    {
        return $this->hasMany(Materia::class, 'id_numero_periodo');
    }
}
