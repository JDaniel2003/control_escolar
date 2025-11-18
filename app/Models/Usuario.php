<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios'; // nombre de tu tabla
    protected $primaryKey = 'id_usuario'; // tu PK

    public $timestamps = false; // como no tienes created_at ni updated_at

    protected $fillable = [
        'username',
        'password',
        'id_rol',
    ];

    protected $hidden = [
        'password',
    ];

    // Si quieres usar Auth con username en lugar de email
    public function getAuthIdentifierName()
    {
        return 'username';
    }
    public function rol()
{
    return $this->belongsTo(Rol::class, 'id_rol', 'id_rol');
}
 public function docente()
    {
        return $this->hasOne(Docente::class, 'id_usuario', 'id_usuario');
    }
     public function hasRole($roleName)
    {
        return $this->rol && $this->rol->nombre === $roleName;
    }
// Obtener nivel del usuario
    public function getNivel()
    {
        return $this->rol ? $this->rol->nivel : 0;
    }

    // Verificar si tiene nivel suficiente
    public function hasLevelOrHigher($level)
    {
        return $this->getNivel() >= $level;
    }

    // Verificar si puede gestionar a otro usuario
    public function canManage(Usuario $otherUser)
    {
        return $this->getNivel() > $otherUser->getNivel();
    }

    // Obtener nombre del nivel
    public function getNivelNombre()
    {
        return $this->rol ? $this->rol->nivel_nombre : 'Sin nivel';
    }

    // Scope para usuarios de nivel inferior
    public function scopeWithLowerLevel($query, $level)
    {
        return $query->whereHas('rol', function($q) use ($level) {
            $q->where('nivel', '<', $level);
        });
    }
}
