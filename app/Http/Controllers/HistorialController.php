<?php

namespace App\Http\Controllers;

use App\Models\Historial;
use App\Models\Alumno;
use App\Models\PeriodoEscolar;
use App\Models\Grupo;
use App\Models\NumeroPeriodo;
use App\Models\StatusAcademico;
use App\Models\HistorialStatus;
use App\Models\Materia;
use App\Models\AsignacionDocente;
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
        // Iniciamos la consulta base con relaciones
        $query = Alumno::with(['datosPersonales', 'datosAcademicos', 'statusAcademico', 'generaciones']);

        // 🔹 Filtro general (por matrícula o nombre)
        if ($request->filled('busqueda')) {
            $busqueda = $request->busqueda;

            $query->where(function ($q) use ($busqueda) {
                $q->whereHas('datosAcademicos', function ($q2) use ($busqueda) {
                    $q2->where('matricula', 'LIKE', '%' . $busqueda . '%');
                })
                ->orWhereHas('datosPersonales', function ($q3) use ($busqueda) {
                    $q3->where('nombres', 'LIKE', '%' . $busqueda . '%')
                        ->orWhere('primer_apellido', 'LIKE', '%' . $busqueda . '%')
                        ->orWhere('segundo_apellido', 'LIKE', '%' . $busqueda . '%');
                });
            });
        }
        $historial = Historial::with([
            'alumno',
            'historialStatus',
            'statusInicio',
            'statusTerminacion',
            'asignacion1',
            'asignacion2',
            'asignacion3',
            'asignacion4',
            'asignacion5',
            'asignacion6',
            'asignacion7',
            'asignacion8'
        ])->get();

        // Obtener datos para el modal
        $alumnos = Alumno::all();
        $periodos = \App\Models\PeriodoEscolar::all(); // Asegúrate de tener este modelo
        $grupos = \App\Models\Grupo::with(['carrera', 'turno'])->get();
        $numerosPeriodo = \App\Models\NumeroPeriodo::with('tipoPeriodo')->get();
        $statusAcademicos = StatusAcademico::all();
        $historialStatus = HistorialStatus::all();

        return view('historial.historial', compact(
            'historial', 
            'alumnos', 
            'periodos', 
            'grupos', 
            'numerosPeriodo', 
            'statusAcademicos', 
            'historialStatus'
        ));
    }

    /**
     * Obtener asignaciones disponibles basado en grupo y período
     */
   public function getAsignacionesDisponibles(Request $request)
{
    try {
        $asignaciones = AsignacionDocente::with([
            'materia:id_materia,nombre,horas,id_numero_periodo',
            'docente.datosDocentes',
            'grupo:id_grupo,nombre',
            'periodoEscolar:id_periodo_escolar,nombre'
        ])
        ->where('id_grupo', $request->grupo)
        ->where('id_periodo_escolar', $request->periodo)
        ->get();

        // ✅ Extraer id_numero_periodo común (de la primera materia)
        $idNumeroPeriodo = null;
        if ($asignaciones->isNotEmpty()) {
            $materia = $asignaciones->first()->materia;
            $idNumeroPeriodo = $materia ? $materia->id_numero_periodo : null;
        }

        $asignacionesFormateadas = $asignaciones->map(function ($asignacion) {
            $docenteNombre = trim(
                ($asignacion->docente?->datosDocentes?->nombres ?? '') . ' ' .
                ($asignacion->docente?->datosDocentes?->primer_apellido ?? '') . ' ' .
                ($asignacion->docente?->datosDocentes?->segundo_apellido ?? '')
            ) ?: ($asignacion->docente?->username ?? 'Sin docente');

            return [
                'id_asignacion' => $asignacion->id_asignacion,
                'materia_nombre' => $asignacion->materia->nombre ?? 'Sin nombre',
                'docente_nombre' => $docenteNombre,
                'horas_semana' => $asignacion->materia->horas ?? 0,
            ];
        });

        return response()->json([
            'success' => true,
            'asignaciones' => $asignacionesFormateadas,
            'total' => $asignacionesFormateadas->count(),
            'id_numero_periodo' => $idNumeroPeriodo, // ✅ CLAVE: lo enviamos
        ]);
    } catch (\Exception $e) {
        Log::error('Error en getAsignacionesDisponibles: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Error al cargar asignaciones'], 500);
    }
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    Log::info('=== Intentando crear reinscripción ===', $request->all());

    try {
        // Validación (usa el nombre correcto de la tabla)
        $request->validate([
            'id_alumno' => 'required|exists:alumnos,id_alumno',
            'id_periodo_escolar' => 'required|exists:periodos_escolares,id_periodo_escolar',
            'id_grupo' => 'required|exists:grupos,id_grupo',
            'id_numero_periodo' => 'required|exists:numero_periodos,id_numero_periodo', // tabla en singular
            'fecha_inscripcion' => 'required|date',
            'asignaciones' => 'required|json',
            'id_historial_status' => 'nullable|exists:historial_status,id_historial_status',
            'id_status_inicio' => 'nullable|exists:status_academico,id_status_academico',
            'id_status_terminacion' => 'nullable|exists:status_academico,id_status_academico',
        ]);

        $asignacionesIds = json_decode($request->asignaciones, true);

        if (!is_array($asignacionesIds) || empty($asignacionesIds)) {
            return back()->withErrors(['asignaciones' => 'Debe seleccionar al menos una asignación.'])->withInput();
        }

        if (count($asignacionesIds) > 8) {
            return back()->withErrors(['asignaciones' => 'Máximo 8 asignaciones permitidas.'])->withInput();
        }

        // Preparar datos del historial
        $data = [
            'id_alumno' => $request->id_alumno,
            'fecha_inscripcion' => $request->fecha_inscripcion,
            'id_historial_status' => $request->id_historial_status ?? 1,
            'id_status_inicio' => $request->id_status_inicio,
            'id_status_terminacion' => $request->id_status_terminacion,
            
        ];

        // ✅ Solo llenar las asignaciones seleccionadas (máximo 8)
        // Las columnas restantes (9 y 10) se quedarán NULL por defecto
        for ($i = 1; $i <= 8; $i++) {
            $data["id_asignacion_$i"] = $asignacionesIds[$i - 1] ?? null;
        }

        // Si tu tabla tiene 10 columnas y quieres asegurar que 9 y 10 estén NULL:
        $data['id_asignacion_9'] = null;
        $data['id_asignacion_10'] = null;

        // Guardar
        $historial = Historial::create($data);

        Log::info('✅ Reinscripción creada con ID:', ['id' => $historial->id_historial]);

        return redirect()->route('historial.index')
            ->with('success', 'Reinscripción creada exitosamente.');

    } catch (\Exception $e) {
        Log::error('❌ Error en store:', [
            'message' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => basename($e->getFile())
        ]);
        return back()->withErrors(['error' => 'Error al guardar: ' . $e->getMessage()])->withInput();
    }
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $alumnos = Alumno::all();
        $historialStatus = HistorialStatus::all();
        $statusAcademicos = StatusAcademico::all();
        $asignaciones = AsignacionDocente::with(['docente', 'materia', 'grupo', 'periodoEscolar'])->get();
        $periodos = \App\Models\PeriodoEscolar::all();
        $grupos = \App\Models\Grupo::with(['carrera', 'turno'])->get();
        $numerosPeriodo = \App\Models\NumeroPeriodo::with('tipoPeriodo')->get();

        return view('historial.create', compact(
            'alumnos', 
            'historialStatus', 
            'statusAcademicos', 
            'asignaciones',
            'periodos',
            'grupos',
            'numerosPeriodo'
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show(Historial $historial)
    {
        $historial->load([
            'alumno',
            'historialStatus',
            'statusInicio',
            'statusTerminacion',
            'asignacion1.docente.materia.grupo.periodoEscolar',
            'asignacion2.docente.materia.grupo.periodoEscolar',
            'asignacion3.docente.materia.grupo.periodoEscolar',
            'asignacion4.docente.materia.grupo.periodoEscolar',
            'asignacion5.docente.materia.grupo.periodoEscolar',
            'asignacion6.docente.materia.grupo.periodoEscolar',
            'asignacion7.docente.materia.grupo.periodoEscolar',
            'asignacion8.docente.materia.grupo.periodoEscolar'
        ]);

        return view('historial.show', compact('historial'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Historial $historial)
    {
        $alumnos = Alumno::all();
        $historialStatus = HistorialStatus::all();
        $statusAcademicos = StatusAcademico::all();
        $asignaciones = AsignacionDocente::with(['docente', 'materia', 'grupo', 'periodoEscolar'])->get();
        $periodos = \App\Models\PeriodoEscolar::all();
        $grupos = \App\Models\Grupo::with(['carrera', 'turno'])->get();
        $numerosPeriodo = \App\Models\NumeroPeriodo::with('tipoPeriodo')->get();

        return view('historial.edit', compact(
            'historial', 
            'alumnos', 
            'historialStatus', 
            'statusAcademicos', 
            'asignaciones',
            'periodos',
            'grupos',
            'numerosPeriodo'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Historial $historial)
    {
        $request->validate([
            'id_alumno' => 'required|exists:alumnos,id_alumno',
            'id_historial_status' => 'required|exists:historial_status,id_historial_status',
            'id_status_inicio' => 'required|exists:status_academico,id_status_academico',
            'id_status_terminacion' => 'nullable|exists:status_academico,id_status_academico',
            'fecha_inicio' => 'required|date',
            'fecha_terminacion' => 'nullable|date',
            'promedio_general' => 'nullable|numeric',
            'observaciones' => 'nullable|string'
        ]);

        $historial->update($request->all());

        return redirect()->route('historial.index')
            ->with('success', 'Historial actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Historial $historial)
    {
        $historial->delete();

        return redirect()->route('historial.index')
            ->with('success', 'Historial eliminado exitosamente.');
    }

    /**
     * Buscar alumnos para el modal
     */
    public function buscarAlumnos(Request $request)
    {
        $search = $request->get('search');

        $alumnos = Alumno::where('nombre', 'like', "%{$search}%")
            ->orWhere('apellido', 'like', "%{$search}%")
            ->orWhere('matricula', 'like', "%{$search}%")
            ->get();

        return response()->json($alumnos);
    }

    /**
     * Obtener asignaciones disponibles (método alternativo)
     */
    public function getAsignaciones()
    {
        $asignaciones = AsignacionDocente::with(['docente', 'materia', 'grupo', 'periodoEscolar'])->get();

        return response()->json($asignaciones);
    }


    public function buscarAlumno(Request $request)
    {
        try {
            $matricula = $request->input('matricula');
            Log::info("Buscando alumno con matrícula: " . $matricula);

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
     * Obtener asignaciones docentes disponibles para un grupo y periodo
     */
    public function obtenerAsignaciones(Request $request)
    {
        try {
            $idGrupo = $request->input('id_grupo');
            $idPeriodo = $request->input('id_periodo_escolar');
            $idNumeroPeriodo = $request->input('id_numero_periodo');
            
            Log::info("Buscando asignaciones para grupo: $idGrupo, periodo: $idPeriodo, numero periodo: $idNumeroPeriodo");

            // Se añade la relación 'docente.datosDocentes' para obtener el nombre completo
            $asignaciones = AsignacionDocente::with(['materia', 'docente.datosDocentes'])
                ->where('id_grupo', $idGrupo)
                ->where('id_periodo_escolar', $idPeriodo)
                ->get()
                ->map(function ($asignacion) {
                    // CÓDIGO CORREGIDO PARA MOSTRAR EL NOMBRE COMPLETO DEL DOCENTE
                    $docenteNombre = trim(
                        ($asignacion->docente?->datosDocentes?->nombres ?? '') . ' ' .
                        ($asignacion->docente?->datosDocentes?->primer_apellido ?? '') . ' ' .
                        ($asignacion->docente?->datosDocentes?->segundo_apellido ?? '')
                    );
                    
                    // Fallback por si la relación datosDocentes no tiene el nombre
                    if (empty($docenteNombre)) {
                        $docenteNombre = trim(($asignacion->docente->nombre ?? '') . ' ' . ($asignacion->docente->apellido ?? 'N/A'));
                    }
                    
                    return [
                        'id' => $asignacion->id_asignacion,
                        'materia' => $asignacion->materia->nombre ?? 'N/A',
                        'docente' => $docenteNombre,
                        'clave' => $asignacion->materia->clave ?? ''
                    ];
                });

            return response()->json([
                'success' => true,
                'asignaciones' => $asignaciones
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en obtenerAsignaciones: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar vista de reinscripción masiva
     */
    public function reinscripcionMasiva()
    {
        try {
            $periodos = PeriodoEscolar::orderBy('nombre', 'desc')->get();
            $grupos = Grupo::with(['carrera', 'turno'])->orderBy('nombre')->get();
            $statusAcademicos = StatusAcademico::all();
            $numerosPeriodo = NumeroPeriodo::with('tipoPeriodo')->get();
            
            return view('historial.reinscripcion-masiva', compact(
                'periodos',
                'grupos',
                'statusAcademicos',
                'numerosPeriodo'
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
        $idPeriodo = $request->input('id_periodo');

        if (!$idGrupo || !$idPeriodo) {
            return response()->json(['success' => false, 'message' => 'Faltan parámetros']);
        }

        // ✅ Paso 1: Obtener todos los alumnos que tienen un HISTORIAL ACTIVO en este grupo y período
        // Pero si no tienes las columnas en historial, entonces:
        // ✅ Paso 2: Obtener los alumnos de las asignaciones del grupo y período

        // Primero, obtener los alumnos con historial activo EN CUALQUIER PARTE
        $alumnosConHistorialActivo = Historial::where('id_historial_status', 1)
            ->pluck('id_alumno')
            ->toArray();

        if (empty($alumnosConHistorialActivo)) {
            return response()->json(['success' => true, 'alumnos' => []]);
        }

        // Luego, filtrar esos alumnos que aparecen en ASIGNACIONES del grupo y período
        $asignaciones = AsignacionDocente::where('id_grupo', $idGrupo)
            ->where('id_periodo_escolar', $idPeriodo)
            ->with('materia')
            ->get();

        // Extraer materias del grupo y período
        $materiasIds = $asignaciones->pluck('materia.id_materia')->toArray();

        if (empty($materiasIds)) {
            return response()->json(['success' => true, 'alumnos' => []]);
        }

        // Ahora, buscar alumnos que tengan HISTORIAL ACTIVO y que estén en esas materias
        // Pero como no tienes relación directa, la forma más segura es:
        // ✅ Devolver todos los alumnos que tienen historial activo (ya que el grupo y período ya los filtraste en el JS)

        $alumnos = Alumno::with(['datosPersonales', 'datosAcademicos'])
            ->whereIn('id_alumno', $alumnosConHistorialActivo)
            ->get()
            ->map(fn($a) => [
                'id' => $a->id_alumno,
                'matricula' => $a->datosAcademicos?->matricula ?? 'N/A',
                'nombre' => trim(
                    ($a->datosPersonales?->nombres ?? '') . ' ' .
                    ($a->datosPersonales?->primer_apellido ?? '') . ' ' .
                    ($a->datosPersonales?->segundo_apellido ?? '')
                )
            ])
            ->values();

        return response()->json(['success' => true, 'alumnos' => $alumnos]);

    } catch (\Exception $e) {
        Log::error('obtenerAlumnosGrupo: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Error'], 500);
    }
}

public function obtenerMateriasGrupo(Request $request)
{
    try {
        $idGrupo = $request->input('id_grupo');
        $idPeriodo = $request->input('id_periodo');

        if (!$idGrupo || !$idPeriodo) {
            return response()->json(['success' => false, 'message' => 'Faltan parámetros']);
        }

        $materias = AsignacionDocente::with([
            'materia:id_materia,nombre,horas,id_numero_periodo',
            'docente.datosDocentes'
        ])
        ->where('id_grupo', $idGrupo)
        ->where('id_periodo_escolar', $idPeriodo)
        ->get()
        ->map(function ($asignacion) {
            $docenteNombre = trim(
                ($asignacion->docente?->datosDocentes?->nombres ?? '') . ' ' .
                ($asignacion->docente?->datosDocentes?->primer_apellido ?? '') . ' ' .
                ($asignacion->docente?->datosDocentes?->segundo_apellido ?? '')
            ) ?: ($asignacion->docente?->username ?? 'Sin docente');

            return [
                'id' => $asignacion->id_asignacion,
                'nombre' => $asignacion->materia->nombre ?? 'N/A',
                'docente' => $docenteNombre,
                'horas' => $asignacion->materia->horas ?? 0,
                'id_numero_periodo' => $asignacion->materia->id_numero_periodo,
            ];
        });

        return response()->json(['success' => true, 'materias' => $materias]);
    } catch (\Exception $e) {
        Log::error('obtenerMateriasGrupo: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Error al cargar materias'], 500);
    }
}

    /**
     * Guardar reinscripciones masivas
     */
    public function storeMasivo(Request $request)
    {
        $data = json_decode($request->alumnos_json, true);
    $request->merge(['alumnos' => $data]);
        try {
            Log::info('StoreMasivo - Datos recibidos:', $request->all());

            $validated = $request->validate([
                'id_periodo_escolar' => 'required|exists:periodos_escolares,id_periodo_escolar',
                'id_grupo' => 'required|exists:grupos,id_grupo',
                // Corregir la validación de la tabla a 'numero_periodos' si ese es el nombre correcto de tu tabla. 
                // Asumo que 'numero_periodos' es la tabla correcta, si es 'numero_periodo' la dejo en la línea anterior.
                'id_numero_periodo' => 'required|exists:numero_periodos,id_numero_periodo', 
                'fecha_inscripcion' => 'nullable|date',
                'alumnos' => 'required|array|min:1',
                'alumnos.*.id_alumno' => 'required|exists:alumnos,id_alumno',
                'alumnos.*.id_status_inicio' => 'required|exists:status_academico,id_status_academico',
                'alumnos.*.id_status_terminacion' => 'nullable|exists:status_academico,id_status_academico',
                'alumnos.*.asignaciones' => 'nullable|array|max:8',
                'alumnos.*.asignaciones.*' => 'exists:asignaciones_docentes,id_asignacion',
            ]);

            DB::beginTransaction();

            $reinscripciones = 0;
            $duplicados = 0;

            foreach ($request->alumnos as $alumnoData) {
                // Verificar si ya existe una reinscripción activa para este alumno en este grupo y período
                $existe = Historial::where('id_alumno', $alumnoData['id_alumno'])
                    ->where('id_periodo_escolar', $request->id_periodo_escolar)
                    ->where('id_grupo', $request->id_grupo)
                    // Asumiendo que id_historial_status = 1 significa 'Activo' o 'Vigente'
                    ->exists();

                if ($existe) {
                    $duplicados++;
                    continue;
                }

                $historialData = [
                    'id_alumno' => $alumnoData['id_alumno'],
                    'id_periodo_escolar' => $request->id_periodo_escolar,
                    'id_grupo' => $request->id_grupo,
                    'id_numero_periodo' => $request->id_numero_periodo,
                    'fecha_inscripcion' => $alumnoData['fecha_inscripcion'] ?? $request->fecha_inscripcion ?? now(),
                    'id_status_inicio' => $alumnoData['id_status_inicio'],
                    'id_status_terminacion' => $alumnoData['id_status_terminacion'] ?? null,
                    'id_historial_status' => 1, // Por defecto, se crea como Activo/Vigente
                ];

                // Asignar las asignaciones de docentes (columnas id_asignacion_1 a id_asignacion_8)
                if (isset($alumnoData['asignaciones']) && is_array($alumnoData['asignaciones'])) {
                    for ($i = 1; $i <= 8; $i++) {
                        $historialData["id_asignacion_$i"] = $alumnoData['asignaciones'][$i - 1] ?? null;
                    }
                }
                
                // Asegurar que las columnas 9 y 10 (si existen) estén a null
                $historialData['id_asignacion_9'] = null;
                $historialData['id_asignacion_10'] = null;

                Historial::create($historialData);
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
    public function obtenerNumeroPeriodoPorGrupo(Request $request)
{
    try {
        $grupoId = $request->query('grupo');
        $numeroPeriodo = NumeroPeriodo::with('tipoPeriodo')
            ->where('id_grupo', $grupoId)
            ->first();

        if ($numeroPeriodo) {
            return response()->json([
                'success' => true,
                'numero_periodo' => [
                    'id_numero_periodo' => $numeroPeriodo->id_numero_periodo,
                    'numero' => $numeroPeriodo->numero,
                    'tipo_periodo_nombre' => $numeroPeriodo->tipoPeriodo->nombre ?? null,
                ]
            ]);
        }

        return response()->json(['success' => false]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
    }
}
public function getPeriodoByGrupo(Request $request)
{
    $grupo = Grupo::with('periodoEscolar')->find($request->id);
    if (!$grupo || !$grupo->periodoEscolar) {
        return response()->json(['success' => false]);
    }

    return response()->json([
        'success' => true,
        'id_periodo_escolar' => $grupo->periodoEscolar->id_periodo_escolar,
        'nombre_periodo' => $grupo->periodoEscolar->nombre
    ]);
}
}