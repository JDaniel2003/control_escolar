<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evaluacion;
use App\Models\StatusAcademico;
use App\Models\TipoPeriodo;
use App\Models\Estado;
use App\Models\Distrito;
use App\Models\LenguaIndigena;
use App\Models\Subsistema;
use App\Models\Beca;
use App\Models\AreaEspecializacion;
use App\Models\Discapacidad;
use App\Models\EstadoCivil;
use App\Models\Generacion;
use App\Models\Genero;
use App\Models\HistorialStatus;
use App\Models\Modalidad;
use App\Models\Parentesco;
use App\Models\Rol;
use App\Models\TipoSangre;
use App\Models\Turno;
use App\Models\TipoEscuela;
use App\Models\TipoCompetencia;

class CatalogosController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->input('tabla', 'tiposPeriodos');

        // Capturar filtros de búsqueda
        $nombrePeriodos = $request->input('nombre_periodos');
        $nombreStatus = $request->input('nombre_status');
        $nombreEvaluaciones = $request->input('nombre_evaluaciones');
        $nombreEstados = $request->input('nombre_estados');
        $nombreDistritos = $request->input('nombre_distritos');
        $nombreLenguas = $request->input('nombre_lenguas');
        $nombreSubsistemas = $request->input('nombre_subsistemas');
        $nombreBecas = $request->input('nombre_becas');
        $nombreAreas = $request->input('nombre_areas');
        $nombreDiscapacidades = $request->input('nombre_discapacidades');
        $nombreEstadoCivil = $request->input('nombre_estado_civil');
        $nombreGeneraciones = $request->input('nombre_generaciones');
        $nombreGeneros = $request->input('nombre_generos');
        $nombreHistorialStatus = $request->input('nombre_historial_status');
        $nombreModalidades = $request->input('nombre_modalidades');
        $nombreParentescos = $request->input('nombre_parentescos');
        $nombreRoles = $request->input('nombre_roles');
        $nombreTiposSangre = $request->input('nombre_tipos_sangre');
        $nombreTurnos = $request->input('nombre_turnos');
        $nombreTiposEscuela = $request->input('nombre_tipos_escuela');
        $nombreTiposCompetencia = $request->input('nombre_tipos_competencia');

        // ==================== EVALUACIONES ====================
        $evaluaciones = Evaluacion::when($nombreEvaluaciones, function ($query, $nombreEvaluaciones) {
            $query->where('nombre', 'like', "%{$nombreEvaluaciones}%");
        })->get();

        // ==================== STATUS ACADEMICOS ====================
        $statusAcademicos = StatusAcademico::when($nombreStatus, function ($query, $nombreStatus) {
            $query->where('nombre', 'like', "%{$nombreStatus}%")
                ->orWhere('descripcion', 'like', "%{$nombreStatus}%");
        })->get();

        // ==================== TIPOS DE PERIODOS ====================
        $tiposPeriodos = TipoPeriodo::when($nombrePeriodos, function ($query, $nombrePeriodos) {
            $query->where('nombre', 'like', "%{$nombrePeriodos}%");
        })->get();

        // ==================== ESTADOS ====================
        $estados = Estado::when($nombreEstados, function ($query, $nombreEstados) {
            $query->where('nombre', 'like', "%{$nombreEstados}%");
        })->get();

        // ==================== DISTRITOS ====================
        $distritos = Distrito::when($nombreDistritos, function ($query, $nombreDistritos) {
            $query->where('nombre', 'like', "%{$nombreDistritos}%");
        })->get();

        // ==================== LENGUAS INDÍGENAS ====================
        $lenguas = LenguaIndigena::when($nombreLenguas, function ($query, $nombreLenguas) {
            $query->where('nombre', 'like', "%{$nombreLenguas}%");
        })->get();

        // ==================== SUBSISTEMAS ====================
        $subsistemas = Subsistema::when($nombreSubsistemas, function ($query, $nombreSubsistemas) {
            $query->where('nombre', 'like', "%{$nombreSubsistemas}%")
                ->orWhere('descripcion', 'like', "%{$nombreSubsistemas}%");
        })->get();

        // ==================== BECAS ====================
        $becas = Beca::when($nombreBecas, function ($query, $nombreBecas) {
            $query->where('nombre', 'like', "%{$nombreBecas}%");
        })->get();

        // ==================== ÁREAS DE ESPECIALIZACIÓN ====================
        $areas = AreaEspecializacion::when($nombreAreas, function ($query, $nombreAreas) {
            $query->where('nombres', 'like', "%{$nombreAreas}%");
        })->get();

        // ==================== DISCAPACIDADES ====================
        $discapacidades = Discapacidad::when($nombreDiscapacidades, function ($query, $nombreDiscapacidades) {
            $query->where('nombre', 'like', "%{$nombreDiscapacidades}%");
        })->get();

        // ==================== ESTADO CIVIL ====================
        $estadosCiviles = EstadoCivil::when($nombreEstadoCivil, function ($query, $nombreEstadoCivil) {
            $query->where('nombre', 'like', "%{$nombreEstadoCivil}%");
        })->get();

        // ==================== GENERACIONES ====================
        $generaciones = Generacion::when($nombreGeneraciones, function ($query, $nombreGeneraciones) {
            $query->where('nombre', 'like', "%{$nombreGeneraciones}%");
        })->get();

        // ==================== GÉNEROS ====================
        $generos = Genero::when($nombreGeneros, function ($query, $nombreGeneros) {
            $query->where('nombre', 'like', "%{$nombreGeneros}%");
        })->get();

        // ==================== HISTORIAL STATUS ====================
        $historialStatus = HistorialStatus::when($nombreHistorialStatus, function ($query, $nombreHistorialStatus) {
            $query->where('nombre', 'like', "%{$nombreHistorialStatus}%")
                ->orWhere('incorporacion', 'like', "%{$nombreHistorialStatus}%");
        })->get();

        // ==================== MODALIDADES ====================
        $modalidades = Modalidad::when($nombreModalidades, function ($query, $nombreModalidades) {
            $query->where('nombre', 'like', "%{$nombreModalidades}%");
        })->get();

        // ==================== PARENTESCOS ====================
        $parentescos = Parentesco::when($nombreParentescos, function ($query, $nombreParentescos) {
            $query->where('nombre', 'like', "%{$nombreParentescos}%");
        })->get();

        // ==================== ROLES ====================
        $roles = Rol::when($nombreRoles, function ($query, $nombreRoles) {
            $query->where('nombre', 'like', "%{$nombreRoles}%");
        })->get();

        // ==================== TIPOS DE SANGRE ====================
        $tiposSangre = TipoSangre::when($nombreTiposSangre, function ($query, $nombreTiposSangre) {
            $query->where('nombre', 'like', "%{$nombreTiposSangre}%");
        })->get();

        // ==================== TURNOS ====================
        $turnos = Turno::when($nombreTurnos, function ($query, $nombreTurnos) {
            $query->where('nombre', 'like', "%{$nombreTurnos}%");
        })->get();

        // ==================== TIPOS DE ESCUELA ====================
        $tiposEscuela = TipoEscuela::when($nombreTiposEscuela, function ($query, $nombreTiposEscuela) {
            $query->where('nombre', 'like', "%{$nombreTiposEscuela}%");
        })->get();

        // ==================== TIPOS DE COMPETENCIA ====================
        $tiposCompetencia = TipoCompetencia::when($nombreTiposCompetencia, function ($query, $nombreTiposCompetencia) {
            $query->where('nombre', 'like', "%{$nombreTiposCompetencia}%");
        })->get();

        // ==================== RETORNAR VISTA ====================
        return view('catalogos.catalogos', [
            'tiposPeriodos' => $tiposPeriodos,
            'statusAcademicos' => $statusAcademicos,
            'evaluaciones' => $evaluaciones,
            'estados' => $estados,
            'distritos' => $distritos,
            'lenguas' => $lenguas,
            'subsistemas' => $subsistemas,
            'becas' => $becas,
            'areas' => $areas,
            'discapacidades' => $discapacidades,
            'estadosCiviles' => $estadosCiviles,
            'generaciones' => $generaciones,
            'generos' => $generos,
            'historialStatus' => $historialStatus,
            'modalidades' => $modalidades,
            'parentescos' => $parentescos,
            'roles' => $roles,
            'tiposSangre' => $tiposSangre,
            'turnos' => $turnos,
            'tiposEscuela' => $tiposEscuela,
            'tiposCompetencia' => $tiposCompetencia,
            'activeTab' => $activeTab,
            'nombrePeriodos' => $nombrePeriodos,
            'nombreStatus' => $nombreStatus,
            'nombreEvaluaciones' => $nombreEvaluaciones,
            'nombreEstados' => $nombreEstados,
            'nombreDistritos' => $nombreDistritos,
            'nombreLenguas' => $nombreLenguas,
            'nombreSubsistemas' => $nombreSubsistemas,
            'nombreBecas' => $nombreBecas,
            'nombreAreas' => $nombreAreas,
            'nombreDiscapacidades' => $nombreDiscapacidades,
            'nombreEstadoCivil' => $nombreEstadoCivil,
            'nombreGeneraciones' => $nombreGeneraciones,
            'nombreGeneros' => $nombreGeneros,
            'nombreHistorialStatus' => $nombreHistorialStatus,
            'nombreModalidades' => $nombreModalidades,
            'nombreParentescos' => $nombreParentescos,
            'nombreRoles' => $nombreRoles,
            'nombreTiposSangre' => $nombreTiposSangre,
            'nombreTurnos' => $nombreTurnos,
            'nombreTiposEscuela' => $nombreTiposEscuela,
            'nombreTiposCompetencia' => $nombreTiposCompetencia,
        ]);
    }

    public function store(Request $request)
    {
        $tabla = $request->input('tabla');
        $model = $this->getModel($tabla);
        $data = $request->only(['nombre', 'nombres', 'duracion', 'descripcion', 'incorporacion']);
        $model::create($data);

        return back()
            ->with('success', 'Registro agregado correctamente.')
            ->with('activeTab', $tabla);
    }

    public function update(Request $request, $id)
    {
        $tabla = $request->input('tabla');
        $model = $this->getModel($tabla)::find($id);
        $model->update($request->only(['nombre', 'nombres', 'duracion', 'descripcion', 'incorporacion']));

        return back()
            ->with('success', 'Registro actualizado correctamente.')
            ->with('activeTab', $tabla);
    }

    public function destroy(Request $request, $id)
    {
        $tabla = $request->input('tabla');
        $model = $this->getModel($tabla)::find($id);
        $model->delete();

        return back()
            ->with('success', 'Registro eliminado correctamente.')
            ->with('activeTab', $tabla);
    }

    private function getModel($tabla)
    {
        return match ($tabla) {
            'evaluaciones' => Evaluacion::class,
            'periodos' => TipoPeriodo::class,
            'status' => StatusAcademico::class,
            'estados' => Estado::class,
            'distritos' => Distrito::class,
            'lenguas' => LenguaIndigena::class,
            'subsistemas' => Subsistema::class,
            'becas' => Beca::class,
            'areas' => AreaEspecializacion::class,
            'discapacidades' => Discapacidad::class,
            'estadoCivil' => EstadoCivil::class,
            'generaciones' => Generacion::class,
            'generos' => Genero::class,
            'historialStatus' => HistorialStatus::class,
            'modalidades' => Modalidad::class,
            'parentescos' => Parentesco::class,
            'roles' => Rol::class,
            'tiposSangre' => TipoSangre::class,
            'turnos' => Turno::class,
            'tiposEscuela' => TipoEscuela::class,
            'tiposCompetencia' => TipoCompetencia::class,
            default => abort(404, 'Tabla no válida'),
        };
    }
}