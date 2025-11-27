<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatosAcademicos extends Model
{
    use HasFactory;

    protected $table = 'datos_academicos';
    protected $primaryKey = 'id_datos_academicos';
    public $timestamps = false;

    protected $fillable = [
        'matricula',
        'id_carrera',
        'id_plan_estudio',
        'fecha_inscripcion',
    ];
        public function carrera()
{
    return $this->belongsTo(Carrera::class, 'id_carrera');
}
public function planEstudio() {
    return $this->belongsTo(PlanEstudio::class, 'id_plan_estudio');
}
public static function generarMatricula($idCarrera)
{
    $carrera = \App\Models\Carrera::find($idCarrera);

    if (!$carrera || empty($carrera->codigo)) {
        throw new \Exception("La carrera no tiene código asignado");
    }

    $prefijoUP = "UP";     // fijo
    $codigoCarrera = strtoupper($carrera->codigo); // ejemplo: TF
    $año = date('y');      // últimos dos dígitos, ejemplo 25
    $letra = "S";          // fijo

    // Último registro de esa carrera
    $ultimo = self::where('id_carrera', $idCarrera)
        ->whereNotNull('matricula')
        ->orderBy('id_datos_academicos', 'desc')
        ->first();

    // Calcular consecutivo
    $consecutivo = 1;
    if ($ultimo && preg_match('/(\d{3})$/', $ultimo->matricula, $match)) {
        $consecutivo = intval($match[1]) + 1;
    }

    // Formato final
    $numero = str_pad($consecutivo, 3, '0', STR_PAD_LEFT);

    return "{$prefijoUP}{$codigoCarrera}{$año}{$letra}{$numero}";
}


}
