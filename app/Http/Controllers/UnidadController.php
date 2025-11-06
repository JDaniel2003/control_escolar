<?php

namespace App\Http\Controllers;

use App\Models\Unidad;
use App\Models\Materia;
use Illuminate\Http\Request;

class UnidadController extends Controller
{
    /**
     * Mostrar listado de unidades.
     */
    public function index()
    {
        $unidades = Unidad::with('materia')->get();
        return view('unidades.index', compact('unidades'));
    }

    /**
     * Mostrar formulario para crear una nueva unidad.
     */
    public function create($id_materia = null)
    {
        $materias = Materia::all();
        return view('unidades.create', compact('materias', 'id_materia'));
    }

    /**
     * Guardar nueva unidad en BD.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'numero_unidad' => 'required|integer',
            'horas_saber' => 'nullable|integer',
            'horas_saber_hacer' => 'nullable|integer',
            'horas_totales' => 'nullable|integer',
            'id_materia' => 'required|exists:materias,id_materia',
        ]);

        Unidad::create($request->all());

        // 🔹 Actualizar horas totales de la materia
        $this->actualizarHorasMateria($request->id_materia);

        return redirect()
            ->route('materias.show', $request->id_materia)
            ->with('success', 'Unidad agregada correctamente y horas actualizadas.');
    }

    /**
     * Mostrar formulario de edición de una unidad individual.
     */
    public function edit($id)
    {
        $unidad = Unidad::findOrFail($id);
        $materias = Materia::all();
        return view('unidades.edit', compact('unidad', 'materias'));
    }

    /**
     * Actualizar todas las unidades asociadas a una materia.
     */
    public function actualizarTodo(Request $request, $idMateria)
    {
        if (!isset($request->unidades) || empty($request->unidades)) {
            return back()->with('warning', 'No hay unidades para actualizar.');
        }

        foreach ($request->unidades as $unidadData) {
            $unidad = Unidad::find($unidadData['id_unidad']);
            if ($unidad) {
                $unidad->update([
                    'numero_unidad'     => $unidadData['numero_unidad'],
                    'nombre'            => $unidadData['nombre'],
                    'horas_saber'       => $unidadData['horas_saber'],
                    'horas_saber_hacer' => $unidadData['horas_saber_hacer'],
                    'horas_totales'     => $unidadData['horas_totales'],
                ]);
            }
        }

        // 🔹 Recalcular horas totales en la materia
        $this->actualizarHorasMateria($idMateria);

        return back()->with('success', 'Unidades y horas de la materia actualizadas correctamente.');
    }

    /**
     * Actualizar una unidad individual.
     */
    public function update(Request $request, $id)
    {
        $unidad = Unidad::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:100',
            'numero_unidad' => 'required|integer',
            'horas_saber' => 'nullable|integer',
            'horas_saber_hacer' => 'nullable|integer',
            'horas_totales' => 'nullable|integer',
            'id_materia' => 'required|exists:materias,id_materia',
        ]);

        $unidad->update($request->all());

        // 🔹 Recalcular horas totales de la materia
        $this->actualizarHorasMateria($unidad->id_materia);

        return redirect()
            ->route('materias.show', $unidad->id_materia)
            ->with('success', 'Unidad y horas de la materia actualizadas correctamente.');
    }

    /**
     * Eliminar unidad y recalcular horas de materia.
     */
    public function destroy($id)
    {
        $unidad = Unidad::findOrFail($id);
        $materiaId = $unidad->id_materia;

        $unidad->delete();

        // 🔹 Recalcular horas totales en la materia
        $this->actualizarHorasMateria($materiaId);

        return redirect()
            ->route('materias.show', $materiaId)
            ->with('success', 'Unidad eliminada y horas de la materia actualizadas correctamente.');
    }

    /**
     * 🔹 Función privada para recalcular las horas totales de una materia
     *    según la suma de todas sus unidades.
     */
    private function actualizarHorasMateria($idMateria)
    {
        $materia = Materia::find($idMateria);

        if ($materia) {
            $materia->horas = Unidad::where('id_materia', $idMateria)->sum('horas_totales');
            $materia->save();
        }
    }
    
}
