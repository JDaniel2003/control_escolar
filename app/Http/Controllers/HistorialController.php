<?php

namespace App\Http\Controllers;

use App\Models\Historial;
use App\Models\Alumno;
use App\Models\PeriodoEscolar;
use App\Models\Grupo;
use App\Models\StatusAcademico;
use App\Models\HistorialStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HistorialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    try {
        // Obtener los parámetros de filtrado
        $idAlumno = $request->input('id_alumno');
        $idPeriodo = $request->input('id_periodo_escolar');
        $idGrupo = $request->input('id_grupo');
        $idHistorialStatus = $request->input('id_historial_status');
        $matricula = $request->input('matricula'); // ← NUEVO
        $mostrar = $request->input('mostrar', 10);

        // Construir la consulta con eager loading
        $query = Historial::with([
            'alumno.datosPersonales',
            'alumno.datosAcademicos.carrera',
            'periodoEscolar',
            'grupo',
            'statusInicio',
            'statusTerminacion',
            'historialStatus'
        ]);

        // 🔹 Filtro por matrícula (a través de relación)
        if ($matricula) {
            $query->whereHas('alumno.datosAcademicos', function ($q) use ($matricula) {
                $q->where('matricula', 'LIKE', "%{$matricula}%");
            });
        }

        // 🔹 Filtros adicionales
        if ($idAlumno) {
            $query->where('id_alumno', $idAlumno);
        }

        if ($idPeriodo) {
            $query->where('id_periodo_escolar', $idPeriodo);
        }

        if ($idGrupo) {
            $query->where('id_grupo', $idGrupo);
        }

        if ($idHistorialStatus) {
            $query->where('id_historial_status', $idHistorialStatus);
        }

        // Ordenar por fecha de inscripción (más reciente primero)
        $query->orderBy('fecha_inscripcion', 'desc');

        // Paginación o todos
        if ($mostrar === 'todo') {
            $historial = $query->get();
        } else {
            $historial = $query->paginate($mostrar)->withQueryString();
        }

        // Obtener datos para los filtros
        $alumnos = Alumno::with('datosPersonales')->get();
        $periodos = PeriodoEscolar::all();
        $grupos = Grupo::with(['carrera', 'turno'])->get();
        $historialStatus = HistorialStatus::all();
        $statusAcademicos = StatusAcademico::all();

        return view('historial.historial', compact(
            'historial',
            'alumnos',
            'periodos',
            'grupos',
            'historialStatus',
            'statusAcademicos'
        ));

    } catch (\Exception $e) {
        Log::error('Error en historial.index: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Error al cargar el historial: ' . $e->getMessage());
    }
}




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $alumnos = Alumno::with('datosPersonales')->get();
            $periodos = PeriodoEscolar::all();
            $grupos = Grupo::with(['carrera', 'turno'])->get();
            $statusAcademicos = StatusAcademico::all();
            $historialStatus = HistorialStatus::all();

            return view('historial.create', compact(
                'alumnos',
                'periodos',
                'grupos',
                'statusAcademicos',
                'historialStatus'
            ));
        } catch (\Exception $e) {
            Log::error('Error en historial.create: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al cargar el formulario: ' . $e->getMessage());
        }
    }

    /**
     * Guardar un nuevo historial.
     */
    public function store(Request $request)
    {
        try {
            // Log para ver qué datos llegan
            Log::info('Datos recibidos en store:', $request->all());

            // Validación
            $validated = $request->validate([
                'id_alumno' => 'required|exists:alumnos,id_alumno',
                'id_periodo_escolar' => 'required|exists:periodos_escolares,id_periodo_escolar',
                'id_grupo' => 'required|exists:grupos,id_grupo',
                'fecha_inscripcion' => 'nullable|date',
                'id_status_inicio' => 'nullable|exists:status_academico,id_status_academico',
                'id_status_terminacion' => 'nullable|exists:status_academico,id_status_academico',
                'id_historial_status' => 'nullable|exists:historial_status,id_historial_status',
                'datos' => 'nullable|json'
            ]);

            // Procesar datos JSON si existen
            $datos = null;
            if ($request->datos && $request->datos != '') {
                $datos = json_decode($request->datos, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    return redirect()->back()
                        ->with('error', 'El formato JSON de datos adicionales no es válido.')
                        ->withInput();
                }
            }

            DB::beginTransaction();

            // Crear el historial
            $historial = Historial::create([
                'id_alumno' => $request->id_alumno,
                'id_periodo_escolar' => $request->id_periodo_escolar,
                'id_grupo' => $request->id_grupo,
                'fecha_inscripcion' => $request->fecha_inscripcion ?? now(),
                'id_status_inicio' => $request->id_status_inicio,
                'id_status_terminacion' => $request->id_status_terminacion,
                'id_historial_status' => $request->id_historial_status ?? 1, // 1 = Activo por defecto
                'datos' => $datos
            ]);

            DB::commit();

            Log::info('Historial creado exitosamente:', ['id' => $historial->id_historial]);

            return redirect()->route('historial.index')
                ->with('success', 'Reinscripción registrada exitosamente.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::error('Error de validación en historial.store:', $e->errors());
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Por favor, verifica los datos ingresados.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en historial.store: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()->back()
                ->with('error', 'Error al crear la reinscripción: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Historial $historial)
    {
        try {
            $historial->load([
                'alumno.datosPersonales',
                'alumno.datosAcademicos.carrera',
                'alumno.tutor.parentesco',
                'alumno.tutor.domiciliosTutor.estado',
                'periodoEscolar',
                'grupo.carrera',
                'grupo.turno',
                'statusInicio',
                'statusTerminacion',
                'historialStatus'
            ]);

            return view('historial.show', compact('historial'));
        } catch (\Exception $e) {
            Log::error('Error en historial.show: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al cargar el registro: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Historial $historial)
    {
        try {
            $historial->load(['alumno.datosPersonales', 'alumno.datosAcademicos']);

            $alumnos = Alumno::with('datosPersonales')->get();
            $periodos = PeriodoEscolar::all();
            $grupos = Grupo::with(['carrera', 'turno'])->get();
            $statusAcademicos = StatusAcademico::all();
            $historialStatus = HistorialStatus::all();

            return view('historial.edit', compact(
                'historial',
                'alumnos',
                'periodos',
                'grupos',
                'statusAcademicos',
                'historialStatus'
            ));
        } catch (\Exception $e) {
            Log::error('Error en historial.edit: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al cargar el formulario de edición: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    try {
        Log::info('Datos recibidos en update:', $request->all());

        $historial = Historial::findOrFail($id);
        Log::info('Modelo encontrado en update:', $historial->toArray());

        $validated = $request->validate([
            'id_alumno' => 'required|exists:alumnos,id_alumno',
            'id_periodo_escolar' => 'required|exists:periodos_escolares,id_periodo_escolar',
            'id_grupo' => 'required|exists:grupos,id_grupo',
            'fecha_inscripcion' => 'nullable|date',
            'id_status_inicio' => 'nullable|exists:status_academico,id_status_academico',
            'id_status_terminacion' => 'nullable|exists:status_academico,id_status_academico',
            'id_historial_status' => 'nullable|exists:historial_status,id_historial_status',
            'datos' => 'nullable|json'
        ]);

        $datos = null;
        if ($request->filled('datos')) {
            $datos = json_decode($request->datos, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()->with('error', 'El formato JSON no es válido.')->withInput();
            }
        }

        DB::beginTransaction();

        $historial->update([
            'id_alumno' => $request->id_alumno,
            'id_periodo_escolar' => $request->id_periodo_escolar,
            'id_grupo' => $request->id_grupo,
            'fecha_inscripcion' => $request->fecha_inscripcion ?: $historial->fecha_inscripcion,
            'id_status_inicio' => $request->id_status_inicio,
            'id_status_terminacion' => $request->id_status_terminacion,
            'id_historial_status' => $request->id_historial_status,
            'datos' => $datos
        ]);

        DB::commit();

        Log::info('Historial actualizado exitosamente:', ['id' => $historial->id_historial]);

        return redirect()->route('historial.index')
            ->with('success', 'Reinscripción actualizada exitosamente.');
    } catch (\Illuminate\Validation\ValidationException $e) {
        DB::rollBack();
        Log::error('Error de validación en historial.update:', $e->errors());
        return back()->withErrors($e->validator)
            ->withInput()
            ->with('error', 'Verifica los datos ingresados.');
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error en historial.update: ' . $e->getMessage());
        return back()->with('error', 'Error al actualizar la reinscripción: ' . $e->getMessage());
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Historial $historial)
    {
        try {
            DB::beginTransaction();

            $id = $historial->id_historial;
            $historial->delete();

            DB::commit();

            Log::info('Historial eliminado exitosamente:', ['id' => $id]);

            return redirect()->route('historial.index')
                ->with('success', 'Reinscripción eliminada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en historial.destroy: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al eliminar la reinscripción: ' . $e->getMessage());
        }
    }

    /**
     * Obtener el historial de reinscripciones de un alumno específico
     */
    public function historialAlumno($alumnoId)
    {
        try {
            $historial = Historial::with([
                'periodoEscolar',
                'grupo.carrera',
                'grupo.turno',
                'statusInicio',
                'statusTerminacion',
                'historialStatus'
            ])
            ->where('id_alumno', $alumnoId)
            ->orderBy('fecha_inscripcion', 'desc')
            ->get();

            $alumno = Alumno::with(['datosPersonales', 'datosAcademicos.carrera'])->findOrFail($alumnoId);

            return view('historial.alumno', compact('historial', 'alumno'));
        } catch (\Exception $e) {
            Log::error('Error en historialAlumno: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al cargar el historial del alumno: ' . $e->getMessage());
        }
    }

    /**
     * Obtener reinscripciones por período escolar
     */
    public function porPeriodo($periodoId)
    {
        try {
            $historial = Historial::with([
                'alumno.datosPersonales',
                'alumno.datosAcademicos',
                'grupo.carrera',
                'statusInicio',
                'statusTerminacion',
                'historialStatus'
            ])
            ->where('id_periodo_escolar', $periodoId)
            ->orderBy('fecha_inscripcion', 'desc')
            ->get();

            $periodo = PeriodoEscolar::findOrFail($periodoId);

            return view('historial.periodo', compact('historial', 'periodo'));
        } catch (\Exception $e) {
            Log::error('Error en porPeriodo: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al cargar las reinscripciones del período: ' . $e->getMessage());
        }
    }
    public function buscarAlumno(Request $request)
{
    try {
        $matricula = $request->input('matricula');
        Log::info("Buscando alumno con matrícula: " . $matricula);

        // Buscar el alumno por la matrícula dentro de la relación datosAcademicos
        $alumno = \App\Models\Alumno::with(['datosPersonales', 'datosAcademicos'])
            ->whereHas('datosAcademicos', function ($query) use ($matricula) {
                $query->where('matricula', $matricula);
            })
            ->first();

        if ($alumno && $alumno->datosPersonales) {
            return response()->json([
                'success' => true,
                'id_alumno' => $alumno->id_alumno,
                'nombre' => trim(
                    ($alumno->datosPersonales->nombres ?? '') . ' ' .
                    ($alumno->datosPersonales->primer_apellido ?? '') . ' ' .
                    ($alumno->datosPersonales->segundo_apellido ?? '')
                )
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró alumno con esa matrícula.'
            ]);
        }

    } catch (\Exception $e) {
        Log::error('Error en buscarAlumno: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error en el servidor: ' . $e->getMessage()
        ], 500);
    }
}


/**
 * Mostrar vista de reinscripción masiva
 */
/**
 * Mostrar vista de reinscripción masiva
 */
public function reinscripcionMasiva()
{
    try {
        $periodos = PeriodoEscolar::orderBy('nombre', 'desc')->get();
        $grupos = Grupo::with(['carrera', 'turno'])->orderBy('nombre')->get();
        $statusAcademicos = StatusAcademico::all();
        
        // ✅ CAMBIADO: de 'historial.index' a 'historial.reinscripcion-masiva'
        return view('historial.reinscripcion-masiva', compact(
            'periodos',
            'grupos',
            'statusAcademicos'
        ));
    } catch (\Exception $e) {
        Log::error('Error en reinscripcionMasiva: ' . $e->getMessage());
        return redirect()->route('historial.index')
            ->with('error', 'Error al cargar la vista: ' . $e->getMessage());
    }
}

    /**
     * Obtener alumnos de un grupo
     */
    public function obtenerAlumnosGrupo(Request $request)
    {
        try {
            $idGrupo = $request->input('id_grupo');
            
            Log::info("Buscando alumnos del grupo: $idGrupo");

            // Buscar alumnos activos en ese grupo
            $alumnos = Alumno::with(['datosPersonales', 'datosAcademicos'])
                ->whereHas('historial', function ($query) use ($idGrupo) {
                    $query->where('id_grupo', $idGrupo)
                          ->where('id_historial_status', 1);
                })
                ->get()
                ->unique('id_alumno')
                ->map(function ($alumno) {
                    return [
                        'id' => $alumno->id_alumno,
                        'matricula' => $alumno->datosAcademicos->matricula ?? 'N/A',
                        'nombre' => trim(
                            ($alumno->datosPersonales->nombres ?? '') . ' ' .
                            ($alumno->datosPersonales->primer_apellido ?? '') . ' ' .
                            ($alumno->datosPersonales->segundo_apellido ?? '')
                        ),
                        'promedio' => $alumno->datosAcademicos->promedio ?? 8.0,
                        'materias' => 6,
                    ];
                })
                ->values();

            return response()->json([
                'success' => true,
                'alumnos' => $alumnos
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en obtenerAlumnosGrupo: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Guardar reinscripciones masivas
     */
    public function storeMasivo(Request $request)
    {
        try {
            Log::info('StoreMasivo - Datos recibidos:', $request->all());

            $validated = $request->validate([
                'id_periodo_escolar' => 'required|exists:periodos_escolares,id_periodo_escolar',
                'id_grupo' => 'required|exists:grupos,id_grupo',
                'fecha_inscripcion' => 'nullable|date',
                'alumnos' => 'required|array|min:1',
                'alumnos.*.id_alumno' => 'required|exists:alumnos,id_alumno',
                'alumnos.*.id_status_inicio' => 'required|exists:status_academico,id_status_academico',
                'alumnos.*.id_status_terminacion' => 'nullable|exists:status_academico,id_status_academico',
            ]);

            DB::beginTransaction();

            $reinscripciones = 0;
            $duplicados = 0;

            foreach ($request->alumnos as $alumnoData) {
                $existe = Historial::where('id_alumno', $alumnoData['id_alumno'])
                    ->where('id_periodo_escolar', $request->id_periodo_escolar)
                    ->where('id_grupo', $request->id_grupo)
                    ->exists();

                if ($existe) {
                    $duplicados++;
                    continue;
                }

                Historial::create([
                    'id_alumno' => $alumnoData['id_alumno'],
                    'id_periodo_escolar' => $request->id_periodo_escolar,
                    'id_grupo' => $request->id_grupo,
                    'fecha_inscripcion' => $alumnoData['fecha_inscripcion'] ?? $request->fecha_inscripcion ?? now(),
                    'id_status_inicio' => $alumnoData['id_status_inicio'],
                    'id_status_terminacion' => $alumnoData['id_status_terminacion'] ?? null,
                    'id_historial_status' => 1,
                ]);

                $reinscripciones++;
            }

            DB::commit();

            $mensaje = "$reinscripciones reinscripciones guardadas exitosamente";
            if ($duplicados > 0) {
                $mensaje .= ". $duplicados ya existían";
            }

            return response()->json([
                'success' => true,
                'message' => $mensaje,
                'reinscripciones' => $reinscripciones
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en storeMasivo: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

}