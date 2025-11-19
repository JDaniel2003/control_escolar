<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mis Asignaciones - Calificaciones</title>

    <!-- Custom fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"
        type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Bootstrap 4 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .unidad-header {
            min-width: 200px;
        }

        .alumno-cell,
        .matricula-cell,
        .nombre-cell {
            position: sticky;
            z-index: 10;
            background: white;
        }

        .alumno-cell {
            left: 0;
            min-width: 50px;
        }

        .matricula-cell {
            left: 50px;
            min-width: 120px;
        }

        .nombre-cell {
            left: 170px;
            min-width: 250px;
        }

        .is-invalid {
            border-color: #dc3545 !important;
        }
    </style>
</head>

<body class="bg-light">

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-chalkboard-teacher"></i> Mis Asignaciones
                        </h4>
                    </div>
                    <div class="card-body">
                        @if ($asignaciones->isEmpty())
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle fa-2x mb-3"></i>
                                <h5>No tienes asignaciones registradas</h5>
                                <p>Comunícate con el coordinador para asignarte materias.</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Materia</th>
                                            <th>Grupo</th>
                                            <th>Período</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($asignaciones as $asignacion)
                                            <tr>
                                                <td><strong>{{ $asignacion['materia'] }}</strong></td>
                                                <td>{{ $asignacion['grupo'] }}</td>
                                                <td>{{ $asignacion['periodo'] }}</td>
                                                <td class="text-center">
                                                    <button class="btn btn-success btn-sm calificar-btn"
                                                        data-id-asignacion="{{ $asignacion['id_asignacion'] }}"
                                                        data-id-grupo="{{ $asignacion['id_grupo'] }}"
                                                        data-id-periodo="{{ $asignacion['id_periodo'] }}"
                                                        data-materia="{{ $asignacion['materia'] }}"
                                                        data-grupo="{{ $asignacion['grupo'] }}">
                                                        <i class="fas fa-edit"></i> Calificar
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
    </div>

    <!-- Modal para calificar -->
    <div class="modal fade" id="modalCalificar" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-graduation-cap"></i>
                        <span id="tituloModal">Calificar Materia</span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formCalificarGrupo" method="POST" action="{{ route('calificaciones.guardar') }}">
                        @csrf
                        <input type="hidden" id="calificacionesJsonInput" name="calificaciones_json">

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Período</label>
                                <select id="periodoCalificar" class="form-control" disabled>
                                    <option value="">Selecciona período</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Grupo</label>
                                <select id="grupoCalificar" class="form-control" disabled>
                                    <option value="">Selecciona grupo</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Materia</label>
                                <select id="materiaCalificar" class="form-control" disabled>
                                    <option value="">Selecciona materia</option>
                                </select>
                            </div>
                        </div>

                        <div id="contenedorMatriz" style="display: none;">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                <span id="infoMateria">Cargando materia...</span>
                                <span class="float-right badge badge-pill badge-secondary" id="totalAlumnos">0
                                    alumnos</span>
                            </div>

                            <div class="table-responsive">
                                <table id="tablaCalificaciones" class="table table-bordered table-sm">
                                    <thead>
                                        <tr></tr>
                                    </thead>
                                    <tbody id="bodyMatriz">
                                        <tr>
                                            <td colspan="100" class="text-center py-4">
                                                <div class="spinner-border text-primary"></div>
                                                <br>Cargando alumnos...
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cerrar
                    </button>
                    <button type="button" class="btn btn-warning" id="btnLimpiarTodo">
                        <i class="fas fa-broom"></i> Limpiar
                    </button>
                    <button type="button" class="btn btn-primary" id="btnCargarMatriz">
                        <i class="fas fa-sync-alt"></i> Cargar Matriz
                    </button>
                    <button type="submit" class="btn btn-success" id="btnGuardarCalificaciones" disabled>
                        <i class="fas fa-save"></i> Guardar Calificaciones
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 4 JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Variables globales
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

            // Evento para botón "Calificar"
            document.addEventListener('click', function(e) {
                if (e.target.closest('.calificar-btn')) {
                    const btn = e.target.closest('.calificar-btn');
                    const datosModal = {
                        id_asignacion: btn.dataset.idAsignacion,
                        id_grupo: btn.dataset.idGrupo,
                        id_periodo: btn.dataset.idPeriodo,
                        materia: btn.dataset.materia,
                        grupo: btn.dataset.grupo
                    };

                    // Actualizar título
                    document.getElementById('tituloModal').textContent =
                        `Calificar: ${datosModal.materia} - ${datosModal.grupo}`;

                    // Llenar selects
                    document.getElementById('periodoCalificar').innerHTML =
                        `<option value="${datosModal.id_periodo}" selected>${datosModal.id_periodo}</option>`;
                    document.getElementById('grupoCalificar').innerHTML =
                        `<option value="${datosModal.id_grupo}" selected>${datosModal.grupo}</option>`;
                    document.getElementById('materiaCalificar').innerHTML =
                        `<option value="${datosModal.id_asignacion}" selected>${datosModal.materia}</option>`;

                    // Mostrar modal
                    $('#modalCalificar').modal('show');
                }
            });

            // Cargar matriz
            document.getElementById('btnCargarMatriz').addEventListener('click', function() {
                const idGrupo = document.getElementById('grupoCalificar').value;
                const idPeriodo = document.getElementById('periodoCalificar').value;
                const idAsignacion = document.getElementById('materiaCalificar').value;
                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                if (!idGrupo || !idPeriodo || !idAsignacion) {
                    alert('Faltan datos para cargar la matriz');
                    return;
                }

                const tbody = document.getElementById('bodyMatriz');
                tbody.innerHTML =
                    '<tr><td colspan="100" class="text-center py-4"><div class="spinner-border text-primary"></div><br>Cargando datos...</td></tr>';
                document.getElementById('contenedorMatriz').style.display = 'block';

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
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            datosMatriz.alumnos = data.alumnos;
                            datosMatriz.unidades = data.unidades;
                            renderMatriz();
                        } else {
                            tbody.innerHTML =
                                `<tr><td colspan="100" class="text-center text-danger">${data.message || 'Error desconocido'}</td></tr>`;
                        }
                    })
                    .catch(err => {
                        tbody.innerHTML =
                            `<tr><td colspan="100" class="text-center text-danger">Error: ${err.message}</td></tr>`;
                    });
            });

            // Renderizar matriz
            function renderMatriz() {
                if (datosMatriz.alumnos.length === 0) {
                    document.getElementById('bodyMatriz').innerHTML =
                        '<tr><td colspan="100" class="text-center text-muted py-4">No hay alumnos en este grupo</td></tr>';
                    return;
                }

                let headersUnidades = '';
                datosMatriz.unidades.forEach(unidad => {
                    headersUnidades += `<th class="unidad-header">${unidad.nombre}</th>`;
                });
                headersUnidades += `<th class="bg-info text-white">📊 Promedio</th>`;
                headersUnidades += `<th class="unidad-header bg-warning">🎓 Extraordinario Especial</th>`;

                document.querySelector('#tablaCalificaciones thead tr').innerHTML = `
            <th class="text-center">#</th>
            <th>Matrícula</th>
            <th>Alumno</th>
            ${headersUnidades}
        `;

                let html = '';
                datosMatriz.alumnos.forEach((alumno, indexAlumno) => {
                    html += `<tr>
                <td class="text-center alumno-cell">${indexAlumno + 1}</td>
                <td class="matricula-cell"><strong>${alumno.matricula}</strong></td>
                <td class="nombre-cell">${alumno.nombre}</td>`;

                    // Renderizar unidades
                    datosMatriz.unidades.forEach(unidad => {
                        const key = `${alumno.id_alumno}_${unidad.id_unidad}`;
                        const calificacionData = alumno.calificaciones[key];

                        if (!calificacionData) {
                            html += '<td class="text-center p-2">-</td>';
                            return;
                        }

                        const calificacion = calificacionData.calificacion;
                        const yaCapturado = calificacion !== null;
                        const esAprobatoria = calificacion >= 6;
                        const puedeCapturar = calificacionData.puede_capturar;
                        const siguienteEval = calificacionData.siguiente_evaluacion;

                        if (yaCapturado) {
                            const tipoEvaluacion = calificacionData.tipo_evaluacion || 'Ordinario';
                            const tipoKey = tipoEvaluacion.toLowerCase().replace('ó', 'o').replace(
                                'ú', 'u');
                            const tipoEval = tiposEvaluacion[tipoKey] || tiposEvaluacion[
                                'ordinario'];

                            if (puedeCapturar && siguienteEval) {
                                const siguienteTipoKey = siguienteEval.tipo.toLowerCase().replace(
                                    'ó', 'o').replace('ú', 'u');
                                const siguienteTipoInfo = tiposEvaluacion[siguienteTipoKey] ||
                                    tiposEvaluacion['ordinario'];

                                html += `
                        <td class="text-center p-2" style="vertical-align: middle;">
                            <div class="d-flex flex-column align-items-center">
                                <span class="badge mb-2" style="font-size: 0.9rem; padding: 0.4rem; background: ${esAprobatoria ? '#28a745' : '#dc3545'};">
                                    Actual: ${calificacion} ${tipoEval.icon}
                                </span>
                                <hr style="width: 100%; margin: 0.5rem 0; border-top: 1px dashed #ddd;">
                                <input type="number" class="form-control calificacion-input-matriz text-center mt-2" 
                                       data-alumno="${alumno.id_alumno}"
                                       data-unidad="${unidad.id_unidad}"
                                       data-evaluacion="${siguienteEval.id_evaluacion}"
                                       data-tipoeval="${siguienteTipoKey}"
                                       min="0" max="10" step="0.1" placeholder="Nueva calif."
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
                                <span class="badge mb-1" style="font-size: 1.1rem; padding: 0.5rem; background: ${esAprobatoria ? '#28a745' : '#dc3545'};">
                                    ${calificacion}
                                </span>
                                <small style="color: ${tipoEval.color};">
                                    ${tipoEval.icon} ${tipoEval.label}
                                </small>
                                ${esAprobatoria ? `
                                    <small class="text-success mt-1" style="font-size: 0.8rem;">✅ Aprobado</small>
                                    ` : `
                                    <small class="text-muted mt-1" style="font-size: 0.8rem;">Sin Oportunidades</small>
                                    `}
                            </div>
                        </td>`;
                            }
                        } else {
                            if (puedeCapturar && siguienteEval) {
                                const tipoKey = siguienteEval.tipo.toLowerCase().replace('ó', 'o')
                                    .replace('ú', 'u');
                                const tipoInfo = tiposEvaluacion[tipoKey] || tiposEvaluacion[
                                    'ordinario'];

                                html += `
                        <td class="text-center p-2" style="vertical-align: middle;">
                            <input type="number" class="form-control calificacion-input-matriz text-center" 
                                   data-alumno="${alumno.id_alumno}"
                                   data-unidad="${unidad.id_unidad}"
                                   data-evaluacion="${siguienteEval.id_evaluacion}"
                                   data-tipoeval="${tipoKey}"
                                   min="0" max="10" step="0.1" placeholder="0.0"
                                   style="width: 100px; margin: 0 auto;">
                            <small class="text-muted mt-1" style="color: ${tipoInfo.color};">
                                ${tipoInfo.icon} ${siguienteEval.tipo}
                            </small>
                        </td>`;
                            } else {
                                html += '<td class="text-center p-2 text-muted">Completado</td>';
                            }
                        }
                    });

                    // Promedio (ocultar si tiene calificación especial)
                    const tieneCalifEspecial = alumno.calificacion_especial !== null && alumno
                        .calificacion_especial !== undefined;
                    if (tieneCalifEspecial) {
                        html += '<td class="text-center p-2 bg-light text-muted">-</td>';
                    } else {
                        const promedioGeneral = alumno.promedio_general;
                        if (promedioGeneral !== null && !isNaN(promedioGeneral)) {
                            const esAprobado = promedioGeneral >= 6;
                            html += `
                    <td class="text-center p-2 bg-light" style="vertical-align: middle;">
                        <span class="badge" style="font-size: 1.2rem; padding: 0.6rem; background: ${esAprobado ? '#17a2b8' : '#6c757d'};">
                            ${promedioGeneral}
                        </span>
                        <small class="d-block mt-1 text-muted" style="font-size: 0.7rem;">
                            Promedio ${esAprobado ? '✅' : '⚠️'}
                        </small>
                    </td>`;
                        } else {
                            html += '<td class="text-center p-2 bg-light text-muted">Pendiente</td>';
                        }
                    }

                    // Extraordinario Especial
                    const tipoEvalEspecial = tiposEvaluacion['extraordinario_especial'] || {
                        icon: '🎓',
                        color: '#6f42c1',
                        label: 'Extraordinario Especial'
                    };
                    if (tieneCalifEspecial) {
                        const esAprob = alumno.calificacion_especial >= 6;
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
                            <small class="text-success mt-1"><i class="fas fa-check-circle"></i> Aprobado</small>
                            ` : `
                            <small class="text-danger mt-1"><i class="fas fa-times-circle"></i> Reprobado</small>
                            `}
                        <small class="text-muted mt-1" style="font-size: 0.7rem;">📚 Calificación general</small>
                    </div>
                </td>`;
                    } else {
                        let hayExtraordinarioReprobado = false;
                        datosMatriz.unidades.forEach(unidad => {
                            const key = `${alumno.id_alumno}_${unidad.id_unidad}`;
                            const califData = alumno.calificaciones[key];
                            if (califData && califData.calificacion !== null &&
                                califData.calificacion < 6 && califData.tipo_evaluacion ===
                                'Extraordinario') {
                                hayExtraordinarioReprobado = true;
                            }
                        });

                        if (hayExtraordinarioReprobado && alumno.evaluacion_especial) {
                            const evalEspecial = alumno.evaluacion_especial;
                            html += `
                    <td class="text-center p-2" style="vertical-align: middle; background: #fff3cd; border-left: 3px solid #dc3545;">
                        <input type="number" class="form-control calificacion-input-especial text-center" 
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
                            html += '<td class="text-center p-2 bg-light text-muted">-</td>';
                        }
                    }

                    html += '</tr>';
                });

                document.getElementById('bodyMatriz').innerHTML = html;
                document.getElementById('totalAlumnos').textContent = datosMatriz.alumnos.length;

                // Eventos para inputs
                document.querySelectorAll('.calificacion-input-matriz, .calificacion-input-especial').forEach(
                    input => {
                        input.addEventListener('input', function() {
                            const valor = parseFloat(this.value);
                            this.classList.toggle('is-invalid', this.value && (valor < 0 || valor >
                                10 || isNaN(valor)));
                            validarGuardar();
                        });
                    });

                validarGuardar();
            }

            // Validar guardar
            function validarGuardar() {
                const inputsValidos = Array.from(document.querySelectorAll(
                        '.calificacion-input-matriz, .calificacion-input-especial'))
                    .some(input => input.value && !input.classList.contains('is-invalid'));
                document.getElementById('btnGuardarCalificaciones').disabled = !inputsValidos;
            }

            // Limpiar
            document.getElementById('btnLimpiarTodo').addEventListener('click', function() {
                if (confirm('¿Limpiar calificaciones no guardadas?')) {
                    document.querySelectorAll('.calificacion-input-matriz, .calificacion-input-especial')
                        .forEach(input => {
                            input.value = '';
                            input.classList.remove('is-invalid');
                        });
                    validarGuardar();
                }
            });

            // Guardar
            document.getElementById('btnGuardarCalificaciones').addEventListener('click', function() {
                const calificaciones = [];
                const calificacionesEspeciales = [];

                document.querySelectorAll('.calificacion-input-matriz').forEach(input => {
                    if (input.value && !input.classList.contains('is-invalid')) {
                        calificaciones.push({
                            id_alumno: parseInt(input.dataset.alumno),
                            id_unidad: parseInt(input.dataset.unidad),
                            id_evaluacion: parseInt(input.dataset.evaluacion),
                            calificacion: parseFloat(input.value)
                        });
                    }
                });

                document.querySelectorAll('.calificacion-input-especial').forEach(input => {
                    if (input.value && !input.classList.contains('is-invalid')) {
                        calificacionesEspeciales.push({
                            id_alumno: parseInt(input.dataset.alumno),
                            id_evaluacion: parseInt(input.dataset.evaluacion),
                            calificacion_especial: parseFloat(input.value)
                        });
                    }
                });

                if (calificaciones.length === 0 && calificacionesEspeciales.length === 0) {
                    alert('Ingresa al menos una calificación');
                    return;
                }

                const data = {
                    id_asignacion: document.getElementById('materiaCalificar').value,
                    calificaciones: calificaciones,
                    calificaciones_especiales: calificacionesEspeciales
                };

                document.getElementById('calificacionesJsonInput').value = JSON.stringify(data);
                this.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Guardando...';
                this.disabled = true;
                document.getElementById('formCalificarGrupo').submit();
            });

            // Reset al cerrar modal
            $('#modalCalificar').on('hidden.bs.modal', function() {
                document.getElementById('formCalificarGrupo').reset();
                document.getElementById('bodyMatriz').innerHTML = '';
                document.getElementById('contenedorMatriz').style.display = 'none';
                datosMatriz = {
                    alumnos: [],
                    unidades: []
                };
                document.getElementById('btnGuardarCalificaciones').disabled = true;
                document.getElementById('btnGuardarCalificaciones').innerHTML =
                    '<i class="fas fa-save mr-1"></i> Guardar Calificaciones';
            });
        });
    </script>

</body>

</html>
