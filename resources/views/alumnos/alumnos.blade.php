<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Alumnos</title>

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
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{ route('login') }}">Login</a>
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
                    <a class="nav-link text-white px-3 mr-1" href="{{ route('planes.index') }}">Planes de estudio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link navbar-active-item px-3 mr-1">Alumnos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white px-3 mr-1" href="{{ route('asignaciones.index') }}">Asignaciones
                        Docentes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white px-3" href="{{ route('historial.index') }}">Historial</a>
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
                        Gestión de Alumnos</h1>

                    <div class="row justify-content-center">
                        <div class="col-lg-10">

                            <!-- Botón para nuevo alumno -->
                            <div class="mb-3 text-right">
                                <button type="button" class="btn btn-success" data-toggle="modal"
                                    data-target="#nuevoAlumnoModal">
                                    <i class="fas fa-user-plus"></i> Nuevo Aspirante
                                </button>
                            </div>

                            <div class="container-fluid mb-4 d-flex justify-content-center">
                                <div class="p-3 border rounded bg-light shadow-sm d-inline-block">
                                    <form id="filtrosForm" method="GET" action="{{ route('alumnos.index') }}"
                                        class="d-flex flex-nowrap align-items-center gap-2">

                                        <!-- Búsqueda general -->
                                        <div class="flex-grow-1" style="width: 400px;">
                                            <input type="text" name="busqueda"
                                                class="form-control form-control-sm"
                                                placeholder="🔍 Buscar por nombre o matrícula"
                                                value="{{ request('busqueda') }}">
                                        </div>


                                        <!-- Carrera -->
                                        <select name="id_carrera"
                                            class="form-control form-control-sm w-auto @error('id_carrera') is-invalid @enderror">
                                            <option value="">🔍 Buscar por carrera</option>
                                            @foreach ($carreras as $carrera)
                                                <option value="{{ $carrera->id_carrera }}"
                                                    {{ old('id_carrera') == $carrera->id_carrera ? 'selected' : '' }}>
                                                    {{ $carrera->nombre }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <select name="estatus" class="form-control form-control-sm w-auto">
                                            <option value="">🔍 Buscar por Estatus</option>
                                            @foreach ($estatus as $status)
                                                <option value="{{ $status->id_historial_status }}"
                                                    {{ request('estatus') == $status->id_historial_status ? 'selected' : '' }}>
                                                    {{ $status->nombre }}
                                                </option>
                                            @endforeach
                                        </select>


                                        <!-- Mostrar -->
                                        <select name="mostrar" onchange="this.form.submit()"
                                            class="form-control form-control-sm w-auto">
                                            <option value="10" {{ request('mostrar') == 10 ? 'selected' : '' }}>10
                                            </option>
                                            <option value="13" {{ request('mostrar') == 13 ? 'selected' : '' }}>13
                                            </option>
                                            <option value="25" {{ request('mostrar') == 25 ? 'selected' : '' }}>25
                                            </option>
                                            <option value="50" {{ request('mostrar') == 50 ? 'selected' : '' }}>50
                                            </option>
                                            <option value="todo"
                                                {{ request('mostrar') == 'todo' ? 'selected' : '' }}>Todo</option>
                                        </select>

                                        <!-- Botón Mostrar todo -->
                                        <a href="{{ route('alumnos.index', ['mostrar' => 'todo']) }}"
                                            class="btn btn-sm btn-outline-secondary d-flex align-items-center">
                                            <i class="fas fa-list me-1"></i> Mostrar todo
                                        </a>

                                    </form>
                                </div>

                            </div>

                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    let form = document.getElementById("filtrosForm");

                                    // Detecta cambios en inputs y selects
                                    form.querySelectorAll("input, select").forEach(el => {
                                        el.addEventListener("change", function() {
                                            form.submit();
                                        });
                                    });

                                    // Para "nombre", busca después de dejar de escribir (delay 500ms)
                                    let typingTimer;
                                    let nombreInput = form.querySelector("input[name='nombre']");
                                    if (nombreInput) {
                                        nombreInput.addEventListener("keyup", function() {
                                            clearTimeout(typingTimer);
                                            typingTimer = setTimeout(() => {
                                                form.submit();
                                            }, 500);
                                        });
                                    }
                                });
                            </script>

                            <!-- Tabla de alumnos -->
                            <div class="card-body1">
                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover text-center">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Matrícula</th>
                                                <th>Nombre Completo</th>
                                                <th>Carrera</th>
                                                <th>Estatus</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($alumnos as $alumno)
                                                <tr>
                                                    <td>{{ optional($alumno->datosAcademicos)->matricula ?? 'No Asignado' }}
                                                    <td>
                                                        {{ optional($alumno->datosPersonales)->nombres }}
                                                        {{ optional($alumno->datosPersonales)->primer_apellido }}
                                                        {{ optional($alumno->datosPersonales)->segundo_apellido }}
                                                    </td>
                                                    <td>{{ optional(optional($alumno->datosAcademicos)->carrera)->nombre ?: 'No Asignado' }}

                                                    </td>
                                                    </td>
                                                    <td>{{ optional($alumno->statusAcademico)->nombre ?? '—' }}
                                                    </td>
                                                    <td>
                                                        <!-- Botón Ver -->
                                                        <button class="btn btn-info btn-sm" data-toggle="modal"
                                                            data-target="#verAlumnoModal{{ $alumno->id_alumno }}">
                                                            <i class="fas fa-eye"></i> Ver
                                                        </button>

                                                        <!-- Botón Editar -->
                                                        <button class="btn btn-warning btn-sm" data-toggle="modal"
                                                            data-target="#editarModal{{ $alumno->id_alumno }}">
                                                            <i class="fas fa-edit"></i> Editar
                                                        </button>

                                                        <!-- Botón Eliminar -->
                                                        <form
                                                            action="{{ route('alumnos.destroy', $alumno->id_alumno) }}"
                                                            method="POST" style="display:inline-block;"
                                                            onsubmit="return confirm('¿Seguro que deseas eliminar este alumno?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                <i class="fas fa-trash-alt"></i> Eliminar
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                <!-- Modal Ver Alumno - Diseño Formal Mejorado -->
                                                <div class="modal fade" id="verAlumnoModal{{ $alumno->id_alumno }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="verAlumnoModalLabel{{ $alumno->id_alumno }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered"
                                                        role="document">
                                                        <div class="modal-content">

                                                            {{-- Header --}}
                                                            <div class="modal-header modal-header-custom border-0">
                                                                <div class="w-100 text-center">
                                                                    <h5 class="m-0 font-weight-bold">📓 Detalles del
                                                                        Estudiante </h5>
                                                                    <p class="m-0 mt-2 mb-0"
                                                                        style="font-size: 0.9rem; opacity: 0.95;">
                                                                        Información académica y personal
                                                                    </p>
                                                                </div>
                                                                <button type="button" class="close text-white"
                                                                    data-dismiss="modal" aria-label="Cerrar"
                                                                    style="position: absolute; right: 1.5rem; top: 1.5rem; font-size: 1.8rem; opacity: 0.9;">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>

                                                            {{-- Body --}}
                                                            <div class="modal-body p-0"
                                                                style="background-color: #f8fafc;">

                                                                {{-- Sección de Identificación --}}
                                                                <div class="bg-white border-bottom py-3 px-4">
                                                                    <div class="row align-items-center">
                                                                        <div class="col-md-2 text-center">
                                                                            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center"
                                                                                style="width: 80px; height: 80px; border: 3px solid #1e40af;">
                                                                                <i class="fas fa-user-graduate"
                                                                                    style="font-size: 2rem; color: #1e40af;"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-10">
                                                                            <h4
                                                                                class="mb-2 font-weight-bold text-danger">
                                                                                {{ $alumno->datosPersonales?->nombres ?? 'N/A' }}
                                                                                {{ $alumno->datosPersonales?->primer_apellido ?? '' }}
                                                                                {{ $alumno->datosPersonales?->segundo_apellido ?? '' }}
                                                                            </h4>
                                                                            <div class="row">
                                                                                <div class="col-md-4">
                                                                                    <small
                                                                                        class="text-muted text-uppercase d-block">Matrícula:
                                                                                    </small>
                                                                                    <strong
                                                                                        class="text-muted d-block">{{ $alumno->datosAcademicos?->matricula ?? 'Sin Matrícula' }}</strong>
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <small
                                                                                        class="text-muted text-uppercase d-block">CURP</small>
                                                                                    <strong>{{ $alumno->datosPersonales?->curp ?? 'Sin CURP' }}</strong>
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <small
                                                                                        class="text-muted text-uppercase d-block">Estatus</small>
                                                                                    <span
                                                                                        class="badge badge-{{ $alumno->statusAcademico?->color ?? 'secondary' }} px-3 py-1">
                                                                                        {{ $alumno->statusAcademico?->nombre ?? 'Sin Estatus' }}
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                {{-- Contenido Principal --}}
                                                                <div class="p-4">

                                                                    {{-- Información Académica --}}
                                                                    <div class="mb-4">
                                                                        <div class="bg-white border rounded">
                                                                            <div class="px-4 py-3 border-bottom"
                                                                                style="background-color: #f1f5f9;">
                                                                                <h6
                                                                                    class="text-danger font-weight-bold mb-3">
                                                                                    <i
                                                                                        class="fas fa-graduation-cap mr-2"></i>Datos
                                                                                    Académicos
                                                                                </h6>
                                                                            </div>
                                                                            <div class="p-4">
                                                                                <div class="row">

                                                                                    @if ($alumno->estatus && in_array($alumno->estatus, [1, 2, 3, 4, 5, 6, 8, 9]))
                                                                                        <div
                                                                                            class="text-center col-md-5 mb-3">
                                                                                            <label
                                                                                                class="text-muted text-uppercase d-block">Carrera</label>
                                                                                            <div
                                                                                                class="font-weight-bold">
                                                                                                {{ $alumno->datosAcademicos?->carrera?->nombre ?? 'No Asignada' }}
                                                                                            </div>
                                                                                        </div>
                                                                                        <div
                                                                                            class="text-center col-md-4 mb-3">
                                                                                            <label
                                                                                                class="text-muted text-uppercase d-block">Plan
                                                                                                de Estudios</label>
                                                                                            <div
                                                                                                class="font-weight-bold">
                                                                                                {{ $alumno->datosAcademicos?->planEstudio?->nombre ?? 'No asignado' }}
                                                                                            </div>
                                                                                        </div>
                                                                                        <div
                                                                                            class="text-center col-md-4 mb-3">
                                                                                            <label
                                                                                                class="text-muted text-uppercase d-block">Generación</label>
                                                                                            <div
                                                                                                class="font-weight-bold">
                                                                                                {{ $alumno->generaciones?->nombre ?? 'N/A' }}
                                                                                            </div>
                                                                                        </div>


                                                                                        <div class="col-md-3 mb-3">
                                                                                            <label
                                                                                                class="text-muted text-uppercase d-block">Servicio
                                                                                                Social</label>
                                                                                            <div
                                                                                                class="font-weight-bold {{ $alumno->servicios_social ? 'text-success' : 'text-warning' }}">
                                                                                                <i
                                                                                                    class="fas {{ $alumno->servicios_social ? 'fa-check-circle' : 'fa-clock' }} mr-1"></i>
                                                                                                {{ $alumno->servicios_social ? 'Completado' : 'Pendiente' }}
                                                                                            </div>
                                                                                        </div>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    {{-- Datos Personales --}}
                                                                    <div class="mb-4">
                                                                        <div class="bg-white border rounded">
                                                                            <div class="px-4 py-3 border-bottom"
                                                                                style="background-color: #f1f5f9;">
                                                                                <h6
                                                                                    class="text-danger font-weight-bold mb-3">
                                                                                    <i
                                                                                        class="fas fa-user mr-2"></i>Información
                                                                                    Personal
                                                                                </h6>
                                                                            </div>
                                                                            <div class="p-4">
                                                                                <div class="row">
                                                                                    <div class="col-md-4 mb-3">
                                                                                        <label
                                                                                            class="text-muted text-uppercase d-block">Fecha
                                                                                            de Nacimiento</label>
                                                                                        <div class="font-weight-bold">
                                                                                            {{ $alumno->datosPersonales?->fecha_nacimiento ? \Carbon\Carbon::parse($alumno->datosPersonales->fecha_nacimiento)->format('d/m/Y') : 'N/A' }}
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- En el modal de Ver Alumno -->
                                                                                    <div class="col-md-4 mb-3">
                                                                                        <label
                                                                                            class="text-muted text-uppercase d-block">Estado
                                                                                            de Nacimiento</label>
                                                                                        <div class="font-weight-bold">
                                                                                            {{ $alumno->datosPersonales->estadoNacimiento->nombre ?? 'No registrado' }}
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-2 mb-3">
                                                                                        <label
                                                                                            class="text-muted text-uppercase d-block">Edad</label>
                                                                                        <div class="font-weight-bold">
                                                                                            {{ $alumno->datosPersonales?->edad ?? 'N/A' }}
                                                                                            años</div>
                                                                                    </div>
                                                                                    <div class="col-md-3 mb-3">
                                                                                        <label
                                                                                            class="text-muted text-uppercase d-block">Género</label>
                                                                                        <div class="font-weight-bold">
                                                                                            {{ $alumno->datosPersonales?->genero?->nombre ?? 'N/A' }}
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3 mb-3">
                                                                                        <label
                                                                                            class="text-muted text-uppercase d-block">Estado
                                                                                            Civil</label>
                                                                                        <div class="font-weight-bold">
                                                                                            {{ $alumno->datosPersonales?->estadoCivil?->nombre ?? 'N/A' }}
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3 mb-3">
                                                                                        <label
                                                                                            class="text-muted text-uppercase d-block">Tipo
                                                                                            de Sangre</label>
                                                                                        <div class="font-weight-bold">
                                                                                            {{ $alumno->datosPersonales?->tipoSangre?->nombre ?? 'N/A' }}
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3 mb-3">
                                                                                        <label
                                                                                            class="text-muted text-uppercase d-block">NSS</label>
                                                                                        <div class="font-weight-bold">
                                                                                            {{ $alumno->datosPersonales?->numero_seguridad_social ?? 'No registrado' }}
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3 mb-3">
                                                                                        <label
                                                                                            class="text-muted text-uppercase d-block">Lengua
                                                                                            Indígena</label>
                                                                                        <div class="font-weight-bold">
                                                                                            {{ $alumno->datosPersonales?->lenguaIndigena?->nombre ?? 'No' }}
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3 mb-3">
                                                                                        <label
                                                                                            class="text-muted text-uppercase d-block">Discapacidad</label>
                                                                                        <div class="font-weight-bold">
                                                                                            {{ $alumno->datosPersonales?->discapacidad?->nombre ?? 'Ninguna' }}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    {{-- Contacto y Domicilio --}}
                                                                    <div class="row mb-4">
                                                                        <div class="col-md-6">
                                                                            <div class="bg-white border rounded h-100">
                                                                                <div class="px-4 py-3 border-bottom"
                                                                                    style="background-color: #f1f5f9;">
                                                                                    <h6
                                                                                        class="text-danger font-weight-bold mb-3">
                                                                                        <i
                                                                                            class="fas fa-phone mr-2"></i>Contacto
                                                                                    </h6>
                                                                                </div>
                                                                                <div class="p-4">
                                                                                    <div class="mb-3">
                                                                                        <label
                                                                                            class="text-muted text-uppercase d-block">Correo
                                                                                            Electrónico</label>
                                                                                        <div class="font-weight-bold">
                                                                                            {{ $alumno->datosPersonales?->correo ?? 'No registrado' }}
                                                                                        </div>
                                                                                    </div>
                                                                                    <div>
                                                                                        <label
                                                                                            class="text-muted text-uppercase d-block">Teléfono</label>
                                                                                        <div class="font-weight-bold">
                                                                                            {{ $alumno->datosPersonales?->telefono ?? 'No registrado' }}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="bg-white border rounded h-100">
                                                                                <div class="px-4 py-3 border-bottom"
                                                                                    style="background-color: #f1f5f9;">
                                                                                    <h6
                                                                                        class="text-danger font-weight-bold mb-3">
                                                                                        <i
                                                                                            class="fas fa-map-marker-alt mr-2"></i>Domicilio
                                                                                    </h6>
                                                                                </div>
                                                                                <div class="p-4">
                                                                                    <div class="font-weight-bold">
                                                                                        <strong>{{ $alumno->datosPersonales?->domicilioAlumno?->calle ?? 'No registrada' }}</strong>
                                                                                        #{{ $alumno->datosPersonales?->domicilioAlumno?->numero_exterior ?? 'S/N' }}
                                                                                        @if ($alumno->datosPersonales?->domicilioAlumno?->numero_interior)
                                                                                            Int.
                                                                                            {{ $alumno->datosPersonales?->domicilioAlumno?->numero_interior }}
                                                                                        @endif
                                                                                    </div>
                                                                                    <div class="font-weight-bold">
                                                                                        {{ $alumno->datosPersonales?->domicilioAlumno?->colonia ?? '' }}<br>
                                                                                        {{ $alumno->datosPersonales?->domicilioAlumno?->municipio ?? '' }},
                                                                                        {{ $alumno->datosPersonales?->domicilioAlumno?->estado?->nombre ?? '' }}<br>
                                                                                        C.P.
                                                                                        {{ $alumno->datosPersonales?->domicilioAlumno?->codigo_postal ?? '' }}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    {{-- Escuela de Procedencia --}}
                                                                    <div class="mb-4">
                                                                        <div class="bg-white border rounded">
                                                                            <div class="px-4 py-3 border-bottom"
                                                                                style="background-color: #f1f5f9;">
                                                                                <h6
                                                                                    class="text-danger font-weight-bold mb-3">
                                                                                    <i
                                                                                        class="fas fa-school mr-2"></i>Escuela
                                                                                    de Procedencia
                                                                                </h6>
                                                                            </div>
                                                                            <div class="p-4">
                                                                                <div class="row">
                                                                                    <div class="col-md-4 mb-3">
                                                                                        <label
                                                                                            class="text-muted text-uppercase d-block">Subsistema</label>
                                                                                        <div class="font-weight-bold">
                                                                                            {{ $alumno->escuelaProcedencia?->subsistemas?->nombre ?? 'No especificado' }}
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-4 mb-3">
                                                                                        <label
                                                                                            class="text-muted text-uppercase d-block">Tipo
                                                                                            de Escuela</label>
                                                                                        <div class="font-weight-bold">
                                                                                            {{ $alumno->escuelaProcedencia?->tiposEscuela?->nombre ?? 'No especificado' }}
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-4 mb-3">
                                                                                        <label
                                                                                            class="text-muted text-uppercase d-block">Área
                                                                                            de Especialización</label>
                                                                                        <div class="font-weight-bold">
                                                                                            {{ $alumno->escuelaProcedencia?->areaEspecializacion?->nombre ?? 'No especificada' }}
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-4 mb-3">
                                                                                        <label
                                                                                            class="text-muted text-uppercase d-block">Localidad</label>
                                                                                        <div class="font-weight-bold">
                                                                                            {{ $alumno->escuelaProcedencia?->localidad ?? 'No registrada' }}
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-4 mb-3">
                                                                                        <label
                                                                                            class="text-muted text-uppercase d-block">Estado</label>
                                                                                        <div class="font-weight-bold">
                                                                                            {{ $alumno->escuelaProcedencia?->estados?->nombre ?? 'No registrado' }}
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-2 mb-3">
                                                                                        <label
                                                                                            class="text-muted text-uppercase d-block">Promedio</label>
                                                                                        <div
                                                                                            class="font-weight-bold text-primary">
                                                                                            {{ $alumno->escuelaProcedencia?->promedio_egreso ?? 'N/A' }}
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-2 mb-3">
                                                                                        <label
                                                                                            class="text-muted text-uppercase d-block">Beca</label>
                                                                                        <div class="font-weight-bold">
                                                                                            {{ $alumno->escuelaProcedencia?->becas?->nombre ?? 'No' }}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    {{-- Datos del Tutor --}}
                                                                    <div class="bg-white border rounded">
                                                                        <div class="px-4 py-3 border-bottom"
                                                                            style="background-color: #f1f5f9;">
                                                                            <h6
                                                                                class="text-danger font-weight-bold mb-3">
                                                                                <i
                                                                                    class="fas fa-user-tie mr-2"></i>Tutor
                                                                                o Responsable Legal
                                                                            </h6>
                                                                        </div>
                                                                        <div class="p-4">
                                                                            <div class="row">
                                                                                <div class="col-md-4 mb-3">
                                                                                    <label
                                                                                        class="text-muted text-uppercase d-block">Nombre
                                                                                        Completo</label>
                                                                                    <div class="font-weight-bold">
                                                                                        {{ $alumno->tutor?->nombres ?? 'No registrado' }}
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3 mb-3">
                                                                                    <label
                                                                                        class="text-muted text-uppercase d-block">Parentesco</label>
                                                                                    <div class="font-weight-bold">
                                                                                        {{ $alumno->tutor?->parentescos?->nombre ?? 'No especificado' }}
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3 mb-3">
                                                                                    <label
                                                                                        class="text-muted text-uppercase d-block">Teléfono</label>
                                                                                    <div class="font-weight-bold">
                                                                                        {{ $alumno->tutor?->telefono ?? 'No registrado' }}
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <label
                                                                                        class="text-muted text-uppercase d-block">Domicilio</label>
                                                                                    <div class="font-weight-bold">
                                                                                        {{ $alumno->tutor?->domiciliosTutor?->calle ?? 'No registrada' }}
                                                                                        #{{ $alumno->tutor?->domiciliosTutor?->numero_exterior ?? '' }}
                                                                                        {{ $alumno->tutor?->domiciliosTutor?->numero_interior ? 'Int. ' . $alumno->tutor?->domiciliosTutor?->numero_interior : '' }},
                                                                                        {{ $alumno->tutor?->domiciliosTutor?->colonia ?? '' }},
                                                                                        {{ $alumno->tutor?->domiciliosTutor?->municipio ?? '' }},
                                                                                        {{ $alumno->tutor?->domiciliosTutor?->estado?->nombre ?? '' }}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                            </div>

                                                            {{-- Footer --}}
                                                            <div class="modal-footer bg-white border-top">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">
                                                                    <i class="fas fa-times mr-2"></i>Cerrar
                                                                </button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>







                                                <!-- Modal Editar Alumno - Diseño Compacto -->
                                                <div class="modal fade" id="editarModal{{ $alumno->id_alumno }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="editarModal{{ $alumno->id_alumno }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-xl modal-dialog-scrollable"
                                                        role="document">
                                                        <div class="modal-content border-0 shadow-lg">
                                                            {{-- Header --}}
                                                            <div
                                                                class="modal-header modal-header-custom border-0 py-3">
                                                                <div class="w-100 text-center">
                                                                    <h5 class="m-0 font-weight-bold">
                                                                        ✏️ Editar Alumno
                                                                    </h5>
                                                                    <p class="m-0 mt-2 mb-0"
                                                                        style="font-size: 0.9rem; opacity: 0.95;">
                                                                        Modifique la información del alumno
                                                                        {{ optional($alumno->datosPersonales)->nombres }}
                                                                        {{ optional($alumno->datosPersonales)->primer_apellido }}
                                                                    </p>
                                                                </div>
                                                                <button type="button" class="close text-white"
                                                                    data-dismiss="modal" aria-label="Cerrar"
                                                                    style="position: absolute; right: 1.5rem; top: 1.5rem; font-size: 1.8rem; opacity: 0.9;">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>

                                                            {{-- Body --}}
                                                            <div class="modal-body p-3"
                                                                style="background-color: #f8f9fa;">
                                                                <div
                                                                    class="form-container p-4 bg-white rounded shadow-sm border">
                                                                    <form
                                                                        action="{{ route('alumnos.update', $alumno->id_alumno) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('PUT')

                                                                        {{-- Acordeón para secciones --}}
                                                                        <div class="accordion"
                                                                            id="editarAccordion{{ $alumno->id_alumno }}">

                                                                            {{-- =================== DATOS PERSONALES =================== --}}
                                                                            <div class="card mb-2 border-0 shadow-sm">
                                                                                <div class="card-header p-0"
                                                                                    id="headingEditarDatos{{ $alumno->id_alumno }}">
                                                                                    <button
                                                                                        class="btn text-danger font-weight-bold btn-block text-left py-2 px-3 text-decoration-none"
                                                                                        type="button"
                                                                                        data-toggle="collapse"
                                                                                        data-target="#collapseEditarDatos{{ $alumno->id_alumno }}"
                                                                                        aria-expanded="true"
                                                                                        aria-controls="collapseEditarDatos{{ $alumno->id_alumno }}">
                                                                                        <i
                                                                                            class="fas fa-user mr-2"></i>Datos
                                                                                        Personales
                                                                                        <i
                                                                                            class="fas fa-chevron-down float-right mt-1"></i>
                                                                                    </button>
                                                                                </div>
                                                                                <div id="collapseEditarDatos{{ $alumno->id_alumno }}"
                                                                                    class="collapse show"
                                                                                    aria-labelledby="headingEditarDatos{{ $alumno->id_alumno }}"
                                                                                    data-parent="#editarAccordion{{ $alumno->id_alumno }}">
                                                                                    <div class="card-body p-3">
                                                                                        <div class="row">
                                                                                            <div class="col-md-4 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">
                                                                                                    Nombres <span
                                                                                                        class="text-danger">*</span>
                                                                                                </label>
                                                                                                <input type="text"
                                                                                                    name="datos_personales[nombres]"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('datos_personales.nombres', optional($alumno->datosPersonales)->nombres) }}"
                                                                                                    placeholder="Nombres"
                                                                                                    required>
                                                                                            </div>
                                                                                            <div class="col-md-4 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">
                                                                                                    Primer Apellido
                                                                                                    <span
                                                                                                        class="text-danger">*</span>
                                                                                                </label>
                                                                                                <input type="text"
                                                                                                    name="datos_personales[primer_apellido]"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('datos_personales.primer_apellido', optional($alumno->datosPersonales)->primer_apellido) }}"
                                                                                                    placeholder="Primer apellido"
                                                                                                    required>
                                                                                            </div>
                                                                                            <div class="col-md-4 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Segundo
                                                                                                    Apellido</label>
                                                                                                <input type="text"
                                                                                                    name="datos_personales[segundo_apellido]"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('datos_personales.segundo_apellido', optional($alumno->datosPersonales)->segundo_apellido) }}"
                                                                                                    placeholder="Segundo apellido">
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div class="col-md-4 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">CURP</label>
                                                                                                <input type="text"
                                                                                                    name="curp"
                                                                                                    maxlength="18"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('curp', optional($alumno->datosPersonales)->curp) }}"
                                                                                                    placeholder="18 caracteres">
                                                                                            </div>
                                                                                            <div class="flex-grow-1"
                                                                                                style="min-width: 200px;">
                                                                                                <label>Fecha de
                                                                                                    Nacimiento</label>
                                                                                                <input type="date"
                                                                                                    name="fecha_nacimiento"
                                                                                                    value="{{ old('fecha_nacimiento', optional($alumno->datosPersonales)->fecha_nacimiento ? \Carbon\Carbon::parse($alumno->datosPersonales->fecha_nacimiento)->format('Y-m-d') : '') }}"
                                                                                                    class="form-control">
                                                                                            </div>
                                                                                            <div class="col-md-2 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Edad</label>
                                                                                                <input type="number"
                                                                                                    name="edad"
                                                                                                    min="0"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('edad', optional($alumno->datosPersonales)->edad) }}"
                                                                                                    placeholder="Años">
                                                                                            </div>
                                                                                            <div class="col-md-3 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Lugar
                                                                                                    Nac.</label>
                                                                                                <input type="text"
                                                                                                    name="lugar_nacimiento"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('lugar_nacimiento', optional($alumno->datosPersonales)->lugar_nacimiento) }}"
                                                                                                    placeholder="Ciudad, Estado">
                                                                                            </div>
                                                                                            <div class="col-md-3 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Estado
                                                                                                    de
                                                                                                    Nacimiento</label>
                                                                                                <select
                                                                                                    name="estado_nacimiento"
                                                                                                    class="form-control form-control-sm">
                                                                                                    <option
                                                                                                        value="">
                                                                                                        -- Selecciona --
                                                                                                    </option>
                                                                                                    @foreach ($estados as $estado)
                                                                                                        <option
                                                                                                            value="{{ $estado->id_estado }}"
                                                                                                            {{ old('estado_nacimiento', $alumno->datosPersonales->estado_nacimiento ?? null) == $estado->id_estado ? 'selected' : '' }}>
                                                                                                            {{ $estado->nombre }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>


                                                                                        </div>

                                                                                        <div class="row">

                                                                                            <div class="col-md-3 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Estado
                                                                                                    Civil</label>
                                                                                                <select
                                                                                                    name="id_estado_civil"
                                                                                                    class="form-control form-control-sm">
                                                                                                    <option
                                                                                                        value="">
                                                                                                        -- Selecciona --
                                                                                                    </option>
                                                                                                    @foreach ($estados_civiles as $estado)
                                                                                                        <option
                                                                                                            value="{{ $estado->id_estado_civil }}"
                                                                                                            {{ old('id_estado_civil', optional($alumno->datosPersonales)->id_estado_civil) == $estado->id_estado_civil ? 'selected' : '' }}>
                                                                                                            {{ $estado->nombre }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-md-3 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Género</label>
                                                                                                <select
                                                                                                    name="id_genero"
                                                                                                    class="form-control form-control-sm">
                                                                                                    <option
                                                                                                        value="">
                                                                                                        -- Selecciona --
                                                                                                    </option>
                                                                                                    @foreach ($generos as $genero)
                                                                                                        <option
                                                                                                            value="{{ $genero->id_genero }}"
                                                                                                            {{ old('id_genero', optional($alumno->datosPersonales)->id_genero) == $genero->id_genero ? 'selected' : '' }}>
                                                                                                            {{ $genero->nombre }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-md-3 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Tipo
                                                                                                    Sangre</label>
                                                                                                <select
                                                                                                    name="id_tipo_sangre"
                                                                                                    class="form-control form-control-sm">
                                                                                                    <option
                                                                                                        value="">
                                                                                                        -- Selecciona --
                                                                                                    </option>
                                                                                                    @foreach ($tipos_sangre as $tipo)
                                                                                                        <option
                                                                                                            value="{{ $tipo->id_tipo_sangre }}"
                                                                                                            {{ old('id_tipo_sangre', optional($alumno->datosPersonales)->id_tipo_sangre) == $tipo->id_tipo_sangre ? 'selected' : '' }}>
                                                                                                            {{ $tipo->nombre }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div class="col-md-4 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Lengua
                                                                                                    Indígena</label>
                                                                                                <select
                                                                                                    name="id_lengua_indigena"
                                                                                                    class="form-control form-control-sm">
                                                                                                    <option
                                                                                                        value="">
                                                                                                        -- Selecciona --
                                                                                                    </option>
                                                                                                    @foreach ($lenguas as $lengua)
                                                                                                        <option
                                                                                                            value="{{ $lengua->id_lengua_indigena }}"
                                                                                                            {{ old('id_lengua_indigena', optional($alumno->datosPersonales)->id_lengua_indigena) == $lengua->id_lengua_indigena ? 'selected' : '' }}>
                                                                                                            {{ $lengua->nombre }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-md-4 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Discapacidad</label>
                                                                                                <select
                                                                                                    name="id_discapacidad"
                                                                                                    class="form-control form-control-sm">
                                                                                                    <option
                                                                                                        value="">
                                                                                                        -- Selecciona --
                                                                                                    </option>
                                                                                                    @foreach ($discapacidades as $discapacidad)
                                                                                                        <option
                                                                                                            value="{{ $discapacidad->id_discapacidad }}"
                                                                                                            {{ old('id_discapacidad', optional($alumno->datosPersonales)->id_discapacidad) == $discapacidad->id_discapacidad ? 'selected' : '' }}>
                                                                                                            {{ $discapacidad->nombre }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-md-2 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">N°
                                                                                                    Hijos</label>
                                                                                                <input type="number"
                                                                                                    name="hijos"
                                                                                                    min="0"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('hijos', optional($alumno->datosPersonales)->hijos) }}"
                                                                                                    placeholder="0">
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div class="col-md-5 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Correo
                                                                                                    Electrónico</label>
                                                                                                <input type="email"
                                                                                                    name="correo"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('correo', optional($alumno->datosPersonales)->correo) }}"
                                                                                                    placeholder="ejemplo@correo.com">
                                                                                            </div>
                                                                                            <div class="col-md-4 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Teléfono</label>
                                                                                                <input type="text"
                                                                                                    name="datos_personales[telefono]"
                                                                                                    maxlength="10"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('datos_personales.telefono', optional($alumno->datosPersonales)->telefono) }}"
                                                                                                    placeholder="10 dígitos">
                                                                                            </div>
                                                                                            <div class="col-md-3 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">N°
                                                                                                    Seguridad
                                                                                                    Social</label>
                                                                                                <input type="text"
                                                                                                    name="numero_seguridad_social"
                                                                                                    maxlength="11"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('numero_seguridad_social', optional($alumno->datosPersonales)->numero_seguridad_social) }}"
                                                                                                    placeholder="11 dígitos">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            {{-- =================== DOMICILIO ALUMNO =================== --}}
                                                                            <div class="card mb-2 border-0 shadow-sm">
                                                                                <div class="card-header p-0"
                                                                                    id="headingEditarDomicilio{{ $alumno->id_alumno }}">
                                                                                    <button
                                                                                        class="btn text-danger font-weight-bold btn-block text-left py-2 px-3 text-decoration-none collapsed"
                                                                                        type="button"
                                                                                        data-toggle="collapse"
                                                                                        data-target="#collapseEditarDomicilio{{ $alumno->id_alumno }}"
                                                                                        aria-expanded="false"
                                                                                        aria-controls="collapseEditarDomicilio{{ $alumno->id_alumno }}">
                                                                                        <i
                                                                                            class="fas fa-home mr-2"></i>Domicilio
                                                                                        del Alumno
                                                                                        <i
                                                                                            class="fas fa-chevron-down float-right mt-1"></i>
                                                                                    </button>
                                                                                </div>
                                                                                <div id="collapseEditarDomicilio{{ $alumno->id_alumno }}"
                                                                                    class="collapse"
                                                                                    aria-labelledby="headingEditarDomicilio{{ $alumno->id_alumno }}"
                                                                                    data-parent="#editarAccordion{{ $alumno->id_alumno }}">
                                                                                    <div class="card-body p-3">
                                                                                        <div class="row">
                                                                                            <div class="col-md-4 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">
                                                                                                    Calle <span
                                                                                                        class="text-danger">*</span>
                                                                                                </label>
                                                                                                <input type="text"
                                                                                                    name="domicilio_alumno[calle]"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('domicilio_alumno.calle', optional($alumno->domicilioAlumno)->calle) }}"
                                                                                                    placeholder="Nombre de la calle"
                                                                                                    required>
                                                                                            </div>
                                                                                            <div class="col-md-2 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">N°
                                                                                                    Ext.</label>
                                                                                                <input type="number"
                                                                                                    name="domicilio_alumno[numero_exterior]"
                                                                                                    min="0"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('domicilio_alumno.numero_exterior', optional($alumno->domicilioAlumno)->numero_exterior) }}"
                                                                                                    placeholder="0">
                                                                                            </div>
                                                                                            <div class="col-md-2 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">N°
                                                                                                    Int.</label>
                                                                                                <input type="number"
                                                                                                    name="domicilio_alumno[numero_interior]"
                                                                                                    min="0"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('domicilio_alumno.numero_interior', optional($alumno->domicilioAlumno)->numero_interior) }}"
                                                                                                    placeholder="0">
                                                                                            </div>
                                                                                            <div class="col-md-4 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">
                                                                                                    Colonia <span
                                                                                                        class="text-danger">*</span>
                                                                                                </label>
                                                                                                <input type="text"
                                                                                                    name="domicilio_alumno[colonia]"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('domicilio_alumno.colonia', optional($alumno->domicilioAlumno)->colonia) }}"
                                                                                                    placeholder="Nombre de la colonia"
                                                                                                    required>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div class="col-md-4 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">
                                                                                                    Comunidad <span
                                                                                                        class="text-danger">*</span>
                                                                                                </label>
                                                                                                <input type="text"
                                                                                                    name="domicilio_alumno[comunidad]"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('domicilio_alumno.comunidad', optional($alumno->domicilioAlumno)->comunidad) }}"
                                                                                                    placeholder="Nombre de la comunidad"
                                                                                                    required>
                                                                                            </div>
                                                                                            <div class="col-md-3 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Distrito</label>
                                                                                                <select
                                                                                                    name="domicilio_alumno[id_distrito]"
                                                                                                    class="form-control form-control-sm">
                                                                                                    <option
                                                                                                        value="">
                                                                                                        -- Selecciona --
                                                                                                    </option>
                                                                                                    @foreach ($distritos as $distrito)
                                                                                                        <option
                                                                                                            value="{{ $distrito->id_distrito }}"
                                                                                                            {{ old('domicilio_alumno.id_distrito', optional($alumno->domicilioAlumno)->id_distrito) == $distrito->id_distrito ? 'selected' : '' }}>
                                                                                                            {{ $distrito->nombre }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-md-3 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Estado</label>
                                                                                                <select
                                                                                                    name="domicilio_alumno[id_estado]"
                                                                                                    class="form-control form-control-sm">
                                                                                                    <option
                                                                                                        value="">
                                                                                                        -- Selecciona --
                                                                                                    </option>
                                                                                                    @foreach ($estados as $estado)
                                                                                                        <option
                                                                                                            value="{{ $estado->id_estado }}"
                                                                                                            {{ old('domicilio_alumno.id_estado', optional($alumno->domicilioAlumno)->id_estado) == $estado->id_estado ? 'selected' : '' }}>
                                                                                                            {{ $estado->nombre }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-md-2 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">C.P.</label>
                                                                                                <input type="number"
                                                                                                    name="codigo_postal"
                                                                                                    min="0"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('codigo_postal', optional($alumno->domicilioAlumno)->codigo_postal) }}"
                                                                                                    placeholder="00000">
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div class="col-md-4 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">
                                                                                                    Municipio <span
                                                                                                        class="text-danger">*</span>
                                                                                                </label>
                                                                                                <input type="text"
                                                                                                    name="domicilio_alumno[municipio]"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('domicilio_alumno.municipio', optional($alumno->domicilioAlumno)->municipio) }}"
                                                                                                    placeholder="Nombre del municipio"
                                                                                                    required>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            {{-- =================== ESCUELA DE PROCEDENCIA =================== --}}
                                                                            <div class="card mb-2 border-0 shadow-sm">
                                                                                <div class="card-header p-0"
                                                                                    id="headingEditarEscuela{{ $alumno->id_alumno }}">
                                                                                    <button
                                                                                        class="btn text-danger font-weight-bold btn-block text-left py-2 px-3 text-decoration-none collapsed"
                                                                                        type="button"
                                                                                        data-toggle="collapse"
                                                                                        data-target="#collapseEditarEscuela{{ $alumno->id_alumno }}"
                                                                                        aria-expanded="false"
                                                                                        aria-controls="collapseEditarEscuela{{ $alumno->id_alumno }}">
                                                                                        <i
                                                                                            class="fas fa-school mr-2"></i>Escuela
                                                                                        de Procedencia
                                                                                        <i
                                                                                            class="fas fa-chevron-down float-right mt-1"></i>
                                                                                    </button>
                                                                                </div>
                                                                                <div id="collapseEditarEscuela{{ $alumno->id_alumno }}"
                                                                                    class="collapse"
                                                                                    aria-labelledby="headingEditarEscuela{{ $alumno->id_alumno }}"
                                                                                    data-parent="#editarAccordion{{ $alumno->id_alumno }}">
                                                                                    <div class="card-body p-3">
                                                                                        <div class="row">
                                                                                            <div class="col-md-4 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Subsistema</label>
                                                                                                <select
                                                                                                    name="id_subsistema"
                                                                                                    class="form-control form-control-sm">
                                                                                                    <option
                                                                                                        value="">
                                                                                                        -- Selecciona --
                                                                                                    </option>
                                                                                                    @foreach ($subsistemas as $subsistema)
                                                                                                        <option
                                                                                                            value="{{ $subsistema->id_subsistema }}"
                                                                                                            {{ old('id_subsistema', optional($alumno->escuelaProcedencia)->id_subsistema) == $subsistema->id_subsistema ? 'selected' : '' }}>
                                                                                                            {{ $subsistema->nombre }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-md-3 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Tipo
                                                                                                    Escuela</label>
                                                                                                <select
                                                                                                    name="id_tipo_escuela"
                                                                                                    class="form-control form-control-sm">
                                                                                                    <option
                                                                                                        value="">
                                                                                                        -- Selecciona --
                                                                                                    </option>
                                                                                                    @foreach ($tiposEscuela as $tipo)
                                                                                                        <option
                                                                                                            value="{{ $tipo->id_tipo_escuela }}"
                                                                                                            {{ old('id_tipo_escuela', optional($alumno->escuelaProcedencia)->id_tipo_escuela) == $tipo->id_tipo_escuela ? 'selected' : '' }}>
                                                                                                            {{ $tipo->nombre }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-md-3 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">
                                                                                                    Promedio <span
                                                                                                        class="text-danger">*</span>
                                                                                                </label>
                                                                                                <input type="number"
                                                                                                    name="promedio_egreso"
                                                                                                    min="0"
                                                                                                    step="0.01"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('promedio_egreso', optional($alumno->escuelaProcedencia)->promedio_egreso) }}"
                                                                                                    placeholder="0.00"
                                                                                                    required>
                                                                                            </div>
                                                                                            <div class="col-md-2 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Beca</label>
                                                                                                <select name="id_beca"
                                                                                                    class="form-control form-control-sm">
                                                                                                    <option
                                                                                                        value="">
                                                                                                        -- Selecciona --
                                                                                                    </option>
                                                                                                    @foreach ($becas as $beca)
                                                                                                        <option
                                                                                                            value="{{ $beca->id_beca }}"
                                                                                                            {{ old('id_beca', optional($alumno->escuelaProcedencia)->id_beca) == $beca->id_beca ? 'selected' : '' }}>
                                                                                                            {{ $beca->nombre }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div class="col-md-5 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Área
                                                                                                    Especialización</label>
                                                                                                <select
                                                                                                    name="id_area_especializacion"
                                                                                                    class="form-control form-control-sm">
                                                                                                    <option
                                                                                                        value="">
                                                                                                        -- Selecciona --
                                                                                                    </option>
                                                                                                    @foreach ($areaEspecializacion as $area)
                                                                                                        <option
                                                                                                            value="{{ $area->id_area_especializacion }}"
                                                                                                            {{ old('id_area_especializacion', optional($alumno->escuelaProcedencia)->id_area_especializacion) == $area->id_area_especializacion ? 'selected' : '' }}>
                                                                                                            {{ $area->nombre }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-md-3 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Estado</label>
                                                                                                <select
                                                                                                    name="escuela[id_estado]"
                                                                                                    class="form-control form-control-sm">
                                                                                                    <option
                                                                                                        value="">
                                                                                                        -- Selecciona --
                                                                                                    </option>
                                                                                                    @foreach ($estados as $estado)
                                                                                                        <option
                                                                                                            value="{{ $estado->id_estado }}"
                                                                                                            {{ old('escuela.id_estado', optional($alumno->escuelaProcedencia)->id_estado) == $estado->id_estado ? 'selected' : '' }}>
                                                                                                            {{ $estado->nombre }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-md-4 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Localidad</label>
                                                                                                <input type="text"
                                                                                                    name="escuela[localidad]"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('escuela.localidad', optional($alumno->escuelaProcedencia)->localidad) }}"
                                                                                                    placeholder="Nombre de la localidad">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            {{-- =================== DATOS DEL TUTOR =================== --}}
                                                                            <div class="card mb-2 border-0 shadow-sm">
                                                                                <div class="card-header p-0"
                                                                                    id="headingEditarTutor{{ $alumno->id_alumno }}">
                                                                                    <button
                                                                                        class="btn text-danger font-weight-bold btn-block text-left py-2 px-3 text-decoration-none collapsed"
                                                                                        type="button"
                                                                                        data-toggle="collapse"
                                                                                        data-target="#collapseEditarTutor{{ $alumno->id_alumno }}"
                                                                                        aria-expanded="false"
                                                                                        aria-controls="collapseEditarTutor{{ $alumno->id_alumno }}">
                                                                                        <i
                                                                                            class="fas fa-user-tie mr-2"></i>Datos
                                                                                        del Tutor
                                                                                        <i
                                                                                            class="fas fa-chevron-down float-right mt-1"></i>
                                                                                    </button>
                                                                                </div>
                                                                                <div id="collapseEditarTutor{{ $alumno->id_alumno }}"
                                                                                    class="collapse"
                                                                                    aria-labelledby="headingEditarTutor{{ $alumno->id_alumno }}"
                                                                                    data-parent="#editarAccordion{{ $alumno->id_alumno }}">
                                                                                    <div class="card-body p-3">
                                                                                        <div class="row">
                                                                                            <div class="col-md-8 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Nombre
                                                                                                    Completo</label>
                                                                                                <input type="text"
                                                                                                    name="tutor[nombres]"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('tutor', optional($alumno->tutor)->nombres) }}"
                                                                                                    placeholder="Nombre completo del tutor">
                                                                                            </div>
                                                                                            <div class="col-md-4 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Parentesco</label>
                                                                                                <select
                                                                                                    name="id_parentesco"
                                                                                                    class="form-control form-control-sm">
                                                                                                    <option
                                                                                                        value="">
                                                                                                        -- Selecciona --
                                                                                                    </option>
                                                                                                    @foreach ($parentescos as $parentesco)
                                                                                                        <option
                                                                                                            value="{{ $parentesco->id_parentesco }}"
                                                                                                            {{ old('tutor.parentescos', optional($alumno->tutor)->id_parentesco) == $parentesco->id_parentesco ? 'selected' : '' }}>
                                                                                                            {{ $parentesco->nombre }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div class="col-md-4 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">
                                                                                                    Calle <span
                                                                                                        class="text-danger">*</span>
                                                                                                </label>
                                                                                                <input type="text"
                                                                                                    name="domicilio_tutor[calle]"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('domicilio_tutor.calle', optional(optional($alumno->tutor)->domiciliosTutor)->calle) }}"
                                                                                                    placeholder="Nombre de la calle"
                                                                                                    required>
                                                                                            </div>
                                                                                            <div class="col-md-2 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">N°
                                                                                                    Ext.</label>
                                                                                                <input type="number"
                                                                                                    name="domicilio_tutor[numero_exterior]"
                                                                                                    min="0"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('domicilio_tutor.numero_exterior', optional(optional($alumno->tutor)->domiciliosTutor)->numero_exterior) }}"
                                                                                                    placeholder="0">
                                                                                            </div>
                                                                                            <div class="col-md-2 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">N°
                                                                                                    Int.</label>
                                                                                                <input type="number"
                                                                                                    name="domicilio_tutor[numero_interior]"
                                                                                                    min="0"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('domicilio_tutor.numero_interior', optional(optional($alumno->tutor)->domiciliosTutor)->numero_interior) }}"
                                                                                                    placeholder="0">
                                                                                            </div>
                                                                                            <div class="col-md-4 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">
                                                                                                    Colonia <span
                                                                                                        class="text-danger">*</span>
                                                                                                </label>
                                                                                                <input type="text"
                                                                                                    name="domicilio_tutor[colonia]"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('domicilio_tutor.colonia', optional(optional($alumno->tutor)->domiciliosTutor)->colonia) }}"
                                                                                                    placeholder="Nombre de la colonia"
                                                                                                    required>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div class="col-md-4 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">
                                                                                                    Municipio <span
                                                                                                        class="text-danger">*</span>
                                                                                                </label>
                                                                                                <input type="text"
                                                                                                    name="domicilio_tutor[municipio]"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('domicilio_tutor.municipio', optional(optional($alumno->tutor)->domiciliosTutor)->municipio) }}"
                                                                                                    placeholder="Nombre del municipio"
                                                                                                    required>
                                                                                            </div>
                                                                                            <div class="col-md-3 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Distrito</label>
                                                                                                <select
                                                                                                    name="domicilio_tutor[id_distrito]"
                                                                                                    class="form-control form-control-sm">
                                                                                                    <option
                                                                                                        value="">
                                                                                                        -- Selecciona --
                                                                                                    </option>
                                                                                                    @foreach ($distritos as $distrito)
                                                                                                        <option
                                                                                                            value="{{ $distrito->id_distrito }}"
                                                                                                            {{ old('tutor.domiciliosTutor.distritos', optional(optional($alumno->tutor)->domiciliosTutor)->id_distrito) == $distrito->id_distrito ? 'selected' : '' }}>
                                                                                                            {{ $distrito->nombre }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-md-3 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Estado</label>
                                                                                                <select
                                                                                                    name="domicilio_tutor[id_estado]"
                                                                                                    class="form-control form-control-sm">
                                                                                                    <option
                                                                                                        value="">
                                                                                                        -- Selecciona --
                                                                                                    </option>
                                                                                                    @foreach ($estados as $estado)
                                                                                                        <option
                                                                                                            value="{{ $estado->id_estado }}"
                                                                                                            {{ old('tutor.domiciliosTutor.estados', optional(optional($alumno->tutor)->domiciliosTutor)->id_estado) == $estado->id_estado ? 'selected' : '' }}>
                                                                                                            {{ $estado->nombre }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-md-2 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Teléfono</label>
                                                                                                <input type="number"
                                                                                                    name="tutor[telefono]"
                                                                                                    min="0"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('tutor.telefono', optional($alumno->tutor)->telefono) }}"
                                                                                                    placeholder="10 dígitos">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            {{-- =================== ESTATUS ACADÉMICO =================== --}}
                                                                            <div class="card mb-2 border-0 shadow-sm">
                                                                                <div class="card-header p-0"
                                                                                    id="headingEditarEstatus{{ $alumno->id_alumno }}">
                                                                                    <button
                                                                                        class="btn text-danger font-weight-bold btn-block text-left py-2 px-3 text-decoration-none collapsed"
                                                                                        type="button"
                                                                                        data-toggle="collapse"
                                                                                        data-target="#collapseEditarEstatus{{ $alumno->id_alumno }}"
                                                                                        aria-expanded="false"
                                                                                        aria-controls="collapseEditarEstatus{{ $alumno->id_alumno }}">
                                                                                        <i
                                                                                            class="fas fa-graduation-cap mr-2"></i>Estatus
                                                                                        Académico
                                                                                        <i
                                                                                            class="fas fa-chevron-down float-right mt-1"></i>
                                                                                    </button>
                                                                                </div>
                                                                                <div id="collapseEditarEstatus{{ $alumno->id_alumno }}"
                                                                                    class="collapse"
                                                                                    aria-labelledby="headingEditarEstatus{{ $alumno->id_alumno }}"
                                                                                    data-parent="#editarAccordion{{ $alumno->id_alumno }}">
                                                                                    <div class="card-body p-3">
                                                                                        <div class="row">
                                                                                            <div class="col-md-4 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">
                                                                                                    Estatus <span
                                                                                                        class="text-danger">*</span>
                                                                                                </label>

                                                                                                <select
                                                                                                    name="id_historial_status"
                                                                                                    id="id_historial_status_editar{{ $alumno->id_alumno }}"
                                                                                                    class="form-control form-control-sm"
                                                                                                    onchange="toggleSeccionAcademica{{ $alumno->id_alumno }}(this.value)"
                                                                                                    required>
                                                                                                    <option
                                                                                                        value="">
                                                                                                        -- Selecciona --
                                                                                                    </option>
                                                                                                    @foreach ($estatus as $status)
                                                                                                        <option
                                                                                                            value="{{ $status->id_historial_status }}"
                                                                                                            {{ $alumno->estatus == $status->id_historial_status ? 'selected' : '' }}>
                                                                                                            {{ $status->nombre }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>

                                                                                        {{-- =================== DATOS ACADÉMICOS (CONDICIONAL) =================== --}}
                                                                                        <div id="seccionAcademicaEditar{{ $alumno->id_alumno }}"
                                                                                            style="{{ in_array($alumno->estatus, [1, 2, 3, 4, 5, 6, 8, 9]) ? 'display:block;' : 'display:none;' }}">
                                                                                            <div class="row mt-3">
                                                                                                <div
                                                                                                    class="col-md-4 mb-2">
                                                                                                    <label
                                                                                                        class="form-label-custom small mb-1">Matrícula</label>
                                                                                                    <input
                                                                                                        type="text"
                                                                                                        name="matricula"
                                                                                                        class="form-control form-control-sm"
                                                                                                        value="{{ old('matricula', $alumno->datosAcademicos?->matricula) }}"
                                                                                                        placeholder="Número de matrícula">
                                                                                                </div>
                                                                                                <div
                                                                                                    class="col-md-4 mb-2">
                                                                                                    <label
                                                                                                        class="form-label-custom small mb-1">Carrera</label>
                                                                                                    <select
                                                                                                        name="id_carrera"
                                                                                                        class="form-control form-control-sm">
                                                                                                        <option
                                                                                                            value="">
                                                                                                            --
                                                                                                            Selecciona
                                                                                                            --</option>
                                                                                                        @foreach ($carreras as $carrera)
                                                                                                            <option
                                                                                                                value="{{ $carrera->id_carrera }}"
                                                                                                                @if (old('id_carrera')) {{ old('id_carrera') == $carrera->id_carrera ? 'selected' : '' }}
                                    @else
                                        {{ $alumno->datosAcademicos?->id_carrera == $carrera->id_carrera ? 'selected' : '' }} @endif>
                                                                                                                {{ $carrera->nombre }}
                                                                                                            </option>
                                                                                                        @endforeach
                                                                                                    </select>
                                                                                                </div>
                                                                                                <div
                                                                                                    class="col-md-3 mb-2">
                                                                                                    <label
                                                                                                        class="form-label-custom small mb-1">Generación</label>
                                                                                                    <select
                                                                                                        name="id_generacion"
                                                                                                        class="form-control form-control-sm">
                                                                                                        <option
                                                                                                            value="">
                                                                                                            --
                                                                                                            Selecciona
                                                                                                            --</option>
                                                                                                        @foreach ($generaciones as $generacion)
                                                                                                            <option
                                                                                                                value="{{ $generacion->id_generacion }}"
                                                                                                                @if (old('id_generacion')) {{ old('id_generacion') == $generacion->id_generacion ? 'selected' : '' }}
                                    @else
                                        {{ $alumno->id_generacion == $generacion->id_generacion ? 'selected' : '' }} @endif>
                                                                                                                {{ $generacion->nombre }}
                                                                                                            </option>
                                                                                                        @endforeach
                                                                                                    </select>
                                                                                                </div>
                                                                                                <div
                                                                                                    class="col-md-4 mb-2">
                                                                                                    <label
                                                                                                        class="form-label-custom small mb-1">Plan
                                                                                                        de
                                                                                                        Estudios</label>
                                                                                                    <select
                                                                                                        name="id_plan_estudio"
                                                                                                        class="form-control form-control-sm">
                                                                                                        <option
                                                                                                            value="">
                                                                                                            --
                                                                                                            Selecciona
                                                                                                            --</option>
                                                                                                        @foreach ($planes as $plan)
                                                                                                            <option
                                                                                                                value="{{ $plan->id_plan_estudio }}"
                                                                                                                @if (old('id_plan_estudio')) {{ old('id_plan_estudio') == $plan->id_plan_estudio ? 'selected' : '' }}
                                    @else
                                        {{ $alumno->datosAcademicos?->id_plan_estudio == $plan->id_plan_estudio ? 'selected' : '' }} @endif>
                                                                                                                {{ $plan->nombre }}
                                                                                                            </option>
                                                                                                        @endforeach
                                                                                                    </select>
                                                                                                </div>
                                                                                                <div
                                                                                                    class="col-md-4 mb-2">
                                                                                                    <label
                                                                                                        class="form-label-custom small mb-1">
                                                                                                        Servicio Social
                                                                                                        <span
                                                                                                            class="text-danger">*</span>
                                                                                                    </label>
                                                                                                    <select
                                                                                                        name="servicios_social"
                                                                                                        class="form-control form-control-sm"
                                                                                                        required>
                                                                                                        <option
                                                                                                            value="">
                                                                                                            --
                                                                                                            Selecciona
                                                                                                            --</option>
                                                                                                        <option
                                                                                                            value="1"
                                                                                                            {{ ($alumno->servicios_social ?? 0) == 1 ? 'selected' : '' }}>
                                                                                                            Sí</option>
                                                                                                        <option
                                                                                                            value="0"
                                                                                                            {{ ($alumno->servicios_social ?? 0) == 0 ? 'selected' : '' }}>
                                                                                                            No</option>
                                                                                                    </select>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            {{-- Script para manejar la visibilidad de la sección académica --}}
                                                                            <script>
                                                                                function toggleSeccionAcademica{{ $alumno->id_alumno }}(statusId) {
                                                                                    const seccion = document.getElementById('seccionAcademicaEditar{{ $alumno->id_alumno }}');
                                                                                    // IDs de estatus que requieren datos académicos
                                                                                    const estatusConAcademicos = [1, 2, 3, 4, 5, 6, 8, 9];

                                                                                    if (estatusConAcademicos.includes(parseInt(statusId))) {
                                                                                        seccion.style.display = 'block';
                                                                                    } else {
                                                                                        seccion.style.display = 'none';
                                                                                    }
                                                                                }

                                                                                // Inicializar al cargar la página
                                                                                document.addEventListener('DOMContentLoaded', function() {
                                                                                    const select = document.getElementById('id_historial_status_editar{{ $alumno->id_alumno }}');
                                                                                    if (select && select.value) {
                                                                                        toggleSeccionAcademica{{ $alumno->id_alumno }}(select.value);
                                                                                    }
                                                                                });
                                                                            </script>
                                                                        </div>

                                                                        {{-- Nota de campos obligatorios --}}
                                                                        <div class="text-center mt-3 mb-2">
                                                                            <small class="text-muted">
                                                                                <span class="text-danger">*</span>
                                                                                Campos
                                                                                obligatorios
                                                                            </small>
                                                                        </div>

                                                                        {{-- Footer con botones --}}
                                                                        <div class="text-right mt-3">
                                                                            <button type="button"
                                                                                class="btn btn-outline-secondary btn-sm px-3"
                                                                                data-dismiss="modal">
                                                                                <i
                                                                                    class="fas fa-times mr-1"></i>Cancelar
                                                                            </button>
                                                                            <button type="submit"
                                                                                class="btn btn-primary btn-sm px-3">
                                                                                <i
                                                                                    class="fas fa-save mr-1"></i>Actualizar
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>




                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-muted text-center">No hay
                                                        alumnos registrados</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
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

    <!-- Modal Nuevo Alumno-->
    <div class="modal fade" id="nuevoAlumnoModal" tabindex="-1" role="dialog" aria-labelledby="nuevoAlumnoLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content border-0 shadow-lg">
                {{-- Header --}}
                <div class="modal-header modal-header-custom border-0 py-3">
                    <div class="w-100 text-center">
                        <h5 class="m-0 font-weight-bold" id="nuevoAlumnoLabel">
                            👨‍🎓 Registrar Nuevo Alumno / Aspirante
                        </h5>
                        <p class="m-0 mt-2 mb-0" style="font-size: 0.9rem; opacity: 0.95;">
                            Complete todos los datos del estudiante
                        </p>
                    </div>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar"
                        style="position: absolute; right: 1.5rem; top: 1.5rem; font-size: 1.8rem; opacity: 0.9;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                {{-- Body --}}
                <div class="modal-body p-3" style="background-color: #f8f9fa;">
                    <div class="form-container p-4 bg-white rounded shadow-sm border">
                        <form action="{{ route('alumnos.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="is_create_alumno" value="1">
                            {{-- Acordeón para secciones --}}
                            <div class="accordion" id="alumnoAccordion">
                                @if ($errors->any() && old('is_create_alumno'))
                        <div class="alert alert-danger mb-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                                {{-- =================== DATOS PERSONALES =================== --}}
                                <div class="card mb-2 border-0 shadow-sm">
                                    <div class="card-header p-0" id="headingDatosPersonales">
                                        <button
                                            class="btn text-danger font-weight-bold btn-block text-left py-2 px-3 text-decoration-none"
                                            type="button" data-toggle="collapse"
                                            data-target="#collapseDatosPersonales" aria-expanded="true"
                                            aria-controls="collapseDatosPersonales">
                                            <i class="fas fa-user mr-2"></i>Datos Personales
                                            <i class="fas fa-chevron-down float-right mt-1"></i>
                                        </button>
                                    </div>
                                    <div id="collapseDatosPersonales" class="collapse show"
                                        aria-labelledby="headingDatosPersonales" data-parent="#alumnoAccordion">
                                        <div class="card-body p-3">
                                            <div class="row">
                                                <div class="flex-grow-1" style="min-width: 200px;">
                                                    <label class="form-label-custom small mb-1">
                                                        Nombres <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" name="datos_personales[nombres]"
                                                        class="form-control form-control-sm" placeholder="Nombres"
                                                        required>
                                                        @error('datos_personales.nombres')
                                                @if(old('is_create_alumno'))
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @endif
                                            @enderror
                                                </div>
                                                <div class="flex-grow-1" style="min-width: 200px;">
                                                    <label class="form-label-custom small mb-1">
                                                        Primer Apellido <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" name="datos_personales[primer_apellido]"
                                                        class="form-control form-control-sm"
                                                        placeholder="Primer apellido" required>
                                                        @error('datos_personales.primer_apellido')
                                                @if(old('is_create_alumno'))
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @endif
                                            @enderror
                                                </div>
                                                <div class="flex-grow-1" style="min-width: 200px;">
                                                    <label class="form-label-custom small mb-1">Segundo
                                                        Apellido</label>
                                                    <input type="text" name="datos_personales[segundo_apellido]"
                                                        class="form-control form-control-sm"
                                                        placeholder="Segundo apellido">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="flex-grow-1" style="min-width: 200px;">
                                                    <label class="form-label-custom small mb-1">CURP</label>
                                                    <input type="text" name="curp" maxlength="18"
                                                        class="form-control form-control-sm"
                                                        placeholder="18 caracteres" required>
                                                </div>
                                                <div class="flex-grow-1" style="min-width: 200px;">
                                                    <label class="form-label-custom small mb-1">Fecha de
                                                        Nacimiento</label>
                                                    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento_create"
                                                        class="form-control form-control-sm" required>
                                                        @error('datos_personales.fecha_nacimiento')
                                                @if(old('is_create_alumno'))
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @endif
                                            @enderror
                                                </div>
                                                <div class="flex-grow-1" style="width: 50px;">
                                                    <label class="form-label-custom small mb-1">Edad</label>
                                                    <input type="number" name="edad" id="edad_create" min="18" max="100" readonly
                                                        class="form-control form-control-sm" placeholder="Años">
                                                </div>
                                                <div class="flex-grow-1" style="min-width: 200px;">
                                                    <label class="form-label-custom small mb-1">Lugar de
                                                        Nacimiento</label>
                                                    <input type="text" name="lugar_nacimiento"
                                                        class="form-control form-control-sm"
                                                        placeholder="Ciudad, Estado">
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label class="form-label-custom small mb-1">Estado de
                                                        Nacimiento</label>
                                                    <select name="estado_nacimiento"
                                                        class="form-control form-control-sm">
                                                        <option value="">-- Selecciona --</option>
                                                        @foreach ($estados as $estado)
                                                            <option value="{{ $estado->id_estado }}">
                                                                {{ $estado->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">

                                                <div class="flex-grow-1" style="min-width: 150px;">
                                                    <label class="form-label-custom small mb-1">Estado Civil</label>
                                                    <select name="id_estado_civil"
                                                        class="form-control form-control-sm">
                                                        <option value="">-- Selecciona --</option>
                                                        @foreach ($estados_civiles as $estado)
                                                            <option value="{{ $estado->id_estado_civil }}">
                                                                {{ $estado->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="flex-grow-1" style="min-width: 150px;">
                                                    <label class="form-label-custom small mb-1">Género</label>
                                                    <select name="id_genero" class="form-control form-control-sm">
                                                        <option value="">-- Selecciona --</option>
                                                        @foreach ($generos as $genero)
                                                            <option value="{{ $genero->id_genero }}">
                                                                {{ $genero->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="flex-grow-1" style="min-width: 150px;">
                                                    <label class="form-label-custom small mb-1">Tipo Sangre</label>
                                                    <select name="id_tipo_sangre"
                                                        class="form-control form-control-sm">
                                                        <option value="">-- Selecciona --</option>
                                                        @foreach ($tipos_sangre as $tipo)
                                                            <option value="{{ $tipo->id_tipo_sangre }}">
                                                                {{ $tipo->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="flex-grow-1" style="min-width: 200px;">
                                                    <label class="form-label-custom small mb-1">Lengua Indígena</label>
                                                    <select name="id_lengua_indigena"
                                                        class="form-control form-control-sm">
                                                        <option value="">-- Selecciona --</option>
                                                        @foreach ($lenguas as $lengua)
                                                            <option value="{{ $lengua->id_lengua_indigena }}">
                                                                {{ $lengua->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="flex-grow-1" style="min-width: 200px;">
                                                    <label class="form-label-custom small mb-1">Discapacidad</label>
                                                    <select name="id_discapacidad"
                                                        class="form-control form-control-sm">
                                                        <option value="">-- Selecciona --</option>
                                                        @foreach ($discapacidades as $discapacidad)
                                                            <option value="{{ $discapacidad->id_discapacidad }}">
                                                                {{ $discapacidad->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="flex-grow-1" style="width: 100px;">
                                                    <label class="form-label-custom small mb-1">N° Hijos</label>
                                                    <input type="number" name="hijos" min="0"
                                                        class="form-control form-control-sm" placeholder="0">
                                                </div>

                                                <div class="flex-grow-1" style="min-width: 200px;">
                                                    <label class="form-label-custom small mb-1">Correo
                                                        Electrónico</label>
                                                    <input type="email" name="correo"
                                                        class="form-control form-control-sm"
                                                        placeholder="ejemplo@correo.com">
                                                </div>
                                                <div class="flex-grow-1" style="min-width: 150px;">
                                                    <label class="form-label-custom small mb-1">Teléfono</label>
                                                    <input type="text" name="datos_personales[telefono]"
                                                        maxlength="10" class="form-control form-control-sm"
                                                        placeholder="10 dígitos">
                                                </div>
                                                <div class="flex-grow-1" style="min-width: 150px;">
                                                    <label class="form-label-custom small mb-1">N° Seguridad
                                                        Social</label>
                                                    <input type="text" name="numero_seguridad_social"
                                                        maxlength="11" class="form-control form-control-sm"
                                                        placeholder="11 dígitos">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- =================== DOMICILIO ALUMNO =================== --}}
                                <div class="card mb-2 border-0 shadow-sm">
                                    <div class="card-header p-0" id="headingDomicilio">
                                        <button
                                            class="btn text-danger font-weight-bold btn-block text-left py-2 px-3 text-decoration-none collapsed"
                                            type="button" data-toggle="collapse" data-target="#collapseDomicilio"
                                            aria-expanded="false" aria-controls="collapseDomicilio">
                                            <i class="fas fa-home mr-2"></i>Domicilio del Alumno
                                            <i class="fas fa-chevron-down float-right mt-1"></i>
                                        </button>
                                    </div>
                                    <div id="collapseDomicilio" class="collapse"
                                        aria-labelledby="headingDomicilio" data-parent="#alumnoAccordion">
                                        <div class="card-body p-3">
                                            <div class="row">
                                                <div class="col-md-4 mb-2">
                                                    <label class="form-label-custom small mb-1">
                                                        Calle <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" name="domicilio_alumno[calle]"
                                                        class="form-control form-control-sm"
                                                        placeholder="Nombre de la calle" required>
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <label class="form-label-custom small mb-1">N° Ext.</label>
                                                    <input type="number" name="domicilio_alumno[numero_exterior]"
                                                        min="0" class="form-control form-control-sm"
                                                        placeholder="0">
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <label class="form-label-custom small mb-1">N° Int.</label>
                                                    <input type="number" name="domicilio_alumno[numero_interior]"
                                                        min="0" class="form-control form-control-sm"
                                                        placeholder="0">
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <label class="form-label-custom small mb-1">
                                                        Colonia <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" name="domicilio_alumno[colonia]"
                                                        class="form-control form-control-sm"
                                                        placeholder="Nombre de la colonia" required>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 mb-2">
                                                    <label class="form-label-custom small mb-1">
                                                        Comunidad <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" name="domicilio_alumno[comunidad]"
                                                        class="form-control form-control-sm"
                                                        placeholder="Nombre de la comunidad" required>
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label class="form-label-custom small mb-1">Distrito</label>
                                                    <select name="domicilio_alumno[id_distrito]"
                                                        class="form-control form-control-sm">
                                                        <option value="">-- Selecciona --</option>
                                                        @foreach ($distritos as $distrito)
                                                            <option value="{{ $distrito->id_distrito }}">
                                                                {{ $distrito->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label class="form-label-custom small mb-1">Estado</label>
                                                    <select name="domicilio_alumno[id_estado]"
                                                        class="form-control form-control-sm">
                                                        <option value="">-- Selecciona --</option>
                                                        @foreach ($estados as $estado)
                                                            <option value="{{ $estado->id_estado }}">
                                                                {{ $estado->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <label class="form-label-custom small mb-1">C.P.</label>
                                                    <input type="number" name="codigo_postal" min="0"
                                                        class="form-control form-control-sm" placeholder="00000">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 mb-2">
                                                    <label class="form-label-custom small mb-1">
                                                        Municipio <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" name="domicilio_alumno[municipio]"
                                                        class="form-control form-control-sm"
                                                        placeholder="Nombre del municipio" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- =================== ESCUELA DE PROCEDENCIA =================== --}}
                                <div class="card mb-2 border-0 shadow-sm">
                                    <div class="card-header p-0" id="headingEscuela">
                                        <button
                                            class="btn text-danger font-weight-bold btn-block text-left py-2 px-3 text-decoration-none collapsed"
                                            type="button" data-toggle="collapse" data-target="#collapseEscuela"
                                            aria-expanded="false" aria-controls="collapseEscuela">
                                            <i class="fas fa-school mr-2"></i>Escuela de Procedencia
                                            <i class="fas fa-chevron-down float-right mt-1"></i>
                                        </button>
                                    </div>
                                    <div id="collapseEscuela" class="collapse" aria-labelledby="headingEscuela"
                                        data-parent="#alumnoAccordion">
                                        <div class="card-body p-3">
                                            <div class="row">
                                                <div class="col-md-4 mb-2">
                                                    <label class="form-label-custom small mb-1">Subsistema</label>
                                                    <select name="id_subsistema"
                                                        class="form-control form-control-sm">
                                                        <option value="">-- Selecciona --</option>
                                                        @foreach ($subsistemas as $subsistema)
                                                            <option value="{{ $subsistema->id_subsistema }}">
                                                                {{ $subsistema->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label class="form-label-custom small mb-1">Tipo Escuela</label>
                                                    <select name="id_tipo_escuela"
                                                        class="form-control form-control-sm">
                                                        <option value="">-- Selecciona --</option>
                                                        @foreach ($tiposEscuela as $tipo)
                                                            <option value="{{ $tipo->id_tipo_escuela }}">
                                                                {{ $tipo->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label class="form-label-custom small mb-1">
                                                        Promedio <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="number" name="promedio_egreso" min="0"
                                                        step="0.01" class="form-control form-control-sm"
                                                        placeholder="0.00" required>
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <label class="form-label-custom small mb-1">Beca</label>
                                                    <select name="id_beca" class="form-control form-control-sm">
                                                        <option value="">-- Selecciona --</option>
                                                        @foreach ($becas as $beca)
                                                            <option value="{{ $beca->id_beca }}">
                                                                {{ $beca->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-5 mb-2">
                                                    <label class="form-label-custom small mb-1">Área
                                                        Especialización</label>
                                                    <select name="id_area_especializacion"
                                                        class="form-control form-control-sm">
                                                        <option value="">-- Selecciona --</option>
                                                        @foreach ($areaEspecializacion as $area)
                                                            <option value="{{ $area->id_area_especializacion }}">
                                                                {{ $area->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label class="form-label-custom small mb-1">Estado</label>
                                                    <select name="escuela[id_estado]"
                                                        class="form-control form-control-sm">
                                                        <option value="">-- Selecciona --</option>
                                                        @foreach ($estados as $estado)
                                                            <option value="{{ $estado->id_estado }}">
                                                                {{ $estado->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <label class="form-label-custom small mb-1">Localidad</label>
                                                    <input type="text" name="escuela[localidad]"
                                                        class="form-control form-control-sm"
                                                        placeholder="Nombre de la localidad">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- =================== DATOS DEL TUTOR =================== --}}
                                <div class="card mb-2 border-0 shadow-sm">
                                    <div class="card-header p-0" id="headingTutor">
                                        <button
                                            class="btn text-danger font-weight-bold btn-block text-left py-2 px-3 text-decoration-none collapsed"
                                            type="button" data-toggle="collapse" data-target="#collapseTutor"
                                            aria-expanded="false" aria-controls="collapseTutor">
                                            <i class="fas fa-user-tie mr-2"></i>Datos del Tutor
                                            <i class="fas fa-chevron-down float-right mt-1"></i>
                                        </button>
                                    </div>
                                    <div id="collapseTutor" class="collapse" aria-labelledby="headingTutor"
                                        data-parent="#alumnoAccordion">
                                        <div class="card-body p-3">
                                            <div class="row">
                                                <div class="col-md-8 mb-2">
                                                    <label class="form-label-custom small mb-1">Nombre
                                                        Completo</label>
                                                    <input type="text" name="tutor[nombres]"
                                                        class="form-control form-control-sm"
                                                        placeholder="Nombre completo del tutor">
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <label class="form-label-custom small mb-1">Parentesco</label>
                                                    <select name="id_parentesco"
                                                        class="form-control form-control-sm">
                                                        <option value="">-- Selecciona --</option>
                                                        @foreach ($parentescos as $parentesco)
                                                            <option value="{{ $parentesco->id_parentesco }}">
                                                                {{ $parentesco->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 mb-2">
                                                    <label class="form-label-custom small mb-1">
                                                        Calle <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" name="domicilio_tutor[calle]"
                                                        class="form-control form-control-sm"
                                                        placeholder="Nombre de la calle" required>
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <label class="form-label-custom small mb-1">N° Ext.</label>
                                                    <input type="number" name="domicilio_tutor[numero_exterior]"
                                                        min="0" class="form-control form-control-sm"
                                                        placeholder="0">
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <label class="form-label-custom small mb-1">N° Int.</label>
                                                    <input type="number" name="domicilio_tutor[numero_interior]"
                                                        min="0" class="form-control form-control-sm"
                                                        placeholder="0">
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <label class="form-label-custom small mb-1">
                                                        Colonia <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" name="domicilio_tutor[colonia]"
                                                        class="form-control form-control-sm"
                                                        placeholder="Nombre de la colonia" required>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 mb-2">
                                                    <label class="form-label-custom small mb-1">
                                                        Municipio <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" name="domicilio_tutor[municipio]"
                                                        class="form-control form-control-sm"
                                                        placeholder="Nombre del municipio" required>
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label class="form-label-custom small mb-1">Distrito</label>
                                                    <select name="domicilio_tutor[id_distrito]"
                                                        class="form-control form-control-sm">
                                                        <option value="">-- Selecciona --</option>
                                                        @foreach ($distritos as $distrito)
                                                            <option value="{{ $distrito->id_distrito }}">
                                                                {{ $distrito->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label class="form-label-custom small mb-1">Estado</label>
                                                    <select name="domicilio_tutor[id_estado]"
                                                        class="form-control form-control-sm">
                                                        <option value="">-- Selecciona --</option>
                                                        @foreach ($estados as $estado)
                                                            <option value="{{ $estado->id_estado }}">
                                                                {{ $estado->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <label class="form-label-custom small mb-1">Teléfono</label>
                                                    <input type="text" name="tutor[telefono]" maxlength="10"
                                                        class="form-control form-control-sm"
                                                        placeholder="10 dígitos">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- =================== ESTATUS ACADÉMICO =================== --}}
                                <div class="card mb-2 border-0 shadow-sm">
                                    <div class="card-header p-0" id="headingEstatus">
                                        <button
                                            class="btn text-danger font-weight-bold btn-block text-left py-2 px-3 text-decoration-none collapsed"
                                            type="button" data-toggle="collapse" data-target="#collapseEstatus"
                                            aria-expanded="false" aria-controls="collapseEstatus">
                                            <i class="fas fa-graduation-cap mr-2"></i>Estatus Académico
                                            <i class="fas fa-chevron-down float-right mt-1"></i>
                                        </button>
                                    </div>
                                    <div id="collapseEstatus" class="collapse" aria-labelledby="headingEstatus"
                                        data-parent="#alumnoAccordion">
                                        <div class="card-body p-3">
                                            <div class="row">
                                                <div class="col-md-4 mb-2">
                                                    <label class="form-label-custom small mb-1">
                                                        Estatus <span class="text-danger">*</span>
                                                    </label>
                                                    <select name="id_historial_status" id="id_historial_status"
                                                        class="form-control form-control-sm" required>
                                                        <option value="">-- Selecciona --</option>
                                                        @foreach ($estatus as $status)
                                                            <option value="{{ $status->id_historial_status }}">
                                                                {{ $status->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            {{-- =================== DATOS ACADÉMICOS (CONDICIONAL) =================== --}}
                                            <div id="seccionAcademica" style="display:none;">
                                                <div class="row mt-3">
                                                    <div class="col-md-3 mb-2">
                                                        <label class="form-label-custom small mb-1">Generación</label>
                                                        <select name="id_generacion"
                                                            class="form-control form-control-sm">
                                                            <option value="">-- Selecciona --</option>
                                                            @foreach ($generaciones as $generacion)
                                                                <option value="{{ $generacion->id_generacion }}">
                                                                    {{ $generacion->nombre }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-custom small mb-1">Matrícula</label>
                                                        <input type="text" name="matricula"
                                                            class="form-control form-control-sm"
                                                            placeholder="Número de matrícula">
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-custom small mb-1">Carrera</label>
                                                        <select name="id_carrera"
                                                            class="form-control form-control-sm">
                                                            <option value="">-- Selecciona --</option>
                                                            @foreach ($carreras as $carrera)
                                                                <option value="{{ $carrera->id_carrera }}">
                                                                    {{ $carrera->nombre }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-custom small mb-1">Plan de
                                                            Estudios</label>
                                                        <select name="id_plan_estudio"
                                                            class="form-control form-control-sm">
                                                            <option value="">-- Selecciona --</option>
                                                            @foreach ($planes as $plan)
                                                                <option value="{{ $plan->id_plan_estudio }}">
                                                                    {{ $plan->nombre }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-custom small mb-1">
                                                            Servicio Social <span class="text-danger">*</span>
                                                        </label>
                                                        <select name="servicios_social"
                                                            class="form-control form-control-sm" required>
                                                            <option value="">-- Selecciona --</option>
                                                            <option value="1"
                                                                {{ old('servicios_social') == '1' ? 'selected' : '' }}>
                                                                Sí</option>
                                                            <option value="0"
                                                                {{ old('servicios_social', '0') == '0' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Nota de campos obligatorios --}}
                            <div class="text-center mt-3 mb-2">
                                <small class="text-muted">
                                    <span class="text-danger">*</span> Campos obligatorios
                                </small>
                            </div>

                            {{-- Footer con botones --}}
                            <div class="text-right mt-3">
                                <button type="button" class="btn btn-outline-secondary btn-sm px-3"
                                    data-dismiss="modal">
                                    <i class="fas fa-times mr-1"></i>Cancelar
                                </button>
                                <button type="submit" class="btn btn-success btn-sm px-3">
                                    <i class="fas fa-save mr-1"></i>Guardar Alumno
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusSelect = document.getElementById('id_historial_status');
            const seccionAcademica = document.getElementById('seccionAcademica');

            statusSelect.addEventListener('change', function() {
                const selectedText = statusSelect.options[statusSelect.selectedIndex].text.toLowerCase();

                // Mostrar la sección académica solo si el estatus es "inscrito regular" o "irregular"
                if (selectedText.includes('inscrito') || selectedText.includes('regular')) {
                    seccionAcademica.style.display = 'flex';
                } else {
                    seccionAcademica.style.display = 'none';
                }
            });
        });
    </script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        @if ($errors->any() && old('is_create_alumno'))
            $('#nuevoAlumnoModal').modal('show');
        @endif
        @if ($errors->any() && old('alumno_id'))
            $('#editarModal{{ old("alumno_id") }}').modal('show');
        @endif
    });
</script>




    <!-- Scripts -->
    <script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('libs/sbadmin/js/sb-admin-2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Espera un poco para asegurar que todos los modales existan
            setTimeout(function() {
                $('.modal').each(function() {
                    // Inicializa el modal con las opciones deseadas
                    $(this).modal({
                        backdrop: 'static',
                        keyboard: false,
                        show: false // no mostrar al cargar
                    });
                });
            }, 500);
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Para cada select de estatus académico
            document.querySelectorAll('[id^="id_historial_status_editar"]').forEach(function(select) {
                // Mostrar/ocultar al cargar la página
                toggleSeccionAcademica(select);

                // Escuchar cambios
                select.addEventListener('change', function() {
                    toggleSeccionAcademica(this);
                });
            });

            function toggleSeccionAcademica(selectElement) {
                const alumnoId = selectElement.id.replace('id_historial_status_editar', '');
                const seccion = document.getElementById('seccionAcademicaEditar' + alumnoId);
                const selectedValue = parseInt(selectElement.value);

                if ([1, 2, 3, 4, 5, 6, 8, 9].includes(selectedValue)) {
                    seccion.style.display = 'block';
                } else {
                    seccion.style.display = 'none';
                }
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Función para calcular la edad a partir de la fecha de nacimiento
            function calcularEdad(fechaNacimiento) {
                const hoy = new Date();
                const nacimiento = new Date(fechaNacimiento);
                let edad = hoy.getFullYear() - nacimiento.getFullYear();
                const mes = hoy.getMonth() - nacimiento.getMonth();
                if (mes < 0 || (mes === 0 && hoy.getDate() < nacimiento.getDate())) {
                    edad--;
                }
                return edad >= 0 ? edad : '';
            }

            // === Para el modal de CREAR ===
            const fechaNacCreate = document.getElementById('fecha_nacimiento_create');
            const edadCreate = document.getElementById('edad_create');
            if (fechaNacCreate && edadCreate) {
                fechaNacCreate.addEventListener('change', function() {
                    edadCreate.value = calcularEdad(this.value);
                });
            }

            
        });
    </script>
</body>

</html>
