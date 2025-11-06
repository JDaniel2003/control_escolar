<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Catálogos</title>

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
                    <a class="nav-link text-white px-3 mr-1" href="#">Carreras</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white px-3 mr-1" href="#">Materias</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white px-3 mr-1" href="#">Planes de estudio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white px-3 mr-1" href="#">Alumnos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white px-3 mr-1" href="#">Asignaciones Docentes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white px-3" href="#">Historial</a>
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
                        Gestión de Catálogos</h1>

                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="row">


                                <div class="container mt-4">

                                    {{-- Mensaje de éxito --}}
                                    @if (session('success'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session('success') }}
                                            <button type="button" class="close" data-dismiss="alert"
                                                aria-label="Cerrar">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif

                                    {{-- Pestañas de navegación con Dropdowns --}}
                                    <ul class="nav nav-tabs" id="catalogTabs" role="tablist">
                                        {{-- ACADÉMICOS --}}
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"
                                                role="button">
                                                🎓 Académicos
                                            </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" id="periodos-tab" data-toggle="tab"
                                                    href="#periodos">Tipos de Períodos</a>
                                                <a class="dropdown-item" id="status-tab" data-toggle="tab"
                                                    href="#status">Status Académicos</a>
                                                <a class="dropdown-item" id="historialStatus-tab" data-toggle="tab"
                                                    href="#historialStatus">Historial de Status</a>
                                                <a class="dropdown-item" id="evaluaciones-tab" data-toggle="tab"
                                                    href="#evaluaciones">Tipos de Evaluaciones</a>
                                                <a class="dropdown-item" id="modalidades-tab" data-toggle="tab"
                                                    href="#modalidades">Tipos de Modalidades</a>
                                                <a class="dropdown-item" id="generaciones-tab" data-toggle="tab"
                                                    href="#generaciones">Generaciones</a>
                                            </div>
                                        </li>

                                        {{-- INSTITUCIONALES --}}
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"
                                                role="button">
                                                🏫 Institucionales
                                            </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" id="subsistemas-tab" data-toggle="tab"
                                                    href="#subsistemas">Subsistemas</a>
                                                <a class="dropdown-item" id="tiposEscuela-tab" data-toggle="tab"
                                                    href="#tiposEscuela">Tipos de Escuela</a>
                                                <a class="dropdown-item" id="areas-tab" data-toggle="tab"
                                                    href="#areas">Áreas de Especialización</a>
                                                <a class="dropdown-item" id="tiposCompetencia-tab" data-toggle="tab"
                                                    href="#tiposCompetencia">Tipos de Competencias</a>
                                                <a class="dropdown-item" id="turnos-tab" data-toggle="tab"
                                                    href="#turnos">Turnos</a>
                                                <a class="dropdown-item" id="becas-tab" data-toggle="tab"
                                                    href="#becas">Becas</a>
                                                <a class="dropdown-item" id="roles-tab" data-toggle="tab"
                                                    href="#roles">Roles</a>
                                            </div>
                                        </li>

                                        {{-- GEOGRÁFICOS --}}
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"
                                                role="button">
                                                📍 Geográficos
                                            </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" id="estados-tab" data-toggle="tab"
                                                    href="#estados">Estados</a>
                                                <a class="dropdown-item" id="distritos-tab" data-toggle="tab"
                                                    href="#distritos">Distritos</a>
                                            </div>
                                        </li>

                                        {{-- PERSONALES --}}
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"
                                                role="button">
                                                👤 Personales
                                            </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" id="generos-tab" data-toggle="tab"
                                                    href="#generos">Géneros</a>
                                                <a class="dropdown-item" id="estadoCivil-tab" data-toggle="tab"
                                                    href="#estadoCivil">Estado Civil</a>
                                                <a class="dropdown-item" id="tiposSangre-tab" data-toggle="tab"
                                                    href="#tiposSangre">Tipos de Sangre</a>
                                                <a class="dropdown-item" id="discapacidades-tab" data-toggle="tab"
                                                    href="#discapacidades">Discapacidades</a>
                                                <a class="dropdown-item" id="lenguas-tab" data-toggle="tab"
                                                    href="#lenguas">Lenguas Indígenas</a>
                                                <a class="dropdown-item" id="parentescos-tab" data-toggle="tab"
                                                    href="#parentescos">Parentescos</a>
                                            </div>
                                        </li>
                                    </ul>

                                    <div class="tab-content mt-3" id="catalogTabsContent">

                                        {{-- ================== EVALUACIONES ================== --}}
                                        <div class="tab-pane fade" id="evaluaciones" role="tabpanel"
                                            aria-labelledby="evaluaciones-tab">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4 class="mb-4">Tipos de Evaluaciones</h4>
                                                    <form id="filtrosFormEvaluaciones" method="GET"
                                                        action="{{ route('catalogos.index') }}"
                                                        class="d-flex align-items-center1 gap-3">
                                                        <input type="hidden" name="tabla" value="evaluaciones">
                                                        <div class="flex-grow-1" style="max-width: 400px;">
                                                            <input type="text" name="nombre_evaluaciones"
                                                                class="form-control form-control-sm"
                                                                placeholder="🔍 Buscar por nombre"
                                                                value="{{ request('nombre_evaluaciones') }}">
                                                        </div>
                                                        <button type="submit" class="btn btn-sm btn-primary px-3">
                                                            <i class="fas fa-search mr-1"></i> Buscar
                                                        </button>
                                                        <a href="{{ route('catalogos.index', ['tabla' => 'evaluaciones']) }}"
                                                            class="btn btn-sm btn-outline-secondary px-3">
                                                            <i class="fas fa-list mr-1"></i>Mostrar todo
                                                        </a>
                                                    </form>

                                                    @if (count($evaluaciones))
                                                        {{-- Formulario agregar nueva evaluación --}}
                                                        <div class="container mb-4 mt-4 d-flex justify-content-start">
                                                            <div
                                                                class="p-3 border rounded bg-light d-inline-block shadow-sm">
                                                                <form id="formAgregarEvaluacion" method="POST"
                                                                    action="{{ route('catalogos.store') }}"
                                                                    class="form-inline mb-3">
                                                                    @csrf
                                                                    <input type="hidden" name="tabla"
                                                                        value="evaluaciones">
                                                                    <div class="form-group mr-2 mb-2">
                                                                        <input type="text" name="nombre"
                                                                            class="form-control"
                                                                            placeholder="Nombre de la evaluación"
                                                                            required>
                                                                    </div>
                                                                    <button type="button"
                                                                        class="btn btn-success mb-2"
                                                                        data-toggle="modal"
                                                                        data-target="#agregarModalEvaluacion">
                                                                        Agregar
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>

                                                        <table class="table table-bordered table-hover">
                                                            <thead class="thead-dark text-center">
                                                                <tr>
                                                                    <th>Nombre</th>
                                                                    <th style="width: 150px;">Acciones</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($evaluaciones as $evaluacion)
                                                                    <tr>
                                                                        <form
                                                                            id="formEvaluacion{{ $evaluacion->id_evaluacion }}"
                                                                            method="POST"
                                                                            action="{{ route('catalogos.update', $evaluacion->id_evaluacion) }}">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <input type="hidden" name="tabla"
                                                                                value="evaluaciones">
                                                                            <td>
                                                                                <input type="text" name="nombre"
                                                                                    class="form-control"
                                                                                    value="{{ $evaluacion->nombre }}">
                                                                            </td>
                                                                            <td class="d-flex">
                                                                                <button type="button"
                                                                                    class="btn btn-warning btn-sm mr-1"
                                                                                    data-toggle="modal"
                                                                                    data-target="#guardarModalEvaluacion{{ $evaluacion->id_evaluacion }}">
                                                                                    Guardar
                                                                                </button>
                                                                                <button type="button"
                                                                                    class="btn btn-danger btn-sm"
                                                                                    data-toggle="modal"
                                                                                    data-target="#eliminarModalEvaluacion{{ $evaluacion->id_evaluacion }}">
                                                                                    Eliminar
                                                                                </button>
                                                                            </td>
                                                                        </form>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    @else
                                                        <p class="text-center text-muted mt-3">No hay registros para
                                                            mostrar.</p>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Modales para Evaluaciones --}}
                                            @foreach ($evaluaciones as $evaluacion)
                                                <div class="modal fade"
                                                    id="guardarModalEvaluacion{{ $evaluacion->id_evaluacion }}"
                                                    tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Confirmar Cambios</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Estás seguro de guardar los cambios en
                                                                <strong>{{ $evaluacion->nombre }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <button type="submit"
                                                                    form="formEvaluacion{{ $evaluacion->id_evaluacion }}"
                                                                    class="btn btn-success">Guardar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade"
                                                    id="eliminarModalEvaluacion{{ $evaluacion->id_evaluacion }}"
                                                    tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header1">
                                                                <h5 class="modal-title">Eliminar Evaluación</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Seguro que deseas eliminar la evaluación
                                                                <strong>{{ $evaluacion->nombre }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <form
                                                                    action="{{ route('catalogos.destroy', $evaluacion->id_evaluacion) }}"
                                                                    method="POST" style="display:inline-block;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <input type="hidden" name="tabla"
                                                                        value="evaluaciones">
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Eliminar</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            {{-- Modal Agregar (solo confirmación) --}}
                                            <div class="modal fade" id="agregarModalEvaluacion" tabindex="-1"
                                                role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Confirmar Agregar</h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal"><span>&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            ¿Estás seguro de agregar esta nueva evaluación?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Cancelar</button>
                                                            <button type="submit" form="formAgregarEvaluacion"
                                                                class="btn btn-success">Agregar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- ================== STATUS ACADÉMICOS ================== --}}
                                        <div class="tab-pane fade" id="status" role="tabpanel"
                                            aria-labelledby="status-tab">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4 class="mb-4">Status Académicos</h4>
                                                    <form id="filtrosFormStatus" method="GET"
                                                        action="{{ route('catalogos.index') }}"
                                                        class="d-flex align-items-center1 gap-3">
                                                        <input type="hidden" name="tabla" value="status">
                                                        <div class="flex-grow-1" style="max-width: 400px;">
                                                            <input type="text" name="nombre_status"
                                                                class="form-control form-control-sm"
                                                                placeholder="🔍 Buscar por nombre o descripción"
                                                                value="{{ request('nombre_status') }}">
                                                        </div>
                                                        <button type="submit" class="btn btn-sm btn-primary px-3">
                                                            <i class="fas fa-search mr-1"></i> Buscar
                                                        </button>
                                                        <a href="{{ route('catalogos.index', ['tabla' => 'status']) }}"
                                                            class="btn btn-sm btn-outline-secondary px-3">
                                                            <i class="fas fa-list mr-1"></i>Mostrar todo
                                                        </a>
                                                    </form>

                                                    @if (count($statusAcademicos))
                                                        {{-- Formulario agregar nuevo status --}}
                                                        <div class="container mb-4 mt-4 d-flex justify-content-start">
                                                            <div
                                                                class="p-3 border rounded bg-light d-inline-block shadow-sm">
                                                                <form id="formAgregarStatus" method="POST"
                                                                    action="{{ route('catalogos.store') }}"
                                                                    class="form-inline mb-3">
                                                                    @csrf
                                                                    <input type="hidden" name="tabla"
                                                                        value="status">
                                                                    <div class="form-group mr-2 mb-2">
                                                                        <input type="text" name="nombre"
                                                                            class="form-control"
                                                                            placeholder="Nombre del status" required>
                                                                    </div>
                                                                    <div class="form-group mr-2 mb-2">
                                                                        <input type="text" name="descripcion"
                                                                            class="form-control"
                                                                            placeholder="Descripción" required>
                                                                    </div>
                                                                    <button type="button"
                                                                        class="btn btn-success mb-2"
                                                                        data-toggle="modal"
                                                                        data-target="#agregarModalStatus">
                                                                        Agregar
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>

                                                        <table class="table table-bordered table-hover">
                                                            <thead class="thead-dark text-center">
                                                                <tr>
                                                                    <th>Nombre</th>
                                                                    <th>Descripción</th>
                                                                    <th style="width: 150px;">Acciones</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($statusAcademicos as $status)
                                                                    <tr>
                                                                        <form
                                                                            id="formStatus{{ $status->id_status_academico }}"
                                                                            method="POST"
                                                                            action="{{ route('catalogos.update', $status->id_status_academico) }}">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <input type="hidden" name="tabla"
                                                                                value="status">
                                                                            <td>
                                                                                <input type="text" name="nombre"
                                                                                    class="form-control"
                                                                                    value="{{ $status->nombre }}">
                                                                            </td>
                                                                            <td>
                                                                                <input type="text"
                                                                                    name="descripcion"
                                                                                    class="form-control"
                                                                                    value="{{ $status->descripcion }}">
                                                                            </td>
                                                                            <td class="d-flex">
                                                                                <button type="button"
                                                                                    class="btn btn-warning btn-sm mr-1"
                                                                                    data-toggle="modal"
                                                                                    data-target="#guardarModalStatus{{ $status->id_status_academico }}">
                                                                                    Guardar
                                                                                </button>
                                                                                <button type="button"
                                                                                    class="btn btn-danger btn-sm"
                                                                                    data-toggle="modal"
                                                                                    data-target="#eliminarModalStatus{{ $status->id_status_academico }}">
                                                                                    Eliminar
                                                                                </button>
                                                                            </td>
                                                                        </form>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    @else
                                                        <p class="text-center text-muted mt-3">No hay registros para
                                                            mostrar.</p>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Modales para Status --}}
                                            @foreach ($statusAcademicos as $status)
                                                <div class="modal fade"
                                                    id="guardarModalStatus{{ $status->id_status_academico }}"
                                                    tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Confirmar Cambios</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Estás seguro de guardar los cambios en
                                                                <strong>{{ $status->nombre }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <button type="submit"
                                                                    form="formStatus{{ $status->id_status_academico }}"
                                                                    class="btn btn-success">Guardar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade"
                                                    id="eliminarModalStatus{{ $status->id_status_academico }}"
                                                    tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header1">
                                                                <h5 class="modal-title">🗑️ Eliminar Status Académico</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Seguro que deseas eliminar el status
                                                                <strong>{{ $status->nombre }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <form
                                                                    action="{{ route('catalogos.destroy', $status->id_status_academico) }}"
                                                                    method="POST" style="display:inline-block;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <input type="hidden" name="tabla"
                                                                        value="status">
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Eliminar</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            {{-- Modal Agregar (solo confirmación) --}}
                                            <div class="modal fade" id="agregarModalStatus" tabindex="-1"
                                                role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Confirmar Agregar</h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal"><span>&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            ¿Estás seguro de agregar este nuevo status académico?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Cancelar</button>
                                                            <button type="submit" form="formAgregarStatus"
                                                                class="btn btn-success">Agregar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- ================== ESTADOS ================== --}}
                                        <div class="tab-pane fade" id="estados" role="tabpanel"
                                            aria-labelledby="estados-tab">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4 class="mb-4">Estados</h4>
                                                    <form id="filtrosFormEstados" method="GET"
                                                        action="{{ route('catalogos.index') }}"
                                                        class="d-flex align-items-center1 gap-3">
                                                        <input type="hidden" name="tabla" value="estados">
                                                        <div class="flex-grow-1" style="max-width: 400px;">
                                                            <input type="text" name="nombre_estados"
                                                                class="form-control form-control-sm"
                                                                placeholder="🔍 Buscar por nombre"
                                                                value="{{ request('nombre_estados') }}">
                                                        </div>
                                                        <button type="submit" class="btn btn-sm btn-primary px-3">
                                                            <i class="fas fa-search mr-1"></i> Buscar
                                                        </button>
                                                        <a href="{{ route('catalogos.index', ['tabla' => 'estados']) }}"
                                                            class="btn btn-sm btn-outline-secondary px-3">
                                                            <i class="fas fa-list mr-1"></i>Mostrar todo
                                                        </a>
                                                    </form>

                                                    @if (count($estados))
                                                        {{-- Formulario agregar nuevo estado --}}
                                                        <div class="container mb-4 mt-4 d-flex justify-content-start">
                                                            <div
                                                                class="p-3 border rounded bg-light d-inline-block shadow-sm">
                                                                <form id="formAgregarEstado" method="POST"
                                                                    action="{{ route('catalogos.store') }}"
                                                                    class="form-inline mb-3">
                                                                    @csrf
                                                                    <input type="hidden" name="tabla"
                                                                        value="estados">
                                                                    <div class="form-group mr-2 mb-2">
                                                                        <input type="text" name="nombre"
                                                                            class="form-control"
                                                                            placeholder="Nombre del estado" required>
                                                                    </div>
                                                                    <button type="button"
                                                                        class="btn btn-success mb-2"
                                                                        data-toggle="modal"
                                                                        data-target="#agregarModalEstado">
                                                                        Agregar
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>

                                                        <table class="table table-bordered table-hover">
                                                            <thead class="thead-dark text-center">
                                                                <tr>
                                                                    <th style="width: 80px;">ID</th>
                                                                    <th>Nombre</th>
                                                                    <th style="width: 150px;">Acciones</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($estados as $estado)
                                                                    <tr>
                                                                        <form id="formEstado{{ $estado->id_estado }}"
                                                                            method="POST"
                                                                            action="{{ route('catalogos.update', $estado->id_estado) }}">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <input type="hidden" name="tabla"
                                                                                value="estados">
                                                                            <td class="text-center">
                                                                                {{ $estado->id_estado }}</td>
                                                                            <td>
                                                                                <input type="text" name="nombre"
                                                                                    class="form-control"
                                                                                    value="{{ $estado->nombre }}">
                                                                            </td>
                                                                            <td class="d-flex">
                                                                                <button type="button"
                                                                                    class="btn btn-warning btn-sm mr-1"
                                                                                    data-toggle="modal"
                                                                                    data-target="#guardarModalEstado{{ $estado->id_estado }}">
                                                                                    Guardar
                                                                                </button>
                                                                                <button type="button"
                                                                                    class="btn btn-danger btn-sm"
                                                                                    data-toggle="modal"
                                                                                    data-target="#eliminarModalEstado{{ $estado->id_estado }}">
                                                                                    Eliminar
                                                                                </button>
                                                                            </td>
                                                                        </form>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    @else
                                                        <p class="text-center text-muted mt-3">No hay registros para
                                                            mostrar.</p>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Modales para Estados --}}
                                            @foreach ($estados as $estado)
                                                <div class="modal fade"
                                                    id="guardarModalEstado{{ $estado->id_estado }}" tabindex="-1"
                                                    role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Confirmar Cambios</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Estás seguro de guardar los cambios en
                                                                <strong>{{ $estado->nombre }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <button type="submit"
                                                                    form="formEstado{{ $estado->id_estado }}"
                                                                    class="btn btn-success">Guardar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade"
                                                    id="eliminarModalEstado{{ $estado->id_estado }}" tabindex="-1"
                                                    role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header1">
                                                                <h5 class="modal-title">Eliminar Estado</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Seguro que deseas eliminar el estado
                                                                <strong>{{ $estado->nombre }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <form
                                                                    action="{{ route('catalogos.destroy', $estado->id_estado) }}"
                                                                    method="POST" style="display:inline-block;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <input type="hidden" name="tabla"
                                                                        value="estados">
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Eliminar</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            {{-- Modal Agregar (solo confirmación) --}}
                                            <div class="modal fade" id="agregarModalEstado" tabindex="-1"
                                                role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Confirmar Agregar</h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal"><span>&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            ¿Estás seguro de agregar este nuevo estado?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Cancelar</button>
                                                            <button type="submit" form="formAgregarEstado"
                                                                class="btn btn-success">Agregar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- ================== DISTRITOS ================== --}}
                                        <div class="tab-pane fade" id="distritos" role="tabpanel"
                                            aria-labelledby="distritos-tab">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4 class="mb-4">Distritos</h4>
                                                    <form id="filtrosFormDistritos" method="GET"
                                                        action="{{ route('catalogos.index') }}"
                                                        class="d-flex align-items-center1 gap-3">
                                                        <input type="hidden" name="tabla" value="distritos">
                                                        <div class="flex-grow-1" style="max-width: 400px;">
                                                            <input type="text" name="nombre_distritos"
                                                                class="form-control form-control-sm"
                                                                placeholder="🔍 Buscar por nombre"
                                                                value="{{ request('nombre_distritos') }}">
                                                        </div>
                                                        <button type="submit" class="btn btn-sm btn-primary px-3">
                                                            <i class="fas fa-search mr-1"></i> Buscar
                                                        </button>
                                                        <a href="{{ route('catalogos.index', ['tabla' => 'distritos']) }}"
                                                            class="btn btn-sm btn-outline-secondary px-3">
                                                            <i class="fas fa-list mr-1"></i>Mostrar todo
                                                        </a>
                                                    </form>

                                                    @if (count($distritos))
                                                        {{-- Formulario agregar nuevo distrito --}}
                                                        <div class="container mb-4 mt-4 d-flex justify-content-start">
                                                            <div
                                                                class="p-3 border rounded bg-light d-inline-block shadow-sm">
                                                                <form id="formAgregarDistrito" method="POST"
                                                                    action="{{ route('catalogos.store') }}"
                                                                    class="form-inline mb-3">
                                                                    @csrf
                                                                    <input type="hidden" name="tabla"
                                                                        value="distritos">
                                                                    <div class="form-group mr-2 mb-2">
                                                                        <input type="text" name="nombre"
                                                                            class="form-control"
                                                                            placeholder="Nombre del distrito" required>
                                                                    </div>
                                                                    <button type="button"
                                                                        class="btn btn-success mb-2"
                                                                        data-toggle="modal"
                                                                        data-target="#agregarModalDistrito">
                                                                        Agregar
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>

                                                        <table class="table table-bordered table-hover">
                                                            <thead class="thead-dark text-center">
                                                                <tr>
                                                                    <th style="width: 80px;">ID</th>
                                                                    <th>Nombre</th>
                                                                    <th style="width: 150px;">Acciones</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($distritos as $distrito)
                                                                    <tr>
                                                                        <form
                                                                            id="formDistrito{{ $distrito->id_distrito }}"
                                                                            method="POST"
                                                                            action="{{ route('catalogos.update', $distrito->id_distrito) }}">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <input type="hidden" name="tabla"
                                                                                value="distritos">
                                                                            <td class="text-center">
                                                                                {{ $distrito->id_distrito }}</td>
                                                                            <td>
                                                                                <input type="text" name="nombre"
                                                                                    class="form-control"
                                                                                    value="{{ $distrito->nombre }}">
                                                                            </td>
                                                                            <td class="d-flex">
                                                                                <button type="button"
                                                                                    class="btn btn-warning btn-sm mr-1"
                                                                                    data-toggle="modal"
                                                                                    data-target="#guardarModalDistrito{{ $distrito->id_distrito }}">
                                                                                    Guardar
                                                                                </button>
                                                                                <button type="button"
                                                                                    class="btn btn-danger btn-sm"
                                                                                    data-toggle="modal"
                                                                                    data-target="#eliminarModalDistrito{{ $distrito->id_distrito }}">
                                                                                    Eliminar
                                                                                </button>
                                                                            </td>
                                                                        </form>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    @else
                                                        <p class="text-center text-muted mt-3">No hay registros para
                                                            mostrar.</p>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Modales para Distritos --}}
                                            @foreach ($distritos as $distrito)
                                                <div class="modal fade"
                                                    id="guardarModalDistrito{{ $distrito->id_distrito }}"
                                                    tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Confirmar Cambios</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Estás seguro de guardar los cambios en
                                                                <strong>{{ $distrito->nombre }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <button type="submit"
                                                                    form="formDistrito{{ $distrito->id_distrito }}"
                                                                    class="btn btn-success">Guardar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade"
                                                    id="eliminarModalDistrito{{ $distrito->id_distrito }}"
                                                    tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header1">
                                                                <h5 class="modal-title">Eliminar Distrito</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Seguro que deseas eliminar el distrito
                                                                <strong>{{ $distrito->nombre }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <form
                                                                    action="{{ route('catalogos.destroy', $distrito->id_distrito) }}"
                                                                    method="POST" style="display:inline-block;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <input type="hidden" name="tabla"
                                                                        value="distritos">
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Eliminar</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            {{-- Modal Agregar (solo confirmación) --}}
                                            <div class="modal fade" id="agregarModalDistrito" tabindex="-1"
                                                role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Confirmar Agregar</h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal"><span>&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            ¿Estás seguro de agregar este nuevo distrito?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Cancelar</button>
                                                            <button type="submit" form="formAgregarDistrito"
                                                                class="btn btn-success">Agregar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- ================== LENGUAS INDÍGENAS ================== --}}
                                        <div class="tab-pane fade" id="lenguas" role="tabpanel"
                                            aria-labelledby="lenguas-tab">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4 class="mb-4">Lenguas Indígenas</h4>
                                                    <form id="filtrosFormLenguas" method="GET"
                                                        action="{{ route('catalogos.index') }}"
                                                        class="d-flex align-items-center1 gap-3">
                                                        <input type="hidden" name="tabla" value="lenguas">
                                                        <div class="flex-grow-1" style="max-width: 400px;">
                                                            <input type="text" name="nombre_lenguas"
                                                                class="form-control form-control-sm"
                                                                placeholder="🔍 Buscar por nombre"
                                                                value="{{ request('nombre_lenguas') }}">
                                                        </div>
                                                        <button type="submit" class="btn btn-sm btn-primary px-3">
                                                            <i class="fas fa-search mr-1"></i> Buscar
                                                        </button>
                                                        <a href="{{ route('catalogos.index', ['tabla' => 'lenguas']) }}"
                                                            class="btn btn-sm btn-outline-secondary px-3">
                                                            <i class="fas fa-list mr-1"></i>Mostrar todo
                                                        </a>
                                                    </form>

                                                    @if (count($lenguas))
                                                        {{-- Formulario agregar nueva lengua --}}
                                                        <div class="container mb-4 mt-4 d-flex justify-content-start">
                                                            <div
                                                                class="p-3 border rounded bg-light d-inline-block shadow-sm">
                                                                <form id="formAgregarLengua" method="POST"
                                                                    action="{{ route('catalogos.store') }}"
                                                                    class="form-inline mb-3">
                                                                    @csrf
                                                                    <input type="hidden" name="tabla"
                                                                        value="lenguas">
                                                                    <div class="form-group mr-2 mb-2">
                                                                        <input type="text" name="nombre"
                                                                            class="form-control"
                                                                            placeholder="Nombre de la lengua indígena"
                                                                            required>
                                                                    </div>
                                                                    <button type="button"
                                                                        class="btn btn-success mb-2"
                                                                        data-toggle="modal"
                                                                        data-target="#agregarModalLengua">
                                                                        Agregar
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>

                                                        <table class="table table-bordered table-hover">
                                                            <thead class="thead-dark text-center">
                                                                <tr>
                                                                    <th style="width: 80px;">ID</th>
                                                                    <th>Nombre</th>
                                                                    <th style="width: 150px;">Acciones</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($lenguas as $lengua)
                                                                    <tr>
                                                                        <form
                                                                            id="formLengua{{ $lengua->id_lengua_indigena }}"
                                                                            method="POST"
                                                                            action="{{ route('catalogos.update', $lengua->id_lengua_indigena) }}">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <input type="hidden" name="tabla"
                                                                                value="lenguas">
                                                                            <td class="text-center">
                                                                                {{ $lengua->id_lengua_indigena }}</td>
                                                                            <td>
                                                                                <input type="text" name="nombre"
                                                                                    class="form-control"
                                                                                    value="{{ $lengua->nombre }}">
                                                                            </td>
                                                                            <td class="d-flex">
                                                                                <button type="button"
                                                                                    class="btn btn-warning btn-sm mr-1"
                                                                                    data-toggle="modal"
                                                                                    data-target="#guardarModalLengua{{ $lengua->id_lengua_indigena }}">
                                                                                    Guardar
                                                                                </button>
                                                                                <button type="button"
                                                                                    class="btn btn-danger btn-sm"
                                                                                    data-toggle="modal"
                                                                                    data-target="#eliminarModalLengua{{ $lengua->id_lengua_indigena }}">
                                                                                    Eliminar
                                                                                </button>
                                                                            </td>
                                                                        </form>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    @else
                                                        <p class="text-center text-muted mt-3">No hay registros para
                                                            mostrar.</p>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Modales para Lenguas --}}
                                            @foreach ($lenguas as $lengua)
                                                <div class="modal fade"
                                                    id="guardarModalLengua{{ $lengua->id_lengua_indigena }}"
                                                    tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Confirmar Cambios</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Estás seguro de guardar los cambios en
                                                                <strong>{{ $lengua->nombre }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <button type="submit"
                                                                    form="formLengua{{ $lengua->id_lengua_indigena }}"
                                                                    class="btn btn-success">Guardar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade"
                                                    id="eliminarModalLengua{{ $lengua->id_lengua_indigena }}"
                                                    tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header1">
                                                                <h5 class="modal-title">Eliminar Lengua Indígena</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Seguro que deseas eliminar la lengua
                                                                <strong>{{ $lengua->nombre }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <form
                                                                    action="{{ route('catalogos.destroy', $lengua->id_lengua_indigena) }}"
                                                                    method="POST" style="display:inline-block;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <input type="hidden" name="tabla"
                                                                        value="lenguas">
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Eliminar</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            {{-- Modal Agregar (solo confirmación) --}}
                                            <div class="modal fade" id="agregarModalLengua" tabindex="-1"
                                                role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Confirmar Agregar</h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal"><span>&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            ¿Estás seguro de agregar esta nueva lengua indígena?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Cancelar</button>
                                                            <button type="submit" form="formAgregarLengua"
                                                                class="btn btn-success">Agregar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- ================== SUBSISTEMAS ================== --}}
                                        <div class="tab-pane fade" id="subsistemas" role="tabpanel"
                                            aria-labelledby="subsistemas-tab">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4 class="mb-4">Subsistemas de Preparatorias</h4>
                                                    <form id="filtrosFormSubsistemas" method="GET"
                                                        action="{{ route('catalogos.index') }}"
                                                        class="d-flex align-items-center1 gap-3">
                                                        <input type="hidden" name="tabla" value="subsistemas">
                                                        <div class="flex-grow-1" style="max-width: 400px;">
                                                            <input type="text" name="nombre_subsistemas"
                                                                class="form-control form-control-sm"
                                                                placeholder="🔍 Buscar por nombre o descripción"
                                                                value="{{ request('nombre_subsistemas') }}">
                                                        </div>
                                                        <button type="submit" class="btn btn-sm btn-primary px-3">
                                                            <i class="fas fa-search mr-1"></i> Buscar
                                                        </button>
                                                        <a href="{{ route('catalogos.index', ['tabla' => 'subsistemas']) }}"
                                                            class="btn btn-sm btn-outline-secondary px-3">
                                                            <i class="fas fa-list mr-1"></i>Mostrar todo
                                                        </a>
                                                    </form>

                                                    @if (count($subsistemas))
                                                        {{-- Formulario agregar nuevo subsistema --}}
                                                        <div class="container mb-4 mt-4 d-flex justify-content-start">
                                                            <div
                                                                class="p-3 border rounded bg-light d-inline-block shadow-sm">
                                                                <form id="formAgregarSubsistema" method="POST"
                                                                    action="{{ route('catalogos.store') }}"
                                                                    class="form-inline mb-3">
                                                                    @csrf
                                                                    <input type="hidden" name="tabla"
                                                                        value="subsistemas">
                                                                    <div class="form-group mr-2 mb-2">
                                                                        <input type="text" name="nombre"
                                                                            class="form-control"
                                                                            placeholder="Nombre del subsistema"
                                                                            required>
                                                                    </div>
                                                                    <div class="form-group mr-2 mb-2">
                                                                        <input type="text" name="descripcion"
                                                                            class="form-control"
                                                                            placeholder="Descripción" required>
                                                                    </div>
                                                                    <button type="button"
                                                                        class="btn btn-success mb-2"
                                                                        data-toggle="modal"
                                                                        data-target="#agregarModalSubsistema">
                                                                        Agregar
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>

                                                        <table class="table table-bordered table-hover">
                                                            <thead class="thead-dark text-center">
                                                                <tr>
                                                                    <th>Nombre</th>
                                                                    <th>Descripción</th>
                                                                    <th style="width: 150px;">Acciones</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($subsistemas as $subsistema)
                                                                    <tr>
                                                                        <form
                                                                            id="formSubsistema{{ $subsistema->id_subsistema }}"
                                                                            method="POST"
                                                                            action="{{ route('catalogos.update', $subsistema->id_subsistema) }}">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <input type="hidden" name="tabla"
                                                                                value="subsistemas">
                                                                            <td>
                                                                                <input type="text" name="nombre"
                                                                                    class="form-control"
                                                                                    value="{{ $subsistema->nombre }}">
                                                                            </td>
                                                                            <td>
                                                                                <input type="text"
                                                                                    name="descripcion"
                                                                                    class="form-control"
                                                                                    value="{{ $subsistema->descripcion }}">
                                                                            </td>
                                                                            <td class="d-flex">
                                                                                <button type="button"
                                                                                    class="btn btn-warning btn-sm mr-1"
                                                                                    data-toggle="modal"
                                                                                    data-target="#guardarModalSubsistema{{ $subsistema->id_subsistema }}">
                                                                                    Guardar
                                                                                </button>
                                                                                <button type="button"
                                                                                    class="btn btn-danger btn-sm"
                                                                                    data-toggle="modal"
                                                                                    data-target="#eliminarModalSubsistema{{ $subsistema->id_subsistema }}">
                                                                                    Eliminar
                                                                                </button>
                                                                            </td>
                                                                        </form>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    @else
                                                        <p class="text-center text-muted mt-3">No hay registros para
                                                            mostrar.</p>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Modales para Subsistemas --}}
                                            @foreach ($subsistemas as $subsistema)
                                                <div class="modal fade"
                                                    id="guardarModalSubsistema{{ $subsistema->id_subsistema }}"
                                                    tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Confirmar Cambios</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Estás seguro de guardar los cambios en
                                                                <strong>{{ $subsistema->nombre }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <button type="submit"
                                                                    form="formSubsistema{{ $subsistema->id_subsistema }}"
                                                                    class="btn btn-success">Guardar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade"
                                                    id="eliminarModalSubsistema{{ $subsistema->id_subsistema }}"
                                                    tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header1">
                                                                <h5 class="modal-title">Eliminar Subsistema</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Seguro que deseas eliminar el subsistema
                                                                <strong>{{ $subsistema->nombre }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <form
                                                                    action="{{ route('catalogos.destroy', $subsistema->id_subsistema) }}"
                                                                    method="POST" style="display:inline-block;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <input type="hidden" name="tabla"
                                                                        value="subsistemas">
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Eliminar</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            {{-- Modal Agregar (solo confirmación) --}}
                                            <div class="modal fade" id="agregarModalSubsistema" tabindex="-1"
                                                role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Confirmar Agregar</h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal"><span>&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            ¿Estás seguro de agregar este nuevo subsistema?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Cancelar</button>
                                                            <button type="submit" form="formAgregarSubsistema"
                                                                class="btn btn-success">Agregar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- ================== BECAS ================== --}}
                                        <div class="tab-pane fade" id="becas" role="tabpanel"
                                            aria-labelledby="becas-tab">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4 class="mb-4">Becas</h4>
                                                    <form id="filtrosFormBecas" method="GET"
                                                        action="{{ route('catalogos.index') }}"
                                                        class="d-flex align-items-center1 gap-3">
                                                        <input type="hidden" name="tabla" value="becas">
                                                        <div class="flex-grow-1" style="max-width: 400px;">
                                                            <input type="text" name="nombre_becas"
                                                                class="form-control form-control-sm"
                                                                placeholder="🔍 Buscar por nombre"
                                                                value="{{ request('nombre_becas') }}">
                                                        </div>
                                                        <button type="submit" class="btn btn-sm btn-primary px-3">
                                                            <i class="fas fa-search mr-1"></i> Buscar
                                                        </button>
                                                        <a href="{{ route('catalogos.index', ['tabla' => 'becas']) }}"
                                                            class="btn btn-sm btn-outline-secondary px-3">
                                                            <i class="fas fa-list mr-1"></i>Mostrar todo
                                                        </a>
                                                    </form>

                                                    @if (count($becas))
                                                        {{-- Formulario agregar nueva beca --}}
                                                        <div class="container mb-4 mt-4 d-flex justify-content-start">
                                                            <div
                                                                class="p-3 border rounded bg-light d-inline-block shadow-sm">
                                                                <form id="formAgregarBeca" method="POST"
                                                                    action="{{ route('catalogos.store') }}"
                                                                    class="form-inline mb-3">
                                                                    @csrf
                                                                    <input type="hidden" name="tabla"
                                                                        value="becas">
                                                                    <div class="form-group mr-2 mb-2">
                                                                        <input type="text" name="nombre"
                                                                            class="form-control"
                                                                            placeholder="Nombre de la beca" required>
                                                                    </div>
                                                                    <button type="button"
                                                                        class="btn btn-success mb-2"
                                                                        data-toggle="modal"
                                                                        data-target="#agregarModalBeca">
                                                                        Agregar
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>

                                                        <table class="table table-bordered table-hover">
                                                            <thead class="thead-dark text-center">
                                                                <tr>
                                                                    <th>Nombre</th>
                                                                    <th style="width: 150px;">Acciones</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($becas as $beca)
                                                                    <tr>
                                                                        <form id="formBeca{{ $beca->id_beca }}"
                                                                            method="POST"
                                                                            action="{{ route('catalogos.update', $beca->id_beca) }}">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <input type="hidden" name="tabla"
                                                                                value="becas">
                                                                            <td>
                                                                                <input type="text" name="nombre"
                                                                                    class="form-control"
                                                                                    value="{{ $beca->nombre }}">
                                                                            </td>
                                                                            <td class="d-flex">
                                                                                <button type="button"
                                                                                    class="btn btn-warning btn-sm mr-1"
                                                                                    data-toggle="modal"
                                                                                    data-target="#guardarModalBeca{{ $beca->id_beca }}">
                                                                                    Guardar
                                                                                </button>
                                                                                <button type="button"
                                                                                    class="btn btn-danger btn-sm"
                                                                                    data-toggle="modal"
                                                                                    data-target="#eliminarModalBeca{{ $beca->id_beca }}">
                                                                                    Eliminar
                                                                                </button>
                                                                            </td>
                                                                        </form>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    @else
                                                        <p class="text-center text-muted mt-3">No hay registros para
                                                            mostrar.</p>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Modales para Becas --}}
                                            @foreach ($becas as $beca)
                                                <div class="modal fade" id="guardarModalBeca{{ $beca->id_beca }}"
                                                    tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Confirmar Cambios</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Estás seguro de guardar los cambios en
                                                                <strong>{{ $beca->nombre }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <button type="submit"
                                                                    form="formBeca{{ $beca->id_beca }}"
                                                                    class="btn btn-success">Guardar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade" id="eliminarModalBeca{{ $beca->id_beca }}"
                                                    tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header1">
                                                                <h5 class="modal-title">Eliminar Beca</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Seguro que deseas eliminar la beca
                                                                <strong>{{ $beca->nombre }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <form
                                                                    action="{{ route('catalogos.destroy', $beca->id_beca) }}"
                                                                    method="POST" style="display:inline-block;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <input type="hidden" name="tabla"
                                                                        value="becas">
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Eliminar</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            {{-- Modal Agregar (solo confirmación) --}}
                                            <div class="modal fade" id="agregarModalBeca" tabindex="-1"
                                                role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Confirmar Agregar</h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal"><span>&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            ¿Estás seguro de agregar esta nueva beca?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Cancelar</button>
                                                            <button type="submit" form="formAgregarBeca"
                                                                class="btn btn-success">Agregar</button>
                                                        </div>
                                                    </div>
                                                </div>
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

                                        {{-- ================== TIPOS DE PERÍODOS ================== --}}
                                        <div class="tab-pane fade show active" id="periodos" role="tabpanel"
                                            aria-labelledby="periodos-tab">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4 class="mb-4">Tipos de Períodos Escolares</h4>
                                                    <form id="filtrosFormPeriodos" method="GET"
                                                        action="{{ route('catalogos.index') }}"
                                                        class="d-flex align-items-center1 gap-3">
                                                        <input type="hidden" name="tabla" value="periodos">
                                                        <div class="flex-grow-1" style="max-width: 400px;">
                                                            <input type="text" name="nombre_periodos"
                                                                class="form-control form-control-sm"
                                                                placeholder="🔍 Buscar por nombre"
                                                                value="{{ request('nombre_periodos') }}">
                                                        </div>
                                                        <button type="submit" class="btn btn-sm btn-primary px-3">
                                                            <i class="fas fa-search mr-1"></i> Buscar
                                                        </button>
                                                        <a href="{{ route('catalogos.index', ['tabla' => 'periodos']) }}"
                                                            class="btn btn-sm btn-outline-secondary px-3">
                                                            <i class="fas fa-list mr-1"></i> Mostrar todo
                                                        </a>
                                                    </form>

                                                    @if (count($tiposPeriodos))
                                                        {{-- Formulario agregar nuevo tipo de período --}}
                                                        <div class="container mb-4 mt-4 d-flex justify-content-start">
                                                            <div
                                                                class="p-3 border rounded bg-light d-inline-block shadow-sm">
                                                                <form id="formAgregarPeriodo" method="POST"
                                                                    action="{{ route('catalogos.store') }}"
                                                                    class="form-inline mb-3">
                                                                    @csrf
                                                                    <input type="hidden" name="tabla"
                                                                        value="periodos">
                                                                    <div class="form-group mr-2 mb-2">
                                                                        <input type="text" name="nombre"
                                                                            class="form-control"
                                                                            placeholder="Nombre del período" required
                                                                            minlength="3" maxlength="100">
                                                                    </div>
                                                                    <div class="form-group mr-2 mb-2">
                                                                        <input type="text" name="duracion"
                                                                            class="form-control"
                                                                            placeholder="Duración (opcional)"
                                                                            maxlength="50">
                                                                    </div>
                                                                    <button type="button"
                                                                        class="btn btn-success mb-2"
                                                                        data-toggle="modal"
                                                                        data-target="#agregarModalPeriodo">
                                                                        <i class="fas fa-plus"></i> Agregar
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>

                                                        <table class="table table-bordered table-hover">
                                                            <thead class="thead-dark text-center">
                                                                <tr>
                                                                    <th>Nombre</th>
                                                                    <th>Duración</th>
                                                                    <th style="width: 150px;">Acciones</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($tiposPeriodos as $periodo)
                                                                    <tr>
                                                                        <form
                                                                            id="formPeriodo{{ $periodo->id_tipo_periodo }}"
                                                                            method="POST"
                                                                            action="{{ route('catalogos.update', $periodo->id_tipo_periodo) }}">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <input type="hidden" name="tabla"
                                                                                value="periodos">
                                                                            <td>
                                                                                <input type="text" name="nombre"
                                                                                    class="form-control"
                                                                                    value="{{ $periodo->nombre }}"
                                                                                    required minlength="3"
                                                                                    maxlength="100">
                                                                            </td>
                                                                            <td>
                                                                                <input type="text"
                                                                                    name="duracion"
                                                                                    class="form-control"
                                                                                    value="{{ $periodo->duracion }}"
                                                                                    maxlength="50">
                                                                            </td>
                                                                            <td class="d-flex">
                                                                                <button type="button"
                                                                                    class="btn btn-warning btn-sm mr-1"
                                                                                    data-toggle="modal"
                                                                                    data-target="#guardarModalPeriodo{{ $periodo->id_tipo_periodo }}">
                                                                                    Guardar
                                                                                </button>
                                                                                <button type="button"
                                                                                    class="btn btn-danger btn-sm"
                                                                                    data-toggle="modal"
                                                                                    data-target="#eliminarModalPeriodo{{ $periodo->id_tipo_periodo }}">
                                                                                    Eliminar
                                                                                </button>
                                                                            </td>
                                                                        </form>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    @else
                                                        <p class="text-center text-muted mt-3">No hay registros para
                                                            mostrar.</p>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Modales para Períodos --}}
                                            @foreach ($tiposPeriodos as $periodo)
                                                <div class="modal fade"
                                                    id="guardarModalPeriodo{{ $periodo->id_tipo_periodo }}"
                                                    tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Confirmar Cambios</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Estás seguro de guardar los cambios en
                                                                <strong>{{ $periodo->nombre }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <button type="submit"
                                                                    form="formPeriodo{{ $periodo->id_tipo_periodo }}"
                                                                    class="btn btn-success">Guardar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade"
                                                    id="eliminarModalPeriodo{{ $periodo->id_tipo_periodo }}"
                                                    tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header1">
                                                                <h5 class="modal-title">Eliminar Período</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Seguro que deseas eliminar el período
                                                                <strong>{{ $periodo->nombre }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <form
                                                                    action="{{ route('catalogos.destroy', $periodo->id_tipo_periodo) }}"
                                                                    method="POST" style="display:inline-block;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <input type="hidden" name="tabla"
                                                                        value="periodos">
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Eliminar</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            {{-- Modal Agregar --}}
                                            <div class="modal fade" id="agregarModalPeriodo" tabindex="-1"
                                                role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Confirmar Agregar</h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal"><span>&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            ¿Estás seguro de agregar este nuevo tipo de período?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Cancelar</button>
                                                            <button type="submit" form="formAgregarPeriodo"
                                                                class="btn btn-success">Agregar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- ================== ÁREAS DE ESPECIALIZACIÓN ================== --}}
                                        <div class="tab-pane fade" id="areas" role="tabpanel"
                                            aria-labelledby="areas-tab">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4 class="mb-4">Áreas de Especialización de Preparatoria</h4>
                                                    <form id="filtrosFormAreas" method="GET"
                                                        action="{{ route('catalogos.index') }}"
                                                        class="d-flex align-items-center1 gap-3">
                                                        <input type="hidden" name="tabla" value="areas">
                                                        <div class="flex-grow-1" style="max-width: 400px;">
                                                            <input type="text" name="nombre_areas"
                                                                class="form-control form-control-sm"
                                                                placeholder="🔍 Buscar por nombre"
                                                                value="{{ request('nombre_areas') }}">
                                                        </div>
                                                        <button type="submit" class="btn btn-sm btn-primary px-3">
                                                            <i class="fas fa-search mr-1"></i> Buscar
                                                        </button>
                                                        <a href="{{ route('catalogos.index', ['tabla' => 'areas']) }}"
                                                            class="btn btn-sm btn-outline-secondary px-3">
                                                            <i class="fas fa-list mr-1"></i>Mostrar todo
                                                        </a>
                                                    </form>

                                                    @if (count($areas))
                                                        <div class="container mb-4 mt-4 d-flex justify-content-start">
                                                            <div
                                                                class="p-3 border rounded bg-light d-inline-block shadow-sm">
                                                                <form id="formAgregarArea" method="POST"
                                                                    action="{{ route('catalogos.store') }}"
                                                                    class="form-inline mb-3">
                                                                    @csrf
                                                                    <input type="hidden" name="tabla"
                                                                        value="areas">
                                                                    <div class="form-group mr-2 mb-2">
                                                                        <input type="text" name="nombres"
                                                                            class="form-control"
                                                                            placeholder="Nombre del área" required
                                                                            minlength="3" maxlength="100">
                                                                    </div>
                                                                    <button type="button"
                                                                        class="btn btn-success mb-2"
                                                                        data-toggle="modal"
                                                                        data-target="#agregarModalArea">
                                                                        Agregar
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>

                                                        <table class="table table-bordered table-hover">
                                                            <thead class="thead-dark text-center">
                                                                <tr>
                                                                    <th style="width: 80px;">ID</th>
                                                                    <th>Nombre</th>
                                                                    <th style="width: 150px;">Acciones</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($areas as $area)
                                                                    <tr>
                                                                        <form
                                                                            id="formArea{{ $area->id_area_especializacion }}"
                                                                            method="POST"
                                                                            action="{{ route('catalogos.update', $area->id_area_especializacion) }}">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <input type="hidden" name="tabla"
                                                                                value="areas">
                                                                            <td class="text-center">
                                                                                {{ $area->id_area_especializacion }}
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" name="nombres"
                                                                                    class="form-control"
                                                                                    value="{{ $area->nombre }}"
                                                                                    required minlength="3"
                                                                                    maxlength="100">
                                                                            </td>
                                                                            <td class="d-flex">
                                                                                <button type="button"
                                                                                    class="btn btn-warning btn-sm mr-1"
                                                                                    data-toggle="modal"
                                                                                    data-target="#guardarModalArea{{ $area->id_area_especializacion }}">
                                                                                    Guardar
                                                                                </button>
                                                                                <button type="button"
                                                                                    class="btn btn-danger btn-sm"
                                                                                    data-toggle="modal"
                                                                                    data-target="#eliminarModalArea{{ $area->id_area_especializacion }}">
                                                                                    Eliminar
                                                                                </button>
                                                                            </td>
                                                                        </form>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    @else
                                                        <p class="text-center text-muted mt-3">No hay registros para
                                                            mostrar.</p>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Modales para Áreas --}}
                                            @foreach ($areas as $area)
                                                <div class="modal fade"
                                                    id="guardarModalArea{{ $area->id_area_especializacion }}"
                                                    tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Confirmar Cambios</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Estás seguro de guardar los cambios en
                                                                <strong>{{ $area->nombre }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <button type="submit"
                                                                    form="formArea{{ $area->id_area_especializacion }}"
                                                                    class="btn btn-success">Guardar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade"
                                                    id="eliminarModalArea{{ $area->id_area_especializacion }}"
                                                    tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header1">
                                                                <h5 class="modal-title">Eliminar Área</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Seguro que deseas eliminar el área
                                                                <strong>{{ $area->nombre }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <form
                                                                    action="{{ route('catalogos.destroy', $area->id_area_especializacion) }}"
                                                                    method="POST" style="display:inline-block;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <input type="hidden" name="tabla"
                                                                        value="areas">
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Eliminar</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <div class="modal fade" id="agregarModalArea" tabindex="-1"
                                                role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Confirmar Agregar</h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal"><span>&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            ¿Estás seguro de agregar esta nueva área de especialización?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Cancelar</button>
                                                            <button type="submit" form="formAgregarArea"
                                                                class="btn btn-success">Agregar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- ================== DISCAPACIDADES ================== --}}
                                        <div class="tab-pane fade" id="discapacidades" role="tabpanel"
                                            aria-labelledby="discapacidades-tab">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4 class="mb-4">Discapacidades</h4>
                                                    <form id="filtrosFormDiscapacidades" method="GET"
                                                        action="{{ route('catalogos.index') }}"
                                                        class="d-flex align-items-center1 gap-3">
                                                        <input type="hidden" name="tabla"
                                                            value="discapacidades">
                                                        <div class="flex-grow-1" style="max-width: 400px;">
                                                            <input type="text" name="nombre_discapacidades"
                                                                class="form-control form-control-sm"
                                                                placeholder="🔍 Buscar por nombre"
                                                                value="{{ request('nombre_discapacidades') }}">
                                                        </div>
                                                        <button type="submit" class="btn btn-sm btn-primary px-3">
                                                            <i class="fas fa-search mr-1"></i> Buscar
                                                        </button>
                                                        <a href="{{ route('catalogos.index', ['tabla' => 'discapacidades']) }}"
                                                            class="btn btn-sm btn-outline-secondary px-3">
                                                            <i class="fas fa-list mr-1"></i>Mostrar todo
                                                        </a>
                                                    </form>

                                                    @if (count($discapacidades))
                                                        <div class="container mb-4 mt-4 d-flex justify-content-start">
                                                            <div
                                                                class="p-3 border rounded bg-light d-inline-block shadow-sm">
                                                                <form id="formAgregarDiscapacidad" method="POST"
                                                                    action="{{ route('catalogos.store') }}"
                                                                    class="form-inline mb-3">
                                                                    @csrf
                                                                    <input type="hidden" name="tabla"
                                                                        value="discapacidades">
                                                                    <div class="form-group mr-2 mb-2">
                                                                        <input type="text" name="nombre"
                                                                            class="form-control"
                                                                            placeholder="Nombre de la discapacidad"
                                                                            required minlength="3" maxlength="100">
                                                                    </div>
                                                                    <button type="button"
                                                                        class="btn btn-success mb-2"
                                                                        data-toggle="modal"
                                                                        data-target="#agregarModalDiscapacidad">
                                                                        Agregar
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>

                                                        <table class="table table-bordered table-hover">
                                                            <thead class="thead-dark text-center">
                                                                <tr>
                                                                    <th style="width: 80px;">ID</th>
                                                                    <th>Nombre</th>
                                                                    <th style="width: 150px;">Acciones</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($discapacidades as $discapacidad)
                                                                    <tr>
                                                                        <form
                                                                            id="formDiscapacidad{{ $discapacidad->id_discapacidad }}"
                                                                            method="POST"
                                                                            action="{{ route('catalogos.update', $discapacidad->id_discapacidad) }}">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <input type="hidden" name="tabla"
                                                                                value="discapacidades">
                                                                            <td class="text-center">
                                                                                {{ $discapacidad->id_discapacidad }}
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" name="nombre"
                                                                                    class="form-control"
                                                                                    value="{{ $discapacidad->nombre }}"
                                                                                    required minlength="3"
                                                                                    maxlength="100">
                                                                            </td>
                                                                            <td class="d-flex">
                                                                                <button type="button"
                                                                                    class="btn btn-warning btn-sm mr-1"
                                                                                    data-toggle="modal"
                                                                                    data-target="#guardarModalDiscapacidad{{ $discapacidad->id_discapacidad }}">
                                                                                    Guardar
                                                                                </button>
                                                                                <button type="button"
                                                                                    class="btn btn-danger btn-sm"
                                                                                    data-toggle="modal"
                                                                                    data-target="#eliminarModalDiscapacidad{{ $discapacidad->id_discapacidad }}">
                                                                                    Eliminar
                                                                                </button>
                                                                            </td>
                                                                        </form>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    @else
                                                        <p class="text-center text-muted mt-3">No hay registros para
                                                            mostrar.</p>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Modales para Discapacidades --}}
                                            @foreach ($discapacidades as $discapacidad)
                                                <div class="modal fade"
                                                    id="guardarModalDiscapacidad{{ $discapacidad->id_discapacidad }}"
                                                    tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header1">
                                                                <h5 class="modal-title">Confirmar Cambios</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Estás seguro de guardar los cambios en
                                                                <strong>{{ $discapacidad->nombre }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <button type="submit"
                                                                    form="formDiscapacidad{{ $discapacidad->id_discapacidad }}"
                                                                    class="btn btn-success">Guardar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade"
                                                    id="eliminarModalDiscapacidad{{ $discapacidad->id_discapacidad }}"
                                                    tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Eliminar Discapacidad</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Seguro que deseas eliminar la discapacidad
                                                                <strong>{{ $discapacidad->nombre }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <form
                                                                    action="{{ route('catalogos.destroy', $discapacidad->id_discapacidad) }}"
                                                                    method="POST" style="display:inline-block;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <input type="hidden" name="tabla"
                                                                        value="discapacidades">
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Eliminar</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <div class="modal fade" id="agregarModalDiscapacidad" tabindex="-1"
                                                role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Confirmar Agregar</h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal"><span>&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            ¿Estás seguro de agregar esta nueva discapacidad?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Cancelar</button>
                                                            <button type="submit" form="formAgregarDiscapacidad"
                                                                class="btn btn-success">Agregar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- ================== ESTADO CIVIL ================== --}}
                                        <div class="tab-pane fade" id="estadoCivil" role="tabpanel"
                                            aria-labelledby="estadoCivil-tab">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4 class="mb-4">Estados Civiles</h4>
                                                    <form id="filtrosFormEstadoCivil" method="GET"
                                                        action="{{ route('catalogos.index') }}"
                                                        class="d-flex align-items-center1 gap-3">
                                                        <input type="hidden" name="tabla" value="estadoCivil">
                                                        <div class="flex-grow-1" style="max-width: 400px;">
                                                            <input type="text" name="nombre_estado_civil"
                                                                class="form-control form-control-sm"
                                                                placeholder="🔍 Buscar por nombre"
                                                                value="{{ request('nombre_estado_civil') }}">
                                                        </div>
                                                        <button type="submit" class="btn btn-sm btn-primary px-3">
                                                            <i class="fas fa-search mr-1"></i> Buscar
                                                        </button>
                                                        <a href="{{ route('catalogos.index', ['tabla' => 'estadoCivil']) }}"
                                                            class="btn btn-sm btn-outline-secondary px-3">
                                                            <i class="fas fa-list mr-1"></i>Mostrar todo
                                                        </a>
                                                    </form>

                                                    @if (count($estadosCiviles))
                                                        <div class="container mb-4 mt-4 d-flex justify-content-start">
                                                            <div
                                                                class="p-3 border rounded bg-light d-inline-block shadow-sm">
                                                                <form id="formAgregarEstadoCivil" method="POST"
                                                                    action="{{ route('catalogos.store') }}"
                                                                    class="form-inline mb-3">
                                                                    @csrf
                                                                    <input type="hidden" name="tabla"
                                                                        value="estadoCivil">
                                                                    <div class="form-group mr-2 mb-2">
                                                                        <input type="text" name="nombre"
                                                                            class="form-control"
                                                                            placeholder="Estado civil" required
                                                                            minlength="3" maxlength="100">
                                                                    </div>
                                                                    <button type="button"
                                                                        class="btn btn-success mb-2"
                                                                        data-toggle="modal"
                                                                        data-target="#agregarModalEstadoCivil">
                                                                        Agregar
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>

                                                        <table class="table table-bordered table-hover">
                                                            <thead class="thead-dark text-center">
                                                                <tr>
                                                                    <th style="width: 80px;">ID</th>
                                                                    <th>Nombre</th>
                                                                    <th style="width: 150px;">Acciones</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($estadosCiviles as $estadoCivil)
                                                                    <tr>
                                                                        <form
                                                                            id="formEstadoCivil{{ $estadoCivil->id_estado_civil }}"
                                                                            method="POST"
                                                                            action="{{ route('catalogos.update', $estadoCivil->id_estado_civil) }}">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <input type="hidden" name="tabla"
                                                                                value="estadoCivil">
                                                                            <td class="text-center">
                                                                                {{ $estadoCivil->id_estado_civil }}
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" name="nombre"
                                                                                    class="form-control"
                                                                                    value="{{ $estadoCivil->nombre }}"
                                                                                    required minlength="3"
                                                                                    maxlength="100">
                                                                            </td>
                                                                            <td class="d-flex">
                                                                                <button type="button"
                                                                                    class="btn btn-warning btn-sm mr-1"
                                                                                    data-toggle="modal"
                                                                                    data-target="#guardarModalEstadoCivil{{ $estadoCivil->id_estado_civil }}">
                                                                                    Guardar
                                                                                </button>
                                                                                <button type="button"
                                                                                    class="btn btn-danger btn-sm"
                                                                                    data-toggle="modal"
                                                                                    data-target="#eliminarModalEstadoCivil{{ $estadoCivil->id_estado_civil }}">
                                                                                    Eliminar
                                                                                </button>
                                                                            </td>
                                                                        </form>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    @else
                                                        <p class="text-center text-muted mt-3">No hay registros para
                                                            mostrar.</p>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Modales para Estados Civiles --}}
                                            @foreach ($estadosCiviles as $estadoCivil)
                                                <div class="modal fade"
                                                    id="guardarModalEstadoCivil{{ $estadoCivil->id_estado_civil }}"
                                                    tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Confirmar Cambios</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Estás seguro de guardar los cambios en
                                                                <strong>{{ $estadoCivil->nombre }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <button type="submit"
                                                                    form="formEstadoCivil{{ $estadoCivil->id_estado_civil }}"
                                                                    class="btn btn-success">Guardar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade"
                                                    id="eliminarModalEstadoCivil{{ $estadoCivil->id_estado_civil }}"
                                                    tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header1">
                                                                <h5 class="modal-title">Eliminar Estado Civil</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Seguro que deseas eliminar el estado civil
                                                                <strong>{{ $estadoCivil->nombre }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <form
                                                                    action="{{ route('catalogos.destroy', $estadoCivil->id_estado_civil) }}"
                                                                    method="POST" style="display:inline-block;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <input type="hidden" name="tabla"
                                                                        value="estadoCivil">
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Eliminar</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <div class="modal fade" id="agregarModalEstadoCivil" tabindex="-1"
                                                role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Confirmar Agregar</h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal"><span>&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            ¿Estás seguro de agregar este nuevo estado civil?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Cancelar</button>
                                                            <button type="submit" form="formAgregarEstadoCivil"
                                                                class="btn btn-success">Agregar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- ================== GENERACIONES ================== --}}
                                        <div class="tab-pane fade" id="generaciones" role="tabpanel"
                                            aria-labelledby="generaciones-tab">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4 class="mb-4">Generaciones</h4>
                                                    <form id="filtrosFormGeneraciones" method="GET"
                                                        action="{{ route('catalogos.index') }}"
                                                        class="d-flex align-items-center1 gap-3">
                                                        <input type="hidden" name="tabla" value="generaciones">
                                                        <div class="flex-grow-1" style="max-width: 400px;">
                                                            <input type="text" name="nombre_generaciones"
                                                                class="form-control form-control-sm"
                                                                placeholder="🔍 Buscar por nombre"
                                                                value="{{ request('nombre_generaciones') }}">
                                                        </div>
                                                        <button type="submit" class="btn btn-sm btn-primary px-3">
                                                            <i class="fas fa-search mr-1"></i> Buscar
                                                        </button>
                                                        <a href="{{ route('catalogos.index', ['tabla' => 'generaciones']) }}"
                                                            class="btn btn-sm btn-outline-secondary px-3">
                                                            <i class="fas fa-list mr-1"></i>Mostrar todo
                                                        </a>
                                                    </form>

                                                    @if (count($generaciones))
                                                        <div class="container mb-4 mt-4 d-flex justify-content-start">
                                                            <div
                                                                class="p-3 border rounded bg-light d-inline-block shadow-sm">
                                                                <form id="formAgregarGeneracion" method="POST"
                                                                    action="{{ route('catalogos.store') }}"
                                                                    class="form-inline mb-3">
                                                                    @csrf
                                                                    <input type="hidden" name="tabla"
                                                                        value="generaciones">
                                                                    <div class="form-group mr-2 mb-2">
                                                                        <input type="text" name="nombre"
                                                                            class="form-control"
                                                                            placeholder="Nombre de la generación"
                                                                            required minlength="3" maxlength="100">
                                                                    </div>
                                                                    <button type="button"
                                                                        class="btn btn-success mb-2"
                                                                        data-toggle="modal"
                                                                        data-target="#agregarModalGeneracion">
                                                                        Agregar
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>

                                                        <table class="table table-bordered table-hover">
                                                            <thead class="thead-dark text-center">
                                                                <tr>
                                                                    <th style="width: 80px;">ID</th>
                                                                    <th>Nombre</th>
                                                                    <th style="width: 150px;">Acciones</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($generaciones as $generacion)
                                                                    <tr>
                                                                        <form
                                                                            id="formGeneracion{{ $generacion->id_generacion }}"
                                                                            method="POST"
                                                                            action="{{ route('catalogos.update', $generacion->id_generacion) }}">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <input type="hidden" name="tabla"
                                                                                value="generaciones">
                                                                            <td class="text-center">
                                                                                {{ $generacion->id_generacion }}</td>
                                                                            <td>
                                                                                <input type="text" name="nombre"
                                                                                    class="form-control"
                                                                                    value="{{ $generacion->nombre }}"
                                                                                    required minlength="3"
                                                                                    maxlength="100">
                                                                            </td>
                                                                            <td class="d-flex">
                                                                                <button type="button"
                                                                                    class="btn btn-warning btn-sm mr-1"
                                                                                    data-toggle="modal"
                                                                                    data-target="#guardarModalGeneracion{{ $generacion->id_generacion }}">
                                                                                    Guardar
                                                                                </button>
                                                                                <button type="button"
                                                                                    class="btn btn-danger btn-sm"
                                                                                    data-toggle="modal"
                                                                                    data-target="#eliminarModalGeneracion{{ $generacion->id_generacion }}">
                                                                                    Eliminar
                                                                                </button>
                                                                            </td>
                                                                        </form>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    @else
                                                        <p class="text-center text-muted mt-3">No hay registros para
                                                            mostrar.</p>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Modales para Generaciones --}}
                                            @foreach ($generaciones as $generacion)
                                                <div class="modal fade"
                                                    id="guardarModalGeneracion{{ $generacion->id_generacion }}"
                                                    tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Confirmar Cambios</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Estás seguro de guardar los cambios en
                                                                <strong>{{ $generacion->nombre }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <button type="submit"
                                                                    form="formGeneracion{{ $generacion->id_generacion }}"
                                                                    class="btn btn-success">Guardar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade"
                                                    id="eliminarModalGeneracion{{ $generacion->id_generacion }}"
                                                    tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header1">
                                                                <h5 class="modal-title">Eliminar Generación</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Seguro que deseas eliminar la generación
                                                                <strong>{{ $generacion->nombre }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <form
                                                                    action="{{ route('catalogos.destroy', $generacion->id_generacion) }}"
                                                                    method="POST" style="display:inline-block;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <input type="hidden" name="tabla"
                                                                        value="generaciones">
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Eliminar</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <div class="modal fade" id="agregarModalGeneracion" tabindex="-1"
                                                role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Confirmar Agregar</h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal"><span>&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            ¿Estás seguro de agregar esta nueva generación?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Cancelar</button>
                                                            <button type="submit" form="formAgregarGeneracion"
                                                                class="btn btn-success">Agregar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- ================== GÉNEROS ================== --}}
                                        <div class="tab-pane fade" id="generos" role="tabpanel"
                                            aria-labelledby="generos-tab">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4 class="mb-4">Géneros</h4>
                                                    <form id="filtrosFormGeneros" method="GET"
                                                        action="{{ route('catalogos.index') }}"
                                                        class="d-flex align-items-center1 gap-3">
                                                        <input type="hidden" name="tabla" value="generos">
                                                        <div class="flex-grow-1" style="max-width: 400px;">
                                                            <input type="text" name="nombre_generos"
                                                                class="form-control form-control-sm"
                                                                placeholder="🔍 Buscar por nombre"
                                                                value="{{ request('nombre_generos') }}">
                                                        </div>
                                                        <button type="submit" class="btn btn-sm btn-primary px-3">
                                                            <i class="fas fa-search mr-1"></i> Buscar
                                                        </button>
                                                        <a href="{{ route('catalogos.index', ['tabla' => 'generos']) }}"
                                                            class="btn btn-sm btn-outline-secondary px-3">
                                                            <i class="fas fa-list mr-1"></i>Mostrar todo
                                                        </a>
                                                    </form>

                                                    @if (count($generos))
                                                        <div class="container mb-4 mt-4 d-flex justify-content-start">
                                                            <div
                                                                class="p-3 border rounded bg-light d-inline-block shadow-sm">
                                                                <form id="formAgregarGenero" method="POST"
                                                                    action="{{ route('catalogos.store') }}"
                                                                    class="form-inline mb-3">
                                                                    @csrf
                                                                    <input type="hidden" name="tabla"
                                                                        value="generos">
                                                                    <div class="form-group mr-2 mb-2">
                                                                        <input type="text" name="nombre"
                                                                            class="form-control"
                                                                            placeholder="Nombre del género" required
                                                                            minlength="3" maxlength="100">
                                                                    </div>
                                                                    <button type="button"
                                                                        class="btn btn-success mb-2"
                                                                        data-toggle="modal"
                                                                        data-target="#agregarModalGenero">
                                                                        Agregar
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>

                                                        <table class="table table-bordered table-hover">
                                                            <thead class="thead-dark text-center">
                                                                <tr>
                                                                    <th style="width: 80px;">ID</th>
                                                                    <th>Nombre</th>
                                                                    <th style="width: 150px;">Acciones</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($generos as $genero)
                                                                    <tr>
                                                                        <form
                                                                            id="formGenero{{ $genero->id_genero }}"
                                                                            method="POST"
                                                                            action="{{ route('catalogos.update', $genero->id_genero) }}">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <input type="hidden" name="tabla"
                                                                                value="generos">
                                                                            <td class="text-center">
                                                                                {{ $genero->id_genero }}</td>
                                                                            <td>
                                                                                <input type="text" name="nombre"
                                                                                    class="form-control"
                                                                                    value="{{ $genero->nombre }}"
                                                                                    required minlength="3"
                                                                                    maxlength="100">
                                                                            </td>
                                                                            <td class="d-flex">
                                                                                <button type="button"
                                                                                    class="btn btn-warning btn-sm mr-1"
                                                                                    data-toggle="modal"
                                                                                    data-target="#guardarModalGenero{{ $genero->id_genero }}">
                                                                                    Guardar
                                                                                </button>
                                                                                <button type="button"
                                                                                    class="btn btn-danger btn-sm"
                                                                                    data-toggle="modal"
                                                                                    data-target="#eliminarModalGenero{{ $genero->id_genero }}">
                                                                                    Eliminar
                                                                                </button>
                                                                            </td>
                                                                        </form>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    @else
                                                        <p class="text-center text-muted mt-3">No hay registros para
                                                            mostrar.</p>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Modales para Géneros --}}
                                            @foreach ($generos as $genero)
                                                <div class="modal fade"
                                                    id="guardarModalGenero{{ $genero->id_genero }}" tabindex="-1"
                                                    role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Confirmar Cambios</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Estás seguro de guardar los cambios en
                                                                <strong>{{ $genero->nombre }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <button type="submit"
                                                                    form="formGenero{{ $genero->id_genero }}"
                                                                    class="btn btn-success">Guardar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade"
                                                    id="eliminarModalGenero{{ $genero->id_genero }}"
                                                    tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header1">
                                                                <h5 class="modal-title">Eliminar Género</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Seguro que deseas eliminar el género
                                                                <strong>{{ $genero->nombre }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <form
                                                                    action="{{ route('catalogos.destroy', $genero->id_genero) }}"
                                                                    method="POST" style="display:inline-block;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <input type="hidden" name="tabla"
                                                                        value="generos">
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Eliminar</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <div class="modal fade" id="agregarModalGenero" tabindex="-1"
                                                role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Confirmar Agregar</h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal"><span>&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            ¿Estás seguro de agregar este nuevo género?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Cancelar</button>
                                                            <button type="submit" form="formAgregarGenero"
                                                                class="btn btn-success">Agregar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- ================== HISTORIAL STATUS ================== --}}
                                        <div class="tab-pane fade" id="historialStatus" role="tabpanel"
                                            aria-labelledby="historialStatus-tab">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4 class="mb-4">Historial de Status</h4>
                                                    <form id="filtrosFormHistorialStatus" method="GET"
                                                        action="{{ route('catalogos.index') }}"
                                                        class="d-flex align-items-center1 gap-3">
                                                        <input type="hidden" name="tabla"
                                                            value="historialStatus">
                                                        <div class="flex-grow-1" style="max-width: 400px;">
                                                            <input type="text" name="nombre_historial_status"
                                                                class="form-control form-control-sm"
                                                                placeholder="🔍 Buscar por nombre"
                                                                value="{{ request('nombre_historial_status') }}">
                                                        </div>
                                                        <button type="submit" class="btn btn-sm btn-primary px-3">
                                                            <i class="fas fa-search mr-1"></i> Buscar
                                                        </button>
                                                        <a href="{{ route('catalogos.index', ['tabla' => 'historialStatus']) }}"
                                                            class="btn btn-sm btn-outline-secondary px-3">
                                                            <i class="fas fa-list mr-1"></i>Mostrar todo
                                                        </a>
                                                    </form>

                                                    @if (count($historialStatus))
                                                        <div class="container mb-4 mt-4 d-flex justify-content-start">
                                                            <div
                                                                class="p-3 border rounded bg-light d-inline-block shadow-sm">
                                                                <form id="formAgregarHistorialStatus" method="POST"
                                                                    action="{{ route('catalogos.store') }}"
                                                                    class="form-inline mb-3">
                                                                    @csrf
                                                                    <input type="hidden" name="tabla"
                                                                        value="historialStatus">
                                                                    <div class="form-group mr-2 mb-2">
                                                                        <input type="text" name="nombre"
                                                                            class="form-control"
                                                                            placeholder="Nombre" required
                                                                            minlength="3" maxlength="100">
                                                                    </div>
                                                                    <div class="form-group mr-2 mb-2">
                                                                        <input type="text" name="incorporacion"
                                                                            class="form-control"
                                                                            placeholder="Incorporación" required
                                                                            minlength="3" maxlength="100">
                                                                    </div>
                                                                    <button type="button"
                                                                        class="btn btn-success mb-2"
                                                                        data-toggle="modal"
                                                                        data-target="#agregarModalHistorialStatus">
                                                                        Agregar
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>

                                                        <table class="table table-bordered table-hover">
                                                            <thead class="thead-dark text-center">
                                                                <tr>
                                                                    <th style="width: 80px;">ID</th>
                                                                    <th>Nombre</th>
                                                                    <th>Incorporación</th>
                                                                    <th style="width: 150px;">Acciones</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($historialStatus as $historial)
                                                                    <tr>
                                                                        <form
                                                                            id="formHistorialStatus{{ $historial->id_historial_status }}"
                                                                            method="POST"
                                                                            action="{{ route('catalogos.update', $historial->id_historial_status) }}">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <input type="hidden" name="tabla"
                                                                                value="historialStatus">
                                                                            <td class="text-center">
                                                                                {{ $historial->id_historial_status }}
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" name="nombre"
                                                                                    class="form-control"
                                                                                    value="{{ $historial->nombre }}"
                                                                                    required minlength="3"
                                                                                    maxlength="100">
                                                                            </td>
                                                                            <td>
                                                                                <input type="text"
                                                                                    name="incorporacion"
                                                                                    class="form-control"
                                                                                    value="{{ $historial->incorporacion }}"
                                                                                    required minlength="3"
                                                                                    maxlength="100">
                                                                            </td>
                                                                            <td class="d-flex">
                                                                                <button type="button"
                                                                                    class="btn btn-warning btn-sm mr-1"
                                                                                    data-toggle="modal"
                                                                                    data-target="#guardarModalHistorialStatus{{ $historial->id_historial_status }}">
                                                                                    Guardar
                                                                                </button>
                                                                                <button type="button"
                                                                                    class="btn btn-danger btn-sm"
                                                                                    data-toggle="modal"
                                                                                    data-target="#eliminarModalHistorialStatus{{ $historial->id_historial_status }}">
                                                                                    Eliminar
                                                                                </button>
                                                                            </td>
                                                                        </form>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    @else
                                                        <p class="text-center text-muted mt-3">No hay registros para
                                                            mostrar.</p>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Modales para Historial Status --}}
                                            @foreach ($historialStatus as $historial)
                                                <div class="modal fade"
                                                    id="guardarModalHistorialStatus{{ $historial->id_historial_status }}"
                                                    tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Confirmar Cambios</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Estás seguro de guardar los cambios en
                                                                <strong>{{ $historial->nombre }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <button type="submit"
                                                                    form="formHistorialStatus{{ $historial->id_historial_status }}"
                                                                    class="btn btn-success">Guardar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade"
                                                    id="eliminarModalHistorialStatus{{ $historial->id_historial_status }}"
                                                    tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header1">
                                                                <h5 class="modal-title">Eliminar Historial Status</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Seguro que deseas eliminar el historial status
                                                                <strong>{{ $historial->nombre }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <form
                                                                    action="{{ route('catalogos.destroy', $historial->id_historial_status) }}"
                                                                    method="POST" style="display:inline-block;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <input type="hidden" name="tabla"
                                                                        value="historialStatus">
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Eliminar</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <div class="modal fade" id="agregarModalHistorialStatus"
                                                tabindex="-1" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Confirmar Agregar</h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal"><span>&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            ¿Estás seguro de agregar este nuevo historial status?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Cancelar</button>
                                                            <button type="submit" form="formAgregarHistorialStatus"
                                                                class="btn btn-success">Agregar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- ================== MODALIDADES ================== --}}
                                        <div class="tab-pane fade" id="modalidades" role="tabpanel"
                                            aria-labelledby="modalidades-tab">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4 class="mb-4">Tipos de Modalidades</h4>
                                                    <form id="filtrosFormModalidades" method="GET"
                                                        action="{{ route('catalogos.index') }}"
                                                        class="d-flex align-items-center1 gap-3">
                                                        <input type="hidden" name="tabla" value="modalidades">
                                                        <div class="flex-grow-1" style="max-width: 400px;">
                                                            <input type="text" name="nombre_modalidades"
                                                                class="form-control form-control-sm"
                                                                placeholder="🔍 Buscar por nombre"
                                                                value="{{ request('nombre_modalidades') }}">
                                                        </div>
                                                        <button type="submit" class="btn btn-sm btn-primary px-3">
                                                            <i class="fas fa-search mr-1"></i> Buscar
                                                        </button>
                                                        <a href="{{ route('catalogos.index', ['tabla' => 'modalidades']) }}"
                                                            class="btn btn-sm btn-outline-secondary px-3">
                                                            <i class="fas fa-list mr-1"></i>Mostrar todo
                                                        </a>
                                                    </form>

                                                    @if (count($modalidades))
                                                        <div class="container mb-4 mt-4 d-flex justify-content-start">
                                                            <div
                                                                class="p-3 border rounded bg-light d-inline-block shadow-sm">
                                                                <form id="formAgregarModalidad" method="POST"
                                                                    action="{{ route('catalogos.store') }}"
                                                                    class="form-inline mb-3">
                                                                    @csrf
                                                                    <input type="hidden" name="tabla"
                                                                        value="modalidades">
                                                                    <div class="form-group mr-2 mb-2">
                                                                        <input type="text" name="nombre"
                                                                            class="form-control"
                                                                            placeholder="Nombre de la modalidad"
                                                                            required minlength="3" maxlength="100">
                                                                    </div>
                                                                    <button type="button"
                                                                        class="btn btn-success mb-2"
                                                                        data-toggle="modal"
                                                                        data-target="#agregarModalModalidad">
                                                                        Agregar
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>

                                                        <table class="table table-bordered table-hover">
                                                            <thead class="thead-dark text-center">
                                                                <tr>
                                                                    <th style="width: 80px;">ID</th>
                                                                    <th>Nombre</th>
                                                                    <th style="width: 150px;">Acciones</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($modalidades as $modalidad)
                                                                    <tr>
                                                                        <form
                                                                            id="formModalidad{{ $modalidad->id_modalidad }}"
                                                                            method="POST"
                                                                            action="{{ route('catalogos.update', $modalidad->id_modalidad) }}">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <input type="hidden" name="tabla"
                                                                                value="modalidades">
                                                                            <td class="text-center">
                                                                                {{ $modalidad->id_modalidad }}</td>
                                                                            <td>
                                                                                <input type="text" name="nombre"
                                                                                    class="form-control"
                                                                                    value="{{ $modalidad->nombre }}"
                                                                                    required minlength="3"
                                                                                    maxlength="100">
                                                                            </td>
                                                                            <td class="d-flex">
                                                                                <button type="button"
                                                                                    class="btn btn-warning btn-sm mr-1"
                                                                                    data-toggle="modal"
                                                                                    data-target="#guardarModalModalidad{{ $modalidad->id_modalidad }}">
                                                                                    Guardar
                                                                                </button>
                                                                                <button type="button"
                                                                                    class="btn btn-danger btn-sm"
                                                                                    data-toggle="modal"
                                                                                    data-target="#eliminarModalModalidad{{ $modalidad->id_modalidad }}">
                                                                                    Eliminar
                                                                                </button>
                                                                            </td>
                                                                        </form>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    @else
                                                        <p class="text-center text-muted mt-3">No hay registros para
                                                            mostrar.</p>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Modales para Modalidades --}}
                                            @foreach ($modalidades as $modalidad)
                                                <div class="modal fade"
                                                    id="guardarModalModalidad{{ $modalidad->id_modalidad }}"
                                                    tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Confirmar Cambios</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Estás seguro de guardar los cambios en
                                                                <strong>{{ $modalidad->nombre }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <button type="submit"
                                                                    form="formModalidad{{ $modalidad->id_modalidad }}"
                                                                    class="btn btn-success">Guardar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade"
                                                    id="eliminarModalModalidad{{ $modalidad->id_modalidad }}"
                                                    tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header1">
                                                                <h5 class="modal-title">Eliminar Modalidad</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Seguro que deseas eliminar la modalidad
                                                                <strong>{{ $modalidad->nombre }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <form
                                                                    action="{{ route('catalogos.destroy', $modalidad->id_modalidad) }}"
                                                                    method="POST" style="display:inline-block;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <input type="hidden" name="tabla"
                                                                        value="modalidades">
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Eliminar</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <div class="modal fade" id="agregarModalModalidad" tabindex="-1"
                                                role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Confirmar Agregar</h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal"><span>&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            ¿Estás seguro de agregar esta nueva modalidad?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Cancelar</button>
                                                            <button type="submit" form="formAgregarModalidad"
                                                                class="btn btn-success">Agregar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- ================== PARENTESCOS ================== --}}
                                        <div class="tab-pane fade" id="parentescos" role="tabpanel"
                                            aria-labelledby="parentescos-tab">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4 class="mb-4">Parentescos</h4>
                                                    <form id="filtrosFormParentescos" method="GET"
                                                        action="{{ route('catalogos.index') }}"
                                                        class="d-flex align-items-center1 gap-3">
                                                        <input type="hidden" name="tabla" value="parentescos">
                                                        <div class="flex-grow-1" style="max-width: 400px;">
                                                            <input type="text" name="nombre_parentescos"
                                                                class="form-control form-control-sm"
                                                                placeholder="🔍 Buscar por nombre"
                                                                value="{{ request('nombre_parentescos') }}">
                                                        </div>
                                                        <button type="submit" class="btn btn-sm btn-primary px-3">
                                                            <i class="fas fa-search mr-1"></i> Buscar
                                                        </button>
                                                        <a href="{{ route('catalogos.index', ['tabla' => 'parentescos']) }}"
                                                            class="btn btn-sm btn-outline-secondary px-3">
                                                            <i class="fas fa-list mr-1"></i>Mostrar todo
                                                        </a>
                                                    </form>

                                                    @if (count($parentescos))
                                                        <div class="container mb-4 mt-4 d-flex justify-content-start">
                                                            <div
                                                                class="p-3 border rounded bg-light d-inline-block shadow-sm">
                                                                <form id="formAgregarParentesco" method="POST"
                                                                    action="{{ route('catalogos.store') }}"
                                                                    class="form-inline mb-3">
                                                                    @csrf
                                                                    <input type="hidden" name="tabla"
                                                                        value="parentescos">
                                                                    <div class="form-group mr-2 mb-2">
                                                                        <input type="text" name="nombre"
                                                                            class="form-control"
                                                                            placeholder="Nombre del parentesco"
                                                                            required minlength="3" maxlength="100">
                                                                    </div>
                                                                    <button type="button"
                                                                        class="btn btn-success mb-2"
                                                                        data-toggle="modal"
                                                                        data-target="#agregarModalParentesco">
                                                                        Agregar
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>

                                                        <table class="table table-bordered table-hover">
                                                            <thead class="thead-dark text-center">
                                                                <tr>
                                                                    <th style="width: 80px;">ID</th>
                                                                    <th>Nombre</th>
                                                                    <th style="width: 150px;">Acciones</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($parentescos as $parentesco)
                                                                    <tr>
                                                                        <form
                                                                            id="formParentesco{{ $parentesco->id_parentesco }}"
                                                                            method="POST"
                                                                            action="{{ route('catalogos.update', $parentesco->id_parentesco) }}">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <input type="hidden" name="tabla"
                                                                                value="parentescos">
                                                                            <td class="text-center">
                                                                                {{ $parentesco->id_parentesco }}</td>
                                                                            <td>
                                                                                <input type="text" name="nombre"
                                                                                    class="form-control"
                                                                                    value="{{ $parentesco->nombre }}"
                                                                                    required minlength="3"
                                                                                    maxlength="100">
                                                                            </td>
                                                                            <td class="d-flex">
                                                                                <button type="button"
                                                                                    class="btn btn-warning btn-sm mr-1"
                                                                                    data-toggle="modal"
                                                                                    data-target="#guardarModalParentesco{{ $parentesco->id_parentesco }}">
                                                                                    Guardar
                                                                                </button>
                                                                                <button type="button"
                                                                                    class="btn btn-danger btn-sm"
                                                                                    data-toggle="modal"
                                                                                    data-target="#eliminarModalParentesco{{ $parentesco->id_parentesco }}">
                                                                                    Eliminar
                                                                                </button>
                                                                            </td>
                                                                        </form>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    @else
                                                        <p class="text-center text-muted mt-3">No hay registros para
                                                            mostrar.</p>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Modales para Parentescos --}}
                                            @foreach ($parentescos as $parentesco)
                                                <div class="modal fade"
                                                    id="guardarModalParentesco{{ $parentesco->id_parentesco }}"
                                                    tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Confirmar Cambios</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Estás seguro de guardar los cambios en
                                                                <strong>{{ $parentesco->nombre }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <button type="submit"
                                                                    form="formParentesco{{ $parentesco->id_parentesco }}"
                                                                    class="btn btn-success">Guardar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade"
                                                    id="eliminarModalParentesco{{ $parentesco->id_parentesco }}"
                                                    tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header1">
                                                                <h5 class="modal-title">Eliminar Parentesco</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Seguro que deseas eliminar el parentesco
                                                                <strong>{{ $parentesco->nombre }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <form
                                                                    action="{{ route('catalogos.destroy', $parentesco->id_parentesco) }}"
                                                                    method="POST" style="display:inline-block;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <input type="hidden" name="tabla"
                                                                        value="parentescos">
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Eliminar</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <div class="modal fade" id="agregarModalParentesco" tabindex="-1"
                                                role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Confirmar Agregar</h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal"><span>&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            ¿Estás seguro de agregar este nuevo parentesco?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Cancelar</button>
                                                            <button type="submit" form="formAgregarParentesco"
                                                                class="btn btn-success">Agregar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- ================== ROLES ================== --}}
                                        <div class="tab-pane fade" id="roles" role="tabpanel"
                                            aria-labelledby="roles-tab">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4 class="mb-4">Roles del Sistema</h4>
                                                    <form id="filtrosFormRoles" method="GET"
                                                        action="{{ route('catalogos.index') }}"
                                                        class="d-flex align-items-center1 gap-3">
                                                        <input type="hidden" name="tabla" value="roles">
                                                        <div class="flex-grow-1" style="max-width: 400px;">
                                                            <input type="text" name="nombre_roles"
                                                                class="form-control form-control-sm"
                                                                placeholder="🔍 Buscar por nombre"
                                                                value="{{ request('nombre_roles') }}">
                                                        </div>
                                                        <button type="submit" class="btn btn-sm btn-primary px-3">
                                                            <i class="fas fa-search mr-1"></i> Buscar
                                                        </button>
                                                        <a href="{{ route('catalogos.index', ['tabla' => 'roles']) }}"
                                                            class="btn btn-sm btn-outline-secondary px-3">
                                                            <i class="fas fa-list mr-1"></i>Mostrar todo
                                                        </a>
                                                    </form>

                                                    @if (count($roles))
                                                        <div class="container mb-4 mt-4 d-flex justify-content-start">
                                                            <div
                                                                class="p-3 border rounded bg-light d-inline-block shadow-sm">
                                                                <form id="formAgregarRol" method="POST"
                                                                    action="{{ route('catalogos.store') }}"
                                                                    class="form-inline mb-3">
                                                                    @csrf
                                                                    <input type="hidden" name="tabla"
                                                                        value="roles">
                                                                    <div class="form-group mr-2 mb-2">
                                                                        <input type="text" name="nombre"
                                                                            class="form-control"
                                                                            placeholder="Nombre del rol" required
                                                                            minlength="3" maxlength="100">
                                                                    </div>
                                                                    <button type="button"
                                                                        class="btn btn-success mb-2"
                                                                        data-toggle="modal"
                                                                        data-target="#agregarModalRol">
                                                                        Agregar
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>

                                                        <table class="table table-bordered table-hover">
                                                            <thead class="thead-dark text-center">
                                                                <tr>
                                                                    <th style="width: 80px;">ID</th>
                                                                    <th>Nombre</th>
                                                                    <th style="width: 150px;">Acciones</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($roles as $rol)
                                                                    <tr>
                                                                        <form id="formRol{{ $rol->id_rol }}"
                                                                            method="POST"
                                                                            action="{{ route('catalogos.update', $rol->id_rol) }}">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <input type="hidden" name="tabla"
                                                                                value="roles">
                                                                            <td class="text-center">
                                                                                {{ $rol->id_rol }}</td>
                                                                            <td>
                                                                                <input type="text" name="nombre"
                                                                                    class="form-control"
                                                                                    value="{{ $rol->nombre }}"
                                                                                    required minlength="3"
                                                                                    maxlength="100">
                                                                            </td>
                                                                            <td class="d-flex">
                                                                                <button type="button"
                                                                                    class="btn btn-warning btn-sm mr-1"
                                                                                    data-toggle="modal"
                                                                                    data-target="#guardarModalRol{{ $rol->id_rol }}">
                                                                                    Guardar
                                                                                </button>
                                                                                <button type="button"
                                                                                    class="btn btn-danger btn-sm"
                                                                                    data-toggle="modal"
                                                                                    data-target="#eliminarModalRol{{ $rol->id_rol }}">
                                                                                    Eliminar
                                                                                </button>
                                                                            </td>
                                                                        </form>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    @else
                                                        <p class="text-center text-muted mt-3">No hay registros para
                                                            mostrar.</p>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Modales para Roles --}}
                                            @foreach ($roles as $rol)
                                                <div class="modal fade" id="guardarModalRol{{ $rol->id_rol }}"
                                                    tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Confirmar Cambios</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Estás seguro de guardar los cambios en
                                                                <strong>{{ $rol->nombre }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <button type="submit"
                                                                    form="formRol{{ $rol->id_rol }}"
                                                                    class="btn btn-success">Guardar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade" id="eliminarModalRol{{ $rol->id_rol }}"
                                                    tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header1">
                                                                <h5 class="modal-title">Eliminar Rol</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Seguro que deseas eliminar el rol
                                                                <strong>{{ $rol->nombre }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <form
                                                                    action="{{ route('catalogos.destroy', $rol->id_rol) }}"
                                                                    method="POST" style="display:inline-block;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <input type="hidden" name="tabla"
                                                                        value="roles">
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Eliminar</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <div class="modal fade" id="agregarModalRol" tabindex="-1"
                                                role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Confirmar Agregar</h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal"><span>&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            ¿Estás seguro de agregar este nuevo rol?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Cancelar</button>
                                                            <button type="submit" form="formAgregarRol"
                                                                class="btn btn-success">Agregar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- ================== TIPOS DE SANGRE ================== --}}
                                        <div class="tab-pane fade" id="tiposSangre" role="tabpanel"
                                            aria-labelledby="tiposSangre-tab">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4 class="mb-4">Tipos de Sangre</h4>
                                                    <form id="filtrosFormTiposSangre" method="GET"
                                                        action="{{ route('catalogos.index') }}"
                                                        class="d-flex align-items-center1 gap-3">
                                                        <input type="hidden" name="tabla" value="tiposSangre">
                                                        <div class="flex-grow-1" style="max-width: 400px;">
                                                            <input type="text" name="nombre_tipos_sangre"
                                                                class="form-control form-control-sm"
                                                                placeholder="🔍 Buscar por nombre"
                                                                value="{{ request('nombre_tipos_sangre') }}">
                                                        </div>
                                                        <button type="submit" class="btn btn-sm btn-primary px-3">
                                                            <i class="fas fa-search mr-1"></i> Buscar
                                                        </button>
                                                        <a href="{{ route('catalogos.index', ['tabla' => 'tiposSangre']) }}"
                                                            class="btn btn-sm btn-outline-secondary px-3">
                                                            <i class="fas fa-list mr-1"></i>Mostrar todo
                                                        </a>
                                                    </form>

                                                    @if (count($tiposSangre))
                                                        <div class="container mb-4 mt-4 d-flex justify-content-start">
                                                            <div
                                                                class="p-3 border rounded bg-light d-inline-block shadow-sm">
                                                                <form id="formAgregarTipoSangre" method="POST"
                                                                    action="{{ route('catalogos.store') }}"
                                                                    class="form-inline mb-3">
                                                                    @csrf
                                                                    <input type="hidden" name="tabla"
                                                                        value="tiposSangre">
                                                                    <div class="form-group mr-2 mb-2">
                                                                        <input type="text" name="nombre"
                                                                            class="form-control"
                                                                            placeholder="Tipo de sangre (Ej: A+, O-)"
                                                                            required minlength="2" maxlength="10">
                                                                    </div>
                                                                    <button type="button"
                                                                        class="btn btn-success mb-2"
                                                                        data-toggle="modal"
                                                                        data-target="#agregarModalTipoSangre">
                                                                        Agregar
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>

                                                        <table class="table table-bordered table-hover">
                                                            <thead class="thead-dark text-center">
                                                                <tr>
                                                                    <th style="width: 80px;">ID</th>
                                                                    <th>Nombre</th>
                                                                    <th style="width: 150px;">Acciones</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($tiposSangre as $tipoSangre)
                                                                    <tr>
                                                                        <form
                                                                            id="formTipoSangre{{ $tipoSangre->id_tipo_sangre }}"
                                                                            method="POST"
                                                                            action="{{ route('catalogos.update', $tipoSangre->id_tipo_sangre) }}">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <input type="hidden" name="tabla"
                                                                                value="tiposSangre">
                                                                            <td class="text-center">
                                                                                {{ $tipoSangre->id_tipo_sangre }}</td>
                                                                            <td>
                                                                                <input type="text" name="nombre"
                                                                                    class="form-control"
                                                                                    value="{{ $tipoSangre->nombre }}"
                                                                                    required minlength="2"
                                                                                    maxlength="10">
                                                                            </td>
                                                                            <td class="d-flex">
                                                                                <button type="button"
                                                                                    class="btn btn-warning btn-sm mr-1"
                                                                                    data-toggle="modal"
                                                                                    data-target="#guardarModalTipoSangre{{ $tipoSangre->id_tipo_sangre }}">
                                                                                    Guardar
                                                                                </button>
                                                                                <button type="button"
                                                                                    class="btn btn-danger btn-sm"
                                                                                    data-toggle="modal"
                                                                                    data-target="#eliminarModalTipoSangre{{ $tipoSangre->id_tipo_sangre }}">
                                                                                    Eliminar
                                                                                </button>
                                                                            </td>
                                                                        </form>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    @else
                                                        <p class="text-center text-muted mt-3">No hay registros para
                                                            mostrar.</p>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Modales para Tipos de Sangre --}}
                                            @foreach ($tiposSangre as $tipoSangre)
                                                <div class="modal fade"
                                                    id="guardarModalTipoSangre{{ $tipoSangre->id_tipo_sangre }}"
                                                    tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Confirmar Cambios</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Estás seguro de guardar los cambios en
                                                                <strong>{{ $tipoSangre->nombre }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <button type="submit"
                                                                    form="formTipoSangre{{ $tipoSangre->id_tipo_sangre }}"
                                                                    class="btn btn-success">Guardar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade"
                                                    id="eliminarModalTipoSangre{{ $tipoSangre->id_tipo_sangre }}"
                                                    tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header1">
                                                                <h5 class="modal-title">Eliminar Tipo de Sangre</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Seguro que deseas eliminar el tipo de sangre
                                                                <strong>{{ $tipoSangre->nombre }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <form
                                                                    action="{{ route('catalogos.destroy', $tipoSangre->id_tipo_sangre) }}"
                                                                    method="POST" style="display:inline-block;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <input type="hidden" name="tabla"
                                                                        value="tiposSangre">
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Eliminar</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <div class="modal fade" id="agregarModalTipoSangre" tabindex="-1"
                                                role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Confirmar Agregar</h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal"><span>&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            ¿Estás seguro de agregar este nuevo tipo de sangre?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Cancelar</button>
                                                            <button type="submit" form="formAgregarTipoSangre"
                                                                class="btn btn-success">Agregar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- ================== TURNOS ================== --}}
                                        <div class="tab-pane fade" id="turnos" role="tabpanel"
                                            aria-labelledby="turnos-tab">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4 class="mb-4">Turnos Escolares</h4>
                                                    <form id="filtrosFormTurnos" method="GET"
                                                        action="{{ route('catalogos.index') }}"
                                                        class="d-flex align-items-center1 gap-3">
                                                        <input type="hidden" name="tabla" value="turnos">
                                                        <div class="flex-grow-1" style="max-width: 400px;">
                                                            <input type="text" name="nombre_turnos"
                                                                class="form-control form-control-sm"
                                                                placeholder="🔍 Buscar por nombre"
                                                                value="{{ request('nombre_turnos') }}">
                                                        </div>
                                                        <button type="submit" class="btn btn-sm btn-primary px-3">
                                                            <i class="fas fa-search mr-1"></i> Buscar
                                                        </button>
                                                        <a href="{{ route('catalogos.index', ['tabla' => 'turnos']) }}"
                                                            class="btn btn-sm btn-outline-secondary px-3">
                                                            <i class="fas fa-list mr-1"></i>Mostrar todo
                                                        </a>
                                                    </form>

                                                    @if (count($turnos))
                                                        <div class="container mb-4 mt-4 d-flex justify-content-start">
                                                            <div
                                                                class="p-3 border rounded bg-light d-inline-block shadow-sm">
                                                                <form id="formAgregarTurno" method="POST"
                                                                    action="{{ route('catalogos.store') }}"
                                                                    class="form-inline mb-3">
                                                                    @csrf
                                                                    <input type="hidden" name="tabla"
                                                                        value="turnos">
                                                                    <div class="form-group mr-2 mb-2">
                                                                        <input type="text" name="nombre"
                                                                            class="form-control"
                                                                            placeholder="Nombre del turno (Ej: Matutino, Vespertino)"
                                                                            required minlength="3" maxlength="100">
                                                                    </div>
                                                                    <button type="button"
                                                                        class="btn btn-success mb-2"
                                                                        data-toggle="modal"
                                                                        data-target="#agregarModalTurno">
                                                                        Agregar
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>

                                                        <table class="table table-bordered table-hover">
                                                            <thead class="thead-dark text-center">
                                                                <tr>
                                                                    <th style="width: 80px;">ID</th>
                                                                    <th>Nombre</th>
                                                                    <th style="width: 150px;">Acciones</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($turnos as $turno)
                                                                    <tr>
                                                                        <form id="formTurno{{ $turno->id_turno }}"
                                                                            method="POST"
                                                                            action="{{ route('catalogos.update', $turno->id_turno) }}">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <input type="hidden" name="tabla"
                                                                                value="turnos">
                                                                            <td class="text-center">
                                                                                {{ $turno->id_turno }}</td>
                                                                            <td>
                                                                                <input type="text" name="nombre"
                                                                                    class="form-control"
                                                                                    value="{{ $turno->nombre }}"
                                                                                    required minlength="3"
                                                                                    maxlength="100">
                                                                            </td>
                                                                            <td class="d-flex">
                                                                                <button type="button"
                                                                                    class="btn btn-warning btn-sm mr-1"
                                                                                    data-toggle="modal"
                                                                                    data-target="#guardarModalTurno{{ $turno->id_turno }}">
                                                                                    Guardar
                                                                                </button>
                                                                                <button type="button"
                                                                                    class="btn btn-danger btn-sm"
                                                                                    data-toggle="modal"
                                                                                    data-target="#eliminarModalTurno{{ $turno->id_turno }}">
                                                                                    Eliminar
                                                                                </button>
                                                                            </td>
                                                                        </form>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    @else
                                                        <p class="text-center text-muted mt-3">No hay registros para
                                                            mostrar.</p>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Modales para Turnos --}}
                                            @foreach ($turnos as $turno)
                                                <div class="modal fade"
                                                    id="guardarModalTurno{{ $turno->id_turno }}" tabindex="-1"
                                                    role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Confirmar Cambios</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Estás seguro de guardar los cambios en
                                                                <strong>{{ $turno->nombre }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <button type="submit"
                                                                    form="formTurno{{ $turno->id_turno }}"
                                                                    class="btn btn-success">Guardar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade"
                                                    id="eliminarModalTurno{{ $turno->id_turno }}" tabindex="-1"
                                                    role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header1">
                                                                <h5 class="modal-title">Eliminar Turno</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Seguro que deseas eliminar el turno
                                                                <strong>{{ $turno->nombre }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <form
                                                                    action="{{ route('catalogos.destroy', $turno->id_turno) }}"
                                                                    method="POST" style="display:inline-block;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <input type="hidden" name="tabla"
                                                                        value="turnos">
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Eliminar</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <div class="modal fade" id="agregarModalTurno" tabindex="-1"
                                                role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Confirmar Agregar</h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal"><span>&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            ¿Estás seguro de agregar este nuevo turno?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Cancelar</button>
                                                            <button type="submit" form="formAgregarTurno"
                                                                class="btn btn-success">Agregar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- ================== TIPOS DE ESCUELA ================== --}}
                                        <div class="tab-pane fade" id="tiposEscuela" role="tabpanel"
                                            aria-labelledby="tiposEscuela-tab">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4 class="mb-4">Tipos de Escuela</h4>
                                                    <form id="filtrosFormTiposEscuela" method="GET"
                                                        action="{{ route('catalogos.index') }}"
                                                        class="d-flex align-items-center1 gap-3">
                                                        <input type="hidden" name="tabla" value="tiposEscuela">
                                                        <div class="flex-grow-1" style="max-width: 400px;">
                                                            <input type="text" name="nombre_tipos_escuela"
                                                                class="form-control form-control-sm"
                                                                placeholder="🔍 Buscar por nombre"
                                                                value="{{ request('nombre_tipos_escuela') }}">
                                                        </div>
                                                        <button type="submit" class="btn btn-sm btn-primary px-3">
                                                            <i class="fas fa-search mr-1"></i> Buscar
                                                        </button>
                                                        <a href="{{ route('catalogos.index', ['tabla' => 'tiposEscuela']) }}"
                                                            class="btn btn-sm btn-outline-secondary px-3">
                                                            <i class="fas fa-list mr-1"></i>Mostrar todo
                                                        </a>
                                                    </form>

                                                    @if (count($tiposEscuela))
                                                        <div class="container mb-4 mt-4 d-flex justify-content-start">
                                                            <div
                                                                class="p-3 border rounded bg-light d-inline-block shadow-sm">
                                                                <form id="formAgregarTipoEscuela" method="POST"
                                                                    action="{{ route('catalogos.store') }}"
                                                                    class="form-inline mb-3">
                                                                    @csrf
                                                                    <input type="hidden" name="tabla"
                                                                        value="tiposEscuela">
                                                                    <div class="form-group mr-2 mb-2">
                                                                        <input type="text" name="nombre"
                                                                            class="form-control"
                                                                            placeholder="Tipo de escuela (Ej: Pública, Privada)"
                                                                            required minlength="3" maxlength="100">
                                                                    </div>
                                                                    <button type="button"
                                                                        class="btn btn-success mb-2"
                                                                        data-toggle="modal"
                                                                        data-target="#agregarModalTipoEscuela">
                                                                        Agregar
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>

                                                        <table class="table table-bordered table-hover">
                                                            <thead class="thead-dark text-center">
                                                                <tr>
                                                                    <th style="width: 80px;">ID</th>
                                                                    <th>Nombre</th>
                                                                    <th style="width: 150px;">Acciones</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($tiposEscuela as $tipoEscuela)
                                                                    <tr>
                                                                        <form
                                                                            id="formTipoEscuela{{ $tipoEscuela->id_tipo_escuela }}"
                                                                            method="POST"
                                                                            action="{{ route('catalogos.update', $tipoEscuela->id_tipo_escuela) }}">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <input type="hidden" name="tabla"
                                                                                value="tiposEscuela">
                                                                            <td class="text-center">
                                                                                {{ $tipoEscuela->id_tipo_escuela }}
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" name="nombre"
                                                                                    class="form-control"
                                                                                    value="{{ $tipoEscuela->nombre }}"
                                                                                    required minlength="3"
                                                                                    maxlength="100">
                                                                            </td>
                                                                            <td class="d-flex">
                                                                                <button type="button"
                                                                                    class="btn btn-warning btn-sm mr-1"
                                                                                    data-toggle="modal"
                                                                                    data-target="#guardarModalTipoEscuela{{ $tipoEscuela->id_tipo_escuela }}">
                                                                                    Guardar
                                                                                </button>
                                                                                <button type="button"
                                                                                    class="btn btn-danger btn-sm"
                                                                                    data-toggle="modal"
                                                                                    data-target="#eliminarModalTipoEscuela{{ $tipoEscuela->id_tipo_escuela }}">
                                                                                    Eliminar
                                                                                </button>
                                                                            </td>
                                                                        </form>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    @else
                                                        <p class="text-center text-muted mt-3">No hay registros para
                                                            mostrar.</p>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Modales para Tipos de Escuela --}}
                                            @foreach ($tiposEscuela as $tipoEscuela)
                                                <div class="modal fade"
                                                    id="guardarModalTipoEscuela{{ $tipoEscuela->id_tipo_escuela }}"
                                                    tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header1">
                                                                <h5 class="modal-title">Confirmar Cambios</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Estás seguro de guardar los cambios en
                                                                <strong>{{ $tipoEscuela->nombre }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <button type="submit"
                                                                    form="formTipoEscuela{{ $tipoEscuela->id_tipo_escuela }}"
                                                                    class="btn btn-success">Guardar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade"
                                                    id="eliminarModalTipoEscuela{{ $tipoEscuela->id_tipo_escuela }}"
                                                    tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Eliminar Tipo de Escuela</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Seguro que deseas eliminar el tipo de escuela
                                                                <strong>{{ $tipoEscuela->nombre }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <form
                                                                    action="{{ route('catalogos.destroy', $tipoEscuela->id_tipo_escuela) }}"
                                                                    method="POST" style="display:inline-block;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <input type="hidden" name="tabla"
                                                                        value="tiposEscuela">
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Eliminar</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <div class="modal fade" id="agregarModalTipoEscuela" tabindex="-1"
                                                role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Confirmar Agregar</h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal"><span>&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            ¿Estás seguro de agregar este nuevo tipo de escuela?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Cancelar</button>
                                                            <button type="submit" form="formAgregarTipoEscuela"
                                                                class="btn btn-success">Agregar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- ================== TIPOS DE COMPETENCIA ================== --}}
                                        <div class="tab-pane fade" id="tiposCompetencia" role="tabpanel"
                                            aria-labelledby="tiposCompetencia-tab">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4 class="mb-4">Tipos de Competencia</h4>
                                                    <form id="filtrosFormTiposCompetencia" method="GET"
                                                        action="{{ route('catalogos.index') }}"
                                                        class="d-flex align-items-center1 gap-3">
                                                        <input type="hidden" name="tabla"
                                                            value="tiposCompetencia">
                                                        <div class="flex-grow-1" style="max-width: 400px;">
                                                            <input type="text" name="nombre_tipos_competencia"
                                                                class="form-control form-control-sm"
                                                                placeholder="🔍 Buscar por nombre"
                                                                value="{{ request('nombre_tipos_competencia') }}">
                                                        </div>
                                                        <button type="submit" class="btn btn-sm btn-primary px-3">
                                                            <i class="fas fa-search mr-1"></i> Buscar
                                                        </button>
                                                        <a href="{{ route('catalogos.index', ['tabla' => 'tiposCompetencia']) }}"
                                                            class="btn btn-sm btn-outline-secondary px-3">
                                                            <i class="fas fa-list mr-1"></i>Mostrar todo
                                                        </a>
                                                    </form>

                                                    @if (count($tiposCompetencia))
                                                        <div class="container mb-4 mt-4 d-flex justify-content-start">
                                                            <div
                                                                class="p-3 border rounded bg-light d-inline-block shadow-sm">
                                                                <form id="formAgregarTipoCompetencia" method="POST"
                                                                    action="{{ route('catalogos.store') }}"
                                                                    class="form-inline mb-3">
                                                                    @csrf
                                                                    <input type="hidden" name="tabla"
                                                                        value="tiposCompetencia">
                                                                    <div class="form-group mr-2 mb-2">
                                                                        <input type="text" name="nombre"
                                                                            class="form-control"
                                                                            placeholder="Tipo de competencia" required
                                                                            minlength="3" maxlength="100">
                                                                    </div>
                                                                    <button type="button"
                                                                        class="btn btn-success mb-2"
                                                                        data-toggle="modal"
                                                                        data-target="#agregarModalTipoCompetencia">
                                                                        Agregar
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>

                                                        <table class="table table-bordered table-hover">
                                                            <thead class="thead-dark text-center">
                                                                <tr>
                                                                    <th style="width: 80px;">ID</th>
                                                                    <th>Nombre</th>
                                                                    <th style="width: 150px;">Acciones</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($tiposCompetencia as $tipoCompetencia)
                                                                    <tr>
                                                                        <form
                                                                            id="formTipoCompetencia{{ $tipoCompetencia->id_tipo_competencia }}"
                                                                            method="POST"
                                                                            action="{{ route('catalogos.update', $tipoCompetencia->id_tipo_competencia) }}">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <input type="hidden" name="tabla"
                                                                                value="tiposCompetencia">
                                                                            <td class="text-center">
                                                                                {{ $tipoCompetencia->id_tipo_competencia }}
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" name="nombre"
                                                                                    class="form-control"
                                                                                    value="{{ $tipoCompetencia->nombre }}"
                                                                                    required minlength="3"
                                                                                    maxlength="100">
                                                                            </td>
                                                                            <td class="d-flex">
                                                                                <button type="button"
                                                                                    class="btn btn-warning btn-sm mr-1"
                                                                                    data-toggle="modal"
                                                                                    data-target="#guardarModalTipoCompetencia{{ $tipoCompetencia->id_tipo_competencia }}">
                                                                                    Guardar
                                                                                </button>
                                                                                <button type="button"
                                                                                    class="btn btn-danger btn-sm"
                                                                                    data-toggle="modal"
                                                                                    data-target="#eliminarModalTipoCompetencia{{ $tipoCompetencia->id_tipo_competencia }}">
                                                                                    Eliminar
                                                                                </button>
                                                                            </td>
                                                                        </form>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    @else
                                                        <p class="text-center text-muted mt-3">No hay registros para
                                                            mostrar.</p>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Modales para Tipos de Competencia --}}
                                            @foreach ($tiposCompetencia as $tipoCompetencia)
                                                <div class="modal fade"
                                                    id="guardarModalTipoCompetencia{{ $tipoCompetencia->id_tipo_competencia }}"
                                                    tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Confirmar Cambios</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Estás seguro de guardar los cambios en
                                                                <strong>{{ $tipoCompetencia->nombre }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <button type="submit"
                                                                    form="formTipoCompetencia{{ $tipoCompetencia->id_tipo_competencia }}"
                                                                    class="btn btn-success">Guardar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade"
                                                    id="eliminarModalTipoCompetencia{{ $tipoCompetencia->id_tipo_competencia }}"
                                                    tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header1">
                                                                <h5 class="modal-title">Eliminar Tipo de Competencia
                                                                </h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Seguro que deseas eliminar el tipo de competencia
                                                                <strong>{{ $tipoCompetencia->nombre }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <form
                                                                    action="{{ route('catalogos.destroy', $tipoCompetencia->id_tipo_competencia) }}"
                                                                    method="POST" style="display:inline-block;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <input type="hidden" name="tabla"
                                                                        value="tiposCompetencia">
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Eliminar</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <div class="modal fade" id="agregarModalTipoCompetencia"
                                                tabindex="-1" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Confirmar Agregar</h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal"><span>&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            ¿Estás seguro de agregar este nuevo tipo de competencia?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Cancelar</button>
                                                            <button type="submit" form="formAgregarTipoCompetencia"
                                                                class="btn btn-success">Agregar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>


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

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('libs/sbadmin/js/sb-admin-2.min.js') }}"></script>

    {{-- Script para mantener la pestaña activa --}}
    <script>
        $(document).ready(function() {
            @if (session('activeTab'))
                var activeTab = "{{ session('activeTab') }}";
                $('#catalogTabs a[href="#' + activeTab + '"]').tab('show');
            @endif
        });
    </script>
    <script>
        $(document).ready(function() {
            @if (session('activeTab'))
                var activeTab = "{{ session('activeTab') }}";
            @else
                var activeTab = "{{ $activeTab ?? 'evaluaciones' }}";
            @endif

            $('#catalogTabs a[href="#' + activeTab + '"]').tab('show');
        });
    </script>
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


</body>

</html>
