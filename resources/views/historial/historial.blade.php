<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Historial</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('libs/fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link rel ="icon" type="image/png" href="{{ asset('libs/sbadmin/img/up_logo.png') }}">
    <!-- Custom styles for this template-->
    <link href="{{ asset('libs/sbadmin/css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Top Header -->
    <div class="bg-danger text-white1 text-center py-2">
        <div class="d-flex justify-content-between align-items-center px-4">

            <h4 class="mb-0" style="text-align: center;">SISTEMA DE CONTROL ESCOLAR</h4>

        </div>
    </div>
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">¿Seguro de cerrar sesión?</h5>
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
            <div style="width: 300px; height: 120px; ">
                <img src="{{ asset('libs/sbadmin/img/upn.png') }}" alt="Logo"
                    style="width: 100%; height: 100%; object-fit: cover;">
            </div>
        </div>


        <div class="collapse navbar-collapse ml-4">
            <ul class="navbar-nav" style="padding-left: 20%;">
                <li class="nav-item"> <!-- bg-success -->
                    <a class="nav-link text-white px-3 mr-1" href="{{ route('admin') }}">Inicio</a>

                </li>
                <li class="nav-item">
                    <a class="nav-link  text-white px-3 mr-1" href="{{ route('periodos.index') }}">Períodos
                        Escolares</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white px-3 mr-1" href="{{ route('carreras.index') }}">Carreras</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white px-3 mr-1" href="{{ route('materias.index') }}">Materias</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  text-white px-3 mr-1" href="{{ route('planes.index') }}">Planes de estudio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white px-3 mr-1" href="{{ route('alumnos.index') }}">Alumnos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white px-3 mr-1" href="#">Asignaciones Docentes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link navbar-active-item px-3" >Historial</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white px-3" href="#">Calificaciones</a>
                </li>
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
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Main Content -->
                <div class="container-fluid py-5">
                    <h1 class="text-danger text-center mb-5"
                        style="font-size: 2.5rem; font-family: 'Arial Black', Verdana, sans-serif; font-weight: bold;">
                        Historial de Reinscripciones</h1>

                    <div class="row justify-content-center">
                        <div class="col-lg-11">

                            <!-- Botón para nueva reinscripción -->
                            <div class="mb-3 text-right">
                                <a href="{{ route('historial.reinscripcion-masiva') }}" class="btn btn-info mr-2">
        <i class="fas fa-users"></i> Reinscripción Masiva
    </a>
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

                                        <!-- Alumno -->
                                        <select name="id_alumno" class="form-control form-control-sm w-auto">
                                            <option value="">Buscar por alumno</option>
                                            @foreach ($alumnos as $alumno)
                                                <option value="{{ $alumno->id_alumno }}"
                                                    {{ request('id_alumno') == $alumno->id_alumno ? 'selected' : '' }}>
                                                    {{ optional($alumno->datosPersonales)->nombres ?? 'N/A' }}
                                                    {{ optional($alumno->datosPersonales)->primer_apellido ?? '' }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <!-- Matrícula -->
                                        <input type="text" name="matricula"
                                            class="form-control form-control-sm w-auto"
                                            placeholder="Buscar por matrícula" value="{{ request('matricula') }}">


                                        <!-- Periodo Escolar -->
                                        <select name="id_periodo_escolar" class="form-control form-control-sm w-auto">
                                            <option value="">Buscar por período</option>
                                            @foreach ($periodos as $periodo)
                                                <option value="{{ $periodo->id_periodo_escolar }}"
                                                    {{ request('id_periodo_escolar') == $periodo->id_periodo_escolar ? 'selected' : '' }}>
                                                    {{ $periodo->nombre }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <!-- Grupo -->
                                        <select name="id_grupo" class="form-control form-control-sm w-auto">
                                            <option value="">Buscar por grupo</option>
                                            @foreach ($grupos as $grupo)
                                                <option value="{{ $grupo->id_grupo }}"
                                                    {{ request('id_grupo') == $grupo->id_grupo ? 'selected' : '' }}>
                                                    {{ $grupo->nombre }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <!-- Estatus Historial -->
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

                                        <!-- Mostrar -->
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

                                        <!-- Botón Mostrar todo -->
                                        <a href="{{ route('historial.index', ['mostrar' => 'todo']) }}"
                                            class="btn btn-sm btn-outline-secondary d-flex align-items-center">
                                            <i class="fas fa-list me-1"></i> Mostrar todo
                                        </a>

                                    </form>
                                </div>
                            </div>

                            <!-- Tabla de historial -->

                            <div class="card-body1">
                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover text-center" id="dataTable"
                                        width="100%" cellspacing="0"> 
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>ID</th>
                                                <th>Alumno</th>
                                                <th>Matrícula</th>
                                                <th>Período Escolar</th>
                                                <th>Grupo</th>
                                                <th>Fecha Inscripción</th>
                                                <th>Status Inicio</th>
                                                <th>Status Terminación</th>
                                                <th>Estatus Historial</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($historial as $registro)
                                                <tr>
                                                    <td>{{ $registro->id_historial }}</td>
                                                    <td>
                                                        {{ optional($registro->alumno->datosPersonales)->nombres ?? 'N/A' }}
                                                        {{ optional($registro->alumno->datosPersonales)->primer_apellido ?? '' }}
                                                        {{ optional($registro->alumno->datosPersonales)->segundo_apellido ?? '' }}
                                                    </td>
                                                    <td>{{ optional($registro->alumno->datosAcademicos)->matricula ?? 'N/A' }}
                                                    </td>
                                                    <td>{{ optional($registro->periodoEscolar)->nombre ?? 'N/A' }}</td>
                                                    <td>{{ optional($registro->grupo)->nombre ?? 'N/A' }}</td>
                                                    <td>{{ $registro->fecha_inscripcion ? \Carbon\Carbon::parse($registro->fecha_inscripcion)->format('d/m/Y') : 'N/A' }}
                                                    </td>
                                                    <td>{{ optional($registro->statusInicio)->nombre ?? 'N/A' }}</td>
                                                    <td>{{ optional($registro->statusTerminacion)->nombre ?? 'Sin Asignar' }}
                                                    </td>
                                                    <td>
                                                        @if ($registro->historialStatus)
                                                            @if ($registro->historialStatus->id_historial_status == 1)
                                                                <span
                                                                    class="historial-status-activo">{{ $registro->historialStatus->nombre }}</span>
                                                            @else
                                                                <span
                                                                    class="historial-status-inactivo">{{ $registro->historialStatus->nombre }}</span>
                                                            @endif
                                                        @else
                                                            <span>N/A</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <!-- Botón Ver -->
                                                        <button class="btn btn-info btn-sm" data-toggle="modal"
                                                            data-target="#verHistorialModal{{ $registro->id_historial }}">
                                                            <i class="fas fa-eye"></i>
                                                        </button>

                                                        <!-- Botón Editar -->
                                                        <button class="btn btn-warning btn-sm" data-toggle="modal"
                                                            data-target="#editarHistorialModal{{ $registro->id_historial }}">
                                                            <i class="fas fa-edit"></i>
                                                        </button>

                                                        <!-- Botón Eliminar -->
                                                        <form
                                                            action="{{ route('historial.destroy', $registro->id_historial) }}"
                                                            method="POST" style="display:inline-block;"
                                                            onsubmit="return confirm('¿Seguro que deseas eliminar este registro?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>

                                                <!-- Modal Ver Historial -->
                                                <div class="modal fade"
                                                    id="verHistorialModal{{ $registro->id_historial }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="verHistorialModalLabel{{ $registro->id_historial }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered"
                                                        role="document">
                                                        <div class="modal-content">

                                                            {{-- Header --}}
                                                            <div class="modal-header">
                                                                <h5 class="modal-title w-100 text-center font-weight-bold"
                                                                    id="verHistorialModalLabel{{ $registro->id_historial }}">
                                                                    Detalles de Reinscripción
                                                                </h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Cerrar">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>

                                                            {{-- Body --}}
                                                            <div class="modal-body p-3">

                                                                {{-- Información Principal --}}
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
                                                                            @if ($registro->historialStatus->id_historial_status == 1)
                                                                                <span
                                                                                    class="badge badge-success">{{ $registro->historialStatus->nombre }}</span>
                                                                            @else
                                                                                <span
                                                                                    class="badge badge-danger">{{ $registro->historialStatus->nombre }}</span>
                                                                            @endif
                                                                        @else
                                                                            <span
                                                                                class="badge badge-secondary">N/A</span>
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                {{-- Datos de Reinscripción --}}
                                                                <div class="card border mb-2">
                                                                    <div class="card-header bg-light py-2">
                                                                        <h6 class="mb-0 font-weight-bold"><i
                                                                                class="fas fa-calendar-alt mr-1"></i>DATOS
                                                                            DE REINSCRIPCIÓN</h6>
                                                                    </div>
                                                                    <div class="card-body p-2">
                                                                        <div class="row small">
                                                                            <div class="col-md-4"><strong>Período
                                                                                    Escolar:</strong>
                                                                                {{ optional($registro->periodoEscolar)->nombre ?? 'N/A' }}
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <strong>Grupo:</strong>
                                                                                {{ optional($registro->grupo)->nombre ?? 'N/A' }}
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <strong>Fecha de Inscripción:</strong>
                                                                                {{ $registro->fecha_inscripcion ? \Carbon\Carbon::parse($registro->fecha_inscripcion)->format('d/m/Y') : 'N/A' }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                {{-- Status --}}
                                                                <div class="row mb-2">
                                                                    <div class="col-md-6">
                                                                        <div class="card border h-100">
                                                                            <div class="card-header bg-light py-2">
                                                                                <h6 class="mb-0 font-weight-bold"><i
                                                                                        class="fas fa-play-circle mr-1"></i>STATUS
                                                                                    INICIO
                                                                                </h6>
                                                                            </div>
                                                                            <div class="card-body p-2">
                                                                                <p class="mb-0">
                                                                                    {{ optional($registro->statusInicio)->nombre ?? 'N/A' }}
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="card border h-100">
                                                                            <div class="card-header bg-light py-2">
                                                                                <h6 class="mb-0 font-weight-bold"><i
                                                                                        class="fas fa-flag-checkered mr-1"></i>STATUS
                                                                                    TERMINACIÓN
                                                                                </h6>
                                                                            </div>
                                                                            <div class="card-body p-2">
                                                                                <p class="mb-0">
                                                                                    {{ optional($registro->statusTerminacion)->nombre ?? 'Sin Asignar' }}
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                {{-- Datos Adicionales --}}
                                                                @if ($registro->datos)
                                                                    <div class="card border mb-2">
                                                                        <div class="card-header bg-light py-2">
                                                                            <h6 class="mb-0 font-weight-bold"><i
                                                                                    class="fas fa-info-circle mr-1"></i>DATOS
                                                                                ADICIONALES
                                                                            </h6>
                                                                        </div>
                                                                        <div class="card-body p-2">
                                                                            <pre class="mb-0 small">{{ json_encode($registro->datos, JSON_PRETTY_PRINT) }}</pre>
                                                                        </div>
                                                                    </div>
                                                                @endif

                                                            </div>

                                                            {{-- Footer --}}
                                                            <div class="modal-footer bg-light border-top py-2">
                                                                <button type="button"
                                                                    class="btn btn-outline-secondary btn-sm"
                                                                    data-dismiss="modal">
                                                                    <i class="fas fa-times mr-1"></i>Cerrar
                                                                </button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Modal Editar Historial -->
                                                <div class="modal fade"
                                                    id="editarHistorialModal{{ $registro->id_historial }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="editarHistorialModal{{ $registro->id_historial }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-scrollable"
                                                        role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-primary text-white">
                                                                <h5 class="text-center w-100 mb-0">Editar Reinscripción
                                                                </h5>
                                                                <button type="button" class="close text-white"
                                                                    data-dismiss="modal">
                                                                    <span>&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">

                                                                <form
                                                                    action="{{ route('historial.update', $registro->id_historial) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PUT')

                                                                    <div class="card mb-3">
                                                                        <div class="card-header bg-light"><b>Datos de
                                                                                Reinscripción</b></div>
                                                                        <div class="card-body d-flex flex-wrap gap-3">

                                                                            <div class="flex-grow-1"
                                                                                style="min-width: 200px;">
                                                                                <label>Alumno</label>
                                                                                <select name="id_alumno"
                                                                                    class="form-control" required>
                                                                                    <option value="">
                                                                                        Selecciona...</option>
                                                                                    @foreach ($alumnos as $alumno)
                                                                                        <option
                                                                                            value="{{ $alumno->id_alumno }}"
                                                                                            {{ $registro->id_alumno == $alumno->id_alumno ? 'selected' : '' }}>
                                                                                            {{ optional($alumno->datosPersonales)->nombres ?? 'N/A' }}
                                                                                            {{ optional($alumno->datosPersonales)->primer_apellido ?? '' }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>

                                                                            <div class="flex-grow-1"
                                                                                style="min-width: 200px;">
                                                                                <label>Período Escolar</label>
                                                                                <select name="id_periodo_escolar"
                                                                                    class="form-control" required>
                                                                                    <option value="">
                                                                                        Selecciona...</option>
                                                                                    @foreach ($periodos as $periodo)
                                                                                        <option
                                                                                            value="{{ $periodo->id_periodo_escolar }}"
                                                                                            {{ $registro->id_periodo_escolar == $periodo->id_periodo_escolar ? 'selected' : '' }}>
                                                                                            {{ $periodo->nombre }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>

                                                                            <div class="flex-grow-1"
                                                                                style="min-width: 200px;">
                                                                                <label>Grupo</label>
                                                                                <select name="id_grupo"
                                                                                    class="form-control" required>
                                                                                    <option value="">
                                                                                        Selecciona...</option>
                                                                                    @foreach ($grupos as $grupo)
                                                                                        <option
                                                                                            value="{{ $grupo->id_grupo }}"
                                                                                            {{ $registro->id_grupo == $grupo->id_grupo ? 'selected' : '' }}>
                                                                                            {{ $grupo->nombre }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>

                                                                            <div class="flex-grow-1"
                                                                                style="min-width: 200px;">
                                                                                <label>Fecha de Inscripción</label>
                                                                                <input type="date"
                                                                                    name="fecha_inscripcion"
                                                                                    value="{{ $registro->fecha_inscripcion }}"
                                                                                    class="form-control">
                                                                            </div>

                                                                            <div class="flex-grow-1"
                                                                                style="min-width: 200px;">
                                                                                <label>Status Inicio</label>
                                                                                <select name="id_status_inicio"
                                                                                    class="form-control">
                                                                                    <option value="">
                                                                                        Selecciona...</option>
                                                                                    @foreach ($statusAcademicos as $status)
                                                                                        <option
                                                                                            value="{{ $status->id_status_academico }}"
                                                                                            {{ $registro->id_status_inicio == $status->id_status_academico ? 'selected' : '' }}>
                                                                                            {{ $status->nombre }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>

                                                                            <div class="flex-grow-1"
                                                                                style="min-width: 200px;">
                                                                                <label>Status Terminación</label>
                                                                                <select name="id_status_terminacion"
                                                                                    class="form-control">
                                                                                    <option value="">
                                                                                        Selecciona...</option>
                                                                                    @foreach ($statusAcademicos as $status)
                                                                                        <option
                                                                                            value="{{ $status->id_status_academico }}"
                                                                                            {{ $registro->id_status_terminacion == $status->id_status_academico ? 'selected' : '' }}>
                                                                                            {{ $status->nombre }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>

                                                                            <div class="flex-grow-1"
                                                                                style="min-width: 200px;">
                                                                                <label>Estatus Historial</label>
                                                                                <select name="id_historial_status"
                                                                                    class="form-control">
                                                                                    <option value="">
                                                                                        Selecciona...</option>
                                                                                    @foreach ($historialStatus as $status)
                                                                                        <option
                                                                                            value="{{ $status->id_historial_status }}"
                                                                                            {{ $registro->id_historial_status == $status->id_historial_status ? 'selected' : '' }}>
                                                                                            {{ $status->nombre }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="text-right mt-4">
                                                                        <button type="button"
                                                                            class="btn btn-secondary"
                                                                            data-dismiss="modal">Cancelar</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">
                                                                            <i class="fas fa-save"></i> Guardar Cambios
                                                                        </button>
                                                                    </div>

                                                                </form>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            @empty
                                                <tr>
                                                    <td colspan="10" class="text-muted text-center">No hay
                                                        registros de reinscripción</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Paginación -->
                                @if ($historial instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                    <div class="d-flex justify-content-center mt-4">
                                        {{ $historial->links() }}
                                    </div>
                                @endif

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

    <!-- Modal Nueva Reinscripción -->
    <div class="modal fade" id="nuevaReinscripcionModal" tabindex="-1" role="dialog"
        aria-labelledby="nuevaReinscripcionLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-header bg-primary text-white">
                    <h5 class="text-center w-100 mb-0">Nueva Reinscripción</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('historial.store') }}" method="POST">
                        @csrf

                        <div class="card mb-3">
                            <div class="card-header bg-light"><b>Datos de Reinscripción</b></div>
                            <div class="card-body d-flex flex-wrap gap-3">

                                <div class="flex-grow-1" style="min-width: 200px;">
    <label>Número de Control</label>
    <div class="input-group">
        <input type="text" id="buscarMatricula" class="form-control" placeholder="Ej. 20230015">
        <div class="input-group-append">
            <button type="button" id="btnBuscarAlumno" class="btn btn-outline-primary">Buscar</button>
        </div>
    </div>
    <small class="text-muted">Escribe la matrícula y presiona Enter o clic en Buscar</small>
</div>

<div class="flex-grow-1" style="min-width: 200px;">
    <label>Nombre del Alumno <span class="text-danger">*</span></label>
    <input type="text" id="nombreAlumno" class="form-control" placeholder="Nombre del alumno" readonly>
    <input type="hidden" name="id_alumno" id="id_alumno"> <!-- ID oculto -->
</div>


                                <div class="flex-grow-1" style="min-width: 200px;">
                                    <label>Período Escolar <span class="text-danger">*</span></label>
                                    <select name="id_periodo_escolar" class="form-control" required>
                                        <option value="">Selecciona...</option>
                                        @foreach ($periodos as $periodo)
                                            <option value="{{ $periodo->id_periodo_escolar }}">
                                                {{ $periodo->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="flex-grow-1" style="min-width: 200px;">
                                    <label>Grupo <span class="text-danger">*</span></label>
                                    <select name="id_grupo" class="form-control" required>
                                        <option value="">Selecciona...</option>
                                        @foreach ($grupos as $grupo)
                                            <option value="{{ $grupo->id_grupo }}">
                                                {{ $grupo->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="flex-grow-1" style="min-width: 200px;">
                                    <label>Fecha de Inscripción</label>
                                    <input type="date" name="fecha_inscripcion" class="form-control">
                                </div>

                                <div class="flex-grow-1" style="min-width: 200px;">
                                    <label>Status Inicio</label>
                                    <select name="id_status_inicio" class="form-control">
                                        <option value="">Selecciona...</option>
                                        @foreach ($statusAcademicos as $status)
                                            <option value="{{ $status->id_status_academico }}">
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
                                            <option value="{{ $status->id_status_academico }}">
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
                                            <option value="{{ $status->id_historial_status }}">
                                                {{ $status->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<script>
document.addEventListener("DOMContentLoaded", function() {

    function buscarAlumno() {
        let matricula = document.getElementById('buscarMatricula').value.trim();
        if (matricula === '') return;

        fetch(`/buscar-alumno?matricula=${matricula}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('id_alumno').value = data.id_alumno;
                    document.getElementById('nombreAlumno').value = data.nombre;
                } else {
                    document.getElementById('id_alumno').value = '';
                    document.getElementById('nombreAlumno').value = '';
                    alert(data.message || 'No se encontró ningún alumno con esa matrícula.');
                }
            })
            .catch(error => {
                console.error('Error al buscar alumno:', error);
                alert('Ocurrió un error al buscar el alumno.');
            });
    }

    document.getElementById('btnBuscarAlumno').addEventListener('click', buscarAlumno);
    document.getElementById('buscarMatricula').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            buscarAlumno();
        }
    });
});
</script>



    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">¿Listo para salir?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Selecciona "Cerrar Sesión" si estás listo para terminar tu sesión actual.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-primary" href="{{ route('login') }}">Cerrar Sesión</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('libs/sbadmin/js/sb-admin-2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Filtros automáticos
            let form = document.getElementById("filtrosForm");
            if (form) {
                form.querySelectorAll("select").forEach(el => {
                    el.addEventListener("change", function() {
                        form.submit();
                    });
                });
            }

            // Inicialización de modales
            setTimeout(function() {
                $('.modal').each(function() {
                    $(this).modal({
                        backdrop: 'static',
                        keyboard: false,
                        show: false
                    });
                });
            }, 500);
        });
    </script>
</body>

</html>
