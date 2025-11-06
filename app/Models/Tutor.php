<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Tutor extends Model
{
    use HasFactory;

    protected $table = 'datos_tutores';
    protected $primaryKey = 'id_datos_tutor';
    public $timestamps = false;

    protected $fillable = [
        'nombres',
        'id_parentesco',
        'id_domicilio_tutor',
        'telefono',
    ];
    public function parentescos()
    {
        return $this->belongsTo(Parentesco::class, 'id_parentesco', 'id_parentesco');
    }
    public function domiciliosTutor()
    {
        return $this->belongsTo(DomicilioTutor::class, 'id_domicilio_tutor', 'id_domicilio_tutor');
    }
    public function alumno()
{
    return $this->belongsTo(Alumno::class, 'id_datos_personales', 'id_datos_personales');
}

}
