<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Calificaciones</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('libs/fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('libs/sbadmin/img/up_logo.png') }}">
    
    <!-- Custom styles for this template-->
    <link href="{{ asset('libs/sbadmin/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        .table-calificaciones {
            font-size: 0.9rem;
        }
        .calificacion-alta {
            background-color: #d4edda;
            color: #155724;
            font-weight: bold;
        }
        .calificacion-media {
            background-color: #fff3cd;
            color: #856404;
        }
        .calificacion-baja {
            background-color: #f8d7da;
            color: #721c24;
        }
        .bg-primary-custom {
            background-color: #2c3e50 !important;
        }
    </style>
</head>

<body id="page-top">

    <!-- Top Header -->
    <div class="bg-danger text-white1 text-center py-2">
        <div class="d-flex justify-content-between align-items-center px-4">

            <h4 class="mb-0" style="text-align: center;">SISTEMA DE CONTROL ESCOLAR</h4>

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
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1" href="{{ route('admin') }}">Inicio</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1" href="{{ route('periodos.index') }}">Períodos Escolares</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1" href="{{ route('carreras.index') }}">Carreras</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1" href="{{ route('materias.index') }}">Materias</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1" href="{{ route('planes.index') }}">Planes de estudio</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1" href="{{ route('alumnos.index') }}">Alumnos</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1" href="{{ route('asignaciones.index') }}">Asignaciones Docentes</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1" href="{{ route('historial.index') }}">Historial</a></li>
                <li class="nav-item"><a class="nav-link navbar-active-item px-3" href="{{ route('calificaciones.index') }}">Calificaciones</a></li>
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
                        Gestión de Calificaciones
                    </h1>

                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            
                            <!-- Filtros -->
                            <div class="container mb-4 d-flex justify-content-center">
                                <div class="p-3 border rounded bg-light d-inline-block shadow-sm">
                                    <form id="filtrosForm" method="GET" action="{{ route('calificaciones.index') }}" class="d-flex flex-wrap gap-2 align-items-center">
                                        
                                        <!-- Mostrar -->
                                        <select name="mostrar" onchange="this.form.submit()" class="form-control form-control-sm w-auto">
                                            <option value="10" {{ request('mostrar') == 10 ? 'selected' : '' }}>10</option>
                                            <option value="25" {{ request('mostrar') == 25 ? 'selected' : '' }}>25</option>
                                            <option value="50" {{ request('mostrar') == 50 ? 'selected' : '' }}>50</option>
                                            <option value="todo" {{ request('mostrar') == 'todo' ? 'selected' : '' }}>Todo</option>
                                        </select>

                                        <!-- Botón Mostrar todo -->
                                        <a href="{{ route('calificaciones.index', ['mostrar' => 'todo']) }}" class="btn btn-sm btn-outline-secondary d-flex align-items-center">
                                            <i class="fas fa-list me-1"></i> Mostrar todo
                                        </a>
                                    </form>
                                </div>
                            </div>

                            <!-- Tabla de Calificaciones -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 bg-primary-custom">
                                    <h6 class="m-0 font-weight-bold text-white">Lista de Calificaciones</h6>
                                </div>
                                <div class="card-body">
                                    @if (session('success'))
                                        <div class="alert alert-success">{{ session('success') }}</div>
                                    @endif

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-calificaciones" id="dataTable" width="100%" cellspacing="0">
                                            <thead class="thead-dark text-center">
                                                <tr>
                                                    <th>Alumno</th>
                                                    <th>Unidad</th>
                                                    <th>Evaluación</th>
                                                    <th>Asignación</th>
                                                    <th>Calificación</th>
                                                    <th>Fecha Registro</th>
                                                    <th>Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($calificaciones as $calificacion)
                                                    @php
                                                        $calif = $calificacion->calificacion;
                                                        if ($calif >= 8) {
                                                            $clase = 'calificacion-alta';
                                                        } elseif ($calif >= 6) {
                                                            $clase = 'calificacion-media';
                                                        } else {
                                                            $clase = 'calificacion-baja';
                                                        }
                                                    @endphp
                                                    <tr class="text-center">
                                                        <td>{{ $calificacion->alumno->nombre ?? 'N/A' }} {{ $calificacion->alumno->apellido_paterno ?? '' }}</td>
                                                        <td>{{ $calificacion->unidad->nombre ?? 'N/A' }}</td>
                                                        <td>{{ $calificacion->evaluacion->nombre ?? 'N/A' }}</td>
                                                        <td>{{ $calificacion->asignacionDocente->id_asignacion ?? 'N/A' }}</td>
                                                        <td class="{{ $clase }}">{{ number_format($calificacion->calificacion, 1) }}</td>
                                                        <td>{{ $calificacion->fecha_registro ? \Carbon\Carbon::parse($calificacion->fecha_registro)->format('d/m/Y') : 'N/A' }}</td>
                                                        <td>
                                                            @if($calif >= 6)
                                                                <span class="badge badge-success">Aprobado</span>
                                                            @else
                                                                <span class="badge badge-danger">Reprobado</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center text-muted py-4">
                                                            <i class="fas fa-info-circle fa-2x mb-3"></i><br>
                                                            No hay calificaciones registradas
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Estadísticas -->
                                    @if($calificaciones->count() > 0)
                                    <div class="row mt-4">
                                        <div class="col-md-3">
                                            <div class="card border-left-primary shadow h-100 py-2">
                                                <div class="card-body">
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col mr-2">
                                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                Promedio General</div>
                                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                {{ number_format($calificaciones->avg('calificacion'), 2) }}
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card border-left-success shadow h-100 py-2">
                                                <div class="card-body">
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col mr-2">
                                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                                Aprobados</div>
                                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                {{ $calificaciones->where('calificacion', '>=', 6)->count() }}
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card border-left-warning shadow h-100 py-2">
                                                <div class="card-body">
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col mr-2">
                                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                                Calificación Máxima</div>
                                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                {{ number_format($calificaciones->max('calificacion'), 1) }}
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <i class="fas fa-arrow-up fa-2x text-gray-300"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card border-left-danger shadow h-100 py-2">
                                                <div class="card-body">
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col mr-2">
                                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                                Calificación Mínima</div>
                                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                {{ number_format($calificaciones->min('calificacion'), 1) }}
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <i class="fas fa-arrow-down fa-2x text-gray-300"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
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

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">¿Listo para salir?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Selecciona "Cerrar Sesión" si estás listo para finalizar tu sesión actual.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-primary" href="{{ route('login') }}">Cerrar Sesión</a>
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
        document.addEventListener("DOMContentLoaded", function() {
            // Auto-submit para filtros
            let form = document.getElementById("filtrosForm");
            if (form) {
                form.querySelectorAll("select").forEach(el => {
                    el.addEventListener("change", function() {
                        form.submit();
                    });
                });
            }
        });
    </script>
</body>
</html>