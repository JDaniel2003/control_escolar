<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesUsuariosSeeder extends Seeder
{
    // Jerarquía de niveles
    public const NIVELES = [
        'SuperAdmin'   => 5,
        'Administrador'=> 4,
        'Coordinador'  => 3,
        'Docente'      => 2,
        'Estudiante'   => 1,
    ];

    public function run(): void
    {
        foreach (self::NIVELES as $nombre => $nivel) {
            DB::table('roles')->updateOrInsert(
                ['nombre' => $nombre],   // <--- ESTA ES LA COLUMNA CORRECTA
                ['nivel' => $nivel]
            );
        }
    }
}
