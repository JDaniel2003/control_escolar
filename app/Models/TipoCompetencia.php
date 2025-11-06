<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoCompetencia extends Model
{
    use HasFactory;

    protected $table = 'tipos_competencia';
    protected $primaryKey = 'id_tipo_competencia';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
    ];
}
