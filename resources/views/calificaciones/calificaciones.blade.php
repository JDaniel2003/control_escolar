<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Calificaciones</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('libs/fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('libs/sbadmin/img/up_logo.png') }}">
    
    <!-- Custom styles for this template-->
    <link href="{{ asset('libs/sbadmin/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        .table-calificaciones {
            font-size: 0.9rem;
        }
        .calificacion-alta {
            background-color: #d4edda;
            color: #155724;
            font-weight: bold;
        }
        .calificacion-media {
            background-color: #fff3cd;
            color: #856404;
        }
        .calificacion-baja {
            background-color: #f8d7da;
            color: #721c24;
        }
        .bg-primary-custom {
            background-color: #2c3e50 !important;
        }
    </style>
</head>

<body id="page-top">

    <!-- Top Header -->
    <div class="bg-danger text-white1 text-center py-2">
        <div class="d-flex justify-content-between align-items-center px-4">

            <h4 class="mb-0" style="text-align: center;">SISTEMA DE CONTROL ESCOLAR</h4>

        </div>
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dangerb">
        <div class="d-flex align-items-center">
            <div style="width: 300px; height: 120px;">
                <img src="{{ asset('libs/sbadmin/img/upn.png') }}" alt="Logo" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
        </div>

        <div class="collapse navbar-collapse ml-4">
            <ul class="navbar-nav" style="padding-left: 20%;">
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1" href="{{ route('admin') }}">Inicio</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1" href="{{ route('periodos.index') }}">Períodos Escolares</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1" href="{{ route('carreras.index') }}">Carreras</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1" href="{{ route('materias.index') }}">Materias</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1" href="{{ route('planes.index') }}">Planes de estudio</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1" href="{{ route('alumnos.index') }}">Alumnos</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1" href="{{ route('asignaciones.index') }}">Asignaciones Docentes</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1" href="{{ route('historial.index') }}">Historial</a></li>
                <li class="nav-item"><a class="nav-link navbar-active-item px-3" href="{{ route('calificaciones.index') }}">Calificaciones</a></li>
            </ul>
        </div>

        <div class="position-absolute" style="top: 10px; right: 20px; z-index: 1000;">
            <div class="d-flex align-items-center text-white">
                <span class="mr-3">{{ Auth::user()->rol->nombre }}</span>
                <a href="#" class="text-white text-decoration-none logout-link" data-toggle="modal" data-target="#logoutModal">
                    Cerrar Sesión <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </div>
    </nav>

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Main Content -->
                <div class="container-fluid py-5">
                    <h1 class="text-danger text-center mb-5" style="font-size: 2.5rem; font-family: 'Arial Black', Verdana, sans-serif; font-weight: bold;">
                        Gestión de Calificaciones
                    </h1>

                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="mb-3 text-right">
                                <button type="button" class="btn btn-success" data-toggle="modal"
                                    data-target="#modalCalificarGrupo">
                                    <i class="fas fa-plus-circle"></i> Calificar Grupo
                                </button>
                            </div>
                            
                            <!-- Filtros -->
                            <div class="container mb-4 d-flex justify-content-center">
                                <div class="p-3 border rounded bg-light d-inline-block shadow-sm">
                                    <form id="filtrosForm" method="GET" action="{{ route('calificaciones.index') }}" class="d-flex flex-wrap gap-2 align-items-center">
                                        
                                        <!-- Mostrar -->
                                        <select name="mostrar" onchange="this.form.submit()" class="form-control form-control-sm w-auto">
                                            <option value="10" {{ request('mostrar') == 10 ? 'selected' : '' }}>10</option>
                                            <option value="25" {{ request('mostrar') == 25 ? 'selected' : '' }}>25</option>
                                            <option value="50" {{ request('mostrar') == 50 ? 'selected' : '' }}>50</option>
                                            <option value="todo" {{ request('mostrar') == 'todo' ? 'selected' : '' }}>Todo</option>
                                        </select>

                                        <!-- Botón Mostrar todo -->
                                        <a href="{{ route('calificaciones.index', ['mostrar' => 'todo']) }}" class="btn btn-sm btn-outline-secondary d-flex align-items-center">
                                            <i class="fas fa-list me-1"></i> Mostrar todo
                                        </a>
                                    </form>
                                </div>
                            </div>

                            <!-- Tabla de Calificaciones -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 bg-primary-custom">
                                    <h6 class="m-0 font-weight-bold text-white">Lista de Calificaciones</h6>
                                </div>
                                <div class="card-body">
                                    @if (session('success'))
                                        <div class="alert alert-success">{{ session('success') }}</div>
                                    @endif

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-calificaciones" id="dataTable" width="100%" cellspacing="0">
                                            <thead class="thead-dark text-center">
                                                <tr>
                                                    <th>Alumno</th>
                                                    <th>Unidad</th>
                                                    <th>Evaluación</th>
                                                    <th>Asignación</th>
                                                    <th>Calificación</th>
                                                    <th>Calificación Especial</th>
                                                    <th>Fecha Registro</th>
                                                    <th>Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($calificaciones as $calificacion)
                                                    @php
                                                        $calif = $calificacion->calificacion;
                                                        if ($calif >= 8) {
                                                            $clase = 'calificacion-alta';
                                                        } elseif ($calif >= 6) {
                                                            $clase = 'calificacion-media';
                                                        } else {
                                                            $clase = 'calificacion-baja';
                                                        }
                                                    @endphp
                                                    <tr class="text-center">
                                                        <td>
                                                            {{ optional($calificacion->alumno->datosPersonales)->nombres ?? 'N/A' }}
                                                            {{ optional($calificacion->alumno->datosPersonales)->primer_apellido ?? '' }}
                                                            {{ optional($calificacion->alumno->datosPersonales)->segundo_apellido ?? '' }}
                                                        </td>
                                                        <td>{{ $calificacion->unidad->nombre ?? 'N/A' }}</td>
                                                        <td>{{ $calificacion->evaluacion->nombre ?? 'N/A' }}</td>
                                                        <td>{{ $calificacion->asignacionDocente->id_asignacion ?? 'N/A' }}</td>
                                                        <td class="{{ $clase }}">{{ number_format($calificacion->calificacion, 1) }}</td>
                                                        <td class="{{ $clase }}">{{ number_format($calificacion->calificacion_especial, 1) }}</td>
                                                        <td>{{ $calificacion->fecha_registro ? \Carbon\Carbon::parse($calificacion->fecha_registro)->format('d/m/Y') : 'N/A' }}</td>
                                                        <td>
                                                            @if($calif >= 6)
                                                                <span class="badge badge-success">Aprobado</span>
                                                            @else
                                                                <span class="badge badge-danger">Reprobado</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center text-muted py-4">
                                                            <i class="fas fa-info-circle fa-2x mb-3"></i><br>
                                                            No hay calificaciones registradas
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Estadísticas -->
                                    @if($calificaciones->count() > 0)
                                    <div class="row mt-4">
                                        <div class="col-md-3">
                                            <div class="card border-left-primary shadow h-100 py-2">
                                                <div class="card-body">
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col mr-2">
                                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                Promedio General</div>
                                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                {{ number_format($calificaciones->avg('calificacion'), 2) }}
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card border-left-success shadow h-100 py-2">
                                                <div class="card-body">
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col mr-2">
                                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                                Aprobados</div>
                                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                {{ $calificaciones->where('calificacion', '>=', 6)->count() }}
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card border-left-warning shadow h-100 py-2">
                                                <div class="card-body">
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col mr-2">
                                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                                Calificación Máxima</div>
                                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                {{ number_format($calificaciones->max('calificacion'), 1) }}
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <i class="fas fa-arrow-up fa-2x text-gray-300"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card border-left-danger shadow h-100 py-2">
                                                <div class="card-body">
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col mr-2">
                                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                                Calificación Mínima</div>
                                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                {{ number_format($calificaciones->min('calificacion'), 1) }}
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <i class="fas fa-arrow-down fa-2x text-gray-300"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Container -->
            </div>

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Tu Web 2025</span>
                    </div>
                </div>
            </footer>
            <!-- End Footer -->
        </div>
        <!-- End Content Wrapper -->
    </div>
    <!-- End Page Wrapper -->

    <!-- Modal Calificar Grupo -->
<!-- Modal Calificar Grupo - Tabla Matricial -->
<div class="modal fade" id="modalCalificarGrupo" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-success text-white">
                <h5 class="mb-0 font-weight-bold">
                    <i class="fas fa-clipboard-check mr-2"></i>Captura de Calificaciones
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body p-3">
                <form id="formCalificarGrupo" method="POST" action="{{ route('calificaciones.store-masivo') }}">
                    @csrf
                    
                    <!-- Filtros -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <strong><i class="fas fa-filter mr-2"></i>Seleccionar Grupo y Materia</strong>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="font-weight-bold">Período Escolar <span class="text-danger">*</span></label>
                                    <select id="periodoCalificar" class="form-control" required>
                                        <option value="">-- Selecciona --</option>
                                        @foreach ($periodos as $periodo)
                                            <option value="{{ $periodo->id_periodo_escolar }}">{{ $periodo->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="font-weight-bold">Grupo <span class="text-danger">*</span></label>
                                    <select id="grupoCalificar" class="form-control" required>
                                        <option value="">-- Selecciona --</option>
                                        @foreach ($grupos as $grupo)
                                            <option value="{{ $grupo->id_grupo }}">
                                                {{ $grupo->nombre }} - {{ $grupo->carrera->nombre ?? 'N/A' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="font-weight-bold">Materia <span class="text-danger">*</span></label>
                                    <select id="materiaCalificar" class="form-control" required disabled>
                                        <option value="">-- Selecciona grupo primero --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-8">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle"></i> 
                                        Selecciona periodo, grupo y materia para ver la tabla de calificaciones
                                    </small>
                                </div>
                                <div class="col-md-4 text-right">
                                    <button type="button" id="btnCargarMatriz" class="btn btn-primary" disabled>
                                        <i class="fas fa-table mr-1"></i>Cargar Tabla de Calificaciones
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla Matricial de Calificaciones -->
                    <div id="contenedorMatriz" style="display: none;">
                        <div class="card">
                            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                                <div>
                                    <strong><i class="fas fa-table mr-2"></i>Matriz de Calificaciones</strong>
                                    <span id="infoMateria" class="ml-3"></span>
                                </div>
                                <div>
                                    <span class="badge badge-light">
                                        Total alumnos: <strong id="totalAlumnos">0</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div id="contenedorTabla" style="overflow-x: auto; max-height: 600px;">
                                    <table class="table table-bordered table-hover table-sm mb-0" id="tablaCalificaciones">
                                        <thead class="thead-dark" style="position: sticky; top: 0; z-index: 100;">
                                            <tr>
                                                <th rowspan="2" style="position: sticky; left: 0; background: #343a40; z-index: 101; min-width: 50px;" class="text-center">#</th>
                                                <th rowspan="2" style="position: sticky; left: 50px; background: #343a40; z-index: 101; min-width: 120px;">Matrícula</th>
                                                <th rowspan="2" style="position: sticky; left: 170px; background: #343a40; z-index: 101; min-width: 250px;">Alumno</th>
                                                <!-- Se llenarán dinámicamente las unidades y evaluaciones -->
                                            </tr>
                                            <tr id="filaEvaluaciones">
                                                <!-- Evaluaciones dinámicas -->
                                            </tr>
                                        </thead>
                                        <tbody id="bodyMatriz">
                                            <!-- Se llenará dinámicamente -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer bg-light">
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle"></i> 
                                        Calificaciones del 0 al 10. Deja vacío si no hay calificación.
                                    </small>
                                    <div>
                                        <button type="button" class="btn btn-sm btn-outline-secondary mr-2" id="btnLimpiarTodo">
                                            <i class="fas fa-eraser"></i> Limpiar Todo
                                        </button>
                                        <button type="button" class="btn btn-sm btn-success" id="btnGuardarCalificaciones" disabled>
                                            <i class="fas fa-save mr-1"></i> Guardar Calificaciones
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="calificaciones_json" id="calificacionesJsonInput">
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.modal-fullscreen {
    max-width: 100%;
    margin: 0;
}

.modal-fullscreen .modal-content {
    height: 100vh;
    border: 0;
    border-radius: 0;
}

#tablaCalificaciones {
    font-size: 0.85rem;
}

#tablaCalificaciones th {
    white-space: nowrap;
    padding: 0.5rem;
    text-align: center;
    vertical-align: middle;
}

#tablaCalificaciones td {
    padding: 0.25rem;
    vertical-align: middle;
}

.alumno-cell {
    position: sticky;
    left: 0;
    background: white;
    z-index: 10;
    font-weight: 500;
}

.matricula-cell {
    position: sticky;
    left: 50px;
    background: white;
    z-index: 10;
}

.nombre-cell {
    position: sticky;
    left: 170px;
    background: white;
    z-index: 10;
}

.calificacion-input-matriz {
    width: 70px;
    text-align: center;
    font-weight: bold;
    padding: 0.25rem;
    border: 1px solid #dee2e6;
}

.calificacion-input-matriz:focus {
    background-color: #fff3cd;
    border-color: #28a745;
}

.calificacion-input-matriz.is-invalid {
    border-color: #dc3545;
    background-color: #f8d7da;
}

.calificacion-input-matriz[readonly] {
    background-color: #e9ecef;
    cursor: not-allowed;
}

.unidad-header {
    background-color: #17a2b8 !important;
    color: white !important;
    font-weight: bold;
}

.evaluacion-header {
    background-color: #6c757d !important;
    color: white !important;
    font-size: 0.75rem;
}

tr:hover .alumno-cell,
tr:hover .matricula-cell,
tr:hover .nombre-cell {
    background-color: #f8f9fa;
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const periodoSelect = document.getElementById('periodoCalificar');
    const grupoSelect = document.getElementById('grupoCalificar');
    const materiaSelect = document.getElementById('materiaCalificar');
    const btnCargar = document.getElementById('btnCargarMatriz');
    const btnGuardar = document.getElementById('btnGuardarCalificaciones');
    const btnLimpiar = document.getElementById('btnLimpiarTodo');
    const contenedor = document.getElementById('contenedorMatriz');
    const tbody = document.getElementById('bodyMatriz');
    const filaEvaluaciones = document.getElementById('filaEvaluaciones');
    const thead = document.querySelector('#tablaCalificaciones thead tr:first-child');
    
    let datosMatriz = {
        alumnos: [],
        unidades: []
    };

    // Cargar materias cuando se selecciona grupo y período
    function cargarMaterias() {
        const idGrupo = grupoSelect.value;
        const idPeriodo = periodoSelect.value;

        if (!idGrupo || !idPeriodo) {
            materiaSelect.innerHTML = '<option value="">-- Selecciona grupo y período --</option>';
            materiaSelect.disabled = true;
            return;
        }

        materiaSelect.innerHTML = '<option value="">Cargando...</option>';
        materiaSelect.disabled = true;

        fetch(`/calificaciones/materias?grupo=${idGrupo}&periodo=${idPeriodo}`)
            .then(r => r.json())
            .then(data => {
                if (data.success && data.materias.length > 0) {
                    materiaSelect.innerHTML = '<option value="">-- Selecciona materia --</option>';
                    data.materias.forEach(m => {
                        materiaSelect.innerHTML += `<option value="${m.id_asignacion}">${m.materia} - ${m.docente}</option>`;
                    });
                    materiaSelect.disabled = false;
                } else {
                    materiaSelect.innerHTML = '<option value="">No hay materias disponibles</option>';
                }
                validarFormulario();
            })
            .catch(err => {
                console.error(err);
                materiaSelect.innerHTML = '<option value="">Error al cargar</option>';
            });
    }

    // Cargar matriz completa
    function cargarMatriz() {
        const idGrupo = grupoSelect.value;
        const idPeriodo = periodoSelect.value;
        const idAsignacion = materiaSelect.value;

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || 
                         document.querySelector('input[name="_token"]')?.value;
        
        if (!csrfToken) {
            alert('Error: Token CSRF no encontrado. Recarga la página.');
            return;
        }

        tbody.innerHTML = '<tr><td colspan="100" class="text-center py-4"><div class="spinner-border text-primary"></div><br>Cargando datos...</td></tr>';
        contenedor.style.display = 'block';

        const materiaText = materiaSelect.options[materiaSelect.selectedIndex].text;
        document.getElementById('infoMateria').innerHTML = `<span class="badge badge-light">${materiaText}</span>`;

        fetch('/calificaciones/matriz-completa', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                id_grupo: idGrupo,
                id_periodo: idPeriodo,
                id_asignacion: idAsignacion
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('=== RESPUESTA DEL SERVIDOR ===', data);
            
            if (data.success) {
                datosMatriz.alumnos = data.alumnos;
                datosMatriz.unidades = data.unidades;
                renderMatriz();
            } else {
                tbody.innerHTML = `<tr><td colspan="100" class="text-center text-danger">Error: ${data.message || 'Error desconocido'}</td></tr>`;
            }
        })
        .catch(err => {
            console.error('Error completo:', err);
            tbody.innerHTML = `<tr><td colspan="100" class="text-center text-danger">Error de conexión: ${err.message}</td></tr>`;
        });
    }

    // Renderizar la matriz completa
    function renderMatriz() {
        if (datosMatriz.alumnos.length === 0) {
            tbody.innerHTML = '<tr><td colspan="100" class="text-center text-muted py-4">No hay alumnos en este grupo</td></tr>';
            return;
        }

        // Construir headers simples de unidades
        let headersUnidades = '';
        datosMatriz.unidades.forEach(unidad => {
            headersUnidades += `<th class="unidad-header" style="min-width: 180px;">${unidad.nombre}</th>`;
        });

        // Actualizar headers
        thead.innerHTML = `
            <th style="position: sticky; left: 0; background: #343a40; z-index: 101; min-width: 50px;" class="text-center">#</th>
            <th style="position: sticky; left: 50px; background: #343a40; z-index: 101; min-width: 120px;">Matrícula</th>
            <th style="position: sticky; left: 170px; background: #343a40; z-index: 101; min-width: 250px;">Alumno</th>
            ${headersUnidades}
        `;
        filaEvaluaciones.innerHTML = '';

        // Construir filas de alumnos
        let html = '';
        datosMatriz.alumnos.forEach((alumno, indexAlumno) => {
            html += `
            <tr>
                <td class="text-center alumno-cell" style="position: sticky; left: 0; background: white; z-index: 10;">
                    ${indexAlumno + 1}
                </td>
                <td class="matricula-cell" style="position: sticky; left: 50px; background: white; z-index: 10;">
                    <strong>${alumno.matricula}</strong>
                </td>
                <td class="nombre-cell" style="position: sticky; left: 170px; background: white; z-index: 10;">
                    ${alumno.nombre}
                </td>`;
            
            // Generar celda compacta con input y select
            datosMatriz.unidades.forEach(unidad => {
                const key = `${alumno.id_alumno}_${unidad.id_unidad}`;
                const calificacionData = alumno.calificaciones[key];
                const calificacion = calificacionData ? calificacionData.calificacion : '';
                const evaluacionGuardada = calificacionData ? calificacionData.id_evaluacion : null;
                const yaCapturado = !!calificacionData;
                
                html += `
                <td class="text-center p-2" style="vertical-align: middle;">
                    ${yaCapturado ? 
                        `<div class="d-flex flex-column align-items-center">
                            <span class="badge badge-success mb-1" style="font-size: 1rem; padding: 0.5rem;">${calificacion}</span>
                            <small class="text-muted">
                                <i class="fas fa-check-circle text-success"></i> 
                                ${unidad.evaluaciones_disponibles.find(e => e.id_evaluacion == evaluacionGuardada)?.nombre || 'Guardada'}
                            </small>
                        </div>` 
                        : 
                        `<div class="input-group input-group-sm" style="max-width: 160px; margin: 0 auto;">
                            <input type="number" 
                                   class="form-control calificacion-input-matriz text-center" 
                                   data-alumno="${alumno.id_alumno}"
                                   data-unidad="${unidad.id_unidad}"
                                   min="0" 
                                   max="10" 
                                   step="0.1"
                                   value="${calificacion}"
                                   placeholder="0.0"
                                   style="border-right: none;">
                            <div class="input-group-append" style="width: 40px;">
                                <button class="btn btn-outline-secondary dropdown-toggle" 
                                        type="button" 
                                        data-toggle="dropdown" 
                                        style="border-left: none; padding: 0.25rem 0.5rem;"
                                        title="Seleccionar evaluación">
                                    <i class="fas fa-list-ul"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <h6 class="dropdown-header">Tipo de Evaluación</h6>
                                    ${unidad.evaluaciones_disponibles.map(eval => `
                                        <a class="dropdown-item evaluacion-option" 
                                           href="#"
                                           data-alumno="${alumno.id_alumno}"
                                           data-unidad="${unidad.id_unidad}"
                                           data-evaluacion="${eval.id_evaluacion}"
                                           data-nombre="${eval.nombre}">
                                            <i class="fas fa-circle-notch mr-2"></i>
                                            ${eval.nombre}
                                        </a>
                                    `).join('')}
                                </div>
                            </div>
                        </div>
                        <small class="text-muted evaluacion-seleccionada" 
                               data-alumno="${alumno.id_alumno}"
                               data-unidad="${unidad.id_unidad}"
                               style="display: none;"></small>`
                    }
                </td>`;
            });
            
            html += '</tr>';
        });
        
        tbody.innerHTML = html;
        document.getElementById('totalAlumnos').textContent = datosMatriz.alumnos.length;

        // Eventos para inputs de calificaciones
        document.querySelectorAll('.calificacion-input-matriz').forEach(input => {
            input.addEventListener('input', function() {
                const valor = parseFloat(this.value);
                if (this.value && (valor < 0 || valor > 10 || isNaN(valor))) {
                    this.classList.add('is-invalid');
                } else {
                    this.classList.remove('is-invalid');
                }
                validarGuardar();
            });

            input.addEventListener('keydown', function(e) {
                if (['ArrowUp', 'ArrowDown', 'ArrowLeft', 'ArrowRight'].includes(e.key)) {
                    e.preventDefault();
                    navegarCelda(this, e.key);
                }
            });
        });

        // Eventos para opciones de evaluación
        document.querySelectorAll('.evaluacion-option').forEach(option => {
            option.addEventListener('click', function(e) {
                e.preventDefault();
                
                const alumno = this.dataset.alumno;
                const unidad = this.dataset.unidad;
                const evaluacion = this.dataset.evaluacion;
                const nombre = this.dataset.nombre;
                
                // Marcar visualmente la selección
                const parent = this.closest('.dropdown-menu');
                parent.querySelectorAll('.evaluacion-option').forEach(opt => {
                    opt.querySelector('i').className = 'fas fa-circle-notch mr-2';
                });
                this.querySelector('i').className = 'fas fa-check-circle text-success mr-2';
                
                // Guardar selección en el input
                const input = document.querySelector(`.calificacion-input-matriz[data-alumno="${alumno}"][data-unidad="${unidad}"]`);
                input.dataset.evaluacion = evaluacion;
                
                // Mostrar evaluación seleccionada
                const labelEval = document.querySelector(`.evaluacion-seleccionada[data-alumno="${alumno}"][data-unidad="${unidad}"]`);
                labelEval.textContent = `✓ ${nombre}`;
                labelEval.style.display = 'block';
                labelEval.classList.add('text-success');
                
                validarGuardar();
            });
        });

        validarGuardar();
    }

    // Navegación con teclado entre celdas
    function navegarCelda(inputActual, tecla) {
        const inputs = Array.from(document.querySelectorAll('.calificacion-input-matriz:not([readonly])'));
        const indexActual = inputs.indexOf(inputActual);
        
        let nuevoIndex = indexActual;
        const columnas = datosMatriz.unidades.length;
        
        switch(tecla) {
            case 'ArrowUp':
                nuevoIndex = indexActual - columnas;
                break;
            case 'ArrowDown':
                nuevoIndex = indexActual + columnas;
                break;
            case 'ArrowLeft':
                nuevoIndex = indexActual - 1;
                break;
            case 'ArrowRight':
                nuevoIndex = indexActual + 1;
                break;
        }
        
        if (nuevoIndex >= 0 && nuevoIndex < inputs.length) {
            inputs[nuevoIndex].focus();
            inputs[nuevoIndex].select();
        }
    }

    // Validar formulario
    function validarFormulario() {
        const valido = periodoSelect.value && grupoSelect.value && materiaSelect.value;
        btnCargar.disabled = !valido;
    }

    // Validar si se puede guardar
    function validarGuardar() {
        const inputs = document.querySelectorAll('.calificacion-input-matriz:not([readonly])');
        let hayCalificacionesValidas = false;
        
        inputs.forEach(input => {
            if (input.value && !input.classList.contains('is-invalid')) {
                if (input.dataset.evaluacion) {
                    hayCalificacionesValidas = true;
                }
            }
        });
        
        btnGuardar.disabled = !hayCalificacionesValidas;
    }

    // Limpiar todas las calificaciones no guardadas
    btnLimpiar?.addEventListener('click', function() {
        if (confirm('¿Estás seguro de limpiar todas las calificaciones no guardadas?')) {
            document.querySelectorAll('.calificacion-input-matriz:not([readonly])').forEach(input => {
                input.value = '';
                input.classList.remove('is-invalid');
                delete input.dataset.evaluacion;
            });
            
            document.querySelectorAll('.evaluacion-seleccionada').forEach(label => {
                label.textContent = '';
                label.style.display = 'none';
            });
            
            document.querySelectorAll('.evaluacion-option i').forEach(icon => {
                icon.className = 'fas fa-circle-notch mr-2';
            });
            
            validarGuardar();
        }
    });

    // Guardar calificaciones
    btnGuardar?.addEventListener('click', function() {
        const calificaciones = [];
        
        document.querySelectorAll('.calificacion-input-matriz:not([readonly])').forEach(input => {
            const valor = input.value;
            
            if (valor && valor !== '' && !input.classList.contains('is-invalid')) {
                const evaluacion = input.dataset.evaluacion;
                
                if (evaluacion) {
                    calificaciones.push({
                        id_alumno: parseInt(input.dataset.alumno),
                        id_unidad: parseInt(input.dataset.unidad),
                        id_evaluacion: parseInt(evaluacion),
                        calificacion: parseFloat(valor)
                    });
                }
            }
        });

        if (calificaciones.length === 0) {
            alert('Debes ingresar al menos una calificación con su evaluación seleccionada');
            return;
        }

        // Preparar datos para enviar
        const data = {
            id_asignacion: materiaSelect.value,
            calificaciones: calificaciones
        };

        console.log('📦 Datos a guardar:', data);
        console.log('📦 JSON stringificado:', JSON.stringify(data));

        // Verificar que el input existe
        const inputJson = document.getElementById('calificacionesJsonInput');
        if (!inputJson) {
            alert('ERROR: No se encontró el input calificacionesJsonInput en el formulario');
            console.error('Input calificacionesJsonInput no existe');
            return;
        }

        inputJson.value = JSON.stringify(data);
        console.log('✅ Valor asignado al input:', inputJson.value);
        
        btnGuardar.disabled = true;
        btnGuardar.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Guardando...';
        
        // Verificar que el form existe
        const form = document.getElementById('formCalificarGrupo');
        if (!form) {
            alert('ERROR: No se encontró el formulario formCalificarGrupo');
            console.error('Formulario no existe');
            return;
        }

        console.log('📤 Enviando formulario...');
        form.submit();
    });

    // Eventos
    periodoSelect.addEventListener('change', cargarMaterias);
    grupoSelect.addEventListener('change', cargarMaterias);
    materiaSelect.addEventListener('change', validarFormulario);
    btnCargar.addEventListener('click', cargarMatriz);

    // Reset al cerrar
    $('#modalCalificarGrupo').on('hidden.bs.modal', function() {
        document.getElementById('formCalificarGrupo').reset();
        tbody.innerHTML = '';
        contenedor.style.display = 'none';
        datosMatriz = { alumnos: [], unidades: [] };
        btnGuardar.disabled = true;
        btnGuardar.innerHTML = '<i class="fas fa-save mr-1"></i> Guardar Calificaciones';
    });
});
</script>
    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">¿Listo para salir?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Selecciona "Cerrar Sesión" si estás listo para finalizar tu sesión actual.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-primary" href="{{ route('login') }}">Cerrar Sesión</a>
                </div>
            </div>
        </div>
    </div>
    

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('libs/sbadmin/js/sb-admin-2.min.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Auto-submit para filtros
            let form = document.getElementById("filtrosForm");
            if (form) {
                form.querySelectorAll("select").forEach(el => {
                    el.addEventListener("change", function() {
                        form.submit();
                    });
                });
            }
        });
    </script>
</body>
</html>