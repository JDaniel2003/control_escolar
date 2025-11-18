<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EstudianteController extends Controller
{
    public function dashboard()
    {
        return view('estudiante.dashboard');
    }

    public function materias()
    {
        return view('estudiante.materias');
    }

    public function calificaciones()
    {
        return view('estudiante.calificaciones');
    }

    public function horario()
    {
        return view('estudiante.horario');
    }
}