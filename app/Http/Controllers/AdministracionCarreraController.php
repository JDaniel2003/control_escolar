<?php

namespace App\Http\Controllers;

use App\Models\AdministracionCarrera;
use App\Models\Area;
use App\Models\Carrera;
use App\Models\User;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdministracionCarreraController extends Controller
{
    public function index(Request $request)
    {
        $query = AdministracionCarrera::with(['area', 'usuario', 'carrera']);

        if ($request->filled('id_carrera')) {
            $query->where('id_carrera', $request->id_carrera);
        }
        if ($request->filled('id_area')) {
            $query->where('id_area', $request->id_area);
        }
        if ($request->filled('id_usuario')) {
            $query->where('id_usuario', $request->id_usuario);
        }

        $mostrar = $request->get('mostrar', 10);
    if ($mostrar === "todo") {
        $administraciones = $query->get();
    } else {
        $administraciones = $query->paginate((int)$mostrar)->appends($request->all());
    }

        $areas = Area::all();
        $carreras = Carrera::all();
        $usuarios = Usuario::all();

        return view('administracion_carreras.index', compact(
            'administraciones', 'areas', 'carreras', 'usuarios'
        ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_area' => 'required|exists:areas,id_area',
            'id_usuario' => 'required|exists:usuarios,id_usuario',
            'id_carrera' => 'required|exists:carreras,id_carrera|unique:administracion_carreras,id_carrera,NULL,id_administracion_carrera,id_area,' . $request->id_area . ',id_usuario,' . $request->id_usuario,
        ], [
            'id_area.required' => 'El área es obligatoria.',
            'id_area.exists' => 'El área seleccionada no es válida.',
            'id_usuario.required' => 'El usuario es obligatorio.',
            'id_usuario.exists' => 'El usuario seleccionado no es válido.',
            'id_carrera.required' => 'La carrera es obligatoria.',
            'id_carrera.exists' => 'La carrera seleccionada no es válida.',
            'id_carrera.unique' => 'Ya existe una administración para esta combinación de área, usuario y carrera.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('administracion-carreras.index')
                ->withErrors($validator)
                ->withInput()
                ->with('is_create_admin', 1);
        }

        AdministracionCarrera::create($request->all());

        return redirect()->route('administracion-carreras.index')
            ->with('success', 'Administración de carrera creada correctamente.');
    }

    public function update(Request $request, $id)
    {
        $admin = AdministracionCarrera::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'id_area' => 'required|exists:areas,id_area',
            'id_usuario' => 'required|exists:usuarios,id_usuario',
            'id_carrera' => 'required|exists:carreras,id_carrera|unique:administracion_carreras,id_carrera,' . $admin->id_administracion_carrera . ',id_administracion_carrera,id_area,' . $request->id_area . ',id_usuario,' . $request->id_usuario,
        ], [
            'id_area.required' => 'El área es obligatoria.',
            'id_area.exists' => 'El área seleccionada no es válida.',
            'id_usuario.required' => 'El usuario es obligatorio.',
            'id_usuario.exists' => 'El usuario seleccionado no es válido.',
            'id_carrera.required' => 'La carrera es obligatoria.',
            'id_carrera.exists' => 'La carrera seleccionada no es válida.',
            'id_carrera.unique' => 'Ya existe una administración para esta combinación de área, usuario y carrera.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('administracion-carreras.index')
                ->withErrors($validator)
                ->withInput()
                ->with('admin_id', $id);
        }

        $admin->update($request->all());

        return redirect()->route('administracion-carreras.index')
            ->with('success', 'Administración de carrera actualizada correctamente.');
    }

    public function destroy($id)
    {
        $admin = AdministracionCarrera::findOrFail($id);
        $admin->delete();

        return redirect()->route('administracion-carreras.index')
            ->with('success', 'Administración de carrera eliminada correctamente.');
    }
}