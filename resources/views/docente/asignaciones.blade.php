<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mis Asignaciones - Calificaciones</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('libs/fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
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
                    <a class="nav-link text-white px-3 mr-1" href="{{ route('docente.dashboard') }}">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link navbar-active-item px-3 mr-1" href="#">Mis Asignaciones</a>
                </li>
            </ul>
        </div>

        <div class="position-absolute" style="top: 10px; right: 20px; z-index: 1000;">
            <div class="d-flex align-items-center text-white">
                <span class="mr-3 small">{{ Auth::user()->rol->nombre }}</span>
                <a href="#" class="text-white text-decoration-none logout-link" data-toggle="modal"
                    data-target="#logoutModal">
                    Cerrar Sesión <i class="fas fa-sign-out-alt ml-1"></i>
                </a>
            </div>
        </div>
    </nav>

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Begin Page Content -->
                <div class="container-fluid py-4">

                    <!-- Page Heading -->

                    <h1 class="text-danger text-center mb-5"
                        style="font-size: 2.5rem; font-family: 'Arial Black', Verdana, sans-serif; font-weight: bold;">
                        Mis Asignaciones
                    </h1>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-10">
                            <!-- Asignaciones Card -->


                            <div class="card-body1">
                                @if ($asignaciones->isEmpty())
                                    <div class="alert alert-info border-left-info" role="alert">
                                        <div class="text-center py-3">
                                            <i class="fas fa-info-circle fa-3x mb-3 text-info"></i>
                                            <h5 class="font-weight-bold">Actualmente no tienes ninguna asignación</h5>
                                            <p class="mb-0">Comunícate con el Personal Administrativo para asignarte
                                                materias.</p>
                                        </div>
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover" id="dataTable" width="100%"
                                            cellspacing="0">
                                            <thead class="thead-dark text-center">
                                                <tr>
                                                    <th class="text-center"><i class="fas fa-book mr-1"></i>Materia
                                                    </th>
                                                    <th class="text-center"><i class="fas fa-users mr-1"></i>Grupo
                                                    </th>
                                                    <th class="text-center"><i
                                                            class="fas fa-calendar-alt mr-1"></i>Período</th>
                                                    <th class="text-center"><i class="fas fa-cogs mr-1"></i>Acciones
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($asignaciones as $asignacion)
                                                    <tr class="text-center">
                                                        <td>{{ $asignacion['materia'] }}</td>
                                                        <td>{{ $asignacion['grupo'] }}</td>
                                                        <td>{{ $asignacion['periodo'] }}</td>
                                                        <td>
                                                            <button
                                                                class="btn btn-success btn-sm shadow-sm calificar-btn"
                                                                data-id-asignacion="{{ $asignacion['id_asignacion'] }}"
                                                                data-id-grupo="{{ $asignacion['id_grupo'] }}"
                                                                data-id-periodo="{{ $asignacion['id_periodo'] }}"
                                                                data-materia="{{ $asignacion['materia'] }}"
                                                                data-grupo="{{ $asignacion['grupo'] }}">
                                                                <i class="fas fa-edit mr-1"></i>Calificar
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Modal para calificar -->
    <div class="modal fade" id="modalCalificar" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-fullscreen" role="document">
            <div class="modal-content">
                <div class="modal-header modal-header-custom border-0">
                    <div class="w-100 text-center">
                        <h5 class="mb-0 font-weight-bold">
                            <i class="fas fa-graduation-cap mr-2"></i>
                            <span id="tituloModal">Calificar Materia</span>
                        </h5>

                    </div>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar"
                        style="position: absolute; right: 1.5rem; top: 1.5rem; font-size: 1.8rem; opacity: 0.9;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-3">
                    <form id="formCalificarGrupo" method="POST" action="{{ route('calificaciones.guardar') }}">
                        @csrf
                        <input type="hidden" id="calificacionesJsonInput" name="calificaciones_json">

                        <!-- Filtros -->
                        <div class="card mb-3">
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label class="font-weight-bold text-gray-700 small">Período</label>
                                    <select id="periodoCalificar" class="form-control form-control-sm" disabled>
                                        <option value="">Selecciona período</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="font-weight-bold text-gray-700 small">Grupo</label>
                                    <select id="grupoCalificar" class="form-control form-control-sm" disabled>
                                        <option value="">Selecciona grupo</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="font-weight-bold text-gray-700 small">Materia</label>
                                    <select id="materiaCalificar" class="form-control form-control-sm" disabled>
                                        <option value="">Selecciona materia</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Contenedor de la matriz -->
                        <div id="contenedorMatriz" style="display: none;">
                            <div class="card-header text-white d-flex justify-content-between align-items-center">
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

                            <div class="table-responsive">
                                <table id="tablaCalificaciones"
                                    class="table table-bordered table-hover table-sm mb-0">
                                    <thead style="position: sticky; top: 0; z-index: 100;" class="text-center">
                                        <tr></tr>
                                    </thead>
                                    <tbody id="bodyMatriz">
                                        <tr>
                                            <td colspan="100" class="text-center py-5">
                                                <div class="spinner-border text-primary" role="status"></div>
                                                <p class="mt-3 text-gray-600">Cargando alumnos...</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm shadow-sm" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>Cerrar
                    </button>
                    <button type="button" class="btn btn-warning btn-sm shadow-sm" id="btnLimpiarTodo">
                        <i class="fas fa-broom mr-1"></i>Limpiar
                    </button>
                    <button type="button" class="btn btn-primary btn-sm shadow-sm" id="btnCargarMatriz">
                        <i class="fas fa-sync-alt mr-1"></i>Cargar Matriz
                    </button>
                    <button type="submit" class="btn btn-success btn-sm shadow-sm" id="btnGuardarCalificaciones"
                        disabled>
                        <i class="fas fa-save mr-1"></i>Guardar Calificaciones
                    </button>
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
        $(document).ready(function() {
            // Variables globales
            let datosMatriz = {
                alumnos: [],
                unidades: []
            };

            // Iconos y colores por tipo de evaluación
            const tiposEvaluacion = {
                'ordinario': {
                    icon: '📘',
                    color: '#4e73df',
                    label: 'Ordinario'
                },
                'recuperación': {
                    icon: '📗',
                    color: '#1cc88a',
                    label: 'Recuperación'
                },
                'recuperacion': {
                    icon: '📗',
                    color: '#1cc88a',
                    label: 'Recuperación'
                },
                'extraordinario': {
                    icon: '📕',
                    color: '#e74a3b',
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

            // Evento para botón "Calificar"
            $(document).on('click', '.calificar-btn', function(e) {
                e.preventDefault();

                const datosModal = {
                    id_asignacion: $(this).data('id-asignacion'),
                    id_grupo: $(this).data('id-grupo'),
                    id_periodo: $(this).data('id-periodo'),
                    materia: $(this).data('materia'),
                    grupo: $(this).data('grupo')
                };

                console.log('Datos del modal:', datosModal);

                // Actualizar título
                $('#tituloModal').text(
                    `Calificar Alumnos de la materia: ${datosModal.materia} - ${datosModal.grupo}`);

                // Llenar selects
                $('#periodoCalificar').html(
                    `<option value="${datosModal.id_periodo}" selected>${datosModal.id_periodo}</option>`
                    );
                $('#grupoCalificar').html(
                    `<option value="${datosModal.id_grupo}" selected>${datosModal.grupo}</option>`);
                $('#materiaCalificar').html(
                    `<option value="${datosModal.id_asignacion}" selected>${datosModal.materia}</option>`
                    );

                // Mostrar modal
                $('#modalCalificar').modal('show');
            });

            // Cargar matriz
            $('#btnCargarMatriz').on('click', function() {
                const idGrupo = $('#grupoCalificar').val();
                const idPeriodo = $('#periodoCalificar').val();
                const idAsignacion = $('#materiaCalificar').val();
                const csrfToken = $('meta[name="csrf-token"]').attr('content');

                if (!idGrupo || !idPeriodo || !idAsignacion) {
                    alert('Faltan datos para cargar la matriz');
                    return;
                }

                const tbody = $('#bodyMatriz');
                tbody.html(
                    '<tr><td colspan="100" class="text-center py-4"><div class="spinner-border text-primary"></div><br>Cargando datos...</td></tr>'
                    );
                $('#contenedorMatriz').show();

                $.ajax({
                    url: '/calificaciones/matriz-completa',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    contentType: 'application/json',
                    data: JSON.stringify({
                        id_grupo: idGrupo,
                        id_periodo: idPeriodo,
                        id_asignacion: idAsignacion
                    }),
                    success: function(data) {
                        if (data.success) {
                            datosMatriz.alumnos = data.alumnos;
                            datosMatriz.unidades = data.unidades;
                            renderMatriz();
                        } else {
                            tbody.html(
                                `<tr><td colspan="100" class="text-center text-danger">${data.message || 'Error desconocido'}</td></tr>`
                                );
                        }
                    },
                    error: function(xhr, status, error) {
                        tbody.html(
                            `<tr><td colspan="100" class="text-center text-danger">Error: ${error}</td></tr>`
                            );
                    }
                });
            });

            // Renderizar matriz
            function renderMatriz() {
                if (datosMatriz.alumnos.length === 0) {
                    $('#bodyMatriz').html(
                        '<tr><td colspan="100" class="text-center text-muted py-4">No hay alumnos en este grupo</td></tr>'
                        );
                    return;
                }

                let headersUnidades = '';
                datosMatriz.unidades.forEach(unidad => {
                    headersUnidades += `<th class="unidad-header">${unidad.nombre}</th>`;
                });
                headersUnidades += `<th class="bg-info text-white">📊 Promedio</th>`;
                headersUnidades += `<th class="unidad-header bg-warning">🎓 Calificación Final</th>`;

                $('#tablaCalificaciones thead tr').html(`
                    <th class="text-center">#</th>
                    <th>Matrícula</th>
                    <th>Alumno</th>
                    ${headersUnidades}
                `);

                let html = '';
                datosMatriz.alumnos.forEach((alumno, indexAlumno) => {
                    html += `<tr>
                        <td class="text-center alumno-cell">${indexAlumno + 1}</td>
                        <td class="matricula-cell"><strong>${alumno.matricula}</strong></td>
                        <td class="nombre-cell">${alumno.nombre}</td>`;

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
                    datosMatriz.unidades.forEach((unidad, indexUnidad) => {
    const key = `${alumno.id_alumno}_${unidad.id_unidad}`;
    const calificacionData = alumno.calificaciones[key];
    const tieneCalifEspecial = alumno.calificacion_especial !== null && 
        alumno.calificacion_especial !== undefined;

    // Contar unidades con calificación y verificar condiciones
    let unidadesConCalificacion = 0;
    let tieneExtraordinario = false;
    const totalUnidades = datosMatriz.unidades.length;
    
    Object.entries(alumno.calificaciones).forEach(([k, calif]) => {
        if (calif?.calificacion !== null) {
            unidadesConCalificacion++;
        }
        if (calif?.tipo_evaluacion === 'Extraordinario') {
            tieneExtraordinario = true;
        }
    });

    // Verificar la ÚLTIMA unidad y su estado
    const ultimaUnidad = datosMatriz.unidades[totalUnidades - 1];
    const keyUltimaUnidad = `${alumno.id_alumno}_${ultimaUnidad.id_unidad}`;
    const califUltimaUnidad = alumno.calificaciones[keyUltimaUnidad];
    
    let puedeHabilitarExtraordinario = false;
    
    // Todas las unidades deben tener calificación
    const todasLasUnidadesCompletas = unidadesConCalificacion >= totalUnidades;
    
    if (todasLasUnidadesCompletas && califUltimaUnidad) {
        const tipoUltimaUnidad = califUltimaUnidad.tipo_evaluacion;
        const califUltimaAprobada = califUltimaUnidad.calificacion >= 7;
        
        // Casos en los que se habilita el Extraordinario:
        // 1. La última unidad está en Extraordinario (ya llegó ahí)
        if (tipoUltimaUnidad === 'Extraordinario') {
            puedeHabilitarExtraordinario = true;
        }
        // 2. La última unidad está en Recuperación Y YA TIENE CALIFICACIÓN (aprobada o reprobada)
        else if (tipoUltimaUnidad === 'Recuperación' && califUltimaUnidad.calificacion !== null) {
            puedeHabilitarExtraordinario = true;
        }
        // 3. La última unidad está en Ordinario/Regularización Y está aprobada
        else if ((tipoUltimaUnidad === 'Ordinario' || tipoUltimaUnidad === 'Regularización') && califUltimaAprobada) {
            puedeHabilitarExtraordinario = true;
        }
    }

    // Verificar si reprobó algún Extraordinario
    let reproboExtraordinario = false;
    Object.values(alumno.calificaciones).forEach(calif => {
        if (calif?.tipo_evaluacion === 'Extraordinario' &&
            calif.calificacion !== null &&
            calif.calificacion < 7) {
            reproboExtraordinario = true;
        }
    });

    // Verificar si unidades anteriores están completadas y aprobadas
    let puedeCapturarEstaUnidad = false;
    let mensajeError = '';

    if (indexUnidad === 0) {
        // Primera unidad: siempre habilitada si no está bloqueada
        puedeCapturarEstaUnidad = !tieneCalifEspecial && !reproboExtraordinario;
    } else {
        // Unidades posteriores: verificar unidad anterior
        const unidadAnterior = datosMatriz.unidades[indexUnidad - 1];
        const keyAnterior = `${alumno.id_alumno}_${unidadAnterior.id_unidad}`;
        const califAnterior = alumno.calificaciones[keyAnterior];

        if (!califAnterior || califAnterior.calificacion === null) {
            mensajeError = 'Captura la unidad anterior primero';
        } else if (califAnterior.calificacion < 0) {
            mensajeError = 'La unidad anterior debe estar aprobada';
        } else {
            puedeCapturarEstaUnidad = !tieneCalifEspecial && !reproboExtraordinario;
        }
    }

    // LÓGICA ESPECIAL: Si la unidad actual ES un Extraordinario
    const esExtraordinarioActual = calificacionData?.tipo_evaluacion === 'Extraordinario';
    
    if (esExtraordinarioActual && !puedeHabilitarExtraordinario) {
        // Bloquear el Extraordinario hasta que se cumplan las condiciones
        puedeCapturarEstaUnidad = false;
        if (!todasLasUnidadesCompletas) {
            mensajeError = '🔒 Completa todas las unidades primero';
        } else if (califUltimaUnidad?.tipo_evaluacion === 'Recuperación' && califUltimaUnidad.calificacion < 7) {
            mensajeError = '🔒 Aprueba la Recuperación de la última unidad';
        } else {
            mensajeError = '🔒 Completa todos los requisitos';
        }
    }

    // Forzar bloqueo si hay calificación especial o extraordinario reprobado
    if (tieneCalifEspecial || reproboExtraordinario) {
        puedeCapturarEstaUnidad = false;
        mensajeError = reproboExtraordinario ? '🔒 Bloqueado' : '🔒 Calificación especial asignada';
    }

    if (!calificacionData) {
        if (mensajeError) {
            html += `<td class="text-center p-2 text-muted" title="${mensajeError}">${mensajeError}</td>`;
        } else {
            html += `<td class="text-center p-2">-</td>`;
        }
        return;
    }

    const calificacion = calificacionData.calificacion;
    const yaCapturado = calificacion !== null;
    const esAprobatoria = calificacion >= 7;
    const siguienteEval = calificacionData.siguiente_evaluacion;
    
    // Aplicar la lógica de bloqueo del Extraordinario
    let puedeCapturar = puedeCapturarEstaUnidad && calificacionData.puede_capturar;
    
    // Si la siguiente evaluación es Extraordinario, verificar si puede habilitarse
    if (siguienteEval?.tipo === 'Extraordinario' && !puedeHabilitarExtraordinario) {
        puedeCapturar = false;
        if (!todasLasUnidadesCompletas) {
            mensajeError = 'Extraordinario Pendiante';
        } else if (califUltimaUnidad?.tipo_evaluacion === 'Recuperación' && califUltimaUnidad.calificacion < 7) {
            mensajeError = '🔒 Aprueba la Recuperación de la última unidad';
        } else {
            mensajeError = '🔒 Completa todos los requisitos';
        }
    }

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
                    ${mensajeError ? `
                    <small class="text-warning mt-1" style="font-size: 0.75rem;">
                        ${mensajeError}
                    </small>
                    ` : esAprobatoria ? `
                    <small class="text-success mt-1" style="font-size: 0.8rem;">
                        
                    </small>
                    ` : `
                    <small class="text-muted mt-1" style="font-size: 0.8rem;">
                        
                    </small>
                    `}
                </div>
            </td>`;
        }
    } else {
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
            html += `<td class="text-center p-2 text-muted" title="${mensajeError || 'Completado'}">${mensajeError || 'Completado'}</td>`;
        }
    }
});

                    // Promedio
                    const tieneCalifEspecial = alumno.calificacion_especial !== null && alumno
                        .calificacion_especial !== undefined;
                    if (tieneCalifEspecial) {
                        html +=
                            `<td class="text-center p-2 bg-light text-muted" style="font-size: 0.8rem;">-</td>`;
                    } else {
                        const promedioGeneral = alumno.promedio_general;
                        if (promedioGeneral !== null && promedioGeneral !== undefined && !isNaN(
                                promedioGeneral)) {
                            // ✅ REDONDEAR SIN DECIMALES
                            const promedioRedondeado = Math.round(promedioGeneral);
                            const esAprobado = promedioRedondeado >= 7;
                            html += `
        <td class="text-center p-2 bg-light" style="vertical-align: middle;">
            <span class="badge" style="font-size: 1.2rem; padding: 0.6rem; background: ${esAprobado ? '#17a2b8' : '#6c757d'};">
                ${promedioRedondeado}
            </span>
            <small class="d-block mt-1 text-muted" style="font-size: 0.7rem;">
                
            </small>
        </td>`;
                        } else {
                            html +=
                                `<td class="text-center p-2 bg-light text-muted" style="font-size: 0.8rem;">Pendiente</td>`;
                        }
                    }

                    // Extraordinario Especial
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
                                    <span class="badge mb-1" style="font-size: 1.2rem; padding: 0.6rem; background: ${esAprob ? '#1cc88a' : '#e74a3b'};">
                                        ${alumno.calificacion_especial}
                                    </span>
                                    <small style="color: ${tipoEvalEspecial.color}; font-weight: bold;">
                                        ${tipoEvalEspecial.icon} ${tipoEvalEspecial.label}
                                    </small>
                                    ${esAprob ? `
                                            <small class="text-success mt-1"><i class="fas fa-check-circle"></i> </small>
                                            ` : `
                                            <small class="text-danger mt-1"><i class="fas fa-times-circle"></i> </small>
                                            `}
                                    <small class="text-muted mt-1" style="font-size: 0.7rem;"></small>
                                </div>
                            </td>`;
                    } else if (reproboExtraordinario) {
                        // Si reprobó extraordinario, HABILITAR Extraordinario Especial
                        if (alumno.evaluacion_especial) {
                            const evalEspecial = alumno.evaluacion_especial;
                            html += `
                                <td class="text-center p-2" style="vertical-align: middle; background: #fff3cd; border-left: 3px solid #e74a3b;">
                                    
                                    <input type="number" class="form-control calificacion-input-especial text-center" 
                                           data-alumno="${alumno.id_alumno}"
                                           data-evaluacion="${evalEspecial.id_evaluacion}"
                                           min="0" max="10" step="0.1" placeholder="Calif."
                                           style="width: 90px; margin: 0 auto; border: 3px solid #e74a3b; font-weight: bold;">
                                    <small class="d-block mt-2" style="color: #6f42c1; font-weight: bold; font-size: 0.75rem;">
                                        🎓 ${evalEspecial.nombre}
                                    </small>
                                    <small class="d-block text-danger mt-1" style="font-size: 0.65rem; font-weight: bold;">
                                        
                                    </small>
                                </td>`;
                        } else {
                            html += '<td class="text-center p-2 bg-light text-muted">-</td>';
                        }
                    } else {
                        let hayExtraordinarioReprobado = false;
                        datosMatriz.unidades.forEach(unidad => {
                            const key = `${alumno.id_alumno}_${unidad.id_unidad}`;
                            const califData = alumno.calificaciones[key];
                            if (califData && califData.calificacion !== null && califData
                                .calificacion < 7 && califData.tipo_evaluacion === 'Extraordinario'
                                ) {
                                hayExtraordinarioReprobado = true;
                            }
                        });

                        if (hayExtraordinarioReprobado && alumno.evaluacion_especial && !
                            reproboExtraordinario) {
                            const evalEspecial = alumno.evaluacion_especial;
                            html += `
                                <td class="text-center p-2" style="vertical-align: middle; background: #fff3cd; border-left: 3px solid #e74a3b;">
                                    <input type="number" class="form-control calificacion-input-especial text-center" 
                                           data-alumno="${alumno.id_alumno}"
                                           data-evaluacion="${evalEspecial.id_evaluacion}"
                                           min="0" max="10" step="0.1" placeholder="Calif."
                                           style="width: 90px; margin: 0 auto; border: 3px solid #e74a3b; font-weight: bold;">
                                    <small class="d-block mt-2" style="color: #6f42c1; font-weight: bold; font-size: 0.75rem;">
                                        🎓 ${evalEspecial.nombre}
                                    </small>
                                    <small class="d-block text-danger mt-1" style="font-size: 0.65rem; font-weight: bold;">
                                        📚 Examen de toda la materia
                                    </small>
                                </td>`;
                        } else {
                            html += '<td class="text-center p-2 bg-light text-muted">-</td>';
                        }
                    }

                    html += '</tr>';
                });

                $('#bodyMatriz').html(html);
                $('#totalAlumnos').text(datosMatriz.alumnos.length + ' alumnos');

                // Eventos para inputs
                $('.calificacion-input-matriz, .calificacion-input-especial').on('input', function() {
                    const valor = parseFloat($(this).val());
                    const esInvalido = $(this).val() && (valor < 0 || valor > 10 || isNaN(valor));
                    $(this).toggleClass('is-invalid', esInvalido);
                    validarGuardar();
                });

                validarGuardar();
            }

            // Validar guardar
            function validarGuardar() {
                const inputsValidos = $('.calificacion-input-matriz, .calificacion-input-especial').toArray().some(
                    input => {
                        return $(input).val() && !$(input).hasClass('is-invalid');
                    });
                $('#btnGuardarCalificaciones').prop('disabled', !inputsValidos);
            }

            // Limpiar
            $('#btnLimpiarTodo').on('click', function() {
                if (confirm('¿Limpiar calificaciones no guardadas?')) {
                    $('.calificacion-input-matriz, .calificacion-input-especial').val('').removeClass(
                        'is-invalid');
                    validarGuardar();
                }
            });

            // Guardar
            $('#btnGuardarCalificaciones').on('click', function(e) {
                e.preventDefault();

                const calificaciones = [];
                const calificacionesEspeciales = [];

                $('.calificacion-input-matriz').each(function() {
                    if ($(this).val() && !$(this).hasClass('is-invalid')) {
                        calificaciones.push({
                            id_alumno: parseInt($(this).data('alumno')),
                            id_unidad: parseInt($(this).data('unidad')),
                            id_evaluacion: parseInt($(this).data('evaluacion')),
                            calificacion: parseFloat($(this).val())
                        });
                    }
                });

                $('.calificacion-input-especial').each(function() {
                    if ($(this).val() && !$(this).hasClass('is-invalid')) {
                        calificacionesEspeciales.push({
                            id_alumno: parseInt($(this).data('alumno')),
                            id_evaluacion: parseInt($(this).data('evaluacion')),
                            calificacion_especial: parseFloat($(this).val())
                        });
                    }
                });

                if (calificaciones.length === 0 && calificacionesEspeciales.length === 0) {
                    alert('Ingresa al menos una calificación');
                    return;
                }

                const data = {
                    id_asignacion: $('#materiaCalificar').val(),
                    calificaciones: calificaciones,
                    calificaciones_especiales: calificacionesEspeciales
                };

                $('#calificacionesJsonInput').val(JSON.stringify(data));
                $(this).html('<i class="fas fa-spinner fa-spin mr-1"></i> Guardando...').prop('disabled',
                    true);
                $('#formCalificarGrupo').submit();
            });

            // Reset al cerrar modal
            $('#modalCalificar').on('hidden.bs.modal', function() {
                $('#formCalificarGrupo')[0].reset();
                $('#bodyMatriz').empty();
                $('#contenedorMatriz').hide();
                datosMatriz = {
                    alumnos: [],
                    unidades: []
                };
                $('#btnGuardarCalificaciones').prop('disabled', true).html(
                    '<i class="fas fa-save mr-1"></i> Guardar Calificaciones');
            });
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
