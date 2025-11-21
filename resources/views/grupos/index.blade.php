<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Grupos</title>
    <link href="{{ asset('libs/fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('libs/sbadmin/img/up_logo.png') }}">
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
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">¿Seguro de cerrar sesión?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Seleccione "Si" si desea finalizar su sesión.</div>
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
                <li class="nav-item"><a class="nav-link text-white px-3" href="{{ route('historial.index') }}">Historial</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3" href="#">Calificaciones</a></li>
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
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid py-5">
                    <h1 class="text-danger text-center mb-5" style="font-size: 2.5rem; font-family: 'Arial Black', Verdana, sans-serif; font-weight: bold;">
                        Gestión de Grupos
                    </h1>
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="mb-3 text-right">
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#crearGrupoModal">
                                    <i class="fas fa-plus"></i> Nuevo Grupo
                                </button>
                            </div>

                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <div class="card-body1">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover text-center">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Carrera</th>
                                                <th>Turno</th>
                                                <th>Período</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($grupos as $grupo)
                                                <tr>
                                                    <td>{{ $grupo->nombre }}</td>
                                                    <td>{{ $grupo->carrera?->nombre ?? '—' }}</td>
                                                    <td>{{ $grupo->turno?->nombre ?? '—' }}</td>
                                                    <td>{{ $grupo->periodoEscolar?->nombre ?? '—' }}</td>
                                                    <td>
                                                        <!-- Ver -->
                                                        <button class="btn btn-info btn-sm" data-toggle="modal"
                                                            data-target="#verGrupoModal{{ $grupo->id_grupo }}">
                                                            <i class="fas fa-eye"></i> Ver
                                                        </button>
                                                        <!-- Editar -->
                                                        <button class="btn btn-warning btn-sm" data-toggle="modal"
                                                            data-target="#editarGrupoModal{{ $grupo->id_grupo }}">
                                                            <i class="fas fa-edit"></i> Editar
                                                        </button>
                                                        <!-- Eliminar -->
                                                        <form action="{{ route('grupos.destroy', $grupo->id_grupo) }}" method="POST"
                                                            style="display:inline;" onsubmit="return confirm('¿Eliminar este grupo?');">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                <i class="fas fa-trash-alt"></i> Eliminar
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>

                                                <!-- Modal Ver Grupo -->
                                                <div class="modal fade" id="verGrupoModal{{ $grupo->id_grupo }}" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-info text-white">
                                                                <h5 class="modal-title">👁️ Detalles del Grupo</h5>
                                                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p><strong>Nombre:</strong> {{ $grupo->nombre }}</p>
                                                                <p><strong>Carrera:</strong> {{ $grupo->carrera?->nombre ?? 'No asignada' }}</p>
                                                                <p><strong>Turno:</strong> {{ $grupo->turno?->nombre ?? 'No asignado' }}</p>
                                                                <p><strong>Período Escolar:</strong> {{ $grupo->periodoEscolar?->nombre ?? 'No asignado' }}</p>
                                                                @if($grupo->datos)
                                                                    <p><strong>Datos Adicionales:</strong></p>
                                                                    <pre>{{ json_encode(json_decode($grupo->datos), JSON_PRETTY_PRINT) }}</pre>
                                                                @endif
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Modal Editar Grupo -->
                                                <div class="modal fade" id="editarGrupoModal{{ $grupo->id_grupo }}" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-warning">
                                                                <h5 class="modal-title">✏️ Editar Grupo</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('grupos.update', $grupo->id_grupo) }}" method="POST">
                                                                    @csrf @method('PUT')
                                                                    <div class="mb-3">
                                                                        <label>Nombre del Grupo <span class="text-danger">*</span></label>
                                                                        <input type="text" name="nombre" class="form-control"
                                                                            value="{{ old('nombre', $grupo->nombre) }}" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label>Carrera</label>
                                                                        <select name="id_carrera" class="form-control">
                                                                            <option value="">-- Sin carrera --</option>
                                                                            @foreach($carreras as $carrera)
                                                                                <option value="{{ $carrera->id_carrera }}" {{ old('id_carrera', $grupo->id_carrera) == $carrera->id_carrera ? 'selected' : '' }}>
                                                                                    {{ $carrera->nombre }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label>Turno</label>
                                                                        <select name="id_turno" class="form-control">
                                                                            <option value="">-- Sin turno --</option>
                                                                            @foreach($turnos as $turno)
                                                                                <option value="{{ $turno->id_turno }}" {{ old('id_turno', $grupo->id_turno) == $turno->id_turno ? 'selected' : '' }}>
                                                                                    {{ $turno->nombre }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label>Período Escolar</label>
                                                                        <select name="periodo" class="form-control">
                                                                            <option value="">-- Sin período --</option>
                                                                            @foreach($periodos as $periodo)
                                                                                <option value="{{ $periodo->id_periodo_escolar }}" {{ old('periodo', $grupo->periodo) == $periodo->id_periodo_escolar ? 'selected' : '' }}>
                                                                                    {{ $periodo->nombre }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="text-right mt-3">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                                        <button type="submit" class="btn btn-primary">Actualizar</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-muted text-center">No hay grupos registrados</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Sistema Control Escolar 2025</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Modal Crear Grupo -->
    <div class="modal fade" id="crearGrupoModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header modal-header-custom">
                    <h5 class="modal-title">🆕 Crear Nuevo Grupo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('grupos.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label>Nombre del Grupo <span class="text-danger">*</span></label>
                            <input type="text" name="nombre" class="form-control" placeholder="Ej: 1A, 2B, etc." required>
                        </div>
                        <div class="mb-3">
                            <label>Carrera</label>
                            <select name="id_carrera" class="form-control">
                                <option value="">-- Selecciona una carrera --</option>
                                @foreach($carreras as $carrera)
                                    <option value="{{ $carrera->id_carrera }}">{{ $carrera->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Turno</label>
                            <select name="id_turno" class="form-control">
                                <option value="">-- Selecciona un turno --</option>
                                @foreach($turnos as $turno)
                                    <option value="{{ $turno->id_turno }}">{{ $turno->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Período Escolar</label>
                            <select name="periodo" class="form-control">
                                <option value="">-- Selecciona un período --</option>
                                @foreach($periodos as $periodo)
                                    <option value="{{ $periodo->id_periodo_escolar }}">{{ $periodo->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="text-right mt-3">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success">Crear Grupo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('libs/sbadmin/js/sb-admin-2.min.js') }}"></script>
</body>
</html>