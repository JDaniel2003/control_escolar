<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abreviatura extends Model
{
    use HasFactory;

    protected $table = 'abreviaturas';
    protected $primaryKey = 'id_abreviatura';
public $timestamps = false;
    protected $fillable = [
        'nombre',
        'abreviatura'
    ];

    // Relación: una abreviatura pertenece a muchos docentes
    public function docentes()
    {
        return $this->hasMany(DatosDocente::class, 'id_abreviatura', 'id_abreviatura');
    }
}
