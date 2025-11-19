<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdministracionCarrera extends Model
{
    protected $table = 'administracion_carreras';
    protected $primaryKey = 'id_administracion_carrera';
    public $timestamps = false; // si no usas created_at/updated_at

    protected $fillable = [
        'id_area',
        'id_usuario',
        'id_carrera',
        'datos',
    ];

    protected $casts = [
        'datos' => 'array', // permite usar como array en PHP
    ];

    // Relación: pertenece a un Usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    // Relación: pertenece a una Carrera
    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'id_carrera');
    }

    // Opcional: si usas áreas
    public function area()
    {
        return $this->belongsTo(Area::class, 'id_area');
    }
}