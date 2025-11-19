<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\DatosDocente;
use App\Models\Genero;
use App\Models\DomicilioDocente;
use App\Models\Usuario; // Cambiado de User a Usuario
use App\Models\Distrito;
use App\Models\Estado;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DocentesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $docentes = Docente::with(['datosDocentes', 'usuario'])->get();
        
        // Para el modal de creación necesitamos estas variables
        $generos = Genero::all();
        $distritos = Distrito::all();
        $estados = Estado::all();
        $usuarios = Usuario::with('rol')->get(); // Cambiado a Usuario
        $roles = Rol::all();
        
        return view('docente.index', compact('docentes', 'generos', 'distritos', 'estados', 'usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $generos = Genero::all();
        $distritos = Distrito::all();
        $estados = Estado::all();
        $usuarios = Usuario::with('rol')->get(); // Cambiado a Usuario
        
        return view('docentes.create', compact('generos', 'distritos', 'estados', 'usuarios','roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            // Datos del docente (tabla docentes)
            'especialidad' => 'required|string|max:100',
            'datos' => 'nullable|json',
            'id_usuario' => 'nullable|exists:usuarios,id_usuario', // Cambiado a 'usuarios'
            
            // Datos personales (tabla datos_docentes)
            'datos_docentes.nombre' => 'required|string|max:100',
            'datos_docentes.apellido_paterno' => 'required|string|max:50',
            'datos_docentes.apellido_materno' => 'nullable|string|max:50',
            'datos_docentes.edad' => 'nullable|integer|min:18|max:100',
            'datos_docentes.id_genero' => 'required|exists:generos,id_genero',
            'datos_docentes.fecha_nacimiento' => 'required|date',
            'datos_docentes.cedula_profesional' => 'required|string|size:7|unique:datos_docentes,cedula_profesional',
            'datos_docentes.rfc' => 'required|string|size:13|unique:datos_docentes,rfc',
            'datos_docentes.telefono' => 'required|string|size:10',
            'datos_docentes.correo' => 'required|email|max:100|unique:datos_docentes,correo',
            'datos_docentes.curp' => 'required|string|size:18|unique:datos_docentes,curp',
            'datos_docentes.numero_seguridad_social' => 'nullable|string|size:11|unique:datos_docentes,numero_seguridad_social',
            'datos_docentes.datos' => 'nullable|json',
            
            // Domicilio (tabla domicilios_docentes)
            'domicilio_docente.calle' => 'required|string|max:100',
            'domicilio_docente.numero_exterior' => 'nullable|string|max:4',
            'domicilio_docente.numero_interior' => 'nullable|string|max:4',
            'domicilio_docente.codigo_postal' => 'nullable|string|size:5',
            'domicilio_docente.id_distrito' => 'nullable|exists:distritos,id_distrito',
            'domicilio_docente.id_estado' => 'required|exists:estado,id_estado',
            'domicilio_docente.municipio' => 'required|string|max:100',
            'domicilio_docente.colonia' => 'required|string|max:100',
            'domicilio_docente.datos' => 'nullable|json',
        ]);

        DB::beginTransaction();

        try {
            // 1. Crear domicilio
            $domicilio = DomicilioDocente::create([
                'calle' => $request->input('domicilio_docente.calle'),
                'numero_exterior' => $request->input('domicilio_docente.numero_exterior'),
                'numero_interior' => $request->input('domicilio_docente.numero_interior'),
                'codigo_postal' => $request->input('domicilio_docente.codigo_postal'),
                'id_distrito' => $request->input('domicilio_docente.id_distrito'),
                'id_estado' => $request->input('domicilio_docente.id_estado'),
                'municipio' => $request->input('domicilio_docente.municipio'),
                'colonia' => $request->input('domicilio_docente.colonia'),
                'datos' => $request->input('domicilio_docente.datos'),
            ]);

            // 2. Crear datos del docente
            $datosDocente = DatosDocente::create([
                'nombre' => $request->input('datos_docentes.nombre'),
                'apellido_paterno' => $request->input('datos_docentes.apellido_paterno'),
                'apellido_materno' => $request->input('datos_docentes.apellido_materno'),
                'edad' => $request->input('datos_docentes.edad'),
                'id_genero' => $request->input('datos_docentes.id_genero'),
                'fecha_nacimiento' => $request->input('datos_docentes.fecha_nacimiento'),
                'cedula_profesional' => $request->input('datos_docentes.cedula_profesional'),
                'rfc' => $request->input('datos_docentes.rfc'),
                'telefono' => $request->input('datos_docentes.telefono'),
                'correo' => $request->input('datos_docentes.correo'),
                'curp' => $request->input('datos_docentes.curp'),
                'id_domicilio_docente' => $domicilio->id_domicilio_docente,
                'numero_seguridad_social' => $request->input('datos_docentes.numero_seguridad_social'),
                'datos' => $request->input('datos_docentes.datos'),
            ]);

            // 3. Crear docente
            $docente = Docente::create([
                'id_datos_docentes' => $datosDocente->id_datos_docentes,
                'id_usuario' => $request->input('id_usuario'),
                'especialidad' => $request->input('especialidad'),
                'datos' => $request->input('datos'),
            ]);

            DB::commit();

            return redirect()->route('docente.index')
                ->with('success', 'Docente registrado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al registrar el docente: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $docente = Docente::with([
            'datosDocentes.genero',
            'datosDocentes.domicilioDocente',
            'usuario'
        ])->findOrFail($id);
        
        return view('docente.show', compact('docente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $docente = Docente::with([
            'datosDocentes.domicilioDocente',
            'usuario'
        ])->findOrFail($id);
        
        $generos = Genero::all();
        $distritos = Distrito::all();
        $estados = Estado::all();
        $usuarios = Usuario::with('rol')->get(); // Cambiado a Usuario
        
        return view('docentes.edit', compact('docente', 'generos', 'distritos', 'estados', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $docente = Docente::with('datosDocentes')->findOrFail($id);

        $request->validate([
            // Datos del docente (tabla docentes)
            'especialidad' => 'required|string|max:100',
            'datos' => 'nullable|json',
            'id_usuario' => 'nullable|exists:usuarios,id_usuario', // Cambiado a 'usuarios'
            
            // Datos personales (tabla datos_docentes)
            'datos_docentes.nombre' => 'required|string|max:100',
            'datos_docentes.apellido_paterno' => 'required|string|max:50',
            'datos_docentes.apellido_materno' => 'nullable|string|max:50',
            'datos_docentes.edad' => 'nullable|integer|min:18|max:100',
            'datos_docentes.id_genero' => 'required|exists:generos,id_genero',
            'datos_docentes.fecha_nacimiento' => 'required|date',
            'datos_docentes.cedula_profesional' => 'required|string|size:7|unique:datos_docentes,cedula_profesional,' . $docente->id_datos_docentes . ',id_datos_docentes',
            'datos_docentes.rfc' => 'required|string|size:13|unique:datos_docentes,rfc,' . $docente->id_datos_docentes . ',id_datos_docentes',
            'datos_docentes.telefono' => 'required|string|size:10',
            'datos_docentes.correo' => 'required|email|max:100|unique:datos_docentes,correo,' . $docente->id_datos_docentes . ',id_datos_docentes',
            'datos_docentes.curp' => 'required|string|size:18|unique:datos_docentes,curp,' . $docente->id_datos_docentes . ',id_datos_docentes',
            'datos_docentes.numero_seguridad_social' => 'nullable|string|size:11|unique:datos_docentes,numero_seguridad_social,' . $docente->id_datos_docentes . ',id_datos_docentes',
            'datos_docentes.datos' => 'nullable|json',
            
            // Domicilio (tabla domicilios_docentes)
            'domicilio_docente.calle' => 'required|string|max:100',
            'domicilio_docente.numero_exterior' => 'nullable|string|max:4',
            'domicilio_docente.numero_interior' => 'nullable|string|max:4',
            'domicilio_docente.codigo_postal' => 'nullable|string|size:5',
            'domicilio_docente.id_distrito' => 'nullable|exists:distritos,id_distrito',
            'domicilio_docente.id_estado' => 'required|exists:estados,id_estado',
            'domicilio_docente.municipio' => 'required|string|max:100',
            'domicilio_docente.colonia' => 'required|string|max:100',
            'domicilio_docente.datos' => 'nullable|json',
        ]);

        DB::beginTransaction();

        try {
            // 1. Actualizar o crear domicilio
            if ($docente->datosDocentes->id_domicilio_docente) {
                // Actualizar domicilio existente
                DomicilioDocente::where('id_domicilio_docente', $docente->datosDocentes->id_domicilio_docente)
                    ->update([
                        'calle' => $request->input('domicilio_docente.calle'),
                        'numero_exterior' => $request->input('domicilio_docente.numero_exterior'),
                        'numero_interior' => $request->input('domicilio_docente.numero_interior'),
                        'codigo_postal' => $request->input('domicilio_docente.codigo_postal'),
                        'id_distrito' => $request->input('domicilio_docente.id_distrito'),
                        'id_estado' => $request->input('domicilio_docente.id_estado'),
                        'municipio' => $request->input('domicilio_docente.municipio'),
                        'colonia' => $request->input('domicilio_docente.colonia'),
                        'datos' => $request->input('domicilio_docente.datos'),
                    ]);
            } else {
                // Crear nuevo domicilio
                $domicilio = DomicilioDocente::create([
                    'calle' => $request->input('domicilio_docente.calle'),
                    'numero_exterior' => $request->input('domicilio_docente.numero_exterior'),
                    'numero_interior' => $request->input('domicilio_docente.numero_interior'),
                    'codigo_postal' => $request->input('domicilio_docente.codigo_postal'),
                    'id_distrito' => $request->input('domicilio_docente.id_distrito'),
                    'id_estado' => $request->input('domicilio_docente.id_estado'),
                    'municipio' => $request->input('domicilio_docente.municipio'),
                    'colonia' => $request->input('domicilio_docente.colonia'),
                    'datos' => $request->input('domicilio_docente.datos'),
                ]);
                $docente->datosDocentes->id_domicilio_docente = $domicilio->id_domicilio_docente;
                $docente->datosDocentes->save();
            }

            // 2. Actualizar datos del docente
            $docente->datosDocentes->update([
                'nombre' => $request->input('datos_docentes.nombre'),
                'apellido_paterno' => $request->input('datos_docentes.apellido_paterno'),
                'apellido_materno' => $request->input('datos_docentes.apellido_materno'),
                'edad' => $request->input('datos_docentes.edad'),
                'id_genero' => $request->input('datos_docentes.id_genero'),
                'fecha_nacimiento' => $request->input('datos_docentes.fecha_nacimiento'),
                'cedula_profesional' => $request->input('datos_docentes.cedula_profesional'),
                'rfc' => $request->input('datos_docentes.rfc'),
                'telefono' => $request->input('datos_docentes.telefono'),
                'correo' => $request->input('datos_docentes.correo'),
                'curp' => $request->input('datos_docentes.curp'),
                'numero_seguridad_social' => $request->input('datos_docentes.numero_seguridad_social'),
                'datos' => $request->input('datos_docentes.datos'),
            ]);

            // 3. Actualizar docente
            $docente->update([
                'especialidad' => $request->input('especialidad'),
                'id_usuario' => $request->input('id_usuario'),
                'datos' => $request->input('datos'),
            ]);

            DB::commit();

            return redirect()->route('docentes.index')
                ->with('success', 'Docente actualizado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar el docente: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();

        try {
            $docente = Docente::with('datosDocentes')->findOrFail($id);
            
            // Guardar IDs antes de eliminar
            $datosDocenteId = $docente->id_datos_docentes;
            $domicilioId = $docente->datosDocentes->id_domicilio_docente ?? null;
            $usuarioId = $docente->id_usuario;

            // 1. Eliminar docente
            $docente->delete();

            // 2. Eliminar datos del docente
            if ($datosDocenteId) {
                DatosDocente::destroy($datosDocenteId);
            }

            // 3. Eliminar domicilio si existe
            if ($domicilioId) {
                DomicilioDocente::destroy($domicilioId);
            }

            // NOTA: No eliminamos el usuario para evitar problemas de integridad
            // con otras partes del sistema

            DB::commit();

            return redirect()->route('docentes.index')
                ->with('success', 'Docente eliminado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al eliminar el docente: ' . $e->getMessage());
        }
    }

    /**
     * Buscar docentes por nombre o cédula
     */
    public function buscar(Request $request)
    {
        $busqueda = $request->input('busqueda');
        
        $docentes = Docente::with(['datosDocentes', 'usuario'])
            ->whereHas('datosDocentes', function($query) use ($busqueda) {
                $query->where('nombre', 'LIKE', "%{$busqueda}%")
                      ->orWhere('apellido_paterno', 'LIKE', "%{$busqueda}%")
                      ->orWhere('apellido_materno', 'LIKE', "%{$busqueda}%")
                      ->orWhere('cedula_profesional', 'LIKE', "%{$busqueda}%")
                      ->orWhere('rfc', 'LIKE', "%{$busqueda}%");
            })
            ->orWhere('especialidad', 'LIKE', "%{$busqueda}%")
            ->get();

        // También necesitamos pasar las variables para el modal
        $generos = Genero::all();
        $distritos = Distrito::all();
        $estados = Estado::all();
        $usuarios = Usuario::with('rol')->get(); // Cambiado a Usuario

        return view('docentes.index', compact('docentes', 'generos', 'distritos', 'estados', 'usuarios'));
    }
}