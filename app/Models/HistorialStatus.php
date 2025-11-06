<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialStatus extends Model
{
    use HasFactory;

    protected $table = 'historial_status';

    protected $primaryKey = 'id_historial_status';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'incorporacion',
        'datos'
    ];

    protected $casts = [
        'incorporacion' => 'boolean',
        'datos' => 'array'
    ];
}