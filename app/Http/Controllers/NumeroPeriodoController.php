<?php

namespace App\Http\Controllers;

use App\Models\NumeroPeriodo;
use Illuminate\Http\Request;

class NumeroPeriodoController extends Controller
{
    // Listar
    public function index()
    {
        $periodos = NumeroPeriodo::with('tipoPeriodo')->get();
        return view('numero_periodos.index', compact('periodos'));
    }

    // Crear - Formulario
    public function create()
    {
        return view('numero_periodos.create');
    }

    // Guardar
    public function store(Request $request)
    {
        $request->validate([
            'numero' => 'required|integer|min:1',
            'id_tipo_periodo' => 'required|exists:tipos_periodos,id_tipo_periodo',
        ]);

        NumeroPeriodo::create($request->all());

        return redirect()->route('numero_periodos.index')->with('success', 'Número de periodo creado correctamente.');
    }

    // Editar
    public function edit($id)
    {
        $periodo = NumeroPeriodo::findOrFail($id);
        return view('numero_periodos.edit', compact('periodo'));
    }

    // Actualizar
    public function update(Request $request, $id)
    {
        $request->validate([
            'numero' => 'required|integer|min:1',
            'id_tipo_periodo' => 'required|exists:tipos_periodos,id_tipo_periodo',
        ]);

        $periodo = NumeroPeriodo::findOrFail($id);
        $periodo->update($request->all());

        return redirect()->route('numero_periodos.index')->with('success', 'Número de periodo actualizado.');
    }

    // Eliminar
    public function destroy($id)
    {
        $periodo = NumeroPeriodo::findOrFail($id);
        $periodo->delete();

        return redirect()->route('numero_periodos.index')->with('success', 'Número de periodo eliminado.');
    }
}
