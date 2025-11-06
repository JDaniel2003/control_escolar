<?php

namespace App\Http\Controllers;

use App\Models\AsignacionDocente;
use App\Models\Usuario;
use App\Models\Materia;
use App\Models\Grupo;
use App\Models\PeriodoEscolar;
use App\Models\Carrera;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AsignacionMasivaController extends Controller
{
    // Vista principal
    public function index()
    {
        return view('asignaciones.masiva.index');
    }

    // Asignar materias a grupo
    public function materiasGrupo()
    {
        $grupos = Grupo::with('carrera')->get();
        $periodos = PeriodoEscolar::where('estado', 'Abierto')->get();
        $carreras = Carrera::all();

        // 🔹 Docentes desde usuarios con rol "Docente"
        $docentes = Usuario::whereHas('rol', function ($q) {
            $q->where('nombre', 'Docente');
        })->get();

        return view('asignaciones.masiva.materias-grupo', compact('grupos', 'periodos', 'carreras', 'docentes'));
    }

    // 🔹 Obtener materias filtradas por carrera (usando plan_estudio)
    public function getMateriasPorCarrera($id_carrera)
    {
        $materias = Materia::whereHas('planEstudio', function ($q) use ($id_carrera) {
            $q->where('id_carrera', $id_carrera);
        })->get();

        return response()->json($materias);
    }

    // 🔹 Guardar asignación masiva de materias a grupo
    public function storeMaterias(Request $request)
    {
        $request->validate([
            'id_grupo' => 'required|exists:grupos,id_grupo',
            'id_periodo_escolar' => 'required|exists:periodos_escolares,id_periodo_escolar',
            'materias' => 'required|array|min:1',
            'materias.*' => 'exists:materias,id_materia',
            'docentes' => 'nullable|array',
            'docentes.*' => 'nullable|exists:usuarios,id_usuario',
        ]);

        DB::beginTransaction();
        try {
            $creadas = 0;
            $duplicadas = 0;

            foreach ($request->materias as $index => $id_materia) {
                $existe = AsignacionDocente::where('id_materia', $id_materia)
                    ->where('id_grupo', $request->id_grupo)
                    ->where('id_periodo_escolar', $request->id_periodo_escolar)
                    ->exists();

                if (!$existe) {
                    AsignacionDocente::create([
                        // 🔹 Ahora se guarda id_usuario como id_docente
                        'id_docente' => $request->docentes[$index] ?? null,
                        'id_materia' => $id_materia,
                        'id_grupo' => $request->id_grupo,
                        'id_periodo_escolar' => $request->id_periodo_escolar,
                    ]);
                    $creadas++;
                } else {
                    $duplicadas++;
                }
            }

            DB::commit();

            $mensaje = "Se crearon {$creadas} asignaciones exitosamente.";
            if ($duplicadas > 0) {
                $mensaje .= " {$duplicadas} ya existían.";
            }

            return redirect()->route('asignaciones.index')->with('success', $mensaje);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al crear asignaciones: ' . $e->getMessage()])->withInput();
        }
    }

    // Asignación masiva de docente a materias
    public function docenteMaterias()
    {
        $docentes = Usuario::whereHas('rol', function($q) {
            $q->where('nombre', 'Docente');
        })->get();

        $materias = Materia::with('planEstudio.carrera')->get();
        $grupos = Grupo::with('carrera')->get();
        $periodos = PeriodoEscolar::where('estado', 'Abierto')->get();
        $carreras = Carrera::all();

        return view('asignaciones.masiva.docente-materias', compact('docentes', 'materias', 'grupos', 'periodos', 'carreras'));
    }

    // Guardar asignación masiva de docente
    public function storeDocente(Request $request)
    {
        $request->validate([
            'id_docente' => 'required|exists:usuarios,id_usuario',
            'id_periodo_escolar' => 'required|exists:periodos_escolares,id_periodo_escolar',
            'asignaciones' => 'required|array|min:1',
            'asignaciones.*.id_materia' => 'required|exists:materias,id_materia',
            'asignaciones.*.id_grupo' => 'required|exists:grupos,id_grupo',
        ]);

        DB::beginTransaction();
        try {
            $creadas = 0;
            $duplicadas = 0;

            foreach ($request->asignaciones as $asignacion) {
                $existe = AsignacionDocente::where('id_docente', $request->id_docente)
                    ->where('id_materia', $asignacion['id_materia'])
                    ->where('id_grupo', $asignacion['id_grupo'])
                    ->where('id_periodo_escolar', $request->id_periodo_escolar)
                    ->exists();

                if (!$existe) {
                    AsignacionDocente::create([
                        'id_docente' => $request->id_docente,
                        'id_materia' => $asignacion['id_materia'],
                        'id_grupo' => $asignacion['id_grupo'],
                        'id_periodo_escolar' => $request->id_periodo_escolar,
                    ]);
                    $creadas++;
                } else {
                    $duplicadas++;
                }
            }

            DB::commit();

            $mensaje = "Se crearon {$creadas} asignaciones exitosamente.";
            if ($duplicadas > 0) {
                $mensaje .= " {$duplicadas} ya existían.";
            }

            return redirect()->route('asignaciones.index')->with('success', $mensaje);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al crear asignaciones: ' . $e->getMessage()])->withInput();
        }
    }
}
