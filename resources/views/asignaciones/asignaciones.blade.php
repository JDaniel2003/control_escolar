<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Asignaciones Docentes</title>

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

    <!-- Logout Modal -->
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
            <div style="width: 300px; height: 120px;">
                <img src="{{ asset('libs/sbadmin/img/upn.png') }}" alt="Logo"
                    style="width: 100%; height: 100%; object-fit: cover;">
            </div>
        </div>

        <div class="collapse navbar-collapse ml-4">
            <ul class="navbar-nav" style="padding-left: 20%;">
                <li class="nav-item">
                    <a class="nav-link text-white px-3 mr-1" href="{{ route('admin') }}">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white px-3 mr-1" href="{{ route('periodos.index') }}">Períodos Escolares</a>
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
                    <a class="nav-link navbar-active-item px-3 mr-1">Asignaciones Docentes</a>
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
                        Gestión de Asignaciones Docentes</h1>

                    <div class="row justify-content-center">
                        <div class="col-lg-11">

                            <!-- Botón para nueva asignación -->
                            <div class="mb-3 text-right">
                                <a href="{{ route('asignaciones.masiva.index') }}" class="btn btn-info mr-2">
                                    <i class="fas fa-layer-group"></i> Asignación Masiva
                                </a>
                                <button type="button" class="btn btn-success" data-toggle="modal"
                                    data-target="#nuevaAsignacionModal">
                                    <i class="fas fa-plus"></i> Nueva Asignación
                                </button>
                            </div>

                            <!-- Filtros -->
                            <div class="container mb-4 d-flex justify-content-center">
                                <div class="p-3 border rounded bg-light d-inline-block shadow-sm">
                                    <form id="filtrosForm" method="GET" action="{{ route('asignaciones.index') }}"
                                        class="d-flex flex-wrap gap-2 align-items-center">

                                        <!-- Búsqueda por nombre -->
                                        <div class="flex-grow-1" style="width: 300px;">
                                            <input type="text" name="buscar" class="form-control form-control-sm"
                                                placeholder="🔍 Buscar docente" value="{{ request('buscar') }}">
                                        </div>

                                        <!-- Filtro Docente -->
                                        <select name="id_docente" class="form-control form-control-sm w-auto">
                                            <option value="">Todos los docentes</option>
                                            @foreach ($docentes as $docente)
                                                <option value="{{ $docente->id_usuario }}"
                                                    {{ request('id_docente') == $docente->id_usuario ? 'selected' : '' }}>
                                                    {{ $docente->username }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <!-- Filtro Materia -->
                                        <select name="id_materia" class="form-control form-control-sm w-auto">
                                            <option value="">Todas las materias</option>
                                            @foreach ($materias as $materia)
                                                <option value="{{ $materia->id_materia }}"
                                                    {{ request('id_materia') == $materia->id_materia ? 'selected' : '' }}>
                                                    {{ $materia->nombre }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <!-- Filtro Período -->
                                        <select name="id_periodo_escolar" class="form-control form-control-sm w-auto">
                                            <option value="">Todos los períodos</option>
                                            @foreach ($periodos as $periodo)
                                                <option value="{{ $periodo->id_periodo_escolar }}"
                                                    {{ request('id_periodo_escolar') == $periodo->id_periodo_escolar ? 'selected' : '' }}>
                                                    {{ $periodo->nombre }}
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
                                            <option value="todo" {{ request('mostrar') == 'todo' ? 'selected' : '' }}>
                                                Todo</option>
                                        </select>

                                        <!-- Botón Mostrar todo -->
                                        <a href="{{ route('asignaciones.index', ['mostrar' => 'todo']) }}"
                                            class="btn btn-sm btn-outline-secondary d-flex align-items-center">
                                            <i class="fas fa-list me-1"></i> Mostrar todo
                                        </a>
                                    </form>
                                </div>
                            </div>

                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    let form = document.getElementById("filtrosForm");
                                    form.querySelectorAll("input, select").forEach(el => {
                                        el.addEventListener("change", function() {
                                            form.submit();
                                        });
                                    });

                                    let typingTimer;
                                    let buscarInput = form.querySelector("input[name='buscar']");
                                    if (buscarInput) {
                                        buscarInput.addEventListener("keyup", function() {
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

                                @if ($errors->has('error'))
                                    <div class="alert alert-danger">{{ $errors->first('error') }}</div>
                                @endif

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="thead-dark text-center">
                                            <tr>
                                                <th>Docente</th>
                                                <th>Materia</th>
                                                <th>Grupo</th>
                                                <th>Período Escolar</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($asignaciones as $asignacion)
                                                <tr class="text-center">
                                                    <td>{{ $asignacion->docente->username ?? 'N/A' }}</td>
                                                    <td>{{ $asignacion->materia->nombre ?? 'N/A' }}</td>
                                                    <td>{{ $asignacion->grupo->nombre ?? 'N/A' }}</td>
                                                    <td>{{ $asignacion->periodoEscolar->nombre ?? 'N/A' }}</td>
                                                    <td>
                                                        <!-- Botón Editar -->
                                                        <button type="button" class="btn btn-warning btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#editarModal{{ $asignacion->id_asignacion }}">
                                                            <i class="fas fa-edit"></i> Editar
                                                        </button>

                                                        <!-- Modal Editar -->
                                                        <div class="modal fade"
                                                            id="editarModal{{ $asignacion->id_asignacion }}"
                                                            tabindex="-1" role="dialog"
                                                            aria-labelledby="editarModalLabel{{ $asignacion->id_asignacion }}"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content border-0 shadow-lg">
                                                                    <div
                                                                        class="modal-header modal-header-custom border-0">
                                                                        <div class="w-100">
                                                                            <div class="text-center">
                                                                                <h5 class="m-0 font-weight-bold">
                                                                                    ✏️ Editar Asignación Docente
                                                                                </h5>
                                                                                <p class="text-center m-0 mt-2"
                                                                                    style="font-size: 0.9rem; opacity: 0.95;">
                                                                                    Modifique la información de la
                                                                                    asignación
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                        <button type="button" class="close text-white"
                                                                            data-dismiss="modal" aria-label="Cerrar"
                                                                            style="position: absolute; right: 1.5rem; top: 1.5rem; font-size: 1.8rem; opacity: 0.9;">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>

                                                                    <form
                                                                        action="{{ route('asignaciones.update', $asignacion->id_asignacion) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <div class="modal-body modal-body-custom p-4">
                                                                            <div
                                                                                class="form-container p-4 bg-white rounded shadow-sm border">

                                                                                <div class="form-group mb-3">
                                                                                    <label
                                                                                        style="text-align: left; display: block;">
                                                                                        👨‍🏫 Docente <span
                                                                                            class="required-asterisk">*</span>
                                                                                    </label>
                                                                                    <select name="id_docente"
                                                                                        class="form-control form-control-custom @error('id_docente') is-invalid @enderror"
                                                                                        required>
                                                                                        <option value="">-- Seleccione
                                                                                            un docente --</option>
                                                                                        @foreach ($docentes as $docente)
                                                                                            <option
                                                                                                value="{{ $docente->id_usuario }}"
                                                                                                {{ $asignacion->id_docente == $docente->id_usuario ? 'selected' : '' }}>
                                                                                                {{ $docente->username }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                    @error('id_docente')
                                                                                        <div class="invalid-feedback">
                                                                                            {{ $message }}</div>
                                                                                    @enderror
                                                                                </div>

                                                                                <div class="form-group mb-3">
                                                                                    <label
                                                                                        style="text-align: left; display: block;">
                                                                                        📚 Materia <span
                                                                                            class="required-asterisk">*</span>
                                                                                    </label>
                                                                                    <select name="id_materia"
                                                                                        class="form-control form-control-custom @error('id_materia') is-invalid @enderror"
                                                                                        required>
                                                                                        <option value="">-- Seleccione
                                                                                            una materia --</option>
                                                                                        @foreach ($materias as $materia)
                                                                                            <option
                                                                                                value="{{ $materia->id_materia }}"
                                                                                                {{ $asignacion->id_materia == $materia->id_materia ? 'selected' : '' }}>
                                                                                                {{ $materia->nombre }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                    @error('id_materia')
                                                                                        <div class="invalid-feedback">
                                                                                            {{ $message }}</div>
                                                                                    @enderror
                                                                                </div>

                                                                                <div class="form-group mb-3">
                                                                                    <label
                                                                                        style="text-align: left; display: block;">
                                                                                        👥 Grupo <span
                                                                                            class="required-asterisk">*</span>
                                                                                    </label>
                                                                                    <select name="id_grupo"
                                                                                        class="form-control form-control-custom @error('id_grupo') is-invalid @enderror"
                                                                                        required>
                                                                                        <option value="">-- Seleccione
                                                                                            un grupo --</option>
                                                                                        @foreach ($grupos as $grupo)
                                                                                            <option
                                                                                                value="{{ $grupo->id_grupo }}"
                                                                                                {{ $asignacion->id_grupo == $grupo->id_grupo ? 'selected' : '' }}>
                                                                                                {{ $grupo->nombre }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                    @error('id_grupo')
                                                                                        <div class="invalid-feedback">
                                                                                            {{ $message }}</div>
                                                                                    @enderror
                                                                                </div>

                                                                                <div class="form-group mb-0">
                                                                                    <label
                                                                                        style="text-align: left; display: block;">
                                                                                        📅 Período Escolar <span
                                                                                            class="required-asterisk">*</span>
                                                                                    </label>
                                                                                    <select name="id_periodo_escolar"
                                                                                        class="form-control form-control-custom @error('id_periodo_escolar') is-invalid @enderror"
                                                                                        required>
                                                                                        <option value="">-- Seleccione
                                                                                            un período --</option>
                                                                                        @foreach ($periodos as $periodo)
                                                                                            <option
                                                                                                value="{{ $periodo->id_periodo_escolar }}"
                                                                                                {{ $asignacion->id_periodo_escolar == $periodo->id_periodo_escolar ? 'selected' : '' }}>
                                                                                                {{ $periodo->nombre }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                    @error('id_periodo_escolar')
                                                                                        <div class="invalid-feedback">
                                                                                            {{ $message }}</div>
                                                                                    @enderror
                                                                                </div>

                                                                            </div>
                                                                        </div>

                                                                        <div class="modal-footer modal-footer-custom">
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-dismiss="modal">
                                                                                Cancelar
                                                                            </button>
                                                                            <button type="submit"
                                                                                class="btn btn-success">
                                                                                ✓ Actualizar Asignación
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Botón Eliminar -->
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#eliminarModal{{ $asignacion->id_asignacion }}">
                                                            <i class="fas fa-trash-alt"></i> Eliminar
                                                        </button>

                                                        <!-- Modal Eliminar -->
                                                        <div class="modal fade"
                                                            id="eliminarModal{{ $asignacion->id_asignacion }}"
                                                            tabindex="-1" role="dialog" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div
                                                                        class="modal-header1 modal-header-custom border-0">
                                                                        <div class="w-100">
                                                                            <div class="text-center">
                                                                                <h5 class="m-0 font-weight-bold">
                                                                                    🗑️ Eliminar Asignación
                                                                                </h5>
                                                                            </div>
                                                                        </div>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Cerrar">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        ¿Seguro que deseas eliminar la asignación del
                                                                        docente
                                                                        <strong>{{ $asignacion->docente->username ?? 'N/A' }}</strong>
                                                                        para la materia
                                                                        <strong>{{ $asignacion->materia->nombre ?? 'N/A' }}</strong>?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-secondary"
                                                                            data-dismiss="modal">Cancelar</button>
                                                                        <form
                                                                            action="{{ route('asignaciones.destroy', $asignacion->id_asignacion) }}"
                                                                            method="POST"
                                                                            style="display:inline-block;">
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
                                                    <td colspan="5" class="text-center text-muted">No hay asignaciones
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

    <!-- Modal Nueva Asignación -->
    <div class="modal fade" id="nuevaAsignacionModal" tabindex="-1" role="dialog"
        aria-labelledby="nuevaAsignacionLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content border-0 shadow-lg">

                <div class="modal-header modal-header-custom border-0">
                    <div class="w-100">
                        <div class="text-center">
                            <h5 class="m-0 font-weight-bold" id="nuevaAsignacionLabel">
                                🎓 Nueva Asignación Docente
                            </h5>
                            <p class="m-0 mt-2 mb-0" style="font-size: 0.9rem; opacity: 0.95;">
                                Complete la información de la asignación
                            </p>
                        </div>
                    </div>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar"
                        style="position: absolute; right: 1.5rem; top: 1.5rem; font-size: 1.8rem; opacity: 0.9;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('asignaciones.store') }}" method="POST">
                    @csrf
                    <div class="modal-body modal-body-custom p-4">

                        <div class="form-container p-4 bg-white rounded shadow-sm border">

                            <div class="form-group mb-3">
                                <label class="form-label-custom d-flex">
                                    👨‍🏫 Docente
                                    <span class="required-asterisk ml-1">*</span>
                                </label>
                                <select name="id_docente"
                                    class="form-control form-control-custom @error('id_docente') is-invalid @enderror"
                                    required>
                                    <option value="">-- Seleccione un docente --</option>
                                    @foreach ($docentes as $docente)
                                        <option value="{{ $docente->id_usuario }}"
                                            {{ old('id_docente') == $docente->id_usuario ? 'selected' : '' }}>
                                            {{ $docente->username }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_docente')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label-custom d-flex">
                                    📚 Materia
                                    <span class="required-asterisk ml-1">*</span>
                                </label>
                                <select name="id_materia"
                                    class="form-control form-control-custom @error('id_materia') is-invalid @enderror"
                                    required>
                                    <option value="">-- Seleccione una materia --</option>
                                    @foreach ($materias as $materia)
                                        <option value="{{ $materia->id_materia }}"
                                            {{ old('id_materia') == $materia->id_materia ? 'selected' : '' }}>
                                            {{ $materia->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_materia')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label-custom d-flex">
                                    👥 Grupo
                                    <span class="required-asterisk ml-1">*</span>
                                </label>
                                <select name="id_grupo"
                                    class="form-control form-control-custom @error('id_grupo') is-invalid @enderror"
                                    required>
                                    <option value="">-- Seleccione un grupo --</option>
                                    @foreach ($grupos as $grupo)
                                        <option value="{{ $grupo->id_grupo }}"
                                            {{ old('id_grupo') == $grupo->id_grupo ? 'selected' : '' }}>
                                            {{ $grupo->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_grupo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-2">
                                <label class="form-label-custom d-flex">
                                    📅 Período Escolar
                                    <span class="required-asterisk ml-1">*</span>
                                </label>
                                <select name="id_periodo_escolar"
                                    class="form-control form-control-custom @error('id_periodo_escolar') is-invalid @enderror"
                                    required>
                                    <option value="">-- Seleccione un período --</option>
                                    @foreach ($periodos as $periodo)
                                        <option value="{{ $periodo->id_periodo_escolar }}"
                                            {{ old('id_periodo_escolar') == $periodo->id_periodo_escolar ? 'selected' : '' }}>
                                            {{ $periodo->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_periodo_escolar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Nota de campos obligatorios -->
                            <div class="text-center mt-3">
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
                            Guardar Asignación
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                $('#nuevaAsignacionModal').modal('show');
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