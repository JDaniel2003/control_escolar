<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Carreras</title>

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
            <div style="width: 300px; height: 120px;" class="d-none d-lg-block">
                <img src="{{ asset('libs/sbadmin/img/upn.png') }}" alt="Logo"
                    style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <div style="width: 150px; height: 60px;" class="d-lg-none">
                <img src="{{ asset('libs/sbadmin/img/upn.png') }}" alt="Logo"
                    style="width: 100%; height: 100%; object-fit: cover;">
            </div>
        </div>

        <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

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
                    <a class="nav-link navbar-active-item px-3 mr-1">Carreras</a>
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

        <div class="position-absolute d-none d-lg-flex" style="top: 10px; right: 20px; z-index: 1000;">
            <div class="d-flex align-items-center text-white">
                <span class="mr-3">{{ Auth::user()->rol->nombre }}</span>
                <a href="#" class="text-white text-decoration-none logout-link" data-toggle="modal"
                    data-target="#logoutModal">
                    Cerrar Sesión <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </div>

        <div class="w-100 d-lg-none mt-2 text-white px-3">
            <div class="d-flex justify-content-between align-items-center pb-2">
                <span>{{ Auth::user()->rol->nombre }}</span>
                <a href="#" class="text-white text-decoration-none" data-toggle="modal"
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
                        Gestión de Carreras</h1>

                    <div class="row justify-content-center">
                        <div class="col-lg-10">

                            <!-- Botón para nuevo período -->
                            <div class="mb-3 text-right">
                                <button type="button" class="btn btn-success" data-toggle="modal"
                                    data-target="#nuevacarreraModal">
                                    <i class="fas fa-plus"></i> Nueva Carrea
                                </button>
                            </div>


                            <!-- Filtros -->
                            <div class="container mb-4 d-flex justify-content-center">
                                <div class="p-3 border rounded bg-light d-inline-block shadow-sm">
                                    <form id="filtrosForm" method="GET" action="{{ route('carreras.index') }}"
                                        class="d-inline-flex flex-wrap gap-2 align-items-center">

                                        <!-- Nombre -->
                                        <div class="flex-grow-1" style="width: 400px;">
                                            <input type="text" name="nombre" class="form-control form-control-sm"
                                                placeholder="🔍 Buscar por nombre" value="{{ request('nombre') }}">
                                        </div>
                                        <!-- Duración -->
                                        <input type="text" name="duracion"
                                            class="form-control form-control-sm w-auto"
                                            placeholder="Buscar por duración" value="{{ request('duracion') }}">

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
                                        <a href="{{ route('carreras.index', ['mostrar' => 'todo']) }}"
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
                                                <th>Duración</th>
                                                <th>Plan de Estudios</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($carreras as $carrera)
                                                <tr class="text-center">
                                                    <td>{{ $carrera->nombre }}</td>
                                                    <td>{{ $carrera->duracion }}</td>
                                                    <td>
                                                        {{-- {{ $carrera->planesEstudio->first()->nombre ?? 'N/A' }} --}}
                                                        <button type="button" class="btn btn-info btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#verModal{{ $carrera->id_carrera }}">
                                                            <i class="fas fa-eye"></i> Ver Plan de Estudios
                                                        </button>


                                                        <!-- Modal Ver Plan Vigente -->
                                                        <div class="modal fade"
                                                            id="verModal{{ $carrera->id_carrera }}" tabindex="-1"
                                                            role="dialog"
                                                            aria-labelledby="verModalLabel{{ $carrera->id_carrera }}"
                                                            aria-hidden="true">

                                                            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable"
                                                                role="document">
                                                                <div class="modal-content shadow-sm border-0">

                                                                    {{-- Header --}}
                                                                    <div
                                                                        class="modal-header modal-header-custom border-0">
                                                                        <div class="w-100">
                                                                            <div class="text-center">
                                                                                <h5 class="m-0 font-weight-bold"
                                                                                    id="verModalLabel{{ $carrera->id_carrera }}">
                                                                                    📖 Plan de Estudios
                                                                                </h5>
                                                                                <p class="m-0 mt-2 mb-0"
                                                                                    style="font-size: 0.9rem; opacity: 0.95;">
                                                                                    Visualización
                                                                                    completa del plan de estudios
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

                                                                    {{-- Body --}}
                                                                    <div class="modal-body p-3"
                                                                        style="background-color: #f8f9fa;">
                                                                        <div class="container-fluid px-2">
                                                                            @php
                                                                                $planVigente = $carrera->planesEstudio
                                                                                    ->where('vigencia', 'Vigente')
                                                                                    ->first();
                                                                            @endphp

                                                                            @if ($planVigente)
                                                                                {{-- Información General --}}
                                                                                <div
                                                                                    class="bg-white rounded p-3 mb-3 shadow-sm">
                                                                                    <h6
                                                                                        class="text-danger font-weight-bold mb-3">
                                                                                        Información General</h6>
                                                                                    <div class="mt-2 text-center mb-2">
                                                                                        <small
                                                                                            class="text-muted text-uppercase d-block">
                                                                                            Plan de Estudios: </small>
                                                                                        <span
                                                                                            class="font-weight-bold text-uppercase">{{ $planVigente->nombre }}</span>

                                                                                    </div>
                                                                                    <div class="mt-2 text-center mb-2">
                                                                                        <small
                                                                                            class="text-muted text-uppercase d-block">Carrera:
                                                                                            <span
                                                                                                class="font-weight-bold">{{ $carrera->nombre }}</span></small>

                                                                                    </div>

                                                                                    <div class="row text-center">

                                                                                        <div
                                                                                            class="col-6 col-md-6 mb-2">
                                                                                            <small
                                                                                                class="text-muted text-uppercase d-block">Estado:
                                                                                                <span
                                                                                                    class="badge badge-success px-3 py-1">
                                                                                                    <i
                                                                                                        class="fas fa-check-circle mr-1"></i>
                                                                                                    {{ $planVigente->vigencia }}
                                                                                                </span></small>

                                                                                        </div>
                                                                                    </div>



                                                                                    {{--
                                                                                    <div class="text-center mt-3">
                                                                                        <a href="{{ route('planes.descargarPDF', $planVigente->id_plan_estudio) }}"
                                                                                            target="_blank" class="btn btn-danger btn-sm">
                                                                                            <i class="fas fa-file-pdf mr-1"></i>Descargar Plan de Estudios
                                                                                        </a>
                                                                                    </div> --}}
                                                                                </div>

                                                                                {{-- Mapa Curricular --}}
                                                                                <div
                                                                                    class="bg-white rounded p-3 shadow-sm">
                                                                                    <h6
                                                                                        class="text-danger font-weight-bold mb-3 d-flex align-items-center justify-content-between">
                                                                                        <span><i
                                                                                                class="fas fa-sitemap mr-2"></i>Mapa
                                                                                            Curricular</span>
                                                                                        @if ($planVigente->materias && $planVigente->materias->count() > 0)
                                                                                            <span
                                                                                                class="badge badge-info">{{ $planVigente->materias->count() }}
                                                                                                Materias</span>
                                                                                        @endif
                                                                                    </h6>

                                                                                    @if ($planVigente->materias && $planVigente->materias->count() > 0)
                                                                                        @php
                                                                                            $materiasPorPeriodo = $planVigente->materias->groupBy(
                                                                                                'id_numero_periodo',
                                                                                            );
                                                                                            $maxMaterias = $materiasPorPeriodo->map
                                                                                                ->count()
                                                                                                ->max();
                                                                                        @endphp

                                                                                        <div class="table-responsive"
                                                                                            style="max-height: 500px; overflow-y: auto;">
                                                                                            <table
                                                                                                class="table table-bordered mb-0 text-center table-sm">
                                                                                                <thead
                                                                                                    class="thead-dark">
                                                                                                    <tr>
                                                                                                        @foreach ($materiasPorPeriodo as $idPeriodo => $materias)
                                                                                                            <th class="align-middle px-2"
                                                                                                                style="min-width: 140px; font-size: 0.85rem;">
                                                                                                                <div>

                                                                                                                    {{ $materias->first()->numeroPeriodo->tipoPeriodo->nombre ?? 'Periodo' }}
                                                                                                                    {{ $materias->first()->numeroPeriodo->numero ?? '' }}
                                                                                                                </div>

                                                                                                            </th>
                                                                                                        @endforeach
                                                                                                    </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                    @for ($i = 0; $i < $maxMaterias; $i++)
                                                                                                        <tr>
                                                                                                            @foreach ($materiasPorPeriodo as $materias)
                                                                                                                <td class="align-top p-1"
                                                                                                                    style="background-color: #fafafa;">
                                                                                                                    @if (isset($materias[$i]))
                                                                                                                        <div class="border rounded p-2 bg-white shadow-sm"
                                                                                                                            style="min-height: 80px; transition: all 0.2s ease;">
                                                                                                                            <div
                                                                                                                                class="mb-1">
                                                                                                                                <strong
                                                                                                                                    class="d-block text-dark"
                                                                                                                                    style="line-height: 1.2; font-size: 0.75rem;">
                                                                                                                                    {{ $materias[$i]->nombre }}
                                                                                                                                </strong>
                                                                                                                            </div>
                                                                                                                            <div
                                                                                                                                class="mt-1 pt-1 border-top">
                                                                                                                                <div class="d-flex flex-column"
                                                                                                                                    style="font-size: 0.7rem;">
                                                                                                                                    <span
                                                                                                                                        class="text-muted mb-1">
                                                                                                                                        <i
                                                                                                                                            class="fas fa-clock text-primary"></i>
                                                                                                                                        <strong>{{ $materias[$i]->horas ?? 'N/A' }}
                                                                                                                                            hrs</strong>
                                                                                                                                    </span>
                                                                                                                                    <span
                                                                                                                                        class="text-muted">
                                                                                                                                        <i
                                                                                                                                            class="fas fa-certificate text-warning"></i>
                                                                                                                                        <strong>{{ $materias[$i]->creditos ?? 'N/A' }}
                                                                                                                                            créd</strong>
                                                                                                                                    </span>
                                                                                                                                </div>
                                                                                                                            </div>

                                                                                                                        </div>
                                                                                                                    @endif
                                                                                                                </td>
                                                                                                            @endforeach
                                                                                                        </tr>
                                                                                                    @endfor
                                                                                                    <tr
                                                                                                        style="background: #e9ecef;">
                                                                                                        @foreach ($materiasPorPeriodo as $materias)
                                                                                                            @php
                                                                                                                $totalHoras = $materias->sum(
                                                                                                                    'horas',
                                                                                                                );
                                                                                                                $totalCreditos = $materias->sum(
                                                                                                                    'creditos',
                                                                                                                );
                                                                                                            @endphp
                                                                                                            <td
                                                                                                                style="background: #e9ecef; padding: 8px 4px;">
                                                                                                                <div
                                                                                                                    style="text-align: center;">
                                                                                                                    <strong
                                                                                                                        style="display: block; color: #333; font-size: 9px; margin-bottom: 4px; text-transform: uppercase;">
                                                                                                                        Totales
                                                                                                                    </strong>
                                                                                                                    <div
                                                                                                                        class="mt-1 pt-1 border-top">
                                                                                                                        <div class="d-flex flex-column"
                                                                                                                            style="font-size: 0.6rem;">
                                                                                                                            <span
                                                                                                                                class="text-muted mb-1">
                                                                                                                                <i
                                                                                                                                    class="fas fa-clock text-primary"></i>
                                                                                                                                <strong>{{ $totalHoras }}</strong>
                                                                                                                                hrs
                                                                                                                            </span>
                                                                                                                            <span
                                                                                                                                class="text-muted">
                                                                                                                                <i
                                                                                                                                    class="fas fa-certificate text-warning"></i>
                                                                                                                                <strong>{{ $totalCreditos }}</strong>
                                                                                                                                Créditos
                                                                                                                            </span>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </td>
                                                                                                        @endforeach
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </div>
                                                                                    @else
                                                                                        <div class="alert alert-warning text-center mb-0"
                                                                                            role="alert">
                                                                                            <i
                                                                                                class="fas fa-exclamation-triangle mr-2"></i>
                                                                                            No hay materias registradas
                                                                                            para este plan de estudios.
                                                                                        </div>
                                                                                    @endif
                                                                                </div>
                                                                            @else
                                                                                <div class="alert alert-danger text-center mb-0"
                                                                                    role="alert">
                                                                                    <i
                                                                                        class="fas fa-times-circle mr-2"></i>
                                                                                    Esta carrera no tiene un plan
                                                                                    vigente registrado actualmente.
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>

                                                                    {{-- Footer --}}
                                                                    <div class="modal-footer py-2"
                                                                        style="background-color: #f8f9fa;">
                                                                        <button type="button"
                                                                            class="btn btn-secondary btn-sm px-3"
                                                                            data-dismiss="modal">
                                                                            <i class="fas fa-times mr-1"></i>Cerrar
                                                                        </button>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>

                                                    </td>

                                                    <td>




                                                        <button type="button" class="btn btn-warning btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#editarModal{{ $carrera->id_carrera }}">
                                                            <i class="fas fa-edit"></i> Editar
                                                        </button>

                                                        <div class="modal fade"
                                                            id="editarModal{{ $carrera->id_carrera }}" tabindex="-1"
                                                            role="dialog"
                                                            aria-labelledby="editarModalLabel{{ $carrera->id_carrera }}"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content border-0 shadow-lg">

                                                                    <div
                                                                        class="modal-header modal-header-custom border-0">
                                                                        <div class="w-100">
                                                                            <div class="text-center">
                                                                                <h5 class="m-0 font-weight-bold"
                                                                                    id="editarModalLabel{{ $carrera->id_carrera }}">
                                                                                    ✏️ Editar Carrera</h5>
                                                                                <p class="text-center m-0 mt-2"
                                                                                    style="font-size: 0.9rem; opacity: 0.95;">
                                                                                    Modifique la información de la
                                                                                    carrera
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
                                                                        action="{{ route('carreras.update', $carrera->id_carrera) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('PUT')

                                                                        <div class="modal-body modal-body-custom p-4">
                                                                            <div
                                                                                class="form-container p-4 bg-white rounded shadow-sm border">

                                                                                <div class="form-group">
                                                                                    <label
                                                                                        style="text-align: left; display: block;">📝
                                                                                        Nombre de la Carrera</label>
                                                                                    <input type="text"
                                                                                        placeholder="Ejemplo: Ingeniería en Sistemas Computacionales"
                                                                                        name="nombre"
                                                                                        class="form-control"
                                                                                        value="{{ $carrera->nombre }}"
                                                                                        required>
                                                                                    @error('nombre')
                                                                                        <div class="invalid-feedback">
                                                                                            {{ $message }}</div>
                                                                                    @enderror
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        style="text-align: left; display: block;">
                                                                                        🕖 Duración de la
                                                                                        Carrera</label>
                                                                                    <input type="text"
                                                                                        name="duracion"
                                                                                        placeholder="Ejemplo: 5 años"
                                                                                        class="form-control"
                                                                                        value="{{ $carrera->duracion }}"
                                                                                        required>
                                                                                    @error('duracion')
                                                                                        <div class="invalid-feedback">
                                                                                            {{ $message }}</div>
                                                                                    @enderror
                                                                                </div>

                                                                            </div>
                                                                            <div
                                                                                class="modal-footer modal-footer-custom">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-dismiss="modal">
                                                                                    Cancelar
                                                                                </button>
                                                                                <button type="submit"
                                                                                    class="btn btn-success">
                                                                                    ✓ Actualizar Carrera
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </form>

                                                                </div>
                                                            </div>
                                                        </div>


                                                        <form action="{{ route('carreras.destroy', $carrera) }}"
                                                            method="POST" style="display:inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                data-toggle="modal"
                                                                data-target="#eliminarModal{{ $carrera->id_carrera }}">
                                                                <i class="fas fa-trash-alt"></i> Eliminar
                                                            </button>

                                                            <!-- Modal de Confirmación -->
                                                            <div class="modal fade"
                                                                id="eliminarModal{{ $carrera->id_carrera }}"
                                                                tabindex="-1" role="dialog"
                                                                aria-labelledby="eliminarModalLabel{{ $carrera->id_carrera }}"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div
                                                                            class="modal-header1 modal-header-custom border-0">
                                                                            <div class="w-100">
                                                                                <div class="text-center">

                                                                                    <h5 class="m-0 font-weight-bold"
                                                                                        id="eliminarModalLabel{{ $carrera->id_carrera }}">
                                                                                        🗑️ Eliminar Carrera</h5>
                                                                                </div>
                                                                            </div>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal"
                                                                                aria-label="Cerrar">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            ¿Seguro que deseas eliminar la carrera
                                                                            <strong>{{ $carrera->nombre }}</strong>?
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-dismiss="modal">Cancelar</button>
                                                                            <form
                                                                                action="{{ route('carreras.destroy', $carrera) }}"
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

                                                        </form>

                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="100" class="text-center text-muted">No hay carreras
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






    <!-- Modal Nuevo Período -->
    <div class="modal fade" id="nuevacarreraModal" tabindex="-1" role="dialog"
        aria-labelledby="nuevoPeriodoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content border-0 shadow-lg">

                <div class="modal-header modal-header-custom border-0">
                    <div class="w-100">
                        <div class="text-center">

                            <h5 class="m-0 font-weight-bold" id="nuevacarreraLabel">
                                🎓 Nueva Carrera
                            </h5>
                            <p class="m-0 mt-2 mb-0" style="font-size: 0.9rem; opacity: 0.95;">
                                Complete la información correspondiente de la Carrera
                            </p>
                        </div>
                    </div>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar"
                        style="position: absolute; right: 1.5rem; top: 1.5rem; font-size: 1.8rem; opacity: 0.9;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>


                <form action="{{ route('carreras.store') }}" method="POST">
                    @csrf
                    <div class="modal-body modal-body-custom p-4">
                        <div class="form-container p-4 bg-white rounded shadow-sm border">
                            <div class="form-group mb-3">
                                <label>📝 Nombre de la Carrera</label>
                                <small class="form-text text-muted">
                                    Ingrese un nombre para la nueva carrera
                                </small>
                                <input type="text" placeholder="Ejemplo: Ingeniería en Sistemas Computacionales"
                                    name="nombre" class="form-control" required>
                            </div>

                            <div class="form-group mb-3">
                                <label>🕖 Duración de la Carrera</label>
                                <input type="text" placeholder="Ejemplo: 5 años" name="duracion"
                                    class="form-control">
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
                            Guardar Carrera
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>


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
