<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Inicio</title>

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
                <li class="nav-item"><a class="nav-link navbar-active-item px-3 mr-1">Inicio</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1" href="{{ route('periodos.index') }}">Períodos Escolares</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1" href="{{ route('carreras.index') }}">Carreras</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1" href="{{ route('materias.index') }}">Materias</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1" href="{{ route('planes.index') }}">Planes de estudio</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1" href="{{ route('alumnos.index') }}">Alumnos</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1" href="{{ route('asignaciones.index') }}">Asignaciones Docentes</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3" href="{{ route('historial.index') }}">Historial</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1" href="{{ route('calificaciones.index') }}">Calificaciones</a></li>

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
                        Bienvenidos al Sistema de Control Escolar</h1>

                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="row">

                                
                                <!-- ALUMNOS -->
                                <div onclick="window.location.href='{{ route('alumnos.index') }}'"
                                    class="col-md-6 col-lg-4 mb-4">
                                    <div class="logout-link card border-success h-100"
                                        style="border-width: 3px; border-radius: 25px;">
                                        <div class="card-body d-flex justify-content-between align-items-center py-4">
                                            <h5 class="card-title font-weight-bold mb-0">ALUMNOS</h5>
                                            <i class="fas fa-user-graduate fa-2x text-success"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- DOCENTES -->
                                <div onclick="window.location.href='{{ route('docente.index') }}'"
                                    class="col-md-6 col-lg-4 mb-4">
                                    <div class="logout-link card border-success h-100"
                                        style="border-width: 3px; border-radius: 25px;">
                                        <div class="card-body d-flex justify-content-between align-items-center py-4">
                                            <h5 class="card-title font-weight-bold mb-0">DOCENTES</h5>
                                            <i class="fas fa-chalkboard-teacher fa-2x text-success"></i>
                                        </div>
                                    </div>
                                </div>

                                <div onclick="window.location.href='{{ route('usuarios.index') }}'"
                                    class="col-md-6 col-lg-4 mb-4">
                                    <div class="logout-link card border-success h-100"
                                        style="border-width: 3px; border-radius: 25px;">
                                        <div class="card-body d-flex justify-content-between align-items-center py-4">
                                            <h5 class="card-title font-weight-bold mb-0">USUARIOS</h5>
                                            <i class="fas fa-chalkboard-teacher fa-2x text-success"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- CALIFICACIONES -->
                                <div onclick="window.location.href='{{ route('calificaciones.index') }}'"
                                    class="col-md-6 col-lg-4 mb-4">
                                    <div class="logout-link card border-success h-100"
                                        style="border-width: 3px; border-radius: 25px;">
                                        <div class="card-body d-flex justify-content-between align-items-center py-4">
                                            <h5 class="card-title font-weight-bold mb-0">CALIFICACIONES</h5>
                                            <i class="fas fa-clipboard-check fa-2x text-success"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- CARRERAS -->
                               <div onclick="window.location.href='{{ route('carreras.index') }}'"
                                    class="col-md-6 col-lg-4 mb-4">
                                    <div class="logout-link card border-success h-100"
                                        style="border-width: 3px; border-radius: 25px;">
                                        <div class="card-body d-flex justify-content-between align-items-center py-4">
                                            <h5 class="card-title font-weight-bold mb-0">CARRERAS</h5>
                                            <i class="fas fa-graduation-cap fa-2x text-success"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- MATERIAS -->

                                <div onclick="window.location.href='{{ route('materias.index') }}'"
                                    class="col-md-6 col-lg-4 mb-4">
                                    <div class="logout-link card border-success h-100"
                                        style="border-width: 3px; border-radius: 25px;">
                                        <div class="card-body d-flex justify-content-between align-items-center py-4">
                                            <h5 class="card-title font-weight-bold mb-0">MATERIAS</h5>
                                            <i class="fas fa-layer-group fa-2x text-success"></i>
                                        </div>
                                    </div>
                                </div>

                                 <!-- GRUPOS -->
                                <div onclick="window.location.href='{{ route('grupos.index') }}'"
                                    class="col-md-6 col-lg-4 mb-4">
                                    <div class="logout-link card border-success h-100"
                                        style="border-width: 3px; border-radius: 25px;">
                                        <div class="card-body d-flex justify-content-between align-items-center py-4">
                                            <h5 class="card-title font-weight-bold mb-0">GRUPOS</h5>
                                            <i class="fas fa-layer-group fa-2x text-success"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- INSCRIPCIONES -->
                                <div onclick="window.location.href='{{ route('historial.index') }}'"
                                    class="col-md-6 col-lg-4 mb-4">
                                    <div class="logout-link card border-success h-100"
                                        style="border-width: 3px; border-radius: 25px;">
                                        <div class="card-body d-flex justify-content-between align-items-center py-4">
                                            <h5 class="card-title font-weight-bold mb-0">INSCRIPCIONES</h5>
                                            <i class="fas fa-user-edit fa-2x text-success"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- PERIODOS ESCOLARES -->
                                <div onclick="window.location.href='{{ route('periodos.index') }}'"
                                    class="col-md-6 col-lg-4 mb-4">
                                    <div class="logout-link card border-success h-100"
                                        style="border-width: 3px; border-radius: 25px;">
                                        <div class="card-body d-flex justify-content-between align-items-center py-4">
                                            <h5 class="card-title font-weight-bold mb-0">PERIODOS ESCOLARES</h5>
                                            <i class="fas fa-calendar-alt fa-2x text-success"></i>
                                        </div>
                                    </div>
                                </div>

                                <div onclick="window.location.href='{{ route('historial.index') }}'"
                                    class="col-md-6 col-lg-4 mb-4">
                                    <div class="logout-link card border-success h-100"
                                        style="border-width: 3px; border-radius: 25px;">
                                        <div class="card-body d-flex justify-content-between align-items-center py-4">
                                            <h5 class="card-title font-weight-bold mb-0">HISTORIAL</h5>
                                            <i class="fas fa-file-alt fa-2x text-success"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- CATÁLOGOS -->
                                <div onclick="window.location.href='{{ route('catalogos.index') }}'"
                                    class="col-md-6 col-lg-4 mb-4">
                                    <div class="logout-link card border-success h-100"
                                        style="border-width: 3px; border-radius: 25px;">
                                        <div class="card-body d-flex justify-content-between align-items-center py-4">
                                            <h5 class="card-title font-weight-bold mb-0">CATÁLOGOS</h5>
                                            <i class="fas fa-user-graduate fa-2x text-success"></i>
                                        </div>
                                    </div>
                                </div>

                                

                                <!-- PLANES DE ESTUDIO -->
                                <div onclick="window.location.href='{{ route('planes.index') }}'"
                                    class="col-md-6 col-lg-4 mb-4">
                                    <div class="logout-link card border-success h-100"
                                        style="border-width: 3px; border-radius: 25px;">
                                        <div class="card-body d-flex justify-content-between align-items-center py-4">
                                            <h5 class="card-title font-weight-bold mb-0">PLANES DE ESTUDIO</h5>
                                            <i class="fas fa-book-open fa-2x text-success"></i>
                                        </div>
                                    </div>
                                </div>

                                <div onclick="window.location.href='{{ route('historial.index') }}'"
                                    class="col-md-6 col-lg-4 mb-4">
                                    <div class="logout-link card border-success h-100"
                                        style="border-width: 3px; border-radius: 25px;">
                                        <div class="card-body d-flex justify-content-between align-items-center py-4">
                                            <h5 class="card-title font-weight-bold mb-0">REINSCRIPCIONES</h5>
                                            <i class="fas fa-sync-alt fa-2x text-success"></i>
                                        </div>
                                    </div>
                                </div>

                                <div onclick="window.location.href='{{ route('asignaciones.index') }}'"
                                    class="col-md-6 col-lg-4 mb-4">
                                    <div class="logout-link card border-success h-100"
                                        style="border-width: 3px; border-radius: 25px;">
                                        <div class="card-body d-flex justify-content-between align-items-center py-4">
                                            <h5 class="card-title font-weight-bold mb-0">ASIGNACIONES DOCENTES</h5>
                                            <i class="fas fa-clipboard-check fa-2x text-success"></i>
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

</body>

</html>
