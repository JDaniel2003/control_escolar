<?php

namespace App\Http\Controllers;

use App\Models\AsignacionDocente;
use App\Models\Usuario;
use App\Models\Docente;
use App\Models\Materia;
use App\Models\Grupo;
use App\Models\Carrera;
use App\Models\PeriodoEscolar;
use App\Models\NumeroPeriodo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AsignacionDocenteController extends Controller
{
    public function index(Request $request)
    {
        // Cargar relaciones corregidas
        $query = AsignacionDocente::with([
            'docente.datosDocentes',
            'docente.usuario',
            'materia',
            'grupo',
            'periodoEscolar'
        ]);

        // Filtro por docente
        if ($request->filled('buscar')) { 
    $busqueda = $request->buscar;

    $query->whereHas('docente.datosDocentes', function ($q) use ($busqueda) {
        $q->where('nombre', 'LIKE', '%' . $busqueda . '%')
          ->orWhere('apellido_paterno', 'LIKE', '%' . $busqueda . '%')
          ->orWhere('apellido_materno', 'LIKE', '%' . $busqueda . '%')
          ->orWhereHas('abreviatura', function ($qa) use ($busqueda) {
              $qa->where('nombre', 'LIKE', '%' . $busqueda . '%')
                 ->orWhere('abreviatura', 'LIKE', '%' . $busqueda . '%');
          });
    });
}


        if ($request->filled('buscar_materia')) {
            $busquedaMateria = $request->buscar_materia;
            
            $query->whereHas('materia', function ($q) use ($busquedaMateria) {
                $q->where('nombre', 'LIKE', '%' . $busquedaMateria . '%')
                  ->orWhere('clave', 'LIKE', '%' . $busquedaMateria . '%');
            });
        }

        if ($request->filled('buscar_grupo')) {
            $busquedaGrupo = $request->buscar_grupo;
            
            $query->whereHas('grupo', function ($q) use ($busquedaGrupo) {
                $q->where('nombre', 'LIKE', '%' . $busquedaGrupo . '%');
            });
        }

        // Filtro por período escolar
        if ($request->filled('buscar_periodo')) {
            $busquedaPeriodo = $request->buscar_periodo;
            
            $query->whereHas('periodoEscolar', function ($q) use ($busquedaPeriodo) {
                $q->where('nombre', 'LIKE', '%' . $busquedaPeriodo . '%');
            });
        }

        // Paginación
        $mostrar = $request->get('mostrar', 10);
        if ($mostrar == 'todo') {
            $asignaciones = $query->orderBy('id_asignacion', 'desc')->get();
        } else {
            $asignaciones = $query->orderBy('id_asignacion', 'desc')->paginate($mostrar);
        }

        // Obtener datos para los filtros
        $docentes = Docente::with(['usuario', 'datosDocentes'])
            ->get()
            ->map(function ($docente) {
                return (object)[
                    'id_docente' => $docente->id_docente,
                    'id_usuario' => $docente->id_usuario,
                    'username' => $docente->usuario->username ?? 'N/A',
                    'nombre_completo' => $docente->nombre_completo
                ];
            });

        $materias = Materia::all();
        $grupos = Grupo::whereIn('periodo', PeriodoEscolar::where('estado', 'Abierto')->pluck('id_periodo_escolar'))->get();
        $periodos = PeriodoEscolar::where('estado', 'Abierto')->get();
        $carreras = Carrera::all();
        $numeroPeriodos = NumeroPeriodo::with('tipoPeriodo')->get();

        return view('asignaciones.asignaciones', compact(
            'asignaciones',
            'docentes',
            'materias',
            'grupos',
            'periodos',
            'carreras',
            'numeroPeriodos'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_docente' => 'required|exists:docentes,id_docente',
            'id_materia' => 'required|exists:materias,id_materia',
            'id_grupo' => 'required|exists:grupos,id_grupo',
            'id_periodo_escolar' => 'required|exists:periodos_escolares,id_periodo_escolar',
        ], [
            'id_docente.required' => 'El docente es obligatorio',
            'id_docente.exists' => 'El docente seleccionado no existe',
            'id_materia.required' => 'La materia es obligatoria',
            'id_grupo.required' => 'El grupo es obligatorio',
            'id_periodo_escolar.required' => 'El período escolar es obligatorio',
        ]);

        // Verificar que no exista la misma asignación
        $existe = AsignacionDocente::where('id_materia', $request->id_materia)
            ->where('id_grupo', $request->id_grupo)
            ->where('id_periodo_escolar', $request->id_periodo_escolar)
            ->exists();

        if ($existe) {
    return redirect()->route('asignaciones.index')
        ->withErrors(['error' => 'Asignacion ya existente.'])
        ->withInput()
        ->with('is_create_asignacion', 1); // 👈 Flag para modal de CREAR SIMPLE
}

        try {
            AsignacionDocente::create([
                'id_docente' => $request->id_docente,
                'id_materia' => $request->id_materia,
                'id_grupo' => $request->id_grupo,
                'id_periodo_escolar' => $request->id_periodo_escolar
            ]);

            return redirect()->route('asignaciones.index')->with('success', 'Asignación creada exitosamente');
        } catch (\Exception $e) {
            Log::error('Error al crear asignación:', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Error al crear la asignación: ' . $e->getMessage()])->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $asignacion = AsignacionDocente::findOrFail($id);

        $request->validate([
            'id_docente' => 'required|exists:docentes,id_docente',
            'id_materia' => 'required|exists:materias,id_materia',
            'id_grupo' => 'required|exists:grupos,id_grupo',
            'id_periodo_escolar' => 'required|exists:periodos_escolares,id_periodo_escolar',
        ], [
            'id_docente.required' => 'El docente es obligatorio',
            'id_materia.required' => 'La materia es obligatoria',
            'id_grupo.required' => 'El grupo es obligatorio',
            'id_periodo_escolar.required' => 'El período escolar es obligatorio',
        ]);

        // Verificar que no exista la misma asignación (excluyendo la actual)
        $existe = AsignacionDocente::where('id_materia', $request->id_materia)
            ->where('id_grupo', $request->id_grupo)
            ->where('id_periodo_escolar', $request->id_periodo_escolar)
            ->where('id_asignacion', '!=', $id)
            ->exists();

       if ($existe) {
    return redirect()->route('asignaciones.index')
        ->withErrors(['error' => 'Ya existe una asignación con esa materia, grupo y período.'])
        ->withInput()
        ->with('asignacion_edit_id', $id);
}

        try {
            $asignacion->update([
                'id_docente' => $request->id_docente,
                'id_materia' => $request->id_materia,
                'id_grupo' => $request->id_grupo,
                'id_periodo_escolar' => $request->id_periodo_escolar
            ]);

            return redirect()->route('asignaciones.index')->with('success', 'Asignación actualizada exitosamente');
        } catch (\Exception $e) {
            Log::error('Error al actualizar asignación:', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Error al actualizar la asignación: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $asignacion = AsignacionDocente::findOrFail($id);
            $asignacion->delete();

            return redirect()->route('asignaciones.index')->with('success', 'Asignación eliminada exitosamente');
        } catch (\Exception $e) {
            Log::error('Error al eliminar asignación:', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Error al eliminar la asignación: ' . $e->getMessage()]);
        }
    }

    // MÉTODO CORREGIDO: Asignación masiva de materias con docentes
    public function storeMasivoMaterias(Request $request)
{
    // Validación inicial
    $request->validate([
        'id_grupo' => 'required|exists:grupos,id_grupo',
        'id_periodo_escolar' => 'required|exists:periodos_escolares,id_periodo_escolar',
        'materias' => 'required|array|min:1',
        'materias.*' => 'exists:materias,id_materia',
        'docentes' => 'array',
    ], [
        'materias.required' => 'Debe seleccionar al menos una materia',
        'materias.min' => 'Debe seleccionar al menos una materia',
    ]);

    $materiasSeleccionadas = $request->input('materias', []);
    $docentesAsignados = $request->input('docentes', []);

    $errores = [];
    $asignacionesCreadas = 0;
    $asignacionesSinDocente = 0;

    DB::beginTransaction();

    try {
        foreach ($materiasSeleccionadas as $idMateria) {
            // Verificar si ya existe
            $existe = AsignacionDocente::where('id_materia', $idMateria)
                ->where('id_grupo', $request->id_grupo)
                ->where('id_periodo_escolar', $request->id_periodo_escolar)
                ->exists();

            if ($existe) {
                $materia = Materia::find($idMateria);
                $errores[] = "La materia '{$materia->nombre}' ya tiene asignacion.";
                continue;
            }

            // Validar docente si se proporcionó
            $idDocente = $docentesAsignados[$idMateria] ?? null;
            if ($idDocente !== null && $idDocente > 0) {
                if (!Docente::where('id_docente', $idDocente)->exists()) {
                    $materia = Materia::find($idMateria);
                    $errores[] = "El docente seleccionado para la materia '{$materia->nombre}' no existe.";
                    continue;
                }
            }

            // Crear asignación
            AsignacionDocente::create([
                'id_docente' => $idDocente,
                'id_materia' => $idMateria,
                'id_grupo' => $request->id_grupo,
                'id_periodo_escolar' => $request->id_periodo_escolar,
            ]);

            $asignacionesCreadas++;
            if ($idDocente === null) {
                $asignacionesSinDocente++;
            }
        }

        DB::commit();

        // Caso 1: Todas fallaron → Reabrir modal con errores
        if ($asignacionesCreadas === 0) {
            return redirect()->back()
                ->withErrors($errores)
                ->withInput()
                ->with('is_create_masiva', 1);
        }

        // Caso 2: Al menos una se creó → Mensaje de éxito en vista principal
        $mensaje = "Se crearon $asignacionesCreadas asignaciones exitosamente";
        if ($asignacionesSinDocente > 0) {
            $mensaje .= ". $asignacionesSinDocente materias quedaron sin docente.";
        }

        // Si hay errores, también los mostramos en la vista principal
        if (!empty($errores)) {
            $mensaje .= ". Errores: " . implode('. ', $errores);
        }

        return redirect()->route('asignaciones.index')
            ->with('success', $mensaje);

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()
            ->withErrors(['Error inesperado: ' . $e->getMessage()])
            ->withInput()
            ->with('is_create_masiva', 1);
    }
}

    // Método para obtener materias por carrera y número de período
    public function materiasPorCarreraYPeriodo($carreraId, $idNumeroPeriodo)
    {
        try {
            Log::info("Buscando materias para carrera: $carreraId, período: $idNumeroPeriodo");

            $materias = Materia::whereHas('planEstudio', function ($query) use ($carreraId) {
                $query->where('id_carrera', $carreraId);
            })
                ->where('id_numero_periodo', $idNumeroPeriodo)
                ->with(['planEstudio', 'numeroPeriodo'])
                ->get();

            Log::info("Materias encontradas: " . $materias->count());

            return response()->json($materias);
        } catch (\Exception $e) {
            Log::error("Error al cargar materias: " . $e->getMessage());
            return response()->json([], 500);
        }
    }

    // Obtener docentes para select
    public function getDocentes()
    {
        try {
            $docentes = Docente::with(['usuario', 'datosDocentes'])
                ->get()
                ->map(function ($docente) {
                    return [
                        'id_docente' => $docente->id_docente,
                        'nombre_completo' => $docente->datos ?
                            ($docente->datos->nombre . ' ' .
                                $docente->datos->apellido_paterno . ' ' .
                                ($docente->datos->apellido_materno ?? '')) : ($docente->usuario->username ?? 'N/A')
                    ];
                });

            return response()->json($docentes);
        } catch (\Exception $e) {
            Log::error('Error al obtener docentes:', ['error' => $e->getMessage()]);
            return response()->json([], 500);
        }
    }

    public function getDocentesPorCarrera($carreraId)
{
    try {
        $docentes = Docente::whereHas('usuario.administracionCarreras', function ($query) use ($carreraId) {
            $query->where('id_carrera', $carreraId);
        })
        ->with(['usuario', 'datosDocentes'])
        ->get()
        ->map(function ($docente) {
            return [
                'id_docente' => $docente->id_docente,
                'nombre_completo' => $docente->nombre_completo,
            ];
        });

        return response()->json($docentes);
    } catch (\Exception $e) {
        Log::error('Error al obtener docentes por carrera:', ['error' => $e->getMessage()]);
        return response()->json([], 500);
    }
}
}