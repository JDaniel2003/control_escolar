<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Docente;

class CoordinadorController extends Controller
{
    public function dashboard()
    {
        // Solo puede ver usuarios de nivel inferior (docentes y estudiantes)
        $usuariosGestionables = Usuario::with('rol')
            ->whereHas('rol', function($q) {
                $q->where('nivel', '<', auth()->user()->getNivel());
            })
            ->get();

        return view('coordinador.dashboard', compact('usuariosGestionables'));
    }

    public function docentes()
    {
        // Solo docentes (nivel 2)
        $docentes = Usuario::with(['rol', 'docente'])
            ->whereHas('rol', function($q) {
                $q->where('nivel', 2);
            })
            ->get();

        return view('coordinador.docentes', compact('docentes'));
    }

    public function horarios()
    {
        return view('coordinador.horarios');
    }

    public function asignaciones()
    {
        return view('coordinador.asignaciones');
    }
}