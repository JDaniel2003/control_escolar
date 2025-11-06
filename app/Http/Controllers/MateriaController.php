<?php

namespace App\Http\Controllers;

use App\Models\Competencia;
use App\Models\EspacioFormativo;
use App\Models\Materia;
use App\Models\Modalidad;
use App\Models\PlanEstudio;
use App\Models\NumeroPeriodo;
use App\Models\Unidad;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    // Agregar nueva unidad
    public function agregarUnidad(Request $request, $idMateria)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'numero_unidad' => 'required|integer',
            'horas_saber' => 'nullable|integer',
            'horas_saber_hacer' => 'nullable|integer',
        ]);

        $horas_totales = ($request->horas_saber ?? 0) + ($request->horas_saber_hacer ?? 0);

        Unidad::create([
            'nombre' => $request->nombre,
            'numero_unidad' => $request->numero_unidad,
            'horas_saber' => $request->horas_saber,
            'horas_saber_hacer' => $request->horas_saber_hacer,
            'horas_totales' => $horas_totales,
            'id_materia' => $idMateria,
        ]);

        // Recalcular el total de horas de la materia
        $this->actualizarHorasMateria($idMateria);

        return back()->with('success', 'Unidad agregada correctamente');
    }

    // Actualizar horas totales de la materia
    private function actualizarHorasMateria($idMateria)
    {
        $materia = Materia::findOrFail($idMateria);
        $totalHoras = $materia->unidades()->sum('horas_totales');
        $materia->update(['horas' => $totalHoras]);
    }

    // Actualizar una unidad específica
    public function actualizarUnidad(Request $request, $idUnidad)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'numero_unidad' => 'required|integer',
            'horas_saber' => 'nullable|integer',
            'horas_saber_hacer' => 'nullable|integer',
        ]);

        $unidad = Unidad::findOrFail($idUnidad);

        $unidad->update([
            'nombre' => $request->nombre,
            'numero_unidad' => $request->numero_unidad,
            'horas_saber' => $request->horas_saber,
            'horas_saber_hacer' => $request->horas_saber_hacer,
            'horas_totales' => ($request->horas_saber ?? 0) + ($request->horas_saber_hacer ?? 0),
        ]);

        return back()->with('success', 'Unidad actualizada correctamente');
    }

    // Actualizar todas las unidades de una materia
    public function actualizarTodo(Request $request, $idMateria)
    {
        foreach ($request->unidades as $unidadData) {
            $unidad = Unidad::find($unidadData['id_unidad']);
            if ($unidad) {
                $horas_totales = ($unidadData['horas_saber'] ?? 0) + ($unidadData['horas_saber_hacer'] ?? 0);
                $unidad->update([
                    'nombre' => $unidadData['nombre'],
                    'numero_unidad' => $unidadData['numero_unidad'],
                    'horas_saber' => $unidadData['horas_saber'],
                    'horas_saber_hacer' => $unidadData['horas_saber_hacer'],
                    'horas_totales' => $horas_totales,
                ]);
            }
        }

        // Recalcula el total de horas
        $this->actualizarHorasMateria($idMateria);

        return back()->with('success', 'Unidades actualizadas correctamente');
    }

    // Eliminar unidad
    public function eliminarUnidad($idUnidad)
    {
        $unidad = Unidad::findOrFail($idUnidad);
        $idMateria = $unidad->id_materia;
        $unidad->delete();

        // Recalcula el total de horas
        $this->actualizarHorasMateria($idMateria);

        return back()->with('success', 'Unidad eliminada correctamente');
    }

    // Mostrar todas las materias con filtros
    public function index(Request $request)
    {
        $query = Materia::with([
            'planEstudio',
            'numeroPeriodo.tipoPeriodo',
            'competencia',
            'modalidad',
            'espacioFormativo',
            'unidades' // Cargar unidades para mostrar en modal
        ])->withCount('unidades');

        // Filtros
        if ($request->filled('busqueda')) {
        $busqueda = $request->busqueda;
        $query->where(function($q) use ($busqueda) {
            $q->where('nombre', 'like', '%' . $busqueda . '%')
              ->orWhere('clave', 'like', '%' . $busqueda . '%');
        });
    }
        if ($request->filled('id_tipo_competencia')) {
            $query->where('id_tipo_competencia', $request->id_tipo_competencia);
        }
        if ($request->filled('id_modalidad')) {
            $query->where('id_modalidad', $request->id_modalidad);
        }
        if ($request->filled('id_espacio_formativo')) {
            $query->where('id_espacio_formativo', $request->id_espacio_formativo);
        }
        if ($request->filled('id_plan_estudio')) {
            $query->where('id_plan_estudio', $request->id_plan_estudio);
        }
        if ($request->filled('id_numero_periodo')) {
            $query->where('id_numero_periodo', $request->id_numero_periodo);
        }

        // Paginación o mostrar todo
        $mostrar = $request->get('mostrar', 10);

        if ($mostrar === "todo") {
            $materias = $query->orderBy('id_materia', 'desc')->get();
        } else {
            $materias = $query->orderBy('id_materia', 'desc')->paginate((int)$mostrar);
        }

        // Datos para los selects
        $planes = PlanEstudio::all();
        $periodos = NumeroPeriodo::with('tipoPeriodo')->get();
        $competencias = Competencia::all();
        $modalidades = Modalidad::all();
        $espaciosformativos = EspacioFormativo::all();

        return view('materias.materias', compact('materias', 'planes', 'periodos', 'competencias', 'modalidades', 'espaciosformativos'));
    }

    // Mostrar materias por plan de estudio
    public function materiasPorPlan($id_plan_estudio)
    {
        $plan = PlanEstudio::findOrFail($id_plan_estudio);
        $materias = Materia::with(['numeroPeriodo', 'unidades'])
            ->where('id_plan_estudio', $id_plan_estudio)
            ->withCount('unidades')
            ->get();

        return view('materias.materias_por_plan', compact('plan', 'materias'));
    }

    // Crear nueva materia (formulario)
    public function create()
    {
        $competencias = Competencia::all();
        $modalidades = Modalidad::all();
        $espaciosformativos = EspacioFormativo::all();
        $planes = PlanEstudio::all();
        $periodos = NumeroPeriodo::all();
        
        return view('materias.create', compact('competencias', 'modalidades', 'espaciosformativos', 'planes', 'periodos'));
    }

    // Guardar nueva materia
    public function store(Request $request)
    {
        $request->validate([
            'clave' => 'required|string|max:50',
            'nombre' => 'required|string|max:150',
            'id_tipo_competencia' => 'required|integer|exists:tipos_competencia,id_tipo_competencia',
            'id_modalidad' => 'required|integer|exists:modalidades,id_modalidad',
            'creditos' => 'nullable|integer',
            'horas' => 'nullable|integer',
            'id_espacio_formativo' => 'required|integer|exists:espacios_formativos,id_espacio_formativo',
            'id_plan_estudio' => 'required|integer|exists:planes_estudio,id_plan_estudio',
            'id_numero_periodo' => 'required|integer|exists:numero_periodos,id_numero_periodo',
        ]);

        Materia::create($request->all());

        return redirect()->route('materias.index')->with('success', 'Materia creada correctamente.');
    }

    // Editar materia (formulario)
    public function edit($id)
    {
        $materia = Materia::findOrFail($id);
        $planes = PlanEstudio::all();
        $periodos = NumeroPeriodo::all();
        $competencias = Competencia::all();
        $modalidades = Modalidad::all();
        $espaciosformativos = EspacioFormativo::all();
        
        return view('materias.edit', compact('materia', 'planes', 'periodos', 'competencias', 'modalidades', 'espaciosformativos'));
    }

    // Actualizar materia
    public function update(Request $request, $id)
{
    $materia = Materia::findOrFail($id);
    
    $materia->clave = $request->clave;
    $materia->nombre = $request->nombre;
    $materia->id_tipo_competencia = $request->id_tipo_competencia;
    $materia->id_modalidad = $request->id_modalidad;
    $materia->creditos = $request->creditos;
    $materia->horas = $request->horas;
    $materia->id_espacio_formativo = $request->id_espacio_formativo;
    $materia->id_plan_estudio = $request->id_plan_estudio;
    $materia->id_numero_periodo = $request->id_numero_periodo;
    
    $materia->save();

    return redirect()->route('materias.index')->with('success', 'Materia actualizada correctamente.');
}

    // Eliminar materia
    public function destroy($id)
    {
        $materia = Materia::findOrFail($id);
        $materia->delete();

        return redirect()->route('materias.index')->with('success', 'Materia eliminada correctamente.');
    }

    // Ver detalles completos de una materia (opcional, si quieres una vista separada)
   /* public function show($id)
    {
        $materia = Materia::with([
            'planEstudio',
            'numeroPeriodo.tipoPeriodo',
            'competencia',
            'modalidad',
            'espacioFormativo',
            'unidades'
        ])->withCount('unidades')->findOrFail($id);

        return view('materias.show', compact('materia'));
    }*/

    public function show($id)
{
    $materia = Materia::with([
        'planEstudio',
        'numeroPeriodo.tipoPeriodo',
        'competencia',
        'modalidad',
        'espacioFormativo',
        'unidades'
    ])->withCount('unidades')->findOrFail($id);

    // Redirigir al listado con un mensaje
    return redirect()->route('materias.index')
        ->with('success', 'La materia fue actualizada correctamente.');
}
    
}