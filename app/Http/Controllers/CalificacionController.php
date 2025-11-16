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
        Log::info('JSON recibido:', ['json' => $jsonData]);

        $data = json_decode($jsonData, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('Error al decodificar JSON:', ['error' => json_last_error_msg()]);
            return redirect()->back()->withErrors(['error' => 'Error al procesar los datos: ' . json_last_error_msg()]);
        }

        Log::info('Datos decodificados:', $data);
        
        // VALIDACIÓN MÁS ESTRICTA
        if (!isset($data['id_asignacion']) || empty($data['id_asignacion'])) {
            Log::error('id_asignacion no está presente o está vacío', ['data' => $data]);
            return redirect()->back()->withErrors(['error' => 'Falta el ID de asignación']);
        }

        if (!isset($data['calificaciones']) || !is_array($data['calificaciones']) || count($data['calificaciones']) === 0) {
            Log::error('calificaciones no está presente, no es array o está vacío', ['data' => $data]);
            return redirect()->back()->withErrors(['error' => 'No hay calificaciones para guardar']);
        }

        $calificaciones = $data['calificaciones'];
        $idAsignacion = $data['id_asignacion'];

        Log::info('Procesando calificaciones', [
            'total_calificaciones' => count($calificaciones),
            'id_asignacion' => $idAsignacion
        ]);

        DB::beginTransaction();

        $guardadas = 0;
        $actualizadas = 0;
        $errores = [];

        foreach ($calificaciones as $index => $cal) {
            try {
                Log::info("Procesando calificación {$index}:", $cal);

                // Validar datos requeridos de manera más específica
                $camposRequeridos = ['id_alumno', 'id_unidad', 'id_evaluacion', 'calificacion'];
                $camposFaltantes = [];
                
                foreach ($camposRequeridos as $campo) {
                    if (!isset($cal[$campo]) || $cal[$campo] === '') {
                        $camposFaltantes[] = $campo;
                    }
                }

                if (!empty($camposFaltantes)) {
                    $errores[] = "Datos incompletos en calificación {$index}: faltan " . implode(', ', $camposFaltantes);
                    Log::warning('Datos incompletos:', ['calificacion' => $cal, 'faltantes' => $camposFaltantes]);
                    continue;
                }

                // Validar tipos de datos
                $id_alumno = intval($cal['id_alumno']);
                $id_unidad = intval($cal['id_unidad']);
                $id_evaluacion = intval($cal['id_evaluacion']);
                $calificacion_valor = floatval($cal['calificacion']);

                // Validar rango de calificación
                if ($calificacion_valor < 0 || $calificacion_valor > 10) {
                    $errores[] = "Calificación {$calificacion_valor} fuera de rango (0-10) para alumno ID {$id_alumno}";
                    continue;
                }

                // VERIFICAR SI LA CALIFICACIÓN YA EXISTE
                $calificacionExistente = Calificacion::where('id_alumno', $id_alumno)
                    ->where('id_asignacion', $idAsignacion)
                    ->where('id_unidad', $id_unidad)
                    ->where('id_evaluacion', $id_evaluacion)
                    ->first();

                $dataCalificacion = [
                    'id_alumno' => $id_alumno,
                    'id_asignacion' => $idAsignacion,
                    'id_unidad' => $id_unidad,
                    'id_evaluacion' => $id_evaluacion,
                    'calificacion' => $calificacion_valor,
                    'fecha' => now()->toDateString()
                ];

                Log::info('Datos a guardar/actualizar:', $dataCalificacion);

                if ($calificacionExistente) {
                    // ACTUALIZAR EXISTENTE
                    $calificacionExistente->update($dataCalificacion);
                    $actualizadas++;
                    Log::info("✅ Calificación actualizada", [
                        'id_calificacion' => $calificacionExistente->id_calificacion,
                        'alumno' => $id_alumno
                    ]);
                } else {
                    // CREAR NUEVA
                    $nuevaCalif = Calificacion::create($dataCalificacion);
                    $guardadas++;
                    Log::info("✅ Calificación creada", [
                        'id_calificacion' => $nuevaCalif->id_calificacion,
                        'alumno' => $id_alumno
                    ]);
                }

            } catch (\Exception $e) {
                $errores[] = "Error en calificación {$index} (Alumno ID {$cal['id_alumno']}): {$e->getMessage()}";
                Log::error("❌ Error guardando calificación", [
                    'index' => $index,
                    'alumno' => $cal['id_alumno'] ?? 'desconocido',
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }

        DB::commit();

        // CONSTRUIR MENSAJE DE RESULTADO
        $mensaje = "Proceso completado: ";
        $partes = [];
        if ($guardadas > 0) {
            $partes[] = "{$guardadas} nueva(s)";
        }
        if ($actualizadas > 0) {
            $partes[] = "{$actualizadas} actualizada(s)";
        }
        if (empty($partes)) {
            $mensaje = "No se realizaron cambios";
        } else {
            $mensaje .= implode(" y ", $partes);
        }

        Log::info('=== Proceso completado ===', [
            'guardadas' => $guardadas,
            'actualizadas' => $actualizadas,
            'errores' => count($errores)
        ]);

        $response = redirect()->route('calificaciones.index')->with('success', $mensaje);

        if (count($errores) > 0) {
            Log::warning('Errores encontrados:', $errores);
            $response->with('warning', 'Algunos registros tuvieron errores')
                    ->with('errores_detalle', $errores);
        }

        return $response;

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('❌ Error crítico en storeMasivo', [
            'error' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return redirect()->back()
            ->withErrors(['error' => 'Error al guardar las calificaciones: ' . $e->getMessage()])
            ->withInput();
    }
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

        // Obtener TODAS las evaluaciones disponibles
        $todasLasEvaluaciones = Evaluacion::withoutGlobalScopes()
            ->orderBy('id_evaluacion')
            ->get()
            ->map(function($eval) {
                return [
                    'id_evaluacion' => $eval->id_evaluacion,
                    'nombre' => $eval->nombre,
                    'porcentaje' => $eval->porcentaje,
                    'tipo' => $eval->tipo ?? null
                ];
            });

        Log::info('Evaluaciones disponibles', ['total' => $todasLasEvaluaciones->count()]);

        // Formatear unidades con las evaluaciones disponibles
        $unidadesFormateadas = $unidades->map(function($unidad) use ($todasLasEvaluaciones) {
            return [
                'id_unidad' => $unidad->id_unidad,
                'nombre' => "Unidad {$unidad->numero_unidad}: {$unidad->nombre}",
                'numero_unidad' => $unidad->numero_unidad,
                'evaluaciones_disponibles' => $todasLasEvaluaciones->toArray()
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
            ->map(function($historial) use ($idAsignacion, $unidadesFormateadas) {
                if (!$historial->alumno) return null;
                
                $alumno = $historial->alumno;
                
                // Obtener calificaciones existentes
                $calificacionesExistentes = [];
                
                foreach ($unidadesFormateadas as $unidad) {
                    // Buscar si ya tiene calificación en esta unidad
                    $calif = Calificacion::where('id_alumno', $alumno->id_alumno)
                        ->where('id_asignacion', $idAsignacion)
                        ->where('id_unidad', $unidad['id_unidad'])
                        ->first();
                    
                    if ($calif) {
                        $key = "{$alumno->id_alumno}_{$unidad['id_unidad']}";
                        $calificacionesExistentes[$key] = [
                            'calificacion' => $calif->calificacion,
                            'id_evaluacion' => $calif->id_evaluacion
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
                    'calificaciones' => $calificacionesExistentes
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
            'line' => $e->getLine()
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
        
        if (!isset($data['id_asignacion']) || !isset($data['calificaciones'])) {
            return redirect()->back()->withErrors(['error' => 'Datos inválidos']);
        }

        $idAsignacion = $data['id_asignacion'];
        $calificaciones = $data['calificaciones'];

        DB::beginTransaction();

        $guardadas = 0;
        $actualizadas = 0;
        $errores = [];

        foreach ($calificaciones as $cal) {
            try {
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
                $errores[] = "Error con alumno ID {$cal['id_alumno']}: {$e->getMessage()}";
            }
        }

        DB::commit();

        $mensaje = "✅ $guardadas nueva(s), $actualizadas actualizada(s)";

        return redirect()->route('calificaciones.index')
            ->with('success', $mensaje)
            ->with('errores', $errores);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error en storeMasivoMatriz: ' . $e->getMessage());
        
        return redirect()->back()
            ->withErrors(['error' => 'Error: ' . $e->getMessage()]);
    }
}
}