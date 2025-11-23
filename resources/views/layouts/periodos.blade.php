<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Períodos Escolares</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('libs/fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
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
                <img src="{{ asset('libs/sbadmin/img/upn.png') }}" alt="Logo" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
        </div>

        <div class="collapse navbar-collapse ml-4">
            <ul class="navbar-nav" style="padding-left: 20%;">
                <li class="nav-item">
                    <a class="nav-link text-white px-3 mr-1" href="{{ route('admin') }}">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link navbar-active-item px-3 mr-1">Períodos Escolares</a>
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
                    <a class="nav-link text-white px-3" href="{{ route('calificaciones.index') }}">Calificaciones</a>
                </li>
            </ul>
        </div>
        <div class="position-absolute" style="top: 10px; right: 20px; z-index: 1000;">
            <div class="d-flex align-items-center text-white">
                <span class="mr-3">{{ Auth::user()->rol->nombre }}</span>
                <a href="#" class="text-white text-decoration-none logout-link" data-toggle="modal" data-target="#logoutModal">
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

                    <h1 class="text-danger text-center mb-5" style="font-size: 2.5rem; font-family: 'Arial Black', Verdana, sans-serif; font-weight: bold;">
                        Gestión de Períodos Escolares</h1>

                    <div class="row justify-content-center">
                        <div class="col-lg-10">

                            <!-- Botón para nuevo período -->
                            <div class="mb-3 text-right">
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#nuevoPeriodoModal">
                                    <i class="fas fa-plus"></i> Nuevo Período
                                </button>
                            </div>

                            <!-- Filtros -->
                            <div class="container mb-4 d-flex justify-content-center">
                                <div class="p-3 border rounded bg-light d-inline-block shadow-sm">
                                    <form id="filtrosForm" method="GET" action="{{ route('periodos.index') }}" class="d-flex flex-wrap gap-2 align-items-center">

                                        <!-- Nombre -->
                                        <div class="flex-grow-1" style="width: 400px;">
                                            <input type="text" name="nombre" class="form-control form-control-sm" placeholder="🔍 Buscar por nombre" value="{{ request('nombre') }}">
                                        </div>

                                        <!-- Tipo de período -->
                                        <select name="id_tipo_periodo" class="form-control form-control-sm w-auto">
                                            <option value="">Tipo de período</option>
                                            @foreach ($tipos as $tipo)
                                                <option value="{{ $tipo->id_tipo_periodo }}" {{ old('id_tipo_periodo') == $tipo->id_tipo_periodo ? 'selected' : '' }}>
                                                    {{ $tipo->nombre }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <!-- Estado -->
                                        <select name="estado" class="form-control form-control-sm w-auto">
                                            <option value="">Estado</option>
                                            <option value="Abierto" {{ request('estado') == 'Abierto' ? 'selected' : '' }}>Abierto</option>
                                            <option value="Cerrado" {{ request('estado') == 'Cerrado' ? 'selected' : '' }}>Cerrado</option>
                                        </select>

                                        <!-- Mostrar -->
                                        <select name="mostrar" onchange="this.form.submit()" class="form-control form-control-sm w-auto">
                                            <option value="10" {{ request('mostrar') == 10 ? 'selected' : '' }}>10</option>
                                            <option value="15" {{ request('mostrar') == 15 ? 'selected' : '' }}>15</option>
                                            <option value="25" {{ request('mostrar') == 25 ? 'selected' : '' }}>25</option>
                                            <option value="50" {{ request('mostrar') == 50 ? 'selected' : '' }}>50</option>
                                            <option value="todo" {{ request('mostrar') == 'todo' ? 'selected' : '' }}>Todo</option>
                                        </select>

                                        <!-- Botón Mostrar todo -->
                                        <a href="{{ route('periodos.index', ['mostrar' => 'todo']) }}" class="btn btn-sm btn-outline-secondary d-flex align-items-center">
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
                                                <th>Ciclo</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($periodos as $periodo)
                                                <tr class="text-center">
                                                    <td>{{ strtoupper($periodo->nombre) }}</td>
                                                    <td>{{ $periodo->tipoPeriodo->nombre ?? '- - -' }}</td>
                                                    <td>{{ $periodo->fecha_inicio }}</td>
                                                    <td>{{ $periodo->fecha_fin }}</td>
                                                    <td>{{ $periodo->ciclos->nombre ?? '- - -'}}</td>
                                                    <td>{{ $periodo->estado }}</td>
                                                    <td>
                                                        <!-- Botón Editar -->
                                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editarModal{{ $periodo->id_periodo_escolar }}">
                                                            <i class="fas fa-edit"></i> Editar
                                                        </button>

                                                        <!-- Modal Editar -->
                                                        <div class="modal fade" id="editarModal{{ $periodo->id_periodo_escolar }}" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel{{ $periodo->id_periodo_escolar }}" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content border-0 shadow-lg">

                                                                    <!-- Header con gradiente -->
                                                                    <div class="modal-header modal-header-custom border-0">
                                                                        <div class="w-100">
                                                                            <div class="text-center">
                                                                                <h5 class="m-0 font-weight-bold" id="editarModalLabel{{ $periodo->id_periodo_escolar }}">
                                                                                    ✏️ Editar Período Escolar
                                                                                </h5>
                                                                                <p class="m-0 mt-2 mb-0" style="font-size: 0.9rem; opacity: 0.95;">
                                                                                    Modifique la información del período escolar
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar" style="position: absolute; right: 1.5rem; top: 1.5rem; font-size: 1.8rem; opacity: 0.9;">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>

                                                                    <form action="{{ route('periodos.update', $periodo->id_periodo_escolar) }}" method="POST">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <input type="hidden" name="periodo_id" value="{{ $periodo->id_periodo_escolar }}">
                                                                        
                                                                        <div class="modal-body modal-body-custom p-4">

                                                                            <div class="form-container p-4 bg-white rounded shadow-sm border">

                                                                                <!-- Sección 1: Información Básica -->
                                                                                <div class="card shadow mb-2 border-0">
                                                                                    <div class="card-header py-3 text-white card-header-custom d-flex ">
                                                                                        <h6 class="m-0 font-weight-bold text-danger">
                                                                                            <i class="fas fa-info-circle"></i> Información del Período
                                                                                        </h6>
                                                                                    </div>
                                                                                    <div class="card-body1 p-4">
                                                                                        <div class="form-group mb-3">
                                                                                            <label class="form-label-custom d-flex">
                                                                                                Nombre del Período
                                                                                                <span class="required-asterisk ml-1">*</span>
                                                                                            </label>
                                                                                            <small class="form-text text-muted d-flex">
                                                                                                Ingrese un nombre descriptivo para el período escolar
                                                                                            </small>
                                                                                            <input type="text" placeholder="Ejemplo: JULIO-DICIEMBRE 2024" name="nombre" value="{{ old('nombre', $periodo->nombre) }}" class="form-control form-control-custom @error('nombre') @if(old('periodo_id') == $periodo->id_periodo_escolar) is-invalid @endif @enderror" required>
                                                                                            @error('nombre')
                                                                                                @if(old('periodo_id') == $periodo->id_periodo_escolar)
                                                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                                @endif
                                                                                            @enderror
                                                                                        </div>

                                                                                        <div class="form-group mb-0">
                                                                                            <label class="form-label-custom d-flex">
                                                                                                Tipo de Período
                                                                                                <span class="required-asterisk ml-1">*</span>
                                                                                            </label>
                                                                                            <select name="id_tipo_periodo" class="form-control form-control-custom @error('id_tipo_periodo') @if(old('periodo_id') == $periodo->id_periodo_escolar) is-invalid @endif @enderror" required>
                                                                                                <option value="">-- Seleccione un tipo de período --</option>
                                                                                                @foreach ($tipos as $tipo)
                                                                                                    <option value="{{ $tipo->id_tipo_periodo }}" {{ old('id_tipo_periodo', $periodo->id_tipo_periodo) == $tipo->id_tipo_periodo ? 'selected' : '' }}>
                                                                                                        {{ $tipo->nombre }}
                                                                                                    </option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                            @error('id_tipo_periodo')
                                                                                                @if(old('periodo_id') == $periodo->id_periodo_escolar)
                                                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                                @endif
                                                                                            @enderror
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Sección 2: Fechas -->
                                                                                <div class="card shadow mb-2 border-0">
                                                                                    <div class="card-header py-3 text-white card-header-custom d-flex ">
                                                                                        <h6 class="m-0 font-weight-bold text-danger">
                                                                                            <i class="fas fa-calendar-alt"></i>  Fechas del Período
                                                                                        </h6>
                                                                                    </div>
                                                                                    <div class="card-body1 p-4">
                                                                                        <div class="row">
                                                                                            <div class="col-md-6">
                                                                                                <div class="form-group mb-3">
                                                                                                    <label class="form-label-custom d-flex">
                                                                                                        Fecha de Inicio
                                                                                                        <span class="required-asterisk ml-1">*</span>
                                                                                                    </label>
                                                                                                    <input type="date" name="fecha_inicio" value="{{ old('fecha_inicio', $periodo->fecha_inicio) }}" class="form-control form-control-custom @error('fecha_inicio') @if(old('periodo_id') == $periodo->id_periodo_escolar) is-invalid @endif @enderror" required>
                                                                                                    @error('fecha_inicio')
                                                                                                        @if(old('periodo_id') == $periodo->id_periodo_escolar)
                                                                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                                        @endif
                                                                                                    @enderror
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="col-md-6">
                                                                                                <div class="form-group mb-0">
                                                                                                    <label class="form-label-custom d-flex">
                                                                                                        Fecha de Finalización
                                                                                                        <span class="required-asterisk ml-1">*</span>
                                                                                                    </label>
                                                                                                    <input type="date" name="fecha_fin" value="{{ old('fecha_fin', $periodo->fecha_fin) }}" class="form-control form-control-custom @error('fecha_fin') @if(old('periodo_id') == $periodo->id_periodo_escolar) is-invalid @endif @enderror" required>
                                                                                                    @error('fecha_fin')
                                                                                                        @if(old('periodo_id') == $periodo->id_periodo_escolar)
                                                                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                                        @endif
                                                                                                    @enderror
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="periodo-info mt-3">
                                                                                            <i class="fas fa-info-circle text-primary"></i>
                                                                                            <strong>Nota:</strong> La fecha fin se calculará automáticamente según el tipo de período seleccionado.
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Sección 3: Estado y Ciclo -->
                                                                                <div class="card shadow mb-4 border-0">
                                                                                    <div class="card-header py-3 text-white card-header-custom d-flex">
                                                                                        <h6 class="m-0 font-weight-bold text-danger">
                                                                                            <i class="fas fa-cog"></i> Configuración del Período
                                                                                        </h6>
                                                                                    </div>
                                                                                    <div class="card-body1 p-4">
                                                                                        <div class="row">
                                                                                            <div class="col-md-6">
                                                                                                <div class="form-group mb-3">
                                                                                                    <label class="form-label-custom d-flex">
                                                                                                        Estado del Período
                                                                                                        <span class="required-asterisk ml-1">*</span>
                                                                                                    </label>
                                                                                                    <select name="estado" class="form-control form-control-custom @error('estado') @if(old('periodo_id') == $periodo->id_periodo_escolar) is-invalid @endif @enderror" required>
                                                                                                        <option value="">-- Seleccione el estado del período --</option>
                                                                                                        <option value="Abierto" {{ old('estado', $periodo->estado) == 'Abierto' ? 'selected' : '' }}>Abierto</option>
                                                                                                        <option value="Cerrado" {{ old('estado', $periodo->estado) == 'Cerrado' ? 'selected' : '' }}>Cerrado</option>
                                                                                                    </select>
                                                                                                    @error('estado')
                                                                                                        @if(old('periodo_id') == $periodo->id_periodo_escolar)
                                                                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                                        @endif
                                                                                                    @enderror
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="col-md-6">
                                                                                                <div class="form-group mb-0">
                                                                                                    <label class="form-label-custom d-flex">
                                                                                                        Ciclo Escolar
                                                                                                        <span class="required-asterisk ml-1">*</span>
                                                                                                    </label>
                                                                                                    <select name="id_ciclo" class="form-control form-control-custom @error('id_ciclo') @if(old('periodo_id') == $periodo->id_periodo_escolar) is-invalid @endif @enderror" required>
                                                                                                        <option value="">-- Seleccione un ciclo escolar --</option>
                                                                                                        @if ($cicloActual)
                                                                                                            <option value="{{ $cicloActual->id_ciclo }}" {{ old('id_ciclo', $periodo->id_ciclo ?? $cicloActual->id_ciclo) == $cicloActual->id_ciclo ? 'selected' : '' }}>
                                                                                                                {{ $cicloActual->nombre }}
                                                                                                            </option>
                                                                                                        @else
                                                                                                            <option value="" disabled>No hay ciclos activos disponibles</option>
                                                                                                        @endif
                                                                                                    </select>

                                                                                                    @if ($cicloActual)
                                                                                                        <small class="text-success mt-1 d-block">
                                                                                                            <i class="fas fa-check-circle"></i> Ciclo activo actual
                                                                                                        </small>
                                                                                                    @else
                                                                                                        <small class="text-danger mt-1 d-block">
                                                                                                            <i class="fas fa-exclamation-triangle"></i> No hay un ciclo escolar activo configurado
                                                                                                        </small>
                                                                                                    @endif

                                                                                                    @error('id_ciclo')
                                                                                                        @if(old('periodo_id') == $periodo->id_periodo_escolar)
                                                                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                                        @endif
                                                                                                    @enderror
                                                                                                </div>
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

                                                                            <div class="modal-footer modal-footer-custom border-top">
                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                                                    <i class="fas fa-times mr-2"></i>
                                                                                    Cancelar
                                                                                </button>
                                                                                <button type="submit" class="btn btn-success">
                                                                                    <i class="fas fa-save mr-2"></i>
                                                                                    Actualizar Período
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </form>

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <form action="{{ route('periodos.destroy', $periodo) }}" method="POST" style="display:inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#eliminarModal{{ $periodo->id_periodo_escolar }}">
                                                                <i class="fas fa-trash-alt"></i> Eliminar
                                                            </button>

                                                            <!-- Modal de Confirmación -->
                                                            <div class="modal fade" id="eliminarModal{{ $periodo->id_periodo_escolar }}" tabindex="-1" role="dialog" aria-labelledby="eliminarModalLabel{{ $periodo->id_periodo_escolar }}" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header1 modal-header-custom border-0">
                                                                            <div class="w-100">
                                                                                <div class="text-center">
                                                                                    <h5 class="m-0 font-weight-bold" id="eliminarModalLabel{{ $periodo->id_periodo_escolar }}">
                                                                                        🗑️ Eliminar Período
                                                                                    </h5>
                                                                                </div>
                                                                            </div>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            ¿Seguro que deseas eliminar el período <strong>{{ $periodo->nombre }}</strong>?
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                                            <form action="{{ route('periodos.destroy', $periodo) }}" method="POST" style="display:inline-block;">
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
                                                    <td colspan="100" class="text-center text-muted">No hay períodos registrados</td>
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

    <script>
        // 📅 CÁLCULO AUTOMÁTICO DE FECHA FIN DEL PERÍODO
        document.addEventListener('DOMContentLoaded', function() {

            // Duraciones por tipo de período (configurables)
            const duracionesPeriodos = {
                '1': 6,  // Semestre: 6 meses
                '2': 3,  // Trimestre: 3 meses
                '3': 4,  // Cuatrimestre: 4 meses
                '4': 2,  // Bimestre: 2 meses
                '5': 12  // Anual: 12 meses
            };

            // Función para inicializar el cálculo automático en cualquier modal
            function initAutoCalculate(modalId) {
                const modal = document.getElementById(modalId);
                if (!modal) return;

                const fechaInicioInput = modal.querySelector('[name="fecha_inicio"]');
                const tipoPeriodoSelect = modal.querySelector('[name="id_tipo_periodo"]');
                const fechaFinInput = modal.querySelector('[name="fecha_fin"]');

                if (!fechaInicioInput || !tipoPeriodoSelect || !fechaFinInput) return;

                // 🔄 Función para calcular la fecha fin
                function calcularFechaFin() {
                    const fechaInicio = fechaInicioInput.value;
                    const tipoPeriodo = tipoPeriodoSelect.value;

                    if (!fechaInicio || !tipoPeriodo) {
                        return;
                    }

                    const duracionMeses = duracionesPeriodos[tipoPeriodo];

                    if (!duracionMeses) {
                        console.warn('Duración no definida para el tipo de período:', tipoPeriodo);
                        return;
                    }

                    const fecha = new Date(fechaInicio + 'T00:00:00');
                    fecha.setMonth(fecha.getMonth() + duracionMeses - 1);

                    const ultimoDiaMes = new Date(fecha.getFullYear(), fecha.getMonth() + 1, 0).getDate();
                    fecha.setDate(ultimoDiaMes);

                    const year = fecha.getFullYear();
                    const month = String(fecha.getMonth() + 1).padStart(2, '0');
                    const day = String(fecha.getDate()).padStart(2, '0');
                    const fechaFin = `${year}-${month}-${day}`;

                    fechaFinInput.value = fechaFin;
                }

                // 🎯 Event listeners
                fechaInicioInput.addEventListener('change', calcularFechaFin);
                tipoPeriodoSelect.addEventListener('change', calcularFechaFin);
            }

            // Inicializar para el modal de nuevo período
            initAutoCalculate('nuevoPeriodoModal');

            // Inicializar para todos los modales de edición
            document.querySelectorAll('[id^="editarModal"]').forEach(modal => {
                initAutoCalculate(modal.id);
            });
        });
    </script>

    <!-- Modal Nuevo Período -->
    <div class="modal fade" id="nuevoPeriodoModal" tabindex="-1" role="dialog" aria-labelledby="nuevoPeriodoLabel" aria-hidden="true">
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
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar" style="position: absolute; right: 1.5rem; top: 1.5rem; font-size: 1.8rem; opacity: 0.9;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('periodos.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="is_create" value="1">
                    
                    <div class="modal-body modal-body-custom p-4">
                        <div class="form-container p-4 bg-white rounded shadow-sm border">
                            <!-- Sección 1: Información Básica -->
                            <div class="card shadow mb-2 border-0">
                                <div class="card-header py-3 text-white card-header-custom">
                                    <h6 class="m-0 font-weight-bold text-danger">
                                        <i class="fas fa-info-circle"></i> Información del Período
                                    </h6>
                                </div>
                                <div class="card-body1 p-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label-custom d-flex">
                                            Nombre del Período
                                            <span class="required-asterisk ml-1">*</span>
                                        </label>
                                        <small class="form-text text-muted">
                                            Ingrese un nombre descriptivo para el período escolar
                                        </small>
                                        <input type="text" placeholder="Ejemplo: JULIO-DICIEMBRE 2024" name="nombre" value="{{ old('nombre') }}" class="form-control form-control-custom @error('nombre') @if(old('is_create')) is-invalid @endif @enderror" required>
                                        @error('nombre')
                                            @if(old('is_create'))
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @endif
                                        @enderror
                                    </div>

                                    <div class="form-group mb-0">
                                        <label class="form-label-custom d-flex">
                                            Tipo de Período
                                            <span class="required-asterisk ml-1">*</span>
                                        </label>
                                        <select name="id_tipo_periodo" class="form-control form-control-custom @error('id_tipo_periodo') @if(old('is_create')) is-invalid @endif @enderror" required>
                                            <option value="">-- Seleccione un tipo de período --</option>
                                            @foreach ($tipos as $tipo)
                                                <option value="{{ $tipo->id_tipo_periodo }}" {{ old('id_tipo_periodo') == $tipo->id_tipo_periodo ? 'selected' : '' }}>
                                                    {{ $tipo->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_tipo_periodo')
                                            @if(old('is_create'))
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @endif
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Sección 2: Fechas -->
                            <div class="card shadow mb-2 border-0">
                                <div class="card-header py-3 text-white card-header-custom">
                                    <h6 class="m-0 font-weight-bold text-danger">
                                        <i class="fas fa-calendar-alt"></i> Fechas del Período
                                    </h6>
                                </div>
                                <div class="card-body1 p-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label-custom d-flex">
                                                    Fecha de Inicio
                                                    <span class="required-asterisk ml-1">*</span>
                                                </label>
                                                <input type="date" name="fecha_inicio" value="{{ old('fecha_inicio') }}" class="form-control form-control-custom @error('fecha_inicio') @if(old('is_create')) is-invalid @endif @enderror" required>
                                                @error('fecha_inicio')
                                                    @if(old('is_create'))
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @endif
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group mb-0">
                                                <label class="form-label-custom d-flex">
                                                    Fecha de Finalización
                                                    <span class="required-asterisk ml-1">*</span>
                                                </label>
                                                <input type="date" name="fecha_fin" value="{{ old('fecha_fin') }}" class="form-control form-control-custom @error('fecha_fin') @if(old('is_create')) is-invalid @endif @enderror" required>
                                                @error('fecha_fin')
                                                    @if(old('is_create'))
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @endif
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="periodo-info mt-3">
                                        <i class="fas fa-info-circle text-primary"></i>
                                        <strong>Nota:</strong> La fecha fin se calculará automáticamente según el tipo de período seleccionado.
                                    </div>
                                </div>
                            </div>

                            <!-- Sección 3: Estado y Ciclo -->
                            <div class="card shadow mb-4 border-0">
                                <div class="card-header py-3 text-white card-header-custom">
                                    <h6 class="m-0 font-weight-bold text-danger">
                                        <i class="fas fa-cog"></i> Configuración del Período
                                    </h6>
                                </div>
                                <div class="card-body1 p-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label-custom d-flex">
                                                    Estado del Período
                                                    <span class="required-asterisk ml-1">*</span>
                                                </label>
                                                <select name="estado" class="form-control form-control-custom @error('estado') @if(old('is_create')) is-invalid @endif @enderror" required>
                                                    <option value="">-- Seleccione el estado del período--</option>
                                                    <option value="Abierto" {{ old('estado') == 'Abierto' ? 'selected' : '' }}>
                                                        Abierto
                                                    </option>
                                                    <option value="Cerrado" {{ old('estado') == 'Cerrado' ? 'selected' : '' }}>
                                                        Cerrado
                                                    </option>
                                                </select>
                                                @error('estado')
                                                    @if(old('is_create'))
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @endif
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group mb-0">
                                                <label class="form-label-custom d-flex">
                                                    Ciclo Escolar
                                                    <span class="required-asterisk ml-1">*</span>
                                                </label>

                                                <select name="id_ciclo" class="form-control form-control-custom @error('id_ciclo') @if(old('is_create')) is-invalid @endif @enderror" required>
                                                    <option value="">-- Seleccione un ciclo escolar --</option>
                                                    @if ($cicloActual)
                                                        <option value="{{ $cicloActual->id_ciclo }}" {{ old('id_ciclo', $cicloActual->id_ciclo) == $cicloActual->id_ciclo ? 'selected' : '' }}>
                                                            {{ $cicloActual->nombre }}
                                                        </option>
                                                    @else
                                                        <option value="" disabled>No hay ciclos activos disponibles</option>
                                                    @endif
                                                </select>

                                                @if ($cicloActual)
                                                    <small class="text-success mt-1 d-block">
                                                        <i class="fas fa-check-circle"></i>
                                                        Ciclo activo actual
                                                    </small>
                                                @else
                                                    <small class="text-danger mt-1 d-block">
                                                        <i class="fas fa-exclamation-triangle"></i>
                                                        No hay un ciclo escolar activo configurado
                                                    </small>
                                                @endif

                                                @error('id_ciclo')
                                                    @if(old('is_create'))
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @endif
                                                @enderror
                                            </div>
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
                            Guardar Período
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script para reabrir modales con errores -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            
            // Abrir modal de CREAR si hay errores y es_create está marcado
            @if ($errors->any() && old('is_create'))
                var modalCrear = document.getElementById('nuevoPeriodoModal');
                if (modalCrear) {
                    $('#nuevoPeriodoModal').modal('show');
                    console.log('Abriendo modal de crear por errores');
                }
            @endif

            // Abrir modal de EDITAR si hay errores y periodo_id está presente
            @if ($errors->any() && old('periodo_id'))
                var modalEditar = document.getElementById('editarModal{{ old("periodo_id") }}');
                if (modalEditar) {
                    $('#editarModal{{ old("periodo_id") }}').modal('show');
                    console.log('Abriendo modal de editar por errores');
                }
            @endif

            // Abrir modal de CREAR si se pasó la sesión open_create_modal
            @if(session('open_create_modal'))
                setTimeout(function() {
                    $('#nuevoPeriodoModal').modal('show');
                    console.log('Abriendo modal de crear desde sesión');
                }, 300);
            @endif

            // Abrir modal de EDITAR si se pasó la sesión open_edit_modal
            @if(session('open_edit_modal'))
                setTimeout(function() {
                    $('#editarModal{{ session("open_edit_modal") }}').modal('show');
                    console.log('Abriendo modal de editar desde sesión: {{ session("open_edit_modal") }}');
                }, 300);
            @endif
        });
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