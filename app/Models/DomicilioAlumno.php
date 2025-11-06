<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class DomicilioAlumno extends Model
{
    use HasFactory;

    protected $table = 'domicilios_alumnos';
    protected $primaryKey = 'id_domicilio_alumno';
    public $timestamps = false;

    protected $fillable = [
        'calle',
        'numero_exterior',
        'numero_interior',
        'colonia',
        'comunidad',
        'id_distrito',
        'id_estado',
        'municipio',
        'codigo_postal',
    ];

    public function distritos()
    {
        return $this->belongsTo(Distrito::class, 'id_distrito', 'id_distrito');
    }
    public function estados()
    {
        return $this->belongsTo(Estado::class, 'id_estado', 'id_estado');
    }
}
