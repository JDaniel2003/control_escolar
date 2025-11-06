<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Models\Grupo;
use App\Models\PeriodoEscolar;
use App\Models\Historial;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReinscripcionMasivaController extends Controller
{
    public function index()
    {
        $grupos = Grupo::with('carrera')->get();
        $periodos = PeriodoEscolar::where('estado', 'Abierto')->get();

        return view('historial.index', compact('grupos', 'periodos'));
    }

    public function getAlumnos($id_grupo)
    {
        $alumnos = Alumno::where('id_grupo', $id_grupo)
            ->with('datosPersonales')
            ->get();

        return response()->json($alumnos);
    }

    public function store(Request $request)
{
    $request->validate([
        'id_grupo_actual' => 'required|exists:grupos,id_grupo',
        'id_grupo_nuevo' => 'required|exists:grupos,id_grupo',
        'id_periodo_nuevo' => 'required|exists:periodos_escolares,id_periodo_escolar',
        'alumnos' => 'required|array|min:1',
        'alumnos.*' => 'exists:alumnos,id_alumno',
    ]);

    DB::beginTransaction();
    try {
        $fecha = now()->format('Y-m-d');

        foreach ($request->alumnos as $id_alumno) {
            Historial::create([
                'id_alumno' => $id_alumno,
                'id_periodo_escolar' => $request->id_periodo_nuevo,
                'id_grupo' => $request->id_grupo_nuevo,
                'fecha_inscripcion' => $fecha,
                'id_status_inicio' => 1,
                'id_status_terminacion' => null,
                'id_historial_status' => 1,
                'datos' => json_encode([
                    'reinscripcion_masiva' => true,
                ]),
            ]);

            Alumno::where('id_alumno', $id_alumno)
                ->update(['id_grupo' => $request->id_grupo_nuevo]);
        }

        DB::commit();
        return redirect()->route('reinscripciones.masiva.index')
            ->with('success', 'Reinscripción masiva completada correctamente.');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors(['error' => 'Error al reinscribir: ' . $e->getMessage()]);
    }
}

}
