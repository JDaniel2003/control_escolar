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
    return $this->belongsTo(Rol::class, 'id_rol');
}

}
