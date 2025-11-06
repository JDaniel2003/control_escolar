<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Parentesco extends Model
{
    use HasFactory;

    protected $table = 'parentescos';
    protected $primaryKey = 'id_parentesco';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
    ];
}