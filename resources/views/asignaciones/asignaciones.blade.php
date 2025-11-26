<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
                <div class="modal-header bg-danger">

                    <div class="w-100 text-center">
                        <h5 class="m-0 font-weight-bold" id="logoutModalLabel">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            Cerrar Sesión
                        </h5>
                    </div>
                    <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close"
                        style="position: absolute; right: 1rem; top: 1rem; opacity: 0.9;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Body -->
                <div class="modal-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-exclamation-circle text-warning" style="font-size: 4rem;"></i>
                    </div>
                    <h6 class="font-weight-bold mb-3">¿Desea cerrar su sesión?</h6>
                    <p class="text-muted mb-0">
                        Al cerrar sesión, será redirigido a la página de inicio de sesión.
                    </p>
                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button class="btn btn-secondary px-4" type="button" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i>
                        Cancelar
                    </button>

                    <!-- Formulario para cerrar sesión -->
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger px-4">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            Cerrar Sesión
                        </button>
                    </form>
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
               <li class="nav-item"><a class="nav-link text-white px-3 mr-1"
                        href="{{ route('calificaciones.index') }}">Calificaciones</a></li>
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
                                <!-- Botón para asignación masiva (ahora abre modal) -->
                                <button type="button" class="btn btn-success" data-toggle="modal"
                                    data-target="#asignacionMasivaModal">
                                    <i class="fas fa-layer-group"></i> Asignación Masiva
                                </button>
                                <button type="button" class="btn btn-success" data-toggle="modal"
                                    data-target="#nuevaAsignacionModal">
                                    <i class="fas fa-plus"></i> Nueva Asignación
                                </button>
                            </div>

                            <!-- Filtros -->
                            <div class="container mb-4 d-flex justify-content-center">
                                <div class="p-3 border rounded bg-light shadow-sm d-inline-block">
                                    <form id="filtrosForm" method="GET" action="{{ route('asignaciones.index') }}"
                                        class="d-flex flex-nowrap align-items-center gap-2">

                                        <!-- Búsqueda por nombre -->
                                        <div class="flex-grow-1" style="width: 350px;">
                                            <input type="text" name="buscar" class="form-control form-control-sm"
                                                placeholder="🔍 Buscar docente" value="{{ request('buscar') }}">
                                        </div>
                                        <!-- Filtro Materia -->
                                        <div class="flex-grow-1" style="width: 300px;">
                                            <input type="text" name="buscar_materia"
                                                class="form-control form-control-sm"
                                                placeholder="🔍 Buscar materia (Clave o Nombre)"
                                                value="{{ request('buscar_materia') }}">
                                        </div>

                                        <!-- Filtro Grupo -->
                                        <div class="flex-grow-1" style="width: 250px;">
                                            <input type="text" name="buscar_grupo"
                                                class="form-control form-control-sm" placeholder="🔍 Buscar grupo"
                                                value="{{ request('buscar_grupo') }}">
                                        </div>
                                        <!-- Filtro periodo -->
                                        <div class="flex-grow-1" style="width: 250px;">
                                            <input type="text" name="buscar_periodo"
                                                class="form-control form-control-sm"
                                                placeholder="🔍 Buscar Período Escolar"
                                                value="{{ request('buscar_periodo') }}">
                                        </div>

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
                                                {{ request('mostrar') == 'todo' ? 'selected' : '' }}>
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
                                // scrip para buscar en filtro automaticamente
                                document.addEventListener("DOMContentLoaded", function() {
                                    let form = document.getElementById("filtrosForm");

                                    form.querySelectorAll("select").forEach(el => {
                                        el.addEventListener("change", function() {
                                            form.submit();
                                        });
                                    });
                                    let typingTimer;
                                    const inputNames = [
                                        "buscar",
                                        "buscar_materia",
                                        "buscar_grupo",
                                        "buscar_periodo"
                                    ];

                                    inputNames.forEach(name => {
                                        let inputElement = form.querySelector(`input[name='${name}']`);
                                        if (inputElement) {
                                            inputElement.addEventListener("keyup", function() {
                                                clearTimeout(typingTimer);
                                                typingTimer = setTimeout(() => {
                                                    form.submit();
                                                }, 500);
                                            });
                                        }
                                    });
                                });
                            </script>

                            <!-- Tabla -->
                            <div class="card-body1">
                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                <!-- TEMPORAL: Obtener carreras directamente si no vienen del controlador -->


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
                                                    <td>
                                                        {{ $asignacion->docente->datosDocentes->load('abreviatura')->nombre_con_abreviatura ?? 'N/A' }}
                                                    </td>
                                                    <td>{{ $asignacion->materia->nombre ?? 'N/A' }}</td>
                                                    <td>{{ $asignacion->grupo->nombre ?? 'N/A' }}</td>
                                                    <td>{{ $asignacion->periodoEscolar->nombre ?? 'N/A' }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#detalleModal{{ $asignacion->id_asignacion }}">
                                                            <i class="fas fa-eye"></i> Ver Detalles
                                                        </button>
                                                        <!-- Botón Editar -->
                                                        <button type="button" class="btn btn-warning btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#editarModal{{ $asignacion->id_asignacion }}">
                                                            <i class="fas fa-edit"></i> Editar
                                                        </button>

                                                        <!-- Botón Eliminar -->
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#eliminarModal{{ $asignacion->id_asignacion }}">
                                                            <i class="fas fa-trash-alt"></i> Eliminar
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted">No hay
                                                        asignaciones
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

    <!-- ========== MODAL NUEVA ASIGNACIÓN INDIVIDUAL ========== -->
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

                <form action="{{ route('asignaciones.store') }}" method="POST" id="formNuevaAsignacion">
                    @if ($errors->any() && session('is_create_asignacion'))
                        <div class="alert alert-danger m-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @csrf
                    <div class="modal-body modal-body-custom p-4">
                        <div class="form-container p-4 bg-white rounded shadow-sm border">
                            <div class="info-section mb-2">
                                <div class="card shadow mb-4 border-0">

                                    <div class="card-header py-3 text-white card-header-custom">
                                        <h6 class="m-0 font-weight-bold">Seleccione Carrera, Grupo y Docente
                                        </h6>
                                    </div>
                                    <div class="info-section p-4 mb-4">

                                        <div class="row">
                                            <div class="col-md-7">
                                                <div class="form-group">
                                                    <label class="form-label-custom d-flex">
                                                        Carrera
                                                        <span class="required-asterisk ml-1">*</span>
                                                    </label>
                                                    <select id="carrera_nueva"
                                                        class="form-control form-control-custom" required>
                                                        <option value="">-- Seleccione una carrera --</option>
                                                        @foreach ($carreras as $carrera)
                                                            <option value="{{ $carrera->id_carrera }}">
                                                                {{ $carrera->nombre }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label class="form-label-custom d-flex">
                                                        Grupo
                                                        <span class="required-asterisk ml-1">*</span>
                                                    </label>
                                                    <select name="id_grupo" id="grupo_nueva"
                                                        class="form-control form-control-custom" required>
                                                        <option value="">-- Primero seleccione carrera --
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label class="form-label-custom d-flex">
                                                        Período Escolar

                                                    </label>
                                                    <input type="text" id="periodo_escolar_nueva_display"
                                                        class="form-control form-control-custom" readonly
                                                        placeholder="Seleccione un grupo">
                                                    <input type="hidden" name="id_periodo_escolar"
                                                        id="periodo_escolar_nueva">
                                                </div>
                                            </div>

                                            <div class="col-md-7">
                                                <div class="form-group">
                                                    <label class="form-label-custom d-flex">
                                                        Docente
                                                        <span class="required-asterisk ml-1">*</span>
                                                    </label>
                                                    <select name="id_docente" id="docente_nueva"
                                                        class="form-control form-control-custom" required>
                                                        <option value="">-- Seleccione un docente --</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label-custom d-flex">
                                                        Número de Período
                                                        <span class="required-asterisk ml-1">*</span>
                                                    </label>
                                                    <select id="numero_periodo_nueva"
                                                        class="form-control form-control-custom" required>
                                                        <option value="">-- Seleccione número de período --
                                                        </option>
                                                        @foreach ($numeroPeriodos as $numeroPeriodo)
                                                            <option value="{{ $numeroPeriodo->id_numero_periodo }}">
                                                                {{ $numeroPeriodo->numero }}° Período
                                                                @if ($numeroPeriodo->tipoPeriodo)
                                                                    ({{ $numeroPeriodo->tipoPeriodo->nombre }})
                                                                @endif
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="periodo-info mt-3">
                                            <i class="fas fa-info-circle text-primary"></i>
                                            <strong>Nota:</strong> Las materias se filtrarán según el número de período
                                            seleccionado.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sección 2: Selección de Materia -->
                            <div class="card shadow mb-4 border-0">
                                <div class="card-header py-3 text-white card-header-custom">
                                    <h6 class="m-0 font-weight-bold">Seleccione Materia</h6>
                                </div>
                                <div class="info-section mb-4">
                                    <div id="materias-container-nueva">
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle"></i> Seleccione primero una carrera y número
                                            de período para ver las materias disponibles
                                        </div>
                                    </div>
                                </div>
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

    <!-- ========== MODAL ASIGNACIÓN MASIVA ========== -->
    <div class="modal fade" id="asignacionMasivaModal" tabindex="-1" role="dialog"
        aria-labelledby="asignacionMasivaLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content border-0 shadow-lg">

                <div class="modal-header modal-header-custom border-0">
                    <div class="w-100">
                        <div class="text-center">
                            <h5 class="m-0 font-weight-bold" id="asignacionMasivaLabel">
                                📚 Asignación Masiva de Docentes
                            </h5>
                            <p class="m-0 mt-2 mb-0" style="font-size: 0.9rem; opacity: 0.95;">
                                Asigne múltiples materias con sus docentes a un grupo
                            </p>
                        </div>
                    </div>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar"
                        style="position: absolute; right: 1.5rem; top: 1.5rem; font-size: 1.8rem; opacity: 0.9;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('asignaciones.masiva.store-materias') }}" method="POST"
                    id="formAsignacionMasiva">
                    @if ($errors->any() && session('is_create_masiva'))
    <div class="alert alert-danger m-3">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                    @csrf
                    <div class="modal-body modal-body-custom p-4">
                        <div class="form-container p-4 bg-white rounded shadow-sm border">

                           

                            <!-- Sección 1: Selección de Grupo y Número de Período -->
                            <div class="card shadow mb-2 border-0">
                                <div class="card-header py-3  text-white card-header-custom">
                                    <h6 class="m-0 font-weight-bold">
                                        <i class="fas fa-users"></i> Seleccione Grupo y Número de Período
                                    </h6>
                                </div>
                                <div class="card-body1">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label-custom d-flex">
                                                    Carrera
                                                    <span class="required-asterisk ml-1">*</span>
                                                </label>
                                                <select id="carrera" class="form-control form-control-custom"
                                                    required>
                                                    <option value="">-- Seleccione una carrera --</option>
                                                    @foreach ($carreras as $carrera)
                                                        <option value="{{ $carrera->id_carrera }}">
                                                            {{ $carrera->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label-custom d-flex">
                                                    Grupo
                                                    <span class="required-asterisk ml-1">*</span>
                                                </label>
                                                <select name="id_grupo" id="grupo"
                                                    class="form-control form-control-custom" required>
                                                    <option value="">-- Primero seleccione carrera --</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label-custom d-flex">
                                                    Período Escolar
                                                </label>
                                                <input type="text" id="periodo_escolar_display"
                                                    class="form-control form-control-custom" readonly
                                                    placeholder="Seleccione un grupo">
                                                <input type="hidden" name="id_periodo_escolar" id="periodo_escolar">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label-custom d-flex">
                                                    Número de Período
                                                    <span class="required-asterisk ml-1">*</span>
                                                </label>
                                                <select name="id_numero_periodo" id="numero_periodo"
                                                    class="form-control form-control-custom" required>
                                                    <option value="">-- Seleccione número de período --</option>
                                                    @foreach ($numeroPeriodos as $numeroPeriodo)
                                                        <option value="{{ $numeroPeriodo->id_numero_periodo }}">
                                                            {{ $numeroPeriodo->numero }}° Período
                                                            @if ($numeroPeriodo->tipoPeriodo)
                                                                ({{ $numeroPeriodo->tipoPeriodo->nombre }})
                                                            @endif
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="periodo-info mt-3">
                                        <i class="fas fa-info-circle text-primary"></i>
                                        <strong>Nota:</strong> Al seleccionar el grupo, el período escolar se llenará
                                        automáticamente.
                                        Las materias se filtrarán según el número de período seleccionado.
                                    </div>
                                </div>
                            </div>

                            <!-- Sección 2: Selección de Materias con Docentes -->
                            <div class="card shadow mb-4 border-0">
                                <div
                                    class="card-header py-3  text-white card-header-custom d-flex justify-content-between align-items-center">
                                    <h6 class="m-0 font-weight-bold">
                                        <i class="fas fa-book"></i> Asigne Docentes a las Materias
                                    </h6>
                                    <button type="button" class="btn btn-sm btn-light select-all-btn"
                                        id="selectAll">
                                        <i class="fas fa-check-square"></i> Seleccionar Todas
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div id="materias-container">
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle"></i> Seleccione primero una carrera y número
                                            de período para ver las materias disponibles
                                        </div>
                                    </div>
                                </div>
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
                            Guardar Asignaciones
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modales de Detalle, Editar y Eliminar -->
    @foreach ($asignaciones as $asignacion)
        <!-- Modal Detalle -->
        <!-- Modal Detalle -->
        <div class="modal fade" id="detalleModal{{ $asignacion->id_asignacion }}" tabindex="-1" role="dialog"
            aria-labelledby="detalleModalLabel{{ $asignacion->id_asignacion }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header modal-header-custom border-0">
                        <div class="w-100">
                            <div class="text-center">
                                <h5 class="m-0 font-weight-bold"
                                    id="detalleModalLabel{{ $asignacion->id_asignacion }}">
                                    Detalles de la Asignación
                                </h5>
                                <p class="m-0 mt-2 mb-0" style="font-size: 0.9rem; opacity: 0.95;">
                                    Información completa de la asignación docente
                                </p>
                            </div>
                        </div>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar"
                            style="position: absolute; right: 1.5rem; top: 1.5rem; font-size: 1.8rem; opacity: 0.9;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body modal-body-custom p-4">
                        <div class="form-container p-4 bg-white rounded shadow-sm border">

                            <div class="card shadow mb-4 border-0">
                                <div class="card-header py-3 text-white card-header-custom">
                                    <h6 class="m-0 font-weight-bold text-danger">
                                        <i class="fas fa-chalkboard-teacher mr-2"></i>
                                        Información de la Asignación
                                    </h6>
                                </div>

                                <div class="card-body1 p-4 text-center">
                                    <!-- PERÍODO / SEMESTRE / CUATRIMESTRE -->
                                    <div class="col-md-10 text-center mb-3">
                                        <label class="text-muted text-uppercase d-block">Número de Período:</label>

                                        @php
                                            $num = $asignacion->materia->numeroPeriodo->numero ?? null;
                                            $tipo = $asignacion->materia->numeroPeriodo->tipoPeriodo->nombre ?? null;
                                        @endphp

                                        <div class="text-muted d-block font-weight-bold">
                                            @if ($num)
                                                {{ $num }}°
                                                @if ($tipo)
                                                    {{ $tipo }}
                                                @endif
                                            @else
                                                N/A
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">


                                        <!-- DOCENTE -->
                                        <div class="col-md-6 mb-3">
                                            <label class="text-muted text-uppercase d-block">Docente:</label>
                                            <div class="text-muted d-block font-weight-bold">
                                                {{ $asignacion->docente->nombre_completo ?? 'N/A' }}
                                            </div>
                                        </div>

                                        <!-- MATERIA -->
                                        <div class="col-md-6 mb-3">
                                            <label class="text-muted text-uppercase d-block">Materia:</label>
                                            <div class="text-muted d-block font-weight-bold">
                                                {{ $asignacion->materia->nombre ?? 'N/A' }}
                                            </div>
                                        </div>

                                        <!-- GRUPO -->
                                        <div class="col-md-6 mb-3">
                                            <label class="text-muted text-uppercase d-block">Grupo:</label>
                                            <div class="text-muted d-block font-weight-bold">
                                                {{ $asignacion->grupo->nombre ?? 'N/A' }}
                                            </div>
                                        </div>

                                        <!-- PERÍODO ESCOLAR -->
                                        <div class="col-md-6 mb-3">
                                            <label class="text-muted text-uppercase d-block">Período Escolar:</label>
                                            <div class="text-muted d-block font-weight-bold">
                                                {{ $asignacion->periodoEscolar->nombre ?? 'N/A' }}
                                            </div>
                                        </div>



                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer modal-footer-custom border-top">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times mr-2"></i> Cerrar
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <!-- Modal Editar -->
        <div class="modal fade" id="editarModal{{ $asignacion->id_asignacion }}" tabindex="-1" role="dialog"
            aria-labelledby="editarModalLabel{{ $asignacion->id_asignacion }}" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header modal-header-custom border-0">
                        <div class="w-100">
                            <div class="text-center">
                                <h5 class="m-0 font-weight-bold">
                                    ✏️ Editar Asignación Docente
                                </h5>
                                <p class="text-center m-0 mt-2" style="font-size: 0.9rem; opacity: 0.95;">
                                    Modifique la información de la asignación
                                </p>
                            </div>
                        </div>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar"
                            style="position: absolute; right: 1.5rem; top: 1.5rem; font-size: 1.8rem; opacity: 0.9;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="{{ route('asignaciones.update', $asignacion->id_asignacion) }}" method="POST"
                        id="formEditar{{ $asignacion->id_asignacion }}">
                        @if ($errors->any() && session('asignacion_edit_id') == $asignacion->id_asignacion)
    <div class="alert alert-danger m-3">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                        @csrf
                        @method('PUT')
                        <div class="modal-body modal-body-custom p-4">
                            <div class="form-container p-4 bg-white rounded shadow-sm border">

                                <div class="card shadow mb-4 border-0">
                                    <div class="card-header py-3 text-white card-header-custom">
                                        <h6 class="m-0 font-weight-bold">
                                            <i class="fas fa-users"></i> Seleccione Grupo y Docente
                                        </h6>
                                    </div>
                                    <div class="info-section p-4 mb-4">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label-custom d-flex">
                                                        Carrera
                                                        <span class="required-asterisk ml-1">*</span>
                                                    </label>
                                                    <select id="carrera_editar_{{ $asignacion->id_asignacion }}"
                                                        class="form-control form-control-custom" required>
                                                        <option value="">-- Seleccione una carrera --</option>
                                                        @foreach ($carreras as $carrera)
                                                            <option value="{{ $carrera->id_carrera }}"
                                                                {{ $asignacion->grupo->carrera->id_carrera == $carrera->id_carrera ? 'selected' : '' }}>
                                                                {{ $carrera->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label-custom d-flex">
                                                        Grupo
                                                        <span class="required-asterisk ml-1">*</span>
                                                    </label>

                                                    <select name="id_grupo"
                                                        id="grupo_editar_{{ $asignacion->id_asignacion }}"
                                                        class="form-control form-control-custom" required>

                                                        <option value="">-- Seleccione un grupo --</option>

                                                        @foreach ($grupos as $grupo)
                                                            <option value="{{ $grupo->id_grupo }}"
                                                                {{ old('id_grupo', $asignacion->id_grupo) == $grupo->id_grupo ? 'selected' : '' }}>
                                                                {{ $grupo->nombre }}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label-custom d-flex">
                                                        Docente
                                                        <span class="required-asterisk ml-1">*</span>
                                                    </label>
                                                    <select name="id_docente" class="form-control form-control-custom"
                                                        required>
                                                        @foreach ($docentes as $docente)
                                                            <option value="{{ $docente->id_docente }}"
                                                                {{ $asignacion->id_docente == $docente->id_docente ? 'selected' : '' }}>
                                                                {{ $docente->nombre_completo }}
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
                                                        Período Escolar
                                                        <span class="text-muted ml-2">(Automático)</span>
                                                    </label>
                                                    <input type="text"
                                                        id="periodo_escolar_editar_{{ $asignacion->id_asignacion }}_display"
                                                        class="form-control form-control-custom" readonly
                                                        value="{{ $asignacion->periodoEscolar->nombre ?? '' }}">
                                                    <input type="hidden" name="id_periodo_escolar"
                                                        id="periodo_escolar_editar_{{ $asignacion->id_asignacion }}"
                                                        value="{{ $asignacion->id_periodo_escolar }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label-custom d-flex">
                                                        Número de Período
                                                        <span class="required-asterisk ml-1">*</span>
                                                    </label>
                                                    <select
                                                        id="numero_periodo_editar_{{ $asignacion->id_asignacion }}"
                                                        class="form-control form-control-custom" required>
                                                        <option value="">-- Seleccione número de período --
                                                        </option>
                                                        @foreach ($numeroPeriodos as $numeroPeriodo)
                                                            <option value="{{ $numeroPeriodo->id_numero_periodo }}"
                                                                {{ $asignacion->materia->id_numero_periodo == $numeroPeriodo->id_numero_periodo ? 'selected' : '' }}>
                                                                {{ $numeroPeriodo->numero }}° Período
                                                                @if ($numeroPeriodo->tipoPeriodo)
                                                                    ({{ $numeroPeriodo->tipoPeriodo->nombre }})
                                                                @endif
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Sección 2: Selección de Materia -->
                                <div class="card shadow mb-4 border-0">
                                    <div class="card-header py-3 text-white card-header-custom">
                                        <h6 class="m-0 font-weight-bold">
                                            <i class="fas fa-book"></i> Seleccione Materia del Período
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div id="materias-container-editar-{{ $asignacion->id_asignacion }}">
                                            <div class="alert alert-info">
                                                <i class="fas fa-info-circle"></i> Cargando materias disponibles...
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="modal-footer modal-footer-custom">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                Cancelar
                            </button>
                            <button type="submit" class="btn btn-success">
                                ✓ Actualizar Asignación
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Eliminar -->
        <div class="modal fade" id="eliminarModal{{ $asignacion->id_asignacion }}" tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header1 modal-header-custom border-0">
                        <div class="w-100">
                            <div class="text-center">
                                <h5 class="m-0 font-weight-bold">
                                    🗑️ Eliminar Asignación
                                </h5>
                            </div>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ¿Seguro que deseas eliminar la asignación del docente
                        <strong>{{ $asignacion->docente->nombre_completo ?? 'N/A' }}</strong>
                        para la materia
                        <strong>{{ $asignacion->materia->nombre ?? 'N/A' }}</strong>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <form action="{{ route('asignaciones.destroy', $asignacion->id_asignacion) }}" method="POST"
                            style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Modal de asignación simple
            @if (session('is_create_asignacion'))
                $('#nuevaAsignacionModal').modal('show');
            @endif

            // Modal de asignación MASIVA 👈
            @if (session('is_create_masiva'))
                $('#asignacionMasivaModal').modal('show');
            @endif

            // Modal de edición
            @if (session('asignacion_edit_id'))
                $('#editarModal{{ session('asignacion_edit_id') }}').modal('show');
            @endif
        });
    </script>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('libs/sbadmin/js/sb-admin-2.min.js') }}"></script>

    <!-- JavaScript para la funcionalidad de asignaciones -->
    <script>
        $(document).ready(function() {
            // Configuración inicial
            const grupos = @json($grupos);
            const docentes = @json($docentes);
            const periodos = @json($periodos);

            console.log('Grupos cargados:', grupos);
            console.log('Docentes cargados:', docentes);
            console.log('Períodos cargados:', periodos);
            $('#carrera_nueva').change(function() {
                const carreraId = $(this).val();

                // Cargar grupos
                cargarGrupos(carreraId, '#grupo_nueva', '#periodo_escolar_nueva_display',
                    '#periodo_escolar_nueva');

                // Limpiar docentes
                $('#docente_nueva').html('<option value="">-- Seleccione un docente --</option>');

                // Cargar docentes de la carrera
                if (carreraId) {
                    $.get(`/docentes-por-carrera/${carreraId}`)
                        .done(function(docentes) {
                            docentes.forEach(doc => {
                                $('#docente_nueva').append(
                                    `<option value="${doc.id_docente}">${doc.nombre_completo}</option>`
                                );
                            });
                        })
                        .fail(function() {
                            console.error('Error al cargar docentes por carrera');
                            $('#docente_nueva').html(
                                '<option value="">Error al cargar docentes</option>');
                        });
                }

                // También puedes recargar materias si ya hay número de período
                const numeroPeriodoId = $('#numero_periodo_nueva').val();
                if (carreraId && numeroPeriodoId) {
                    cargarMateriasIndividual(carreraId, numeroPeriodoId, '#materias-container-nueva');
                }
            });
            // ========== FUNCIONES COMPARTIDAS ==========

            // Función para cargar grupos por carrera y autocompletar período
            function cargarGrupos(carreraId, grupoSelectId, periodoDisplayId, periodoHiddenId, grupoSeleccionado =
                null) {
                const grupoSelect = $(grupoSelectId);
                grupoSelect.html('<option value="">-- Seleccione un grupo --</option>');

                console.log('Carrera seleccionada:', carreraId);

                if (carreraId) {
                    const gruposFiltrados = grupos.filter(g => g.id_carrera == carreraId);
                    console.log('Grupos filtrados:', gruposFiltrados);

                    gruposFiltrados.forEach(grupo => {
                        const selected = grupoSeleccionado && grupo.id_grupo == grupoSeleccionado ?
                            'selected' : '';
                        grupoSelect.append(
                            `<option value="${grupo.id_grupo}" data-periodo="${grupo.periodo}">${grupo.nombre}</option>`
                        );
                    });

                    // Si hay un grupo seleccionado, cargar su período
                    if (grupoSeleccionado) {
                        const grupoData = gruposFiltrados.find(g => g.id_grupo == grupoSeleccionado);
                        if (grupoData && grupoData.periodo) {
                            cargarPeriodoGrupo(grupoData.periodo, periodoDisplayId, periodoHiddenId);
                        }
                    }
                }

                // Event listener para cuando cambie el grupo
                grupoSelect.off('change').on('change', function() {
                    const periodoId = $(this).find(':selected').data('periodo');
                    cargarPeriodoGrupo(periodoId, periodoDisplayId, periodoHiddenId);
                });
            }

            // Función para cargar y mostrar el período del grupo
            function cargarPeriodoGrupo(periodoId, displayId, hiddenId) {
                console.log('Cargando período:', periodoId);

                if (periodoId) {
                    const periodo = periodos.find(p => p.id_periodo_escolar == periodoId);
                    console.log('Período encontrado:', periodo);

                    if (periodo) {
                        $(displayId).val(periodo.nombre);
                        $(hiddenId).val(periodo.id_periodo_escolar);
                    } else {
                        $(displayId).val('');
                        $(hiddenId).val('');
                    }
                } else {
                    $(displayId).val('');
                    $(hiddenId).val('');
                }
            }

            // Función para cargar materias individual (para modales individuales)
            function cargarMateriasIndividual(carreraId, numeroPeriodoId, contenedorId, materiaSeleccionada =
                null) {
                console.log('Cargando materias individual para carrera:', carreraId, 'período:', numeroPeriodoId);

                $(contenedorId).html(
                    '<div class="text-center"><i class="fas fa-spinner fa-spin fa-2x text-primary"></i><p class="mt-2">Cargando materias...</p></div>'
                );

                if (!carreraId || !numeroPeriodoId) {
                    $(contenedorId).html(
                        '<div class="alert alert-warning">Seleccione carrera y número de período</div>');
                    return;
                }

                const url =
                    `{{ url('asignaciones/masiva/materias-carrera-periodo') }}/${carreraId}/${numeroPeriodoId}`;
                console.log('URL de petición:', url);

                $.ajax({
                    url: url,
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json'
                    },
                    success: function(response) {
                        console.log('Respuesta recibida:', response);
                        let html = '';

                        if (response.length === 0) {
                            html = `
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i> 
                                No hay materias para esta carrera y período seleccionados
                            </div>`;
                        } else {
                            html += `
                            <div class="alert alert-success mb-3">
                                <i class="fas fa-check-circle"></i> 
                                Seleccione una materia
                            </div>
                            <div class="materia-item">
                                <div class="form-group mb-0">
                                    <label class="form-label-custom d-flex">
                                        📚 Materia
                                        <span class="required-asterisk ml-1">*</span>
                                    </label>
                                    <select name="id_materia" class="form-control form-control-custom" required>`;

                            response.forEach((materia) => {
                                const selected = materiaSeleccionada && materia.id_materia ==
                                    materiaSeleccionada ? 'selected' : '';
                                html +=
                                    `<option value="${materia.id_materia}" ${selected}>${materia.nombre} - ${materia.clave || 'Sin clave'}</option>`;
                            });

                            html += `</select>
                                </div>
                            </div>`;
                        }

                        $(contenedorId).html(html);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al cargar materias:', error);
                        $(contenedorId).html(`
                        <div class="alert alert-danger">
                            <i class="fas fa-times-circle"></i> 
                            Error al cargar las materias. Por favor, intente nuevamente.
                        </div>
                    `);
                    }
                });
            }

            // ========== MODAL NUEVA ASIGNACIÓN INDIVIDUAL ==========

            // Filtrar grupos cuando cambia la carrera
            $('#carrera_nueva').change(function() {
                const carreraId = $(this).val();
                cargarGrupos(carreraId, '#grupo_nueva', '#periodo_escolar_nueva_display',
                    '#periodo_escolar_nueva');

                // Cargar materias si ya hay número de período seleccionado
                const numeroPeriodoId = $('#numero_periodo_nueva').val();
                if (carreraId && numeroPeriodoId) {
                    cargarMateriasIndividual(carreraId, numeroPeriodoId, '#materias-container-nueva');
                } else {
                    $('#materias-container-nueva').html(
                        '<div class="alert alert-info">Seleccione carrera y número de período</div>');
                }
            });

            // Cargar materias cuando cambia el número de período
            $('#numero_periodo_nueva').change(function() {
                const carreraId = $('#carrera_nueva').val();
                const numeroPeriodoId = $(this).val();

                if (carreraId && numeroPeriodoId) {
                    cargarMateriasIndividual(carreraId, numeroPeriodoId, '#materias-container-nueva');
                } else {
                    $('#materias-container-nueva').html(
                        '<div class="alert alert-info">Seleccione carrera y número de período</div>');
                }
            });

            // ========== MODALES DE EDICIÓN ==========

            @foreach ($asignaciones as $asignacion)
                // Configurar modal de edición para {{ $asignacion->id_asignacion }}
                $(document).ready(function() {


                    // Cuando se abre el modal de edición
                    $('#editarModal{{ $asignacion->id_asignacion }}').on('show.bs.modal', function() {

                        const carreraId = $('#carrera_editar_{{ $asignacion->id_asignacion }}')
                            .val();
                        const grupoSeleccionado =
                            "{{ $asignacion->id_grupo }}"; // 🔹 Corregido: ahora se envía como string

                        // Cargar grupos con el seleccionado
                        function cargarGrupos(carreraId, selectGrupoId, displayPeriodoId,
                            hiddenPeriodoId, grupoSeleccionado = null) {

                            if (!carreraId) {
                                $(selectGrupoId).html(
                                    '<option value="">Seleccione un grupo</option>');
                                return;
                            }

                            $.ajax({
                                url: '/obtener-grupos/' + carreraId,
                                method: 'GET',
                                success: function(response) {

                                    let html =
                                        '<option value="">-- Seleccione un grupo --</option>';

                                    response.forEach(grupo => {
                                        if (grupoSeleccionado &&
                                            grupoSeleccionado == grupo.id_grupo
                                        ) {
                                            html +=
                                                `<option value="${grupo.id_grupo}" selected>${grupo.nombre}</option>`;
                                        } else {
                                            html +=
                                                `<option value="${grupo.id_grupo}">${grupo.nombre}</option>`;
                                        }
                                    });

                                    $(selectGrupoId).html(html);

                                    // Si necesitas asignar período según el grupo, aquí va tu lógica
                                },
                                error: function() {
                                    $(selectGrupoId).html(
                                        '<option value="">Error al cargar grupos</option>'
                                    );
                                }
                            });
                        }


                        // 🔸 MATERIAS — NO SE TOCÓ NADA
                        const numeroPeriodoId = $(
                            '#numero_periodo_editar_{{ $asignacion->id_asignacion }}').val();
                        const materiaSeleccionada = "{{ $asignacion->id_materia }}";

                        if (carreraId && numeroPeriodoId) {
                            cargarMateriasIndividual(
                                carreraId,
                                numeroPeriodoId,
                                '#materias-container-editar-{{ $asignacion->id_asignacion }}',
                                materiaSeleccionada
                            );
                        }
                    });

                    // Cuando cambia la carrera en edición
                    $('#carrera_editar_{{ $asignacion->id_asignacion }}').change(function() {

                        const carreraId = $(this).val();

                        cargarGrupos(
                            carreraId,
                            '#grupo_editar_{{ $asignacion->id_asignacion }}',
                            '#periodo_escolar_editar_{{ $asignacion->id_asignacion }}_display',
                            '#periodo_escolar_editar_{{ $asignacion->id_asignacion }}'
                        );

                        // 🔸 MATERIAS — NO SE TOCÓ NADA
                        const numeroPeriodoId = $(
                            '#numero_periodo_editar_{{ $asignacion->id_asignacion }}').val();
                        const materiaSeleccionada = "{{ $asignacion->id_materia }}";

                        if (carreraId && numeroPeriodoId) {
                            cargarMateriasIndividual(
                                carreraId,
                                numeroPeriodoId,
                                '#materias-container-editar-{{ $asignacion->id_asignacion }}',
                                materiaSeleccionada
                            );
                        }
                    });

                    // Cuando cambia el número de período en edición
                    $('#numero_periodo_editar_{{ $asignacion->id_asignacion }}').change(function() {

                        const carreraId = $('#carrera_editar_{{ $asignacion->id_asignacion }}')
                            .val();
                        const numeroPeriodoId = $(this).val();
                        const materiaSeleccionada = "{{ $asignacion->id_materia }}";

                        if (carreraId && numeroPeriodoId) {
                            cargarMateriasIndividual(
                                carreraId,
                                numeroPeriodoId,
                                '#materias-container-editar-{{ $asignacion->id_asignacion }}',
                                materiaSeleccionada
                            );
                        } else {
                            $('#materias-container-editar-{{ $asignacion->id_asignacion }}').html(
                                '<div class="alert alert-warning">Seleccione carrera y número de período</div>'
                            );
                        }
                    });

                });
            @endforeach

            // ========== MODAL ASIGNACIÓN MASIVA ==========

            // Filtrar grupos por carrera en modal masivo
            $('#carrera').change(function() {
                const carreraId = $(this).val();
                cargarGrupos(carreraId, '#grupo', '#periodo_escolar_display', '#periodo_escolar');

                // Intentar cargar materias si ya hay período seleccionado
                const idNumeroPeriodo = $('#numero_periodo').val();
                if (carreraId && idNumeroPeriodo) {
                    cargarMateriasMasivas(carreraId, idNumeroPeriodo);
                }
            });

            // Cargar materias cuando se seleccione número de período en modal masivo
            $('#numero_periodo').change(function() {
                const carreraId = $('#carrera').val();
                const idNumeroPeriodo = $(this).val();

                console.log('Número de período seleccionado:', idNumeroPeriodo);
                console.log('Carrera actual:', carreraId);

                if (carreraId && idNumeroPeriodo) {
                    cargarMateriasMasivas(carreraId, idNumeroPeriodo);
                } else {
                    let mensaje =
                        '<div class="alert alert-warning"><i class="fas fa-exclamation-triangle"></i> ';
                    if (!carreraId && !idNumeroPeriodo) {
                        mensaje += 'Seleccione una carrera y número de período';
                    } else if (!carreraId) {
                        mensaje += 'Seleccione una carrera';
                    } else {
                        mensaje += 'Seleccione un número de período';
                    }
                    mensaje += '</div>';
                    $('#materias-container').html(mensaje);
                }
            });

            // Función para cargar materias en modal masivo
            function cargarMateriasMasivas(carreraId, idNumeroPeriodo) {
                console.log('Cargando materias masivas para carrera:', carreraId, 'período:', idNumeroPeriodo);

                $('#materias-container').html(
                    '<div class="text-center"><i class="fas fa-spinner fa-spin fa-2x text-primary"></i><p class="mt-2">Cargando materias y docentes...</p></div>'
                );

                const urlMaterias = `/asignaciones/masiva/materias-carrera-periodo/${carreraId}/${idNumeroPeriodo}`;
                const urlDocentes = `/docentes-por-carrera/${carreraId}`;

                // Ejecutar ambas peticiones en paralelo
                Promise.all([
                        $.ajax({
                            url: urlMaterias,
                            method: 'GET',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                'Accept': 'application/json'
                            }
                        }),
                        $.ajax({
                            url: urlDocentes,
                            method: 'GET',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                'Accept': 'application/json'
                            }
                        })
                    ])
                    .then(([materias, docentesFiltrados]) => {
                        console.log('Materias recibidas:', materias);
                        console.log('Docentes filtrados por carrera:', docentesFiltrados);

                        let html = '';

                        if (materias.length === 0) {
                            html = `
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> 
                    No hay materias para esta carrera y período seleccionados
                </div>`;
                        } else {
                            const carreraSeleccionada = $('#carrera option:selected').text().trim();
                            const periodoSeleccionado = $('#numero_periodo option:selected').text().trim();

                            html += `
                <div class="alert alert-success mb-3">
                    <i class="fas fa-check-circle"></i> 
                    Se encontraron ${materias.length} materias para ${carreraSeleccionada} - ${periodoSeleccionado}
                </div>`;

                            materias.forEach((materia) => {
                                html += `
                <div class="materia-item">
                    <div class="row align-items-center">
                        <div class="col-md-1 text-center">
                            <input type="checkbox" name="materias[]" value="${materia.id_materia}" 
                                   class="materia-checkbox" style="width: 20px; height: 20px;">
                        </div>
                        <div class="col-md-5">
                            <strong>${materia.nombre}</strong><br>
                            <small class="text-muted">Clave: ${materia.clave || 'N/A'}</small><br>
                            <small class="text-info">Créditos: ${materia.creditos || 'N/A'} | Horas: ${materia.horas || 'N/A'}</small>
                        </div>
                        <div class="col-md-6">
                            <label class="small mb-1">Docente <span class="text-muted">(seleccione si asignará esta materia)</span></label>
                            <select name="docentes[${materia.id_materia}]" class="form-control form-control-sm docente-select">
                                <option value="">-- Seleccione un docente --</option>`;

                                // ✅ Usamos docentesFiltrados (solo de la carrera)
                                if (Array.isArray(docentesFiltrados) && docentesFiltrados.length > 0) {
                                    docentesFiltrados.forEach(docente => {
                                        html +=
                                            `<option value="${docente.id_docente}">${docente.nombre_completo}</option>`;
                                    });
                                } else {
                                    html += `<option disabled>Sin docentes disponibles</option>`;
                                }

                                html += `
                            </select>
                        </div>
                    </div>
                </div>`;
                            });
                        }

                        $('#materias-container').html(html);
                    })
                    .catch((error) => {
                        console.error('Error al cargar materias o docentes:', error);
                        $('#materias-container').html(`
            <div class="alert alert-danger">
                <i class="fas fa-times-circle"></i> 
                Error al cargar los datos. Por favor, intente nuevamente.
            </div>
        `);
                    });
            }

            // Seleccionar/Deseleccionar todas en modal masivo
            $('#selectAll').click(function() {
                const checkboxes = $('.materia-checkbox');
                const allChecked = checkboxes.length > 0 && checkboxes.filter(':checked').length ===
                    checkboxes.length;

                checkboxes.each(function() {
                    $(this).prop('checked', !allChecked);
                    $(this).trigger(
                        'change'); // Disparar el evento change para actualizar los selects
                });

                $(this).html(allChecked ?
                    '<i class="fas fa-check-square"></i> Seleccionar Todas' :
                    '<i class="fas fa-square"></i> Deseleccionar Todas');
            });

            // Marcar visualmente items seleccionados en modal masivo
            $(document).on('change', '.materia-checkbox', function() {
                const isChecked = $(this).is(':checked');
                const materiaItem = $(this).closest('.materia-item');
                const docenteSelect = materiaItem.find('.docente-select');

                materiaItem.toggleClass('selected', isChecked);

                // Habilitar/deshabilitar el select de docente según el checkbox
                if (isChecked) {
                    docenteSelect.prop('disabled', false);
                    docenteSelect.prop('required', true);
                    // Resaltar visualmente
                    docenteSelect.addClass('select-enabled');
                } else {
                    // NO deshabilitar, solo limpiar y quitar estilo
                    docenteSelect.prop('required', false);
                    docenteSelect.val(''); // Limpiar la selección
                    docenteSelect.removeClass('select-enabled');
                    // IMPORTANTE: NO usar .prop('disabled', true)
                }
            });

            // ========== VALIDACIONES ==========

            // Validar antes de enviar formulario masivo
            // Validar antes de enviar formulario masivo
            // Validar antes de enviar formulario masivo
            $('#formAsignacionMasiva').submit(function(e) {
                e.preventDefault(); // Prevenir envío por defecto

                const materiasSeleccionadas = $('.materia-checkbox:checked');
                if (materiasSeleccionadas.length === 0) {
                    alert('Debe seleccionar al menos una materia');
                    return false;
                }

                // Validar que todas las materias seleccionadas tengan docente asignado
                let todasTienenDocente = true;
                let materiasSinDocente = [];
                materiasSeleccionadas.each(function() {
                    const materiaId = $(this).val();
                    const docenteSelect = $(`select[name="docentes[${materiaId}]"]`);
                    if (!docenteSelect.val() || docenteSelect.val() === '') {
                        todasTienenDocente = false;
                        const materiaNombre = $(this).closest('.materia-item').find('strong')
                            .text();
                        materiasSinDocente.push(materiaNombre);
                    }
                });

                if (!todasTienenDocente) {
                    alert('Todas las materias seleccionadas deben tener un docente asignado.\nMaterias sin docente:\n- ' +
                        materiasSinDocente.join('\n- '));
                    return false;
                }

                // Validar que el período escolar esté seleccionado
                const periodoEscolar = $('#periodo_escolar').val();
                if (!periodoEscolar) {
                    alert('Debe seleccionar un grupo para que se asigne el período escolar');
                    return false;
                }

                // ✅ CORRECCIÓN: DESHABILITAR LAS MATERIAS NO SELECCIONADAS EN LUGAR DE ELIMINARLAS
                $('.materia-checkbox').not(':checked').each(function() {
                    const materiaId = $(this).val();
                    const docenteSelect = $(`select[name="docentes[${materiaId}]"]`);
                    // Deshabilitar el select y el checkbox para que el navegador los ignore
                    docenteSelect.prop('disabled', true);
                    $(this).prop('disabled', true); // También deshabilitamos el checkbox
                });

                // Log para debug ANTES de enviar
                console.log('=== DATOS DEL FORMULARIO ANTES DE ENVIAR ===');
                console.log('Grupo:', $('#grupo').val());
                console.log('Período Escolar:', $('#periodo_escolar').val());
                console.log('Materias seleccionadas:', materiasSeleccionadas.length);

                console.log('=== DOCENTES QUE SE ENVIARÁN ===');
                $('select[name^="docentes["]').each(function() {
                    console.log('Select encontrado:', {
                        name: $(this).attr('name'),
                        value: $(this).val(),
                        disabled: $(this).prop('disabled')
                    });
                });

                // Serializar y mostrar datos
                const formData = $(this).serialize();
                console.log('=== FORM DATA SERIALIZADO ===');
                console.log(formData);

                // ⚠️ NO PREVENIR MÁS - Permitir envío normal
                this.submit();
            });

            // Validar antes de enviar formulario individual
            $('#formNuevaAsignacion').submit(function(e) {
                const materiaSeleccionada = $('#materias-container-nueva select[name="id_materia"]').val();
                if (!materiaSeleccionada) {
                    e.preventDefault();
                    alert('Debe seleccionar una materia');
                    return false;
                }

                const periodoEscolar = $('#periodo_escolar_nueva').val();
                if (!periodoEscolar) {
                    e.preventDefault();
                    alert('Debe seleccionar un grupo para que se asigne el período escolar');
                    return false;
                }
            });

            // Configuración inicial de modales
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
