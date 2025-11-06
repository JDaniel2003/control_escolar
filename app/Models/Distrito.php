<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Distrito extends Model
{
    use HasFactory;

    protected $table = 'distritos';
    protected $primaryKey = 'id_distrito';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
    ];
}
