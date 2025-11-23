<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Administración de Carreras</title>
    <link href="{{ asset('libs/fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('libs/sbadmin/img/up_logo.png') }}">
    <link href="{{ asset('libs/sbadmin/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <style>
        .required-asterisk { color: #dc3545; }
        .card-header-custom,
        .modal-header-custom { background: linear-gradient(135deg, #c00 0%, #800 100%); }
        .modal-footer-custom { background-color: #f8f9fa; }
        .form-control-custom { border-radius: 0.375rem; }
        .form-label-custom { font-weight: 600; margin-bottom: 0.3rem; }
    </style>
</head>
<body id="page-top">

    <!-- Top Header -->
    <div class="bg-danger text-white text-center py-2">
        <h4 class="mb-0">SISTEMA DE CONTROL ESCOLAR</h4>
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger">
        <!-- ... tu menú aquí ... -->
        <div class="collapse navbar-collapse ml-4">
            <ul class="navbar-nav" style="padding-left: 20%;">
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1" href="{{ route('admin') }}">Inicio</a></li>
                <!-- Otros items -->
                <li class="nav-item">
                    <a class="nav-link navbar-active-item px-3 mr-1">Administración de Carreras</a>
                </li>
                <!-- ... -->
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

    <!-- Main Content -->
    <div id="wrapper">
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid py-5">
                    <h1 class="text-danger text-center mb-5" style="font-size: 2.5rem; font-family: 'Arial Black', Verdana, sans-serif; font-weight: bold;">
                        Administración de Carreras
                    </h1>
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="mb-3 text-right">
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#nuevaAdminModal">
                                    <i class="fas fa-plus"></i> Nueva Administración
                                </button>
                            </div>

                            <!-- Filtros -->
                            <div class="container-fluid mb-4 d-flex justify-content-center">
                                <div class="p-3 border rounded bg-light shadow-sm d-inline-block">
                                    <form id="filtrosForm" method="GET" action="{{ route('administracion-carreras.index') }}" class="d-flex flex-nowrap align-items-center gap-2">
                                        <select name="id_area" class="form-control form-control-sm py-1 px-2">
                                            <option value="">Área</option>
                                            @foreach ($areas as $area)
                                                <option value="{{ $area->id_area }}" {{ request('id_area') == $area->id_area ? 'selected' : '' }}>
                                                    {{ $area->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <select name="id_carrera" class="form-control form-control-sm py-1 px-2">
                                            <option value="">Carrera</option>
                                            @foreach ($carreras as $carrera)
                                                <option value="{{ $carrera->id_carrera }}" {{ request('id_carrera') == $carrera->id_carrera ? 'selected' : '' }}>
                                                    {{ $carrera->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <select name="id_usuario" class="form-control form-control-sm py-1 px-2">
                                            <option value="">Usuario</option>
                                            @foreach ($usuarios as $usuario)
                                                <option value="{{ $usuario->id_usuario }}" {{ request('id_usuario') == $usuario->id_usuario ? 'selected' : '' }}>
                                                    {{ $usuario->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <select name="mostrar" onchange="this.form.submit()" class="form-control form-control-sm w-auto">
                                            <option value="10" {{ request('mostrar') == 10 ? 'selected' : '' }}>10</option>
                                            <option value="25" {{ request('mostrar') == 25 ? 'selected' : '' }}>25</option>
                                            <option value="50" {{ request('mostrar') == 50 ? 'selected' : '' }}>50</option>
                                            <option value="todo" {{ request('mostrar') == 'todo' ? 'selected' : '' }}>Todo</option>
                                        </select>
                                    </form>
                                </div>
                            </div>

                            <!-- Mensajes -->
                            <div class="card-body1">
                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                <!-- Tabla -->
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover text-center">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Área</th>
                                                <th>Usuario</th>
                                                <th>Carrera</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($administraciones as $admin)
                                                <tr>
                                                    <td>{{ $admin->area->nombre ?? 'N/A' }}</td>
                                                    <td>{{ $admin->usuario->name ?? 'N/A' }}</td>
                                                    <td>{{ $admin->carrera->nombre ?? 'N/A' }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editarModal{{ $admin->id_administracion_carrera }}">
                                                            <i class="fas fa-edit"></i> Editar
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#eliminarModal{{ $admin->id_administracion_carrera }}">
                                                            <i class="fas fa-trash-alt"></i> Eliminar
                                                        </button>

                                                        <!-- Modal Editar -->
                                                        <div class="modal fade" id="editarModal{{ $admin->id_administracion_carrera }}" tabindex="-1" role="dialog">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content border-0 shadow-lg">
                                                                    <div class="modal-header modal-header-custom border-0">
                                                                        <div class="w-100 text-center">
                                                                            <h5 class="m-0 font-weight-bold">✏️ Editar Administración</h5>
                                                                            <p class="m-0 mt-2 mb-0" style="font-size: 0.9rem; opacity: 0.95;">
                                                                                Modifique la administración seleccionada
                                                                            </p>
                                                                        </div>
                                                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar"
                                                                            style="position: absolute; right: 1.5rem; top: 1.5rem; font-size: 1.8rem; opacity: 0.9;">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <form action="{{ route('administracion-carreras.update', $admin->id_administracion_carrera) }}" method="POST">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <input type="hidden" name="admin_id" value="{{ $admin->id_administracion_carrera }}">
                                                                        <div class="modal-body modal-body-custom p-4">
                                                                            <div class="form-container p-4 bg-white rounded shadow-sm border">
                                                                                <div class="card shadow mb-3 border-0">
                                                                                    <div class="card-header py-3 text-white card-header-custom">
                                                                                        <h6 class="m-0 font-weight-bold">
                                                                                            <i class="fas fa-cogs"></i> Datos de Administración
                                                                                        </h6>
                                                                                    </div>
                                                                                    <div class="card-body1 p-4">
                                                                                        <div class="row">
                                                                                            <div class="col-md-4">
                                                                                                <div class="form-group">
                                                                                                    <label class="form-label-custom d-flex">Área <span class="required-asterisk ml-1">*</span></label>
                                                                                                    <select name="id_area" class="form-control form-control-custom @error('id_area'){{ old('admin_id') == $admin->id_administracion_carrera ? ' is-invalid' : '' }}@enderror" required>
                                                                                                        <option value="">-- Seleccione --</option>
                                                                                                        @foreach ($areas as $area)
                                                                                                            <option value="{{ $area->id_area }}" {{ old('id_area', $admin->id_area) == $area->id_area ? 'selected' : '' }}>
                                                                                                                {{ $area->nombre }}
                                                                                                            </option>
                                                                                                        @endforeach
                                                                                                    </select>
                                                                                                    @error('id_area')
                                                                                                        @if(old('admin_id') == $admin->id_administracion_carrera)
                                                                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                                        @endif
                                                                                                    @enderror
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-4">
                                                                                                <div class="form-group">
                                                                                                    <label class="form-label-custom d-flex">Usuario <span class="required-asterisk ml-1">*</span></label>
                                                                                                    <select name="id_usuario" class="form-control form-control-custom @error('id_usuario'){{ old('admin_id') == $admin->id_administracion_carrera ? ' is-invalid' : '' }}@enderror" required>
                                                                                                        <option value="">-- Seleccione --</option>
                                                                                                        @foreach ($usuarios as $usuario)
                                                                                                            <option value="{{ $usuario->id_usuario }}" {{ old('id_usuario', $admin->id_usuario) == $usuario->id_usuario ? 'selected' : '' }}>
                                                                                                                {{ $usuario->name }}
                                                                                                            </option>
                                                                                                        @endforeach
                                                                                                    </select>
                                                                                                    @error('id_usuario')
                                                                                                        @if(old('admin_id') == $admin->id_administracion_carrera)
                                                                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                                        @endif
                                                                                                    @enderror
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-4">
                                                                                                <div class="form-group">
                                                                                                    <label class="form-label-custom d-flex">Carrera <span class="required-asterisk ml-1">*</span></label>
                                                                                                    <select name="id_carrera" class="form-control form-control-custom @error('id_carrera'){{ old('admin_id') == $admin->id_administracion_carrera ? ' is-invalid' : '' }}@enderror" required>
                                                                                                        <option value="">-- Seleccione --</option>
                                                                                                        @foreach ($carreras as $carrera)
                                                                                                            <option value="{{ $carrera->id_carrera }}" {{ old('id_carrera', $admin->id_carrera) == $carrera->id_carrera ? 'selected' : '' }}>
                                                                                                                {{ $carrera->nombre }}
                                                                                                            </option>
                                                                                                        @endforeach
                                                                                                    </select>
                                                                                                    @error('id_carrera')
                                                                                                        @if(old('admin_id') == $admin->id_administracion_carrera)
                                                                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                                        @endif
                                                                                                    @enderror
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer modal-footer-custom border-top">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                                                <i class="fas fa-times mr-2"></i> Cancelar
                                                                            </button>
                                                                            <button type="submit" class="btn btn-success">
                                                                                <i class="fas fa-save mr-2"></i> Actualizar
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Modal Eliminar -->
                                                        <div class="modal fade" id="eliminarModal{{ $admin->id_administracion_carrera }}" tabindex="-1" role="dialog">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header modal-header-custom border-0">
                                                                        <div class="w-100 text-center">
                                                                            <h5 class="m-0 font-weight-bold">🗑️ Eliminar Administración</h5>
                                                                        </div>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body text-center">
                                                                        ¿Seguro que deseas eliminar la administración de
                                                                        <strong>{{ $admin->carrera->nombre }}</strong>?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                                        <form action="{{ route('administracion-carreras.destroy', $admin->id_administracion_carrera) }}" method="POST" style="display:inline;">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted">No hay administraciones registradas</td>
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
        </div>
    </div>

    <!-- Modal Crear -->
    <div class="modal fade" id="nuevaAdminModal" tabindex="-1" role="dialog" aria-labelledby="nuevaAdminLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header modal-header-custom border-0">
                    <div class="w-100 text-center">
                        <h5 class="m-0 font-weight-bold" id="nuevaAdminLabel">
                            📓 Nueva Administración de Carrera
                        </h5>
                        <p class="m-0 mt-2 mb-0" style="font-size: 0.9rem; opacity: 0.95;">
                            Registre la nueva administración
                        </p>
                    </div>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar"
                        style="position: absolute; right: 1.5rem; top: 1.5rem; font-size: 1.8rem; opacity: 0.9;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('administracion-carreras.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="is_create_admin" value="1">
                    <div class="modal-body modal-body-custom p-4">
                        <div class="form-container p-4 bg-white rounded shadow-sm border">
                            <div class="card shadow mb-3 border-0">
                                <div class="card-header py-3 text-white card-header-custom">
                                    <h6 class="m-0 font-weight-bold">
                                        <i class="fas fa-cogs"></i> Datos de Administración
                                    </h6>
                                </div>
                                <div class="card-body1 p-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label-custom d-flex">Área <span class="required-asterisk ml-1">*</span></label>
                                                <select name="id_area" class="form-control form-control-custom @error('id_area') @if(old('is_create_admin')) is-invalid @endif @enderror" required>
                                                    <option value="">-- Seleccione --</option>
                                                    @foreach ($areas as $area)
                                                        <option value="{{ $area->id_area }}" {{ old('id_area') == $area->id_area ? 'selected' : '' }}>
                                                            {{ $area->nombre }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('id_area')
                                                    @if(old('is_create_admin'))
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @endif
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label-custom d-flex">Usuario <span class="required-asterisk ml-1">*</span></label>
                                                <select name="id_usuario" class="form-control form-control-custom @error('id_usuario') @if(old('is_create_admin')) is-invalid @endif @enderror" required>
                                                    <option value="">-- Seleccione --</option>
                                                    @foreach ($usuarios as $usuario)
                                                        <option value="{{ $usuario->id_usuario }}" {{ old('id_usuario') == $usuario->id_usuario ? 'selected' : '' }}>
                                                            {{ $usuario->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('id_usuario')
                                                    @if(old('is_create_admin'))
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @endif
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label-custom d-flex">Carrera <span class="required-asterisk ml-1">*</span></label>
                                                <select name="id_carrera" class="form-control form-control-custom @error('id_carrera') @if(old('is_create_admin')) is-invalid @endif @enderror" required>
                                                    <option value="">-- Seleccione --</option>
                                                    @foreach ($carreras as $carrera)
                                                        <option value="{{ $carrera->id_carrera }}" {{ old('id_carrera') == $carrera->id_carrera ? 'selected' : '' }}>
                                                            {{ $carrera->nombre }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('id_carrera')
                                                    @if(old('is_create_admin'))
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @endif
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer modal-footer-custom border-top">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times mr-2"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save mr-2"></i> Guardar Administración
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts para reabrir modales -->
    <script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('libs/sbadmin/js/sb-admin-2.min.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if ($errors->any() && old('is_create_admin'))
                $('#nuevaAdminModal').modal('show');
            @endif
            @if ($errors->any() && old('admin_id'))
                $('#editarModal{{ old("admin_id") }}').modal('show');
            @endif
        });
    </script>
</body>
</html>