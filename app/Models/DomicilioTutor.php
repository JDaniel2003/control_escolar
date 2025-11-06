<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DomicilioTutor extends Model
{
    use HasFactory;

    protected $table = 'domicilios_tutores';
    protected $primaryKey = 'id_domicilio_tutor';
    public $timestamps = false;

    protected $fillable = [
        'calle',
        'numero_exterior',
        'numero_interior',
        'colonia',
        'municipio',
        'id_distrito',
        'id_estado',
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
