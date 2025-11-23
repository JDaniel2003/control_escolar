<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdministracionCarrera extends Model
{
    protected $table = 'administracion_carreras';
    protected $primaryKey = 'id_administracion_carrera';
    public $timestamps = false;

    protected $fillable = [
        'id_area',
        'id_usuario',
        'id_carrera',
        'datos',
    ];

    protected $casts = [
        'datos' => 'array', 
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'id_carrera');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'id_area');
    }
}