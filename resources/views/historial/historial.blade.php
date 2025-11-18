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
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1" href="{{ route('admin') }}">Inicio</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1" href="{{ route('periodos.index') }}">Períodos Escolares</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1" href="{{ route('carreras.index') }}">Carreras</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1" href="{{ route('materias.index') }}">Materias</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1" href="{{ route('planes.index') }}">Planes de estudio</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1" href="{{ route('alumnos.index') }}">Alumnos</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1" href="{{ route('asignaciones.index') }}">Asignaciones Docentes</a></li>
                <li class="nav-item"><a class="nav-link navbar-active-item px-3" href="{{ route('historial.index') }}">Historial</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1" href="{{ route('calificaciones.index') }}">Calificaciones</a></li>

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
                                <button type="button" class="btn btn-info mr-2" data-toggle="modal"
                                    data-target="#modalReinscripcionMasiva">
                                    <i class="fas fa-users"></i> Promoción
                                </button>
                                <button type="button" class="btn btn-info mr-2" data-toggle="modal"
                                    data-target="#modalReinscripcionMasivaAvanzada">
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
        <div class="modal fade" id="verHistorialModal{{ $registro->id_historial }}" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title w-100 text-center font-weight-bold">
                            <i class="fas fa-eye mr-2"></i>Detalles de Reinscripción
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-3">
                        {{-- Información del Alumno --}}
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <h6 class="font-weight-bold text-primary mb-1">
                                    @if ($registro->alumno)
                                        {{ $registro->alumno->datosPersonales->nombres ?? 'N/A' }}
                                        {{ $registro->alumno->datosPersonales->primer_apellido ?? '' }}
                                        {{ $registro->alumno->datosPersonales->segundo_apellido ?? '' }}
                                    @else
                                        <span class="text-muted">Alumno no disponible</span>
                                    @endif
                                </h6>
                                <p class="text-muted mb-0 small">
                                    <i class="fas fa-id-card mr-1"></i>Matrícula:
                                    <strong>{{ $registro->alumno->datosAcademicos->matricula ?? 'N/A' }}</strong>
                                    <span class="mx-2">|</span>
                                    <i class="fas fa-graduation-cap mr-1"></i>Carrera:
                                    <strong>{{ $registro->alumno->datosAcademicos->carrera->nombre ?? 'N/A' }}</strong>
                                </p>
                            </div>
                            <div class="col-md-4 text-right">
                                <span class="badge badge-lg badge-info">
                                    <i class="fas fa-calendar-check mr-1"></i>
                                    {{ $registro->fecha_inscripcion ? \Carbon\Carbon::parse($registro->fecha_inscripcion)->format('d/m/Y') : 'N/A' }}
                                </span>
                            </div>
                        </div>

                        {{-- Datos de Período y Grupo --}}
                        <div class="card border mb-3">
                            <div class="card-header bg-light py-2">
                                <h6 class="mb-0 font-weight-bold">
                                    <i class="fas fa-info-circle mr-2 text-info"></i>Información del Período
                                </h6>
                            </div>
                            <div class="card-body p-3">
                                <div class="row">
                                    @php
                                        // Obtener grupo y período desde la primera asignación
                                        $primeraAsignacion = $registro->asignacion1;
                                        $grupo = $primeraAsignacion->grupo ?? null;
                                        $periodo = $primeraAsignacion->periodoEscolar ?? null;
                                    @endphp
                                    <div class="col-md-6 mb-2">
                                        <strong><i class="fas fa-users mr-1 text-muted"></i>Grupo:</strong>
                                        <span class="ml-2">{{ $grupo->nombre ?? 'N/A' }}</span>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <strong><i class="fas fa-calendar-alt mr-1 text-muted"></i>Período
                                            Escolar:</strong>
                                        <span class="ml-2">{{ $periodo->nombre ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="card border h-100">
                                    <div class="card-header bg-success text-white py-2">
                                        <h6 class="mb-0 font-weight-bold">
                                            <i class="fas fa-play-circle mr-1"></i>Status Inicio
                                        </h6>
                                    </div>
                                    <div class="card-body p-3 text-center">
                                        <h5 class="mb-0 text-success">
                                            {{ $registro->statusInicio->nombre ?? 'Sin definir' }}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border h-100">
                                    <div class="card-header bg-warning text-white py-2">
                                        <h6 class="mb-0 font-weight-bold">
                                            <i class="fas fa-flag-checkered mr-1"></i>Status Terminación
                                        </h6>
                                    </div>
                                    <div class="card-body p-3 text-center">
                                        <h5 class="mb-0 text-warning">
                                            {{ $registro->statusTerminacion->nombre ?? 'Pendiente' }}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Materias/Asignaciones --}}
                        @php
                            $asignaciones = [];
                            for ($i = 1; $i <= 10; $i++) {
                                $asignacion = $registro->{"asignacion$i"};
                                if ($asignacion && $asignacion->materia) {
                                    $asignaciones[] = $asignacion;
                                }
                            }
                        @endphp

                        @if (count($asignaciones) > 0)
                            <div class="card border">
                                <div class="card-header bg-primary text-white py-2">
                                    <h6 class="mb-0 font-weight-bold">
                                        <i class="fas fa-book-open mr-2"></i>
                                        Materias Cursadas ({{ count($asignaciones) }})
                                    </h6>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover mb-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th width="50" class="text-center">#</th>
                                                    <th>Materia</th>
                                                    <th>Docente</th>
                                                    <th class="text-center">Horas</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($asignaciones as $index => $asignacion)
                                                    <tr>
                                                        <td class="text-center">
                                                            <span
                                                                class="badge badge-secondary">{{ $index + 1 }}</span>
                                                        </td>
                                                        <td>
                                                            <strong>{{ $asignacion->materia->nombre }}</strong>
                                                            @if ($asignacion->materia->clave)
                                                                <br>
                                                                <small class="text-muted">
                                                                    Clave: {{ $asignacion->materia->clave }}
                                                                </small>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($asignacion->docente)
                                                                {{ $asignacion->docente->nombre_completo }}
                                                            @else
                                                                <span class="text-muted">Sin asignar</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="badge badge-info">
                                                                {{ $asignacion->materia->horas ?? 0 }}h
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot class="bg-light">
                                                <tr>
                                                    <td colspan="3" class="text-right"><strong>Total de
                                                            horas:</strong></td>
                                                    <td class="text-center">
                                                        <strong class="text-primary">
                                                            {{ collect($asignaciones)->sum(fn($a) => $a->materia->horas ?? 0) }}h
                                                        </strong>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning text-center">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                No hay materias asignadas en este registro
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer bg-light border-top">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times mr-1"></i>Cerrar
                        </button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal"
                            data-target="#editarHistorialModal{{ $registro->id_historial }}">
                            <i class="fas fa-edit mr-1"></i>Editar
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
                            @csrf
                            @method('PUT')

                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <b>Datos de Reinscripción</b>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Alumno (solo lectura) -->
                                        <!-- Alumno (solo lectura + campo oculto) -->
                                        <div class="col-12 mb-3">
                                            <label><strong>Alumno:</strong></label>
                                            <input type="text" class="form-control" readonly
                                                value="{{ optional($registro->alumno->datosPersonales)->nombres ?? 'N/A' }} {{ optional($registro->alumno->datosPersonales)->primer_apellido ?? '' }} ({{ $registro->alumno->matricula ?? 'N/A' }})">
                                            <input type="hidden" name="id_alumno"
                                                value="{{ $registro->id_alumno }}">
                                        </div>

                                        <!-- Fecha de Inscripción -->
                                        <div class="col-md-6 mb-3">
                                            <label>Fecha de Inscripción <span class="text-danger">*</span></label>
                                            <input type="date" name="fecha_inscripcion"
                                                value="{{ $registro->fecha_inscripcion ? \Carbon\Carbon::parse($registro->fecha_inscripcion)->format('Y-m-d') : '' }}"
                                                class="form-control" required>
                                        </div>

                                        <!-- Status Inicio -->
                                        <div class="col-md-6 mb-3">
                                            <label>Status Inicio <span class="text-danger">*</span></label>
                                            <select name="id_status_inicio" class="form-control" required>
                                                <option value="">Selecciona...</option>
                                                @foreach ($statusAcademicos as $status)
                                                    <option value="{{ $status->id_status_academico }}"
                                                        {{ $registro->id_status_inicio == $status->id_status_academico ? 'selected' : '' }}>
                                                        {{ $status->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Status Terminación -->
                                        <div class="col-md-6 mb-3">
                                            <label>Status Terminación</label>
                                            <select name="id_status_terminacion" class="form-control">
                                                <option value="">Selecciona...</option>
                                                @foreach ($historialStatus as $status)
                                                    <option value="{{ $status->id_historial_status }}"
                                                        {{ $registro->id_status_terminacion == $status->id_historial_status ? 'selected' : '' }}>
                                                        {{ $status->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small class="text-muted">Opcional</small>
                                        </div>

                                        <!-- Materias/Asignaciones -->
                                        <div class="col-12 mb-3">
                                            <label>Materias Asignadas <span class="text-danger">*</span></label>
                                            <select name="materias[]"
                                                class="form-control select-materias materias-editar-{{ $registro->id_historial }}"
                                                multiple required>
                                                <!-- Se llenarán las materias actuales del historial -->
                                                @foreach ($registro->asignaciones as $asignacion)
                                                    <option value="{{ $asignacion->id_asignacion }}" selected>
                                                        {{ $asignacion->materia->nombre ?? 'N/A' }} -
                                                        {{ optional($asignacion->docente->datosPersonales)->nombres ?? 'N/A' }}
                                                        {{ optional($asignacion->docente->datosPersonales)->primer_apellido ?? '' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small class="text-muted">
                                                <i class="fas fa-info-circle"></i> Máximo 10 materias.
                                                Mantén presionado Ctrl (Cmd en Mac) para seleccionar múltiples
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-right mt-4">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                    <i class="fas fa-times"></i> Cancelar
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Guardar Cambios
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <!-- -------------------------------------------------------------- -->

    <!-- Modal PROMOCION -->
    <div class="modal fade" id="modalReinscripcionMasiva" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header modal-header-custom border-0">
                    <div class="w-100 text-center">
                        <h5 class="mb-0 font-weight-bold">
                            👨‍🎓 Promoción de alumnos
                        </h5>
                        <p class="m-0 mt-2 mb-0" style="font-size: 0.9rem; opacity: 0.95;">
                            Asigne estatus múltiples para alumnos de un grupo
                        </p>
                    </div>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar"
                        style="position: absolute; right: 1.5rem; top: 1.5rem; font-size: 1.8rem; opacity: 0.9;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formReinscripcionMasiva" method="POST"
                        action="{{ route('historial.store-masivo') }}">
                        @csrf
                        <div class="form-container p-4 bg-white rounded shadow-sm border">
                            <div class="card shadow mb-2 border-0">
                                <div class="card-header py-3  text-white card-header-custom">
                                    <h6 class="m-0 font-weight-bold">
                                        <i class="fas fa-users"></i> Seleccione el Período Escolar y Grupo
                                    </h6>
                                </div>
                                <div class="card-body1">
                                <div class="row ">
                                    <div class="col-md-6">
                                        <label class="font-weight-bold">Período Escolar <span
                                                class="text-danger">*</span></label>
                                        <select name="id_periodo_escolar" id="periodoEscolarMasivo"
                                            class="form-control" required>
                                            <option value="">-- Selecciona un período --</option>
                                            @foreach ($periodos as $periodo)
                                                <option value="{{ $periodo->id_periodo_escolar }}">
                                                    {{ $periodo->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="font-weight-bold">Grupo <span
                                                class="text-danger">*</span></label>
                                        <select name="id_grupo_actual" id="grupoActualMasivo" class="form-control"
                                            required>
                                            <option value="">-- Selecciona un grupo --</option>
                                            @foreach ($grupos as $grupo)
                                                <option value="{{ $grupo->id_grupo }}">
                                                    {{ $grupo->nombre }} - {{ $grupo->carrera->nombre ?? 'N/A' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="font-weight-bold">Número de Periodo</label>
                                        <input type="text" id="numeroPeriodoDisplay" class="form-control" readonly
                                            placeholder="Se autorellenará">
                                        <input type="hidden" name="id_numero_periodo" id="id_numero_periodo_masivo">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="font-weight-bold">Fecha de Inscripción</label>
                                        <input type="date" name="fecha_inscripcion" class="form-control"
                                            value="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                                </div>
                            </div>
                            <!-- Panel de configuración rápida -->
                            <div class="alert alert-light border mb-3" id="panelConfigRapida" style="display: none;">
                                <div class="row">
                                    <div class="col-md-10">
                                        <select id="statusTerminacionMasivo" class="form-control form-control-sm">
                                            <option value="">-- Status Terminación (Aplicar a seleccionados) --
                                            </option>
                                            @foreach ($historialStatus as $status)
                                                <option value="{{ $status->id_historial_status }}">
                                                    {{ $status->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" id="btnAplicarRapido"
                                            class="btn btn-sm btn-info btn-block">
                                            <i class="fas fa-check mr-1"></i> Aplicar
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div id="contenedorAlumnos" style="display: none;">
                                <h6 class="font-weight-bold mb-2">
                                    <i class="fas fa-user-graduate mr-2"></i>Alumnos del Grupo
                                    <button type="button" id="btnSeleccionarTodos"
                                        class="btn btn-sm btn-outline-secondary float-right">
                                        Seleccionar Todos
                                    </button>
                                </h6>
                                <div id="listaAlumnos"
                                    style="max-height: 400px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; border-radius: 5px;">
                                    <div class="text-center py-3 text-muted">Selecciona grupo y período</div>
                                </div>
                            </div>
                            <input type="hidden" name="alumnos_json" id="alumnosJsonInput">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cancelar
                    </button>
                    <button type="button" id="btnGuardarMasivo" class="btn btn-success" disabled>
                        <i class="fas fa-save mr-1"></i> Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Reinscripción Masiva -->
    <div class="modal fade" id="modalReinscripcionMasivaAvanzada" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content border-0 shadow-lg">
               <div class="modal-header modal-header-custom border-0">
                    <div class="w-100 text-center">
                        <h5 class="mb-0 font-weight-bold">
                            👨‍🎓 Reinscripción Masiva de alumnos
                        </h5>
                        <p class="m-0 mt-2 mb-0" style="font-size: 0.9rem; opacity: 0.95;">
                            Reinscribe múltiples alumnos
                        </p>
                    </div>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar"
                        style="position: absolute; right: 1.5rem; top: 1.5rem; font-size: 1.8rem; opacity: 0.9;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formReinscripcionMasivaAvanzada" method="POST"
                        action="{{ route('historial.store-masivo-avanzado') }}">
                        @csrf
<div class="form-container p-4 bg-white rounded shadow-sm border">
                        <!-- Origen: de dónde vienen los alumnos -->
                        <div class="card shadow mb-2 border-0">
                            <div class="card-header py-3  text-white card-header-custom">
                            <h6 class="m-0 font-weight-bold">
                                🔍 Período Escolar y Grupo Anterior</b>
                            </h6>
                            </div>
                            <div class="card-body1">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>Período Escolar (Origen) <span class="text-danger">*</span></label>
                                        <select name="id_periodo_origen" id="periodoOrigen" class="form-control"
                                            required>
                                            <option value="">-- Selecciona período --</option>
                                            @foreach ($periodos as $p)
                                                <option value="{{ $p->id_periodo_escolar }}">{{ $p->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Grupo (Origen) <span class="text-danger">*</span></label>
                                        <select name="id_grupo_origen" id="grupoOrigen" class="form-control"
                                            required>
                                            <option value="">-- Selecciona grupo --</option>
                                            @foreach ($grupos as $g)
                                                <option value="{{ $g->id_grupo }}">{{ $g->nombre }} -
                                                    {{ $g->carrera->nombre ?? 'N/A' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Destino: a dónde se reinscriben -->
                        <div class="card shadow mb-2 border-0">
                            <div class="card-header py-3  text-white card-header-custom">
                            <h6 class="m-0 font-weight-bold">
                                🎯 Destino: Nuevo período de reinscripción</b>
                            </h6>
                            </div>
                            <div class="card-body1">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>Período Escolar (Destino) <span class="text-danger">*</span></label>
                                        <select name="id_periodo_destino" id="periodoDestino" class="form-control"
                                            required>
                                            <option value="">-- Selecciona período --</option>
                                            @foreach ($periodos as $p)
                                                <option value="{{ $p->id_periodo_escolar }}">{{ $p->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Grupo (Destino) <span class="text-danger">*</span></label>
                                        <select name="id_grupo_destino" id="grupoDestino" class="form-control"
                                            required>
                                            <option value="">-- Selecciona grupo --</option>
                                            @foreach ($grupos as $g)
                                                <option value="{{ $g->id_grupo }}">{{ $g->nombre }} -
                                                    {{ $g->carrera->nombre ?? 'N/A' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Número de Período (Autorellenado)</label>
                                        <input type="text" id="numeroPeriodoDestinoDisplay" class="form-control"
                                            readonly placeholder="Se autorellenará">
                                        <input type="hidden" name="id_numero_periodo_destino"
                                            id="id_numero_periodo_destino">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Fecha de Inscripción</label>
                                        <input type="date" name="fecha_inscripcion" class="form-control"
                                            value="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Alumnos y Materias -->
                        <div id="contenedorAlumnosAvanzado" style="display: none;">
                            <h6 class="font-weight-bold mb-3">
                                <i class="fas fa-user-graduate mr-2"></i>Alumnos del Origen
                            </h6>
                            <div id="listaAlumnosAvanzado"
                                style="max-height: 400px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; border-radius: 5px;">
                                <div class="text-center py-3 text-muted">Selecciona origen y destino</div>
                            </div>
                        </div>

                        <input type="hidden" name="alumnos_json" id="alumnosJsonAvanzado">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cancelar
                    </button>
                    <button type="button" id="btnGuardarAvanzado" class="btn btn-primary" disabled>
                        <i class="fas fa-save mr-1"></i> Guardar Reinscripciones
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Nueva Reinscripción -->
    <div class="modal fade" id="nuevaReinscripcionModal" tabindex="-1" role="dialog"
        aria-labelledby="nuevaReinscripcionLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header modal-header-custom border-0">
                    <div class="w-100 text-center">
                        <h5 class="mb-0 font-weight-bold">
                            👨‍🎓 Nueva Inscripcion o Reinscripcion
                        </h5>
                        <p class="m-0 mt-2 mb-0" style="font-size: 0.9rem; opacity: 0.95;">
                            Inscribe o reinscribe un alumno
                        </p>
                    </div>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar"
                        style="position: absolute; right: 1.5rem; top: 1.5rem; font-size: 1.8rem; opacity: 0.9;">
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
                                                    ({{ $grupo->turno->nombre ?? 'N/A' }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label class="font-weight-bold">Número de Periodo <span
                                                class="text-danger">*</span></label>
                                        <select name="id_numero_periodo" id="numeroPeriodoSelect" required
                                            style="pointer-events: none;">
                                            <option value="">-- Selecciona primero grupo --</option>
                                            @foreach ($numerosPeriodo as $numeroPeriodo)
                                                <option value="{{ $numeroPeriodo->id_numero_periodo }}">
                                                    {{ $numeroPeriodo->tipoPeriodo->nombre ?? 'N/A' }} - Período
                                                    {{ $numeroPeriodo->numero }}
                                                </option>
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
                                    seleccionar el grupo y período escolar.
                                </div>
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
                                            @foreach ($historialStatus as $status)
                                                <option value="{{ $status->id_historial_status }}">
                                                    {{ $status->nombre }}</option>
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
            // Inyectar datos desde Blade
            window.appData = {
                statusAcademicos: @json($statusAcademicos),
                historialStatus: @json($historialStatus)
            };

            // Datos globales
            let alumnosOrigen = [];
            let materiasDestino = [];

            // Elementos del DOM
            const periodoOrigen = document.getElementById('periodoOrigen');
            const grupoOrigen = document.getElementById('grupoOrigen');
            const periodoDestino = document.getElementById('periodoDestino');
            const grupoDestino = document.getElementById('grupoDestino');
            const numeroPeriodoDisplay = document.getElementById('numeroPeriodoDestinoDisplay');
            const idNumeroPeriodoInput = document.getElementById('id_numero_periodo_destino');
            const listaAlumnos = document.getElementById('listaAlumnosAvanzado');
            const contenedorAlumnos = document.getElementById('contenedorAlumnosAvanzado');
            const panelConfigRapida = document.getElementById('panelConfigRapida');
            const btnGuardar = document.getElementById('btnGuardarAvanzado');
            const form = document.getElementById('formReinscripcionMasivaAvanzada');
            const alumnosJsonInput = document.getElementById('alumnosJsonAvanzado');

            // Cargar datos cuando cambien origen o destino
            function cargarDatos() {
                const idGrupoOrigen = grupoOrigen?.value;
                const idPeriodoOrigen = periodoOrigen?.value;
                const idGrupoDestino = grupoDestino?.value;
                const idPeriodoDestino = periodoDestino?.value;

                if (!idGrupoOrigen || !idPeriodoOrigen || !idGrupoDestino || !idPeriodoDestino) {
                    listaAlumnos.innerHTML =
                        '<div class="text-center py-3 text-muted">Selecciona todos los campos</div>';
                    contenedorAlumnos.style.display = 'none';
                    if (panelConfigRapida) panelConfigRapida.style.display = 'none';
                    return;
                }

                listaAlumnos.innerHTML =
                    '<div class="text-center py-3"><div class="spinner-border text-primary"></div></div>';

                // Cargar en paralelo
                Promise.all([
                        fetch(`/historial/obtener-alumnos-grupo`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                id_grupo: idGrupoOrigen,
                                id_periodo: idPeriodoOrigen
                            })
                        }).then(r => r.json()),
                        fetch(`/asignaciones/disponibles?grupo=${idGrupoDestino}&periodo=${idPeriodoDestino}`)
                        .then(r => r.json())
                    ])
                    .then(([alumnosRes, materiasRes]) => {
                        if (!alumnosRes.success || !materiasRes.success) throw new Error('Error al cargar');

                        // Guardar materias del destino
                        materiasDestino = materiasRes.asignaciones || [];
                        const idNumeroPeriodo = materiasRes.id_numero_periodo;

                        if (idNumeroPeriodo) {
                            idNumeroPeriodoInput.value = idNumeroPeriodo;
                            fetch(`/historial/obtener-tipo-periodo/${idNumeroPeriodo}`)
                                .then(r => r.json())
                                .then(data => {
                                    if (data.success) {
                                        numeroPeriodoDisplay.value =
                                            `${data.numero} - ${data.tipo_periodo}`;
                                    } else {
                                        numeroPeriodoDisplay.value = `Periodo ${idNumeroPeriodo}`;
                                    }
                                })
                                .catch(() => {
                                    numeroPeriodoDisplay.value = `Periodo ${idNumeroPeriodo}`;
                                });
                        } else {
                            idNumeroPeriodoInput.value = '';
                            numeroPeriodoDisplay.value = 'No definido';
                        }

                        // Guardar alumnos del origen CON status
                        alumnosOrigen = alumnosRes.alumnos.map(a => ({
                            id: a.id,
                            matricula: a.matricula,
                            nombre: a.nombre,
                            status_origen: a.status_inicio_nombre || 'Sin status',
                            status_terminacion_anterior: a.status_terminacion_nombre ||
                                'Sin status',
                            id_status_terminacion_anterior: a
                                .id_status_terminacion,
                            selected: false,
                            statusInicio: a.id_status_terminacion ||
                                '',
                            statusTerminacion: '',
                            materias: materiasDestino.map(m => m.id_asignacion)
                        }));

                        renderAlumnos();
                        contenedorAlumnos.style.display = 'block';
                        if (panelConfigRapida) panelConfigRapida.style.display = 'block';
                    })
                    .catch(err => {
                        console.error('Error:', err);
                        listaAlumnos.innerHTML =
                            '<div class="alert alert-danger text-center">Error al cargar datos</div>';
                    });
            }

            function renderAlumnos() {
                if (alumnosOrigen.length === 0) {
                    listaAlumnos.innerHTML =
                        '<div class="text-center py-3 text-muted">No hay alumnos en el origen</div>';
                    return;
                }

                // Generar opciones de status
                const opcionesInicio = window.appData.statusAcademicos.map(s =>
                    `<option value="${s.id_status_academico}">${s.nombre}</option>`
                ).join('');
                const opcionesTerminacion = window.appData.historialStatus.map(s =>
                    `<option value="${s.id_historial_status}">${s.nombre}</option>`
                ).join('');

                // Verificar si todos están seleccionados
                const todosSeleccionados = alumnosOrigen.every(a => a.selected);

                // Header con botón de seleccionar todos
                let html = `
                <div class="mb-3 p-3 border rounded" style="background: #f8f9fa;">
                    <button type="button" class="btn btn-sm btn-outline-primary" id="btnSeleccionarTodosAlumnos">
                        <i class="fas fa-${todosSeleccionados ? 'square' : 'check-square'}"></i> 
                        ${todosSeleccionados ? 'Deseleccionar Todas' : 'Seleccionar Todas'}
                    </button>
                    <small class="text-muted ml-2">Total: ${alumnosOrigen.length} alumnos</small>
                </div>
                `;

                alumnosOrigen.forEach((alumno, i) => {
                    // Badge con los dos status anteriores
                    const badgeInicio = alumno.status_origen ?
                        `<span class="badge badge-secondary mr-1" title="Status Inicio Anterior">${alumno.status_origen}</span>` :
                        '';
                    const badgeTerminacion = alumno.status_terminacion_anterior ?
                        `<span class="badge badge-success" title="Status con el que terminó">${alumno.status_terminacion_anterior}</span>` :
                        '';

                    html += `
            <div class="mb-3 p-3 border rounded" style="background: ${alumno.selected ? '#e3f2fd' : '#fff'};">
                <div class="form-check mb-2">
                    <input class="form-check-input alumno-check" type="checkbox" 
                           id="alumno_${i}" data-index="${i}" ${alumno.selected ? 'checked' : ''}>
                    <label class="form-check-label font-weight-bold" for="alumno_${i}">
                        ${alumno.nombre} <small class="text-muted">(${alumno.matricula})</small>
                    </label>
                    <div class="mt-1">
                        <small class="text-muted">Período anterior:</small>
                        ${badgeInicio}
                        <i class="fas fa-arrow-right text-muted mx-1"></i>
                        ${badgeTerminacion}
                    </div>
                </div>
                
                <!-- Status -->
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label class="small text-muted">
                            Status Inicio (Nuevo Período) <span class="text-danger">*</span>
                            <i class="fas fa-sync-alt text-success ml-1" title="Autorrellenado con status de terminación anterior"></i>
                        </label>
                        <select class="form-control form-control-sm status-inicio" data-index="${i}" 
                                ${!alumno.selected ? 'disabled' : ''}>
                            <option value="">-- Selecciona --</option>
                            ${opcionesInicio}
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="small text-muted">Status Terminación (Nuevo Período)</label>
                        <select class="form-control form-control-sm status-terminacion" data-index="${i}" 
                                ${!alumno.selected ? 'disabled' : ''}>
                            <option value="">-- Opcional --</option>
                            ${opcionesTerminacion}
                        </select>
                    </div>
                </div>
                
                <!-- Materias -->
                <div>
                    <small class="text-muted">
                        <i class="fas fa-book mr-1"></i>Materias del nuevo período: ${alumno.materias.length}
                    </small>
                    <button type="button" class="btn btn-sm btn-outline-primary ml-2 btn-editar-materias" 
                            data-index="${i}" ${!alumno.selected ? 'disabled' : ''}>
                        <i class="fas fa-edit"></i> Editar
                    </button>
                </div>
            </div>`;
                });
                listaAlumnos.innerHTML = html;

                // Restaurar valores de status
                alumnosOrigen.forEach((a, i) => {
                    if (a.statusInicio) {
                        const selectInicio = document.querySelector(`.status-inicio[data-index="${i}"]`);
                        if (selectInicio) selectInicio.value = a.statusInicio;
                    }
                    if (a.statusTerminacion) {
                        const selectTerminacion = document.querySelector(
                            `.status-terminacion[data-index="${i}"]`);
                        if (selectTerminacion) selectTerminacion.value = a.statusTerminacion;
                    }
                });

                // Evento para botón de seleccionar todos
                document.getElementById('btnSeleccionarTodosAlumnos')?.addEventListener('click', function() {
                    const todosSeleccionados = alumnosOrigen.every(a => a.selected);
                    const seleccionar = !todosSeleccionados;

                    alumnosOrigen.forEach((a, i) => {
                        a.selected = seleccionar;

                        // Actualizar checkboxes individuales
                        const checkbox = document.getElementById(`alumno_${i}`);
                        if (checkbox) checkbox.checked = seleccionar;

                        // Habilitar/deshabilitar controles
                        const selectInicio = document.querySelector(
                            `.status-inicio[data-index="${i}"]`);
                        const selectTerminacion = document.querySelector(
                            `.status-terminacion[data-index="${i}"]`);
                        const btnMaterias = document.querySelector(
                            `.btn-editar-materias[data-index="${i}"]`);

                        if (selectInicio) selectInicio.disabled = !seleccionar;
                        if (selectTerminacion) selectTerminacion.disabled = !seleccionar;
                        if (btnMaterias) btnMaterias.disabled = !seleccionar;
                    });

                    // Actualizar texto e ícono del botón
                    this.innerHTML = seleccionar ?
                        '<i class="fas fa-square"></i> Deseleccionar Todas' :
                        '<i class="fas fa-check-square"></i> Seleccionar Todas';

                    renderAlumnos();
                    validar();
                });

                // Asignar eventos a checkboxes individuales
                document.querySelectorAll('.alumno-check').forEach(cb => {
                    cb.addEventListener('change', function() {
                        const i = parseInt(this.dataset.index);
                        alumnosOrigen[i].selected = this.checked;

                        // Habilitar/deshabilitar controles
                        const selectInicio = document.querySelector(
                            `.status-inicio[data-index="${i}"]`);
                        const selectTerminacion = document.querySelector(
                            `.status-terminacion[data-index="${i}"]`);
                        const btnMaterias = document.querySelector(
                            `.btn-editar-materias[data-index="${i}"]`);

                        selectInicio.disabled = !this.checked;
                        selectTerminacion.disabled = !this.checked;
                        btnMaterias.disabled = !this.checked;

                        // Actualizar botón de seleccionar todos
                        const todosSeleccionados = alumnosOrigen.every(a => a.selected);
                        const btnTodos = document.getElementById('btnSeleccionarTodosAlumnos');
                        if (btnTodos) {
                            btnTodos.innerHTML = todosSeleccionados ?
                                '<i class="fas fa-square"></i> Deseleccionar Todas' :
                                '<i class="fas fa-check-square"></i> Seleccionar Todas';
                        }

                        validar();
                    });
                });

                document.querySelectorAll('.status-inicio').forEach(sel => {
                    sel.addEventListener('change', function() {
                        const i = parseInt(this.dataset.index);
                        alumnosOrigen[i].statusInicio = this.value;
                        validar();
                    });
                });

                document.querySelectorAll('.status-terminacion').forEach(sel => {
                    sel.addEventListener('change', function() {
                        const i = parseInt(this.dataset.index);
                        alumnosOrigen[i].statusTerminacion = this.value;
                    });
                });

                document.querySelectorAll('.btn-editar-materias').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const i = parseInt(this.dataset.index);
                        editarMaterias(i);
                    });
                });

                validar();
            }

            function editarMaterias(i) {
                const alumno = alumnosOrigen[i];
                const seleccionadas = new Set(alumno.materias);

                let opciones = materiasDestino.map(m => {
                    const checked = seleccionadas.has(m.id_asignacion) ? 'checked' : '';
                    return `
                <div class="form-check">
                    <input class="form-check-input materia-check" type="checkbox" 
                           id="materia_${i}_${m.id_asignacion}" 
                           value="${m.id_asignacion}" ${checked}>
                    <label class="form-check-label small" for="materia_${i}_${m.id_asignacion}">
                        ${m.materia_nombre} - ${m.docente_nombre}
                    </label>
                </div>`;
                }).join('');

                const modal = document.createElement('div');
                modal.className = 'modal fade';
                modal.innerHTML = `
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Materias para ${alumno.nombre}</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                        ${opciones}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="btnGuardarMaterias">Guardar</button>
                    </div>
                </div>
            </div>`;

                document.body.appendChild(modal);
                $(modal).modal('show');

                document.getElementById('btnGuardarMaterias').addEventListener('click', () => {
                    const checkboxes = modal.querySelectorAll('.materia-check:checked');
                    alumno.materias = Array.from(checkboxes).map(cb => parseInt(cb.value));
                    $(modal).modal('hide');
                    renderAlumnos();
                });

                $(modal).on('hidden.bs.modal', () => modal.remove());
            }

            function validar() {
                const seleccionados = alumnosOrigen.filter(a => a.selected);
                const validos = seleccionados.filter(a => a.statusInicio && a.materias.length > 0);
                btnGuardar.disabled = validos.length === 0;
            }

            // Configuración rápida
            document.getElementById('btnAplicarRapido')?.addEventListener('click', () => {
                const inicio = document.getElementById('statusInicioMasivo')?.value;
                const terminacion = document.getElementById('statusTerminacionMasivo')?.value;

                if (!inicio && !terminacion) {
                    alert('Selecciona al menos un status');
                    return;
                }

                const seleccionados = alumnosOrigen.filter(a => a.selected);
                if (seleccionados.length === 0) {
                    alert('Selecciona al menos un alumno');
                    return;
                }

                seleccionados.forEach(alumno => {
                    if (inicio) alumno.statusInicio = inicio;
                    if (terminacion) alumno.statusTerminacion = terminacion;
                });

                renderAlumnos();
            });

            // Guardar
            btnGuardar?.addEventListener('click', () => {
                const seleccionados = alumnosOrigen.filter(a => a.selected);

                if (seleccionados.length === 0) {
                    alert('Selecciona al menos un alumno');
                    return;
                }

                const sinStatus = seleccionados.filter(a => !a.statusInicio);
                if (sinStatus.length > 0) {
                    alert(`${sinStatus.length} alumno(s) no tienen status de inicio`);
                    return;
                }

                const sinMaterias = seleccionados.filter(a => a.materias.length === 0);
                if (sinMaterias.length > 0) {
                    alert(`${sinMaterias.length} alumno(s) no tienen materias asignadas`);
                    return;
                }

                const data = seleccionados.map(a => ({
                    id_alumno: a.id,
                    statusInicio: a.statusInicio,
                    statusTerminacion: a.statusTerminacion || null,
                    materias: a.materias.slice(0, 10)
                }));

                alumnosJsonInput.value = JSON.stringify(data);

                btnGuardar.disabled = true;
                btnGuardar.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Guardando...';

                form.submit();
            });

            // Eventos de cambio
            if (grupoOrigen) grupoOrigen.addEventListener('change', cargarDatos);
            if (periodoOrigen) periodoOrigen.addEventListener('change', cargarDatos);
            if (grupoDestino) grupoDestino.addEventListener('change', cargarDatos);
            if (periodoDestino) periodoDestino.addEventListener('change', cargarDatos);

            // Reset al cerrar modal
            $('#modalReinscripcionMasivaAvanzada').on('hidden.bs.modal', () => {
                form?.reset();
                alumnosOrigen = [];
                materiasDestino = [];
                listaAlumnos.innerHTML =
                    '<div class="text-center py-3 text-muted">Selecciona todos los campos</div>';
                contenedorAlumnos.style.display = 'none';
                if (panelConfigRapida) panelConfigRapida.style.display = 'none';
                btnGuardar.disabled = true;
                btnGuardar.innerHTML = '<i class="fas fa-save mr-1"></i> Guardar';
            });
        });
    </script>
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
                        // ✅ Esto es todo. Nada más.
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

                // Solo continuar si ambos están seleccionados
                if (!idGrupo || !idPeriodo) {
                    resetearAsignaciones();
                    if (numeroPeriodoSelect) numeroPeriodoSelect.value = '';
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

                            // ✅ AUTORELLENAR NÚMERO DE PERÍODO desde la respuesta
                            if (numeroPeriodoSelect && data.id_numero_periodo) {
                                numeroPeriodoSelect.value = data.id_numero_periodo;
                            } else {
                                numeroPeriodoSelect.value = '';
                            }
                        } else {
                            resetearAsignaciones();
                            sinAsignaciones.style.display = 'block';
                            if (numeroPeriodoSelect) numeroPeriodoSelect.value = '';
                        }
                    })
                    .catch(err => {
                        console.error('Error al cargar asignaciones:', err);
                        resetearAsignaciones();
                        sinAsignaciones.style.display = 'block';
                        if (numeroPeriodoSelect) numeroPeriodoSelect.value = '';
                    })
                    .finally(() => {
                        loadingAsignaciones.style.display = 'none';
                        validarFormulario();
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

                // ✅ NUEVO: Autorellenar número de período desde la primera materia seleccionada
                actualizarNumeroPeriodoDesdeAsignaciones();
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
        window.appData = {
            statusAcademicos: @json($statusAcademicos)
        };
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inyectar status desde Blade
            window.appData = {
                statusAcademicos: @json($statusAcademicos),
                historialStatus: @json($historialStatus)
            };

            // Elementos del DOM
            const periodoSelect = document.getElementById('periodoEscolarMasivo');
            const grupoSelect = document.getElementById('grupoActualMasivo');
            const numeroPeriodoDisplay = document.getElementById('numeroPeriodoDisplay');
            const idNumeroPeriodoInput = document.getElementById('id_numero_periodo_masivo');
            const listaAlumnos = document.getElementById('listaAlumnos');
            const contenedorAlumnos = document.getElementById('contenedorAlumnos');
            const panelConfigRapida = document.getElementById('panelConfigRapida');
            const btnGuardar = document.getElementById('btnGuardarMasivo');
            const alumnosJsonInput = document.getElementById('alumnosJsonInput');
            let alumnosCargados = [];

            // Cargar datos al cambiar grupo o período
            function cargarDatos() {
                const idGrupo = grupoSelect.value;
                const idPeriodo = periodoSelect.value;
                if (!idGrupo || !idPeriodo) {
                    resetearVista();
                    return;
                }

                listaAlumnos.innerHTML =
                    '<div class="text-center py-3"><div class="spinner-border text-info"></div></div>';

                Promise.all([
                        fetch(`/historial/obtener-alumnos-grupo`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                id_grupo: idGrupo,
                                id_periodo: idPeriodo
                            })
                        }).then(r => r.json()),
                        fetch(`/historial/obtener-materias-grupo`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                id_grupo: idGrupo,
                                id_periodo: idPeriodo
                            })
                        }).then(r => r.json())
                    ])
                    .then(([alumnosRes, materiasRes]) => {
                        if (!alumnosRes.success || !materiasRes.success) throw new Error('Error al cargar');

                        // ✅ Autorellenar número de período
                        const idNumeroPeriodo = materiasRes.materias.length > 0 ?
                            materiasRes.materias[0].id_numero_periodo :
                            null;

                        if (idNumeroPeriodo) {
                            idNumeroPeriodoInput.value = idNumeroPeriodo;

                            fetch(`/historial/obtener-tipo-periodo/${idNumeroPeriodo}`)
                                .then(r => r.json())
                                .then(data => {
                                    if (data.success) {
                                        numeroPeriodoDisplay.value =
                                            `${data.numero} - ${data.tipo_periodo}`;
                                    } else {
                                        numeroPeriodoDisplay.value = `Periodo ${idNumeroPeriodo}`;
                                    }
                                })
                                .catch(() => {
                                    numeroPeriodoDisplay.value = `Periodo ${idNumeroPeriodo}`;
                                });
                        } else {
                            idNumeroPeriodoInput.value = '';
                            numeroPeriodoDisplay.value = 'No detectado';
                        }

                        // ✅ Cargar alumnos con sus status
                        alumnosCargados = alumnosRes.alumnos.map(a => ({
                            id: a.id,
                            matricula: a.matricula,
                            nombre: a.nombre,
                            id_historial: a.id_historial,
                            status_inicio_nombre: a.status_inicio_nombre,
                            id_status_terminacion: a.id_status_terminacion || '',
                            selected: false
                        }));

                        renderAlumnos();
                        contenedorAlumnos.style.display = 'block';
                        panelConfigRapida.style.display = 'block';
                    })
                    .catch(err => {
                        listaAlumnos.innerHTML =
                            '<div class="alert alert-danger text-center">Error al cargar datos</div>';
                    });
            }

            function resetearVista() {
                listaAlumnos.innerHTML =
                    '<div class="text-center py-3 text-muted">Selecciona grupo y período</div>';
                contenedorAlumnos.style.display = 'none';
                panelConfigRapida.style.display = 'none';
                if (idNumeroPeriodoInput) idNumeroPeriodoInput.value = '';
                if (numeroPeriodoDisplay) numeroPeriodoDisplay.value = '';
            }

            // Renderizar alumnos
            function renderAlumnos() {
                if (alumnosCargados.length === 0) {
                    listaAlumnos.innerHTML =
                        '<div class="text-center py-3 text-muted">No hay alumnos en este grupo</div>';
                    return;
                }

                const opcionesTerminacion = window.appData.historialStatus.map(s =>
                    `<option value="${s.id_historial_status}">${s.nombre}</option>`
                ).join('');

                let html = '';
                alumnosCargados.forEach((a, i) => {
                    html += `
            <div class="mb-2 p-2 border rounded" style="background: ${a.selected ? '#e3f2fd' : '#fff'};">
                <div class="form-check mb-2">
                    <input class="form-check-input alumno-check" type="checkbox" data-index="${i}" ${a.selected ? 'checked' : ''}>
                    <label class="form-check-label font-weight-bold">${a.nombre} (${a.matricula})</label>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label class="small text-muted">Status Inicio</label>
                        <input type="text" class="form-control form-control-sm bg-light" value="${a.status_inicio_nombre}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="small text-muted">Status Terminación</label>
                        <select class="form-control form-control-sm status-terminacion" data-index="${i}" ${!a.selected ? 'disabled' : ''}>
                            <option value="">-- Selecciona --</option>
                            ${opcionesTerminacion}
                        </select>
                    </div>
                </div>
            </div>`;
                });
                listaAlumnos.innerHTML = html;

                // Restaurar valores previos
                alumnosCargados.forEach((a, i) => {
                    if (a.id_status_terminacion) {
                        const select = document.querySelector(`.status-terminacion[data-index="${i}"]`);
                        if (select) select.value = a.id_status_terminacion;
                    }
                });

                // Reasignar eventos
                document.querySelectorAll('.alumno-check').forEach(cb => {
                    cb.addEventListener('change', toggleAlumno);
                });
                document.querySelectorAll('.status-terminacion').forEach(sel => {
                    sel.addEventListener('change', actualizarStatus);
                });
            }

            // Manejo de eventos
            function toggleAlumno(e) {
                const i = e.target.dataset.index;
                alumnosCargados[i].selected = e.target.checked;
                document.querySelector(`.status-terminacion[data-index="${i}"]`).disabled = !e.target.checked;
                validar();
            }

            function actualizarStatus(e) {
                const i = e.target.dataset.index;
                alumnosCargados[i].id_status_terminacion = e.target.value;
                validar();
            }

            function validar() {
                const seleccionados = alumnosCargados.filter(a => a.selected);
                const validos = seleccionados.filter(a => a.id_status_terminacion);
                btnGuardar.disabled = validos.length === 0;
            }

            // 🔧 APLICAR CONFIGURACIÓN MASIVA - VERSIÓN CORRECTA SIN DUPLICADOS
            const btnAplicarRapido = document.getElementById('btnAplicarRapido');
            if (btnAplicarRapido) {
                // Remover listeners previos si existen
                const newBtn = btnAplicarRapido.cloneNode(true);
                btnAplicarRapido.parentNode.replaceChild(newBtn, btnAplicarRapido);

                // Agregar el listener ÚNICO
                newBtn.addEventListener('click', function() {
                    // Limpiar mensajes previos
                    const mensajePrevio = document.getElementById('mensajeAplicarRapido');
                    if (mensajePrevio) mensajePrevio.remove();

                    const terminacion = document.getElementById('statusTerminacionMasivo')?.value;

                    // Validar status
                    if (!terminacion) {
                        mostrarMensaje('Por favor, selecciona un Status de Terminación', 'warning');
                        return;
                    }

                    // Contar seleccionados
                    const seleccionados = alumnosCargados.filter(a => a.selected);

                    // Validar que haya seleccionados
                    if (seleccionados.length === 0) {
                        mostrarMensaje('Por favor, selecciona al menos un alumno', 'warning');
                        return;
                    }

                    // Aplicar cambios
                    alumnosCargados.forEach(a => {
                        if (a.selected) {
                            a.id_status_terminacion = terminacion;
                        }
                    });

                    // Actualizar vista
                    renderAlumnos();
                    validar();

                    // Confirmación
                    const nombreStatus = document.querySelector('#statusTerminacionMasivo option:checked')
                        ?.text || '';
                    mostrarMensaje(
                        `✅ Status "${nombreStatus}" aplicado a ${seleccionados.length} alumno(s)`,
                        'success');
                });
            }

            // Función para mostrar mensajes dentro del modal
            function mostrarMensaje(texto, tipo) {
                // Remover mensaje anterior si existe
                const mensajePrevio = document.getElementById('mensajeAplicarRapido');
                if (mensajePrevio) mensajePrevio.remove();

                // Crear el mensaje
                const tipoClase = tipo === 'success' ? 'alert-success' : 'alert-warning';
                const icono = tipo === 'success' ? '✅' : '⚠️';

                const mensaje = document.createElement('div');
                mensaje.id = 'mensajeAplicarRapido';
                mensaje.className = `alert ${tipoClase} alert-dismissible fade show mt-2 mb-0`;
                mensaje.innerHTML = `
                    <strong>${icono}</strong> ${texto}
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                `;

                // Insertar después del panel de configuración rápida
                panelConfigRapida.insertAdjacentElement('afterend', mensaje);

                // Auto-ocultar después de 5 segundos (solo para mensajes de éxito)
                if (tipo === 'success') {
                    setTimeout(() => {
                        if (mensaje.parentNode) {
                            mensaje.classList.remove('show');
                            setTimeout(() => mensaje.remove(), 150);
                        }
                    }, 5000);
                }
            }

            // Seleccionar todos
            document.getElementById('btnSeleccionarTodos')?.addEventListener('click', () => {
                const todos = alumnosCargados.every(a => a.selected);
                alumnosCargados.forEach(a => a.selected = !todos);
                renderAlumnos();
                if (document.getElementById('btnSeleccionarTodos')) {
                    document.getElementById('btnSeleccionarTodos').textContent = !todos ?
                        'Deseleccionar Todos' : 'Seleccionar Todos';
                }
                validar();
            });

            // Guardar
            btnGuardar?.addEventListener('click', () => {
                const seleccionados = alumnosCargados.filter(a => a.selected);
                if (seleccionados.length === 0) return;

                const data = seleccionados.map(a => ({
                    id_historial: a.id_historial,
                    id_status_terminacion: a.id_status_terminacion
                }));

                alumnosJsonInput.value = JSON.stringify(data);
                document.getElementById('formReinscripcionMasiva').submit();
            });

            // Eventos
            grupoSelect?.addEventListener('change', cargarDatos);
            periodoSelect?.addEventListener('change', cargarDatos);

            // Reset al cerrar
            $('#modalReinscripcionMasiva').on('hidden.bs.modal', () => {
                document.getElementById('formReinscripcionMasiva')?.reset();
                alumnosCargados = [];
                resetearVista();
                btnGuardar.disabled = true;
            });
        });
    </script>
</body>

</html>
