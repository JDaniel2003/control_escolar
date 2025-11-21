<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Docentes</title>
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
        <div class="d-flex justify-content-between align-items-center px-4">

            <h4 class="mb-0" style="text-align: center;">SISTEMA DE CONTROL ESCOLAR</h4>

        </div>
    </div>
    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">¿Seguro de cerrar sesión?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Seleccione "Si" si desea finalizar su sesión.</div>
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
                <li class="nav-item"><a class="nav-link text-white px-3"
                        href="{{ route('historial.index') }}">Historial</a></li>
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
                        style="font-size: 2.5rem; font-family: 'Arial Black', Verdana, sans-serif; font-weight: bold;">
                        Gestión de Docentes
                    </h1>
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <!-- Botón Nuevo Docente -->
                            <div class="mb-3 text-right">
                                <button type="button" class="btn btn-success" data-toggle="modal"
                                    data-target="#nuevoDocenteModal">
                                    <i class="fas fa-user-plus"></i> Nuevo Docente
                                </button>
                            </div>

                            <!-- Alertas -->
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            <!-- Tabla de Docentes -->
                            <div class="card-body1">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover text-center">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Nombre Completo</th>
                                                <th>Cédula Profesional</th>
                                                <th>Especialidad</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($docentes as $docente)
                                                <tr>
                                                    <td>
                                                        {{ $docente->datosDocentes->nombre ?? 'N/A' }}
                                                        {{ $docente->datosDocentes->apellido_paterno ?? '' }}
                                                        {{ $docente->datosDocentes->apellido_materno ?? '' }}
                                                    </td>
                                                    <td>{{ $docente->datosDocentes->cedula_profesional ?? 'N/A' }}</td>
                                                    <td>{{ $docente->especialidad ?? 'N/A' }}</td>
                                                    <td>
                                                        <!-- Botón Ver -->
                                                        <button class="btn btn-info btn-sm" data-toggle="modal"
                                                            data-target="#verDocenteModal{{ $docente->id_docente }}">
                                                            <i class="fas fa-eye"></i> Ver
                                                        </button>
                                                        <!-- Botón Editar -->
                                                        <button class="btn btn-warning btn-sm" data-toggle="modal"
                                                            data-target="#editarDocenteModal{{ $docente->id_docente }}">
                                                            <i class="fas fa-edit"></i> Editar
                                                        </button>
                                                        <!-- Botón Eliminar -->
                                                        <form
                                                            action="{{ route('docentes.destroy', $docente->id_docente) }}"
                                                            method="POST" style="display:inline-block;"
                                                            onsubmit="return confirm('¿Seguro que deseas eliminar este docente?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                <i class="fas fa-trash-alt"></i> Eliminar
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>

                                                <!-- Modal Ver Docente -->
                                                <div class="modal fade"
                                                    id="verDocenteModal{{ $docente->id_docente }}" tabindex="-1"
                                                    role="dialog">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered"
                                                        role="document">
                                                        <div class="modal-content">
                                                            <div
                                                                class="modal-header modal-header-custom border-0 py-">
                                                                <div class="w-100 text-center">
                                                                    <h5 class="m-0 font-weight-bold">👨‍🏫 Detalles del
                                                                        Docente</h5>
                                                                    <p class="m-0 mt-2 mb-0"
                                                                        style="font-size: 0.9rem; opacity: 0.95;">
                                                                        Información personal y profesional</p>
                                                                </div>
                                                                <button type="button" class="close text-white"
                                                                    data-dismiss="modal" aria-label="Cerrar">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body p-0"
                                                                style="background-color: #f8fafc;">
                                                                <!-- Sección de Identificación -->
                                                                <div class="bg-white border-bottom py-3 px-4">
                                                                    <div class="row align-items-center">
                                                                        <div class="col-md-2 text-center">
                                                                            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center"
                                                                                style="width: 80px; height: 80px; border: 3px solid #1e40af;">
                                                                                <i class="fas fa-chalkboard-teacher"
                                                                                    style="font-size: 2rem; color: #1e40af;"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-10">
                                                                            <h4
                                                                                class="mb-2 font-weight-bold text-danger">
                                                                                {{ $docente->datosDocentes->nombre ?? 'N/A' }}
                                                                                {{ $docente->datosDocentes->apellido_paterno ?? '' }}
                                                                                {{ $docente->datosDocentes->apellido_materno ?? '' }}
                                                                            </h4>
                                                                            <div class="row">
                                                                                <div class="col-md-4">
                                                                                    <small
                                                                                        class="text-muted text-uppercase d-block">Cédula
                                                                                        Profesional:</small>
                                                                                    <strong>{{ $docente->datosDocentes->cedula_profesional ?? 'Sin cédula' }}</strong>
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <small
                                                                                        class="text-muted text-uppercase d-block">Especialidad</small>
                                                                                    <strong>{{ $docente->especialidad ?? 'No asignada' }}</strong>
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <small
                                                                                        class="text-muted text-uppercase d-block">Título</small>
                                                                                    <strong>{{ $docente->datosDocentes->abreviatura?->titulo ?? 'Sin título' }}</strong>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Contenido Principal -->
                                                                <div class="p-4">
                                                                    <!-- Datos Personales -->
                                                                    <div class="mb-4">
                                                                        <div class="bg-white border rounded">
                                                                            <div class="px-4 py-3 border-bottom"
                                                                                style="background-color: #f1f5f9;">
                                                                                <h6
                                                                                    class="text-danger font-weight-bold mb-3">
                                                                                    <i
                                                                                        class="fas fa-user mr-2"></i>Datos
                                                                                    Personales
                                                                                </h6>
                                                                            </div>
                                                                            <div class="p-4">
                                                                                <div class="row">
                                                                                    <div class="col-md-3 mb-3">
                                                                                        <label
                                                                                            class="text-muted text-uppercase d-block">Fecha
                                                                                            de Nacimiento</label>
                                                                                        <div class="font-weight-bold">
                                                                                            {{ $docente->datosDocentes->fecha_nacimiento ? \Carbon\Carbon::parse($docente->datosDocentes->fecha_nacimiento)->format('d/m/Y') : 'N/A' }}
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-2 mb-3">
                                                                                        <label
                                                                                            class="text-muted text-uppercase d-block">Edad</label>
                                                                                        <div class="font-weight-bold">
                                                                                            {{ $docente->datosDocentes->edad ?? 'N/A' }}
                                                                                            años
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3 mb-3">
                                                                                        <label
                                                                                            class="text-muted text-uppercase d-block">Género</label>
                                                                                        <div class="font-weight-bold">
                                                                                            {{ $docente->datosDocentes->genero?->nombre ?? 'N/A' }}
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-4 mb-3">
                                                                                        <label
                                                                                            class="text-muted text-uppercase d-block">RFC</label>
                                                                                        <div class="font-weight-bold">
                                                                                            {{ $docente->datosDocentes->rfc ?? 'N/A' }}
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-4 mb-3">
                                                                                        <label
                                                                                            class="text-muted text-uppercase d-block">CURP</label>
                                                                                        <div class="font-weight-bold">
                                                                                            {{ $docente->datosDocentes->curp ?? 'N/A' }}
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-4 mb-3">
                                                                                        <label
                                                                                            class="text-muted text-uppercase d-block">Teléfono</label>
                                                                                        <div class="font-weight-bold">
                                                                                            {{ $docente->datosDocentes->telefono ?? 'N/A' }}
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-4 mb-3">
                                                                                        <label
                                                                                            class="text-muted text-uppercase d-block">Correo</label>
                                                                                        <div class="font-weight-bold">
                                                                                            {{ $docente->datosDocentes->correo ?? 'N/A' }}
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-4 mb-3">
                                                                                        <label
                                                                                            class="text-muted text-uppercase d-block">N°
                                                                                            Seguridad Social</label>
                                                                                        <div class="font-weight-bold">
                                                                                            {{ $docente->datosDocentes->numero_seguridad_social ?? 'No registrado' }}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Domicilio -->
                                                                    <div class="mb-4">
                                                                        <div class="bg-white border rounded">
                                                                            <div class="px-4 py-3 border-bottom"
                                                                                style="background-color: #f1f5f9;">
                                                                                <h6
                                                                                    class="text-danger font-weight-bold mb-3">
                                                                                    <i
                                                                                        class="fas fa-home mr-2"></i>Domicilio
                                                                                </h6>
                                                                            </div>
                                                                            <div class="p-4">
                                                                                <div class="font-weight-bold">
                                                                                    <strong>{{ $docente->datosDocentes->domicilioDocente?->calle ?? 'No registrada' }}</strong>
                                                                                    #{{ $docente->datosDocentes->domicilioDocente?->numero_exterior ?? 'S/N' }}
                                                                                    @if ($docente->datosDocentes->domicilioDocente?->numero_interior)
                                                                                        Int.
                                                                                        {{ $docente->datosDocentes->domicilioDocente->numero_interior }}
                                                                                    @endif
                                                                                </div>
                                                                                <div class="font-weight-bold">
                                                                                    {{ $docente->datosDocentes->domicilioDocente?->colonia ?? '' }}<br>
                                                                                    {{ $docente->datosDocentes->domicilioDocente?->municipio ?? '' }},
                                                                                    {{ $docente->datosDocentes->domicilioDocente?->estado?->nombre ?? '' }}<br>
                                                                                    C.P.
                                                                                    {{ $docente->datosDocentes->domicilioDocente?->codigo_postal ?? '' }}
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Usuario del Sistema -->
                                                                    <div class="bg-white border rounded">
                                                                        <div class="px-4 py-3 border-bottom"
                                                                            style="background-color: #f1f5f9;">
                                                                            <h6
                                                                                class="text-danger font-weight-bold mb-3">
                                                                                <i
                                                                                    class="fas fa-user-lock mr-2"></i>Usuario
                                                                                del Sistema
                                                                            </h6>
                                                                        </div>
                                                                        <div class="p-4">
                                                                            @if ($docente->usuario)
                                                                                <div class="row">
                                                                                    <div class="col-md-6 mb-2">
                                                                                        <label
                                                                                            class="text-muted text-uppercase d-block">Usuario</label>
                                                                                        <div class="font-weight-bold">
                                                                                            {{ $docente->usuario->username }}
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6 mb-2">
                                                                                        <label
                                                                                            class="text-muted text-uppercase d-block">Rol</label>
                                                                                        <div class="font-weight-bold">
                                                                                            {{ $docente->usuario->rol?->nombre ?? 'Sin rol' }}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @else
                                                                                <p class="text-muted">Este docente no
                                                                                    tiene usuario en el sistema.</p>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer bg-white border-top">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">
                                                                    <i class="fas fa-times mr-2"></i>Cerrar
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Modal Editar Docente -->
                                                <div class="modal fade"
                                                    id="editarDocenteModal{{ $docente->id_docente }}" tabindex="-1"
                                                    role="dialog">
                                                    <div class="modal-dialog modal-xl modal-dialog-scrollable"
                                                        role="document">
                                                        <div class="modal-content border-0 shadow-lg">
                                                            <div
                                                                class="modal-header modal-header-custom border-0 py-3">
                                                                <div class="w-100 text-center">
                                                                    <h5 class="m-0 font-weight-bold">✏️ Editar Docente
                                                                    </h5>
                                                                    <p class="m-0 mt-2 mb-0"
                                                                        style="font-size: 0.9rem; opacity: 0.95;">
                                                                        Modifique la información del docente
                                                                    </p>
                                                                </div>
                                                                <button type="button" class="close text-white"
                                                                    data-dismiss="modal" aria-label="Cerrar">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body p-3"
                                                                style="background-color: #f8f9fa;">
                                                                <div
                                                                    class="form-container p-4 bg-white rounded shadow-sm border">
                                                                    <form
                                                                        action="{{ route('docentes.update', $docente->id_docente) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <div class="accordion"
                                                                            id="editarAccordion{{ $docente->id_docente }}">
                                                                            <!-- Datos Personales -->
                                                                            <div class="card mb-2 border-0 shadow-sm">
                                                                                <div class="card-header p-0"
                                                                                    id="headingEditarDatos{{ $docente->id_docente }}">
                                                                                    <button
                                                                                        class="btn text-danger font-weight-bold btn-block text-left py-2 px-3 text-decoration-none"
                                                                                        type="button"
                                                                                        data-toggle="collapse"
                                                                                        data-target="#collapseEditarDatos{{ $docente->id_docente }}"
                                                                                        aria-expanded="true"
                                                                                        aria-controls="collapseEditarDatos{{ $docente->id_docente }}">
                                                                                        <i
                                                                                            class="fas fa-user mr-2"></i>Datos
                                                                                        Personales
                                                                                        <i
                                                                                            class="fas fa-chevron-down float-right mt-1"></i>
                                                                                    </button>
                                                                                </div>
                                                                                <div id="collapseEditarDatos{{ $docente->id_docente }}"
                                                                                    class="collapse show"
                                                                                    aria-labelledby="headingEditarDatos{{ $docente->id_docente }}"
                                                                                    data-parent="#editarAccordion{{ $docente->id_docente }}">
                                                                                    <div class="card-body p-3">
                                                                                        <div class="row">
                                                                                            <div class="col-md-4 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Nombre
                                                                                                    <span
                                                                                                        class="text-danger">*</span></label>
                                                                                                <input type="text"
                                                                                                    name="datos_docentes[nombre]"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('datos_docentes.nombre', $docente->datosDocentes->nombre) }}"
                                                                                                    required>
                                                                                            </div>
                                                                                            <div class="col-md-4 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Apellido
                                                                                                    Paterno <span
                                                                                                        class="text-danger">*</span></label>
                                                                                                <input type="text"
                                                                                                    name="datos_docentes[apellido_paterno]"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('datos_docentes.apellido_paterno', $docente->datosDocentes->apellido_paterno) }}"
                                                                                                    required>
                                                                                            </div>
                                                                                            <div class="col-md-4 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Apellido
                                                                                                    Materno</label>
                                                                                                <input type="text"
                                                                                                    name="datos_docentes[apellido_materno]"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('datos_docentes.apellido_materno', $docente->datosDocentes->apellido_materno) }}">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-3 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Cédula
                                                                                                    Profesional</label>
                                                                                                <input type="text"
                                                                                                    name="datos_docentes[cedula_profesional]"
                                                                                                    maxlength="7"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('datos_docentes.cedula_profesional', $docente->datosDocentes->cedula_profesional) }}">
                                                                                            </div>
                                                                                            <div class="col-md-3 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">RFC</label>
                                                                                                <input type="text"
                                                                                                    name="datos_docentes[rfc]"
                                                                                                    maxlength="13"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('datos_docentes.rfc', $docente->datosDocentes->rfc) }}">
                                                                                            </div>
                                                                                            <div class="col-md-3 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">CURP</label>
                                                                                                <input type="text"
                                                                                                    name="datos_docentes[curp]"
                                                                                                    maxlength="18"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('datos_docentes.curp', $docente->datosDocentes->curp) }}">
                                                                                            </div>
                                                                                            <div class="col-md-3 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Especialidad
                                                                                                    <span
                                                                                                        class="text-danger">*</span></label>
                                                                                                <input type="text"
                                                                                                    name="especialidad"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('especialidad', $docente->especialidad) }}"
                                                                                                    required>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-3 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Fecha
                                                                                                    de
                                                                                                    Nacimiento</label>
                                                                                                <input type="date"
                                                                                                    name="datos_docentes[fecha_nacimiento]"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('datos_docentes.fecha_nacimiento', $docente->datosDocentes->fecha_nacimiento) }}">
                                                                                            </div>
                                                                                            <div class="col-md-2 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Edad</label>
                                                                                                <input type="number"
                                                                                                    name="datos_docentes[edad]"
                                                                                                    min="18"
                                                                                                    id="edad_create"max="100"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('datos_docentes.edad', $docente->datosDocentes->edad) }}">
                                                                                            </div>
                                                                                            <div class="col-md-3 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Género
                                                                                                    <span
                                                                                                        class="text-danger">*</span></label>
                                                                                                <select
                                                                                                    name="datos_docentes[id_genero]"
                                                                                                    class="form-control form-control-sm"
                                                                                                    required>
                                                                                                    <option
                                                                                                        value="">
                                                                                                        -- Selecciona --
                                                                                                    </option>
                                                                                                    @foreach ($generos as $genero)
                                                                                                        <option
                                                                                                            value="{{ $genero->id_genero }}"
                                                                                                            {{ old('datos_docentes.id_genero', $docente->datosDocentes->id_genero) == $genero->id_genero ? 'selected' : '' }}>
                                                                                                            {{ $genero->nombre }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-md-4 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Título/Abreviatura</label>
                                                                                                <select
                                                                                                    name="datos_docentes[id_abreviatura]"
                                                                                                    class="form-control form-control-sm">
                                                                                                    <option
                                                                                                        value="">
                                                                                                        -- Sin título --
                                                                                                    </option>
                                                                                                    @foreach ($abreviaturas as $abreviatura)
                                                                                                        <option
                                                                                                            value="{{ $abreviatura->id_abreviatura }}"
                                                                                                            {{ old('datos_docentes.id_abreviatura', $docente->datosDocentes->id_abreviatura) == $abreviatura->id_abreviatura ? 'selected' : '' }}>
                                                                                                            {{ $abreviatura->abreviatura }}
                                                                                                            -
                                                                                                            {{ $abreviatura->nombre }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-4 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">N°
                                                                                                    Seguridad
                                                                                                    Social</label>
                                                                                                <input type="text"
                                                                                                    name="datos_docentes[numero_seguridad_social]"
                                                                                                    maxlength="11"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('datos_docentes.numero_seguridad_social', $docente->datosDocentes->numero_seguridad_social) }}">
                                                                                            </div>
                                                                                            <div class="col-md-5 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Correo
                                                                                                    Electrónico <span
                                                                                                        class="text-danger">*</span></label>
                                                                                                <input type="email"
                                                                                                    name="datos_docentes[correo]"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('datos_docentes.correo', $docente->datosDocentes->correo) }}"
                                                                                                    required>
                                                                                            </div>
                                                                                            <div class="col-md-3 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Teléfono
                                                                                                    <span
                                                                                                        class="text-danger">*</span></label>
                                                                                                <input type="text"
                                                                                                    name="datos_docentes[telefono]"
                                                                                                    maxlength="10"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('datos_docentes.telefono', $docente->datosDocentes->telefono) }}"
                                                                                                    required>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Domicilio Docente -->
                                                                            <div class="card mb-2 border-0 shadow-sm">
                                                                                <div class="card-header p-0"
                                                                                    id="headingEditarDomicilio{{ $docente->id_docente }}">
                                                                                    <button
                                                                                        class="btn text-danger font-weight-bold btn-block text-left py-2 px-3 text-decoration-none collapsed"
                                                                                        type="button"
                                                                                        data-toggle="collapse"
                                                                                        data-target="#collapseEditarDomicilio{{ $docente->id_docente }}"
                                                                                        aria-expanded="false"
                                                                                        aria-controls="collapseEditarDomicilio{{ $docente->id_docente }}">
                                                                                        <i
                                                                                            class="fas fa-home mr-2"></i>Domicilio
                                                                                        del Docente
                                                                                        <i
                                                                                            class="fas fa-chevron-down float-right mt-1"></i>
                                                                                    </button>
                                                                                </div>
                                                                                <div id="collapseEditarDomicilio{{ $docente->id_docente }}"
                                                                                    class="collapse"
                                                                                    aria-labelledby="headingEditarDomicilio{{ $docente->id_docente }}"
                                                                                    data-parent="#editarAccordion{{ $docente->id_docente }}">
                                                                                    <div class="card-body p-3">
                                                                                        <div class="row">
                                                                                            <div class="col-md-4 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Calle
                                                                                                    <span
                                                                                                        class="text-danger">*</span></label>
                                                                                                <input type="text"
                                                                                                    name="domicilio_docente[calle]"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('domicilio_docente.calle', $docente->datosDocentes->domicilioDocente?->calle) }}"
                                                                                                    required>
                                                                                            </div>
                                                                                            <div class="col-md-2 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">N°
                                                                                                    Ext.</label>
                                                                                                <input type="text"
                                                                                                    name="domicilio_docente[numero_exterior]"
                                                                                                    maxlength="4"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('domicilio_docente.numero_exterior', $docente->datosDocentes->domicilioDocente?->numero_exterior) }}">
                                                                                            </div>
                                                                                            <div class="col-md-2 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">N°
                                                                                                    Int.</label>
                                                                                                <input type="text"
                                                                                                    name="domicilio_docente[numero_interior]"
                                                                                                    maxlength="4"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('domicilio_docente.numero_interior', $docente->datosDocentes->domicilioDocente?->numero_interior) }}">
                                                                                            </div>
                                                                                            <div class="col-md-4 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Colonia
                                                                                                    <span
                                                                                                        class="text-danger">*</span></label>
                                                                                                <input type="text"
                                                                                                    name="domicilio_docente[colonia]"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('domicilio_docente.colonia', $docente->datosDocentes->domicilioDocente?->colonia) }}"
                                                                                                    required>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-4 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Municipio
                                                                                                    <span
                                                                                                        class="text-danger">*</span></label>
                                                                                                <input type="text"
                                                                                                    name="domicilio_docente[municipio]"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('domicilio_docente.municipio', $docente->datosDocentes->domicilioDocente?->municipio) }}"
                                                                                                    required>
                                                                                            </div>
                                                                                            <div class="col-md-3 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Distrito</label>
                                                                                                <select
                                                                                                    name="domicilio_docente[id_distrito]"
                                                                                                    class="form-control form-control-sm">
                                                                                                    <option
                                                                                                        value="">
                                                                                                        -- Selecciona --
                                                                                                    </option>
                                                                                                    @foreach ($distritos as $distrito)
                                                                                                        <option
                                                                                                            value="{{ $distrito->id_distrito }}"
                                                                                                            {{ old('domicilio_docente.id_distrito', $docente->datosDocentes->domicilioDocente?->id_distrito) == $distrito->id_distrito ? 'selected' : '' }}>
                                                                                                            {{ $distrito->nombre }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-md-3 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Estado
                                                                                                    <span
                                                                                                        class="text-danger">*</span></label>
                                                                                                <select
                                                                                                    name="domicilio_docente[id_estado]"
                                                                                                    class="form-control form-control-sm"
                                                                                                    required>
                                                                                                    <option
                                                                                                        value="">
                                                                                                        -- Selecciona --
                                                                                                    </option>
                                                                                                    @foreach ($estados as $estado)
                                                                                                        <option
                                                                                                            value="{{ $estado->id_estado }}"
                                                                                                            {{ old('domicilio_docente.id_estado', $docente->datosDocentes->domicilioDocente?->id_estado) == $estado->id_estado ? 'selected' : '' }}>
                                                                                                            {{ $estado->nombre }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-md-2 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">C.P.</label>
                                                                                                <input type="text"
                                                                                                    name="domicilio_docente[codigo_postal]"
                                                                                                    maxlength="5"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('domicilio_docente.codigo_postal', $docente->datosDocentes->domicilioDocente?->codigo_postal) }}">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Información de Usuario -->
                                                                            <div class="card mb-2 border-0 shadow-sm">
                                                                                <div class="card-header p-0"
                                                                                    id="headingEditarUsuario{{ $docente->id_docente }}">
                                                                                    <button
                                                                                        class="btn text-danger font-weight-bold btn-block text-left py-2 px-3 text-decoration-none collapsed"
                                                                                        type="button"
                                                                                        data-toggle="collapse"
                                                                                        data-target="#collapseEditarUsuario{{ $docente->id_docente }}"
                                                                                        aria-expanded="false"
                                                                                        aria-controls="collapseEditarUsuario{{ $docente->id_docente }}">
                                                                                        <i
                                                                                            class="fas fa-user-lock mr-2"></i>Información
                                                                                        de Usuario (Opcional)
                                                                                        <i
                                                                                            class="fas fa-chevron-down float-right mt-1"></i>
                                                                                    </button>
                                                                                </div>
                                                                                <div id="collapseEditarUsuario{{ $docente->id_docente }}"
                                                                                    class="collapse"
                                                                                    aria-labelledby="headingEditarUsuario{{ $docente->id_docente }}"
                                                                                    data-parent="#editarAccordion{{ $docente->id_docente }}">
                                                                                    <div class="card-body p-3">
                                                                                        <div class="row">
                                                                                            <div class="col-md-4 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Usuario</label>
                                                                                                <input type="text"
                                                                                                    name="usuario[username]"
                                                                                                    class="form-control form-control-sm"
                                                                                                    value="{{ old('usuario.username', $docente->usuario?->username) }}"
                                                                                                    placeholder="Dejar vacío para no modificar">
                                                                                            </div>
                                                                                            <div class="col-md-4 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Nueva
                                                                                                    Contraseña</label>
                                                                                                <input type="password"
                                                                                                    name="usuario[password]"
                                                                                                    class="form-control form-control-sm"
                                                                                                    placeholder="Dejar vacío para no cambiar">
                                                                                            </div>
                                                                                            <div class="col-md-4 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Confirmar
                                                                                                    Contraseña</label>
                                                                                                <input type="password"
                                                                                                    name="usuario[password_confirmation]"
                                                                                                    class="form-control form-control-sm">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-4 mb-2">
                                                                                                <label
                                                                                                    class="form-label-custom small mb-1">Rol</label>
                                                                                                <select
                                                                                                    name="usuario[id_rol]"
                                                                                                    class="form-control form-control-sm">
                                                                                                    <option
                                                                                                        value="">
                                                                                                        -- Mantener
                                                                                                        actual --
                                                                                                    </option>
                                                                                                    @foreach ($roles as $rol)
                                                                                                        <option
                                                                                                            value="{{ $rol->id_rol }}"
                                                                                                            {{ old('usuario.id_rol', $docente->usuario?->id_rol) == $rol->id_rol ? 'selected' : '' }}>
                                                                                                            {{ $rol->nombre }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="text-center mt-3 mb-2">
                                                                            <small class="text-muted"><span
                                                                                    class="text-danger">*</span> Campos
                                                                                obligatorios</small>
                                                                        </div>
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
                                                    <td colspan="4" class="text-muted text-center">No hay docentes
                                                        registrados</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Sistema Control Escolar 2025</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Modal Nuevo Docente -->
    <div class="modal fade" id="nuevoDocenteModal" tabindex="-1" role="dialog"
        aria-labelledby="nuevoDocenteLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header modal-header-custom border-0 py-3 bg-danger text-white">
                    <div class="w-100 text-center">
                        <h5 class="m-0 font-weight-bold" id="nuevoDocenteLabel">
                            👨‍🏫 Registrar Nuevo Docente
                        </h5>
                        <p class="m-0 mt-2 mb-0" style="font-size: 0.9rem; opacity: 0.95;">
                            Complete todos los datos del docente
                        </p>
                    </div>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-3" style="background-color: #f8f9fa;">
                    <div class="form-container p-4 bg-white rounded shadow-sm border">
                        <form action="{{ route('docentes.store') }}" method="POST">
                            @csrf
                            <div class="accordion" id="docenteAccordion">
                                <!-- Datos Personales -->
                                <div class="card mb-2 border-0 shadow-sm">
                                    <div class="card-header p-0" id="headingDatosPersonales">
                                        <button
                                            class="btn text-danger font-weight-bold btn-block text-left py-2 px-3 text-decoration-none"
                                            type="button" data-toggle="collapse"
                                            data-target="#collapseDatosPersonales" aria-expanded="true">
                                            <i class="fas fa-user mr-2"></i>Datos Personales
                                            <i class="fas fa-chevron-down float-right mt-1"></i>
                                        </button>
                                    </div>
                                    <div id="collapseDatosPersonales" class="collapse show"
                                        data-parent="#docenteAccordion">
                                        <div class="card-body p-3">
                                            <div class="row">
                                                <div class="col-md-4 mb-2">
                                                    <label class="form-label-custom small mb-1">Nombre <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="datos_docentes[nombre]"
                                                        class="form-control form-control-sm" placeholder="Nombre"
                                                        required>
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <label class="form-label-custom small mb-1">Apellido Paterno <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="datos_docentes[apellido_paterno]"
                                                        class="form-control form-control-sm"
                                                        placeholder="Apellido paterno" required>
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <label class="form-label-custom small mb-1">Apellido
                                                        Materno</label>
                                                    <input type="text" name="datos_docentes[apellido_materno]"
                                                        class="form-control form-control-sm"
                                                        placeholder="Apellido materno">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 mb-2">
                                                    <label class="form-label-custom small mb-1">Cédula
                                                        Profesional</label>
                                                    <input type="text" name="datos_docentes[cedula_profesional]"
                                                        maxlength="7" class="form-control form-control-sm"
                                                        placeholder="7 caracteres">
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label class="form-label-custom small mb-1">RFC</label>
                                                    <input type="text" name="datos_docentes[rfc]" maxlength="13"
                                                        class="form-control form-control-sm"
                                                        placeholder="13 caracteres">
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label class="form-label-custom small mb-1">CURP</label>
                                                    <input type="text" name="datos_docentes[curp]" maxlength="18"
                                                        class="form-control form-control-sm"
                                                        placeholder="18 caracteres">
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label class="form-label-custom small mb-1">Especialidad <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="especialidad"
                                                        class="form-control form-control-sm"
                                                        placeholder="Especialidad" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 mb-2">
                                                    <label class="form-label-custom small mb-1">Fecha de
                                                        Nacimiento</label>
                                                    <input type="date" name="datos_docentes[fecha_nacimiento]"
                                                        id="fecha_nacimiento_create"
                                                        class="form-control form-control-sm" required>
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <label class="form-label-custom small mb-1">Edad</label>
                                                    <input type="number" name="datos_docentes[edad]"
                                                        id="edad_create" class="form-control form-control-sm"
                                                        min="18" max="100" readonly>
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label class="form-label-custom small mb-1">Género <span
                                                            class="text-danger">*</span></label>
                                                    <select name="datos_docentes[id_genero]"
                                                        class="form-control form-control-sm" required>
                                                        <option value="">-- Selecciona --</option>
                                                        @foreach ($generos as $genero)
                                                            <option value="{{ $genero->id_genero }}">
                                                                {{ $genero->nombre }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <label
                                                        class="form-label-custom small mb-1">Título/Abreviatura</label>
                                                    <select name="datos_docentes[id_abreviatura]"
                                                        class="form-control form-control-sm">
                                                        <option value="">-- Sin título --</option>
                                                        @foreach ($abreviaturas as $abreviatura)
                                                            <option value="{{ $abreviatura->id_abreviatura }}">
                                                                {{ $abreviatura->abreviatura }} -
                                                                {{ $abreviatura->nombre }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 mb-2">
                                                    <label class="form-label-custom small mb-1">N° Seguridad
                                                        Social</label>
                                                    <input type="text"
                                                        name="datos_docentes[numero_seguridad_social]" maxlength="11"
                                                        class="form-control form-control-sm" placeholder="11 dígitos">
                                                </div>
                                                <div class="col-md-5 mb-2">
                                                    <label class="form-label-custom small mb-1">Correo Electrónico
                                                        <span class="text-danger">*</span></label>
                                                    <input type="email" name="datos_docentes[correo]"
                                                        class="form-control form-control-sm"
                                                        placeholder="ejemplo@correo.com" required>
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label class="form-label-custom small mb-1">Teléfono <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="datos_docentes[telefono]"
                                                        maxlength="10" class="form-control form-control-sm"
                                                        placeholder="10 dígitos" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Domicilio Docente -->
                                <div class="card mb-2 border-0 shadow-sm">
                                    <div class="card-header p-0" id="headingDomicilio">
                                        <button
                                            class="btn text-danger font-weight-bold btn-block text-left py-2 px-3 text-decoration-none collapsed"
                                            type="button" data-toggle="collapse" data-target="#collapseDomicilio">
                                            <i class="fas fa-home mr-2"></i>Domicilio del Docente
                                            <i class="fas fa-chevron-down float-right mt-1"></i>
                                        </button>
                                    </div>
                                    <div id="collapseDomicilio" class="collapse" data-parent="#docenteAccordion">
                                        <div class="card-body p-3">
                                            <div class="row">
                                                <div class="col-md-4 mb-2">
                                                    <label class="form-label-custom small mb-1">Calle <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="domicilio_docente[calle]"
                                                        class="form-control form-control-sm"
                                                        placeholder="Nombre de la calle" required>
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <label class="form-label-custom small mb-1">N° Ext.</label>
                                                    <input type="text" name="domicilio_docente[numero_exterior]"
                                                        maxlength="4" class="form-control form-control-sm"
                                                        placeholder="Núm.">
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <label class="form-label-custom small mb-1">N° Int.</label>
                                                    <input type="text" name="domicilio_docente[numero_interior]"
                                                        maxlength="4" class="form-control form-control-sm"
                                                        placeholder="Int.">
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <label class="form-label-custom small mb-1">Colonia <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="domicilio_docente[colonia]"
                                                        class="form-control form-control-sm"
                                                        placeholder="Nombre de la colonia" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 mb-2">
                                                    <label class="form-label-custom small mb-1">Municipio <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="domicilio_docente[municipio]"
                                                        class="form-control form-control-sm"
                                                        placeholder="Nombre del municipio" required>
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label class="form-label-custom small mb-1">Distrito</label>
                                                    <select name="domicilio_docente[id_distrito]"
                                                        class="form-control form-control-sm">
                                                        <option value="">-- Selecciona --</option>
                                                        @foreach ($distritos as $distrito)
                                                            <option value="{{ $distrito->id_distrito }}">
                                                                {{ $distrito->nombre }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label class="form-label-custom small mb-1">Estado <span
                                                            class="text-danger">*</span></label>
                                                    <select name="domicilio_docente[id_estado]"
                                                        class="form-control form-control-sm" required>
                                                        <option value="">-- Selecciona --</option>
                                                        @foreach ($estados as $estado)
                                                            <option value="{{ $estado->id_estado }}">
                                                                {{ $estado->nombre }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <label class="form-label-custom small mb-1">C.P.</label>
                                                    <input type="text" name="domicilio_docente[codigo_postal]"
                                                        maxlength="5" class="form-control form-control-sm"
                                                        placeholder="00000">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Crear Usuario -->
                                <div class="card mb-2 border-0 shadow-sm">
                                    <div class="card-header p-0" id="headingUsuario">
                                        <button
                                            class="btn text-danger font-weight-bold btn-block text-left py-2 px-3 text-decoration-none collapsed"
                                            type="button" data-toggle="collapse" data-target="#collapseUsuario">
                                            <i class="fas fa-user-plus mr-2"></i>Crear Usuario (Opcional)
                                            <i class="fas fa-chevron-down float-right mt-1"></i>
                                        </button>
                                    </div>
                                    <div id="collapseUsuario" class="collapse" data-parent="#docenteAccordion">
                                        <div class="card-body p-3">
                                            <div class="row">
                                                <div class="col-md-4 mb-2">
                                                    <label class="form-label-custom small mb-1">Usuario</label>
                                                    <input type="text" name="usuario[username]"
                                                        class="form-control form-control-sm"
                                                        placeholder="Nombre de usuario">
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <label class="form-label-custom small mb-1">Contraseña</label>
                                                    <input type="password" name="usuario[password]"
                                                        class="form-control form-control-sm"
                                                        placeholder="Mínimo 8 caracteres">
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <label class="form-label-custom small mb-1">Confirmar
                                                        Contraseña</label>
                                                    <input type="password" name="usuario[password_confirmation]"
                                                        class="form-control form-control-sm">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 mb-2">
                                                    <label class="form-label-custom small mb-1">Rol</label>
                                                    <select name="usuario[id_rol]"
                                                        class="form-control form-control-sm">
                                                        <option value="">-- Selecciona --</option>
                                                        @foreach ($roles as $rol)
                                                            <option value="{{ $rol->id_rol }}">{{ $rol->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mt-3 mb-2">
                                <small class="text-muted"><span class="text-danger">*</span> Campos
                                    obligatorios</small>
                            </div>
                            <div class="text-right mt-3">
                                <button type="button" class="btn btn-outline-secondary btn-sm px-3"
                                    data-dismiss="modal">
                                    <i class="fas fa-times mr-1"></i>Cancelar
                                </button>
                                <button type="submit" class="btn btn-success btn-sm px-3">
                                    <i class="fas fa-save mr-1"></i>Guardar Docente
                                </button>
                            </div>
                        </form>
                    </div>
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

            // === Para los modales de EDITAR (cada uno tiene su propio id) ===
            @foreach ($docentes as $docente)
                const fechaNacEdit{{ $docente->id_docente }} = document.querySelector(
                    '#editarModal{{ $docente->id_docente }} [name="datos_docentes[fecha_nacimiento]"]');
                const edadEdit{{ $docente->id_docente }} = document.querySelector(
                    '#editarModal{{ $docente->id_docente }} [name="datos_docentes[edad]"]');
                if (fechaNacEdit{{ $docente->id_docente }} && edadEdit{{ $docente->id_docente }}) {
                    fechaNacEdit{{ $docente->id_docente }}.addEventListener('change', function() {
                        edadEdit{{ $docente->id_docente }}.value = calcularEdad(this.value);
                    });
                }
            @endforeach
        });
    </script>
</body>

</html>
