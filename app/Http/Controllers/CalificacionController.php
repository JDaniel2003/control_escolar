<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use App\Models\Alumno;
use App\Models\Historial;
use App\Models\AsignacionDocente;
use App\Models\Unidad;
use App\Models\Evaluacion;
use App\Models\PeriodoEscolar;
use App\Models\Grupo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

        // Datos para el modal de calificar
        $periodos = PeriodoEscolar::all();
        $grupos = Grupo::with('carrera')->get();

        return view('calificaciones.calificaciones', compact('calificaciones', 'periodos', 'grupos'));
    }

    /**
     * Obtener materias de un grupo y período
     */
    public function obtenerMaterias(Request $request)
    {
        try {
            $materias = AsignacionDocente::with(['materia', 'docente.datosDocentes'])
                ->where('id_grupo', $request->grupo)
                ->where('id_periodo_escolar', $request->periodo)
                ->get()
                ->map(function ($asignacion) {
                    $docente = $asignacion->docente;
                    $nombreDocente = 'Sin docente';

                    if ($docente) {
                        $nombreDocente = $docente->nombre_completo ??
                            $docente->username ??
                            'Sin nombre';
                    }

                    return [
                        'id_asignacion' => $asignacion->id_asignacion,
                        'materia' => $asignacion->materia->nombre ?? 'N/A',
                        'docente' => $nombreDocente
                    ];
                });

            return response()->json([
                'success' => true,
                'materias' => $materias
            ]);
        } catch (\Exception $e) {
            Log::error('Error en obtenerMaterias: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar materias'
            ], 500);
        }
    }

    /**
     * Obtener unidades de una materia (desde asignación)
     */
    public function obtenerUnidades($idAsignacion)
    {
        try {
            $asignacion = AsignacionDocente::with('materia')->find($idAsignacion);

            if (!$asignacion || !$asignacion->materia) {
                return response()->json([
                    'success' => false,
                    'message' => 'Materia no encontrada'
                ]);
            }

            $unidades = Unidad::where('id_materia', $asignacion->materia->id_materia)
                ->orderBy('numero_unidad')
                ->get()
                ->map(function ($unidad) {
                    return [
                        'id_unidad' => $unidad->id_unidad,
                        'nombre' => "Unidad {$unidad->numero_unidad}: {$unidad->nombre}",
                        'numero_unidad' => $unidad->numero_unidad
                    ];
                });

            return response()->json([
                'success' => true,
                'unidades' => $unidades
            ]);
        } catch (\Exception $e) {
            Log::error('Error en obtenerUnidades: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar unidades'
            ], 500);
        }
    }

    /**
     * Obtener evaluaciones de una unidad
     */
    public function obtenerEvaluaciones($idUnidad)
    {
        try {
            $evaluaciones = Evaluacion::where('id_unidad', $idUnidad)
                ->orderBy('orden')
                ->get()
                ->map(function ($evaluacion) {
                    return [
                        'id_evaluacion' => $evaluacion->id_evaluacion,
                        'nombre' => $evaluacion->nombre,
                        'porcentaje' => $evaluacion->porcentaje ?? 0,
                        'tipo' => $evaluacion->tipo ?? 'Normal'
                    ];
                });

            return response()->json([
                'success' => true,
                'evaluaciones' => $evaluaciones
            ]);
        } catch (\Exception $e) {
            Log::error('Error en obtenerEvaluaciones: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar evaluaciones'
            ], 500);
        }
    }

    /**
     * Obtener alumnos del grupo con sus calificaciones existentes
     */
    public function obtenerAlumnosGrupo(Request $request)
    {
        try {
            $idGrupo = $request->id_grupo;
            $idPeriodo = $request->id_periodo;
            $idAsignacion = $request->id_asignacion;
            $idUnidad = $request->id_unidad;
            $idEvaluacion = $request->id_evaluacion;

            Log::info('Obteniendo alumnos para calificaciones', [
                'grupo' => $idGrupo,
                'periodo' => $idPeriodo,
                'asignacion' => $idAsignacion
            ]);

            // Obtener alumnos del grupo que tienen historial en este período
            $alumnos = Historial::with(['alumno.datosPersonales', 'alumno.datosAcademicos'])
                ->whereHas('alumno')
                ->where(function ($query) use ($idAsignacion) {
                    // Buscar en cualquiera de las 10 columnas de asignaciones
                    for ($i = 1; $i <= 10; $i++) {
                        $query->orWhere("id_asignacion_$i", $idAsignacion);
                    }
                })
                ->get()
                ->unique('id_alumno')
                ->map(function ($historial) use ($idAsignacion, $idUnidad, $idEvaluacion) {
                    if (!$historial->alumno) return null;

                    $alumno = $historial->alumno;

                    // Buscar si ya tiene calificación capturada
                    $calificacionExistente = Calificacion::where('id_alumno', $alumno->id_alumno)
                        ->where('id_asignacion', $idAsignacion)
                        ->where('id_unidad', $idUnidad)
                        ->where('id_evaluacion', $idEvaluacion)
                        ->first();

                    return [
                        'id_alumno' => $alumno->id_alumno,
                        'matricula' => $alumno->datosAcademicos->matricula ?? 'N/A',
                        'nombre' => trim(
                            ($alumno->datosPersonales->nombres ?? '') . ' ' .
                                ($alumno->datosPersonales->primer_apellido ?? '') . ' ' .
                                ($alumno->datosPersonales->segundo_apellido ?? '')
                        ),
                        'calificacion_existente' => $calificacionExistente ? $calificacionExistente->calificacion : null,
                        'observacion' => $calificacionExistente ? $calificacionExistente->calificacion_especial : null,
                        'ya_capturado' => (bool) $calificacionExistente,
                        'id_calificacion' => $calificacionExistente ? $calificacionExistente->id_calificacion : null
                    ];
                })
                ->filter()
                ->sortBy('nombre')
                ->values();

            Log::info('Alumnos encontrados', ['total' => $alumnos->count()]);

            return response()->json([
                'success' => true,
                'alumnos' => $alumnos
            ]);
        } catch (\Exception $e) {
            Log::error('Error en obtenerAlumnosGrupo calificaciones: ' . $e->getMessage());
            Log::error('Stack: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar alumnos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Guardar calificaciones masivas
     */
    public function storeMasivo(Request $request)
    {
        try {
            Log::info('=== INICIO storeMasivo ===');
            Log::info('Request completo:', $request->all());

            // Validar que llegue el JSON
            if (!$request->has('calificaciones_json') || empty($request->calificaciones_json)) {
                Log::error('No se recibió calificaciones_json o está vacío');
                return redirect()->back()->withErrors(['error' => 'No se recibieron datos de calificaciones']);
            }

            $jsonData = $request->input('calificaciones_json');
            $data = json_decode($jsonData, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('Error al decodificar JSON:', ['error' => json_last_error_msg()]);
                return redirect()->back()->withErrors(['error' => 'Error al procesar los datos']);
            }

            if (
                !isset($data['id_asignacion']) || !isset($data['calificaciones']) ||
                !is_array($data['calificaciones']) || count($data['calificaciones']) === 0
            ) {
                return redirect()->back()->withErrors(['error' => 'Datos incompletos']);
            }

            $calificaciones = $data['calificaciones'];
            $idAsignacion = $data['id_asignacion'];

            Log::info('Procesando calificaciones', [
                'total' => count($calificaciones),
                'asignacion' => $idAsignacion
            ]);

            DB::beginTransaction();

            $estadisticas = [
                'nuevas' => 0,
                'actualizadas' => 0,
                'recuperacion' => 0,
                'extraordinario' => 0,
                'extraordinario_especial' => 0,
                'errores' => []
            ];

            foreach ($calificaciones as $index => $cal) {
                try {
                    // Validar datos requeridos
                    if (
                        !isset($cal['id_alumno']) || !isset($cal['id_unidad']) ||
                        !isset($cal['id_evaluacion']) || !isset($cal['calificacion'])
                    ) {
                        $estadisticas['errores'][] = "Datos incompletos en registro {$index}";
                        continue;
                    }

                    $idAlumno = intval($cal['id_alumno']);
                    $idUnidad = intval($cal['id_unidad']);
                    $idEvaluacion = intval($cal['id_evaluacion']);
                    $calificacionNueva = floatval($cal['calificacion']);

                    // Validar rango
                    if ($calificacionNueva < 0 || $calificacionNueva > 10) {
                        $estadisticas['errores'][] = "Calificación fuera de rango para alumno {$idAlumno}";
                        continue;
                    }

                    // Obtener el tipo de evaluación
                    $evaluacion = Evaluacion::find($idEvaluacion);
                    if (!$evaluacion) {
                        $estadisticas['errores'][] = "Evaluación {$idEvaluacion} no encontrada";
                        continue;
                    }

                    $tipoEvaluacion = strtolower($evaluacion->tipo ?? 'ordinario');

                    Log::info("Procesando calificación", [
                        'alumno' => $idAlumno,
                        'unidad' => $idUnidad,
                        'evaluacion' => $idEvaluacion,
                        'tipo' => $tipoEvaluacion,
                        'calificacion' => $calificacionNueva
                    ]);

                    // 🎯 EXTRAORDINARIO ESPECIAL (Calificación general de la materia)
                    if ($tipoEvaluacion === 'extraordinario_especial') {
                        $resultado = $this->procesarExtraordinarioEspecial(
                            $idAlumno,
                            $idAsignacion,
                            $calificacionNueva
                        );

                        if ($resultado['exito']) {
                            $estadisticas['extraordinario_especial']++;
                            Log::info("✅ Extraordinario Especial procesado", $resultado);
                        } else {
                            $estadisticas['errores'][] = $resultado['mensaje'];
                        }
                        continue;
                    }

                    // 🎯 EVALUACIONES POR UNIDAD (Ordinario, Recuperación, Extraordinario)
                    $resultado = $this->procesarCalificacionUnidad(
                        $idAlumno,
                        $idAsignacion,
                        $idUnidad,
                        $idEvaluacion,
                        $tipoEvaluacion,
                        $calificacionNueva
                    );

                    if ($resultado['exito']) {
                        switch ($resultado['accion']) {
                            case 'nueva':
                                $estadisticas['nuevas']++;
                                break;
                            case 'actualizada':
                                $estadisticas['actualizadas']++;
                                break;
                            case 'recuperacion':
                                $estadisticas['recuperacion']++;
                                break;
                            case 'extraordinario':
                                $estadisticas['extraordinario']++;
                                break;
                        }
                        Log::info("✅ {$resultado['mensaje']}", $resultado['datos']);
                    } else {
                        $estadisticas['errores'][] = $resultado['mensaje'];
                    }
                } catch (\Exception $e) {
                    $estadisticas['errores'][] = "Error en alumno {$cal['id_alumno']}: {$e->getMessage()}";
                    Log::error("❌ Error procesando calificación", [
                        'alumno' => $cal['id_alumno'] ?? 'desconocido',
                        'error' => $e->getMessage()
                    ]);
                }
            }

            DB::commit();

            // Construir mensaje de resultado
            $mensaje = $this->construirMensajeResultado($estadisticas);

            Log::info('=== Proceso completado ===', $estadisticas);

            $response = redirect()->route('calificaciones.index')->with('success', $mensaje);

            if (count($estadisticas['errores']) > 0) {
                $response->with('warning', 'Algunos registros tuvieron errores')
                    ->with('errores_detalle', $estadisticas['errores']);
            }

            return $response;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('❌ Error crítico en storeMasivo', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withErrors(['error' => 'Error al guardar: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Procesar calificación por unidad (Ordinario, Recuperación, Extraordinario)
     */
    private function procesarCalificacionUnidad($idAlumno, $idAsignacion, $idUnidad, $idEvaluacion, $tipoEvaluacion, $calificacionNueva)
    {
        // Buscar TODAS las calificaciones de esta unidad (para historial completo)
        $calificacionesExistentes = Calificacion::where('id_alumno', $idAlumno)
            ->where('id_asignacion', $idAsignacion)
            ->where('id_unidad', $idUnidad)
            ->orderBy('fecha', 'desc')
            ->get();

        // Obtener la última calificación registrada
        $ultimaCalificacion = $calificacionesExistentes->first();

        $esAprobatoria = $calificacionNueva >= 6;

        // 📘 CASO 1: Primera calificación (Ordinario)
        if ($calificacionesExistentes->isEmpty() && $tipoEvaluacion === 'ordinario') {
            Calificacion::create([
                'id_alumno' => $idAlumno,
                'id_asignacion' => $idAsignacion,
                'id_unidad' => $idUnidad,
                'id_evaluacion' => $idEvaluacion,
                'calificacion' => $calificacionNueva,
                'fecha' => now()->toDateString()
            ]);

            return [
                'exito' => true,
                'accion' => 'nueva',
                'mensaje' => 'Calificación ordinaria guardada',
                'datos' => ['alumno' => $idAlumno, 'unidad' => $idUnidad, 'calif' => $calificacionNueva]
            ];
        }

        // 📗 CASO 2: Calificación aprobatoria en ordinario - No se modifica
        if ($ultimaCalificacion && $ultimaCalificacion->calificacion >= 6) {
            return [
                'exito' => false,
                'mensaje' => "Alumno {$idAlumno} ya tiene calificación aprobatoria ({$ultimaCalificacion->calificacion}) en unidad {$idUnidad}"
            ];
        }

        // 📙 CASO 3: Recuperación (reprobó en ordinario)
        if ($tipoEvaluacion === 'recuperacion') {
            if ($calificacionesExistentes->isEmpty()) {
                return [
                    'exito' => false,
                    'mensaje' => "No hay calificación ordinaria previa para alumno {$idAlumno}, unidad {$idUnidad}"
                ];
            }

            // Verificar que efectivamente reprobó la última evaluación
            if ($ultimaCalificacion->calificacion >= 6) {
                return [
                    'exito' => false,
                    'mensaje' => "El alumno {$idAlumno} ya aprobó esta unidad con {$ultimaCalificacion->calificacion}"
                ];
            }

            // ✅ CREAR NUEVO REGISTRO para recuperación (mantiene el historial)
            Calificacion::create([
                'id_alumno' => $idAlumno,
                'id_asignacion' => $idAsignacion,
                'id_unidad' => $idUnidad,
                'id_evaluacion' => $idEvaluacion,
                'calificacion' => $calificacionNueva,
                'fecha' => now()->toDateString()
            ]);

            return [
                'exito' => true,
                'accion' => 'recuperacion',
                'mensaje' => $esAprobatoria ? 'Aprobado en recuperación (historial guardado)' : 'Reprobó en recuperación (historial guardado)',
                'datos' => ['alumno' => $idAlumno, 'unidad' => $idUnidad, 'calif' => $calificacionNueva, 'historico' => $calificacionesExistentes->count() + 1]
            ];
        }

        // 📕 CASO 4: Extraordinario (reprobó en ordinario y recuperación)
        if ($tipoEvaluacion === 'extraordinario') {
            if ($calificacionesExistentes->isEmpty()) {
                return [
                    'exito' => false,
                    'mensaje' => "No hay calificación previa para alumno {$idAlumno}, unidad {$idUnidad}"
                ];
            }

            // Verificar que efectivamente reprobó antes
            if ($ultimaCalificacion->calificacion >= 6) {
                return [
                    'exito' => false,
                    'mensaje' => "El alumno {$idAlumno} ya aprobó esta unidad con {$ultimaCalificacion->calificacion}"
                ];
            }

            // ✅ CREAR NUEVO REGISTRO para extraordinario (mantiene el historial)
            Calificacion::create([
                'id_alumno' => $idAlumno,
                'id_asignacion' => $idAsignacion,
                'id_unidad' => $idUnidad,
                'id_evaluacion' => $idEvaluacion,
                'calificacion' => $calificacionNueva,
                'fecha' => now()->toDateString()
            ]);

            return [
                'exito' => true,
                'accion' => 'extraordinario',
                'mensaje' => $esAprobatoria ? 'Aprobado en extraordinario (historial guardado)' : 'Reprobó en extraordinario (historial guardado)',
                'datos' => ['alumno' => $idAlumno, 'unidad' => $idUnidad, 'calif' => $calificacionNueva, 'historico' => $calificacionesExistentes->count() + 1]
            ];
        }

        // 🔄 CASO 5: Actualizar ordinario si se vuelve a enviar (solo si no ha pasado a recuperación)
        if ($tipoEvaluacion === 'ordinario' && !$calificacionesExistentes->isEmpty()) {
            // Solo permitir actualizar si solo hay UN registro (no ha pasado a recuperación/extraordinario)
            if ($calificacionesExistentes->count() === 1) {
                $ultimaCalificacion->update([
                    'id_evaluacion' => $idEvaluacion,
                    'calificacion' => $calificacionNueva,
                    'fecha' => now()->toDateString()
                ]);

                return [
                    'exito' => true,
                    'accion' => 'actualizada',
                    'mensaje' => 'Calificación ordinaria actualizada',
                    'datos' => ['alumno' => $idAlumno, 'unidad' => $idUnidad, 'calif' => $calificacionNueva]
                ];
            } else {
                return [
                    'exito' => false,
                    'mensaje' => "No se puede actualizar ordinario, el alumno ya tiene evaluaciones posteriores (recuperación/extraordinario)"
                ];
            }
        }

        return [
            'exito' => false,
            'mensaje' => "Tipo de evaluación '{$tipoEvaluacion}' no reconocido o flujo inválido"
        ];
    }

    /**
     * Procesar Extraordinario Especial (calificación general de la materia)
     */
    private function procesarExtraordinarioEspecial($idAlumno, $idAsignacion, $calificacion)
    {
        // Buscar TODAS las unidades de esta materia
        $asignacion = AsignacionDocente::with('materia')->find($idAsignacion);
        if (!$asignacion || !$asignacion->materia) {
            return ['exito' => false, 'mensaje' => 'Materia no encontrada'];
        }

        $unidades = Unidad::where('id_materia', $asignacion->materia->id_materia)->get();

        if ($unidades->isEmpty()) {
            return ['exito' => false, 'mensaje' => 'No hay unidades para esta materia'];
        }

        // Actualizar TODAS las unidades con la calificación especial
        foreach ($unidades as $unidad) {
            $calificacionExistente = Calificacion::where('id_alumno', $idAlumno)
                ->where('id_asignacion', $idAsignacion)
                ->where('id_unidad', $unidad->id_unidad)
                ->first();

            if ($calificacionExistente) {
                // Actualizar el campo calificacion_especial
                $calificacionExistente->update([
                    'calificacion_especial' => $calificacion,
                    'fecha' => now()->toDateString()
                ]);
            } else {
                // Si no existe, crear registro con calificación especial
                Calificacion::create([
                    'id_alumno' => $idAlumno,
                    'id_asignacion' => $idAsignacion,
                    'id_unidad' => $unidad->id_unidad,
                    'id_evaluacion' => 1, // O el ID por defecto que uses
                    'calificacion' => 0,
                    'calificacion_especial' => $calificacion,
                    'fecha' => now()->toDateString()
                ]);
            }
        }

        return [
            'exito' => true,
            'mensaje' => 'Extraordinario Especial aplicado a todas las unidades',
            'unidades_afectadas' => $unidades->count()
        ];
    }

    /**
     * Construir mensaje de resultado
     */
    private function construirMensajeResultado($estadisticas)
    {
        $partes = [];

        if ($estadisticas['nuevas'] > 0) {
            $partes[] = "✅ {$estadisticas['nuevas']} nueva(s)";
        }
        if ($estadisticas['actualizadas'] > 0) {
            $partes[] = "🔄 {$estadisticas['actualizadas']} actualizada(s)";
        }
        if ($estadisticas['recuperacion'] > 0) {
            $partes[] = "📗 {$estadisticas['recuperacion']} en recuperación";
        }
        if ($estadisticas['extraordinario'] > 0) {
            $partes[] = "📕 {$estadisticas['extraordinario']} en extraordinario";
        }
        if ($estadisticas['extraordinario_especial'] > 0) {
            $partes[] = "🎓 {$estadisticas['extraordinario_especial']} extraordinario especial";
        }

        if (empty($partes)) {
            return "No se realizaron cambios";
        }

        return "Proceso completado: " . implode(", ", $partes);
    }
    /**
     * Obtener matriz completa de calificaciones
     */
    public function obtenerMatrizCompleta(Request $request)
    {
        try {
            $idGrupo = $request->id_grupo;
            $idPeriodo = $request->id_periodo;
            $idAsignacion = $request->id_asignacion;

            // Obtener la materia
            $asignacion = AsignacionDocente::with('materia')->find($idAsignacion);
            if (!$asignacion || !$asignacion->materia) {
                return response()->json(['success' => false, 'message' => 'Materia no encontrada']);
            }

            // Obtener unidades
            $unidades = Unidad::where('id_materia', $asignacion->materia->id_materia)
                ->orderBy('numero_unidad')
                ->get();

            // Función para detectar tipo
            $detectarTipo = function ($nombre) {
                $n = strtolower($nombre ?? '');
                if (str_contains($n, 'especial')) return 'Extraordinario Especial';
                if (str_contains($n, 'extraordinari')) return 'Extraordinario';
                if (str_contains($n, 'recupera')) return 'Recuperación';
                return 'Ordinario';
            };

            // Obtener evaluaciones
            $todasEvaluaciones = Evaluacion::withoutGlobalScopes()->get();
            $evaluaciones = [];
            foreach ($todasEvaluaciones as $eval) {
                $evaluaciones[] = [
                    'id_evaluacion' => $eval->id_evaluacion,
                    'nombre' => $eval->nombre,
                    'tipo' => $detectarTipo($eval->nombre)
                ];
            }

            $evalOrdinario = collect($evaluaciones)->firstWhere('tipo', 'Ordinario');
            $evalRecuperacion = collect($evaluaciones)->firstWhere('tipo', 'Recuperación');
            $evalExtraordinario = collect($evaluaciones)->firstWhere('tipo', 'Extraordinario');
            $evalEspecial = collect($evaluaciones)->firstWhere('tipo', 'Extraordinario Especial');

            // Formatear unidades
            $unidadesFormateadas = $unidades->map(fn($u) => [
                'id_unidad' => $u->id_unidad,
                'nombre' => "Unidad {$u->numero_unidad}: {$u->nombre}",
                'numero_unidad' => $u->numero_unidad
            ]);

            // Buscar alumnos
            $historiales = Historial::with(['alumno.datosPersonales', 'alumno.datosAcademicos'])
                ->whereHas('alumno')
                ->where(function ($query) use ($idAsignacion) {
                    for ($i = 1; $i <= 10; $i++) {
                        $query->orWhere("id_asignacion_$i", $idAsignacion);
                    }
                })
                ->get();

            $alumnos = $historiales
                ->unique('id_alumno')
                ->map(function ($historial) use (
                    $idAsignacion,
                    $unidadesFormateadas,
                    $evalOrdinario,
                    $evalRecuperacion,
                    $evalExtraordinario,
                    $evalEspecial,
                    $detectarTipo
                ) {
                    if (!$historial->alumno) return null;
                    $alumno = $historial->alumno;

                    // 🔑 CORRECCIÓN CLAVE: Buscar calificación especial en la tabla calificaciones 🔑
                    $califEspecialDB = Calificacion::where('id_alumno', $alumno->id_alumno)
                        ->where('id_asignacion', $idAsignacion)
                        ->whereNotNull('calificacion_especial')
                        ->first();

                    $califEspecialHistorial = $califEspecialDB ? (float) $califEspecialDB->calificacion_especial : null;

                    $calificaciones = [];
                    $todasReprobadas = true;
                    $alMenosUnaExtraordinarioReprobada = false;
                    $todasCero = true;
                    $hayAlgunaCalif = false;

                    foreach ($unidadesFormateadas as $unidad) {
                        $califs = Calificacion::with('evaluacion')
                            ->where('id_alumno', $alumno->id_alumno)
                            ->where('id_asignacion', $idAsignacion)
                            ->where('id_unidad', $unidad['id_unidad'])
                            ->get();

                        if ($califs->isNotEmpty()) {
                            // Jerarquía
                            $califExtra = $califs->firstWhere('id_evaluacion', $evalExtraordinario['id_evaluacion'] ?? 0);
                            $califRecup = $califs->firstWhere('id_evaluacion', $evalRecuperacion['id_evaluacion'] ?? 0);
                            $califOrd = $califs->firstWhere('id_evaluacion', $evalOrdinario['id_evaluacion'] ?? 0);

                            $mejorCalif = $califExtra ?? $califRecup ?? $califOrd;
                            $tipoMejor = 'Ordinario';
                            if ($califExtra) $tipoMejor = 'Extraordinario';
                            elseif ($califRecup) $tipoMejor = 'Recuperación';

                            $califValor = $mejorCalif->calificacion;
                            $hayAlgunaCalif = true;

                            if ($califValor != 0) $todasCero = false;
                            if ($califValor >= 6) $todasReprobadas = false;
                            if ($tipoMejor === 'Extraordinario' && $califValor < 6) {
                                $alMenosUnaExtraordinarioReprobada = true;
                            }

                            $key = "{$alumno->id_alumno}_{$unidad['id_unidad']}";
                            $calificaciones[$key] = [
                                'calificacion' => $califValor,
                                'id_evaluacion' => $mejorCalif->id_evaluacion,
                                'tipo_evaluacion' => $tipoMejor,
                                'nombre_evaluacion' => $mejorCalif->evaluacion->nombre ?? $tipoMejor,
                                'historial_completo' => $califs->map(function ($c) use ($detectarTipo) {
                                    return [
                                        'calificacion' => $c->calificacion,
                                        'tipo' => $detectarTipo($c->evaluacion->nombre ?? ''),
                                        'fecha' => $c->created_at,
                                        'id_evaluacion' => $c->id_evaluacion
                                    ];
                                })->toArray(),
                                'siguiente_evaluacion' => null,
                                'puede_capturar' => false
                            ];

                            // Determinar siguiente evaluación
                            if ($califValor < 6) {
                                if ($tipoMejor === 'Ordinario' && $evalRecuperacion) {
                                    $calificaciones[$key]['siguiente_evaluacion'] = $evalRecuperacion;
                                    $calificaciones[$key]['puede_capturar'] = true;
                                } elseif (in_array($tipoMejor, ['Ordinario', 'Recuperación']) && $evalExtraordinario) {
                                    $calificaciones[$key]['siguiente_evaluacion'] = $evalExtraordinario;
                                    $calificaciones[$key]['puede_capturar'] = true;
                                }
                            }
                        } else {
                            // Sin calificación
                            $key = "{$alumno->id_alumno}_{$unidad['id_unidad']}";
                            $calificaciones[$key] = [
                                'calificacion' => null,
                                'siguiente_evaluacion' => $evalOrdinario,
                                'puede_capturar' => true,
                                'tipo_evaluacion' => null,
                                'nombre_evaluacion' => null,
                                'historial_completo' => []
                            ];
                            $todasCero = false; // No hay calif = no todas son cero
                        }
                    }

                    // 🔑 NUEVA LÓGICA PARA HABILITAR EXTRAORDINARIO ESPECIAL 🔑
                    $puedeEspecial = false;
                    if ($califEspecialHistorial === null && $evalEspecial) {
                        if ($alMenosUnaExtraordinarioReprobada) {
                            // Al menos una unidad reprobada en Extraordinario
                            $puedeEspecial = true;
                        } elseif ($hayAlgunaCalif && $todasReprobadas) {
                            // Todas reprobadas
                            $puedeEspecial = true;
                        } elseif ($hayAlgunaCalif && $todasCero) {
                            // Todas las calificaciones son 0
                            $puedeEspecial = true;
                        }
                    }

                    // Promedio
                    // ... código anterior ...

                    // Calcular promedio incluyendo unidades vacías como 0
                    $calificacionesTotales = [];
                    foreach ($unidadesFormateadas as $unidad) {
                        $key = "{$alumno->id_alumno}_{$unidad['id_unidad']}";
                        $valor = 0; // Unidades sin calificación = 0
                        if (isset($calificaciones[$key]) && $calificaciones[$key]['calificacion'] !== null) {
                            $valor = $calificaciones[$key]['calificacion'];
                        }
                        $calificacionesTotales[] = $valor;
                    }

                    $promedio = !empty($calificacionesTotales)
                        ? round(array_sum($calificacionesTotales) / count($calificacionesTotales), 1)
                        : null;

                    return [
                        'id_alumno' => $alumno->id_alumno,
                        'matricula' => $alumno->datosAcademicos->matricula ?? 'N/A',
                        'nombre' => trim(
                            ($alumno->datosPersonales->nombres ?? '') . ' ' .
                                ($alumno->datosPersonales->primer_apellido ?? '') . ' ' .
                                ($alumno->datosPersonales->segundo_apellido ?? '')
                        ),
                        'calificaciones' => $calificaciones,
                        'calificacion_especial' => $califEspecialHistorial,
                        'puede_extraordinario_especial' => $puedeEspecial,
                        'evaluacion_especial' => $evalEspecial,
                        'promedio_general' => $promedio
                    ];
                })
                ->filter()
                ->sortBy('nombre')
                ->values();

            return response()->json([
                'success' => true,
                'alumnos' => $alumnos,
                'unidades' => $unidadesFormateadas
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Guardar calificaciones desde matriz
     */
    public function storeMasivoMatriz(Request $request)
    {

        try {
            $data = json_decode($request->calificaciones_json, true);

            if (!isset($data['id_asignacion'])) {
                return redirect()->back()->withErrors(['error' => 'Datos inválidos: falta id_asignacion']);
            }

            $idAsignacion = $data['id_asignacion'];
            $calificaciones = $data['calificaciones'] ?? [];
            $calificacionesEspeciales = $data['calificaciones_especiales'] ?? [];

            DB::beginTransaction();

            $guardadas = 0;
            $actualizadas = 0;
            $especialesGuardadas = 0;
            $errores = [];

            // ============================================
            // PROCESAR CALIFICACIONES NORMALES (por unidad)
            // ============================================
            foreach ($calificaciones as $cal) {
                try {
                    // Verificar si ya existe esta calificación exacta
                    $calificacionExistente = Calificacion::where('id_alumno', $cal['id_alumno'])
                        ->where('id_asignacion', $idAsignacion)
                        ->where('id_unidad', $cal['id_unidad'])
                        ->where('id_evaluacion', $cal['id_evaluacion'])
                        ->first();
                    date_default_timezone_set('America/Mexico_City');
                    $fecha = date('Y-m-d H:i:s');
                    $dataCalif = [
                        'id_alumno' => $cal['id_alumno'],
                        'id_asignacion' => $idAsignacion,
                        'id_unidad' => $cal['id_unidad'],
                        'id_evaluacion' => $cal['id_evaluacion'],
                        'calificacion' => $cal['calificacion'],
                        'fecha' => $fecha

                    ];

                    if ($calificacionExistente) {
                        $calificacionExistente->update($dataCalif);
                        $actualizadas++;
                    } else {
                        Calificacion::create($dataCalif);
                        $guardadas++;
                    }
                } catch (\Exception $e) {
                    $errores[] = "Error con calificación alumno ID {$cal['id_alumno']}, unidad {$cal['id_unidad']}: {$e->getMessage()}";
                    Log::error('Error guardando calificación', [
                        'alumno' => $cal['id_alumno'],
                        'unidad' => $cal['id_unidad'],
                        'error' => $e->getMessage()
                    ]);
                }
            }

            // ============================================
            // PROCESAR CALIFICACIONES ESPECIALES
            // (Extraordinario Especial - toda la materia)
            // ============================================
            foreach ($calificacionesEspeciales as $especial) {
                try {
                    Log::info('Procesando calificación especial', [
                        'alumno' => $especial['id_alumno'],
                        'calificacion' => $especial['calificacion_especial']
                    ]);

                    // ✅ INSERTAR EN LA TABLA CALIFICACIONES
                    // Con id_unidad y id_evaluacion en NULL porque es para TODA la materia
                    $calificacionEspecialExistente = Calificacion::where('id_alumno', $especial['id_alumno'])
                        ->where('id_asignacion', $idAsignacion)
                        ->whereNull('id_unidad')  // ✅ Sin unidad específica
                        ->whereNull('id_evaluacion')  // ✅ Sin evaluación específica
                        ->first();
                    date_default_timezone_set('America/Mexico_City');
                    $fecha = date('Y-m-d H:i:s');
                    $dataEspecial = [
                        'id_alumno' => $especial['id_alumno'],
                        'id_asignacion' => $idAsignacion,
                        'id_unidad' => null,  // ✅ NULL porque aplica a toda la materia
                        'id_evaluacion' => $especial['id_evaluacion'],
                        'calificacion' => null,  // ✅ NULL porque NO es calificación normal
                        'calificacion_especial' => $especial['calificacion_especial'],  // ✅ La calificación va aquí
                        'fecha' => $fecha

                    ];

                    if ($calificacionEspecialExistente) {
                        $calificacionEspecialExistente->update($dataEspecial);
                        Log::info('Calificación especial actualizada', [
                            'id_calificacion' => $calificacionEspecialExistente->id_calificacion
                        ]);
                    } else {
                        Calificacion::create($dataEspecial);
                        Log::info('Calificación especial creada');
                    }

                    $especialesGuardadas++;
                } catch (\Exception $e) {
                    $errores[] = "Error con calificación especial alumno ID {$especial['id_alumno']}: {$e->getMessage()}";
                    Log::error('Error guardando calificación especial', [
                        'alumno' => $especial['id_alumno'],
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                }
            }


            DB::commit();

            // Construir mensaje de éxito
            $mensajes = [];
            if ($guardadas > 0) {
                $mensajes[] = "✅ {$guardadas} calificación(es) nueva(s)";
            }
            if ($actualizadas > 0) {
                $mensajes[] = "🔄 {$actualizadas} calificación(es) actualizada(s)";
            }
            if ($especialesGuardadas > 0) {
                $mensajes[] = "🎓 {$especialesGuardadas} calificación(es) especial(es) guardada(s)";
            }

            $mensaje = implode(', ', $mensajes);
            if (empty($mensaje)) {
                $mensaje = "No se realizaron cambios";
            }

            if (!empty($errores)) {
                return redirect()->route('calificaciones.index')
                    ->with('warning', $mensaje)
                    ->with('errores', $errores);
            }

            return redirect()->route('calificaciones.index')
                ->with('success', $mensaje);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en storeMasivoMatriz: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withErrors(['error' => 'Error al guardar: ' . $e->getMessage()]);
        }
    }

    public function misAsignaciones()
    {

        // Obtener el ID del docente desde el usuario autenticado
        $idDocente = auth()->user()->docente->id_docente;

        if (!$idDocente) {
            return view('docente.asignaciones', ['asignaciones' => collect()])
                ->with('mensaje', 'No tienes un ID de docente asignado.');
        }

        // Cargar asignaciones con relaciones
        $asignaciones = AsignacionDocente::with([
            'materia',
            'grupo.periodoEscolar' // ← Usa el nombre EXACTO del método
        ])
            ->where('id_docente', $idDocente)
            ->get()
            ->map(function ($asignacion) {
                return [
                    'id_asignacion' => $asignacion->id_asignacion,
                    'materia' => $asignacion->materia?->nombre ?? 'Sin materia',
                    'grupo' => $asignacion->grupo?->nombre ?? 'Sin grupo',
                    'periodo' => $asignacion->grupo?->periodoEscolar?->nombre ?? 'Sin período',
                    'id_grupo' => $asignacion->id_grupo,
                    'id_periodo' => $asignacion->grupo?->periodoEscolar?->id_periodo_escolar
                ];
            });
        return view('docente.asignaciones', compact('asignaciones'));
    }

    public function guardarCalificaciones(Request $request)
    {
        date_default_timezone_set('America/Mexico_City');
        $fecha = date('Y-m-d H:i:s');
        try {
            $data = json_decode($request->calificaciones_json, true);
            $idAsignacion = $data['id_asignacion'];

            // 1. Guardar calificaciones normales (por unidad)
            if (!empty($data['calificaciones'])) {
                foreach ($data['calificaciones'] as $calif) {
                    // Solo guardar si tiene id_unidad (calificaciones normales)
                    if (!empty($calif['id_unidad'])) {
                        Calificacion::updateOrCreate(
                            [
                                'id_alumno' => $calif['id_alumno'],
                                'id_asignacion' => $idAsignacion,
                                'id_unidad' => $calif['id_unidad'],
                                'id_evaluacion' => $calif['id_evaluacion']
                            ],
                            [
                                'calificacion' => $calif['calificacion'],
                                'calificacion_especial' => null, // ← Asegurar que sea null
                                'fecha' => $fecha
                            ]
                        );
                    }
                }
            }

            // 2. Guardar calificaciones especiales (SIN id_unidad)
            if (!empty($data['calificaciones_especiales'])) {
                foreach ($data['calificaciones_especiales'] as $califEsp) {
                    // Buscar registro ESPECIAL existente (sin id_unidad)
                    $califEspecial = Calificacion::where('id_alumno', $califEsp['id_alumno'])
                        ->where('id_asignacion', $idAsignacion)
                        ->whereNull('id_unidad') // ← Clave: sin unidad
                        ->first();

                    if ($califEspecial) {
                        $califEspecial->calificacion_especial = $califEsp['calificacion_especial'];
                        $califEspecial->id_evaluacion = $califEsp['id_evaluacion'];
                        $califEspecial->calificacion = null; // ← Asegurar que sea null
                        $califEspecial->save();
                    } else {
                        Calificacion::create([
                            'id_alumno' => $califEsp['id_alumno'],
                            'id_asignacion' => $idAsignacion,
                            'id_evaluacion' => $califEsp['id_evaluacion'],
                            'calificacion_especial' => $califEsp['calificacion_especial'],
                            'calificacion' => null, // ← Clave: null para calif normal
                            'id_unidad' => null,    // ← Clave: sin unidad
                            'fecha' => $fecha
                        ]);
                    }
                }
            }

            return redirect()->back()->with('success', 'Calificaciones guardadas correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al guardar calificaciones:', [
                'error' => $e->getMessage(),
                'data' => $request->all()
            ]);
            return redirect()->back()->with('error', 'Error al guardar: ' . $e->getMessage());
        }
    }
}
