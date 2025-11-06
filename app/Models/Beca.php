<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Beca extends Model
{
    use HasFactory;

    protected $table = 'becas';
    protected $primaryKey = 'id_beca';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
    ];
}
