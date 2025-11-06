<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusAcademico extends Model
{
    use HasFactory;

    protected $table = 'status_academico';
    protected $primaryKey = 'id_status_academico';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
    ];
}