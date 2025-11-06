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
            'nombre' => 'required|string|max:100',
            'duracion' => 'nullable|string|max:10',
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
        'nombre' => 'required|string|max:100',
        'duracion' => 'nullable|string|max:10',
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
            ->with('success', 'Período escolar eliminado correctamente.');
    }
}
