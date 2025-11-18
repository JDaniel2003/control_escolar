<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocenteController extends Controller
{
    public function dashboard()
    {
        $docente = auth()->user()->docente;
        return view('docente.dashboard', compact('docente'));
    }

    public function materias()
    {
        return view('docente.materias');
    }

    public function estudiantes()
    {
        return view('docente.estudiantes');
    }

    public function calificaciones()
    {
        return view('docente.calificaciones');
    }

    public function asistencias()
    {
        return view('docente.asistencias');
    }
}