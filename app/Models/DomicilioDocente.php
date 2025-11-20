<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DomicilioDocente extends Model
{
    protected $table = 'domicilios_docentes';
    protected $primaryKey = 'id_domicilio_docente';
    public $timestamps = false;

    protected $fillable = [
        'calle',
        'numero_exterior',
        'numero_interior',
        'codigo_postal',
        'id_distrito',      
        'id_estado',        
        'municipio',        
        'colonia',
        'datos',
    ];

    protected $casts = [
        'datos' => 'array',
    ];

    /**
     * Relación con DatosDocente
     */
    public function datosDocentes()
    {
        return $this->hasMany(DatosDocente::class, 'id_domicilio_docente', 'id_domicilio_docente');
    }

    /**
     * Obtener dirección completa
     */
    public function getDireccionCompletaAttribute()
    {
        $direccion = $this->calle;
        
        if ($this->numero_exterior) {
            $direccion .= ' #' . $this->numero_exterior;
        }
        
        if ($this->numero_interior) {
            $direccion .= ' Int. ' . $this->numero_interior;
        }
        
        if ($this->colonia) {
            $direccion .= ', ' . $this->colonia;
        }
        
        if ($this->codigo_postal) {
            $direccion .= ', C.P. ' . $this->codigo_postal;
        }
        
        if ($this->ciudad) {
            $direccion .= ', ' . $this->ciudad;
        }
        
        if ($this->estado) {
            $direccion .= ', ' . $this->estado;
        }
        
        return $direccion;
    }
}