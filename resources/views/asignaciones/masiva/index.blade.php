<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Asignación Masiva</title>
    <link href="{{ asset('libs/fontawesome/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('libs/sbadmin/img/up_logo.png') }}">
    <link href="{{ asset('libs/sbadmin/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <style>
        .card-option {
            transition: all 0.3s ease;
            cursor: pointer;
            border: 2px solid transparent;
        }
        .card-option:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            border-color: #4e73df;
        }
        .card-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
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
                    <a class="nav-link navbar-active-item px-3 mr-1" href="{{ route('asignaciones.index') }}">Asignaciones Docentes</a>
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
                <a href="#" class="text-white text-decoration-none logout-link" data-toggle="modal" data-target="#logoutModal">
                    Cerrar Sesión <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </div>
    </nav>

    <div class="container-fluid py-5">
        <div class="row mb-4">
            <div class="col-12">
                <a href="{{ route('asignaciones.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver a Asignaciones
                </a>
            </div>
        </div>

        <h1 class="text-danger text-center mb-5" style="font-size: 2.5rem; font-family: 'Arial Black', Verdana, sans-serif; font-weight: bold;">
            Asignación Masiva de Docentes
        </h1>

        <div class="row justify-content-center">
            <div class="col-md-5 mb-4">
                <a href="{{ route('asignaciones.masiva.materias-grupo') }}" class="text-decoration-none">
                    <div class="card card-option h-100 shadow">
                        <div class="card-body text-center p-5">
                            <div class="card-icon text-primary">
                                <i class="fas fa-book-reader"></i>
                            </div>
                            <h3 class="card-title text-dark font-weight-bold mb-3">
                                Asignar Materias a Grupo
                            </h3>
                            <p class="card-text text-muted">
                                Seleccione un grupo y asigne múltiples materias con sus respectivos docentes de forma simultánea
                            </p>
                            <div class="mt-4">
                                <span class="badge badge-primary badge-pill p-2">
                                    <i class="fas fa-users mr-1"></i> 1 Grupo → N Materias
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-5 mb-4">
                <a href="{{ route('asignaciones.masiva.docente-materias') }}" class="text-decoration-none">
                    <div class="card card-option h-100 shadow">
                        <div class="card-body text-center p-5">
                            <div class="card-icon text-success">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <h3 class="card-title text-dark font-weight-bold mb-3">
                                Asignar Docente a Materias
                            </h3>
                            <p class="card-text text-muted">
                                Seleccione un docente y asigne múltiples materias en diferentes grupos de forma simultánea
                            </p>
                            <div class="mt-4">
                                <span class="badge badge-success badge-pill p-2">
                                    <i class="fas fa-user-tie mr-1"></i> 1 Docente → N Grupos/Materias
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
                <div class="alert alert-info">
                    <h5><i class="fas fa-info-circle"></i> Información</h5>
                    <ul class="mb-0">
                        <li>Las asignaciones masivas permiten agilizar el proceso de asignación de materias y docentes</li>
                        <li>El sistema verificará automáticamente que no existan asignaciones duplicadas</li>
                        <li>Puede asignar docentes opcionales al momento de asignar materias a grupos</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <footer class="sticky-footer bg-white mt-5">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Copyright &copy; Tu Web 2025</span>
            </div>
        </div>
    </footer>

    <script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('libs/sbadmin/js/sb-admin-2.min.js') }}"></script>
</body>
</html>