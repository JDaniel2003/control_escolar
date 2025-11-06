<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Materias</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('libs/fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('libs/sbadmin/img/up_logo.png') }}">
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
                    <a class="nav-link navbar-active-item px-3 mr-1">Materias</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white px-3 mr-1" href="{{ route('planes.index') }}">Planes de estudio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white px-3 mr-1" href="{{ route('alumnos.index') }}">Alumnos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white px-3 mr-1" href="#">Asignaciones Docentes</a>
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
                        Gestión de Materias</h1>

                    <div class="row justify-content-center">
                        <div class="col-lg-10">

                            <!-- Botón para nueva MATERIA -->
                            <div class="mb-3 text-right">
                                <button type="button" class="btn btn-success" data-toggle="modal"
                                    data-target="#nuevaMateriaModal">
                                    <i class="fas fa-plus"></i> Nueva Materia
                                </button>
                            </div>

                            <!-- Filtros -->
                            <div class="container-fluid mb-4 d-flex justify-content-center">
                                <div class="p-3 border rounded bg-light shadow-sm d-inline-block">
                                    <form id="filtrosForm" method="GET" action="{{ route('materias.index') }}"
                                        class="d-flex flex-nowrap align-items-center gap-2">

                                        <!-- Nombre o Clave-->
                                        <div class="flex-grow-1" style="width: 400px;">
                                            <input type="text" name="busqueda"
                                                class="form-control form-control-sm"
                                                placeholder="🔍 Buscar por nombre o clave"
                                                value="{{ request('busqueda') }}" style="font-size: 1rem;">
                                        </div>

                                        <!-- Plan Estudio -->
                                        <select name="id_plan_estudio" class="form-control form-control-sm py-1 px-2"
                                            style="font-size: 1rem; width: fit-content;">
                                            <option value="">Plan de Estudio</option>
                                            @foreach ($planes as $plan)
                                                <option value="{{ $plan->id_plan_estudio }}"
                                                    {{ request('id_plan_estudio') == $plan->id_plan_estudio ? 'selected' : '' }}
                                                    style="white-space: nowrap;">
                                                    {{ $plan->nombre }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <!-- Número Período -->
                                        <select name="id_numero_periodo"
                                            class="form-control form-control-sm py-1 px-2"
                                            style="font-size: 1rem; width: fit-content;">
                                            <option value="">Número Período</option>
                                            @foreach ($periodos as $periodo)
                                                <option value="{{ $periodo->id_numero_periodo }}"
                                                    {{ request('id_numero_periodo') == $periodo->id_numero_periodo ? 'selected' : '' }}>
                                                    {{ $periodo->tipoPeriodo->nombre }} - {{ $periodo->numero }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <!-- Mostrar -->
                                        <select name="mostrar" onchange="this.form.submit()"
                                            class="form-control form-control-sm w-auto">
                                            <option value="5" {{ request('mostrar') == 5 ? 'selected' : '' }}>5
                                            </option>
                                            <option value="10" {{ request('mostrar') == 10 ? 'selected' : '' }}>10
                                            </option>
                                            <option value="10" {{ request('mostrar') == 15 ? 'selected' : '' }}>15
                                            </option>
                                            <option value="25" {{ request('mostrar') == 25 ? 'selected' : '' }}>25
                                            </option>
                                            <option value="50" {{ request('mostrar') == 50 ? 'selected' : '' }}>50
                                            </option>
                                            <option value="todo"
                                                {{ request('mostrar') == 'todo' ? 'selected' : '' }}>Todo</option>
                                        </select>

                                        <!-- Botón Mostrar todo -->
                                        <a href="{{ route('materias.index', ['mostrar' => 'todo']) }}"
                                            class="btn btn-sm btn-outline-secondary py-1 px-3 d-flex align-items-center"
                                            style="font-size: 1rem; white-space: nowrap;">
                                            <i class="fas fa-list me-1"></i> Mostrar todo
                                        </a>
                                    </form>
                                </div>
                            </div>

                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    let form = document.getElementById("filtrosForm");

                                    // Detecta cambios en selects
                                    form.querySelectorAll("select").forEach(el => {
                                        el.addEventListener("change", function() {
                                            form.submit();
                                        });
                                    });

                                    // Para inputs de texto, busca después de dejar de escribir
                                    let typingTimer;
                                    form.querySelectorAll("input[type='text']").forEach(input => {
                                        input.addEventListener("keyup", function() {
                                            clearTimeout(typingTimer);
                                            typingTimer = setTimeout(() => {
                                                form.submit();
                                            }, 500);
                                        });
                                    });
                                });
                            </script>

                            <!-- Tabla Simplificada -->
                            <div class="card-body1">
                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="thead-dark text-center">
                                            <tr>
                                                <th>Clave</th>
                                                <th>Nombre</th>
                                                <th>Plan de Estudios</th>
                                                <th>Unidades</th>
                                                <th>Numero Período</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($materias as $materia)
                                                <tr class="text-center">
                                                    <td>{{ $materia->clave }}</td>
                                                    <td>{{ $materia->nombre }}</td>
                                                    <td>{{ $materia->planEstudio->nombre ?? 'N/A' }}</td>
                                                    <td>
                                                        {{ $materia->unidades_count }}
                                                        <button class="btn btn-info btn-sm" data-toggle="modal"
                                                            data-target="#unidadesModal{{ $materia->id_materia }}">
                                                            <i class="fas fa-eye"></i> Ver
                                                        </button>

                                                        <!-- Modal Unidades -->
                                                        <div class="modal fade"
                                                            id="unidadesModal{{ $materia->id_materia }}"
                                                            tabindex="-1" role="dialog"
                                                            aria-labelledby="unidadesModalLabel{{ $materia->id_materia }}"
                                                            aria-hidden="true">

                                                            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable"
                                                                role="document">
                                                                <div class="modal-content shadow-sm border-0">

                                                                    {{-- Header --}}
                                                                    <div
                                                                        class="modal-header modal-header-custom border-0">
                                                                        <div class="w-100 text-center">
                                                                            <h5 class="m-0 font-weight-bold"
                                                                                id="unidadesModalLabel{{ $materia->id_materia }}">
                                                                                📑 Unidades de Aprendizaje
                                                                            </h5>
                                                                            <p class="m-0 mt-2 mb-0 "
                                                                                style="font-size: 0.9rem; opacity: 0.95;">
                                                                                Unidades de la materia
                                                                                {{ $materia->nombre }}
                                                                            </p>
                                                                        </div>
                                                                        <button type="button"
                                                                            class="close text-white"
                                                                            data-dismiss="modal" aria-label="Cerrar"
                                                                            style="position: absolute; right: 1.5rem; top: 1.5rem; font-size: 1.8rem; opacity: 0.9;">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>

                                                                    {{-- Body --}}
                                                                    <div class="modal-body p-3"
                                                                        style="background-color: #f8f9fa;">
                                                                        <div class="container-fluid px-2">

                                                                            {{-- Información de la Materia --}}
                                                                            <div
                                                                                class="bg-white rounded p-3 mb-3 shadow-sm">
                                                                                <h6
                                                                                    class="text-danger font-weight-bold mb-2">
                                                                                    Materia</h6>
                                                                                <div class="text-center">
                                                                                    <span
                                                                                        class="font-weight-bold text-dark"
                                                                                        style="font-size: 1rem;">
                                                                                        {{ $materia->nombre }}
                                                                                    </span>
                                                                                </div>
                                                                            </div>

                                                                            @if ($materia->unidades->count() > 0)
                                                                                {{-- Formulario para actualizar todas las unidades --}}
                                                                                <form
                                                                                    action="{{ route('unidades.actualizarTodo', $materia->id_materia) }}"
                                                                                    method="POST">
                                                                                    @csrf
                                                                                    @method('PUT')

                                                                                    {{-- Tabla de Unidades --}}
                                                                                    <div
                                                                                        class="bg-white rounded p-3 mb-3 shadow-sm">
                                                                                        <h6
                                                                                            class="text-danger font-weight-bold mb-3 d-flex align-items-center justify-content-between">
                                                                                            <span><i
                                                                                                    class="fas fa-book mr-2"></i>Unidades
                                                                                                Registradas</span>
                                                                                            <span
                                                                                                class="badge badge-info">{{ $materia->unidades->count() }}
                                                                                                Unidades</span>
                                                                                        </h6>

                                                                                        <div class="table-responsive">
                                                                                            <table
                                                                                                class="table table-sm table-bordered mb-0 text-center">
                                                                                                <thead
                                                                                                    class="thead-dark">
                                                                                                    <tr>
                                                                                                        <th
                                                                                                            style="width: 7%;">
                                                                                                            Unidad</th>
                                                                                                        <th>Nombre</th>
                                                                                                        <th
                                                                                                            style="width: 110px;">
                                                                                                            Horas Saber
                                                                                                        </th>
                                                                                                        <th
                                                                                                            style="width: 130px;">
                                                                                                            Horas S.
                                                                                                            Hacer</th>
                                                                                                        <th
                                                                                                            style="width: 110px;">
                                                                                                            Total Horas
                                                                                                        </th>
                                                                                                        <th
                                                                                                            style="width: 80px;">
                                                                                                            Eliminar
                                                                                                        </th>
                                                                                                    </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                    @foreach ($materia->unidades as $i => $unidad)
                                                                                                        <tr>
                                                                                                            <td>
                                                                                                                <input
                                                                                                                    type="hidden"
                                                                                                                    name="unidades[{{ $i }}][id_unidad]"
                                                                                                                    value="{{ $unidad->id_unidad }}">
                                                                                                                <input
                                                                                                                    type="number"
                                                                                                                    name="unidades[{{ $i }}][numero_unidad]"
                                                                                                                    class="form-control form-control-sm text-center"
                                                                                                                    value="{{ $unidad->numero_unidad }}"
                                                                                                                    required>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                <input
                                                                                                                    type="text"
                                                                                                                    name="unidades[{{ $i }}][nombre]"
                                                                                                                    class="form-control form-control-sm"
                                                                                                                    value="{{ $unidad->nombre }}"
                                                                                                                    required>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                <input
                                                                                                                    type="number"
                                                                                                                    name="unidades[{{ $i }}][horas_saber]"
                                                                                                                    class="form-control form-control-sm text-center horas-saber"
                                                                                                                    value="{{ $unidad->horas_saber }}">
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                <input
                                                                                                                    type="number"
                                                                                                                    name="unidades[{{ $i }}][horas_saber_hacer]"
                                                                                                                    class="form-control form-control-sm text-center horas-saber-hacer"
                                                                                                                    value="{{ $unidad->horas_saber_hacer }}">
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                <input
                                                                                                                    type="number"
                                                                                                                    name="unidades[{{ $i }}][horas_totales]"
                                                                                                                    class="form-control form-control-sm text-center horas-totales bg-light"
                                                                                                                    value="{{ $unidad->horas_totales }}"
                                                                                                                    readonly>
                                                                                                            </td>
                                                                                                            <!-- Botón para abrir el modal -->
                                                                                                            <td
                                                                                                                class="text-center">
                                                                                                                <button
                                                                                                                    type="button"
                                                                                                                    class="btn btn-danger btn-sm"
                                                                                                                    data-toggle="modal"
                                                                                                                    data-target="#eliminarModalUnidad{{ $unidad->id_unidad }}"
                                                                                                                    title="Eliminar unidad">
                                                                                                                    <i
                                                                                                                        class="fas fa-trash"></i>
                                                                                                                </button>
                                                                                                            </td>



                                                                                                        </tr>
                                                                                                    @endforeach

                                                                                                    {{-- Fila de Totales --}}
                                                                                                    <tr>
                                                                                                        <td colspan="2"
                                                                                                            class="text-right font-weight-bold">
                                                                                                            Totales
                                                                                                        </td>
                                                                                                        <td
                                                                                                            class="font-weight-bold text-primary">
                                                                                                            {{ $materia->unidades->sum('horas_saber') }}
                                                                                                        </td>
                                                                                                        <td
                                                                                                            class="font-weight-bold text-primary">
                                                                                                            {{ $materia->unidades->sum('horas_saber_hacer') }}
                                                                                                        </td>
                                                                                                        <td
                                                                                                            class="font-weight-bold text-danger">
                                                                                                            {{ $materia->unidades->sum('horas_totales') }}
                                                                                                        </td>
                                                                                                        <td></td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </div>

                                                                                        <div class="text-right mt-3">
                                                                                            <button type="submit"
                                                                                                class="btn btn-primary btn-sm px-4">
                                                                                                <i
                                                                                                    class="fas fa-save mr-1"></i>Guardar
                                                                                                Cambios
                                                                                            </button>
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                                <!-- Modal de Confirmación para Eliminar Unidad -->
                                                                                <div class="modal fade"
                                                                                    id="eliminarModalUnidad{{ $unidad->id_unidad }}"
                                                                                    tabindex="-1" role="dialog"
                                                                                    aria-labelledby="eliminarModalLabelUnidad{{ $unidad->id_unidad }}"
                                                                                    aria-hidden="true">
                                                                                    <div class="modal-dialog modal-dialog-centered"
                                                                                        role="document">
                                                                                        <div
                                                                                            class="modal-content shadow-sm border-0">

                                                                                            <!-- Encabezado -->
                                                                                            <div
                                                                                                class="modal-header modal-header-custom border-0">
                                                                                                <h5 class="modal-title w-100 text-center font-weight-bold m-0"
                                                                                                    id="eliminarModalLabelUnidad{{ $unidad->id_unidad }}">
                                                                                                    🗑️ Eliminar Unidad
                                                                                                </h5>
                                                                                                <button type="button"
                                                                                                    class="close text-white"
                                                                                                    data-dismiss="modal"
                                                                                                    aria-label="Cerrar"
                                                                                                    style="position: absolute; right: 1rem; top: 1rem; font-size: 1.5rem; opacity: 0.9;">
                                                                                                    <span
                                                                                                        aria-hidden="true">&times;</span>
                                                                                                </button>
                                                                                            </div>

                                                                                            <!-- Cuerpo -->
                                                                                            <div
                                                                                                class="modal-body text-center py-4">
                                                                                                <i class="fas fa-exclamation-triangle text-warning mb-3"
                                                                                                    style="font-size: 3rem;"></i>
                                                                                                <p class="mb-2">
                                                                                                    ¿Estás seguro de que
                                                                                                    deseas eliminar la
                                                                                                    siguiente unidad?
                                                                                                </p>
                                                                                                <p
                                                                                                    class="mb-0 font-weight-bold text-primary">
                                                                                                    {{ $unidad->nombre }}
                                                                                                </p>
                                                                                                <small
                                                                                                    class="text-muted d-block mt-2">
                                                                                                    Unidad
                                                                                                    {{ $unidad->numero_unidad }}
                                                                                                    —
                                                                                                    {{ $unidad->horas_totales }}
                                                                                                    horas totales
                                                                                                </small>
                                                                                                <p
                                                                                                    class="text-danger mt-3 mb-0">
                                                                                                    <small><i
                                                                                                            class="fas fa-info-circle"></i>
                                                                                                        Esta acción no
                                                                                                        se puede
                                                                                                        deshacer.</small>
                                                                                                </p>
                                                                                            </div>

                                                                                            <!-- Pie -->
                                                                                            <div
                                                                                                class="modal-footer border-top">
                                                                                                <button type="button"
                                                                                                    class="btn btn-secondary"
                                                                                                    data-dismiss="modal">
                                                                                                    <i
                                                                                                        class="fas fa-times mr-1"></i>
                                                                                                    Cancelar
                                                                                                </button>

                                                                                                <!-- Formulario independiente para eliminar -->
                                                                                                <form
                                                                                                    action="{{ route('unidades.eliminar', $unidad->id_unidad) }}"
                                                                                                    method="POST"
                                                                                                    class="m-0 p-0 d-inline">
                                                                                                    @csrf
                                                                                                    @method('DELETE')
                                                                                                    <button
                                                                                                        type="submit"
                                                                                                        class="btn btn-danger">
                                                                                                        <i
                                                                                                            class="fas fa-trash mr-1"></i>
                                                                                                        Eliminar
                                                                                                    </button>
                                                                                                </form>
                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @else
                                                                                {{-- Sin Unidades --}}
                                                                                <div class="alert alert-warning text-center mb-3"
                                                                                    role="alert">
                                                                                    <i
                                                                                        class="fas fa-info-circle mr-2"></i>
                                                                                    No hay unidades registradas para
                                                                                    esta materia.
                                                                                </div>
                                                                            @endif

                                                                            {{-- Formulario para agregar nueva unidad --}}
                                                                            <div
                                                                                class="bg-white rounded p-3 shadow-sm">
                                                                                <h6
                                                                                    class="text-danger font-weight-bold mb-3">
                                                                                    <i
                                                                                        class="fas fa-plus-circle mr-2"></i>Agregar
                                                                                    Nueva Unidad
                                                                                </h6>

                                                                                <form
                                                                                    action="{{ route('unidades.agregar', $materia->id_materia) }}"
                                                                                    method="POST">
                                                                                    @csrf
                                                                                    <div class="form-row text-center">
                                                                                        <div class="col-md-1 mb-2">
                                                                                            <label
                                                                                                class="small text-muted mb-1">No.
                                                                                                Unidad</label>
                                                                                            <input type="number"
                                                                                                name="numero_unidad"
                                                                                                class="form-control form-control-sm"
                                                                                                placeholder="Ej: 1"
                                                                                                required>
                                                                                        </div>
                                                                                        <div class="col-md-6 mb-2">
                                                                                            <label
                                                                                                class="small text-muted mb-1">Nombre
                                                                                                de la Unidad</label>
                                                                                            <input type="text"
                                                                                                name="nombre"
                                                                                                class="form-control form-control-sm"
                                                                                                placeholder="Ej: Introducción a la programación"
                                                                                                required>
                                                                                        </div>

                                                                                        <div class="col-md-2 mb-2">
                                                                                            <label
                                                                                                class="small text-muted mb-1">Horas
                                                                                                Saber</label>
                                                                                            <input type="number"
                                                                                                name="horas_saber"
                                                                                                class="form-control form-control-sm horas-saber-nueva"
                                                                                                placeholder="0"
                                                                                                min="0">
                                                                                        </div>
                                                                                        <div class="col-md-2 mb-2">
                                                                                            <label
                                                                                                class="small text-muted mb-1">Horas
                                                                                                Saber Hacer</label>
                                                                                            <input type="number"
                                                                                                name="horas_saber_hacer"
                                                                                                class="form-control form-control-sm horas-saber-hacer-nueva"
                                                                                                placeholder="0"
                                                                                                min="0">
                                                                                        </div>
                                                                                        <div class="col-md-2 mb-2">
                                                                                            <label
                                                                                                class="small text-muted mb-1">Total
                                                                                                de Horas</label>
                                                                                            <input type="number"
                                                                                                name="horas_totales"
                                                                                                class="form-control form-control-sm horas-totales-nueva bg-light"
                                                                                                placeholder="0"
                                                                                                readonly>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="text-center">
                                                                                        <small class="text-muted">
                                                                                            <span
                                                                                                class="required-asterisk">*</span>
                                                                                            Campos obligatorios
                                                                                        </small>
                                                                                    </div>

                                                                                    <div class="text-right">
                                                                                        <button type="submit"
                                                                                            class="btn btn-success btn-sm px-4">
                                                                                            <i
                                                                                                class="fas fa-plus mr-1"></i>Agregar
                                                                                            Unidad
                                                                                        </button>
                                                                                    </div>

                                                                                </form>
                                                                            </div>

                                                                        </div>
                                                                    </div>

                                                                    {{-- Footer --}}
                                                                    <div class="modal-footer py-2"
                                                                        style="background-color: #f8f9fa;">
                                                                        <button type="button"
                                                                            class="btn btn-secondary"
                                                                            data-dismiss="modal">
                                                                            <i class="fas fa-times mr-2"></i>Cerrar
                                                                        </button>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>


                                                        <!-- Formularios de eliminación -->
                                                        @foreach ($materia->unidades as $unidad)
                                                            <form id="formEliminar{{ $unidad->id_unidad }}"
                                                                action="{{ route('unidades.eliminar', $unidad->id_unidad) }}"
                                                                method="POST" style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        {{ $materia->numeroPeriodo->tipoPeriodo->nombre ?? 'N/A' }}
                                                        {{ $materia->numeroPeriodo->numero ?? 'N/A' }}
                                                    </td>
                                                    <!-- //////////////////////////////////////////////////////////////////// -->

                                                    <td>
                                                        <!-- Botón Ver Detalles -->
                                                        <button type="button" class="btn btn-info btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#verModal{{ $materia->id_materia }}">
                                                            <i class="fas fa-eye"></i> Ver
                                                        </button>

                                                        <!-- Botón Editar -->
                                                        <button type="button" class="btn btn-warning btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#editarModal{{ $materia->id_materia }}">
                                                            <i class="fas fa-edit"></i> Editar
                                                        </button>

                                                        <!-- Botón Eliminar -->
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#eliminarModal{{ $materia->id_materia }}">
                                                            <i class="fas fa-trash-alt"></i> Eliminar
                                                        </button>

                                                        <!-- Modal Ver Detalles -->
                                                        <div class="modal fade"
                                                            id="verModal{{ $materia->id_materia }}" tabindex="-1"
                                                            role="dialog"
                                                            aria-labelledby="verModalLabel{{ $materia->id_materia }}"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable"
                                                                role="document">
                                                                <div class="modal-content shadow-sm border-0">

                                                                    <!-- Encabezado -->
                                                                    <div
                                                                        class="modal-header modal-header-custom border-0">
                                                                        <div class="w-100 text-center">
                                                                            <h5 class="m-0 font-weight-bold">
                                                                                📓 Materia
                                                                            </h5>
                                                                            <p class="m-0 mt-2 mb-0"
                                                                                style="font-size: 0.9rem; opacity: 0.95;">
                                                                                Visualización completa de la materia
                                                                            </p>
                                                                        </div>
                                                                        <button type="button"
                                                                            class="close text-white"
                                                                            data-dismiss="modal" aria-label="Cerrar"
                                                                            style="position: absolute; right: 1.5rem; top: 1.5rem; font-size: 1.8rem; opacity: 0.9;">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>

                                                                    <!-- Cuerpo -->
                                                                    <div class="modal-body p-3"
                                                                        style="background-color: #f8f9fa;">
                                                                        <div class="container-fluid px-2">

                                                                            <!-- Info general -->
                                                                            <div
                                                                                class="bg-white rounded p-3 mb-3 shadow-sm">
                                                                                <h6
                                                                                    class="text-danger font-weight-bold mb-3">
                                                                                    Información
                                                                                    General
                                                                                </h6>
                                                                                <div class="mt-2 text-center mb-2">
                                                                                    <small
                                                                                        class="text-muted text-uppercase d-block">Nombre:</small>
                                                                                    <span
                                                                                        class="font-weight-bold">{{ $materia->nombre }}</span>
                                                                                </div>
                                                                                <div class="row text-center">

                                                                                    <div class="col-6 col-md-3 mb-2">
                                                                                        <small
                                                                                            class="text-muted text-uppercase d-block">Clave:</small>
                                                                                        <span
                                                                                            class="font-weight-bold">{{ $materia->clave }}</span>
                                                                                    </div>
                                                                                    <div class="col-6 col-md-3 mb-2">
                                                                                        <small
                                                                                            class="text-muted text-uppercase d-block">Créditos:</small>
                                                                                        <span
                                                                                            class="font-weight-bold">{{ $materia->creditos }}</span>
                                                                                    </div>
                                                                                    <div class="col-6 col-md-3 mb-2">
                                                                                        <small
                                                                                            class="text-muted text-uppercase d-block">Horas:</small>
                                                                                        <span
                                                                                            class="font-weight-bold">{{ $materia->horas }}</span>
                                                                                    </div>
                                                                                </div>

                                                                            </div>

                                                                            <!-- Características académicas -->
                                                                            <div
                                                                                class="bg-white rounded p-3 mb-3 shadow-sm">
                                                                                <h6
                                                                                    class="text-danger font-weight-bold mb-3">
                                                                                    Características
                                                                                    Académicas
                                                                                </h6>


                                                                                <div class="row">
                                                                                    <div class="mt-2 text-center mb-2">
                                                                                        <small
                                                                                            class="text-muted text-uppercase d-block">Plan
                                                                                            de Estudios:</small>
                                                                                        <span
                                                                                            class="text-uppercase font-weight-bold">{{ $materia->planEstudio->nombre ?? 'N/A' }}</span>
                                                                                    </div>
                                                                                    <div class="col-md-6 mb-2">
                                                                                        <small
                                                                                            class="text-muted text-uppercase d-block">Competencia:</small>
                                                                                        <span
                                                                                            class="font-weight-bold">{{ $materia->competencia->nombre ?? 'N/A' }}</span>
                                                                                    </div>
                                                                                    <div class="col-md-6 mb-2">
                                                                                        <small
                                                                                            class="text-muted text-uppercase d-block">Modalidad:</small>
                                                                                        <span
                                                                                            class="font-weight-bold">{{ $materia->modalidad->nombre ?? 'N/A' }}</span>
                                                                                    </div>
                                                                                    <div class="col-md-6 mb-2">
                                                                                        <small
                                                                                            class="text-muted text-uppercase d-block">Espacio
                                                                                            Formativo:</small>
                                                                                        <span
                                                                                            class="font-weight-bold">{{ $materia->espacioFormativo->nombre ?? 'N/A' }}</span>
                                                                                    </div>

                                                                                    <div class="col-md-6 mb-2">
                                                                                        <small
                                                                                            class="text-muted text-uppercase d-block">Período:</small>
                                                                                        <span
                                                                                            class="font-weight-bold">{{ $materia->numeroPeriodo->tipoPeriodo->nombre ?? 'N/A' }}
                                                                                            {{ $materia->numeroPeriodo->numero ?? '' }}</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Unidades -->
                                                                            <div
                                                                                class="bg-white rounded p-3 shadow-sm">
                                                                                <h6
                                                                                    class="text-danger font-weight-bold mb-3 d-flex align-items-center justify-content-between">
                                                                                    <span>Unidades
                                                                                        de Aprendizaje</span>
                                                                                    <span
                                                                                        class="badge badge-info">{{ $materia->unidades_count }}
                                                                                        Unidades</span>
                                                                                </h6>

                                                                                @if ($materia->unidades_count > 0)
                                                                                    <div class="table-responsive">
                                                                                        <table
                                                                                            class="table table-sm table-bordered mb-0 text-center">
                                                                                            <thead class="thead-dark">
                                                                                                <tr>
                                                                                                    <th>Unidad</th>
                                                                                                    <th>Nombre</th>
                                                                                                    <th>Saber</th>
                                                                                                    <th>Hacer</th>
                                                                                                    <th>Total</th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                                @foreach ($materia->unidades->sortBy('numero_unidad') as $unidad)
                                                                                                    <tr>
                                                                                                        <td>{{ $unidad->numero_unidad }}
                                                                                                        </td>
                                                                                                        <td
                                                                                                            class="text-left">
                                                                                                            {{ $unidad->nombre }}
                                                                                                        </td>
                                                                                                        <td>{{ $unidad->horas_saber ?? 0 }}
                                                                                                        </td>
                                                                                                        <td>{{ $unidad->horas_saber_hacer ?? 0 }}
                                                                                                        </td>
                                                                                                        <td><strong
                                                                                                                class="text-success">{{ $unidad->horas_totales }}</strong>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                @endforeach
                                                                                                <tr>
                                                                                                    <td colspan="4"
                                                                                                        class="text-right font-weight-bold">
                                                                                                        Total de Horas
                                                                                                    </td>
                                                                                                    <td
                                                                                                        class="font-weight-bold text-danger">
                                                                                                        {{ $materia->unidades->sum('horas_totales') }}
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                @else
                                                                                    <div class="alert alert-warning text-center mb-0"
                                                                                        role="alert">
                                                                                        <i
                                                                                            class="fas fa-info-circle mr-2"></i>Esta
                                                                                        materia no tiene unidades
                                                                                        registradas.
                                                                                    </div>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Footer -->
                                                                    <div class="modal-footer py-2"
                                                                        style="background-color: #f8f9fa;">
                                                                        <button type="button"
                                                                            class="btn btn-secondary btn-sm px-3"
                                                                            data-dismiss="modal">
                                                                            <i class="fas fa-times mr-1"></i> Cerrar
                                                                        </button>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>


                                                        <!-- Modal Editar Materia -->
                                                        <div class="modal fade"
                                                            id="editarModal{{ $materia->id_materia }}" tabindex="-1"
                                                            role="dialog"
                                                            aria-labelledby="editarModalLabel{{ $materia->id_materia }}"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content border-0 shadow-lg">

                                                                    <!-- Header con gradiente -->
                                                                    <div
                                                                        class="modal-header modal-header-custom border-0">
                                                                        <div class="w-100 text-center">
                                                                            <h5 class="m-0 font-weight-bold"
                                                                                id="editarModalLabel{{ $materia->id_materia }}">
                                                                                ✏️ Editar Materia
                                                                            </h5>
                                                                            <p class="m-0 mt-2 mb-0"
                                                                                style="font-size: 0.9rem; opacity: 0.95;">
                                                                                Modifique la información de la materia
                                                                                seleccionada
                                                                            </p>
                                                                        </div>
                                                                        <button type="button"
                                                                            class="close text-white"
                                                                            data-dismiss="modal" aria-label="Cerrar"
                                                                            style="position: absolute; right: 1.5rem; top: 1.5rem; font-size: 1.8rem; opacity: 0.9;">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>

                                                                    <!-- Formulario -->
                                                                    <form
                                                                        action="{{ route('materias.update', $materia->id_materia) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <div class="modal-body modal-body-custom p-4">

                                                                            <!-- Contenedor principal -->
                                                                            <div
                                                                                class="form-container p-4 bg-white rounded shadow-sm border">

                                                                                <!-- Sección 1: Identificación -->
                                                                                <div class="info-section mb-4">
                                                                                    <div class="row">
                                                                                        <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    class="form-label-custom d-flex">
                                                                                                    🔑 Clave
                                                                                                    <span
                                                                                                        class="required-asterisk ml-1">*</span>
                                                                                                </label>
                                                                                                <input type="text"
                                                                                                    name="clave"
                                                                                                    class="form-control form-control-custom"
                                                                                                    value="{{ old('clave', $materia->clave) }}"
                                                                                                    required>
                                                                                                <small
                                                                                                    class="form-text text-muted">Código
                                                                                                    único
                                                                                                    identificador</small>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="col-md-8">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    class="form-label-custom d-flex">
                                                                                                    📝 Nombre de la
                                                                                                    Materia
                                                                                                    <span
                                                                                                        class="required-asterisk ml-1">*</span>
                                                                                                </label>
                                                                                                <input type="text"
                                                                                                    name="nombre"
                                                                                                    class="form-control form-control-custom"
                                                                                                    value="{{ old('nombre', $materia->nombre) }}"
                                                                                                    required>
                                                                                                <small
                                                                                                    class="form-text text-muted">Nombre
                                                                                                    completo de la
                                                                                                    asignatura</small>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Sección 2: Clasificación Académica -->
                                                                                <div class="academic-section mb-4">
                                                                                    <div class="row">
                                                                                        <div class="col-md-6">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    class="form-label-custom d-flex">🎯
                                                                                                    Tipo de
                                                                                                    Competencia</label>
                                                                                                <select
                                                                                                    name="id_tipo_competencia"
                                                                                                    class="form-control form-control-custom">
                                                                                                    <option
                                                                                                        value="">
                                                                                                        -- Seleccione
                                                                                                        una competencia
                                                                                                        --</option>
                                                                                                    @foreach ($competencias as $competencia)
                                                                                                        <option
                                                                                                            value="{{ $competencia->id_tipo_competencia }}"
                                                                                                            {{ $materia->id_tipo_competencia == $competencia->id_tipo_competencia ? 'selected' : '' }}>
                                                                                                            {{ $competencia->nombre }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="col-md-6">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    class="form-label-custom d-flex">🎓
                                                                                                    Modalidad</label>
                                                                                                <select
                                                                                                    name="id_modalidad"
                                                                                                    class="form-control form-control-custom">
                                                                                                    <option
                                                                                                        value="">
                                                                                                        -- Seleccione
                                                                                                        una modalidad --
                                                                                                    </option>
                                                                                                    @foreach ($modalidades as $modalidad)
                                                                                                        <option
                                                                                                            value="{{ $modalidad->id_modalidad }}"
                                                                                                            {{ $materia->id_modalidad == $modalidad->id_modalidad ? 'selected' : '' }}>
                                                                                                            {{ $modalidad->nombre }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="row">
                                                                                        <div class="col-md-6">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    class="form-label-custom d-flex">🏫
                                                                                                    Espacio
                                                                                                    Formativo</label>
                                                                                                <select
                                                                                                    name="id_espacio_formativo"
                                                                                                    class="form-control form-control-custom">
                                                                                                    <option
                                                                                                        value="">
                                                                                                        -- Seleccione un
                                                                                                        espacio --
                                                                                                    </option>
                                                                                                    @foreach ($espaciosformativos as $espacio)
                                                                                                        <option
                                                                                                            value="{{ $espacio->id_espacio_formativo }}"
                                                                                                            {{ $materia->id_espacio_formativo == $espacio->id_espacio_formativo ? 'selected' : '' }}>
                                                                                                            {{ $espacio->nombre }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="col-md-6">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    class="form-label-custom d-flex">📚
                                                                                                    Plan de
                                                                                                    Estudio</label>
                                                                                                <select
                                                                                                    name="id_plan_estudio"
                                                                                                    class="form-control form-control-custom">
                                                                                                    <option
                                                                                                        value="">
                                                                                                        -- Seleccione un
                                                                                                        plan --</option>
                                                                                                    @foreach ($planes as $plan)
                                                                                                        <option
                                                                                                            value="{{ $plan->id_plan_estudio }}"
                                                                                                            {{ $materia->id_plan_estudio == $plan->id_plan_estudio ? 'selected' : '' }}>
                                                                                                            {{ $plan->nombre }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Sección 3: Carga Académica -->
                                                                                <div class="workload-section mb-4">
                                                                                    <div class="row">
                                                                                        <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    class="form-label-custom d-flex">⭐
                                                                                                    Créditos</label>
                                                                                                <input type="number"
                                                                                                    name="creditos"
                                                                                                    class="form-control form-control-custom"
                                                                                                    value="{{ old('creditos', $materia->creditos) }}"
                                                                                                    min="0"
                                                                                                    step="0.5">
                                                                                                <small
                                                                                                    class="form-text text-muted">Valor
                                                                                                    en créditos</small>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    class="form-label-custom d-flex">⏰
                                                                                                    Horas</label>
                                                                                                <input type="number"
                                                                                                    name="horas"
                                                                                                    class="form-control form-control-custom"
                                                                                                    value="{{ old('horas', $materia->horas) }}"
                                                                                                    min="0">
                                                                                                <small
                                                                                                    class="form-text text-muted">Horas
                                                                                                    totales</small>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    class="form-label-custom d-flex">📅
                                                                                                    Número de
                                                                                                    Período</label>
                                                                                                <select
                                                                                                    name="id_numero_periodo"
                                                                                                    class="form-control form-control-custom">
                                                                                                    <option
                                                                                                        value="">
                                                                                                        -- Seleccione --
                                                                                                    </option>
                                                                                                    @foreach ($periodos as $periodo)
                                                                                                        <option
                                                                                                            value="{{ $periodo->id_numero_periodo }}"
                                                                                                            {{ $materia->id_numero_periodo == $periodo->id_numero_periodo ? 'selected' : '' }}>
                                                                                                            {{ $periodo->tipoPeriodo->nombre }}
                                                                                                            -
                                                                                                            {{ $periodo->numero }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Footer -->
                                                                        <div
                                                                            class="modal-footer modal-footer-custom border-top">
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-dismiss="modal">
                                                                                <i class="fas fa-times mr-2"></i>
                                                                                Cancelar
                                                                            </button>
                                                                            <button type="submit"
                                                                                class="btn btn-success">
                                                                                <i class="fas fa-save mr-2"></i>
                                                                                Actualizar Materia
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <!-- Modal Eliminar -->
                                                        <div class="modal fade"
                                                            id="eliminarModal{{ $materia->id_materia }}"
                                                            tabindex="-1" role="dialog"
                                                            aria-labelledby="eliminarModalLabel{{ $materia->id_materia }}"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div
                                                                        class="modal-header1 modal-header-custom border-0">
                                                                        <div class="w-100 text-center">
                                                                            <h5 class="m-0 font-weight-bold"
                                                                                id="eliminarModalLabel{{ $materia->id_materia }}">
                                                                                🗑️ Eliminar Materia
                                                                            </h5>
                                                                        </div>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Cerrar">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        ¿Seguro que deseas eliminar la materia
                                                                        <strong>{{ $materia->nombre }}</strong>?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        
                                                                        <button type="button"
                                                                            class="btn btn-secondary"
                                                                            data-dismiss="modal">Cancelar</button>
                                                                            <form
                                                                            action="{{ route('materias.destroy', $materia->id_materia) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="btn btn-danger">Eliminar</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="100" class="text-center text-muted">No hay materias
                                                        registradas</td>
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

    <!-- Modal Nueva Materia -->
    <div class="modal fade" id="nuevaMateriaModal" tabindex="-1" role="dialog"
        aria-labelledby="nuevaMateriaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content border-0 shadow-lg">

                <!-- Header con gradiente -->
                <div class="modal-header modal-header-custom border-0">
                    <div class="w-100">
                        <div class="text-center">
                            <h5 class="m-0 font-weight-bold" id="nuevaMateriaLabel">
                                📓 Nueva Materia
                            </h5>
                            <p class="m-0 mt-2 mb-0" style="font-size: 0.9rem; opacity: 0.95;">
                                Registre la información de la nueva materia
                            </p>
                        </div>
                    </div>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar"
                        style="position: absolute; right: 1.5rem; top: 1.5rem; font-size: 1.8rem; opacity: 0.9;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Formulario -->
                <form action="{{ route('materias.store') }}" method="POST">
                    @csrf
                    <div class="modal-body modal-body-custom p-4">

                        <!-- Contenedor principal -->
                        <div class="form-container p-4 bg-white rounded shadow-sm border">

                            <!-- Sección 1: Identificación -->
                            <div class="info-section mb-4 ">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label-custom d-flex">
                                                🔑 Clave
                                                <span class="required-asterisk ml-1">*</span>
                                            </label>
                                            <input type="text" name="clave"
                                                class="form-control form-control-custom" placeholder="Ej: MAT-101"
                                                required>
                                            <small class="form-text text-muted">Código único identificador</small>
                                        </div>
                                    </div>

                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="form-label-custom d-flex">
                                                📝 Nombre de la Materia
                                                <span class="required-asterisk ml-1">*</span>
                                            </label>
                                            <input type="text" name="nombre"
                                                class="form-control form-control-custom"
                                                placeholder="Ej: Matemáticas Aplicadas" required>
                                            <small class="form-text text-muted">Nombre completo de la
                                                asignatura</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sección 2: Clasificación Académica -->
                            <div class="academic-section mb-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label-custom d-flex">
                                                🎯 Tipo de Competencia
                                            </label>
                                            <select name="id_tipo_competencia"
                                                class="form-control form-control-custom">
                                                <option value="">-- Seleccione una competencia --</option>
                                                @foreach ($competencias as $competencia)
                                                    <option value="{{ $competencia->id_tipo_competencia }}">
                                                        {{ $competencia->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label-custom d-flex">
                                                🎓 Modalidad
                                            </label>
                                            <select name="id_modalidad" class="form-control form-control-custom">
                                                <option value="">-- Seleccione una modalidad --</option>
                                                @foreach ($modalidades as $modalidad)
                                                    <option value="{{ $modalidad->id_modalidad }}">
                                                        {{ $modalidad->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label-custom d-flex">
                                                🏫 Espacio Formativo
                                            </label>
                                            <select name="id_espacio_formativo"
                                                class="form-control form-control-custom">
                                                <option value="">-- Seleccione un espacio --</option>
                                                @foreach ($espaciosformativos as $espacio)
                                                    <option value="{{ $espacio->id_espacio_formativo }}">
                                                        {{ $espacio->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label-custom d-flex">
                                                📚 Plan de Estudio
                                            </label>
                                            <select name="id_plan_estudio" class="form-control form-control-custom">
                                                <option value="">-- Seleccione un plan --</option>
                                                @foreach ($planes as $plan)
                                                    <option value="{{ $plan->id_plan_estudio }}">
                                                        {{ $plan->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sección 3: Carga Académica -->
                            <div class="workload-section mb-4">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label-custom d-flex">
                                                ⭐ Créditos
                                            </label>
                                            <input type="number" name="creditos"
                                                class="form-control form-control-custom" placeholder="0"
                                                min="0" step="0.5">
                                            <small class="form-text text-muted">Valor en créditos</small>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label-custom d-flex">
                                                ⏰ Horas
                                            </label>
                                            <input type="number" name="horas"
                                                class="form-control form-control-custom" placeholder="0"
                                                min="0">
                                            <small class="form-text text-muted">Horas totales</small>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label-custom d-flex">
                                                📅 Numero de Período
                                            </label>
                                            <select name="id_numero_periodo" class="form-control form-control-custom">
                                                <option value="">-- Seleccione --</option>
                                                @foreach ($periodos as $periodo)
                                                    <option value="{{ $periodo->id_numero_periodo }}">
                                                        {{ $periodo->tipoPeriodo->nombre }} - {{ $periodo->numero }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Nota de campos obligatorios -->
                            <div class="text-center">
                                <small class="text-muted">
                                    <span class="required-asterisk">*</span> Campos obligatorios
                                </small>
                            </div>

                        </div>

                    </div>

                    <!-- Footer -->
                    <div class="modal-footer modal-footer-custom border-top">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times mr-2"></i>
                            Cancelar
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save mr-2"></i>
                            Guardar Materia
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JS para autocalcular horas totales y eliminar unidades -->
    <script>
        // Autocalcular horas totales
        document.addEventListener("input", function(e) {
            if (e.target.classList.contains("horas-saber") ||
                e.target.classList.contains("horas-saber-hacer")) {

                let row = e.target.closest("tr, .form-row");
                if (!row) return;

                let saber = parseInt(row.querySelector(".horas-saber")?.value) || 0;
                let hacer = parseInt(row.querySelector(".horas-saber-hacer")?.value) || 0;

                let totalInput = row.querySelector(".horas-totales");
                if (totalInput) {
                    totalInput.value = saber + hacer;
                }
            }
        });

        // Función segura para eliminar unidad
        function eliminarUnidad(formId) {
            if (confirm('¿Seguro que deseas eliminar esta unidad?')) {
                document.getElementById(formId).submit();
            }
        }
    </script>


    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
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


</body>

</html>
