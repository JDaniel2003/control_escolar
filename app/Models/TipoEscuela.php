<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoEscuela extends Model
{
    use HasFactory;

    protected $table = 'tipos_escuela';
    protected $primaryKey = 'id_tipo_escuela';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
    ];
}
