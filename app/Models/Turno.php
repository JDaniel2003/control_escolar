<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    use HasFactory;

    protected $table = 'turnos';
    protected $primaryKey = 'id_turno';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'datos'
    ];

    protected $casts = [
        'datos' => 'array'
    ];

    /**
     * Relación con el modelo Grupo
     */
    public function grupos()
    {
        return $this->hasMany(Grupo::class, 'id_turno');
    }

    /**
     * Obtener el horario formateado
     */
    public function getHorarioAttribute()
    {
        return $this->hora_inicio . ' - ' . $this->hora_fin;
    }
}