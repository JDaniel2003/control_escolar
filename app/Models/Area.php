<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'areas'; // Ajusta si tu tabla se llama diferente, ej. 'cat_areas'
    protected $primaryKey = 'id_area';
    public $timestamps = false; // Si no usas created_at/updated_at

    protected $fillable = [
        'nombre',
        // añade otros campos si existen: 'descripcion', 'clave', etc.
    ];

    // Relación: una área puede tener muchas entradas en administracion_carreras
    public function administracionCarreras()
    {
        return $this->hasMany(\App\Models\AdministracionCarrera::class, 'id_area');
    }

    // Opcional: si un área pertenece a algo más (departamento, división, etc.)
    // public function departamento() { ... }
}