<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id_rol';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'nivel',
        'datos',
    ];

    protected $casts = [
        'datos' => 'array',
        'nivel' => 'integer',
    ];

    // Jerarquía de niveles (constante)
    public const NIVELES = [
        'SuperAdmin' => 5,
        'Administrador' => 4,
        'Coordinador' => 3,
        'Docente' => 2,
        'Estudiante' => 1,
    ];

    // Relación con Usuarios
    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'id_rol', 'id_rol');
    }

    // Verificar si tiene nivel suficiente
    public function hasLevelOrHigher($level)
    {
        return $this->nivel >= $level;
    }

    // Verificar si es superior a otro rol
    public function isSuperiorTo($otherRole)
    {
        return $this->nivel > $otherRole->nivel;
    }

    // Obtener nombre del nivel (atributo accesible)
    public function getNivelNombreAttribute()
    {
        return array_search($this->nivel, self::NIVELES) ?: 'Sin nivel';
    }
}