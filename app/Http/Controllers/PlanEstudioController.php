<?php

namespace App\Http\Controllers;



use App\Models\PlanEstudio;
use App\Models\Carrera;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
class PlanEstudioController extends Controller
{
    public function descargarPDF($id)
    {
        $plan = PlanEstudio::with(['carrera', 'materias.numeroPeriodo.tipoPeriodo'])
            ->findOrFail($id);

        $pdf = Pdf::loadView('planes.pdf', compact('plan'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('Plan_' . $plan->nombre . '.pdf');
    }
    public function index(Request $request)
    {
        // Traer carrera + contar materias
        $query = PlanEstudio::with('carrera')->withCount('materias');

        // Filtro por nombre de plan
        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        // Filtro por carrera
        if ($request->filled('id_carrera')) {
            $query->where('id_carrera', $request->id_carrera);
        }

        // Orden descendente
        $query->orderByDesc('id_plan_estudio');

        // Mostrar todo o paginar
        $mostrar = $request->get('mostrar', 10); // por defecto 10
        if ($mostrar === "todo") {
            $planes = $query->get();
        } else {
            $planes = $query->paginate((int)$mostrar)->appends($request->all());
        }

        $carreras = Carrera::all();

        return view('planes.planes', compact('planes', 'carreras'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:planes_estudio,nombre',
            'id_carrera' => 'nullable|exists:carreras,id_carrera',
        ]);

        PlanEstudio::create($request->all());

        return redirect()->route('planes.index')
            ->with('success', 'Plan de estudio creado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $plan = PlanEstudio::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:100|unique:planes_estudio,nombre,' . $plan->id_plan_estudio . ',id_plan_estudio',
            'id_carrera' => 'nullable|exists:carreras,id_carrera',
        ]);

        $plan->update($request->all());

        return redirect()->route('planes.index')
            ->with('success', 'Plan de estudio actualizado correctamente.');
    }

    public function destroy($id)
    {
        $plan = PlanEstudio::findOrFail($id);
        $plan->delete();

        return redirect()->route('planes.index')
            ->with('success', 'Plan de estudio eliminado correctamente.');
    }

    public function show(PlanEstudio $plane)
    {
        return view('planes.show', compact('plane'));
    }
}
