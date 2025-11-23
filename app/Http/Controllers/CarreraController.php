<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use Illuminate\Http\Request;

class CarreraController extends Controller
{
    public function index(Request $request)
    {
        $query = Carrera::query();

        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }
        if ($request->filled('duracion')) {
            $query->where('duracion', 'like', '%' . $request->duracion . '%');
        }
        $mostrar = $request->get('mostrar', 10); // por defecto 10

        if ($mostrar === "todo") {
            $carreras = $query->orderBy('id_carrera', 'desc')->get();
        } else {
            $carreras = $query->orderBy('id_carrera', 'desc')->paginate((int)$mostrar);
        }
        $carreras = $query->get();
        $carreras = Carrera::with('planesEstudio')->get();
        $carreras = Carrera::with(['planVigente.materias.numeroPeriodo.tipoPeriodo'])->get();

        return view('carreras.carreras', compact('carreras'));
    }
    public function create()
    {
        return view('carreras.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
                'unique:carreras,nombre',
                'regex:/^[A-ZÁÉÍÓÚÑ][a-záéíóúñA-ZÁÉÍÓÚÑ\s]+$/'
            ],
            'duracion' => [
                'required',
                'string',
                'max:50',
                'regex:/^\d+\s+(año|años|semestre|semestres|cuatrimestre|cuatrimestres)$/i'
            ],
        ], [
            'nombre.required' => 'El nombre de la carrera es obligatorio.',
            'nombre.unique' => 'Ya existe una carrera con este nombre.',
            'nombre.max' => 'El nombre de la carrera no puede exceder 255 caracteres.',
            'nombre.regex' => 'El nombre debe comenzar con mayúscula y contener solo letras y espacios.',

            'duracion.required' => 'La duración de la carrera es obligatoria.',
            'duracion.max' => 'La duración no puede exceder 50 caracteres.',
            'duracion.regex' => 'La duración debe tener el formato: "4 años".',
        ]);

        Carrera::create($request->all());

        return redirect()->route('carreras.index')
            ->with('success', 'Carrera creada correctamente.');
    }

    public function edit($id)
    {
        $carrera = Carrera::findOrFail($id);
        return view('carreras.edit', compact('carrera'));
    }

    public function update(Request $request, $id)
    {
        $carrera = Carrera::findOrFail($id);

        $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
                'unique:carreras,nombre,' . $id . ',id_carrera',
                'regex:/^[A-ZÁÉÍÓÚÑ][a-záéíóúñA-ZÁÉÍÓÚÑ\s]+$/'
            ],
            'duracion' => [
                'required',
                'string',
                'max:50',
                'regex:/^\d+\s+(año|años|semestre|semestres|cuatrimestre|cuatrimestres)$/i'
            ],
        ], [
            'nombre.required' => 'El nombre de la carrera es obligatorio.',
            'nombre.unique' => 'Ya existe otra carrera con este nombre.',
            'nombre.max' => 'El nombre de la carrera no puede exceder 255 caracteres.',
            'nombre.regex' => 'El nombre debe comenzar con mayúscula y contener solo letras y espacios.',

            'duracion.required' => 'La duración de la carrera es obligatoria.',
            'duracion.max' => 'La duración no puede exceder 50 caracteres.',
            'duracion.regex' => 'La duración debe tener el formato: "4 años", "8 semestres", etc.',
        ]);


        $carrera->update($request->all());

        return redirect()->route('carreras.index')
            ->with('success', 'Carrera actualizada correctamente.');
    }
    public function destroy($id)
    {
        $carrera = Carrera::findOrFail($id);
        $carrera->delete();

        return redirect()->route('carreras.index')
            ->with('success', 'Carrera eliminada correctamente.');
    }
}
