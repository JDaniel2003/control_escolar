<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoSangre extends Model
{
    use HasFactory;

    protected $table = 'tipos_sangre';
    protected $primaryKey = 'id_tipo_sangre';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
    ];
}
