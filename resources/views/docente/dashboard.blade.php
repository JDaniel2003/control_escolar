<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mis Asignaciones - Calificaciones</title>

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

    <!-- Logout Modal-->
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
            <div style="width: 300px; height: 120px; ">
                <img src="{{ asset('libs/sbadmin/img/upn.png') }}" alt="Logo"
                    style="width: 100%; height: 100%; object-fit: cover;">
            </div>
        </div>

        <div class="collapse navbar-collapse ml-4">
            <ul class="navbar-nav" style="padding-left: 75%;">
                <li class="nav-item">
                    <a class="nav-link navbar-active-item px-3 mr-1" href="{{ route('docente.dashboard') }}">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white px-3 mr-1" href="{{ route('docente.asignaciones') }}">Mis Asignaciones</a>
                </li>
            </ul>
        </div>

        <div class="position-absolute" style="top: 10px; right: 20px; z-index: 1000;">
            <div class="d-flex align-items-center text-white">
                <span class="mr-3 small">{{ Auth::user()->rol->nombre }}</span>
                <a href="" class="text-white text-decoration-none logout-link" data-toggle="modal" data-target="#logoutModal">
                    Cerrar Sesión <i class="fas fa-sign-out-alt ml-1"></i>
                </a>
            </div>
        </div>
    </nav>

    
    <div class="container mx-auto mt-8 p-4">
        <h1 class="text-danger text-center mb-5"
                            style="font-size: 2.5rem;margin-top: 5%; font-family: 'Arial Black', Verdana, sans-serif; font-weight: bold;">
                            Bienvenido Docente
                        </h1>
        <h2 class="fw-semibold text-dark mt-2 text-uppercase text-center" style="font-size: 3rem;">
    {{ auth()->user()?->docente?->datosDocentes?->nombre_con_abreviatura ?? 'SIN NOMBRE' }}
</h2>


</p>

        {{--<p>Nivel: {{ auth()->user()->getNivel() }}</p>--}}
    </div>
    
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('libs/sbadmin/js/sb-admin-2.min.js') }}"></script>
</body>
</html>