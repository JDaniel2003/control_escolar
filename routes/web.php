<?php

use App\Http\Controllers\PeriodoEscolarController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\PlanEstudioController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\UnidadController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\CatalogosController;
use App\Http\Controllers\AsignacionMasivaController;
use App\Http\Controllers\AsignacionDocenteController;
use App\Http\Controllers\CalificacionController;
use App\Models\Calificacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdministracionCarreraController;
use App\Http\Controllers\CoordinadorController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\DocentesController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\UserController;
use App\Models\AdministracionCarrera;

// Redirigir raíz al login
Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login.post']);

/*
|--------------------------------------------------------------------------
| Rutas Protegidas (Requieren autenticación)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Logout (disponible para todos los usuarios autenticados)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard general - Redirige según nivel
    Route::get('/dashboard', function () {
        $user = auth()->user();

        // Redirigir según nivel
        if ($user->hasLevelOrHigher(5)) {
            return redirect()->route('superadmin.dashboard');
        } elseif ($user->hasLevelOrHigher(4)) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasLevelOrHigher(3)) {
            return redirect()->route('coordinador.dashboard');
        } elseif ($user->hasLevelOrHigher(2)) {
            return redirect()->route('docente.dashboard');
        } else {
            return redirect()->route('estudiante.dashboard');
        }
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | NIVEL 5: SuperAdmin - Acceso total al sistema
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role.level:5'])->prefix('superadmin')->name('superadmin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'superDashboard'])->name('dashboard');
        Route::get('/sistema', [AdminController::class, 'sistema'])->name('sistema');
        Route::get('/roles', [AdminController::class, 'roles'])->name('roles');
    });

    /*
    |--------------------------------------------------------------------------
    | NIVEL 4: Administrador - Gestión completa de usuarios
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role.level:4'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/usuarios', [AdminController::class, 'usuarios'])->name('usuarios');
        Route::get('/reportes', [AdminController::class, 'reportes'])->name('reportes');
        Route::get('/configuracion', [AdminController::class, 'configuracion'])->name('configuracion');
    });

    /*
    |--------------------------------------------------------------------------
    | NIVEL 3: Coordinador - Gestión académica
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role.level:3'])->prefix('coordinador')->name('coordinador.')->group(function () {
        Route::get('/dashboard', [CoordinadorController::class, 'dashboard'])->name('dashboard');
        Route::get('/docentes', [CoordinadorController::class, 'docentes'])->name('docentes');
        Route::get('/horarios', [CoordinadorController::class, 'horarios'])->name('horarios');
        Route::get('/asignaciones', [CoordinadorController::class, 'asignaciones'])->name('asignaciones');
    });

    /*
    |--------------------------------------------------------------------------
    | NIVEL 2: Docente - Gestión de clases y calificaciones
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role.level:2'])->prefix('docente')->name('docente.')->group(function () {
        Route::get('/dashboard', [DocenteController::class, 'dashboard'])->name('dashboard');
        Route::get('/materias', [DocenteController::class, 'materias'])->name('materias');
        Route::get('/estudiantes', [DocenteController::class, 'estudiantes'])->name('estudiantes');
        Route::get('/calificaciones', [DocenteController::class, 'calificaciones'])->name('calificaciones');
        Route::get('/asistencias', [DocenteController::class, 'asistencias'])->name('asistencias');
    });

    /*
    |--------------------------------------------------------------------------
    | NIVEL 1: Estudiante - Vista de información personal
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role.level:1'])->prefix('estudiante')->name('estudiante.')->group(function () {
        Route::get('/dashboard', [EstudianteController::class, 'dashboard'])->name('dashboard');
        Route::get('/materias', [EstudianteController::class, 'materias'])->name('materias');
        Route::get('/calificaciones', [EstudianteController::class, 'calificaciones'])->name('calificaciones');
        Route::get('/horario', [EstudianteController::class, 'horario'])->name('horario');
    });
});




#----------------------login-----------------------
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
#Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
#.......cerrar sesion
Route::post('/logout', function () {
    Auth::logout();
    Session::flush(); // Limpia toda la sesión
    return redirect()->route('login');
})->name('logout');

##============con niveles==============
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::post('/logout', function () {
    Auth::logout();
    Session::flush();
    return redirect()->route('login');
})->name('logout');
#===========================================


Route::get('/admin', function () {
    return view('layouts.admin');
})->name('admin.dashboard')->middleware('auth');



Route::get('/admin', function () {
    return view('layouts.admin');
})->name('admin');



Route::get('/catalogos', [CatalogosController::class, 'index'])->name('catalogos.index');
Route::post('/catalogos', [CatalogosController::class, 'store'])->name('catalogos.store');
Route::put('/catalogos/{id}', [CatalogosController::class, 'update'])->name('catalogos.update');
Route::delete('/catalogos/{id}', [CatalogosController::class, 'destroy'])->name('catalogos.destroy');




Route::get('/periodos', [PeriodoEscolarController::class, 'index'])->name('periodos');
Route::get('/periodos/create', [PeriodoEscolarController::class, 'create'])->name('periodos.create');
Route::post('/periodos', [PeriodoEscolarController::class, 'store'])->name('periodos.store');
Route::get('/periodos/{id}/edit', [PeriodoEscolarController::class, 'edit'])->name('periodos.edit');
Route::put('/periodos/{id}', [PeriodoEscolarController::class, 'update'])->name('periodos.update');
Route::delete('/periodos/{id}', [PeriodoEscolarController::class, 'destroy'])->name('periodos.destroy');
Route::resource('periodos', PeriodoEscolarController::class);



Route::get('/carreras', [CarreraController::class, 'index'])->name('carreras');
Route::get('/carreras/create', [CarreraController::class, 'create'])->name('carreras.create');
Route::post('/carreras', [CarreraController::class, 'store'])->name('carreras.store');
Route::get('/carreras/{id}/edit', [CarreraController::class, 'edit'])->name('carreras.edit');
Route::put('/carreras/{id}', [CarreraController::class, 'update'])->name('carreras.update');
Route::delete('/carreras/{id}', [CarreraController::class, 'destroy'])->name('carreras.destroy');
Route::resource('carreras', CarreraController::class);


Route::get('/planes', [PlanEstudioController::class, 'index'])->name('planes');
Route::get('/planes/create', [PlanEstudioController::class, 'create'])->name('planes.create');
Route::post('/planes', [PlanEstudioController::class, 'store'])->name('planes.store');
Route::get('/planes/{id}/edit', [PlanEstudioController::class, 'edit'])->name('planes.edit');
Route::put('/planes/{id}', [PlanEstudioController::class, 'update'])->name('planes.update');
Route::delete('/planes/{id}', [PlanEstudioController::class, 'destroy'])->name('planes.destroy');
Route::resource('planes', PlanEstudioController::class);


Route::get('/materias', [MateriaController::class, 'index'])->name('materias');
Route::get('/materias/create', [MateriaController::class, 'create'])->name('materias.create');
Route::post('/materias', [MateriaController::class, 'store'])->name('materias.store');
Route::get('/materias/{id}/edit', [MateriaController::class, 'edit'])->name('materias.edit');
Route::put('/materias/{id}', [MateriaController::class, 'update'])->name('materias.update');
Route::delete('/materias/{id}', [MateriaController::class, 'destroy'])->name('materias.destroy');

Route::resource('materias', MateriaController::class);
Route::get('planes/{id_plan_estudio}/materias', [MateriaController::class, 'materiasPorPlan'])->name('planes.materias');

Route::get('/planes/{id}/descargar-pdf', [PlanEstudioController::class, 'descargarPDF'])
    ->name('planes.descargarPDF');

// Agregar unidad a una materia
Route::post('/materias/{idMateria}/unidades', [MateriaController::class, 'agregarUnidad'])
    ->name('unidades.agregar');
Route::put('/unidades/{idUnidad}/actualizar', [MateriaController::class, 'actualizarUnidad'])
    ->name('unidades.actualizar');
Route::resource('unidades', UnidadController::class);

// Eliminar unidad
Route::delete('/unidades/{idUnidad}', [MateriaController::class, 'eliminarUnidad'])
    ->name('unidades.eliminar');


Route::put('/materias/{idMateria}/unidades/actualizar-todo', [UnidadController::class, 'actualizarTodo'])
    ->name('unidades.actualizarTodo');


Route::get('/alumnos', [AlumnoController::class, 'index'])->name('alumnos');
Route::get('/alumnos/create', [AlumnoController::class, 'create'])->name('alumnos.create');
Route::post('/alumnos', [AlumnoController::class, 'store'])->name('alumnos.store');
Route::get('/alumnos/{id}/edit', [AlumnoController::class, 'edit'])->name('alumnos.edit');
Route::put('/alumnos/{id}', [AlumnoController::class, 'update'])->name('alumnos.update');
Route::delete('/alumnos/{id}', [AlumnoController::class, 'destroy'])->name('alumnos.destroy');
Route::resource('alumnos', AlumnoController::class);


//--------------HISTORIAL--------------
Route::resource('historial', HistorialController::class)->parameters([
    'historial' => 'historial:id_historial'
]);



Route::middleware(['auth'])->group(function () {
    // Rutas para asignaciones docentes individuales
    Route::get('/asignaciones', [AsignacionDocenteController::class, 'index'])->name('asignaciones.index');
    Route::post('/asignaciones', [AsignacionDocenteController::class, 'store'])->name('asignaciones.store');
    Route::put('/asignaciones/{asignacione}', [AsignacionDocenteController::class, 'update'])->name('asignaciones.update');
    Route::delete('/asignaciones/{asignacione}', [AsignacionDocenteController::class, 'destroy'])->name('asignaciones.destroy');

    // Rutas para asignaciones masivas (¡SIN DUPLICADOS!)
    Route::post('/asignaciones/masiva/store-materias', [AsignacionDocenteController::class, 'storeMasivoMaterias'])
        ->name('asignaciones.masiva.store-materias');

    Route::get(
        '/asignaciones/masiva/materias-carrera-periodo/{carreraId}/{idNumeroPeriodo}',
        [AsignacionDocenteController::class, 'materiasPorCarreraYPeriodo']
    )
        ->name('asignaciones.masiva.materias-carrera-periodo');
});

// Rutas públicas si son necesarias
Route::get('/buscar-alumno', [HistorialController::class, 'buscarAlumno'])->name('buscar.alumno');
Route::get('/asignaciones/disponibles', [HistorialController::class, 'getAsignacionesDisponibles']);
Route::middleware(['auth'])->group(function () {
    Route::get('/historial/reinscripcion-masiva', [HistorialController::class, 'reinscripcionMasiva'])
        ->name('historial.reinscripcion-masiva');

    Route::post('/historial/obtener-alumnos-grupo', [HistorialController::class, 'obtenerAlumnosGrupo'])
        ->name('historial.obtener-alumnos-grupo');

    Route::post('/historial/store-masivo', [HistorialController::class, 'storeMasivo'])
        ->name('historial.store-masivo');
});
// Rutas adicionales para historial
Route::get('/historial/obtener-alumnos-grupo', [HistorialController::class, 'obtenerAlumnosGrupo'])
    ->name('historial.obtener-alumnos-grupo');

Route::get('/historial/obtener-materias-grupo', [HistorialController::class, 'obtenerMateriasPorGrupo'])
    ->name('historial.obtener-materias-grupo');
Route::get('/test-vista', function () {
    $periodos = \App\Models\PeriodoEscolar::all();
    $grupos = \App\Models\Grupo::all();
    $statusAcademicos = \App\Models\StatusAcademico::all();

    return view('historial.reinscripcion-masiva', compact('periodos', 'grupos', 'statusAcademicos'));
})->middleware('auth');


////////////////////////// Obtener alumnos del grupo
Route::post('/historial/obtener-alumnos-grupo', [HistorialController::class, 'obtenerAlumnosGrupo'])
    ->name('historial.obtener-alumnos-grupo');

// Obtener materias del grupo 
Route::post('/asignaciones/obtener-materias-grupo', [AsignacionDocenteController::class, 'obtenerMateriasGrupo'])
    ->name('asignaciones.obtener-materias-grupo');
Route::get('/docentes-por-carrera/{carreraId}', [AsignacionDocenteController::class, 'getDocentesPorCarrera'])
    ->name('docentes.por.carrera');

// Guardar reinscripciones masivas
Route::post('/historial/store-masivo', [HistorialController::class, 'storeMasivo'])
    ->name('historial.store-masivo');
// Rutas opcionales para filtrar por grupo (si lo necesitas en el futuro)
Route::get('/periodos-grupo', [HistorialController::class, 'getPeriodosPorGrupo'])->name('periodos.por-grupo');
Route::get('/numeros-periodo-grupo', [HistorialController::class, 'getNumerosPeriodoPorGrupo'])->name('numeros-periodo.por-grupo');
Route::get('/obtener-numero-periodo', [HistorialController::class, 'obtenerNumeroPeriodoPorGrupo']);
Route::get('/grupo/{id}/periodo', [HistorialController::class, 'getPeriodoByGrupo']);

// Búsqueda
Route::get('/buscar-alumno', [HistorialController::class, 'buscarAlumno']);
Route::get('/asignaciones/disponibles', [HistorialController::class, 'getAsignacionesDisponibles']);

// Reinscripción masiva
Route::post('/historial/obtener-alumnos-grupo', [HistorialController::class, 'obtenerAlumnosGrupo']);
Route::post('/historial/obtener-materias-grupo', [HistorialController::class, 'obtenerMateriasGrupo']);
Route::post('/historial/store-masivo', [HistorialController::class, 'storeMasivo'])->name('historial.store-masivo');
Route::get('/historial/obtener-tipo-periodo/{id}', [HistorialController::class, 'obtenerTipoPeriodo']);
Route::post(
    '/historial/store-masivo-avanzado',
    [HistorialController::class, 'storeMasivoAvanzado']
)->name('historial.store-masivo-avanzado');

Route::get('/calificaciones', [CalificacionController::class, 'index'])->name('calificaciones.index');
// Rutas de Calificaciones
Route::middleware(['auth'])->prefix('calificaciones')->name('calificaciones.')->group(function () {
    Route::get('/', [CalificacionController::class, 'index'])->name('index');
    Route::get('/materias', [CalificacionController::class, 'obtenerMaterias']);
    Route::get('/unidades/{idAsignacion}', [CalificacionController::class, 'obtenerUnidades']);
    Route::get('/evaluaciones/{idUnidad}', [CalificacionController::class, 'obtenerEvaluaciones']);
    Route::post('/alumnos-grupo', [CalificacionController::class, 'obtenerAlumnosGrupo']);
    Route::post('/store-masivo', [CalificacionController::class, 'storeMasivo'])->name('store-masivo');
    Route::post('/matriz-completa', [CalificacionController::class, 'obtenerMatrizCompleta']);
    Route::post('/store-masivo', [CalificacionController::class, 'storeMasivoMatriz'])->name('store-masivo');
});
Route::post('/calificaciones/guardar-masivo', [CalificacionController::class, 'storeMasivo'])
    ->name('calificaciones.storeMasivo');


Route::resource('docentes', DocentesController::class);
Route::get('/docentes', [DocentesController::class, 'index'])->name('docente.index');

Route::resource('usuarios', UserController::class);
// routes/web.php
Route::get('/docente/asignaciones', [CalificacionController::class, 'misAsignaciones'])
    ->name('docente.asignaciones');

Route::post('/calificaciones/matriz-completa', [CalificacionController::class, 'obtenerMatrizCompleta'])
    ->name('calificaciones.matriz.completa');
    Route::post('/calificaciones/guardar', [CalificacionController::class, 'guardarCalificaciones'])
    ->name('calificaciones.guardar');

    Route::resource('grupos', GrupoController::class);
    Route::resource('administracion-carreras', AdministracionCarreraController::class);