<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'roles'; // tu tabla de roles
    protected $primaryKey = 'id_rol';
    public $timestamps = false;

    protected $fillable = ['nombre'];
}
