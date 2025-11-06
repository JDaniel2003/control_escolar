<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class EstadoCivil extends Model
{
    use HasFactory;

    protected $table = 'estado_civil';
    protected $primaryKey = 'id_estado_civil';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
    ];
}
