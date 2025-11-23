<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\AreaEspecializacion;
use App\Models\Beca;
use App\Models\Carrera;
use App\Models\StatusAcademico;
use Illuminate\Http\Request;
use App\Models\TipoSangre;
use App\Models\EstadoCivil;
use App\Models\Genero;
use App\Models\LenguaIndigena;
use App\Models\Discapacidad;
use App\Models\Distrito;
use App\Models\EscuelaProcedencia;
use App\Models\Tutor;
use App\Models\DomicilioAlumno;
use App\Models\DomicilioTutor;
use App\Models\Estado;
use App\Models\Generacion;
use App\Models\HistorialStatus;
use App\Models\Parentesco;
use App\Models\PlanEstudio;
use App\Models\Subsistema;
use App\Models\TipoEscuela;
use Illuminate\Support\Facades\Validator;

class AlumnoController extends Controller
{
    /**
     * Mostrar listado de alumnos con sus datos personales y académicos
     */
    public function index(Request $request)
{
    // Iniciamos la consulta base con relaciones
    $query = Alumno::with(['datosPersonales', 'datosAcademicos', 'statusAcademico', 'generaciones']);

   // 🔹 Filtro general (por matrícula o nombre)
if ($request->filled('busqueda')) {
    $busqueda = $request->busqueda;

    $query->where(function ($q) use ($busqueda) {
        $q->whereHas('datosAcademicos', function ($q2) use ($busqueda) {
            $q2->where('matricula', 'LIKE', '%' . $busqueda . '%');
        })
        ->orWhereHas('datosPersonales', function ($q3) use ($busqueda) {
            $q3->where('nombres', 'LIKE', '%' . $busqueda . '%')
               ->orWhere('primer_apellido', 'LIKE', '%' . $busqueda . '%')
               ->orWhere('segundo_apellido', 'LIKE', '%' . $busqueda . '%');
        });
    });
}


    // 🔹 Filtro por carrera
    if ($request->filled('id_carrera')) {
        $query->whereHas('datosAcademicos', function ($q) use ($request) {
            $q->where('id_carrera', $request->id_carrera);
        });
    }

    // 🔹 Filtro por estatus académico
    if ($request->filled('estatus')) {
        $query->where('estatus', $request->estatus);
    }

    // 🔹 Orden descendente por ID
    $query->orderByDesc('id_alumno');

    // 🔹 Mostrar todo o paginar
    $mostrar = $request->get('mostrar', 10); // Por defecto 10
    if ($mostrar === "todo") {
        $alumnos = $query->get();
    } else {
        $alumnos = $query->paginate((int)$mostrar)->appends($request->all());
    }

    // 🔹 Datos complementarios
    $estatus = HistorialStatus::all();
    $generaciones = Generacion::all();
    $carreras = Carrera::all();
    $planes = PlanEstudio::all();
    $tipos_sangre = TipoSangre::all();
    $estados_civiles = EstadoCivil::all();
    $generos = Genero::all();
    $lenguas = LenguaIndigena::all();
    $discapacidades = Discapacidad::all();
    $domicilios = DomicilioAlumno::with(['distritos','estados']);
    $escuelas = EscuelaProcedencia::with(['areaEspecializacion', 'subsistemas', 'estados', 'becas', 'tiposEscuela'])->get();
    $subsistemas = Subsistema::all(); 
    $areaEspecializacion = AreaEspecializacion::all(); 
    $estados = Estado::all(); 
    $distritos = Distrito::all();
    $becas = Beca::all();
    $tiposEscuela = TipoEscuela::all();
    $tutores = Tutor::with(['parentescos']);
    $domiciliosTutor = DomicilioTutor::with(['distritos','estados']);
    $parentescos = Parentesco::all();

    // 🔹 Retornar vista con todos los datos
    return view('alumnos.alumnos', compact(
        'alumnos',
        'estatus',
        'carreras',
        'planes',
        'tipos_sangre',
        'estados_civiles',
        'generos',
        'lenguas',
        'discapacidades',
        'escuelas',
        'tutores',
        'domicilios',
        'subsistemas',
        'areaEspecializacion',
        'estados',
        'becas',
        'tiposEscuela',
        'parentescos',
        'distritos',
        'generaciones'
    ));
}



    public function create()
{
    $alumnos = \App\Models\Alumno::all();
    $estatus = \App\Models\HistorialStatus::all();
    return view('alumnos.create', compact('alumnos', 'estatus'));
}

public function store(Request $request)
{

    $validator = Validator::make($request->all(), [
            // Datos personales
            'datos_personales.nombres' => 'required|string|max:100',
            'datos_personales.primer_apellido' => 'required|string|max:100',
            'curp' => 'nullable|string|size:18|unique:datos_personales,curp',
            'fecha_nacimiento' => 'nullable|date',
            'id_estado_civil' => 'nullable|exists:estados_civiles,id_estado_civil',
            'id_genero' => 'nullable|exists:generos,id_genero',
            'id_tipo_sangre' => 'nullable|exists:tipos_sangre,id_tipo_sangre',
            'id_lengua_indigena' => 'nullable|exists:lenguas_indigenas,id_lengua_indigena',
            'id_discapacidad' => 'nullable|exists:discapacidades,id_discapacidad',
            'correo' => 'nullable|email|max:255',
            'datos_personales.telefono' => 'nullable|string|regex:/^[0-9]{10}$/',
            'numero_seguridad_social' => 'nullable|string|size:11',

            // Domicilio alumno
            'domicilio_alumno.calle' => 'required|string|max:255',
            'domicilio_alumno.colonia' => 'required|string|max:255',
            'domicilio_alumno.comunidad' => 'required|string|max:255',
            'domicilio_alumno.municipio' => 'required|string|max:100',
            'domicilio_alumno.id_estado' => 'required|exists:estados,id_estado',
            'codigo_postal' => 'nullable|integer|digits:5',

            // Escuela procedencia
            'promedio_egreso' => 'required|numeric|min:0|max:10',
            'id_subsistema' => 'nullable|exists:subsistemas,id_subsistema',
            'id_tipo_escuela' => 'nullable|exists:tipos_escuela,id_tipo_escuela',
            'id_area_especializacion' => 'nullable|exists:areas_especializacion,id_area_especializacion',
            'escuela.id_estado' => 'nullable|exists:estados,id_estado',
            'escuela.localidad' => 'nullable|string|max:255',
            'id_beca' => 'nullable|exists:becas,id_beca',

            // Tutor
            'tutor.nombres' => 'nullable|string|max:255',
            'id_parentesco' => 'nullable|exists:parentescos,id_parentesco',
            'tutor.telefono' => 'nullable|string|regex:/^[0-9]{10}$/',
            'domicilio_tutor.calle' => 'nullable|string|max:255',
            'domicilio_tutor.colonia' => 'nullable|string|max:255',
            'domicilio_tutor.municipio' => 'nullable|string|max:100',
            'domicilio_tutor.id_estado' => 'nullable|exists:estados,id_estado',

            // Estatus académico
            'id_historial_status' => 'required|exists:historial_status,id_historial_status',
            'matricula' => 'nullable|string|max:50|unique:datos_academicos,matricula',
            'id_carrera' => 'required_if:id_historial_status,1,2,3,4,5,6,8,9|exists:carreras,id_carrera',
            'id_plan_estudio' => 'nullable|exists:planes_estudio,id_plan_estudio',
            'id_generacion' => 'nullable|exists:generaciones,id_generacion',
            'servicios_social' => 'nullable|in:0,1',
        ], [
            'datos_personales.nombres.required' => 'El nombre es obligatorio.',
            'datos_personales.primer_apellido.required' => 'El primer apellido es obligatorio.',
            'curp.size' => 'La CURP debe tener 18 caracteres.',
            'curp.unique' => 'Ya existe un alumno con esa CURP.',
            'promedio_egreso.required' => 'El promedio de egreso es obligatorio.',
            'promedio_egreso.min' => 'El promedio debe ser al menos 0.',
            'promedio_egreso.max' => 'El promedio no puede ser mayor a 10.',
            'correo.email' => 'El correo electrónico no es válido.',
            'datos_personales.telefono.regex' => 'El teléfono debe tener 10 dígitos numéricos.',
            'numero_seguridad_social.size' => 'El N° de Seguridad Social debe tener 11 dígitos.',
            'domicilio_alumno.calle.required' => 'La calle del domicilio es obligatoria.',
            'domicilio_alumno.colonia.required' => 'La colonia es obligatoria.',
            'domicilio_alumno.comunidad.required' => 'La comunidad es obligatoria.',
            'domicilio_alumno.municipio.required' => 'El municipio es obligatorio.',
            'domicilio_alumno.id_estado.required' => 'El estado del domicilio es obligatorio.',
            'codigo_postal.digits' => 'El código postal debe tener 5 dígitos.',
            'id_historial_status.required' => 'El estatus académico es obligatorio.',
            'id_historial_status.exists' => 'El estatus seleccionado no es válido.',
            'id_carrera.required_if' => 'La carrera es obligatoria para este estatus académico.',
            'matricula.unique' => 'Ya existe un alumno con esa matrícula.',
            'servicios_social.in' => 'El valor de Servicio Social no es válido.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('alumnos.index')
                ->withErrors($validator)
                ->withInput()
                ->with('is_create_alumno', 1);
        }
    // 🔹 Crear domicilio del alumno
    $domicilioAlumno = \App\Models\DomicilioAlumno::create([
        'calle' => $request->domicilio_alumno['calle'] ?? null,
        'numero_exterior' => $request->domicilio_alumno['numero_exterior'] ?? null,
        'numero_interior' => $request->domicilio_alumno['numero_interior'] ?? null,
        'colonia' => $request->domicilio_alumno['colonia'] ?? null,
        'comunidad' => $request->domicilio_alumno['comunidad'] ?? null,
        'id_distrito' => $request->domicilio_alumno['id_distrito'] ?? null,
        'id_estado' => $request->domicilio_alumno['id_estado'] ?? null,
        'municipio' => $request->domicilio_alumno['municipio'] ?? null,
        'codigo_postal' => $request->codigo_postal ?? null,
    ]);

    // 🔹 Crear escuela de procedencia
    $escuelaProcedencia = \App\Models\EscuelaProcedencia::create([
        'id_subsistema' => $request->id_subsistema ?? null,
        'id_tipo_escuela' => $request->id_tipo_escuela ?? null,
        'id_area_especializacion' => $request->id_area_especializacion ?? null,
        'id_estado' => $request->escuela['id_estado'] ?? null,
        'localidad' => $request->escuela['localidad'] ?? null,
        'id_beca' => $request->id_beca ?? null,
        'promedio_egreso' => $request->promedio_egreso ?? null,
    ]);

    // 🔹 Crear domicilio del tutor
    $domicilioTutor = \App\Models\DomicilioTutor::create([
        'calle' => $request->domicilio_tutor['calle'] ?? null,
        'numero_exterior' => $request->domicilio_tutor['numero_exterior'] ?? null,
        'numero_interior' => $request->domicilio_tutor['numero_interior'] ?? null,
        'colonia' => $request->domicilio_tutor['colonia'] ?? null,
        'municipio' => $request->domicilio_tutor['municipio'] ?? null,
        'id_distrito' => $request->domicilio_tutor['id_distrito'] ?? null,
        'id_estado' => $request->domicilio_tutor['id_estado'] ?? null,
    ]);

    // 🔹 Crear tutor
    $tutor = \App\Models\Tutor::create([
        'nombres' => $request->tutor['nombres'] ?? null,
        'id_parentesco' => $request->id_parentesco ?? null,
        'telefono' => $request->tutor['telefono'] ?? null,
        'id_domicilio_tutor' => $domicilioTutor->id_domicilio_tutor,
    ]);

    // 🔹 Crear datos personales del alumno (ahora ya tenemos el tutor creado)
    $datosPersonales = \App\Models\DatosPersonales::create([
        'nombres' => $request->datos_personales['nombres'] ?? null,
        'primer_apellido' => $request->datos_personales['primer_apellido'] ?? null,
        'segundo_apellido' => $request->datos_personales['segundo_apellido'] ?? null,
        'telefono' => $request->datos_personales['telefono'] ?? $request->telefono ?? null,
        'curp' => $request->curp ?? null,
        'correo' => $request->correo ?? null,
        'fecha_nacimiento' => $request->fecha_nacimiento ?? null,
        'edad' => $request->edad ?? null,
        'lugar_nacimiento' => $request->lugar_nacimiento ?? null,
        'estado_nacimiento' => $request->estado_nacimiento ?? null,
        'id_estado_civil' => $request->id_estado_civil ?? null,
        'id_tipo_sangre' => $request->id_tipo_sangre ?? null,
        'id_lengua_indigena' => $request->id_lengua_indigena ?? null,
        'id_discapacidad' => $request->id_discapacidad ?? null,
        'id_genero' => $request->id_genero ?? null,
        'numero_seguridad_social' => $request->numero_seguridad_social ?? null,
        'hijos' => $request->hijos ?? 0,
        'id_domicilio_alumno' => $domicilioAlumno->id_domicilio_alumno,
        'id_datos_escuela_procedencia' => $escuelaProcedencia->id_datos_escuela_procedencia,
        'id_datos_tutor' => $tutor->id_datos_tutor, 
    ]);

    // 🔹 Crear datos académicos (si aplica)
    $datosAcademicos = null;
    if ($request->filled('matricula') && $request->filled('id_carrera')) {
        $datosAcademicos = \App\Models\DatosAcademicos::create([
            'matricula' => $request->matricula,
            'id_carrera' => $request->id_carrera,
            'id_plan_estudio' => $request->id_plan_estudio ?? null,
            'semestre' => $request->semestre ?? null,
        ]);
    }

    // 🔹 Crear alumno principal
    $alumno = \App\Models\Alumno::create([
        'id_datos_personales' => $datosPersonales->id_datos_personales,
        'id_datos_academicos' => $datosAcademicos?->id_datos_academicos,
        'estatus' => $request->id_historial_status ?? null,
        'id_generacion' => $request->id_generacion ?? null,
        'id_datos_tutor' => $tutor->id_datos_tutor,
        'servicios_social' => $request->servicios_social ?? null,
    ]);

    return redirect()->route('alumnos.index')
                     ->with('success', 'Alumno agregado correctamente.');
}

    /**
     * Mostrar información de un solo alumno
     */
   public function show($id)
{
    $alumno = Alumno::with([
        'datosPersonales',
        'datosPersonales.estadoCivil',
        'datosPersonales.tipoSangre',
        'datosPersonales.genero',
        'datosPersonales.lenguaIndigena',
        'datosPersonales.discapacidad',
        'datosPersonales.estadoNacimiento',
        'datosPersonales.domicilioAlumno.distritos',
        'datosPersonales.domicilioAlumno.estados',
        'datosAcademicos.carrera',
        'datosAcademicos.planEstudio',
        'statusAcademico',
        'generaciones',
        'tutor',
        'tutor.parentescos',
        'tutor.domiciliosTutor.distritos',
        'tutor.domiciliosTutor.estados',
        'escuelaProcedencia.estados',
        'escuelaProcedencia.tiposEscuela',
        'escuelaProcedencia.becas',
        'escuelaProcedencia.subsistemas'
    ])->findOrFail($id);

    return view('alumnos.show', compact('alumno'));
}

/**
 * Actualizar información del alumno
 */
public function update(Request $request, $id)
{
    // Buscar el alumno
    $alumno = Alumno::findOrFail($id);


    $validator = Validator::make($request->all(), [
            // Datos personales
            'datos_personales.nombres' => 'required|string|max:100',
            'datos_personales.primer_apellido' => 'required|string|max:100',
            'curp' => 'nullable|string|size:18|unique:datos_personales,curp,' . optional($alumno->datosPersonales)->id_datos_personales . ',id_datos_personales',
            'fecha_nacimiento' => 'nullable|date',
            'id_estado_civil' => 'nullable|exists:estados_civiles,id_estado_civil',
            'id_genero' => 'nullable|exists:generos,id_genero',
            'id_tipo_sangre' => 'nullable|exists:tipos_sangre,id_tipo_sangre',
            'id_lengua_indigena' => 'nullable|exists:lenguas_indigenas,id_lengua_indigena',
            'id_discapacidad' => 'nullable|exists:discapacidades,id_discapacidad',
            'correo' => 'nullable|email|max:255',
            'datos_personales.telefono' => 'nullable|string|regex:/^[0-9]{10}$/',
            'numero_seguridad_social' => 'nullable|string|size:11',

            // Domicilio alumno
            'domicilio_alumno.calle' => 'required|string|max:255',
            'domicilio_alumno.colonia' => 'required|string|max:255',
            'domicilio_alumno.comunidad' => 'required|string|max:255',
            'domicilio_alumno.municipio' => 'required|string|max:100',
            'domicilio_alumno.id_estado' => 'required|exists:estados,id_estado',
            'codigo_postal' => 'nullable|integer|digits:5',

            // Escuela procedencia
            'promedio_egreso' => 'required|numeric|min:0|max:10',
            'id_subsistema' => 'nullable|exists:subsistemas,id_subsistema',
            'id_tipo_escuela' => 'nullable|exists:tipos_escuela,id_tipo_escuela',
            'id_area_especializacion' => 'nullable|exists:areas_especializacion,id_area_especializacion',
            'escuela.id_estado' => 'nullable|exists:estados,id_estado',
            'escuela.localidad' => 'nullable|string|max:255',
            'id_beca' => 'nullable|exists:becas,id_beca',

            // Tutor
            'tutor.nombres' => 'nullable|string|max:255',
            'id_parentesco' => 'nullable|exists:parentescos,id_parentesco',
            'tutor.telefono' => 'nullable|string|regex:/^[0-9]{10}$/',
            'domicilio_tutor.calle' => 'nullable|string|max:255',
            'domicilio_tutor.colonia' => 'nullable|string|max:255',
            'domicilio_tutor.municipio' => 'nullable|string|max:100',
            'domicilio_tutor.id_estado' => 'nullable|exists:estados,id_estado',

            // Estatus académico
            'id_historial_status' => 'required|exists:historial_status,id_historial_status',
            'matricula' => 'nullable|string|max:50|unique:datos_academicos,matricula,' . optional($alumno->datosAcademicos)->id_datos_academicos . ',id_datos_academicos',
            'id_carrera' => 'required_if:id_historial_status,1,2,3,4,5,6,8,9|exists:carreras,id_carrera',
            'id_plan_estudio' => 'nullable|exists:planes_estudio,id_plan_estudio',
            'id_generacion' => 'nullable|exists:generaciones,id_generacion',
            'servicios_social' => 'nullable|in:0,1',
        ], [
            'datos_personales.nombres.required' => 'El nombre es obligatorio.',
            'datos_personales.primer_apellido.required' => 'El primer apellido es obligatorio.',
            'curp.size' => 'La CURP debe tener 18 caracteres.',
            'curp.unique' => 'Ya existe un alumno con esa CURP.',
            'promedio_egreso.required' => 'El promedio de egreso es obligatorio.',
            'promedio_egreso.min' => 'El promedio debe ser al menos 0.',
            'promedio_egreso.max' => 'El promedio no puede ser mayor a 10.',
            'correo.email' => 'El correo electrónico no es válido.',
            'datos_personales.telefono.regex' => 'El teléfono debe tener 10 dígitos numéricos.',
            'numero_seguridad_social.size' => 'El N° de Seguridad Social debe tener 11 dígitos.',
            'domicilio_alumno.calle.required' => 'La calle del domicilio es obligatoria.',
            'domicilio_alumno.colonia.required' => 'La colonia es obligatoria.',
            'domicilio_alumno.comunidad.required' => 'La comunidad es obligatoria.',
            'domicilio_alumno.municipio.required' => 'El municipio es obligatorio.',
            'domicilio_alumno.id_estado.required' => 'El estado del domicilio es obligatorio.',
            'codigo_postal.digits' => 'El código postal debe tener 5 dígitos.',
            'id_historial_status.required' => 'El estatus académico es obligatorio.',
            'id_historial_status.exists' => 'El estatus seleccionado no es válido.',
            'id_carrera.required_if' => 'La carrera es obligatoria para este estatus académico.',
            'matricula.unique' => 'Ya existe un alumno con esa matrícula.',
            'servicios_social.in' => 'El valor de Servicio Social no es válido.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('alumnos.index')
                ->withErrors($validator)
                ->withInput()
                ->with('alumno_id', $id);
        }
    // 🔹 Actualizar domicilio del alumno
    if ($alumno->datosPersonales && $alumno->datosPersonales->domicilioAlumno) {
        $alumno->datosPersonales->domicilioAlumno->update([
            'calle' => $request->domicilio_alumno['calle'] ?? null,
            'numero_exterior' => $request->domicilio_alumno['numero_exterior'] ?? null,
            'numero_interior' => $request->domicilio_alumno['numero_interior'] ?? null,
            'colonia' => $request->domicilio_alumno['colonia'] ?? null,
            'comunidad' => $request->domicilio_alumno['comunidad'] ?? null,
            'id_distrito' => $request->domicilio_alumno['id_distrito'] ?? null,
            'id_estado' => $request->domicilio_alumno['id_estado'] ?? null,
            'municipio' => $request->domicilio_alumno['municipio'] ?? null,
            'codigo_postal' => $request->codigo_postal ?? null,
        ]);
    } else {
        // Crear domicilio si no existe
        $domicilioAlumno = DomicilioAlumno::create([
            'calle' => $request->domicilio_alumno['calle'] ?? null,
            'numero_exterior' => $request->domicilio_alumno['numero_exterior'] ?? null,
            'numero_interior' => $request->domicilio_alumno['numero_interior'] ?? null,
            'colonia' => $request->domicilio_alumno['colonia'] ?? null,
            'comunidad' => $request->domicilio_alumno['comunidad'] ?? null,
            'id_distrito' => $request->domicilio_alumno['id_distrito'] ?? null,
            'id_estado' => $request->domicilio_alumno['id_estado'] ?? null,
            'municipio' => $request->domicilio_alumno['municipio'] ?? null,
            'codigo_postal' => $request->codigo_postal ?? null,
        ]);
        
        if ($alumno->datosPersonales) {
            $alumno->datosPersonales->update([
                'id_domicilio_alumno' => $domicilioAlumno->id_domicilio_alumno
            ]);
        }
    }

    // 🔹 Actualizar datos personales del alumno
    if ($alumno->datosPersonales) {
        $alumno->datosPersonales->update([
            'nombres' => $request->datos_personales['nombres'] ?? null,
            'primer_apellido' => $request->datos_personales['primer_apellido'] ?? null,
            'segundo_apellido' => $request->datos_personales['segundo_apellido'] ?? null,
            'telefono' => $request->telefono ?? null,
            'curp' => $request->curp ?? null,
            'correo' => $request->correo ?? null,
            'fecha_nacimiento' => $request->fecha_nacimiento ?? null,
            'edad' => $request->edad ?? null,
            'lugar_nacimiento' => $request->lugar_nacimiento ?? null,
            'estado_nacimiento' => $request->estado_nacimiento ?? null,
            'id_estado_civil' => $request->id_estado_civil ?? null,
            'id_tipo_sangre' => $request->id_tipo_sangre ?? null,
            'id_lengua_indigena' => $request->id_lengua_indigena ?? null,
            'id_discapacidad' => $request->id_discapacidad ?? null,
            'id_genero' => $request->id_genero ?? null,
            'numero_seguridad_social' => $request->numero_seguridad_social ?? null,
            'hijos' => $request->hijos ?? 0,
        ]);
    }

    // 🔹 Actualizar domicilio del tutor
    if ($alumno->tutor && $alumno->tutor->domiciliosTutor) {
        $alumno->tutor->domiciliosTutor->update([
            'calle' => $request->domicilio_tutor['calle'] ?? null,
            'numero_exterior' => $request->domicilio_tutor['numero_exterior'] ?? null,
            'numero_interior' => $request->domicilio_tutor['numero_interior'] ?? null,
            'colonia' => $request->domicilio_tutor['colonia'] ?? null,
            'municipio' => $request->domicilio_tutor['municipio'] ?? null,
            'id_distrito' => $request->domicilio_tutor['id_distrito'] ?? null,
            'id_estado' => $request->domicilio_tutor['id_estado'] ?? null,
        ]);
    } else if ($alumno->tutor && $request->filled('domicilio_tutor')) {
        // Crear domicilio del tutor si no existe
        $domicilioTutor = DomicilioTutor::create([
            'calle' => $request->domicilio_tutor['calle'] ?? null,
            'numero_exterior' => $request->domicilio_tutor['numero_exterior'] ?? null,
            'numero_interior' => $request->domicilio_tutor['numero_interior'] ?? null,
            'colonia' => $request->domicilio_tutor['colonia'] ?? null,
            'municipio' => $request->domicilio_tutor['municipio'] ?? null,
            'id_distrito' => $request->domicilio_tutor['id_distrito'] ?? null,
            'id_estado' => $request->domicilio_tutor['id_estado'] ?? null,
        ]);
        
        $alumno->tutor->update([
            'id_domicilio_tutor' => $domicilioTutor->id_domicilio_tutor
        ]);
    }

    // 🔹 Actualizar datos del tutor
    if ($alumno->tutor) {
        $alumno->tutor->update([
            'nombres' => $request->tutor['nombres'] ?? null,
            'id_parentesco' => $request->id_parentesco ?? null,
            'telefono' => $request->tutor['telefono'] ?? null,
        ]);
    } else if ($request->filled('tutor')) {
        // Crear tutor si no existe
        $domicilioTutor = DomicilioTutor::create([
            'calle' => $request->domicilio_tutor['calle'] ?? null,
            'numero_exterior' => $request->domicilio_tutor['numero_exterior'] ?? null,
            'numero_interior' => $request->domicilio_tutor['numero_interior'] ?? null,
            'colonia' => $request->domicilio_tutor['colonia'] ?? null,
            'municipio' => $request->domicilio_tutor['municipio'] ?? null,
            'id_distrito' => $request->domicilio_tutor['id_distrito'] ?? null,
            'id_estado' => $request->domicilio_tutor['id_estado'] ?? null,
        ]);

        $tutor = Tutor::create([
            'nombres' => $request->tutor['nombres'] ?? null,
            'id_parentesco' => $request->id_parentesco ?? null,
            'telefono' => $request->tutor['telefono'] ?? null,
            'id_domicilio_tutor' => $domicilioTutor->id_domicilio_tutor,
        ]);

        $alumno->update([
            'id_datos_tutor' => $tutor->id_datos_tutor
        ]);
    }

    // 🔹 Actualizar o crear datos académicos
    if ($request->filled('matricula') && $request->filled('id_carrera')) {
        if ($alumno->datosAcademicos) {
            $alumno->datosAcademicos->update([
                'matricula' => $request->matricula,
                'id_carrera' => $request->id_carrera,
                'id_plan_estudio' => $request->id_plan_estudio ?? null,
                'semestre' => $request->semestre ?? null,
            ]);
        } else {
            // Crear datos académicos si no existen
            $datosAcademicos = \App\Models\DatosAcademicos::create([
                'matricula' => $request->matricula,
                'id_carrera' => $request->id_carrera,
                'id_plan_estudio' => $request->id_plan_estudio ?? null,
                'semestre' => $request->semestre ?? null,
            ]);

            $alumno->update([
                'id_datos_academicos' => $datosAcademicos->id_datos_academicos
            ]);
        }
    }

    // 🔹 Actualizar datos del alumno principal
    $alumno->update([
        'estatus' => $request->id_historial_status ?? $alumno->estatus,
        'id_generacion' => $request->id_generacion ?? $alumno->id_generacion,
        'servicios_social' => $request->servicios_social ?? $alumno->servicios_social,
    ]);

    return redirect()->route('alumnos.index')
                     ->with('success', 'Alumno actualizado correctamente.');
}

/**
 * Eliminar un alumno
 */
public function destroy($id)
{
    $alumno = Alumno::findOrFail($id);
    
    // Eliminar registros relacionados si es necesario
    // (dependiendo de tu configuración de cascada en la BD)
    
    $alumno->delete();
    
    return redirect()->route('alumnos.index')
                     ->with('success', 'Alumno eliminado correctamente.');
}


}