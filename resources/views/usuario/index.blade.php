<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Usuarios</title>

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

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">¿Seguro de cerrar sesión?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Seleccione "si" a continuación si está listo para finalizar su sesión actual.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">No</button>
                    <a class="btn btn-primary" href="{{ route('login') }}">Si</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete User Modal -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteUserModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Está seguro de que desea eliminar este usuario?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancelar</button>
                    <form id="deleteUserForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="changePasswordModalLabel">Cambiar Contraseña</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="changePasswordForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="change_password" value="true">

                        <div class="mb-3">
                            <label class="form-label-custom">Nueva Contraseña</label>
                            <div class="input-group">
                                <input type="password" name="password" id="newPassword" class="form-control" required
                                    minlength="8">
                                <button type="button" class="btn btn-outline-secondary"
                                    onclick="togglePassword('newPassword')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="form-text">Mínimo 8 caracteres</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label-custom">Confirmar Contraseña</label>
                            <div class="input-group">
                                <input type="password" name="password_confirmation" id="confirmPassword"
                                    class="form-control" required>
                                <button type="button" class="btn btn-outline-secondary"
                                    onclick="togglePassword('confirmPassword')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="changePasswordForm" class="btn btn-success">Actualizar
                        Contraseña</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Create User Modal -->
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-header-custom">
                    <h5 class="modal-title" id="createUserModalLabel">
                        <i class="fas fa-user-plus me-2"></i>Crear Nuevo Usuario
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('usuarios.store') }}" method="POST" id="createUserForm">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label-custom">Nombre de Usuario</label>
                                <input type="text" name="username" class="form-control"
                                    value="{{ old('username') }}" required>
                                @error('username')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label-custom">Correo Electrónico</label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label-custom">Contraseña</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="createPassword" class="form-control"
                                        required minlength="8">
                                    <button type="button" class="btn btn-outline-secondary"
                                        onclick="togglePassword('createPassword')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="form-text">Mínimo 8 caracteres</div>
                                @error('password')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label-custom">Confirmar Contraseña</label>
                                <div class="input-group">
                                    <input type="password" name="password_confirmation" id="createPasswordConfirm"
                                        class="form-control" required>
                                    <button type="button" class="btn btn-outline-secondary"
                                        onclick="togglePassword('createPasswordConfirm')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label-custom">Rol</label>
                                <select name="id_rol" class="form-control" required>
                                    <option value="">-- Seleccionar Rol --</option>
                                    @foreach ($roles as $rol)
                                        <option value="{{ $rol->id_rol }}"
                                            {{ old('id_rol') == $rol->id_rol ? 'selected' : '' }}>
                                            {{ $rol->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_rol')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label-custom">Estado</label>
                                <select name="activo" class="form-control" required>
                                    <option value="1" {{ old('activo', '1') == '1' ? 'selected' : '' }}>Activo
                                    </option>
                                    <option value="0" {{ old('activo') == '0' ? 'selected' : '' }}>Inactivo
                                    </option>
                                </select>
                                @error('activo')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="createUserForm" class="btn btn-success">Crear Usuario</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-header-custom">
                    <h5 class="modal-title" id="editUserModalLabel">
                        <i class="fas fa-edit me-2"></i>Editar Usuario
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label-custom">Nombre de Usuario</label>
                                <input type="text" name="username" id="editUsername" class="form-control"
                                    required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label-custom">Correo Electrónico</label>
                                <input type="email" name="email" id="editEmail" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label-custom">Rol</label>
                                <select name="id_rol" id="editRol" class="form-control" required>
                                    <option value="">-- Seleccionar Rol --</option>
                                    @foreach ($roles as $rol)
                                        <option value="{{ $rol->id_rol }}">{{ $rol->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label-custom">Estado</label>
                                <select name="activo" id="editActivo" class="form-control" required>
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="editUserForm" class="btn btn-success">Actualizar Usuario</button>
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

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse ml-4" id="navbarNav">
            <ul class="navbar-nav" style="padding-left: 20%;">
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1" href="{{ route('admin') }}">Inicio</a>
                </li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1"
                        href="{{ route('periodos.index') }}">Períodos Escolares</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1"
                        href="{{ route('carreras.index') }}">Carreras</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1"
                        href="{{ route('materias.index') }}">Materias</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1"
                        href="{{ route('planes.index') }}">Planes de estudio</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1"
                        href="{{ route('alumnos.index') }}">Alumnos</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1"
                        href="{{ route('asignaciones.index') }}">Asignaciones Docentes</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1"
                        href="{{ route('historial.index') }}">Historial</a></li>
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
        </div>
    </nav>

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Main Content -->
                <div class="container-fluid py-4">
                    <!-- Page Heading -->
                    <h1 class="text-danger text-center mb-5"
                        style="font-size: 2.5rem; font-family: 'Arial Black', Verdana, sans-serif; font-weight: bold;">
                        Gestión de Usuarios</h1>

                    <div class="row justify-content-center">
                        
                        <div class="col-lg-10">
                            <div class="mb-3 text-right">
                                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#createUserModal">
                                    <i class="fas fa-plus me-1"></i> Nuevo Usuario
                                </button>
                            </div>
                            <div class="container mb-4 d-flex justify-content-center">
                                <div class="p-3 border rounded bg-light d-inline-block shadow-sm">
                                    <form id="filtrosForm" method="GET" action="{{ route('usuarios.index') }}"
                                        class="d-flex flex-wrap gap-2 align-items-center">

                                        <!-- Mostrar -->
                                        <select name="mostrar" onchange="this.form.submit()"
                                            class="form-control form-control-sm w-auto">
                                            <option value="10" {{ request('mostrar') == 10 ? 'selected' : '' }}>10
                                            </option>
                                            <option value="25" {{ request('mostrar') == 25 ? 'selected' : '' }}>25
                                            </option>
                                            <option value="50" {{ request('mostrar') == 50 ? 'selected' : '' }}>50
                                            </option>
                                            <option value="todo"
                                                {{ request('mostrar') == 'todo' ? 'selected' : '' }}>Todo</option>
                                        </select>

                                        <!-- Botón Mostrar todo -->
                                        <a href="{{ route('usuarios.index', ['mostrar' => 'todo']) }}"
                                            class="btn btn-sm btn-outline-secondary d-flex align-items-center">
                                            <i class="fas fa-list me-1"></i> Mostrar todo
                                        </a>
                                    </form>
                                </div>
                            </div>

                            <!-- Alerts -->
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <!-- Table Card -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                    <input type="text" id="searchInput" class="form-control form-control-sm"
                                        placeholder="Buscar usuarios...">
                                </div>
                                
                                <div class="card-body1">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover" id="usersTable">
                                            <thead class="thead-dark text-center">
                                                <tr>
                                                    <th>Usuario</th>
                                                    <th>Email</th>
                                                    <th>Rol</th>
                                                    <th>Fecha Registro</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($usuarios as $usuario)
                                                    <tr>
                                                        <td>
                                                            <strong>{{ $usuario->username }}</strong>
                                                        </td>
                                                        <td>{{ $usuario->email }}</td>
                                                        <td>{{ $usuario->rol->nombre ?? 'Sin rol' }}</td>
                                                        <td>{{ $usuario->created_at ? $usuario->created_at->format('d/m/Y') : 'N/A' }}
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="btn-group" role="group">
                                                                <button type="button" class="btn btn-info btn-sm"
                                                                    title="Ver detalles"
                                                                    onclick="viewUser({{ $usuario }})">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-warning btn-sm"
                                                                    title="Editar"
                                                                    onclick="editUser({{ $usuario }})">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
                                                                <button type="button"
                                                                    class="btn btn-secondary btn-sm"
                                                                    title="Cambiar contraseña"
                                                                    onclick="changePassword({{ $usuario->id_usuario }})">
                                                                    <i class="fas fa-key"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                    title="Eliminar"
                                                                    onclick="confirmDelete({{ $usuario->id_usuario }})">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center">
                                                            <div class="alert alert-info mb-0">
                                                                <i class="fas fa-info-circle me-2"></i>No hay usuarios
                                                                registrados
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <footer class="sticky-footer bg-white mt-auto py-3">
                        <div class="container my-auto">
                            <div class="copyright text-center my-auto">
                                <span>Copyright &copy; Sistema Control Escolar 2025</span>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>

            <!-- Bootstrap JavaScript -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    console.log('Sistema de usuarios cargado');

                    // ===== BÚSQUEDA EN TABLA =====
                    const searchInput = document.getElementById('searchInput');
                    if (searchInput) {
                        searchInput.addEventListener('input', function(e) {
                            const searchTerm = e.target.value.toLowerCase();
                            const table = document.getElementById('usersTable');
                            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

                            for (let row of rows) {
                                const text = row.textContent.toLowerCase();
                                if (text.includes(searchTerm)) {
                                    row.style.display = '';
                                } else {
                                    row.style.display = 'none';
                                }
                            }
                        });
                    }

                    // ===== ORDENAMIENTO DE TABLA =====
                    function sortTable(columnIndex) {
                        const table = document.getElementById('usersTable');
                        const tbody = table.querySelector('tbody');
                        const rows = Array.from(tbody.querySelectorAll('tr'));
                        const header = table.querySelectorAll('thead th')[columnIndex];

                        const isAscending = !header.classList.contains('sort-asc');

                        table.querySelectorAll('thead th').forEach(th => {
                            th.classList.remove('sort-asc', 'sort-desc');
                        });

                        header.classList.add(isAscending ? 'sort-asc' : 'sort-desc');

                        rows.sort((a, b) => {
                            const aText = a.cells[columnIndex].textContent.trim();
                            const bText = b.cells[columnIndex].textContent.trim();

                            if (isAscending) {
                                return aText.localeCompare(bText);
                            } else {
                                return bText.localeCompare(aText);
                            }
                        });

                        rows.forEach(row => tbody.appendChild(row));
                    }

                    const tableHeaders = document.querySelectorAll('#usersTable thead th');
                    tableHeaders.forEach((header, index) => {
                        if (index < 6) { // No ordenar la columna de acciones
                            header.style.cursor = 'pointer';
                            header.addEventListener('click', () => sortTable(index));
                        }
                    });

                    // ===== ELIMINAR USUARIO =====
                    window.confirmDelete = function(userId) {
                        document.getElementById('deleteUserForm').action = `/usuarios/${userId}`;
                        const deleteModal = new bootstrap.Modal(document.getElementById('deleteUserModal'));
                        deleteModal.show();
                    }

                    // ===== CAMBIAR CONTRASEÑA =====
                    window.changePassword = function(userId) {
                        document.getElementById('changePasswordForm').action = `/usuarios/${userId}`;
                        const passwordModal = new bootstrap.Modal(document.getElementById('changePasswordModal'));
                        passwordModal.show();
                    }

                    // ===== EDITAR USUARIO =====
                    window.editUser = function(usuario) {
                        document.getElementById('editUserForm').action = `/usuarios/${usuario.id_usuario}`;
                        document.getElementById('editUsername').value = usuario.username;
                        document.getElementById('editEmail').value = usuario.email;
                        document.getElementById('editRol').value = usuario.id_rol;
                        document.getElementById('editActivo').value = usuario.activo;

                        const editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
                        editModal.show();
                    }

                    // ===== VER USUARIO =====
                    window.viewUser = function(usuario) {
                        // Aquí podrías abrir un modal de visualización o redirigir a una página de detalles
                        alert(
                            `Detalles del usuario:\n\nID: ${usuario.id_usuario}\nUsuario: ${usuario.username}\nEmail: ${usuario.email}\nRol: ${usuario.rol?.nombre || 'Sin rol'}\nEstado: ${usuario.activo ? 'Activo' : 'Inactivo'}\nRegistro: ${new Date(usuario.created_at).toLocaleDateString()}`);
                    }

                    // ===== MOSTRAR/OCULTAR CONTRASEÑA =====
                    window.togglePassword = function(fieldId) {
                        const field = document.getElementById(fieldId);
                        const icon = field.parentNode.querySelector('i');

                        if (field.type === 'password') {
                            field.type = 'text';
                            icon.classList.remove('fa-eye');
                            icon.classList.add('fa-eye-slash');
                        } else {
                            field.type = 'password';
                            icon.classList.remove('fa-eye-slash');
                            icon.classList.add('fa-eye');
                        }
                    }

                    // ===== VALIDACIÓN DE CONTRASEÑA =====
                    const passwordFields = document.querySelectorAll('input[type="password"]');
                    passwordFields.forEach(field => {
                        field.addEventListener('input', function() {
                            if (this.name === 'password_confirmation' || this.id ===
                                'createPasswordConfirm' || this.id === 'confirmPassword') {
                                const passwordField = this.form.querySelector('input[name="password"]') ||
                                    document.getElementById('createPassword') ||
                                    document.getElementById('newPassword');

                                if (this.value !== passwordField.value && this.value !== '') {
                                    this.classList.add('is-invalid');
                                    this.classList.remove('is-valid');
                                } else if (this.value === passwordField.value && this.value !== '') {
                                    this.classList.remove('is-invalid');
                                    this.classList.add('is-valid');
                                } else {
                                    this.classList.remove('is-invalid', 'is-valid');
                                }
                            }

                            // Validar longitud mínima
                            if ((this.name === 'password' || this.id === 'createPassword' || this.id ===
                                    'newPassword') &&
                                this.value.length > 0 && this.value.length < 8) {
                                this.classList.add('is-invalid');
                                this.classList.remove('is-valid');
                            } else if ((this.name === 'password' || this.id === 'createPassword' || this
                                    .id === 'newPassword') &&
                                this.value.length >= 8) {
                                this.classList.remove('is-invalid');
                                this.classList.add('is-valid');
                            }
                        });
                    });

                    // ===== AUTO-OCULTAR ALERTAS =====
                    setTimeout(function() {
                        const alerts = document.querySelectorAll('.alert');
                        alerts.forEach(function(alert) {
                            if (alert.classList.contains('show')) {
                                alert.style.transition = 'opacity 0.5s';
                                alert.style.opacity = '0';
                                setTimeout(function() {
                                    alert.style.display = 'none';
                                }, 500);
                            }
                        });
                    }, 5000);

                    // ===== LIMPIAR FORMULARIOS AL CERRAR MODALES =====
                    const modals = ['createUserModal', 'editUserModal', 'changePasswordModal'];
                    modals.forEach(modalId => {
                        const modal = document.getElementById(modalId);
                        if (modal) {
                            modal.addEventListener('hidden.bs.modal', function() {
                                const form = this.querySelector('form');
                                if (form) {
                                    form.reset();
                                    // Limpiar clases de validación
                                    const inputs = form.querySelectorAll('input');
                                    inputs.forEach(input => {
                                        input.classList.remove('is-valid', 'is-invalid');
                                    });
                                }
                            });
                        }
                    });
                });
            </script>

</body>

</html>
