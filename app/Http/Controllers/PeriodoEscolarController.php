<?php

namespace App\Http\Controllers;

use App\Models\PeriodoEscolar;
use App\Models\TipoPeriodo;
use Illuminate\Http\Request;

class PeriodoEscolarController extends Controller
{
    public function index(Request $request)
    {
        $query = PeriodoEscolar::with('tipoPeriodo');


        
        // Filtro por nombre
        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // Filtro por fechas
        // ---- Filtro por fecha exacta ----
if ($request->filled('fecha_inicio')) {
    $query->whereDate('fecha_inicio', $request->fecha_inicio);
}

if ($request->filled('fecha_fin')) {
    $query->whereDate('fecha_fin', $request->fecha_fin);
}


        // Filtro por tipo de período
        if ($request->filled('id_tipo_periodo')) {
            $query->where('id_tipo_periodo', $request->id_tipo_periodo);
        }

        // Orden fijo (por fecha_inicio orden)
        //$periodos = $query->orderBy('fecha_inicio', 'orden')->paginate(10);
        $mostrar = $request->get('mostrar', 10); // por defecto 10

        if ($mostrar === "todo") {
            $periodos = $query->orderBy('id_periodo_escolar', 'desc')->get();
        } else {
            $periodos = $query->orderBy('id_periodo_escolar', 'desc')->paginate((int)$mostrar);
        }

        
        // Para llenar el select de tipos
        $tipos = TipoPeriodo::all();
        return view('layouts.periodos', compact('periodos', 'tipos'));
    }

    ///////////////////////////////////////////////////////////////////////////////
    public function create()
    {
        $tipos = TipoPeriodo::all();
        return view('periodos.create', compact('tipos'));
    }

    public function store(Request $request)
    {
        // Validación de todos los campos
        $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
                'unique:periodos_escolares,nombre',
                // formato con guion (ejemplo: JULIO-DICIEMBRE 2024)
                'regex:/^[A-ZÁÉÍÓÚÑ]+-[A-ZÁÉÍÓÚÑ]+ \d{4}$/'

            ],
            'id_tipo_periodo' => 'required|exists:tipos_periodos,id_tipo_periodo',
            // 🔹 obligatorio y debe existir
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'estado' => 'required|in:Abierto,Cerrado',
        ], [
            // Mensajes personalizados
            'nombre.unique' => 'El nombre del período ya existe.',
            'nombre.regex' => 'El nombre debe tener el formato JULIO-DICIEMBRE 2024.',
            'nombre.required' => 'El campo nombre es obligatorio.',
            'id_tipo_periodo.required' => 'Debes seleccionar un tipo de período.',
            'id_tipo_periodo.exists' => 'El tipo de período seleccionado no es válido.',
        ]);

        // Inserción en la base de datos
        PeriodoEscolar::create([
            'nombre' => $request->nombre,
            'id_tipo_periodo' => $request->id_tipo_periodo,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'estado' => $request->estado,
        ]);

        // Redirección con mensaje de éxito
        return redirect()->route('periodos.index')
            ->with('success', 'Período escolar creado correctamente.');
    }

    public function edit($id)
    {
        $tipos = TipoPeriodo::all();
        $periodo = PeriodoEscolar::findOrFail($id);
        return view('periodos.edit', compact('periodo', 'tipos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
                'unique:periodos_escolares,nombre,' . $id . ',id_periodo_escolar',
                // formato con guion (ejemplo: JULIO-DICIEMBRE 2024)
                'regex:/^[A-ZÁÉÍÓÚÑ]+-[A-ZÁÉÍÓÚÑ]+ \d{4}$/'

            ],
            'id_tipo_periodo' => 'required|exists:tipos_periodos,id_tipo_periodo',
            // 🔹 obligatorio y debe existir
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'estado' => 'required|in:Abierto,Cerrado',
        ], [
            // Mensajes personalizados
            'nombre.unique' => 'El nombre del período ya existe.',
            'nombre.regex' => 'El nombre debe tener el formato JULIO-DICIEMBRE 2024.',
            'nombre.required' => 'El campo nombre es obligatorio.',
            'id_tipo_periodo.required' => 'Debes seleccionar un tipo de período.',
            'id_tipo_periodo.exists' => 'El tipo de período seleccionado no es válido.',
        ]);

        $periodo = PeriodoEscolar::findOrFail($id);
        $periodo->update($request->all());

        return redirect()->route('periodos.index')
            ->with('success', 'Período escolar actualizado correctamente.');
    }

    public function destroy($id)
    {
        $periodo = PeriodoEscolar::findOrFail($id);
        $periodo->delete();

        return redirect()->route('periodos.index')
            ->with('success', 'Período escolar eliminado correctamente.');
    }
}
