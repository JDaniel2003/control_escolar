<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Períodos Escolares</title>

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
                    <a class="nav-link  navbar-active-item px-3 mr-1">Períodos Escolares</a>
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
                        Gestión de Períodos Escolares</h1>

                    <div class="row justify-content-center">
                        <div class="col-lg-10">

                            <!-- Botón para nuevo período -->
                            <div class="mb-3 text-right">
                                <button type="button" class="btn btn-success" data-toggle="modal"
                                    data-target="#nuevoPeriodoModal">
                                    <i class="fas fa-plus"></i> Nuevo Período
                                </button>
                            </div>


                            <!-- Filtros -->
                            <div class="container mb-4 d-flex justify-content-center">
                                <div class="p-3 border rounded bg-light d-inline-block shadow-sm">
                                    <form id="filtrosForm" method="GET" action="{{ route('periodos.index') }}"
                                        class="d-flex flex-wrap gap-2 align-items-center">

                                        <!-- Nombre -->
                                        <div class="flex-grow-1" style="width: 400px;">
                                            <input type="text" name="nombre" class="form-control form-control-sm"
                                                placeholder="🔍 Buscar por nombre" value="{{ request('nombre') }}">
                                        </div>

                                        <!-- Tipo de período -->
                                        <select name="id_tipo_periodo" class="form-control form-control-sm w-auto">
                                            <option value="">Tipo de período</option>
                                            @foreach ($tipos as $tipo)
                                                <option value="{{ $tipo->id_tipo_periodo }}"
                                                    {{ old('id_tipo_periodo') == $tipo->id_tipo_periodo ? 'selected' : '' }}>
                                                    {{ $tipo->nombre }}
                                                </option>
                                            @endforeach
                                        </select>



                                        <!-- Estado -->
                                        <select name="estado" class="form-control form-control-sm w-auto">
                                            <option value="">Estado</option>
                                            <option value="Abierto"
                                                {{ request('estado') == 'Abierto' ? 'selected' : '' }}>Abierto</option>
                                            <option value="Cerrado"
                                                {{ request('estado') == 'Cerrado' ? 'selected' : '' }}>Cerrado</option>
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
                                        <a href="{{ route('periodos.index', ['mostrar' => 'todo']) }}"
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

                            <!-- Tabla -->

                            <div class="card-body1">
                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="thead-dark text-center">
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Tipo de Período</th>
                                                <th>Fecha Inicio</th>
                                                <th>Fecha Fin</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($periodos as $periodo)
                                                <tr class="text-center">
                                                    <td>{{ $periodo->nombre }}</td>
                                                    <td>{{ $periodo->tipoPeriodo->nombre ?? 'N/A' }}</td>
                                                    <td>{{ $periodo->fecha_inicio }}</td>
                                                    <td>{{ $periodo->fecha_fin }}</td>
                                                    <td>{{ $periodo->estado }}</td>
                                                    <td>
                                                        <!-- Botón Editar -->
                                                        <button type="button" class="btn btn-warning btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#editarModal{{ $periodo->id_periodo_escolar }}">
                                                            <i class="fas fa-edit"></i> Editar
                                                        </button>

                                                        <!-- Modal Editar -->
                                                        <div class="modal fade"
                                                            id="editarModal{{ $periodo->id_periodo_escolar }}"
                                                            tabindex="-1" role="dialog"
                                                            aria-labelledby="editarModalLabel{{ $periodo->id_periodo_escolar }}"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content border-0 shadow-lg">

                                                                    <div class="modal-header modal-header-custom border-0">
                                                                        <div class="w-100">
                                                                            <div class="text-center">
                                                                                <h5 class="m-0 font-weight-bold"
                                                                                    id="editarModalLabel{{ $periodo->id_periodo_escolar }}">
                                                                                    ✏️ Editar Período Escolar
                                                                                </h5>
                                                                                <p class="text-center m-0 mt-2"
                                                                                    style="font-size: 0.9rem; opacity: 0.95;">
                                                                                    Modifique la información del período
                                                                                    escolar
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                        <button type="button"
                                                                            class="close text-white"
                                                                            data-dismiss="modal" aria-label="Cerrar"
                                                                            style="position: absolute; right: 1.5rem; top: 1.5rem; font-size: 1.8rem; opacity: 0.9;">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>


                                                                    <form
                                                                        action="{{ route('periodos.update', $periodo->id_periodo_escolar) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <div class="modal-body modal-body-custom p-4">

                                                                            <div class="form-container p-4 bg-white rounded shadow-sm border">

                                                                                <div class="form-section mb-4">

                                                                                    <div class="form-group mb-3">
                                                                                        <label
                                                                                            style="text-align: left; display: block;">
                                                                                            📝 Nombre del Período <span
                                                                                                class="required-asterisk">*</span>
                                                                                        </label>
                                                                                        <input type="text"
                                                                                            placeholder="Ejemplo: JULIO-DICIEMBRE 2024"
                                                                                            name="nombre"
                                                                                            value="{{ $periodo->nombre }}"
                                                                                            class="form-control form-control-custom @error('nombre') is-invalid @enderror"
                                                                                            required>
                                                                                        @error('nombre')
                                                                                            <div class="invalid-feedback">
                                                                                                {{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>

                                                                                    <div class="form-group">
                                                                                        <label
                                                                                            style="text-align: left; display: block;">
                                                                                            🏷️ Tipo de Período <span
                                                                                                class="required-asterisk">*</span>
                                                                                        </label>
                                                                                        <select name="id_tipo_periodo"
                                                                                            class="form-control form-control-custom @error('id_tipo_periodo') is-invalid @enderror"
                                                                                            required>
                                                                                            <option value="">--
                                                                                                Seleccione un tipo de período --
                                                                                            </option>
                                                                                            @foreach ($tipos as $tipo)
                                                                                                <option
                                                                                                    value="{{ $tipo->id_tipo_periodo }}"
                                                                                                    {{ $periodo->id_tipo_periodo == $tipo->id_tipo_periodo ? 'selected' : '' }}>
                                                                                                    {{ $tipo->nombre }}
                                                                                                </option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                        @error('id_tipo_periodo')
                                                                                            <div class="invalid-feedback">
                                                                                                {{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>

                                                                                    <div class="row">
                                                                                        <div class="col-md-6">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    style="text-align: left; display: block;">
                                                                                                    📅 Fecha de Inicio
                                                                                                    <span
                                                                                                        class="required-asterisk">*</span>
                                                                                                </label>
                                                                                                <input type="date"
                                                                                                    name="fecha_inicio"
                                                                                                    value="{{ $periodo->fecha_inicio }}"
                                                                                                    class="form-control form-control-custom @error('fecha_inicio') is-invalid @enderror"
                                                                                                    required>
                                                                                                @error('fecha_inicio')
                                                                                                    <div
                                                                                                        class="invalid-feedback">
                                                                                                        {{ $message }}
                                                                                                    </div>
                                                                                                @enderror
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="col-md-6">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    style="text-align: left; display: block;">
                                                                                                    📅 Fecha de
                                                                                                    Finalización
                                                                                                    <span
                                                                                                        class="required-asterisk">*</span>
                                                                                                </label>
                                                                                                <input type="date"
                                                                                                    name="fecha_fin"
                                                                                                    value="{{ $periodo->fecha_fin }}"
                                                                                                    class="form-control form-control-custom @error('fecha_fin') is-invalid @enderror"
                                                                                                    required>
                                                                                                @error('fecha_fin')
                                                                                                    <div
                                                                                                        class="invalid-feedback">
                                                                                                        {{ $message }}
                                                                                                    </div>
                                                                                                @enderror
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="form-group mb-0">
                                                                                        <label
                                                                                            style="text-align: left; display: block;">
                                                                                            ⚡ Estado del Período <span
                                                                                                class="required-asterisk">*</span>
                                                                                        </label>
                                                                                        <select name="estado"
                                                                                            class="form-control form-control-custom @error('estado') is-invalid @enderror"
                                                                                            required>
                                                                                            <option value="">--
                                                                                                Seleccione el estado --
                                                                                            </option>
                                                                                            <option value="Abierto"
                                                                                                {{ $periodo->estado == 'Abierto' ? 'selected' : '' }}>
                                                                                                Abierto
                                                                                            </option>
                                                                                            <option value="Cerrado"
                                                                                                {{ $periodo->estado == 'Cerrado' ? 'selected' : '' }}>
                                                                                                Cerrado
                                                                                            </option>
                                                                                        </select>
                                                                                        @error('estado')
                                                                                            <div class="invalid-feedback">
                                                                                                {{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>

                                                                                </div>
                                                                            </div>

                                                                            <div
                                                                                class="modal-footer modal-footer-custom">
                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                                                    Cancelar
                                                                                </button>
                                                                                <button type="submit" class="btn btn-success">
                                                                                    ✓ Actualizar Período
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </form>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <form action="{{ route('periodos.destroy', $periodo) }}"
                                                            method="POST" style="display:inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                data-toggle="modal"
                                                                data-target="#eliminarModal{{ $periodo->id_periodo_escolar }}">
                                                                <i class="fas fa-trash-alt"></i> Eliminar
                                                            </button>

                                                            <!-- Modal de Confirmación -->
                                                            <div class="modal fade" id="eliminarModal{{ $periodo->id_periodo_escolar }}"
                                                                tabindex="-1" role="dialog"
                                                                aria-labelledby="eliminarModalLabel{{ $periodo->id_periodo_escolar }}"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header1 modal-header-custom border-0">
                                                                            <div class="w-100">
                                                                                <div class="text-center">

                                                                                    <h5 class="m-0 font-weight-bold"
                                                                                        id="eliminarModalLabel{{ $periodo->id_periodo_escolar }}">
                                                                                        🗑️ Eliminar Período
                                                                                    </h5>
                                                                                </div>
                                                                            </div>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal"
                                                                                aria-label="Cerrar">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            ¿Seguro que deseas eliminar el período
                                                                            <strong>{{ $periodo->nombre }}</strong>?
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-dismiss="modal">Cancelar</button>
                                                                            <form
                                                                                action="{{ route('periodos.destroy', $periodo) }}"
                                                                                method="POST"
                                                                                style="display:inline-block;">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="100" class="text-center text-muted">No hay períodos
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






    <!-- Modal Nuevo Período -->
    <div class="modal fade" id="nuevoPeriodoModal" tabindex="-1" role="dialog"
        aria-labelledby="nuevoPeriodoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content border-0 shadow-lg">

                <!-- Header con gradiente -->
                <div class="modal-header modal-header-custom border-0">
                    <div class="w-100">
                        <div class="text-center">
                            <h5 class="m-0 font-weight-bold" id="nuevoPeriodoLabel">
                                📚 Nuevo Período Escolar
                            </h5>
                            <p class="m-0 mt-2 mb-0" style="font-size: 0.9rem; opacity: 0.95;">
                                Complete la información del período escolar
                            </p>
                        </div>
                    </div>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar"
                        style="position: absolute; right: 1.5rem; top: 1.5rem; font-size: 1.8rem; opacity: 0.9;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('periodos.store') }}" method="POST">
                    @csrf
                    <div class="modal-body modal-body-custom p-4">

                        <!-- Contenedor principal con borde y sombra -->
                        <div class="form-container p-4 bg-white rounded shadow-sm border">

                            <!-- Sección 1: Información Básica -->
                            <div class="info-section mb-4 ">

                                <div class="form-group mb-3">
                                    <label class="form-label-custom d-flex">
                                        📝 Nombre del Período
                                        <span class="required-asterisk ml-1">*</span>
                                    </label>
                                    <small class="form-text text-muted">
                                        Ingrese un nombre descriptivo para el período escolar
                                    </small>
                                    <input type="text" placeholder="Ejemplo: JULIO-DICIEMBRE 2024" name="nombre"
                                        value="{{ old('nombre') }}"
                                        class="form-control form-control-custom @error('nombre') is-invalid @enderror"
                                        required>
                                    @error('nombre')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>


                            </div>
                            <div class="dates-section mb-4">

                                <div class="form-group mb-0">
                                    <label class="form-label-custom d-flex">
                                        🏷️ Tipo de Período
                                        <span class="required-asterisk ml-1">*</span>
                                    </label>
                                    <select name="id_tipo_periodo"
                                        class="form-control form-control-custom @error('id_tipo_periodo') is-invalid @enderror"
                                        required>
                                        <option value="">-- Seleccione un tipo de período --</option>
                                        @foreach ($tipos as $tipo)
                                            <option value="{{ $tipo->id_tipo_periodo }}"
                                                {{ old('id_tipo_periodo') == $tipo->id_tipo_periodo ? 'selected' : '' }}>
                                                {{ $tipo->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_tipo_periodo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Sección 2: Fechas -->
                            <div class="dates-section mb-4">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label-custom d-flex">
                                                📅 Fecha de Inicio
                                                <span class="required-asterisk ml-1">*</span>
                                            </label>
                                            <input type="date" name="fecha_inicio"
                                                value="{{ old('fecha_inicio') }}"
                                                class="form-control form-control-custom @error('fecha_inicio') is-invalid @enderror"
                                                required>
                                            @error('fecha_inicio')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label-custom d-flex">
                                                📅 Fecha de Finalización
                                                <span class="required-asterisk ml-1">*</span>
                                            </label>
                                            <input type="date" name="fecha_fin" value="{{ old('fecha_fin') }}"
                                                class="form-control form-control-custom @error('fecha_fin') is-invalid @enderror"
                                                required>
                                            @error('fecha_fin')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sección 3: Estado -->
                            <div class="status-section mb-4">

                                <div class="form-group mb-2">
                                    <label class="form-label-custom d-flex">
                                        ⚡ Estado del Período
                                        <span class="required-asterisk ml-1">*</span>
                                    </label>
                                    <select name="estado"
                                        class="form-control form-control-custom @error('estado') is-invalid @enderror"
                                        required>
                                        <option value="">-- Seleccione el estado del período--</option>
                                        <option value="Abierto" {{ old('estado') == 'Abierto' ? 'selected' : '' }}>
                                            Abierto
                                        </option>
                                        <option value="Cerrado" {{ old('estado') == 'Cerrado' ? 'selected' : '' }}>
                                            Cerrado
                                        </option>
                                    </select>
                                    @error('estado')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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

                    <div class="modal-footer modal-footer-custom border-top">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times mr-2"></i>
                            Cancelar
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save mr-2"></i>
                            Guardar Período
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>







    @if ($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                $('#nuevoPeriodoModal').modal('show');
            });
        </script>
    @endif





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
