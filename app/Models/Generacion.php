<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Generacion extends Model
{
    use HasFactory;

    protected $table = 'generaciones';
    protected $primaryKey = 'id_generacion';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
    ];
}
