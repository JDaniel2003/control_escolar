<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use Illuminate\Http\Request;

class CalificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Calificacion::with(['alumno', 'unidad', 'evaluacion', 'asignacionDocente']);
        
        // Filtros
        if ($request->has('mostrar') && $request->mostrar != 'todo') {
            $query->limit($request->mostrar);
        }
        
        $calificaciones = $query->get();
        
        return view('calificaciones.calificaciones', compact('calificaciones'));
    }
}