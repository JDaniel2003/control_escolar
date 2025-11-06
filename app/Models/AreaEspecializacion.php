<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AreaEspecializacion extends Model
{
    use HasFactory;

    protected $table = 'area_especializacion';
    protected $primaryKey = 'id_area_especializacion';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
    ];
}
