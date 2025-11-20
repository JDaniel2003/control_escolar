<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Docentes</title>

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

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Está seguro de que desea eliminar este docente?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancelar</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Crear Docente -->
    <div class="modal fade" id="addTeacherModal" tabindex="-1" aria-labelledby="addTeacherModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header modal-header-custom border-0 py-3">
                    <div class="w-100 text-center position-relative">
                        <h5 class="m-0 font-weight-bold">
                            👨‍🏫 Registrar Nuevo Docente
                        </h5>
                        <p class="m-0 mt-2 mb-0" style="font-size: 0.9rem; opacity: 0.95;">
                            Complete la información para registrar un nuevo docente en el sistema
                        </p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body p-3" style="background-color: #f8f9fa;">
                    <div class="form-container p-4 bg-white rounded shadow-sm border">
                        <form action="{{ route('docentes.store') }}" method="POST" id="createTeacherForm">
                            @csrf

                            <div class="accordion" id="createAccordion">

                                <!-- Datos Personales -->
                                <div class="card mb-2 border-0 shadow-sm">
                                    <div class="card-header p-0" id="headingCreateDatos">
                                        <button
                                            class="btn text-danger font-weight-bold btn-block text-left py-2 px-3 text-decoration-none"
                                            type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseCreateDatos" aria-expanded="true"
                                            aria-controls="collapseCreateDatos">
                                            <i class="fas fa-user mr-2"></i>Datos Personales
                                            <i class="fas fa-chevron-down float-end mt-1"></i>
                                        </button>
                                    </div>
                                    <div id="collapseCreateDatos" class="collapse show"
                                        aria-labelledby="headingCreateDatos" data-bs-parent="#createAccordion">
                                        <div class="card-body p-3">
                                            <div class="row">
                                                <div class="col-md-4 mb-2">
                                                    <label class="form-label-custom small mb-1">
                                                        Nombre <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" name="datos_docentes[nombre]"
                                                        class="form-control form-control-sm"
                                                        value="{{ old('datos_docentes.nombre') }}"
                                                        placeholder="Nombre" required>
                                                    @error('datos_docentes.nombre')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <label class="form-label-custom small mb-1">
                                                        Apellido Paterno <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" name="datos_docentes[apellido_paterno]"
                                                        class="form-control form-control-sm"
                                                        value="{{ old('datos_docentes.apellido_paterno') }}"
                                                        placeholder="Apellido paterno" required>
                                                    @error('datos_docentes.apellido_paterno')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <label class="form-label-custom small mb-1">Apellido
                                                        Materno</label>
                                                    <input type="text" name="datos_docentes[apellido_materno]"
                                                        class="form-control form-control-sm"
                                                        value="{{ old('datos_docentes.apellido_materno') }}"
                                                        placeholder="Apellido materno">
                                                    @error('datos_docentes.apellido_materno')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3 mb-2">
                                                    <label class="form-label-custom small mb-1">Cédula
                                                        Profesional</label>
                                                    <input type="text" name="datos_docentes[cedula_profesional]"
                                                        maxlength="7" class="form-control form-control-sm"
                                                        value="{{ old('datos_docentes.cedula_profesional') }}"
                                                        placeholder="7 caracteres">
                                                    @error('datos_docentes.cedula_profesional')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label class="form-label-custom small mb-1">RFC</label>
                                                    <input type="text" name="datos_docentes[rfc]" maxlength="13"
                                                        class="form-control form-control-sm"
                                                        value="{{ old('datos_docentes.rfc') }}"
                                                        placeholder="13 caracteres">
                                                    @error('datos_docentes.rfc')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label class="form-label-custom small mb-1">CURP</label>
                                                    <input type="text" name="datos_docentes[curp]" maxlength="18"
                                                        class="form-control form-control-sm"
                                                        value="{{ old('datos_docentes.curp') }}"
                                                        placeholder="18 caracteres">
                                                    @error('datos_docentes.curp')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label class="form-label-custom small mb-1">Especialidad <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="especialidad"
                                                        class="form-control form-control-sm"
                                                        value="{{ old('especialidad') }}"
                                                        placeholder="Especialidad del docente" required>
                                                    @error('especialidad')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3 mb-2">
                                                    <label class="form-label-custom small mb-1">Fecha de
                                                        Nacimiento</label>
                                                    <input type="date" name="datos_docentes[fecha_nacimiento]"
                                                        id="fecha_nacimiento_create"
                                                        class="form-control form-control-sm"
                                                        value="{{ old('datos_docentes.fecha_nacimiento') }}">
                                                    @error('datos_docentes.fecha_nacimiento')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <label class="form-label-custom small mb-1">Edad</label>
                                                    <input type="number" name="datos_docentes[edad]"
                                                        id="edad_create" min="18" max="100"
                                                        class="form-control form-control-sm"
                                                        value="{{ old('datos_docentes.edad') }}" placeholder="Años"
                                                        readonly>
                                                    @error('datos_docentes.edad')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label class="form-label-custom small mb-1">Género <span
                                                            class="text-danger">*</span></label>
                                                    <select name="datos_docentes[id_genero]"
                                                        class="form-control form-control-sm" required>
                                                        <option value="">-- Selecciona --</option>
                                                        @foreach ($generos as $genero)
                                                            <option value="{{ $genero->id_genero }}"
                                                                {{ old('datos_docentes.id_genero') == $genero->id_genero ? 'selected' : '' }}>
                                                                {{ $genero->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('datos_docentes.id_genero')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label
                                                        class="form-label-custom small mb-1">Título/Abreviatura</label>
                                                    <select name="datos_docentes[id_abreviatura]"
                                                        class="form-control form-control-sm">
                                                        <option value="">-- Sin título --</option>
                                                        @foreach ($abreviaturas as $abreviatura)
                                                            <option value="{{ $abreviatura->id_abreviatura }}"
                                                                {{ old('datos_docentes.id_abreviatura') == $abreviatura->id_abreviatura ? 'selected' : '' }}>
                                                                {{ $abreviatura->abreviatura }} -
                                                                {{ $abreviatura->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <small class="text-muted">Ej: Dr., Mtro., Ing.</small>
                                                    @error('datos_docentes.id_abreviatura')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <label class="form-label-custom small mb-1">N° Seguridad
                                                        Social</label>
                                                    <input type="text"
                                                        name="datos_docentes[numero_seguridad_social]" maxlength="11"
                                                        class="form-control form-control-sm"
                                                        value="{{ old('datos_docentes.numero_seguridad_social') }}"
                                                        placeholder="11 dígitos">
                                                    @error('datos_docentes.numero_seguridad_social')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-5 mb-2">
                                                    <label class="form-label-custom small mb-1">Correo Electrónico
                                                        <span class="text-danger">*</span></label>
                                                    <input type="email" name="datos_docentes[correo]"
                                                        class="form-control form-control-sm"
                                                        value="{{ old('datos_docentes.correo') }}"
                                                        placeholder="ejemplo@correo.com" required>
                                                    @error('datos_docentes.correo')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <label class="form-label-custom small mb-1">Teléfono <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="datos_docentes[telefono]"
                                                        maxlength="10" class="form-control form-control-sm"
                                                        value="{{ old('datos_docentes.telefono') }}"
                                                        placeholder="10 dígitos" required>
                                                    @error('datos_docentes.telefono')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Domicilio Docente -->
                                <div class="card mb-2 border-0 shadow-sm">
                                    <div class="card-header p-0" id="headingCreateDomicilio">
                                        <button
                                            class="btn text-danger font-weight-bold btn-block text-left py-2 px-3 text-decoration-none collapsed"
                                            type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseCreateDomicilio" aria-expanded="false"
                                            aria-controls="collapseCreateDomicilio">
                                            <i class="fas fa-home mr-2"></i>Domicilio del Docente
                                            <i class="fas fa-chevron-down float-end mt-1"></i>
                                        </button>
                                    </div>
                                    <div id="collapseCreateDomicilio" class="collapse"
                                        aria-labelledby="headingCreateDomicilio" data-bs-parent="#createAccordion">
                                        <div class="card-body p-3">
                                            <div class="row">
                                                <div class="col-md-4 mb-2">
                                                    <label class="form-label-custom small mb-1">
                                                        Calle <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" name="domicilio_docente[calle]"
                                                        class="form-control form-control-sm"
                                                        value="{{ old('domicilio_docente.calle') }}"
                                                        placeholder="Nombre de la calle" required>
                                                    @error('domicilio_docente.calle')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <label class="form-label-custom small mb-1">N° Ext.</label>
                                                    <input type="text" name="domicilio_docente[numero_exterior]"
                                                        maxlength="4" class="form-control form-control-sm"
                                                        value="{{ old('domicilio_docente.numero_exterior') }}"
                                                        placeholder="Núm.">
                                                    @error('domicilio_docente.numero_exterior')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <label class="form-label-custom small mb-1">N° Int.</label>
                                                    <input type="text" name="domicilio_docente[numero_interior]"
                                                        maxlength="4" class="form-control form-control-sm"
                                                        value="{{ old('domicilio_docente.numero_interior') }}"
                                                        placeholder="Int.">
                                                    @error('domicilio_docente.numero_interior')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <label class="form-label-custom small mb-1">
                                                        Colonia <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" name="domicilio_docente[colonia]"
                                                        class="form-control form-control-sm"
                                                        value="{{ old('domicilio_docente.colonia') }}"
                                                        placeholder="Nombre de la colonia" required>
                                                    @error('domicilio_docente.colonia')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 mb-2">
                                                    <label class="form-label-custom small mb-1">
                                                        Municipio <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" name="domicilio_docente[municipio]"
                                                        class="form-control form-control-sm"
                                                        value="{{ old('domicilio_docente.municipio') }}"
                                                        placeholder="Nombre del municipio" required>
                                                    @error('domicilio_docente.municipio')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label class="form-label-custom small mb-1">Distrito</label>
                                                    <select name="domicilio_docente[id_distrito]"
                                                        class="form-control form-control-sm">
                                                        <option value="">-- Selecciona --</option>
                                                        @foreach ($distritos as $distrito)
                                                            <option value="{{ $distrito->id_distrito }}"
                                                                {{ old('domicilio_docente.id_distrito') == $distrito->id_distrito ? 'selected' : '' }}>
                                                                {{ $distrito->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('domicilio_docente.id_distrito')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label class="form-label-custom small mb-1">Estado <span
                                                            class="text-danger">*</span></label>
                                                    <select name="domicilio_docente[id_estado]"
                                                        class="form-control form-control-sm" required>
                                                        <option value="">-- Selecciona --</option>
                                                        @foreach ($estados as $estado)
                                                            <option value="{{ $estado->id_estado }}"
                                                                {{ old('domicilio_docente.id_estado') == $estado->id_estado ? 'selected' : '' }}>
                                                                {{ $estado->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('domicilio_docente.id_estado')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <label class="form-label-custom small mb-1">C.P.</label>
                                                    <input type="text" name="domicilio_docente[codigo_postal]"
                                                        maxlength="5" class="form-control form-control-sm"
                                                        value="{{ old('domicilio_docente.codigo_postal') }}"
                                                        placeholder="00000">
                                                    @error('domicilio_docente.codigo_postal')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12 mb-2">
                                                    <label class="form-label-custom small mb-1">Datos Adicionales del
                                                        Domicilio (JSON)</label>
                                                    <textarea name="domicilio_docente[datos]" class="form-control form-control-sm" rows="1"
                                                        placeholder='{"referencias": "..."}'>{{ old('domicilio_docente.datos') }}</textarea>
                                                    @error('domicilio_docente.datos')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Información del Docente -->
                                <div class="card mb-2 border-0 shadow-sm">
                                    <div class="card-header p-0" id="headingCreateDocente">
                                        <button
                                            class="btn text-danger font-weight-bold btn-block text-left py-2 px-3 text-decoration-none collapsed"
                                            type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseCreateDocente" aria-expanded="false"
                                            aria-controls="collapseCreateDocente">
                                            <i class="fas fa-chalkboard-teacher mr-2"></i>Información del Docente
                                            <i class="fas fa-chevron-down float-end mt-1"></i>
                                        </button>
                                    </div>
                                    <div id="collapseCreateDocente" class="collapse"
                                        aria-labelledby="headingCreateDocente" data-bs-parent="#createAccordion">
                                        <div class="card-body p-3">
                                            <div class="row">
                                                <div class="col-md-6 mb-2">
                                                    <label class="form-label-custom small mb-1">Datos Adicionales
                                                        (JSON)</label>
                                                    <textarea name="datos" class="form-control form-control-sm" rows="3"
                                                        placeholder='{"experiencia": "años", "titulos": "..."}'>{{ old('datos') }}</textarea>
                                                    <small class="text-muted">Información adicional en formato
                                                        JSON</small>
                                                    @error('datos')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <label class="form-label-custom small mb-1">Usuario
                                                        Asociado</label>
                                                    <select name="id_usuario" class="form-control form-control-sm">
                                                        <option value="">-- Sin usuario asociado --</option>
                                                        @foreach ($usuarios as $usuario)
                                                            <option value="{{ $usuario->id_usuario }}"
                                                                {{ old('id_usuario') == $usuario->id_usuario ? 'selected' : '' }}>
                                                                {{ $usuario->email }}
                                                                ({{ $usuario->rol->nombre ?? 'Sin rol' }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <small class="text-muted">Opcional: asociar a una cuenta de usuario
                                                        existente</small>
                                                    @error('id_usuario')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                <h6 class="text-primary mb-2">
                                    <i class="fas fa-user-plus"></i> Crear Usuario para el Docente (Opcional)
                                </h6>

                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <label class="form-label-custom small mb-1">Nombre de Usuario</label>
                                        <input type="text" name="usuario[username]"
                                            class="form-control form-control-sm"
                                            value="{{ old('usuario.username') }}" placeholder="Ej: jlopez123">
                                        @error('usuario.username')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label class="form-label-custom small mb-1">Contraseña</label>
                                        <input type="password" name="usuario[password]"
                                            class="form-control form-control-sm" placeholder="Contraseña">
                                        @error('usuario.password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label class="form-label-custom small mb-1">Confirmar Contraseña</label>
                                        <input type="password" name="usuario[password_confirmation]"
                                            class="form-control form-control-sm" placeholder="Confirmar contraseña">
                                    </div>
                                </div>


                                <div class="col-md-4 mb-2">
                                    <label class="form-label-custom small mb-1">Rol del Usuario</label>
                                    <select name="usuario[id_rol]" class="form-control form-control-sm">
                                        <option value="">-- Selecciona un rol --</option>
                                        @foreach ($roles as $rol)
                                            <option value="{{ $rol->id_rol }}"
                                                {{ old('usuario.id_rol', 3) == $rol->id_rol ? 'selected' : '' }}>
                                                {{ $rol->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Por defecto: Docente</small>
                                    @error('usuario.id_rol')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="text-center mt-3 mb-2">
                                <small class="text-muted">
                                    <span class="text-danger">*</span> Campos obligatorios
                                </small>
                            </div>

                            <div class="text-end mt-3">
                                <button type="button" class="btn btn-outline-secondary btn-sm px-3"
                                    data-bs-dismiss="modal">
                                    <i class="fas fa-times me-1"></i>Cancelar
                                </button>
                                <button type="submit" class="btn btn-success btn-sm px-3">
                                    <i class="fas fa-save me-1"></i>Guardar Docente
                                </button>
                            </div>
                        </form>
                    </div>
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
                <li class="nav-item">
                    <a class="nav-link text-white px-3 me-1" href="{{ route('admin') }}">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white px-3 me-1" href="{{ route('periodos.index') }}">Períodos
                        Escolares</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white px-3 me-1" href="{{ route('carreras.index') }}">Carreras</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white px-3 me-1" href="{{ route('materias.index') }}">Materias</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white px-3 me-1" href="{{ route('planes.index') }}">Planes de estudio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white px-3 me-1" href="{{ route('alumnos.index') }}">Alumnos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white px-3 me-1" href="{{ route('asignaciones.index') }}">Asignaciones
                        Docentes</a>
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
                <a href="#" class="text-white text-decoration-none logout-link" data-toggle="modal"
                    data-target="#logoutModal">
                    Cerrar Sesión <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
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
                <div class="container-fluid py-5">
                    <h1 class="text-danger text-center mb-5"
                        style="font-size: 2.5rem; font-family: 'Arial Black', Verdana, sans-serif; font-weight: bold;">
                        Gestión de Docentes</h1>

                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <!-- Page Heading -->
                            <div class="mb-3 text-right">

                                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#addTeacherModal">
                                    <i class="fas fa-plus me-1"></i> Nuevo Docente
                                </button>
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
                                <div class="card-header py-3  d-flex justify-content-between align-items-center">
                                    <input type="text" id="searchInput" class="form-control form-control-sm"
                                        placeholder="Buscar docentes...">
                                </div>
                                <div class="card-body1">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover" id="teachersTable">
                                            <thead class="thead-dark text-center">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Nombre Completo</th>
                                                    <th>Cédula Profesional</th>
                                                    <th>RFC</th>
                                                    <th>Teléfono</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($docentes as $docente)
                                                    <tr>
                                                        <td>{{ $docente->id_docente }}</td>
                                                        <td>
                                                            <strong>
                                                                {{ $docente->datosDocentes->nombre ?? 'N/A' }}
                                                                {{ $docente->datosDocentes->apellido_paterno ?? '' }}
                                                                {{ $docente->datosDocentes->apellido_materno ?? '' }}
                                                            </strong>
                                                        </td>
                                                        <td>{{ $docente->datosDocentes->cedula_profesional ?? 'N/A' }}
                                                        </td>
                                                        <td>{{ $docente->datosDocentes->rfc ?? 'N/A' }}</td>
                                                        <td>{{ $docente->datosDocentes->telefono ?? 'N/A' }}</td>
                                                        <td class="text-center">
                                                            <div class="btn-group" role="group">
                                                                <a href="{{ route('docentes.show', $docente->id_docente) }}"
                                                                    class="btn btn-info btn-sm" title="Ver detalles">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                                <a href="{{ route('docentes.edit', $docente->id_docente) }}"
                                                                    class="btn btn-warning btn-sm" title="Editar">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                    title="Eliminar"
                                                                    onclick="confirmDelete('{{ route('docentes.destroy', $docente->id_docente) }}')">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center">
                                                            <div class="alert alert-info mb-0">
                                                                <i class="fas fa-info-circle me-2"></i>No hay docentes
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
            console.log('Sistema de docentes cargado');

            // ===== BÚSQUEDA EN TABLA =====
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('input', function(e) {
                    const searchTerm = e.target.value.toLowerCase();
                    const table = document.getElementById('teachersTable');
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
                const table = document.getElementById('teachersTable');
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

            const tableHeaders = document.querySelectorAll('#teachersTable thead th');
            tableHeaders.forEach((header, index) => {
                if (index < 5) { // No ordenar la columna de acciones
                    header.style.cursor = 'pointer';
                    header.addEventListener('click', () => sortTable(index));
                }
            });

            // ===== ELIMINAR DOCENTE =====
            window.confirmDelete = function(url) {
                document.getElementById('deleteForm').action = url;
                const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                deleteModal.show();
            }

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

            // ===== FUNCIONALIDAD PARA MODAL DE CREAR DOCENTE =====
            const fechaNacimientoInput = document.getElementById('fecha_nacimiento_create');
            const edadInput = document.getElementById('edad_create');

            if (fechaNacimientoInput && edadInput) {
                fechaNacimientoInput.addEventListener('change', function() {
                    const birthDate = new Date(this.value);
                    const today = new Date();
                    let age = today.getFullYear() - birthDate.getFullYear();
                    const monthDiff = today.getMonth() - birthDate.getMonth();

                    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                        age--;
                    }

                    edadInput.value = age >= 0 ? age : '';
                });
            }

            // ===== LIMPIAR FORMULARIO AL CERRAR MODAL =====
            const addTeacherModal = document.getElementById('addTeacherModal');
            if (addTeacherModal) {
                addTeacherModal.addEventListener('hidden.bs.modal', function() {
                    const form = document.getElementById('createTeacherForm');
                    if (form) {
                        form.reset();
                        if (edadInput) edadInput.value = '';
                    }
                });
            }

            // ===== VALIDACIÓN DE FORMULARIO =====
            const createTeacherForm = document.getElementById('createTeacherForm');
            if (createTeacherForm) {
                createTeacherForm.addEventListener('submit', function(e) {
                    const requiredFields = this.querySelectorAll('[required]');
                    let isValid = true;
                    let firstInvalidField = null;

                    requiredFields.forEach(function(field) {
                        if (!field.value.trim()) {
                            isValid = false;
                            field.classList.add('is-invalid');

                            if (!firstInvalidField) {
                                firstInvalidField = field;
                            }
                        } else {
                            field.classList.remove('is-invalid');
                        }
                    });

                    if (!isValid) {
                        e.preventDefault();

                        // Mostrar alerta de error
                        showAlert('Por favor, complete todos los campos obligatorios.', 'danger');

                        // Enfocar el primer campo inválido
                        if (firstInvalidField) {
                            firstInvalidField.focus();
                        }
                    }
                });
            }

            // ===== FUNCIÓN PARA MOSTRAR ALERTAS =====
            function showAlert(message, type = 'info') {
                const alertDiv = document.createElement('div');
                alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
                alertDiv.innerHTML = `
                    <i class="fas fa-${type === 'danger' ? 'exclamation-triangle' : 'info-circle'} me-2"></i> 
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;

                const content = document.querySelector('.container-fluid');
                if (content) {
                    content.insertBefore(alertDiv, content.firstChild);
                }

                setTimeout(function() {
                    if (alertDiv.parentNode) {
                        alertDiv.remove();
                    }
                }, 5000);
            }
        });
    </script>

</body>

</html>
