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
                ->map(function($asignacion) {
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
                ->map(function($unidad) {
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
                ->map(function($evaluacion) {
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
                ->where(function($query) use ($idAsignacion) {
                    // Buscar en cualquiera de las 10 columnas de asignaciones
                    for ($i = 1; $i <= 10; $i++) {
                        $query->orWhere("id_asignacion_$i", $idAsignacion);
                    }
                })
                ->get()
                ->unique('id_alumno')
                ->map(function($historial) use ($idAsignacion, $idUnidad, $idEvaluacion) {
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

        if (!isset($data['id_asignacion']) || !isset($data['calificaciones']) || 
            !is_array($data['calificaciones']) || count($data['calificaciones']) === 0) {
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
                if (!isset($cal['id_alumno']) || !isset($cal['id_unidad']) || 
                    !isset($cal['id_evaluacion']) || !isset($cal['calificacion'])) {
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

        Log::info('=== INICIANDO CARGA DE MATRIZ ===', [
            'grupo' => $idGrupo,
            'periodo' => $idPeriodo,
            'asignacion' => $idAsignacion
        ]);

        // Obtener la materia
        $asignacion = AsignacionDocente::with('materia')->find($idAsignacion);
        if (!$asignacion || !$asignacion->materia) {
            return response()->json(['success' => false, 'message' => 'Materia no encontrada']);
        }

        // Obtener unidades de la materia
        $unidades = Unidad::where('id_materia', $asignacion->materia->id_materia)
            ->orderBy('numero_unidad')
            ->get();

        Log::info('Unidades encontradas', ['total' => $unidades->count()]);

        // Función helper para detectar tipo de evaluación por nombre
        $detectarTipo = function($nombre) {
            $nombreLower = strtolower($nombre ?? '');
            
            if (str_contains($nombreLower, 'especial')) {
                return 'Extraordinario Especial';
            } elseif (str_contains($nombreLower, 'extraordinari')) {
                return 'Extraordinario';
            } elseif (str_contains($nombreLower, 'recupera') || str_contains($nombreLower, 'recuperación')) {
                return 'Recuperación';
            }
            
            return 'Ordinario';
        };

        // Obtener evaluaciones por tipo (sin Extraordinario Especial)
        $todasLasEvaluaciones = Evaluacion::withoutGlobalScopes()
            ->orderBy('id_evaluacion')
            ->get()
            ->map(function($eval) use ($detectarTipo) {
                return [
                    'id_evaluacion' => $eval->id_evaluacion,
                    'nombre' => $eval->nombre,
                    'porcentaje' => $eval->porcentaje ?? 0,
                    'tipo' => $detectarTipo($eval->nombre)
                ];
            });

        // Separar evaluaciones por tipo
        $evaluacionesOrdinario = $todasLasEvaluaciones->where('tipo', 'Ordinario')->values();
        $evaluacionesRecuperacion = $todasLasEvaluaciones->where('tipo', 'Recuperación')->values();
        $evaluacionesExtraordinario = $todasLasEvaluaciones->where('tipo', 'Extraordinario')->values();
        $evaluacionEspecial = $todasLasEvaluaciones->firstWhere('tipo', 'Extraordinario Especial');

        Log::info('Evaluaciones por tipo', [
            'ordinario' => $evaluacionesOrdinario->count(),
            'recuperacion' => $evaluacionesRecuperacion->count(),
            'extraordinario' => $evaluacionesExtraordinario->count(),
            'especial' => $evaluacionEspecial ? 'Disponible' : 'No disponible'
        ]);

        // Formatear unidades (sin incluir evaluaciones, se asignan automáticamente)
        $unidadesFormateadas = $unidades->map(function($unidad) {
            return [
                'id_unidad' => $unidad->id_unidad,
                'nombre' => "Unidad {$unidad->numero_unidad}: {$unidad->nombre}",
                'numero_unidad' => $unidad->numero_unidad
            ];
        });

        // Buscar alumnos
        $historiales = Historial::with(['alumno.datosPersonales', 'alumno.datosAcademicos'])
            ->whereHas('alumno')
            ->where(function($query) use ($idAsignacion) {
                for ($i = 1; $i <= 10; $i++) {
                    $query->orWhere("id_asignacion_$i", $idAsignacion);
                }
            })
            ->get();

        Log::info('Historiales encontrados', ['total' => $historiales->count()]);

        $alumnos = $historiales
            ->unique('id_alumno')
            ->map(function($historial) use (
                $idAsignacion, 
                $unidadesFormateadas, 
                $todasLasEvaluaciones, 
                $detectarTipo,
                $evaluacionesOrdinario,
                $evaluacionesRecuperacion,
                $evaluacionesExtraordinario,
                $evaluacionEspecial
            ) {
                if (!$historial->alumno) return null;
                
                $alumno = $historial->alumno;
                
                // Verificar si tiene calificación especial (Extraordinario Especial de toda la materia)
                $calificacionEspecial = $historial->calificacion_especial;
                $tieneEspecial = !is_null($calificacionEspecial);
                
                // Obtener calificaciones existentes por unidad
                $calificacionesExistentes = [];
                $todasUnidadesReprobadas = true; // Para determinar si aplica Extraordinario Especial
                
                foreach ($unidadesFormateadas as $unidad) {
                    // Buscar TODAS las calificaciones de esta unidad
                    $calificaciones = Calificacion::with('evaluacion')
                        ->where('id_alumno', $alumno->id_alumno)
                        ->where('id_asignacion', $idAsignacion)
                        ->where('id_unidad', $unidad['id_unidad'])
                        ->orderBy('id_calificacion', 'desc')
                        ->get();
                    
                    if ($calificaciones->isNotEmpty()) {
                        // Construir historial completo
                        $historialCompleto = $calificaciones->map(function($c) use ($detectarTipo) {
                            $tipoEval = $detectarTipo($c->evaluacion->nombre ?? '');
                            return [
                                'calificacion' => $c->calificacion,
                                'tipo' => $tipoEval,
                                'fecha' => $c->created_at,
                                'id_evaluacion' => $c->id_evaluacion
                            ];
                        })->toArray();
                        
                        // Jerarquía para seleccionar calificación vigente
                        $jerarquia = [
                            'Extraordinario' => 3,
                            'Recuperación' => 2,
                            'Ordinario' => 1
                        ];
                        
                        $calificacionVigente = $calificaciones->sortByDesc(function($calif) use ($jerarquia, $detectarTipo) {
                            $tipoEval = $detectarTipo($calif->evaluacion->nombre ?? '');
                            $prioridad = $jerarquia[$tipoEval] ?? 0;
                            return ($prioridad * 100000) + $calif->id_calificacion;
                        })->first();
                        
                        $tipoVigente = $detectarTipo($calificacionVigente->evaluacion->nombre ?? '');
                        $nombreVigente = $calificacionVigente->evaluacion->nombre ?? 'Evaluación';
                        
                        // Determinar siguiente evaluación disponible según jerarquía
                        $siguienteEvaluacion = null;
                        $tiposSinCapturar = [];
                        
                        $tiposCapturados = collect($historialCompleto)->pluck('tipo')->unique()->toArray();
                        
                        if (!in_array('Ordinario', $tiposCapturados)) {
                            $tiposSinCapturar[] = 'Ordinario';
                        }
                        if (!in_array('Recuperación', $tiposCapturados) && $calificacionVigente->calificacion < 6) {
                            $tiposSinCapturar[] = 'Recuperación';
                        }
                        if (!in_array('Extraordinario', $tiposCapturados) && $calificacionVigente->calificacion < 6) {
                            $tiposSinCapturar[] = 'Extraordinario';
                        }
                        
                        // Determinar próxima evaluación según jerarquía
                        if (in_array('Ordinario', $tiposSinCapturar)) {
                            $siguienteEvaluacion = $evaluacionesOrdinario->first();
                        } elseif ($calificacionVigente->calificacion < 6) {
                            if (in_array('Recuperación', $tiposSinCapturar)) {
                                $siguienteEvaluacion = $evaluacionesRecuperacion->first();
                            } elseif (in_array('Extraordinario', $tiposSinCapturar)) {
                                $siguienteEvaluacion = $evaluacionesExtraordinario->first();
                            }
                        }
                        
                        // Si aprobó, no hay más evaluaciones
                        if ($calificacionVigente->calificacion >= 6) {
                            $todasUnidadesReprobadas = false;
                        }
                        
                        $key = "{$alumno->id_alumno}_{$unidad['id_unidad']}";
                        $calificacionesExistentes[$key] = [
                            'calificacion' => $calificacionVigente->calificacion,
                            'id_evaluacion' => $calificacionVigente->id_evaluacion,
                            'tipo_evaluacion' => $tipoVigente,
                            'nombre_evaluacion' => $nombreVigente,
                            'historial_completo' => $historialCompleto,
                            'siguiente_evaluacion' => $siguienteEvaluacion,
                            'puede_capturar' => !is_null($siguienteEvaluacion)
                        ];
                    } else {
                        // No tiene calificación, debe empezar con Ordinario
                        $key = "{$alumno->id_alumno}_{$unidad['id_unidad']}";
                        $calificacionesExistentes[$key] = [
                            'calificacion' => null,
                            'siguiente_evaluacion' => $evaluacionesOrdinario->first(),
                            'puede_capturar' => true
                        ];
                    }
                }
                
                return [
                    'id_alumno' => $alumno->id_alumno,
                    'matricula' => $alumno->datosAcademicos->matricula ?? 'N/A',
                    'nombre' => trim(
                        ($alumno->datosPersonales->nombres ?? '') . ' ' .
                        ($alumno->datosPersonales->primer_apellido ?? '') . ' ' .
                        ($alumno->datosPersonales->segundo_apellido ?? '')
                    ),
                    'calificaciones' => $calificacionesExistentes,
                    'calificacion_especial' => $calificacionEspecial,
                    'puede_extraordinario_especial' => $todasUnidadesReprobadas && !$tieneEspecial && $evaluacionEspecial,
                    'evaluacion_especial' => $evaluacionEspecial
                ];
            })
            ->filter()
            ->sortBy('nombre')
            ->values();

        Log::info('Resultado final', [
            'total_alumnos' => $alumnos->count(),
            'total_unidades' => $unidadesFormateadas->count()
        ]);

        return response()->json([
            'success' => true,
            'alumnos' => $alumnos,
            'unidades' => $unidadesFormateadas
        ]);

    } catch (\Exception $e) {
        Log::error('Error en obtenerMatrizCompleta', [
            'error' => $e->getMessage(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ]);
        
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

                $dataCalif = [
                    'id_alumno' => $cal['id_alumno'],
                    'id_asignacion' => $idAsignacion,
                    'id_unidad' => $cal['id_unidad'],
                    'id_evaluacion' => $cal['id_evaluacion'],
                    'calificacion' => $cal['calificacion'],
                    'fecha' => now()
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
                // Buscar el historial del alumno en esta asignación
                $historial = Historial::where('id_alumno', $especial['id_alumno'])
                    ->where(function($query) use ($idAsignacion) {
                        for ($i = 1; $i <= 10; $i++) {
                            $query->orWhere("id_asignacion_$i", $idAsignacion);
                        }
                    })
                    ->first();

                if (!$historial) {
                    $errores[] = "No se encontró historial para alumno ID {$especial['id_alumno']}";
                    continue;
                }

                // Actualizar calificación especial y estatus
                $historial->update([
                    'calificacion_especial' => $especial['calificacion_especial'],
                    'id_evaluacion' => $especial['calificacion_especial'] >= 6 
                        ? 'Aprobado con Extraordinario Especial' 
                        : 'Reprobado en Extraordinario Especial'
                ]);

                $especialesGuardadas++;

                Log::info('Calificación Especial guardada', [
                    'alumno' => $especial['id_alumno'],
                    'calificacion' => $especial['calificacion_especial'],
                    'id_evaluacion' => $especial['id_evaluacion'],
                ]);

            } catch (\Exception $e) {
                $errores[] = "Error con calificación especial alumno ID {$especial['id_alumno']}: {$e->getMessage()}";
                Log::error('Error guardando calificación especial', [
                    'alumno' => $especial['id_alumno'],
                    'error' => $e->getMessage()
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
}