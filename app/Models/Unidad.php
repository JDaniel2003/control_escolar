<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    use HasFactory;

    protected $table = 'unidades';
    protected $primaryKey = 'id_unidad';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'numero_unidad',
        'horas_saber',
        'horas_saber_hacer',
        'horas_totales',
        'id_materia',
        'datos',
    ];

    // Relación: una unidad pertenece a una materia
    public function materia()
    {
        return $this->belongsTo(Materia::class, 'id_materia', 'id_materia');
    }
    
}
