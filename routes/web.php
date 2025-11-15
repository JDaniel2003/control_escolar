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


#----------------------login-----------------------
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
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

Route::get('/historial', [HistorialController::class, 'index'])->name('historial');
Route::get('/historial/create', [HistorialController::class, 'create'])->name('historial.create');
Route::post('/historial', [HistorialController::class, 'store'])->name('historial.store');
Route::get('/historial/{id}/edit', [HistorialController::class, 'edit'])->name('historial.edit');
Route::put('/historial/{id}', [HistorialController::class, 'update'])->name('historial.update');
Route::delete('/historial/{id}', [HistorialController::class, 'destroy'])->name('historial.destroy');
Route::resource('historial', HistorialController::class);
Route::get('/buscar-alumno', [HistorialController::class, 'buscarAlumno'])->name('buscar.alumno');

Route::middleware(['auth'])->group(function () {
    
    // ⚠️ IMPORTANTE: Las rutas AJAX deben ir ANTES que las rutas con parámetros
    Route::get('/buscar-alumno', [HistorialController::class, 'buscarAlumno']);
    Route::get('/historial/obtener-materias-grupo', [HistorialController::class, 'obtenerMateriasPorGrupo']);
    Route::get('/historial/obtener-alumnos-grupo', [HistorialController::class, 'obtenerAlumnosGrupo']);
    Route::get('/historial/reinscripcion-masiva', [HistorialController::class, 'reinscripcionMasiva'])->name('historial.reinscripcion-masiva');
    
    Route::get('/historial/materias-por-grupo', [HistorialController::class, 'obtenerMateriasPorGrupo'])
    ->name('historial.materias-por-grupo');

Route::get('/historial/buscar-alumno', [HistorialController::class, 'buscarAlumno'])
    ->name('historial.buscar-alumno');

    // Rutas para Historial
Route::prefix('historial')->group(function () {
    Route::get('/', [HistorialController::class, 'index'])->name('historial.index');
    Route::get('/create', [HistorialController::class, 'create'])->name('historial.create');
    Route::post('/', [HistorialController::class, 'store'])->name('historial.store');
    Route::get('/{historial}', [HistorialController::class, 'show'])->name('historial.show');
    Route::get('/{historial}/edit', [HistorialController::class, 'edit'])->name('historial.edit');
    Route::put('/{historial}', [HistorialController::class, 'update'])->name('historial.update');
    Route::delete('/{historial}', [HistorialController::class, 'destroy'])->name('historial.destroy');
    
    // Rutas adicionales para funcionalidades específicas
    Route::get('/buscar-alumno', [HistorialController::class, 'buscarAlumno'])->name('historial.buscar-alumno');
    Route::get('/materias-por-grupo', [HistorialController::class, 'obtenerMateriasPorGrupo'])->name('historial.materias-por-grupo');
    Route::get('/reinscripcion-masiva', [HistorialController::class, 'reinscripcionMasiva'])->name('historial.reinscripcion-masiva');
    Route::post('/reinscripcion-masiva', [HistorialController::class, 'storeMasivo'])->name('historial.store-masivo');
    Route::get('/obtener-alumnos-grupo', [HistorialController::class, 'obtenerAlumnosGrupo'])->name('historial.obtener-alumnos-grupo');
});
    // Rutas normales
    Route::get('/historial', [HistorialController::class, 'index'])->name('historial.index');
    Route::post('/historial', [HistorialController::class, 'store'])->name('historial.store');
    Route::put('/historial/{historial}', [HistorialController::class, 'update'])->name('historial.update');
    Route::delete('/historial/{historial}', [HistorialController::class, 'destroy'])->name('historial.destroy');
    Route::post('/historial/store-masivo', [HistorialController::class, 'storeMasivo'])->name('historial.store-masivo');
});

Route::middleware(['auth'])->group(function () {
    // Rutas para asignaciones docentes individuales
    Route::get('/asignaciones', [AsignacionDocenteController::class, 'index'])->name('asignaciones.index');
    Route::post('/asignaciones', [AsignacionDocenteController::class, 'store'])->name('asignaciones.store');
    Route::put('/asignaciones/{asignacione}', [AsignacionDocenteController::class, 'update'])->name('asignaciones.update');
    Route::delete('/asignaciones/{asignacione}', [AsignacionDocenteController::class, 'destroy'])->name('asignaciones.destroy');
    
    // Rutas para asignaciones masivas (¡SIN DUPLICADOS!)
    Route::post('/asignaciones/masiva/store-materias', [AsignacionDocenteController::class, 'storeMasivoMaterias'])
        ->name('asignaciones.masiva.store-materias');
    
    Route::get('/asignaciones/masiva/materias-carrera-periodo/{carreraId}/{idNumeroPeriodo}', 
        [AsignacionDocenteController::class, 'materiasPorCarreraYPeriodo'])
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
Route::get('/test-vista', function() {
    $periodos = \App\Models\PeriodoEscolar::all();
    $grupos = \App\Models\Grupo::all();
    $statusAcademicos = \App\Models\StatusAcademico::all();
    
    return view('historial.reinscripcion-masiva', compact('periodos', 'grupos', 'statusAcademicos'));
})->middleware('auth');


////////////////////////// Obtener alumnos del grupo
Route::post('/historial/obtener-alumnos-grupo', [HistorialController::class, 'obtenerAlumnosGrupo'])
    ->name('historial.obtener-alumnos-grupo');

// Obtener materias del grupo (NUEVA)
Route::post('/asignaciones/obtener-materias-grupo', [AsignacionDocenteController::class, 'obtenerMateriasGrupo'])
    ->name('asignaciones.obtener-materias-grupo');

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
Route::post('/historial/store-masivo-avanzado', 
    [HistorialController::class, 'storeMasivoAvanzado']
)->name('historial.store-masivo-avanzado');