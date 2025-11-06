<?php

namespace App\Http\Controllers;

use App\Models\AsignacionDocente;
use App\Models\Usuario;
use App\Models\Materia;
use App\Models\Grupo;
use App\Models\PeriodoEscolar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AsignacionDocenteController extends Controller
{
    public function index(Request $request)
    {
        $query = AsignacionDocente::with(['docente', 'materia', 'grupo', 'periodoEscolar']);

        // Filtro por docente
        if ($request->filled('id_docente')) {
            $query->where('id_docente', $request->id_docente);
        }

        // Filtro por materia
        if ($request->filled('id_materia')) {
            $query->where('id_materia', $request->id_materia);
        }

        // Filtro por grupo
        if ($request->filled('id_grupo')) {
            $query->where('id_grupo', $request->id_grupo);
        }

        // Filtro por período escolar
        if ($request->filled('id_periodo_escolar')) {
            $query->where('id_periodo_escolar', $request->id_periodo_escolar);
        }

        // Búsqueda por nombre de docente
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->whereHas('docente', function($q) use ($buscar) {
                $q->where('name', 'like', "%{$buscar}%");
            });
        }

        // Paginación
        $mostrar = $request->get('mostrar', 10);
        if ($mostrar == 'todo') {
            $asignaciones = $query->get();
        } else {
            $asignaciones = $query->paginate($mostrar);
        }

        // Obtener datos para los filtros
        $docentes = Usuario::whereHas('rol', function($q) {
            $q->where('nombre', 'Docente');
        })->get();
        
        $materias = Materia::all();
        $grupos = Grupo::all();
        $periodos = PeriodoEscolar::all();

        return view('asignaciones.asignaciones', compact('asignaciones', 'docentes', 'materias', 'grupos', 'periodos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_docente' => 'required|exists:usuarios,id_usuario',
            'id_materia' => 'required|exists:materias,id_materia',
            'id_grupo' => 'required|exists:grupos,id_grupo',
            'id_periodo_escolar' => 'required|exists:periodos_escolares,id_periodo_escolar',
        ], [
            'id_docente.required' => 'El docente es obligatorio',
            'id_materia.required' => 'La materia es obligatoria',
            'id_grupo.required' => 'El grupo es obligatorio',
            'id_periodo_escolar.required' => 'El período escolar es obligatorio',
        ]);

        // Verificar que no exista la misma asignación
        $existe = AsignacionDocente::where('id_docente', $request->id_docente)
            ->where('id_materia', $request->id_materia)
            ->where('id_grupo', $request->id_grupo)
            ->where('id_periodo_escolar', $request->id_periodo_escolar)
            ->exists();

        if ($existe) {
            return back()->withErrors(['error' => 'Esta asignación ya existe'])->withInput();
        }

        AsignacionDocente::create($request->all());

        return redirect()->route('asignaciones.index')->with('success', 'Asignación creada exitosamente');
    }

    public function update(Request $request, AsignacionDocente $asignacione)
    {
        $request->validate([
            'id_docente' => 'required|exists:usuarios,id_usuario',
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
        $existe = AsignacionDocente::where('id_docente', $request->id_docente)
            ->where('id_materia', $request->id_materia)
            ->where('id_grupo', $request->id_grupo)
            ->where('id_periodo_escolar', $request->id_periodo_escolar)
            ->where('id_asignacion', '!=', $asignacione->id_asignacion)
            ->exists();

        if ($existe) {
            return back()->withErrors(['error' => 'Esta asignación ya existe'])->withInput();
        }

        $asignacione->update($request->all());

        return redirect()->route('asignaciones.index')->with('success', 'Asignación actualizada exitosamente');
    }

    public function destroy(AsignacionDocente $asignacione)
    {
        $asignacione->delete();
        return redirect()->route('asignaciones.index')->with('success', 'Asignación eliminada exitosamente');
    }
}