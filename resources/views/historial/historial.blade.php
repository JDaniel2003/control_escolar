<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Historial</title>
    <!-- Custom fonts -->
    <link href="{{ asset('libs/fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('libs/sbadmin/img/up_logo.png') }}">
    <!-- Custom styles -->
    <link href="{{ asset('libs/sbadmin/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>

<body id="page-top">
    <!-- Top Header -->
    <div class="bg-danger text-white1 text-center py-2">
        <h4 class="mb-0">SISTEMA DE CONTROL ESCOLAR</h4>
    </div>

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">¿Seguro de cerrar sesión?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Seleccione "si" a continuación si está listo para finalizar su sesión actual.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">No</button>
                    <a class="btn btn-primary" href="{{ route('login') }}">Si</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dangerb">
        <div class="d-flex align-items-center">
            <div style="width: 300px; height: 120px;">
                <img src="{{ asset('libs/sbadmin/img/upn.png') }}" alt="Logo"
                    style="width: 100%; height: 100%; object-fit: cover;">
            </div>
        </div>
        <div class="collapse navbar-collapse ml-4">
            <ul class="navbar-nav" style="padding-left: 20%;">
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1" href="{{ route('admin') }}">Inicio</a>
                </li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1"
                        href="{{ route('periodos.index') }}">Períodos Escolares</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1"
                        href="{{ route('carreras.index') }}">Carreras</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1"
                        href="{{ route('materias.index') }}">Materias</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1" href="{{ route('planes.index') }}">Planes
                        de estudio</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1"
                        href="{{ route('alumnos.index') }}">Alumnos</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1"
                        href="{{ route('asignaciones.index') }}">Asignaciones Docentes</a></li>
                <li class="nav-item"><a class="nav-link navbar-active-item px-3">Historial</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3" href="#">Calificaciones</a></li>
            </ul>
        </div>
        <div class="position-absolute" style="top: 10px; right: 20px; z-index: 1000;">
            <div class="d-flex align-items-center text-white">
                <span class="mr-3">{{ Auth::user()->rol->nombre }}</span>
                <a href="#" class="text-white text-decoration-none logout-link" data-toggle="modal"
                    data-target="#logoutModal">
                    Cerrar Sesión <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </div>
    </nav>

    <!-- Page Wrapper -->
    <div id="wrapper">
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid py-5">
                    <h1 class="text-danger text-center mb-5"
                        style="font-size: 2.5rem; font-weight: bold; font-family: 'Arial Black', Verdana, sans-serif;">
                        Historial de Reinscripciones
                    </h1>
                    <div class="row justify-content-center">
                        <div class="col-lg-11">
                            <!-- Botón nueva reinscripción -->
                            <div class="mb-3 text-right">
                                <button type="button" class="btn btn-info mr-2" data-toggle="modal" data-target="#modalReinscripcionMasiva">
    <i class="fas fa-users"></i> Reinscripción Masiva
</button>

                                <button type="button" class="btn btn-success" data-toggle="modal"
                                    data-target="#nuevaReinscripcionModal">
                                    <i class="fas fa-plus-circle"></i> Nueva Reinscripción
                                </button>
                            </div>

                            <!-- Filtros -->
                            <div class="container-fluid mb-4 d-flex justify-content-center">
                                <div class="p-3 border rounded bg-light shadow-sm d-inline-block">
                                    <form id="filtrosForm" method="GET" action="{{ route('historial.index') }}"
                                        class="d-flex flex-nowrap align-items-center gap-2">
                                        <div class="flex-grow-1" style="width: 400px;">
                                            <input type="text" name="busqueda"
                                                class="form-control form-control-sm"
                                                placeholder="🔍 Buscar por nombre o matrícula"
                                                value="{{ request('busqueda') }}">
                                        </div>
                                        <input type="text" name="matricula"
                                            class="form-control form-control-sm w-auto"
                                            placeholder="Buscar por matrícula" value="{{ request('matricula') }}">
                                        <select name="id_periodo_escolar" class="form-control form-control-sm w-auto">
                                            <option value="">Buscar por período</option>
                                            @foreach ($periodos as $periodo)
                                                <option value="{{ $periodo->id_periodo_escolar }}"
                                                    {{ request('id_periodo_escolar') == $periodo->id_periodo_escolar ? 'selected' : '' }}>
                                                    {{ $periodo->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <select name="id_grupo" class="form-control form-control-sm w-auto">
                                            <option value="">Buscar por grupo</option>
                                            @foreach ($grupos as $grupo)
                                                <option value="{{ $grupo->id_grupo }}"
                                                    {{ request('id_grupo') == $grupo->id_grupo ? 'selected' : '' }}>
                                                    {{ $grupo->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <select name="id_historial_status"
                                            class="form-control form-control-sm w-auto">
                                            <option value="">Buscar por estatus</option>
                                            @foreach ($historialStatus as $status)
                                                <option value="{{ $status->id_historial_status }}"
                                                    {{ request('id_historial_status') == $status->id_historial_status ? 'selected' : '' }}>
                                                    {{ $status->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <select name="mostrar" onchange="this.form.submit()"
                                            class="form-control form-control-sm w-auto">
                                            <option value="10" {{ request('mostrar') == 10 ? 'selected' : '' }}>10
                                            </option>
                                            <option value="25" {{ request('mostrar') == 25 ? 'selected' : '' }}>25
                                            </option>
                                            <option value="50" {{ request('mostrar') == 50 ? 'selected' : '' }}>50
                                            </option>
                                            <option value="todo"
                                                {{ request('mostrar') == 'todo' ? 'selected' : '' }}>Todo</option>
                                        </select>
                                        <a href="{{ route('historial.index', ['mostrar' => 'todo']) }}"
                                            class="btn btn-sm btn-outline-secondary d-flex align-items-center">
                                            <i class="fas fa-list me-1"></i> Mostrar todo
                                        </a>
                                    </form>
                                </div>
                            </div>

                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            <!-- Tabla de historial -->
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover text-center" width="100%">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Alumno</th> {{-- <th>Matrícula</th><th>Período Escolar</th><th>Grupo</th><th>Número Período</th> --}}
                                            <th>Asignaciones</th>
                                            <th>Fecha Inscripción</th>
                                            <th>Status Inicio</th>
                                            <th>Status Terminación</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($historial as $registro)
                                            <tr>
                                                <td>
                                                    {{ optional($registro->alumno->datosPersonales)->nombres ?? 'N/A' }}
                                                    {{ optional($registro->alumno->datosPersonales)->primer_apellido ?? '' }}
                                                    {{ optional($registro->alumno->datosPersonales)->segundo_apellido ?? '' }}
                                                </td>
                                                {{-- <td>{{ optional($registro->periodoEscolar)->nombre ?? 'N/A' }}</td>
                                                <td>{{ optional($registro->grupo)->nombre ?? 'N/A' }}</td>
                                                <td>{{ $registro->numeroPeriodo->tipoPeriodo->nombre ?? 'N/A' }} {{ $registro->numeroPeriodo->numero ?? 'N/A' }}</td> --}}
                                                <td>
                                                    @php
                                                        $asignacionesCount = 0;
                                                        for ($i = 1; $i <= 8; $i++) {
                                                            $asignacion = $registro->{"asignacion$i"};
                                                            if ($asignacion && $asignacion->materia) {
                                                                $asignacionesCount++;
                                                                echo '<span class="asignacion-tag d-block mb-1">' .
                                                                    $asignacion->materia->nombre .
                                                                    '</span>';
                                                            }
                                                        }
                                                        if ($asignacionesCount === 0) {
                                                            echo '<span class="text-muted">Sin asignaciones</span>';
                                                        }
                                                    @endphp
                                                </td>

                                                <td>{{ $registro->fecha_inscripcion ? \Carbon\Carbon::parse($registro->fecha_inscripcion)->format('d/m/Y') : 'N/A' }}
                                                </td>
                                                <td>{{ optional($registro->statusInicio)->nombre ?? 'N/A' }}</td>
                                                <td>{{ optional($registro->statusTerminacion)->nombre ?? 'Sin Asignar' }}
                                                </td>
                                                <td>
                                                    <button class="btn btn-info btn-sm" data-toggle="modal"
                                                        data-target="#verHistorialModal{{ $registro->id_historial }}">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button class="btn btn-warning btn-sm" data-toggle="modal"
                                                        data-target="#editarHistorialModal{{ $registro->id_historial }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <form
                                                        action="{{ route('historial.destroy', $registro->id_historial) }}"
                                                        method="POST" style="display:inline-block;"
                                                        onsubmit="return confirm('¿Seguro que deseas eliminar este registro?');">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"><i
                                                                class="fas fa-trash-alt"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="11" class="text-muted text-center">No hay registros de
                                                    reinscripción</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            @if ($historial instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                <div class="d-flex justify-content-center mt-4">{{ $historial->links() }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Tu Web 2025</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- === MODALES FUERA DE LA TABLA === -->
    @foreach ($historial as $registro)
        <!-- Modal Ver -->
        <div class="modal fade" id="verHistorialModal{{ $registro->id_historial }}" tabindex="-1" role="dialog"
            aria-labelledby="verHistorialModalLabel{{ $registro->id_historial }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title w-100 text-center font-weight-bold">Detalles de Reinscripción</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-3">
                        <div class="row mb-2">
                            <div class="col-md-8">
                                <h6 class="font-weight-bold text-primary mb-1">
                                    {{ optional($registro->alumno->datosPersonales)->nombres ?? 'N/A' }}
                                    {{ optional($registro->alumno->datosPersonales)->primer_apellido ?? '' }}
                                    {{ optional($registro->alumno->datosPersonales)->segundo_apellido ?? '' }}
                                </h6>
                                <p class="text-muted mb-0 small">
                                    Matrícula:
                                    <strong>{{ optional($registro->alumno->datosAcademicos)->matricula ?? 'Sin Asignar' }}</strong>
                                    | Carrera:
                                    <strong>{{ optional($registro->alumno->datosAcademicos->carrera)->nombre ?? 'N/A' }}</strong>
                                </p>
                            </div>
                            <div class="col-md-4 text-right">
                                @if ($registro->historialStatus)
                                    <span
                                        class="badge {{ $registro->historialStatus->id_historial_status == 1 ? 'badge-success' : 'badge-danger' }}">
                                        {{ $registro->historialStatus->nombre }}
                                    </span>
                                @else
                                    <span class="badge badge-secondary">N/A</span>
                                @endif
                            </div>
                        </div>
                        <div class="card border mb-2">
                            <div class="card-header bg-light py-2">
                                <h6 class="mb-0 font-weight-bold"><i class="fas fa-calendar-alt mr-1"></i>DATOS DE
                                    REINSCRIPCIÓN</h6>
                            </div>
                            <div class="card-body p-2">
                                <div class="row small">
                                    <div class="col-md-4"><strong>Período Escolar:</strong>
                                        {{ optional($registro->periodoEscolar)->nombre ?? 'N/A' }}</div>
                                    <div class="col-md-4"><strong>Grupo:</strong>
                                        {{ optional($registro->grupo)->nombre ?? 'N/A' }}</div>
                                    <div class="col-md-4"><strong>Fecha:</strong>
                                        {{ $registro->fecha_inscripcion ? \Carbon\Carbon::parse($registro->fecha_inscripcion)->format('d/m/Y') : 'N/A' }}
                                    </div>
                                    <div class="col-md-4"><strong>Número de Período:</strong>
                                        {{ $registro->numeroPeriodo->tipoPeriodo->nombre ?? 'N/A' }}
                                        {{ $registro->numeroPeriodo->numero ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </div>
                        @php
                            $hasAsignaciones = false;
                            for ($i = 1; $i <= 8; $i++) {
                                if ($registro->{"asignacion$i"} && $registro->{"asignacion$i"}->materia) {
                                    $hasAsignaciones = true;
                                    break;
                                }
                            }
                        @endphp
                        @if ($hasAsignaciones)
                            <div class="card border mb-2">
                                <div class="card-header bg-light py-2">
                                    <h6 class="mb-0 font-weight-bold"><i
                                            class="fas fa-chalkboard-teacher mr-1"></i>ASIGNACIONES DE DOCENTES</h6>
                                </div>
                                <div class="card-body p-2">
                                    <table class="table table-sm table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Materia</th>
                                                <th>Docente</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @for ($i = 1; $i <= 8; $i++)
                                                @php $asignacion = $registro->{"asignacion$i"}; @endphp
                                                @if ($asignacion && $asignacion->materia)
                                                    <tr>
                                                        <td>{{ $i }}</td>
                                                        <td>{{ $asignacion->materia->nombre }}</td>
                                                        <td>{{ optional($asignacion->docente)->username ?? 'N/A' }}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endfor
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <div class="card border h-100">
                                    <div class="card-header bg-light py-2">
                                        <h6 class="mb-0 font-weight-bold"><i
                                                class="fas fa-play-circle mr-1"></i>STATUS INICIO</h6>
                                    </div>
                                    <div class="card-body p-2">
                                        <p class="mb-0">{{ optional($registro->statusInicio)->nombre ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border h-100">
                                    <div class="card-header bg-light py-2">
                                        <h6 class="mb-0 font-weight-bold"><i
                                                class="fas fa-flag-checkered mr-1"></i>STATUS TERMINACIÓN</h6>
                                    </div>
                                    <div class="card-body p-2">
                                        <p class="mb-0">
                                            {{ optional($registro->statusTerminacion)->nombre ?? 'Sin Asignar' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($registro->datos)
                            <div class="card border mb-2">
                                <div class="card-header bg-light py-2">
                                    <h6 class="mb-0 font-weight-bold"><i class="fas fa-info-circle mr-1"></i>DATOS
                                        ADICIONALES</h6>
                                </div>
                                <div class="card-body p-2">
                                    <pre class="mb-0 small">{{ json_encode($registro->datos, JSON_PRETTY_PRINT) }}</pre>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer bg-light border-top py-2">
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">
                            <i class="fas fa-times mr-1"></i>Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Editar -->
        <div class="modal fade" id="editarHistorialModal{{ $registro->id_historial }}" tabindex="-1"
            role="dialog" aria-labelledby="editarHistorialModalLabel{{ $registro->id_historial }}"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="text-center w-100 mb-0">Editar Reinscripción</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('historial.update', $registro->id_historial) }}" method="POST">
                            @csrf @method('PUT')
                            <div class="card mb-3">
                                <div class="card-header bg-light"><b>Datos de Reinscripción</b></div>
                                <div class="card-body d-flex flex-wrap gap-3">
                                    <div class="flex-grow-1" style="min-width: 200px;">
                                        <label>Alumno</label>
                                        <select name="id_alumno" class="form-control" required>
                                            <option value="">Selecciona...</option>
                                            @foreach ($alumnos as $alumno)
                                                <option value="{{ $alumno->id_alumno }}"
                                                    {{ $registro->id_alumno == $alumno->id_alumno ? 'selected' : '' }}>
                                                    {{ optional($alumno->datosPersonales)->nombres ?? 'N/A' }}
                                                    {{ optional($alumno->datosPersonales)->primer_apellido ?? '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="flex-grow-1" style="min-width: 200px;">
                                        <label>Período Escolar</label>
                                        <select name="id_periodo_escolar" class="form-control" required>
                                            <option value="">Selecciona...</option>
                                            @foreach ($periodos as $periodo)
                                                <option value="{{ $periodo->id_periodo_escolar }}"
                                                    {{ $registro->id_periodo_escolar == $periodo->id_periodo_escolar ? 'selected' : '' }}>
                                                    {{ $periodo->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="flex-grow-1" style="min-width: 200px;">
                                        <label>Grupo</label>
                                        <select name="id_grupo" class="form-control grupo-select-editar" required>
                                            <option value="">Selecciona...</option>
                                            @foreach ($grupos as $grupo)
                                                <option value="{{ $grupo->id_grupo }}"
                                                    {{ $registro->id_grupo == $grupo->id_grupo ? 'selected' : '' }}>
                                                    {{ $grupo->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="flex-grow-1" style="min-width: 200px;">
                                        <label>Número de Periodo</label>
                                        <select name="id_numero_periodo" class="form-control" required>
                                            <option value="">Selecciona...</option>
                                            @foreach ($numerosPeriodo as $numeroPeriodo)
                                                <option value="{{ $numeroPeriodo->id_numero_periodo }}"
                                                    {{ $registro->id_numero_periodo == $numeroPeriodo->id_numero_periodo ? 'selected' : '' }}>
                                                    {{ $numeroPeriodo->tipoPeriodo->nombre ?? 'N/A' }}
                                                    {{ $numeroPeriodo->numero }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="flex-grow-1" style="min-width: 200px;">
                                        <label>Fecha de Inscripción</label>
                                        <input type="date" name="fecha_inscripcion"
                                            value="{{ $registro->fecha_inscripcion ? \Carbon\Carbon::parse($registro->fecha_inscripcion)->format('Y-m-d') : '' }}"
                                            class="form-control">
                                    </div>
                                    <div class="flex-grow-1" style="min-width: 200px;">
                                        <label>Status Inicio</label>
                                        <select name="id_status_inicio" class="form-control">
                                            <option value="">Selecciona...</option>
                                            @foreach ($statusAcademicos as $status)
                                                <option value="{{ $status->id_status_academico }}"
                                                    {{ $registro->id_status_inicio == $status->id_status_academico ? 'selected' : '' }}>
                                                    {{ $status->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="flex-grow-1" style="min-width: 200px;">
                                        <label>Status Terminación</label>
                                        <select name="id_status_terminacion" class="form-control">
                                            <option value="">Selecciona...</option>
                                            @foreach ($statusAcademicos as $status)
                                                <option value="{{ $status->id_status_academico }}"
                                                    {{ $registro->id_status_terminacion == $status->id_status_academico ? 'selected' : '' }}>
                                                    {{ $status->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="flex-grow-1" style="min-width: 200px;">
                                        <label>Estatus Historial</label>
                                        <select name="id_historial_status" class="form-control">
                                            <option value="">Selecciona...</option>
                                            @foreach ($historialStatus as $status)
                                                <option value="{{ $status->id_historial_status }}"
                                                    {{ $registro->id_historial_status == $status->id_historial_status ? 'selected' : '' }}>
                                                    {{ $status->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="w-100" style="min-width: 200px;">
                                        <label>Asignaciones de Docentes</label>
                                        <select name="asignaciones[]"
                                            class="form-control select-asignaciones asignaciones-editar-{{ $registro->id_historial }}"
                                            multiple>
                                            <!-- Se llenarán vía AJAX -->
                                        </select>
                                        <small class="text-muted">Máximo 8 asignaciones. Mantén presionado Ctrl (Cmd en
                                            Mac) para seleccionar múltiples</small>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right mt-4">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar
                                    Cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
<!-- -------------------------------------------------------------- -->
    <div class="modal fade" id="modalReinscripcionMasiva" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl-custom" role="document">
        <div class="modal-content">
            <div class="modal-header modal-header-gradient">
                <h5 class="mb-0 font-weight-bold">
                    <i class="fas fa-magic mr-3"></i>Reinscripción Masiva Inteligente con Asignación de Materias
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body p-4">
                <form id="formReinscripcionMasiva" method="POST" action="{{ route('historial.store-masivo') }}">
                    @csrf

                    <!-- Barra de Progreso -->
                    <div class="mb-4">
                        <div class="progress" style="height: 8px; background: #e3e6f0;">
                            <div class="progress-bar-custom" id="progressBar" style="width: 0%"></div>
                        </div>
                        <small class="text-muted mt-2 d-block" id="progressText">Paso 1 de 3: Configuración inicial</small>
                    </div>

                    <!-- PASO 1: Configuración -->
                    <div class="step-card">
                        <div class="step-header">
                            <div class="d-flex align-items-center">
                                <div class="step-badge">1</div>
                                <div>
                                    <h5 class="mb-0 font-weight-bold">Configuración de Reinscripción</h5>
                                    <small>Selecciona el grupo y período</small>
                                </div>
                            </div>
                            <span id="checkPaso1"><i class="fas fa-circle text-white-50"></i></span>
                        </div>
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="font-weight-bold">
                                        <i class="fas fa-users text-primary mr-2"></i>Grupo Actual <span class="text-danger">*</span>
                                    </label>
                                    <select name="id_grupo_actual" id="grupoActual" class="form-control form-control-modern" required>
                                        <option value="">-- Seleccione el grupo --</option>
                                        @foreach($grupos as $grupo)
                                            <option value="{{ $grupo->id_grupo }}" 
                                                    data-carrera="{{ $grupo->carrera->nombre ?? '' }}"
                                                    data-turno="{{ $grupo->turno->nombre ?? '' }}">
                                                {{ $grupo->nombre }} - {{ $grupo->carrera->nombre ?? '' }} ({{ $grupo->turno->nombre ?? '' }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="font-weight-bold">
                                        <i class="fas fa-calendar-alt text-success mr-2"></i>Período Escolar <span class="text-danger">*</span>
                                    </label>
                                    <select name="id_periodo_escolar" id="periodoEscolar" class="form-control form-control-modern" required>
                                        <option value="">-- Seleccione el período --</option>
                                        @foreach($periodos as $periodo)
                                            <option value="{{ $periodo->id_periodo_escolar }}">{{ $periodo->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="font-weight-bold">
                                        <i class="fas fa-calendar-check text-info mr-2"></i>Fecha de Inscripción
                                    </label>
                                    <input type="date" name="fecha_inscripcion" id="fechaInscripcion" 
                                           class="form-control form-control-modern" value="{{ date('Y-m-d') }}">
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button type="button" id="btnCargarDatos" class="btn btn-gradient-primary btn-lg">
                                    <i class="fas fa-rocket mr-2"></i>Cargar Alumnos y Materias
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Panel de Configuración Masiva -->
                    <div id="panelConfiguracion" style="display: none;">
                        <div class="config-panel">
                            <h5 class="font-weight-bold mb-3">
                                <i class="fas fa-sliders-h mr-2"></i>Configuración Rápida para Seleccionados
                            </h5>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="font-weight-bold mb-2">Status Inicio</label>
                                    <select id="statusInicioMasivo" class="form-control form-control-modern">
                                        <option value="">-- Seleccionar --</option>
                                        @foreach($statusAcademicos as $status)
                                            <option value="{{ $status->id_status_academico }}">{{ $status->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="font-weight-bold mb-2">Status Terminación</label>
                                    <select id="statusTerminacionMasivo" class="form-control form-control-modern">
                                        <option value="">-- Seleccionar --</option>
                                        @foreach($statusAcademicos as $status)
                                            <option value="{{ $status->id_status_academico }}">{{ $status->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3 mb-3 d-flex align-items-end">
                                    <button type="button" id="btnAplicarStatus" class="btn btn-light btn-block font-weight-bold">
                                        <i class="fas fa-check mr-2"></i>Aplicar Status
                                    </button>
                                </div>

                                <div class="col-md-3 mb-3 d-flex align-items-end">
                                    <button type="button" id="btnAsignarTodasMaterias" class="btn btn-light btn-block font-weight-bold">
                                        <i class="fas fa-book mr-2"></i>Asignar Todas las Materias
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PASO 2: Materias Disponibles -->
                    <div class="step-card" id="cardMaterias" style="display: none;">
                        <div class="step-header warning">
                            <div class="d-flex align-items-center">
                                <div class="step-badge" style="color: #f5576c;">2</div>
                                <div>
                                    <h5 class="mb-0 font-weight-bold">Selección de Materias del Grupo</h5>
                                    <small>Estas materias se asignarán a los alumnos seleccionados</small>
                                </div>
                            </div>
                            <span id="checkPaso2"><i class="fas fa-circle text-white-50"></i></span>
                        </div>
                        <div class="card-body p-4">
                            <div class="alert alert-info mb-4">
                                <i class="fas fa-lightbulb mr-2"></i>
                                <strong>¡Nuevo!</strong> Selecciona las materias que quieres asignar. Luego, en el paso 3, podrás personalizar qué materias recibe cada alumno.
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">
                                    <i class="fas fa-book-open mr-2"></i>Materias Disponibles 
                                    <span class="badge badge-primary" id="totalMaterias">0</span>
                                </h6>
                                <button type="button" id="btnSelectAllMaterias" class="select-all-badge">
                                    <i class="fas fa-check-double"></i>
                                    <span id="selectAllMateriasText">Seleccionar Todas</span>
                                </button>
                            </div>

                            <div id="materiasContainer" class="row">
                                <div class="col-12">
                                    <div class="empty-state">
                                        <i class="fas fa-books"></i>
                                        <h5 class="font-weight-bold">Cargando materias...</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PASO 3: Lista de Alumnos con Materias -->
                    <div class="step-card" id="cardAlumnos" style="display: none;">
                        <div class="step-header success">
                            <div class="d-flex align-items-center">
                                <div class="step-badge" style="color: #11998e;">3</div>
                                <div>
                                    <h5 class="mb-0 font-weight-bold">Alumnos y Asignación de Materias</h5>
                                    <small>Configura cada alumno individualmente</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="select-all-badge mr-3" id="btnSelectAll">
                                    <i class="fas fa-user-check"></i>
                                    <span id="selectAllText">Seleccionar Todos</span>
                                </div>
                                <span id="checkPaso3"><i class="fas fa-circle text-white-50"></i></span>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <!-- Estadísticas -->
                            <div class="row mb-4" id="statsContainer" style="display: none;">
                                <div class="col-md-3 mb-3">
                                    <div class="stats-card">
                                        <div class="stats-number" id="totalAlumnos">0</div>
                                        <div class="font-weight-bold">Total Alumnos</div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="stats-card" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                                        <div class="stats-number" id="alumnosSeleccionados">0</div>
                                        <div class="font-weight-bold">Seleccionados</div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="stats-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                                        <div class="stats-number" id="alumnosConfigurados">0</div>
                                        <div class="font-weight-bold">Configurados</div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="stats-card" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                                        <div class="stats-number" id="materiasSeleccionadas">0</div>
                                        <div class="font-weight-bold">Materias Activas</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Contenedor de Alumnos -->
                            <div id="alumnosContainer">
                                <div class="empty-state">
                                    <i class="fas fa-users"></i>
                                    <h5 class="font-weight-bold">Esperando datos...</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer border-top p-4">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-2"></i>Cancelar
                </button>
                <button type="button" id="btnGuardarReinscripciones" class="btn btn-gradient-success" style="display: none;">
                    <i class="fas fa-save mr-2"></i>Guardar Reinscripciones
                </button>
            </div>
        </div>
    </div>
</div>
</div>

    <!-- Modal Nueva Reinscripción -->
    <div class="modal fade" id="nuevaReinscripcionModal" tabindex="-1" role="dialog"
        aria-labelledby="nuevaReinscripcionLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-user-graduate mr-2"></i>Nueva Reinscripción</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-4">
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar bg-success" id="progressBar" role="progressbar"
                                style="width: 0%"></div>
                        </div>
                        <small class="text-muted" id="progressText">Completa los campos requeridos</small>
                    </div>
                    <form action="{{ route('historial.store') }}" method="POST" id="formNuevaReinscripcion">
                        @csrf
                        <!-- Paso 1: Alumno -->
                        <div class="card shadow-sm mb-3">
                            <div class="card-header bg-white border-bottom">
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-primary mr-2">1</span><b>Búsqueda de Alumno</b>
                                    <span class="ml-auto" id="checkAlumno"><i
                                            class="fas fa-circle text-muted"></i></span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-5">
                                        <label class="font-weight-bold">Número de Control / Matrícula</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i
                                                        class="fas fa-search"></i></span></div>
                                            <input type="text" id="buscarMatricula" class="form-control"
                                                placeholder="Ej. 20230015" autofocus>
                                            <div class="input-group-append">
                                                <button type="button" id="btnBuscarAlumno" class="btn btn-primary">
                                                    <i class="fas fa-search mr-1"></i> Buscar
                                                </button>
                                            </div>
                                        </div>
                                        <small class="text-muted">Presiona Enter o clic en Buscar</small>
                                    </div>
                                    <div class="col-md-7">
                                        <label class="font-weight-bold">Alumno Seleccionado <span
                                                class="text-danger">*</span></label>
                                        <div class="alert alert-secondary mb-0" id="alumnoInfo"
                                            style="display: none;">
                                            <div class="d-flex align-items-center">
                                                <div class="mr-3"><i
                                                        class="fas fa-user-circle fa-3x text-primary"></i></div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1" id="nombreAlumnoDisplay"></h6>
                                                    <small class="text-muted"><i class="fas fa-id-card mr-1"></i><span
                                                            id="matriculaDisplay"></span></small>
                                                    <div class="mt-1">
                                                        <span class="badge badge-info mr-1"
                                                            id="carreraDisplay"></span>
                                                        <span class="badge badge-secondary" id="grupoDisplay"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="id_alumno" id="id_alumno">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Paso 2: Datos de reinscripción -->
                        <div class="card shadow-sm mb-3">
                            <div class="card-header bg-white border-bottom">
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-primary mr-2">2</span><b>Datos de Reinscripción</b>
                                    <span class="ml-auto" id="checkDatos"><i
                                            class="fas fa-circle text-muted"></i></span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="font-weight-bold">Período Escolar <span
                                                class="text-danger">*</span></label>
                                        <select name="id_periodo_escolar" id="periodoSelect"
                                            class="form-control custom-select" required>
                                            <option value="">-- Selecciona un período --</option>
                                            @foreach ($periodos as $periodo)
                                                <option value="{{ $periodo->id_periodo_escolar }}">
                                                    {{ $periodo->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="font-weight-bold">Grupo <span
                                                class="text-danger">*</span></label>
                                        <select name="id_grupo" id="grupoSelect" class="form-control custom-select"
                                            required>
                                            <option value="">-- Selecciona un grupo --</option>
                                            @foreach ($grupos as $grupo)
                                                <option value="{{ $grupo->id_grupo }}">{{ $grupo->nombre }} -
                                                    {{ $grupo->carrera->nombre ?? 'N/A' }}
                                                    ({{ $grupo->turno->nombre ?? 'N/A' }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label class="font-weight-bold">Número de Periodo <span
                                                class="text-danger">*</span></label>
                                        <select name="id_numero_periodo" id="numeroPeriodoSelect"
                                            class="form-control custom-select" required>
                                            <option value="">-- Selecciona primero grupo --</option>
                                            @foreach ($numerosPeriodo as $numeroPeriodo)
                                                <option value="{{ $numeroPeriodo->id_numero_periodo }}">
                                                    {{ $numeroPeriodo->tipoPeriodo->nombre ?? 'N/A' }} - Período
                                                    {{ $numeroPeriodo->numero }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="font-weight-bold">Fecha de Inscripción</label>
                                        <input type="date" name="fecha_inscripcion" id="fechaInscripcion"
                                            class="form-control" value="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Paso 3: Asignaciones -->
                        <div class="card shadow-sm mb-3">
                            <div class="card-header bg-white border-bottom">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <span class="badge badge-primary mr-2">3</span><b>Asignaciones de Docentes</b>
                                        <span class="ml-2 badge badge-pill badge-info"
                                            id="contadorAsignaciones">0/8</span>
                                    </div>
                                    <span id="checkAsignaciones"><i class="fas fa-circle text-muted"></i></span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info mb-3"><i class="fas fa-info-circle mr-2"></i>
                                    <strong>Instrucciones:</strong> Las asignaciones se cargarán automáticamente al
                                    seleccionar el grupo y período escolar.</div>
                                <div id="loadingAsignaciones" class="text-center py-4" style="display: none;">
                                    <div class="spinner-border text-primary" role="status"><span
                                            class="sr-only">Cargando...</span></div>
                                    <p class="mt-2 text-muted">Cargando asignaciones disponibles...</p>
                                </div>
                                <div id="mensajeSeleccionPrevia" class="alert alert-warning">
                                    Selecciona un grupo y período escolar para cargar las asignaciones disponibles.
                                </div>
                                <div id="asignacionesContainer" style="display: none;">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="font-weight-bold">
                                                <i class="fas fa-list mr-2"></i>Asignaciones Disponibles
                                                <span class="badge badge-primary" id="totalAsignaciones">0
                                                    materias</span>
                                            </label>
                                            <small class="text-muted">Selecciona hasta 8 materias</small>
                                            <div id="listaAsignacionesDisponibles" class="border rounded p-3 bg-white"
                                                style="max-height: 400px; overflow-y: auto;"></div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="card border-success">
                                                <div
                                                    class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                                                    <div><i class="fas fa-check-double mr-2"></i>Asignaciones
                                                        Seleccionadas<span class="badge badge-light ml-2"
                                                            id="contadorSeleccionadas">0</span></div>
                                                    <button type="button" id="btnLimpiarAsignaciones"
                                                        class="btn btn-sm btn-light" style="display: none;"><i
                                                            class="fas fa-times mr-1"></i> Limpiar</button>
                                                </div>
                                                <div class="card-body">
                                                    <div id="listaAsignacionesSeleccionadas" class="p-2"
                                                        style="min-height: 100px; max-height: 200px; overflow-y: auto;">
                                                        <div class="text-center text-muted py-4">
                                                            <i class="fas fa-inbox fa-2x mb-2"></i>
                                                            <p class="mb-0">No hay asignaciones seleccionadas</p>
                                                            <small>Marca los checkboxes para seleccionar
                                                                materias</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="asignaciones" id="asignacionesInput">
                                </div>
                                <div id="sinAsignaciones" class="alert alert-warning" style="display: none;">
                                    <i class="fas fa-exclamation-triangle mr-2"></i> No hay asignaciones disponibles.
                                </div>
                            </div>
                        </div>

                        <!-- Paso 4: Status -->
                        <div class="card shadow-sm mb-3">
                            <div class="card-header bg-white border-bottom">
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-primary mr-2">4</span><b>Status Académico (Opcional)</b>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="font-weight-bold">Status Inicio</label>
                                        <select name="id_status_inicio" class="form-control custom-select">
                                            <option value="">-- Selecciona --</option>
                                            @foreach ($statusAcademicos as $status)
                                                <option value="{{ $status->id_status_academico }}">
                                                    {{ $status->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="font-weight-bold">Status Terminación</label>
                                        <select name="id_status_terminacion" class="form-control custom-select">
                                            <option value="">-- Selecciona --</option>
                                            @foreach ($statusAcademicos as $status)
                                                <option value="{{ $status->id_status_academico }}">
                                                    {{ $status->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="font-weight-bold">Estatus Historial</label>
                                        <select name="id_historial_status" class="form-control custom-select">
                                            @foreach ($historialStatus as $status)
                                                <option value="{{ $status->id_historial_status }}"
                                                    {{ $status->id_historial_status == 1 ? 'selected' : '' }}>
                                                    {{ $status->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="datos" id="datosAdicionales">
                        <div class="modal-footer border-top">
                            <button type="button" class="btn btn-light" data-dismiss="modal"><i
                                    class="fas fa-times mr-1"></i> Cancelar</button>
                            <button type="submit" class="btn btn-success" id="btnGuardar" disabled><i
                                    class="fas fa-save mr-1"></i> Guardar Reinscripción</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('libs/sbadmin/js/sb-admin-2.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Variables globales
            let asignacionesSeleccionadas = [];
            let asignacionesDisponibles = [];

            // === DOM Elements ===
            const buscarMatricula = document.getElementById('buscarMatricula');
            const btnBuscarAlumno = document.getElementById('btnBuscarAlumno');
            const idAlumno = document.getElementById('id_alumno');
            const alumnoInfo = document.getElementById('alumnoInfo');
            const nombreAlumnoDisplay = document.getElementById('nombreAlumnoDisplay');
            const matriculaDisplay = document.getElementById('matriculaDisplay');
            const carreraDisplay = document.getElementById('carreraDisplay');
            const grupoDisplay = document.getElementById('grupoDisplay');
            const grupoSelect = document.getElementById('grupoSelect');
            const periodoSelect = document.getElementById('periodoSelect');
            const numeroPeriodoSelect = document.getElementById('numeroPeriodoSelect');
            const listaAsignacionesDisponibles = document.getElementById('listaAsignacionesDisponibles');
            const listaAsignacionesSeleccionadas = document.getElementById('listaAsignacionesSeleccionadas');
            const asignacionesInput = document.getElementById('asignacionesInput');
            const totalAsignaciones = document.getElementById('totalAsignaciones');
            const contadorAsignaciones = document.getElementById('contadorAsignaciones');
            const btnLimpiarAsignaciones = document.getElementById('btnLimpiarAsignaciones');
            const loadingAsignaciones = document.getElementById('loadingAsignaciones');
            const asignacionesContainer = document.getElementById('asignacionesContainer');
            const mensajeSeleccionPrevia = document.getElementById('mensajeSeleccionPrevia');
            const sinAsignaciones = document.getElementById('sinAsignaciones');
            const form = document.getElementById('formNuevaReinscripcion');
            const btnGuardar = document.getElementById('btnGuardar');

            // === Funciones ===
            function mostrarAlerta(mensaje, tipo = 'info') {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: tipo,
                        title: mensaje,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                } else {
                    alert(mensaje);
                }
            }

            function validarFormulario() {
                const esValido = idAlumno.value && grupoSelect.value && periodoSelect.value &&
                    numeroPeriodoSelect.value && asignacionesSeleccionadas.length > 0;
                btnGuardar.disabled = !esValido;
                actualizarBarraProgreso();
                actualizarChecks();
            }

            function actualizarBarraProgreso() {
                const campos = [idAlumno.value, grupoSelect.value, periodoSelect.value, numeroPeriodoSelect.value,
                    asignacionesSeleccionadas.length > 0
                ];
                const progreso = (campos.filter(Boolean).length / 5) * 100;
                const progressBar = document.getElementById('progressBar');
                const progressText = document.getElementById('progressText');
                if (!progressBar || !progressText) return;

                progressBar.style.width = progreso + '%';
                if (progreso === 100) {
                    progressText.textContent = '¡Formulario completo! Listo para guardar';
                    progressText.className = 'text-success font-weight-bold';
                } else {
                    progressText.textContent =
                    `Progreso: ${Math.round(progreso)}% - Completa los campos requeridos`;
                    progressText.className = 'text-muted';
                }
            }

            function actualizarChecks() {
                const checkAlumno = document.getElementById('checkAlumno');
                const checkDatos = document.getElementById('checkDatos');
                const checkAsignaciones = document.getElementById('checkAsignaciones');
                if (checkAlumno) checkAlumno.innerHTML = idAlumno.value ?
                    '<i class="fas fa-check-circle text-success"></i>' : '<i class="fas fa-circle text-muted"></i>';
                if (checkDatos) checkDatos.innerHTML = (grupoSelect.value && periodoSelect.value &&
                        numeroPeriodoSelect.value) ?
                    '<i class="fas fa-check-circle text-success"></i>' : '<i class="fas fa-circle text-muted"></i>';
                if (checkAsignaciones) checkAsignaciones.innerHTML = asignacionesSeleccionadas.length > 0 ?
                    '<i class="fas fa-check-circle text-success"></i>' : '<i class="fas fa-circle text-muted"></i>';
            }

            function buscarAlumno() {
                const matricula = buscarMatricula.value.trim();
                if (!matricula) return mostrarAlerta('Ingresa una matrícula', 'warning');

                btnBuscarAlumno.disabled = true;
                btnBuscarAlumno.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Buscando...';

                fetch(`/buscar-alumno?matricula=${encodeURIComponent(matricula)}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            idAlumno.value = data.id_alumno;
                            nombreAlumnoDisplay.textContent = data.nombre;
                            matriculaDisplay.textContent = matricula;
                            carreraDisplay.textContent = data.carrera || 'N/A';
                            grupoDisplay.textContent = data.grupo || 'N/A';
                            alumnoInfo.style.display = 'block';
                        } else {
                            idAlumno.value = '';
                            alumnoInfo.style.display = 'none';
                            mostrarAlerta(data.message || 'Alumno no encontrado', 'info');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        mostrarAlerta('Error al buscar alumno', 'error');
                        idAlumno.value = '';
                        alumnoInfo.style.display = 'none';
                    })
                    .finally(() => {
                        btnBuscarAlumno.disabled = false;
                        btnBuscarAlumno.innerHTML = '<i class="fas fa-search mr-1"></i> Buscar';
                        validarFormulario();
                    });
            }

            function cargarAsignaciones() {
                const idGrupo = grupoSelect.value;
                const idPeriodo = periodoSelect.value;
                if (!idGrupo || !idPeriodo) {
                    resetearAsignaciones();
                    return;
                }

                loadingAsignaciones.style.display = 'block';
                asignacionesContainer.style.display = 'none';
                mensajeSeleccionPrevia.style.display = 'none';
                sinAsignaciones.style.display = 'none';

                fetch(`/asignaciones/disponibles?grupo=${idGrupo}&periodo=${idPeriodo}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.success && data.asignaciones) {
                            asignacionesDisponibles = data.asignaciones;
                            mostrarAsignaciones();
                        } else {
                            resetearAsignaciones();
                            sinAsignaciones.style.display = 'block';
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        resetearAsignaciones();
                        sinAsignaciones.style.display = 'block';
                        sinAsignaciones.innerHTML =
                            '<i class="fas fa-exclamation-circle mr-2"></i> Error al cargar asignaciones';
                    })
                    .finally(() => {
                        loadingAsignaciones.style.display = 'none';
                    });
            }

            function mostrarAsignaciones() {
                listaAsignacionesDisponibles.innerHTML = '';
                totalAsignaciones.textContent = `${asignacionesDisponibles.length} materias`;
                asignacionesDisponibles.forEach(asignacion => {
                    const isSelected = asignacionesSeleccionadas.some(a => a.id_asignacion === asignacion
                        .id_asignacion);
                    const div = document.createElement('div');
                    div.className = `asignacion-card ${isSelected ? 'selected' : ''}`;
                    div.innerHTML = `
                        <div class="d-flex align-items-start">
                            <input type="checkbox" class="asignacion-checkbox" id="asignacion_${asignacion.id_asignacion}" ${isSelected ? 'checked' : ''}>
                            <div class="materia-info">
                                <label class="materia-nombre">${asignacion.materia_nombre || 'Sin nombre'}</label>
                                <div class="materia-detalle"><strong>Docente:</strong> ${asignacion.docente_nombre || 'No asignado'}</div>
                                <div class="materia-detalle"><strong>Horas:</strong> ${asignacion.horas_semana || '0'} hrs/semana</div>
                            </div>
                            ${isSelected ? '<div class="asignacion-indicador"><i class="fas fa-check-circle text-success"></i></div>' : ''}
                        </div>
                    `;
                    div.querySelector('.asignacion-checkbox').addEventListener('change', () =>
                        toggleAsignacion(asignacion.id_asignacion));
                    listaAsignacionesDisponibles.appendChild(div);
                });
                asignacionesContainer.style.display = 'block';
                actualizarVistaSeleccionadas();
                validarFormulario();
            }

            function toggleAsignacion(idAsignacion) {
                const index = asignacionesSeleccionadas.findIndex(a => a.id_asignacion === idAsignacion);
                if (index > -1) {
                    asignacionesSeleccionadas.splice(index, 1);
                } else {
                    if (asignacionesSeleccionadas.length >= 8) {
                        mostrarAlerta('Máximo 8 asignaciones permitidas', 'warning');
                        return;
                    }
                    const asignacion = asignacionesDisponibles.find(a => a.id_asignacion === idAsignacion);
                    if (asignacion) asignacionesSeleccionadas.push(asignacion);
                }
                mostrarAsignaciones();
                actualizarVistaSeleccionadas();
                asignacionesInput.value = JSON.stringify(asignacionesSeleccionadas.map(a => a.id_asignacion));
            }

            function actualizarVistaSeleccionadas() {
                listaAsignacionesSeleccionadas.innerHTML = '';
                if (asignacionesSeleccionadas.length === 0) {
                    listaAsignacionesSeleccionadas.innerHTML = `
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-inbox fa-2x mb-2"></i>
                            <p class="mb-0">No hay asignaciones seleccionadas</p>
                            <small>Haz clic en las materias para seleccionarlas</small>
                        </div>
                    `;
                    btnLimpiarAsignaciones.style.display = 'none';
                } else {
                    asignacionesSeleccionadas.forEach((asignacion, i) => {
                        const div = document.createElement('div');
                        div.className = 'asignacion-seleccionada-item';
                        div.innerHTML = `
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="flex-grow-1">
                                    <strong>${i + 1}. ${asignacion.materia_nombre || 'Sin nombre'}</strong><br>
                                    <small class="text-muted"><i class="fas fa-user-tie mr-1"></i>${asignacion.docente_nombre || 'No asignado'}</small>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="toggleAsignacion(${asignacion.id_asignacion})">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        `;
                        listaAsignacionesSeleccionadas.appendChild(div);
                    });
                    btnLimpiarAsignaciones.style.display = 'block';
                }
                contadorAsignaciones.textContent = `${asignacionesSeleccionadas.length}/8`;
            }

            function resetearAsignaciones() {
                asignacionesSeleccionadas = [];
                asignacionesDisponibles = [];
                asignacionesContainer.style.display = 'none';
                mensajeSeleccionPrevia.style.display = 'block';
                sinAsignaciones.style.display = 'none';
                asignacionesInput.value = '[]';
                actualizarVistaSeleccionadas();
                contadorAsignaciones.textContent = '0/8';
            }

            function limpiarAsignaciones() {
                if (confirm(`¿Limpiar todas las ${asignacionesSeleccionadas.length} asignaciones?`)) {
                    asignacionesSeleccionadas = [];
                    mostrarAsignaciones();
                    asignacionesInput.value = '[]';
                    validarFormulario();
                }
            }

            // === Eventos ===
            btnBuscarAlumno.addEventListener('click', buscarAlumno);
            buscarMatricula.addEventListener('keypress', e => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    buscarAlumno();
                }
            });

            grupoSelect.addEventListener('change', cargarAsignaciones);
            periodoSelect.addEventListener('change', cargarAsignaciones);
            numeroPeriodoSelect.addEventListener('change', validarFormulario);
            btnLimpiarAsignaciones.addEventListener('click', limpiarAsignaciones);

            // === Modal reset ===
            $('#nuevaReinscripcionModal').on('hidden.bs.modal', () => {
                form.reset();
                idAlumno.value = '';
                alumnoInfo.style.display = 'none';
                resetearAsignaciones();
                document.querySelectorAll('.fas.fa-check-circle').forEach(el => {
                    el.parentNode.innerHTML = '<i class="fas fa-circle text-muted"></i>';
                });
                document.getElementById('progressBar').style.width = '0%';
                document.getElementById('progressText').textContent = 'Completa los campos requeridos';
                btnGuardar.disabled = true;
            });

            // Exponer funciones globales
            window.toggleAsignacion = toggleAsignacion;
        });
    </script>

    <script>
$(document).ready(function() {
    let alumnosData = [];
    let materiasData = [];
    let selectAllState = false;
    let selectAllMateriasState = false;

    // ============================================
    // PASO 1: CARGAR DATOS
    // ============================================
    $('#btnCargarDatos').click(function() {
        const grupoId = $('#grupoActual').val();
        const periodoId = $('#periodoEscolar').val();

        if (!grupoId || !periodoId) {
            alert('⚠️ Por favor selecciona grupo y período');
            return;
        }

        const btn = $(this);
        btn.prop('disabled', true).html('<span class="loading-spinner mr-2"></span>Cargando datos...');

        // Cargar alumnos y materias en paralelo
        Promise.all([
            cargarAlumnos(grupoId, periodoId),
            cargarMaterias(grupoId, periodoId)
        ]).then(([alumnos, materias]) => {
            if (alumnos.length > 0 && materias.length > 0) {
                alumnosData = alumnos.map(a => ({
                    ...a,
                    selected: false,
                    statusInicio: '',
                    statusTerminacion: '',
                    materias: [] // Materias asignadas a este alumno
                }));

                materiasData = materias.map(m => ({
                    ...m,
                    selected: false
                }));

                renderMaterias();
                $('#cardMaterias').slideDown();
                $('#panelConfiguracion').slideDown();
                updateProgress(33);
                
                alert(`✅ Datos cargados: ${alumnos.length} alumnos y ${materias.length} materias`);
            } else {
                alert('⚠️ No se encontraron alumnos o materias para este grupo');
            }
        }).catch(err => {
            alert('❌ Error al cargar datos: ' + err.message);
        }).finally(() => {
            btn.prop('disabled', false).html('<i class="fas fa-rocket mr-2"></i>Cargar Alumnos y Materias');
        });
    });

    function cargarAlumnos(grupoId, periodoId) {
        return $.ajax({
            url: "{{ route('historial.obtener-alumnos-grupo') }}",
            method: 'POST',
            data: {
                id_grupo: grupoId,
                id_periodo: periodoId,
                _token: $('meta[name="csrf-token"]').attr('content')
            }
        }).then(response => {
            if (response.success) {
                return response.alumnos;
            }
            throw new Error('No se pudieron cargar los alumnos');
        });
    }

    function cargarMaterias(grupoId, periodoId) {
        return $.ajax({
            url: "{{ route('asignaciones.obtener-materias-grupo') }}",
            method: 'POST',
            data: {
                id_grupo: grupoId,
                id_periodo: periodoId,
                _token: $('meta[name="csrf-token"]').attr('content')
            }
        }).then(response => {
            if (response.success) {
                return response.materias;
            }
            throw new Error('No se pudieron cargar las materias');
        });
    }

    // ============================================
    // PASO 2: RENDERIZAR Y SELECCIONAR MATERIAS
    // ============================================
    function renderMaterias() {
        let html = '';
        
        materiasData.forEach((materia, index) => {
            html += `
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="materia-item ${materia.selected ? 'selected' : ''}" data-index="${index}">
                        <div class="d-flex align-items-start">
                            <input type="checkbox" 
                                   class="materia-checkbox mr-3" 
                                   data-index="${index}"
                                   ${materia.selected ? 'checked' : ''}>
                            <div class="flex-grow-1">
                                <h6 class="font-weight-bold mb-2">${materia.nombre}</h6>
                                <div class="d-flex align-items-center mb-1">
                                    <span class="docente-badge mr-2">
                                        <i class="fas fa-chalkboard-teacher mr-1"></i>${materia.docente || 'Sin docente'}
                                    </span>
                                </div>
                                <small class="text-muted">
                                    <i class="fas fa-clock mr-1"></i>${materia.horas || 0} hrs/semana
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });

        $('#materiasContainer').html(`<div class="col-12"><div class="row">${html}</div></div>`);
        $('#totalMaterias').text(materiasData.length);
    }

    // Toggle materia
    $(document).on('change', '.materia-checkbox', function() {
        const index = $(this).data('index');
        materiasData[index].selected = $(this).is(':checked');
        
        $(this).closest('.materia-item').toggleClass('selected', materiasData[index].selected);
        
        updateStats();
        updateProgress(materiasData.some(m => m.selected) ? 66 : 33);
        $('#checkPaso2 i').attr('class', materiasData.some(m => m.selected) ? 'fas fa-check-circle text-white' : 'fas fa-circle text-white-50');
        
        // Si hay materias seleccionadas, mostrar paso 3
        if (materiasData.some(m => m.selected)) {
            renderAlumnos();
            $('#cardAlumnos').slideDown();
            $('#btnGuardarReinscripciones').slideDown();
        }
    });

    // Click en tarjeta de materia
    $(document).on('click', '.materia-item', function(e) {
        if (!$(e.target).is('input')) {
            const checkbox = $(this).find('.materia-checkbox');
            checkbox.prop('checked', !checkbox.prop('checked')).trigger('change');
        }
    });

    // Seleccionar todas las materias
    $('#btnSelectAllMaterias').click(function() {
        selectAllMateriasState = !selectAllMateriasState;
        materiasData.forEach(m => m.selected = selectAllMateriasState);
        renderMaterias();
        updateStats();
        
        $('#selectAllMateriasText').text(selectAllMateriasState ? 'Deseleccionar Todas' : 'Seleccionar Todas');
        
        if (selectAllMateriasState) {
            renderAlumnos();
            $('#cardAlumnos').slideDown();
            $('#btnGuardarReinscripciones').slideDown();
            updateProgress(66);
        }
    });

    // ============================================
    // PASO 3: RENDERIZAR ALUMNOS CON MATERIAS
    // ============================================
    function renderAlumnos() {
        const materiasSeleccionadas = materiasData.filter(m => m.selected);
        
        if (materiasSeleccionadas.length === 0) {
            $('#alumnosContainer').html(`
                <div class="empty-state">
                    <i class="fas fa-exclamation-triangle text-warning"></i>
                    <h5 class="font-weight-bold">Selecciona al menos una materia</h5>
                    <p>Ve al paso 2 y selecciona las materias que deseas asignar</p>
                </div>
            `);
            return;
        }

        let html = '';
        
        alumnosData.forEach((alumno, index) => {
            // Si el alumno no tiene materias asignadas, asignar todas las seleccionadas por defecto
            if (alumno.materias.length === 0) {
                alumno.materias = materiasSeleccionadas.map(m => m.id);
            }

            html += `
                <div class="alumno-card ${alumno.selected ? 'selected' : ''}" data-index="${index}">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="d-flex align-items-center">
                                <input type="checkbox" 
                                       class="checkbox-custom mr-3 alumno-checkbox" 
                                       data-index="${index}"
                                       ${alumno.selected ? 'checked' : ''}>
                                <div class="flex-grow-1">
                                    <h6 class="font-weight-bold mb-1">${alumno.nombre}</h6>
                                    <span class="matricula-badge">${alumno.matricula}</span>
                                    <span class="contador-materias ml-2">
                                        <i class="fas fa-book mr-1"></i>${alumno.materias.length} materias
                                    </span>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary btn-toggle-materias" 
                                        data-index="${index}" ${!alumno.selected ? 'disabled' : ''}>
                                    <i class="fas fa-cog mr-1"></i> Personalizar Materias
                                </button>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="small font-weight-bold mb-1">Status Inicio *</label>
                            <select class="form-control form-control-sm status-inicio" 
                                    data-index="${index}" ${!alumno.selected ? 'disabled' : ''}>
                                <option value="">-- Seleccionar --</option>
                                @foreach($statusAcademicos as $status)
                                    <option value="{{ $status->id_status_academico }}" 
                                            ${alumno.statusInicio == '{{ $status->id_status_academico }}' ? 'selected' : ''}>
                                        {{ $status->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="small font-weight-bold mb-1">Status Terminación</label>
                            <select class="form-control form-control-sm status-terminacion" 
                                    data-index="${index}" ${!alumno.selected ? 'disabled' : ''}>
                                <option value="">-- Seleccionar --</option>
                                @foreach($statusAcademicos as $status)
                                    <option value="{{ $status->id_status_academico }}"
                                            ${alumno.statusTerminacion == '{{ $status->id_status_academico }}' ? 'selected' : ''}>
                                        {{ $status->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="small font-weight-bold mb-1">Materias Asignadas</label>
                            <div class="alumno-materias-preview" id="preview-${index}">
                                ${renderMateriasPreview(alumno.materias)}
                            </div>
                        </div>

                        <!-- Panel expandible de materias -->
                        <div class="col-md-12 materias-panel" id="materias-panel-${index}" style="display: none;">
                            <hr>
                            <h6 class="font-weight-bold mb-3">
                                <i class="fas fa-list-check mr-2"></i>Selecciona las materias para ${alumno.nombre.split(' ')[0]}
                            </h6>
                            <div class="row">
                                ${renderMateriasParaAlumno(alumno, index)}
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });

        $('#alumnosContainer').html(html);
        $('#statsContainer').show();
        updateStats();
    }

    function renderMateriasPreview(materiasIds) {
        if (materiasIds.length === 0) return '<small class="text-muted">Sin materias</small>';
        
        return materiasIds.slice(0, 3).map(id => {
            const materia = materiasData.find(m => m.id === id);
            return `<span class="materia-badge">${materia ? materia.nombre.substring(0, 15) + '...' : 'N/A'}</span>`;
        }).join('') + (materiasIds.length > 3 ? `<span class="materia-badge">+${materiasIds.length - 3} más</span>` : '');
    }

    function renderMateriasParaAlumno(alumno, alumnoIndex) {
        const materiasSeleccionadas = materiasData.filter(m => m.selected);
        
        return materiasSeleccionadas.map((materia, materiaIndex) => {
            const isChecked = alumno.materias.includes(materia.id);
            return `
                <div class="col-md-6 col-lg-4 mb-2">
                    <label class="d-flex align-items-center p-2 border rounded" style="cursor: pointer;">
                        <input type="checkbox" 
                               class="mr-2 materia-alumno-checkbox" 
                               data-alumno="${alumnoIndex}" 
                               data-materia="${materia.id}"
                               ${isChecked ? 'checked' : ''}>
                        <small class="font-weight-bold">${materia.nombre}</small>
                    </label>
                </div>
            `;
        }).join('');
    }

    // Toggle panel de materias por alumno
    $(document).on('click', '.btn-toggle-materias', function() {
        const index = $(this).data('index');
        const panel = $(`#materias-panel-${index}`);
        panel.slideToggle();
        $(this).find('i').toggleClass('fa-cog fa-times');
    });

    // Toggle materia individual por alumno
    $(document).on('change', '.materia-alumno-checkbox', function() {
        const alumnoIndex = $(this).data('alumno');
        const materiaId = $(this).data('materia');
        const isChecked = $(this).is(':checked');

        if (isChecked) {
            if (!alumnosData[alumnoIndex].materias.includes(materiaId)) {
                alumnosData[alumnoIndex].materias.push(materiaId);
            }
        } else {
            alumnosData[alumnoIndex].materias = alumnosData[alumnoIndex].materias.filter(id => id !== materiaId);
        }

        // Actualizar preview
        $(`#preview-${alumnoIndex}`).html(renderMateriasPreview(alumnosData[alumnoIndex].materias));
        
        // Actualizar contador
        $(`.alumno-card[data-index="${alumnoIndex}"] .contador-materias`).html(
            `<i class="fas fa-book mr-1"></i>${alumnosData[alumnoIndex].materias.length} materias`
        );

        updateStats();
    });

    // Toggle alumno
    $(document).on('change', '.alumno-checkbox', function() {
        const index = $(this).data('index');
        alumnosData[index].selected = $(this).is(':checked');
        
        const card = $(this).closest('.alumno-card');
        card.toggleClass('selected', alumnosData[index].selected);
        
        card.find('.status-inicio, .status-terminacion, .btn-toggle-materias').prop('disabled', !alumnosData[index].selected);
        
        updateStats();
    });

    // Click en tarjeta de alumno
    $(document).on('click', '.alumno-card', function(e) {
        if (!$(e.target).is('select, input, button, label, i')) {
            const checkbox = $(this).find('.alumno-checkbox');
            checkbox.prop('checked', !checkbox.prop('checked')).trigger('change');
        }
    });

    // Seleccionar todos los alumnos
    $('#btnSelectAll').click(function() {
        selectAllState = !selectAllState;
        alumnosData.forEach(a => a.selected = selectAllState);
        renderAlumnos();
        
        $('#selectAllText').text(selectAllState ? 'Deseleccionar Todos' : 'Seleccionar Todos');
    });

    // Cambios en status
    $(document).on('change', '.status-inicio', function() {
        const index = $(this).data('index');
        alumnosData[index].statusInicio = $(this).val();
        updateStats();
    });

    $(document).on('change', '.status-terminacion', function() {
        const index = $(this).data('index');
        alumnosData[index].statusTerminacion = $(this).val();
    });

    // ============================================
    // CONFIGURACIÓN MASIVA
    // ============================================
    $('#btnAplicarStatus').click(function() {
        const statusInicio = $('#statusInicioMasivo').val();
        const statusTerminacion = $('#statusTerminacionMasivo').val();

        if (!statusInicio && !statusTerminacion) {
            alert('⚠️ Selecciona al menos un status');
            return;
        }

        const seleccionados = alumnosData.filter(a => a.selected);
        if (seleccionados.length === 0) {
            alert('⚠️ Selecciona al menos un alumno');
            return;
        }

        alumnosData.forEach(alumno => {
            if (alumno.selected) {
                if (statusInicio) alumno.statusInicio = statusInicio;
                if (statusTerminacion) alumno.statusTerminacion = statusTerminacion;
            }
        });

        renderAlumnos();
        $('#statusInicioMasivo, #statusTerminacionMasivo').val('');
        
        alert(`✅ Status aplicado a ${seleccionados.length} alumno(s)`);
    });

    $('#btnAsignarTodasMaterias').click(function() {
        const seleccionados = alumnosData.filter(a => a.selected);
        if (seleccionados.length === 0) {
            alert('⚠️ Selecciona al menos un alumno');
            return;
        }

        const materiasSeleccionadas = materiasData.filter(m => m.selected).map(m => m.id);
        
        alumnosData.forEach(alumno => {
            if (alumno.selected) {
                alumno.materias = [...materiasSeleccionadas];
            }
        });

        renderAlumnos();
        alert(`✅ Todas las materias asignadas a ${seleccionados.length} alumno(s)`);
    });

    // ============================================
    // ESTADÍSTICAS Y PROGRESO
    // ============================================
    function updateStats() {
        const total = alumnosData.length;
        const seleccionados = alumnosData.filter(a => a.selected).length;
        const configurados = alumnosData.filter(a => a.selected && a.statusInicio && a.materias.length > 0).length;
        const materiasActivas = materiasData.filter(m => m.selected).length;

        $('#totalAlumnos').text(total);
        $('#alumnosSeleccionados').text(seleccionados);
        $('#alumnosConfigurados').text(configurados);
        $('#materiasSeleccionadas').text(materiasActivas);

        const paso3Valid = seleccionados > 0 && seleccionados === configurados;
        $('#checkPaso3 i').attr('class', paso3Valid ? 'fas fa-check-circle text-white' : 'fas fa-circle text-white-50');
        
        if (paso3Valid) {
            updateProgress(100);
        }
    }

    function updateProgress(percent) {
        $('#progressBar').css('width', percent + '%');
        
        if (percent === 33) {
            $('#progressText').text('Paso 1 de 3: Configuración completada');
        } else if (percent === 66) {
            $('#progressText').text('Paso 2 de 3: Materias seleccionadas');
        } else if (percent === 100) {
            $('#progressText').html('<strong class="text-success">✓ Listo para guardar</strong>');
        }
    }

    // ============================================
    // GUARDAR REINSCRIPCIONES
    // ============================================
    $('#btnGuardarReinscripciones').click(function() {
        const seleccionados = alumnosData.filter(a => a.selected);
        
        if (seleccionados.length === 0) {
            alert('⚠️ Debes seleccionar al menos un alumno');
            return;
        }

        const sinStatus = seleccionados.filter(a => !a.statusInicio);
        if (sinStatus.length > 0) {
            alert(`⚠️ ${sinStatus.length} alumno(s) sin Status Inicio`);
            return;
        }

        const sinMaterias = seleccionados.filter(a => a.materias.length === 0);
        if (sinMaterias.length > 0) {
            alert(`⚠️ ${sinMaterias.length} alumno(s) sin materias asignadas`);
            return;
        }

        const formData = new FormData($('#formReinscripcionMasiva')[0]);
        
        // Agregar datos de alumnos con sus materias
        seleccionados.forEach((alumno, idx) => {
            formData.append(`alumnos[${idx}][id_alumno]`, alumno.id);
            formData.append(`alumnos[${idx}][id_status_inicio]`, alumno.statusInicio);
            if (alumno.statusTerminacion) {
                formData.append(`alumnos[${idx}][id_status_terminacion]`, alumno.statusTerminacion);
            }
            formData.append(`alumnos[${idx}][fecha_inscripcion]`, $('#fechaInscripcion').val());
            
            // Agregar materias del alumno
            alumno.materias.forEach((materiaId, mIdx) => {
                formData.append(`alumnos[${idx}][materias][${mIdx}]`, materiaId);
            });
        });

        const btn = $(this);
        btn.prop('disabled', true).html('<span class="loading-spinner mr-2"></span>Guardando...');

        $.ajax({
            url: $('#formReinscripcionMasiva').attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    alert(`✅ ${response.message}\n\n` +
                          `Reinscripciones: ${response.reinscripciones}\n` +
                          `Materias asignadas: ${response.materias_asignadas || 'N/A'}`);
                    window.location.href = "{{ route('historial.index') }}";
                } else {
                    alert('❌ ' + (response.message || 'Error al guardar'));
                    btn.prop('disabled', false).html('<i class="fas fa-save mr-2"></i>Guardar Reinscripciones');
                }
            },
            error: function(xhr) {
                alert('❌ Error: ' + (xhr.responseJSON?.message || 'Error al procesar'));
                btn.prop('disabled', false).html('<i class="fas fa-save mr-2"></i>Guardar Reinscripciones');
            }
        });
    });

    // ============================================
    // RESET AL CERRAR MODAL
    // ============================================
    $('#modalReinscripcionMasiva').on('hidden.bs.modal', function() {
        $('#formReinscripcionMasiva')[0].reset();
        alumnosData = [];
        materiasData = [];
        selectAllState = false;
        selectAllMateriasState = false;
        
        $('#cardMaterias, #cardAlumnos, #panelConfiguracion, #btnGuardarReinscripciones').hide();
        $('#statsContainer').hide();
        
        updateProgress(0);
        $('#progressText').text('Paso 1 de 3: Configuración inicial');
        
        $('#checkPaso1 i, #checkPaso2 i, #checkPaso3 i').attr('class', 'fas fa-circle text-white-50');
        $('#selectAllText').text('Seleccionar Todos');
        $('#selectAllMateriasText').text('Seleccionar Todas');
    });

    // Validación inicial
    $('#grupoActual, #periodoEscolar').change(function() {
        const valid = $('#grupoActual').val() && $('#periodoEscolar').val();
        $('#checkPaso1 i').attr('class', valid ? 'fas fa-check-circle text-white' : 'fas fa-circle text-white-50');
    });
});
</script>
</body>

</html>
