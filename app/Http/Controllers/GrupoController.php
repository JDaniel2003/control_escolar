<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Turno;
use App\Models\Carrera;
use App\Models\Periodo;
use App\Models\PeriodoEscolar;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    public function index()
    {
        $grupos = Grupo::with(['turno', 'carrera', 'periodoEscolar'])->get();
        $turnos = Turno::all();
        $carreras = Carrera::all();
        $periodos = PeriodoEscolar::all();

        return view('grupos.index', compact('grupos', 'turnos', 'carreras', 'periodos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50|exists:grupos,nombre',
            'id_turno' => 'nullable|exists:turnos,id_turno',
            'id_carrera' => 'nullable|exists:carreras,id_carrera',
            'periodo' => 'nullable|exists:periodos_escolares,id_periodo_escolar',
        ]);

        try {
            Grupo::create($request->only(['nombre', 'id_turno', 'id_carrera', 'periodo']));

            return redirect()->route('grupos.index')->with('success', 'Grupo creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al crear el grupo: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            
            'id_turno' => 'nullable|exists:turnos,id_turno',
            'id_carrera' => 'nullable|exists:carreras,id_carrera',
            'periodo' => 'nullable|exists:periodos_escolares,id_periodo_escolar',
        ]);

        try {
            $grupo = Grupo::findOrFail($id);
            $grupo->update($request->only(['nombre', 'id_turno', 'id_carrera', 'periodo']));

            return redirect()->route('grupos.index')->with('success', 'Grupo actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar el grupo: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $grupo = Grupo::findOrFail($id);
            // Opcional: verificar si tiene asignaciones
            $grupo->delete();

            return redirect()->route('grupos.index')->with('success', 'Grupo eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar el grupo: ' . $e->getMessage());
        }
    }
}