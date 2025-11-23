<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Usuarios</title>
    <link href="{{ asset('libs/fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('libs/sbadmin/img/up_logo.png') }}">
    <link href="{{ asset('libs/sbadmin/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>
<body id="page-top">
    <!-- Top Header -->
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
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1" href="{{ route('asignaciones.index') }}">Asignaciones Docentes</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3" href="{{ route('historial.index') }}">Historial</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3" href="{{ route('calificaciones.index') }}">Calificaciones</a></li>
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
                        Gestión de Usuarios
                    </h1>
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="mb-3 text-right">
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#crearUsuarioModal">
                                    <i class="fas fa-user-plus"></i> Nuevo Usuario
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
                                                <th>Usuario</th>
                                                <th>Rol</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($usuarios as $usuario)
                                                <tr>
                                                    <td>{{ $usuario->username }}</td>
                                                    <td>{{ $usuario->rol->nombre ?? 'Sin rol' }}</td>
                                                    
                                                    <td>
                                                        <!-- Ver -->
                                                        <button class="btn btn-info btn-sm" data-toggle="modal"
                                                            data-target="#verUsuarioModal{{ $usuario->id_usuario }}">
                                                            <i class="fas fa-eye"></i> Ver
                                                        </button>
                                                        <!-- Editar -->
                                                        <button class="btn btn-warning btn-sm" data-toggle="modal"
                                                            data-target="#editarUsuarioModal{{ $usuario->id_usuario }}">
                                                            <i class="fas fa-edit"></i> Editar
                                                        </button>
                                                        <!-- Contraseña -->
                                                        <button class="btn btn-secondary btn-sm" data-toggle="modal"
                                                            data-target="#cambiarPasswordModal{{ $usuario->id_usuario }}">
                                                            <i class="fas fa-key"></i>Cambiar Contraseña
                                                        </button>
                                                        <!-- Eliminar -->
                                                        <form action="{{ route('usuarios.destroy', $usuario->id_usuario) }}" method="POST"
                                                            style="display:inline;" onsubmit="return confirm('¿Eliminar este usuario?');">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                <i class="fas fa-trash-alt"></i> Eliminar
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>

                                                <!-- Modal Ver Usuario -->
                                                <div class="modal fade" id="verUsuarioModal{{ $usuario->id_usuario }}" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-info text-white">
                                                                <h5 class="modal-title">👁️ Detalles del Usuario</h5>
                                                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p><strong>Usuario:</strong> {{ $usuario->username }}</p>
                                                                <p><strong>Contraseña:</strong> {{ $usuario->password }}</p>
                                                                <p><strong>Rol:</strong> {{ $usuario->rol->nombre ?? 'Sin rol' }}</p>
                                                                <p><strong>Estado:</strong> {{ $usuario->activo ? 'Activo' : 'Inactivo' }}</p>
                                                                <p><strong>Registrado:</strong> {{ $usuario->created_at ? $usuario->created_at->format('d/m/Y H:i') : '—' }}</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Modal Editar Usuario -->
                                                <div class="modal fade" id="editarUsuarioModal{{ $usuario->id_usuario }}" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-warning">
                                                                <h5 class="modal-title">✏️ Editar Usuario</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('usuarios.update', $usuario->id_usuario) }}" method="POST">
                                                                    @csrf @method('PUT')
                                                                    <div class="row">
                                                                        <div class="col-md-6 mb-3">
                                                                            <label>Usuario <span class="text-danger">*</span></label>
                                                                            <input type="text" name="username" class="form-control"
                                                                                value="{{ old('username', $usuario->username) }}" required>
                                                                        </div>
                                                                        <!-- ❌ CORREO ELIMINADO -->
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-6 mb-3">
                                                                            <label>Rol <span class="text-danger">*</span></label>
                                                                            <select name="id_rol" class="form-control" required>
                                                                                @foreach($roles as $rol)
                                                                                    <option value="{{ $rol->id_rol }}" {{ old('id_rol', $usuario->id_rol) == $rol->id_rol ? 'selected' : '' }}>
                                                                                        {{ $rol->nombre }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label>Estado</label>
                                                                            <select name="activo" class="form-control">
                                                                                <option value="1" {{ old('activo', $usuario->activo) == 1 ? 'selected' : '' }}>Activo</option>
                                                                                <option value="0" {{ old('activo', $usuario->activo) == 0 ? 'selected' : '' }}>Inactivo</option>
                                                                            </select>
                                                                        </div>
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

                                                <!-- Modal Cambiar Contraseña -->
                                                <div class="modal fade" id="cambiarPasswordModal{{ $usuario->id_usuario }}" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-secondary text-white">
                                                                <h5 class="modal-title">🔑 Cambiar Contraseña</h5>
                                                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('usuarios.update', $usuario->id_usuario) }}" method="POST">
                                                                    @csrf @method('PUT')
                                                                    <input type="hidden" name="change_password" value="1">
                                                                    <div class="mb-3">
                                                                        <label>Nueva Contraseña <span class="text-danger">*</span></label>
                                                                        <input type="password" name="password" class="form-control" minlength="8" required>
                                                                        <div class="form-text">Mínimo 8 caracteres</div>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label>Confirmar Contraseña <span class="text-danger">*</span></label>
                                                                        <input type="password" name="password_confirmation" class="form-control" required>
                                                                    </div>
                                                                    <div class="text-right mt-3">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                                        <button type="submit" class="btn btn-success">Actualizar Contraseña</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-muted text-center">No hay usuarios registrados</td>
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

    <!-- Modal Crear Usuario -->
    <div class="modal fade" id="crearUsuarioModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header modal-header-custom">
                    <h5 class="modal-title">👨‍💻 Crear Nuevo Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('usuarios.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Nombre de Usuario <span class="text-danger">*</span></label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Contraseña <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" minlength="8" required>
                                <div class="form-text">Mínimo 8 caracteres</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Confirmar Contraseña <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Rol <span class="text-danger">*</span></label>
                                <select name="id_rol" class="form-control" required>
                                    <option value="">-- Selecciona un rol --</option>
                                    @foreach($roles as $rol)
                                        <option value="{{ $rol->id_rol }}">{{ $rol->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- ❌ CORREO ELIMINADO -->
                        <div class="text-right mt-3">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success">Crear Usuario</button>
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