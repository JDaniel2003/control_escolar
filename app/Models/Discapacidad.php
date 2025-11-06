<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Discapacidad extends Model
{
    use HasFactory;

    protected $table = 'discapacidades';
    protected $primaryKey = 'id_discapacidad';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
    ];
}
