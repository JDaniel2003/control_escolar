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
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
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
                <img src="{{ asset('libs/sbadmin/img/upn.png') }}" alt="Logo"
                    style="width: 100%; height: 100%; object-fit: cover;">
            </div>
        </div>

        <div class="collapse navbar-collapse ml-4">
            <ul class="navbar-nav" style="padding-left: 20%;">
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1" href="{{ route('admin') }}">Inicio</a>
                </li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1"
                        href="{{ route('periodos.index') }}">Períodos Escolares</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1"
                        href="{{ route('carreras.index') }}">Carreras</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1"
                        href="{{ route('materias.index') }}">Materias</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1" href="{{ route('planes.index') }}">Planes
                        de estudio</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1"
                        href="{{ route('alumnos.index') }}">Alumnos</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1"
                        href="{{ route('asignaciones.index') }}">Asignaciones Docentes</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3 mr-1"
                        href="{{ route('historial.index') }}">Historial</a></li>
                <li class="nav-item"><a class="nav-link navbar-active-item px-3"
                        href="{{ route('calificaciones.index') }}">Calificaciones</a></li>
            </ul>
        </div>

        <div class="position-absolute" style="top: 10px; right: 20px; z-index: 1000;">
            <div class="d-flex align-items-center text-white">
                <span class="mr-3">{{ optional(Auth::user()->rol)->nombre }}</span>

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
                        Gestión de Calificaciones
                    </h1>

                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="mb-3 text-right">
                                <button type="button" class="btn btn-success" data-toggle="modal"
                                    data-target="#modalCalificarGrupo">
                                    <i class="fas fa-plus-circle"></i> Calificar Grupo
                                </button>
                            </div>

                            <!-- Filtros -->
                            <div class="container mb-4 d-flex justify-content-center">
                                <div class="p-3 border rounded bg-light d-inline-block shadow-sm">
                                    <form id="filtrosForm" method="GET" action="{{ route('calificaciones.index') }}"
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
                                        <a href="{{ route('calificaciones.index', ['mostrar' => 'todo']) }}"
                                            class="btn btn-sm btn-outline-secondary d-flex align-items-center">
                                            <i class="fas fa-list me-1"></i> Mostrar todo
                                        </a>
                                    </form>
                                </div>
                            </div>

                            <!-- Tabla de Calificaciones -->
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    @if (session('success'))
                                        <div class="alert alert-success">{{ session('success') }}</div>
                                    @endif

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-calificaciones"
                                            id="dataTable" width="100%" cellspacing="0">
                                            <thead class="thead-dark text-center">
                                                <tr>
                                                    <th>Alumno</th>
                                                    <th>Unidad</th>
                                                    <th>Evaluación</th>
                                                    <th>Asignación</th>
                                                    <th>Calificación</th>
                                                    <th>Calificación Especial</th>
                                                    <th>Fecha Registro</th>
                                                    <th>Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($calificaciones as $calificacion)
                                                   @php
    // Si existe calificación especial, usar esa
    $calif = $calificacion->calificacion_especial ?? $calificacion->calificacion;

    if ($calif >= 8) {
        $clase = 'calificacion-alta';
    } elseif ($calif >= 7) {
        $clase = 'calificacion-media';
    } else {
        $clase = 'calificacion-baja';
    }
@endphp

                                                    <tr class="text-center">
                                                        <td>
                                                            {{ optional($calificacion->alumno->datosPersonales)->nombres ?? 'N/A' }}
                                                            {{ optional($calificacion->alumno->datosPersonales)->primer_apellido ?? '' }}
                                                            {{ optional($calificacion->alumno->datosPersonales)->segundo_apellido ?? '' }}
                                                        </td>
                                                        <td>{{ $calificacion->unidad->nombre ?? 'N/A' }}</td>
                                                        <td>{{ $calificacion->evaluacion->nombre ?? 'N/A' }}</td>
                                                        <td>{{ $calificacion->asignacionDocente->id_asignacion ?? 'N/A' }}
                                                        </td>
                                                        <td class="{{ $clase }}">
                                                            {{ number_format($calificacion->calificacion, 1) }}</td>
                                                        <td class="{{ $clase }}">
                                                            {{ number_format($calificacion->calificacion_especial, 1) }}
                                                        </td>
                                                        <td>{{ $calificacion->fecha }}</td>

                                                        </td>
                                                        <td>
                                                            @if ($calif >= 7)
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

    <!-- Modal Calificar Grupo -->
    <!-- Modal Calificar Grupo - Tabla Matricial -->
    <div class="modal fade" id="modalCalificarGrupo" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-fullscreen" role="document">
            <div class="modal-content">
                <div class="modal-header modal-header-custom border-0">
                    <div class="w-100 text-center">
                    <h5 class="mb-0 font-weight-bold">
                        <i class="fas fa-graduation-cap mr-2"></i>Captura de Calificaciones
                    </h5>
                    </div>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar"
                        style="position: absolute; right: 1.5rem; top: 1.5rem; font-size: 1.8rem; opacity: 0.9;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-3">
                    <form id="formCalificarGrupo" method="POST"
                        action="{{ route('calificaciones.store-masivo') }}">
                        @csrf

                        <!-- Filtros -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <strong><i class="fas fa-filter mr-2"></i>Seleccionar Grupo y Materia</strong>
                            </div>
                            <div class="card-body1">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="font-weight-bold">Período Escolar <span
                                                class="text-danger">*</span></label>
                                        <select id="periodoCalificar" class="form-control" required>
                                            <option value="">-- Selecciona --</option>
                                            @foreach ($periodos as $periodo)
                                                <option value="{{ $periodo->id_periodo_escolar }}">
                                                    {{ $periodo->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="font-weight-bold">Grupo <span
                                                class="text-danger">*</span></label>
                                        <select id="grupoCalificar" class="form-control" required>
                                            <option value="">-- Selecciona --</option>
                                            @foreach ($grupos as $grupo)
                                                <option value="{{ $grupo->id_grupo }}">
                                                    {{ $grupo->nombre }} - {{ $grupo->carrera->nombre ?? 'N/A' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="font-weight-bold">Materia <span
                                                class="text-danger">*</span></label>
                                        <select id="materiaCalificar" class="form-control" required disabled>
                                            <option value="">-- Selecciona grupo primero --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-8">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle"></i>
                                            Selecciona periodo, grupo y materia para ver la tabla de calificaciones
                                        </small>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <button type="button" id="btnCargarMatriz" class="btn btn-primary" disabled>
                                            <i class="fas fa-table mr-1"></i>Cargar Tabla de Calificaciones
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tabla Matricial de Calificaciones -->
                        <div id="contenedorMatriz" style="display: none;">
                            <div class="card">
                                <div
                                    class="card-header text-white d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong><i class="fas fa-table mr-2"></i>Matriz de Calificaciones</strong>
                                        <span id="infoMateria" class="ml-3"></span>
                                    </div>
                                    <div>
                                        <span class="badge badge-light">
                                            Total alumnos: <strong id="totalAlumnos">0</strong>
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div id="contenedorTabla" style="overflow-x: auto; max-height: 600px;">
                                        <table class="table table-bordered table-hover table-sm mb-0"
                                            id="tablaCalificaciones">
                                            <thead  style="position: sticky; top: 0; z-index: 100;" class="text-center">
                                                <tr>
                                                    <th rowspan="2"
                                                        style="position: sticky; left: 0; background: #ffffff; z-index: 101; min-width: 50px;"
                                                        class="text-center">#</th>
                                                    <th rowspan="2"
                                                        style="position: sticky; left: 50px; background: #ffffff; z-index: 101; min-width: 120px;" class="text-center">
                                                        Matrícula</th>
                                                    <th rowspan="2"
                                                        style="position: sticky; left: 170px; background: #ffffff; z-index: 101; min-width: 250px;" class="text-center">
                                                        Alumno</th>
                                                    <!-- Se llenarán dinámicamente las unidades y evaluaciones -->
                                                </tr>
                                                <tr id="filaEvaluaciones">
                                                    <!-- Evaluaciones dinámicas -->
                                                </tr>
                                            </thead>
                                            <tbody id="bodyMatriz">
                                                <!-- Se llenará dinámicamente -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer bg-light">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle"></i>
                                            Calificaciones del 0 al 10. Deja vacío si no hay calificación.
                                        </small>
                                        <div>
                                            <button type="button" class="btn btn-sm btn-outline-secondary mr-2"
                                                id="btnLimpiarTodo">
                                                <i class="fas fa-eraser"></i> Limpiar Todo
                                            </button>
                                            <button type="button" class="btn btn-sm btn-success"
                                                id="btnGuardarCalificaciones" disabled>
                                                <i class="fas fa-save mr-1"></i> Guardar Calificaciones
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="calificaciones_json" id="calificacionesJsonInput">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const periodoSelect = document.getElementById('periodoCalificar');
            const grupoSelect = document.getElementById('grupoCalificar');
            const materiaSelect = document.getElementById('materiaCalificar');
            const btnCargar = document.getElementById('btnCargarMatriz');
            const btnGuardar = document.getElementById('btnGuardarCalificaciones');
            const btnLimpiar = document.getElementById('btnLimpiarTodo');
            const contenedor = document.getElementById('contenedorMatriz');
            const tbody = document.getElementById('bodyMatriz');
            const thead = document.querySelector('#tablaCalificaciones thead tr:first-child');

            let datosMatriz = {
                alumnos: [],
                unidades: []
            };

            // Iconos y colores por tipo de evaluación
            const tiposEvaluacion = {
                'ordinario': {
                    icon: '📘',
                    color: '#007bff',
                    label: 'Ordinario'
                },
                'recuperación': {
                    icon: '📗',
                    color: '#28a745',
                    label: 'Recuperación'
                },
                'recuperacion': {
                    icon: '📗',
                    color: '#28a745',
                    label: 'Recuperación'
                },
                'extraordinario': {
                    icon: '📕',
                    color: '#dc3545',
                    label: 'Extraordinario'
                },
                'extraordinario_especial': {
                    icon: '🎓',
                    color: '#6f42c1',
                    label: 'Extraordinario Especial'
                },
                'extraordinario especial': {
                    icon: '🎓',
                    color: '#6f42c1',
                    label: 'Extraordinario Especial'
                }
            };

            // Cargar materias
            function cargarMaterias() {
                const idGrupo = grupoSelect.value;
                const idPeriodo = periodoSelect.value;

                if (!idGrupo || !idPeriodo) {
                    materiaSelect.innerHTML = '<option value="">-- Selecciona grupo y período --</option>';
                    materiaSelect.disabled = true;
                    return;
                }

                materiaSelect.innerHTML = '<option value="">Cargando...</option>';
                materiaSelect.disabled = true;

                fetch(`/calificaciones/materias?grupo=${idGrupo}&periodo=${idPeriodo}`)
                    .then(r => r.json())
                    .then(data => {
                        if (data.success && data.materias.length > 0) {
                            materiaSelect.innerHTML = '<option value="">-- Selecciona materia --</option>';
                            data.materias.forEach(m => {
                                materiaSelect.innerHTML +=
                                    `<option value="${m.id_asignacion}">${m.materia} - ${m.docente}</option>`;
                            });
                            materiaSelect.disabled = false;
                        } else {
                            materiaSelect.innerHTML = '<option value="">No hay materias disponibles</option>';
                        }
                        validarFormulario();
                    })
                    .catch(err => {
                        console.error(err);
                        materiaSelect.innerHTML = '<option value="">Error al cargar</option>';
                    });
            }

            // Cargar matriz completa
            function cargarMatriz() {
                const idGrupo = grupoSelect.value;
                const idPeriodo = periodoSelect.value;
                const idAsignacion = materiaSelect.value;

                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ||
                    document.querySelector('input[name="_token"]')?.value;

                if (!csrfToken) {
                    alert('Error: Token CSRF no encontrado. Recarga la página.');
                    return;
                }

                tbody.innerHTML =
                    '<tr><td colspan="100" class="text-center py-4"><div class="spinner-border text-primary"></div><br>Cargando datos...</td></tr>';
                contenedor.style.display = 'block';

                const materiaText = materiaSelect.options[materiaSelect.selectedIndex].text;
                document.getElementById('infoMateria').innerHTML =
                    `<span class="badge badge-light">${materiaText}</span>`;

                fetch('/calificaciones/matriz-completa', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            id_grupo: idGrupo,
                            id_periodo: idPeriodo,
                            id_asignacion: idAsignacion
                        })
                    })
                    .then(response => {
                        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                        return response.json();
                    })
                    .then(data => {
                        console.log('=== RESPUESTA DEL SERVIDOR ===', data);
                        if (data.success) {
                            datosMatriz.alumnos = data.alumnos;
                            datosMatriz.unidades = data.unidades;
                            renderMatriz();
                        } else {
                            tbody.innerHTML =
                                `<tr><td colspan="100" class="text-center text-danger">Error: ${data.message || 'Error desconocido'}</td></tr>`;
                        }
                    })
                    .catch(err => {
                        console.error('Error completo:', err);
                        tbody.innerHTML =
                            `<tr><td colspan="100" class="text-center text-danger">Error de conexión: ${err.message}</td></tr>`;
                    });
            }

            // Renderizar matriz
            function renderMatriz() {
                if (datosMatriz.alumnos.length === 0) {
                    tbody.innerHTML =
                        '<tr><td colspan="100" class="text-center text-muted py-4">No hay alumnos en este grupo</td></tr>';
                    return;
                }

                let headersUnidades = '';
                datosMatriz.unidades.forEach(unidad => {
                    headersUnidades +=
                        `<th class="unidad-header" style="min-width: 200px;">${unidad.nombre}</th>`;
                });

                headersUnidades += `<th class="bg-info text-white">📊 Promedio</th>`;
                headersUnidades +=
                    `<th class="unidad-header bg-warning" style="min-width: 200px;">🎓 Calificación Final</th>`;

                thead.innerHTML = `
            <th style="position: sticky; left: 0; ; z-index: 101; min-width: 50px;" class="text-center">#</th>
            <th style="position: sticky; left: 50px; ; z-index: 101; min-width: 120px;">Matrícula</th>
            <th style="position: sticky; left: 170px; ; z-index: 101; min-width: 250px;">Alumno</th>
            ${headersUnidades}
        `;

                let html = '';
                datosMatriz.alumnos.forEach((alumno, indexAlumno) => {
                    html += `
            <tr>
                <td class="text-center alumno-cell" style="position: sticky; left: 0; background: white; z-index: 10;">
                    ${indexAlumno + 1}
                </td>
                <td class="matricula-cell" style="position: sticky; left: 50px; background: white; z-index: 10;">
                    <strong>${alumno.matricula}</strong>
                </td>
                <td class="nombre-cell" style="position: sticky; left: 170px; background: white; z-index: 10;">
                    ${alumno.nombre}
                </td>`;

                    // Verificar si reprobó algún Extraordinario
                    let reproboExtraordinario = false;
                    Object.values(alumno.calificaciones).forEach(calif => {
                        if (calif.tipo_evaluacion === 'Extraordinario' && 
                            calif.calificacion !== null && 
                            calif.calificacion < 7) {
                            reproboExtraordinario = true;
                        }
                    });

                    // Renderizar unidades
                    datosMatriz.unidades.forEach(unidad => {
                        const key = `${alumno.id_alumno}_${unidad.id_unidad}`;
                        const calificacionData = alumno.calificaciones[key];
                        const tieneCalifEspecial = alumno.calificacion_especial !== null && alumno.calificacion_especial !== undefined;

                        if (!calificacionData) {
                            // Si tiene calificación especial o reprobó extraordinario, mostrar "Bloqueado"
                            html += (tieneCalifEspecial || reproboExtraordinario)
                                ? `<td class="text-center p-2 text-muted">🔒 Bloqueado</td>`
                                : `<td class="text-center p-2">-</td>`;
                            return;
                        }

                        const calificacion = calificacionData.calificacion;
                        const yaCapturado = calificacion !== null;
                        const esAprobatoria = calificacion >= 7;
                        const puedeCapturar = calificacionData.puede_capturar && !tieneCalifEspecial && !reproboExtraordinario;
                        const siguienteEval = calificacionData.siguiente_evaluacion;

                        if (yaCapturado) {
                            const tipoEvaluacion = calificacionData.tipo_evaluacion || 'Ordinario';
                            const nombreEvaluacion = calificacionData.nombre_evaluacion || 'Evaluación';
                            const historialCompleto = calificacionData.historial_completo || [];
                            const tipoKey = tipoEvaluacion.toLowerCase().replace('ó', 'o').replace('ú', 'u');
                            const tipoEval = tiposEvaluacion[tipoKey] || tiposEvaluacion['ordinario'];
                            
                            let tooltipHistorial = '';
                            if (historialCompleto.length > 1) {
                                tooltipHistorial = 'Historial:\n' + 
                                    historialCompleto.map((h, i) => `${i + 1}. ${h.tipo}: ${h.calificacion}`).join('\n');
                            }
                            
                            // Si puede capturar y hay siguiente evaluación (y no está bloqueado)
                            if (puedeCapturar && siguienteEval) {
                                const siguienteTipoKey = siguienteEval.tipo.toLowerCase().replace('ó', 'o').replace('ú', 'u');
                                const siguienteTipoInfo = tiposEvaluacion[siguienteTipoKey] || tiposEvaluacion['ordinario'];
                                
                                html += `
                                <td class="text-center p-2" style="vertical-align: middle;">
                                    <div class="d-flex flex-column align-items-center">
                                        <span class="badge mb-2" 
                                              style="font-size: 0.9rem; padding: 0.4rem; background: ${esAprobatoria ? '#28a745' : '#dc3545'}; cursor: help;"
                                              ${tooltipHistorial ? `title="${tooltipHistorial.replace(/"/g, '&quot;')}"` : ''}>
                                            Actual: ${calificacion} ${tipoEval.icon}
                                        </span>
                                        ${historialCompleto.length > 1 ? `
                                        <small class="text-muted mb-2" style="font-size: 0.7rem;">
                                            📋 ${historialCompleto.length} evaluaciones
                                        </small>
                                        ` : ''}
                                        <hr style="width: 100%; margin: 0.5rem 0; border-top: 1px dashed #ddd;">
                                        <input type="number" 
                                               class="form-control calificacion-input-matriz text-center mt-2" 
                                               data-alumno="${alumno.id_alumno}"
                                               data-unidad="${unidad.id_unidad}"
                                               data-evaluacion="${siguienteEval.id_evaluacion}"
                                               data-tipoeval="${siguienteTipoKey}"
                                               min="0" 
                                               max="10" 
                                               step="0.1"
                                               placeholder="Nueva calif."
                                               style="width: 100px; margin: 0 auto;">
                                        <small class="text-muted mt-1" style="color: ${siguienteTipoInfo.color};">
                                            ${siguienteTipoInfo.icon} ${siguienteEval.tipo}
                                        </small>
                                    </div>
                                </td>`;
                            } else {
                                html += `
                                <td class="text-center p-2" style="vertical-align: middle;">
                                    <div class="d-flex flex-column align-items-center">
                                        <span class="badge mb-1" 
                                              style="font-size: 1.1rem; padding: 0.5rem; background: ${esAprobatoria ? '#28a745' : '#dc3545'}; cursor: help;"
                                              ${tooltipHistorial ? `title="${tooltipHistorial.replace(/"/g, '&quot;')}"` : ''}>
                                            ${calificacion}
                                        </span>
                                        <small style="color: ${tipoEval.color};">
                                            ${tipoEval.icon} ${tipoEval.label}
                                        </small>
                                        ${historialCompleto.length > 1 ? `
                                        <small class="text-muted mt-1" style="font-size: 0.7rem;">
                                            
                                        </small>
                                        ` : ''}
                                        ${esAprobatoria ? `
                                        <small class="text-success mt-1" style="font-size: 0.8rem;">
                                            
                                        </small>
                                        ` : (tipoEvaluacion === 'Extraordinario' ? `
                                        <small class="text-danger mt-1" style="font-size: 0.8rem;">
                                            
                                        </small>
                                        ` : `
                                        <small class="text-muted mt-1" style="font-size: 0.8rem;">
                                            Sin Oportunidades
                                        </small>
                                        `)}
                                    </div>
                                </td>`;
                            }
                        } else {
                            // Sin calificación aún
                            if (puedeCapturar && siguienteEval) {
                                const tipoKey = siguienteEval.tipo.toLowerCase().replace('ó', 'o').replace('ú', 'u');
                                const tipoInfo = tiposEvaluacion[tipoKey] || tiposEvaluacion['ordinario'];
                                
                                html += `
                                <td class="text-center p-2" style="vertical-align: middle;">
                                    <input type="number" 
                                           class="form-control calificacion-input-matriz text-center" 
                                           data-alumno="${alumno.id_alumno}"
                                           data-unidad="${unidad.id_unidad}"
                                           data-evaluacion="${siguienteEval.id_evaluacion}"
                                           data-tipoeval="${tipoKey}"
                                           min="0" 
                                           max="10" 
                                           step="0.1"
                                           placeholder="0.0"
                                           style="width: 100px; margin: 0 auto;">
                                    <small class="text-muted mt-1" style="color: ${tipoInfo.color};">
                                        ${tipoInfo.icon} ${siguienteEval.tipo}
                                    </small>
                                </td>`;
                            } else {
                                html += `<td class="text-center p-2 text-muted">${(tieneCalifEspecial || reproboExtraordinario) ? '🔒 Bloqueado' : 'Completado'}</td>`;
                            }
                        }
                    });

                    // Columna de Promedio General
                    const tieneCalifEspecial = alumno.calificacion_especial !== null && alumno.calificacion_especial !== undefined;
                    if (tieneCalifEspecial) {
                        html += `<td class="text-center p-2 bg-light text-muted" style="font-size: 0.8rem;">-</td>`;
                    } else {
                        const promedioGeneral = alumno.promedio_general;
                        if (promedioGeneral !== null && promedioGeneral !== undefined && !isNaN(promedioGeneral)) {
                            const esAprobado = promedioGeneral >= 7;
                            html += `
                            <td class="text-center p-2 bg-light" style="vertical-align: middle;">
                                <span class="badge" style="font-size: 1.2rem; padding: 0.6rem; background: ${esAprobado ? '#17a2b8' : '#6c757d'};">
                                    ${promedioGeneral}
                                </span>
                                <small class="d-block mt-1 text-muted" style="font-size: 0.7rem;">
                                    
                                </small>
                            </td>`;
                        } else {
                            html += `<td class="text-center p-2 bg-light text-muted" style="font-size: 0.8rem;">Pendiente</td>`;
                        }
                    }

                    // Columna Extraordinario Especial
                    const tipoEvalEspecial = tiposEvaluacion['extraordinario_especial'] || {
                        icon: '🎓',
                        color: '#6f42c1',
                        label: 'Extraordinario Especial'
                    };

                    if (tieneCalifEspecial) {
                        const esAprob = alumno.calificacion_especial >= 7;
                        html += `
                        <td class="text-center p-2" style="vertical-align: middle; background: #fff3cd; border-left: 3px solid #6f42c1;">
                            <div class="d-flex flex-column align-items-center">
                                <span class="badge mb-1" style="font-size: 1.2rem; padding: 0.6rem; background: ${esAprob ? '#28a745' : '#dc3545'};">
                                    ${alumno.calificacion_especial}
                                </span>
                                <small style="color: ${tipoEvalEspecial.color}; font-weight: bold;">
                                    ${tipoEvalEspecial.icon} ${tipoEvalEspecial.label}
                                </small>
                                ${esAprob ? `
                                    <small class="text-success mt-1">
                                        <i class="fas fa-check-circle"></i>
                                    </small>` : `
                                    <small class="text-danger mt-1">
                                        <i class="fas fa-times-circle"></i>
                                    </small>`}
                                <small class="text-muted mt-1" style="font-size: 0.7rem;">
                                    
                                </small>
                            </div>
                        </td>`;
                    } else if (reproboExtraordinario) {
                        // Si reprobó extraordinario, HABILITAR Extraordinario Especial
                        if (alumno.evaluacion_especial) {
                            const evalEspecial = alumno.evaluacion_especial;
                            html += `
                            <td class="text-center p-2" style="vertical-align: middle; background: #fff3cd; border-left: 3px solid #dc3545;">
                                <div class="d-flex flex-column align-items-center mb-2">
                                    <span class="badge badge-danger mb-2" style="font-size: 0.85rem;">
                                        
                                    </span>
                                </div>
                                <input type="number" 
                                       class="form-control calificacion-input-especial text-center" 
                                       data-alumno="${alumno.id_alumno}"
                                       data-evaluacion="${evalEspecial.id_evaluacion}"
                                       min="0" max="10" step="0.1" placeholder="Calif."
                                       style="width: 90px; margin: 0 auto; border: 3px solid #dc3545; font-weight: bold;">
                                <small class="d-block mt-2" style="color: #6f42c1; font-weight: bold; font-size: 0.75rem;">
                                    🎓 ${evalEspecial.nombre}
                                </small>
                                <small class="d-block text-danger mt-1" style="font-size: 0.65rem; font-weight: bold;">
                                    
                                </small>
                            </td>`;
                        } else {
                            html += `<td class="text-center p-2 bg-light text-muted">-</td>`;
                        }
                    } else {
                        // Verificar si hay al menos una unidad reprobada en "Extraordinario" (pero no todas)
                        let hayExtraordinarioReprobado = false;
                        datosMatriz.unidades.forEach(unidad => {
                            const key = `${alumno.id_alumno}_${unidad.id_unidad}`;
                            const califData = alumno.calificaciones[key];
                            if (califData &&
                                califData.calificacion !== null &&
                                califData.calificacion < 7 &&
                                califData.tipo_evaluacion === 'Extraordinario') {
                                hayExtraordinarioReprobado = true;
                            }
                        });

                        // Solo permitir captura si tiene evaluación especial y NO ha reprobado todos los extraordinarios
                        if (hayExtraordinarioReprobado && alumno.evaluacion_especial && !reproboExtraordinario) {
                            const evalEspecial = alumno.evaluacion_especial;
                            html += `
                            <td class="text-center p-2" style="vertical-align: middle; background: #fff3cd; border-left: 3px solid #dc3545;">
                                <input type="number" 
                                       class="form-control calificacion-input-especial text-center" 
                                       data-alumno="${alumno.id_alumno}"
                                       data-evaluacion="${evalEspecial.id_evaluacion}"
                                       min="0" max="10" step="0.1" placeholder="Calif."
                                       style="width: 90px; margin: 0 auto; border: 3px solid #dc3545; font-weight: bold;">
                                <small class="d-block mt-2" style="color: #6f42c1; font-weight: bold; font-size: 0.75rem;">
                                    🎓 ${evalEspecial.nombre}
                                </small>
                                <small class="d-block text-danger mt-1" style="font-size: 0.65rem; font-weight: bold;">
                                    📚 Examen de toda la materia
                                </small>
                            </td>`;
                        } else {
                            html += `<td class="text-center p-2 bg-light text-muted">-</td>`;
                        }
                    }

                    html += '</tr>';
                });

                tbody.innerHTML = html;
                document.getElementById('totalAlumnos').textContent = datosMatriz.alumnos.length;

                // Eventos para inputs de unidades
                document.querySelectorAll('.calificacion-input-matriz').forEach(input => {
                    input.addEventListener('input', function() {
                        const valor = parseFloat(this.value);
                        if (this.value && (valor < 0 || valor > 10 || isNaN(valor))) {
                            this.classList.add('is-invalid');
                        } else {
                            this.classList.remove('is-invalid');
                        }
                        validarGuardar();
                    });

                    input.addEventListener('keydown', function(e) {
                        if (['ArrowUp', 'ArrowDown', 'ArrowLeft', 'ArrowRight'].includes(e.key)) {
                            e.preventDefault();
                            navegarCelda(this, e.key);
                        }
                    });
                });

                // Eventos para inputs de Extraordinario Especial
                document.querySelectorAll('.calificacion-input-especial').forEach(input => {
                    input.addEventListener('input', function() {
                        const valor = parseFloat(this.value);
                        if (this.value && (valor < 0 || valor > 10 || isNaN(valor))) {
                            this.classList.add('is-invalid');
                        } else {
                            this.classList.remove('is-invalid');
                        }
                        validarGuardar();
                    });
                });

                validarGuardar();
            }

            // Navegación con teclado
            function navegarCelda(inputActual, tecla) {
                const inputs = Array.from(document.querySelectorAll('.calificacion-input-matriz'));
                const indexActual = inputs.indexOf(inputActual);
                let nuevoIndex = indexActual;
                const columnas = datosMatriz.unidades.length;

                switch (tecla) {
                    case 'ArrowUp':
                        nuevoIndex = indexActual - columnas;
                        break;
                    case 'ArrowDown':
                        nuevoIndex = indexActual + columnas;
                        break;
                    case 'ArrowLeft':
                        nuevoIndex = indexActual - 1;
                        break;
                    case 'ArrowRight':
                        nuevoIndex = indexActual + 1;
                        break;
                }

                if (nuevoIndex >= 0 && nuevoIndex < inputs.length) {
                    inputs[nuevoIndex].focus();
                    inputs[nuevoIndex].select();
                }
            }

            // Validar formulario
            function validarFormulario() {
                const valido = periodoSelect.value && grupoSelect.value && materiaSelect.value;
                btnCargar.disabled = !valido;
            }

            // Validar si se puede guardar
            function validarGuardar() {
                const inputsUnidades = document.querySelectorAll('.calificacion-input-matriz');
                const inputsEspeciales = document.querySelectorAll('.calificacion-input-especial');
                let hayCalificacionesValidas = false;

                inputsUnidades.forEach(input => {
                    if (input.value && !input.classList.contains('is-invalid') && input.dataset.evaluacion) {
                        hayCalificacionesValidas = true;
                    }
                });

                inputsEspeciales.forEach(input => {
                    if (input.value && !input.classList.contains('is-invalid')) {
                        hayCalificacionesValidas = true;
                    }
                });

                btnGuardar.disabled = !hayCalificacionesValidas;
            }

            // Limpiar calificaciones
            btnLimpiar?.addEventListener('click', function() {
                if (confirm('¿Estás seguro de limpiar todas las calificaciones no guardadas?')) {
                    document.querySelectorAll('.calificacion-input-matriz, .calificacion-input-especial').forEach(input => {
                        input.value = '';
                        input.classList.remove('is-invalid');
                    });
                    validarGuardar();
                }
            });

            // Guardar calificaciones
            btnGuardar?.addEventListener('click', function() {
                const calificaciones = [];
                const calificacionesEspeciales = [];

                // Calificaciones de unidades
                document.querySelectorAll('.calificacion-input-matriz').forEach(input => {
                    const valor = input.value;
                    if (valor && valor !== '' && !input.classList.contains('is-invalid')) {
                        const evaluacion = input.dataset.evaluacion;
                        if (evaluacion) {
                            calificaciones.push({
                                id_alumno: parseInt(input.dataset.alumno),
                                id_unidad: parseInt(input.dataset.unidad),
                                id_evaluacion: parseInt(evaluacion),
                                calificacion: parseFloat(valor)
                            });
                        }
                    }
                });

                // Calificaciones especiales (Extraordinario Especial)
                document.querySelectorAll('.calificacion-input-especial').forEach(input => {
                    const valor = input.value;
                    if (valor && valor !== '' && !input.classList.contains('is-invalid')) {
                        calificacionesEspeciales.push({
                            id_alumno: parseInt(input.dataset.alumno),
                            id_evaluacion: parseInt(input.dataset.evaluacion),
                            calificacion_especial: parseFloat(valor)
                        });
                    }
                });

                if (calificaciones.length === 0 && calificacionesEspeciales.length === 0) {
                    alert('Debes ingresar al menos una calificación');
                    return;
                }

                const data = {
                    id_asignacion: materiaSelect.value,
                    calificaciones: calificaciones,
                    calificaciones_especiales: calificacionesEspeciales
                };

                const inputJson = document.getElementById('calificacionesJsonInput');
                if (!inputJson) {
                    alert('ERROR: Input calificacionesJsonInput no encontrado');
                    return;
                }

                inputJson.value = JSON.stringify(data);
                btnGuardar.disabled = true;
                btnGuardar.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Guardando...';

                const form = document.getElementById('formCalificarGrupo');
                if (!form) {
                    alert('ERROR: Formulario no encontrado');
                    return;
                }

                form.submit();
            });

            // Eventos
            periodoSelect.addEventListener('change', cargarMaterias);
            grupoSelect.addEventListener('change', cargarMaterias);
            materiaSelect.addEventListener('change', validarFormulario);
            btnCargar.addEventListener('click', cargarMatriz);

            // Reset al cerrar modal
            $('#modalCalificarGrupo').on('hidden.bs.modal', function() {
                document.getElementById('formCalificarGrupo').reset();
                tbody.innerHTML = '';
                contenedor.style.display = 'none';
                datosMatriz = {
                    alumnos: [],
                    unidades: []
                };
                btnGuardar.disabled = true;
                btnGuardar.innerHTML = '<i class="fas fa-save mr-1"></i> Guardar Calificaciones';
            });
        });
    </script>
    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">¿Listo para salir?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Selecciona "Cerrar Sesión" si estás listo para finalizar tu sesión actual.
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>

                <!-- Botón de cierre de sesión -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        Cerrar Sesión
                    </button>
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
