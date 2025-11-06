<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class LenguaIndigena extends Model
{
    use HasFactory;

    protected $table = 'lengua_indigena';
    protected $primaryKey = 'id_lengua_indigena';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
    ];
}
