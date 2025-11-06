<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subsistema extends Model
{
    use HasFactory;

    protected $table = 'subsistemas';
    protected $primaryKey = 'id_subsistema';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
    ];
}
