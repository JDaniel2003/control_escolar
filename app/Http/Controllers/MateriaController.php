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
use Illuminate\Support\Facades\Validator;

class MateriaController extends Controller
{
    // ---------------------------
    // UNIDADES
    // ---------------------------

    public function agregarUnidad(Request $request, $idMateria)
{
    $validator = Validator::make($request->all(), [
        'nombre' => 'required|string|max:255',
        'numero_unidad' => 'nullable|integer|min:1|unique:unidades,numero_unidad,NULL,id_unidad,id_materia,' . $idMateria,
        'horas_saber' => 'required|integer|min:0',
        'horas_saber_hacer' => 'nullable|integer|min:0',
    ], [
        'nombre.required' => 'El nombre de la unidad es obligatorio.',
        'nombre.max' => 'El nombre no puede exceder 255 caracteres.',
        'numero_unidad.integer' => 'El número de unidad debe ser un entero.',
        'numero_unidad.min' => 'El número de unidad debe ser al menos 1.',
        'numero_unidad.unique' => 'Ya existe una unidad con ese número en esta materia.',
        'horas_saber.integer' => 'Las horas saber deben ser un número entero.',
        'horas_saber.min' => 'Las horas saber no pueden ser negativas.',
        'horas_saber_hacer.integer' => 'Las horas saber hacer deben ser un número entero.',
        'horas_saber_hacer.min' => 'Las horas saber hacer no pueden ser negativas.',
    ]);

    if ($validator->fails()) {
        return redirect()->route('materias.index')
            ->withErrors($validator)
            ->withInput()
            ->with('unidad_error', 'Error al agregar la unidad.') // mensaje genérico o personalizado
            ->with('abrir_unidades', $idMateria); // 👈 clave unificada
    }

    // Autoincrementar si no se envía
    if (!$request->filled('numero_unidad')) {
        $ultimo = Unidad::where('id_materia', $idMateria)->max('numero_unidad');
        $numero_unidad = ($ultimo ?? 0) + 1;
    } else {
        $numero_unidad = $request->numero_unidad;
    }

    $horas_totales = ($request->horas_saber ?? 0) + ($request->horas_saber_hacer ?? 0);

    Unidad::create([
        'nombre' => trim($request->nombre),
        'numero_unidad' => $numero_unidad,
        'horas_saber' => $request->horas_saber,
        'horas_saber_hacer' => $request->horas_saber_hacer,
        'horas_totales' => $horas_totales,
        'id_materia' => $idMateria,
    ]);

    $this->actualizarHorasMateria($idMateria);

    return redirect()->route('materias.index')
        ->with('unidad_success', 'Unidad agregada correctamente.')
        ->with('abrir_unidades', $idMateria);
}

public function actualizarTodo(Request $request, $idMateria)
{
    if (!$request->has('unidades') || !is_array($request->unidades)) {
        return redirect()->route('materias.index')
            ->with('unidad_error', 'No se recibieron unidades para actualizar.')
            ->with('abrir_unidades', $idMateria);
    }

    $errores = [];
    foreach ($request->unidades as $index => $unidadData) {
        if (!isset($unidadData['id_unidad']) || !isset($unidadData['nombre']) || !isset($unidadData['numero_unidad'])) {
            $errores[] = "Faltan datos en la unidad #{$index}.";
            continue;
        }

        $unidad = Unidad::find($unidadData['id_unidad']);
        if (!$unidad) {
            $errores[] = "Unidad con ID {$unidadData['id_unidad']} no encontrada.";
            continue;
        }

        $validator = Validator::make($unidadData, [
            'nombre' => 'required|string|max:255',
            'numero_unidad' => 'required|integer|min:1|unique:unidades,numero_unidad,' . $unidad->id_unidad . ',id_unidad,id_materia,' . $idMateria,
            'horas_saber' => 'nullable|integer|min:0',
            'horas_saber_hacer' => 'nullable|integer|min:0',
        ], [
            'nombre.required' => "El nombre de la unidad #{$index} es obligatorio.",
            'nombre.max' => "El nombre de la unidad #{$index} no puede exceder 255 caracteres.",
            'numero_unidad.required' => "El número de la unidad #{$index} es obligatorio.",
            'numero_unidad.integer' => "El número de la unidad #{$index} debe ser un entero.",
            'numero_unidad.min' => "El número de la unidad #{$index} debe ser al menos 1.",
            'numero_unidad.unique' => "Ya existe una unidad con ese número en esta materia (unidad #{$index}).",
            'horas_saber.integer' => "Las horas saber de la unidad #{$index} deben ser un número entero.",
            'horas_saber.min' => "Las horas saber de la unidad #{$index} no pueden ser negativas.",
            'horas_saber_hacer.integer' => "Las horas saber hacer de la unidad #{$index} deben ser un número entero.",
            'horas_saber_hacer.min' => "Las horas saber hacer de la unidad #{$index} no pueden ser negativas.",
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $errores[] = $error;
            }
            continue;
        }

        $horas_totales = ($unidadData['horas_saber'] ?? 0) + ($unidadData['horas_saber_hacer'] ?? 0);
        $unidad->update([
            'nombre' => trim($unidadData['nombre']),
            'numero_unidad' => $unidadData['numero_unidad'],
            'horas_saber' => $unidadData['horas_saber'],
            'horas_saber_hacer' => $unidadData['horas_saber_hacer'],
            'horas_totales' => $horas_totales,
        ]);
    }

    if (!empty($errores)) {
        return redirect()->route('materias.index')
            ->withErrors($errores) // Esto mostrará los errores en la vista
            ->with('abrir_unidades', $idMateria);
    }

    $this->actualizarHorasMateria($idMateria);
    return redirect()->route('materias.index')
        ->with('unidad_success', 'Unidades actualizadas correctamente.')
        ->with('abrir_unidades', $idMateria);
}

 public function eliminarUnidad($idUnidad)
    {
        $unidad = Unidad::findOrFail($idUnidad);
        $idMateria = $unidad->id_materia;
        $unidad->delete();

        // Recalcula el total de horas
        $this->actualizarHorasMateria($idMateria);

        return back()->with('success', 'Unidad eliminada correctamente');
    }
    // ---------------------------
    // MATERIAS
    // ---------------------------

    public function index(Request $request)
    {
        $query = Materia::with([
            'planEstudio',
            'numeroPeriodo.tipoPeriodo',
            'competencia',
            'modalidad',
            'espacioFormativo',
            'unidades'
        ])->withCount('unidades');

        if ($request->filled('busqueda')) {
            $busqueda = $request->busqueda;
            $query->where(function($q) use ($busqueda) {
                $q->where('nombre', 'like', "%$busqueda%")
                  ->orWhere('clave', 'like', "%$busqueda%");
            });
        }
        if ($request->filled('id_plan_estudio')) {
            $query->where('id_plan_estudio', $request->id_plan_estudio);
        }
        if ($request->filled('id_numero_periodo')) {
            $query->where('id_numero_periodo', $request->id_numero_periodo);
        }

        $mostrar = $request->get('mostrar', 10);
        $materias = ($mostrar === 'todo')
            ? $query->orderBy('id_materia', 'desc')->get()
            : $query->orderBy('id_materia', 'desc')->paginate((int)$mostrar);

        $planes = PlanEstudio::all();
        $periodos = NumeroPeriodo::with('tipoPeriodo')->get();
        $competencias = Competencia::all();
        $modalidades = Modalidad::all();
        $espaciosformativos = EspacioFormativo::all();

        return view('materias.materias', compact('materias', 'planes', 'periodos', 'competencias', 'modalidades', 'espaciosformativos'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'clave' => [
                'required',
                'string',
                'max:50',
                'unique:materias,clave',
                'regex:/^[A-Z0-9\-]+$/'
            ],
            'nombre' => [
                'required',
                'string',
                'max:255',
                'unique:materias,nombre',
                'regex:/^[A-ZÁÉÍÓÚÑ][a-záéíóúñA-ZÁÉÍÓÚÑ0-9\s\-\.,:;()]+$/'
            ],
            'id_tipo_competencia' => 'required|exists:tipos_competencia,id_tipo_competencia',
            'id_modalidad' => 'required|exists:modalidades,id_modalidad',
            'creditos' => 'required|numeric|min:0|max:20',
            'horas' => 'required|integer|min:0|max:500',
            'id_espacio_formativo' => 'required|exists:espacios_formativos,id_espacio_formativo',
            'id_plan_estudio' => 'required|exists:planes_estudio,id_plan_estudio',
            'id_numero_periodo' => 'required|exists:numero_periodos,id_numero_periodo',
        ], [
            'clave.required' => 'La clave de la materia es obligatoria.',
            'clave.unique' => 'Ya existe una materia con esta clave.',
            'clave.max' => 'La clave no puede exceder 50 caracteres.',
            'clave.regex' => 'La clave debe contener solo letras mayúsculas, números y guiones (Ej: MAT-101).',

            'nombre.required' => 'El nombre de la materia es obligatorio.',
            'nombre.unique' => 'Ya existe una materia con este nombre.',
            'nombre.max' => 'El nombre no puede exceder 255 caracteres.',
            'nombre.regex' => 'El nombre debe comenzar con mayúscula y contener solo letras, números y puntuación básica.',

            'id_tipo_competencia.required' => 'El tipo de competencia de la materia es obligatorio.',
            'id_modalidad.required' => 'La modalidad de la materia es obligatoria.',
            'creditos.required' => 'Los créditos de la materia son obligatorios.',
            'horas.required' => 'Las horas de la materia son obligatorias.',
            'id_espacio_formativo.required' => 'El espacio formativo de la materia es obligatorio.',
            'id_plan_estudio.required' => 'El plan de estudios de la materia es obligatorio.',
            'id_numero_periodo.required' => 'El número de período que pertenece la materia es obligatorio.',

            'id_tipo_competencia.exists' => 'La competencia seleccionada no es válida.',
            'id_modalidad.exists' => 'La modalidad seleccionada no es válida.',
            'id_espacio_formativo.exists' => 'El espacio formativo seleccionado no es válido.',
            'id_plan_estudio.exists' => 'El plan de estudio seleccionado no es válido.',
            'id_numero_periodo.exists' => 'El número de período seleccionado no es válido.',

            'creditos.numeric' => 'Los créditos deben ser un número.',
            'creditos.min' => 'Los créditos no pueden ser negativos.',
            'creditos.max' => 'Los créditos no pueden exceder 20.',

            'horas.integer' => 'Las horas deben ser un número entero.',
            'horas.min' => 'Las horas no pueden ser negativas.',
            'horas.max' => 'Las horas no pueden exceder 500.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('materias.index')
                ->withErrors($validator)
                ->withInput()
                ->with('is_create_materia', 1);
        }

        $materia = Materia::create($request->all());

        return redirect()->route('materias.index')
            ->with('success', 'Materia creada correctamente.')
            ->with('abrir_unidades', $materia->id_materia);
    }

    public function update(Request $request, $id)
    {
        $materia = Materia::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'clave' => [
                'required',
                'string',
                'max:50',
                'unique:materias,clave,' . $id . ',id_materia',
                'regex:/^[A-Z0-9\-]+$/'
            ],
            'nombre' => [
                'required',
                'string',
                'max:255',
                'unique:materias,nombre,' . $id . ',id_materia',
                'regex:/^[A-ZÁÉÍÓÚÑ][a-záéíóúñA-ZÁÉÍÓÚÑ0-9\s\-\.,:;()]+$/'
            ],
            'id_tipo_competencia' => 'required|exists:tipos_competencia,id_tipo_competencia',
            'id_modalidad' => 'required|exists:modalidades,id_modalidad',
            'creditos' => 'required|numeric|min:0|max:20',
            'horas' => 'required|integer|min:0|max:500',
            'id_espacio_formativo' => 'required|exists:espacios_formativos,id_espacio_formativo',
            'id_plan_estudio' => 'required|exists:planes_estudio,id_plan_estudio',
            'id_numero_periodo' => 'required|exists:numero_periodos,id_numero_periodo',
        ], [
            'clave.required' => 'La clave de la materia es obligatoria.',
            'clave.unique' => 'Ya existe otra materia con esta clave.',
            'clave.regex' => 'La clave debe contener solo letras mayúsculas, números y guiones.',

            'nombre.required' => 'El nombre de la materia es obligatorio.',
            'nombre.unique' => 'Ya existe otra materia con este nombre.',
            'nombre.regex' => 'El nombre debe comenzar con mayúscula.',

            'id_tipo_competencia.required' => 'El tipo de competencia de la materia es obligatorio.',
            'id_modalidad.required' => 'La modalidad de la materia es obligatoria.',
            'creditos.required' => 'Los créditos de la materia son obligatorios.',
            'horas.required' => 'Las horas de la materia son obligatorias.',
            'id_espacio_formativo.required' => 'El espacio formativo de la materia es obligatorio.',
            'id_plan_estudio.required' => 'El plan de estudios de la materia es obligatorio.',
            'id_numero_periodo.required' => 'El número de período que pertenece la materia es obligatorio.',

            'creditos.max' => 'Los créditos no pueden exceder 20.',
            'horas.max' => 'Las horas no pueden exceder 500.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('materias.index')
                ->withErrors($validator)
                ->withInput()
                ->with('materia_id', $id);
        }

        $materia->update([
            'clave' => strtoupper(trim($request->clave)),
            'nombre' => trim($request->nombre),
            'id_tipo_competencia' => $request->id_tipo_competencia,
            'id_modalidad' => $request->id_modalidad,
            'creditos' => $request->creditos,
            'horas' => $request->horas,
            'id_espacio_formativo' => $request->id_espacio_formativo,
            'id_plan_estudio' => $request->id_plan_estudio,
            'id_numero_periodo' => $request->id_numero_periodo,
        ]);

        return redirect()->route('materias.index')
            ->with('success', 'Materia actualizada correctamente.');
    }

    public function destroy($id)
    {
        $materia = Materia::findOrFail($id);
        $materia->delete();
        return redirect()->route('materias.index')
            ->with('success', 'Materia eliminada correctamente.');
    }

    public function show($id)
    {
        return redirect()->route('materias.index');
    }

    private function actualizarHorasMateria($idMateria)
    {
        $materia = Materia::findOrFail($idMateria);
        $totalHoras = $materia->unidades()->sum('horas_totales');
        $materia->update(['horas' => $totalHoras]);
    }
}