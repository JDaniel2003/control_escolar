{{-- resources/views/historial/reinscripcion-masiva.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reinscripción Masiva</title>

    <link href="{{ asset('libs/fontawesome/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('libs/sbadmin/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #fff5f5 0%, #ffffff 50%, #fff5f5 100%);
            min-height: 100vh;
        }
        
        .header-banner {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            padding: 25px 0;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
        }
        
        .main-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        
        .main-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }
        
        .section-header {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            padding: 20px;
            color: white;
            border-radius: 15px 15px 0 0;
        }
        
        .section-header.success {
            background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
        }
        
        .section-header.warning {
            background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%);
        }
        
        .alumno-card {
            padding: 20px;
            margin-bottom: 15px;
            border: 2px solid #e3e6f0;
            border-radius: 12px;
            background: #ffffff;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .alumno-card:hover {
            border-color: #4e73df;
            box-shadow: 0 5px 15px rgba(78, 115, 223, 0.2);
            transform: translateX(5px);
        }
        
        .alumno-card.selected {
            background: linear-gradient(135deg, #e7f3ff 0%, #d4e9ff 100%);
            border-color: #4e73df;
            box-shadow: 0 5px 20px rgba(78, 115, 223, 0.3);
        }
        
        .checkbox-custom {
            width: 24px;
            height: 24px;
            cursor: pointer;
            accent-color: #4e73df;
        }
        
        .btn-gradient-primary {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-gradient-primary:hover {
            background: linear-gradient(135deg, #224abe 0%, #1a3a8f 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(78, 115, 223, 0.4);
        }
        
        .btn-gradient-success {
            background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
            border: none;
            color: white;
            padding: 15px 40px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }
        
        .btn-gradient-success:hover {
            background: linear-gradient(135deg, #13855c 0%, #0d5a3d 100%);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(28, 200, 138, 0.4);
        }
        
        .btn-gradient-danger {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            border: none;
            color: white;
        }
        
        .btn-gradient-danger:hover {
            background: linear-gradient(135deg, #c82333 0%, #a71d2a 100%);
        }
        
        .badge-status {
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .form-control-modern {
            border: 2px solid #e3e6f0;
            border-radius: 10px;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }
        
        .form-control-modern:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }
        
        .config-panel {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            border-radius: 15px;
            padding: 25px;
            color: white;
            box-shadow: 0 8px 25px rgba(220, 53, 69, 0.3);
            margin-bottom: 30px;
        }
        
        .stats-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        
        .stats-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #4e73df;
        }
        
        .empty-state {
            padding: 60px 20px;
            text-align: center;
            color: #858796;
        }
        
        .empty-state i {
            font-size: 5rem;
            opacity: 0.3;
            margin-bottom: 20px;
        }
        
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 0.8s linear infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        .select-all-badge {
            background: white;
            color: #1cc88a;
            padding: 8px 20px;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .select-all-badge:hover {
            background: #f8f9fc;
            transform: scale(1.05);
        }
        
        .matricula-badge {
            background: #4e73df;
            color: white;
            padding: 5px 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .promedio-badge {
            padding: 6px 15px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .promedio-excelente {
            background: #d4edda;
            color: #155724;
        }
        
        .promedio-bueno {
            background: #d1ecf1;
            color: #0c5460;
        }
        
        .promedio-regular {
            background: #fff3cd;
            color: #856404;
        }
    </style>
</head>

<body id="page-top">
    <!-- Header Banner -->
    <div class="header-banner">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center px-4">
                <h3 class="mb-0 text-white font-weight-bold">
                    <i class="fas fa-graduation-cap mr-2"></i>
                    SISTEMA DE CONTROL ESCOLAR
                </h3>
                <a href="{{ route('historial.index') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-arrow-left mr-2"></i>Volver al Historial
                </a>
            </div>
        </div>
    </div>

    <div class="container-fluid py-5 px-4">
        <!-- Título Principal -->
        <div class="text-center mb-5">
            <h1 class="display-4 font-weight-bold text-danger mb-2">
                <i class="fas fa-users-cog mr-3"></i>Reinscripción Masiva
            </h1>
            <p class="lead text-muted">Gestiona las reinscripciones de múltiples alumnos de forma eficiente</p>
        </div>

        <!-- Mensajes de Alerta -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle mr-2"></i>{{ session('error') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        <form id="formReinscripcionMasiva" method="POST" action="{{ route('historial.store-masivo') }}">
            @csrf

            <!-- PASO 1: Selección de Grupo y Período -->
            <div class="main-card card mb-4">
                <div class="section-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 font-weight-bold">
                            <i class="fas fa-filter mr-2"></i>PASO 1: Seleccionar Grupo y Período
                        </h4>
                        <span class="badge badge-light">Requerido</span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold text-dark mb-2">
                                <i class="fas fa-users text-primary mr-2"></i>Grupo Actual
                                <span class="text-danger">*</span>
                            </label>
                            <select name="id_grupo_actual" id="grupo_actual" class="form-control form-control-modern" required>
                                <option value="">-- Seleccione el grupo actual --</option>
                                @foreach($grupos as $grupo)
                                    <option value="{{ $grupo->id_grupo }}" 
                                            data-carrera="{{ $grupo->carrera->nombre ?? '' }}"
                                            data-turno="{{ $grupo->turno->nombre ?? '' }}">
                                        {{ $grupo->nombre }} - {{ $grupo->carrera->nombre ?? '' }} ({{ $grupo->turno->nombre ?? '' }})
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle mr-1"></i>Selecciona el grupo del que reinscribirás alumnos
                            </small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold text-dark mb-2">
                                <i class="fas fa-calendar-alt text-success mr-2"></i>Período Escolar Nuevo
                                <span class="text-danger">*</span>
                            </label>
                            <select name="id_periodo_escolar" id="periodo_escolar" class="form-control form-control-modern" required>
                                <option value="">-- Seleccione el nuevo período --</option>
                                @foreach($periodos as $periodo)
                                    <option value="{{ $periodo->id_periodo_escolar }}">
                                        {{ $periodo->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle mr-1"></i>Período al que se inscribirán los alumnos
                            </small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold text-dark mb-2">
                                <i class="fas fa-users text-warning mr-2"></i>Grupo Nuevo
                                <span class="text-danger">*</span>
                            </label>
                            <select name="id_grupo" id="grupo_nuevo" class="form-control form-control-modern" required>
                                <option value="">-- Seleccione el nuevo grupo --</option>
                                @foreach($grupos as $grupo)
                                    <option value="{{ $grupo->id_grupo }}">
                                        {{ $grupo->nombre }} - {{ $grupo->carrera->nombre ?? '' }} ({{ $grupo->turno->nombre ?? '' }})
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle mr-1"></i>Grupo al que serán asignados
                            </small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold text-dark mb-2">
                                <i class="fas fa-calendar-check text-info mr-2"></i>Fecha de Inscripción
                            </label>
                            <input type="date" 
                                   name="fecha_inscripcion" 
                                   id="fecha_inscripcion" 
                                   class="form-control form-control-modern" 
                                   value="{{ date('Y-m-d') }}">
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle mr-1"></i>Fecha por defecto: Hoy
                            </small>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="button" id="btnCargarAlumnos" class="btn btn-gradient-primary btn-lg">
                            <i class="fas fa-search mr-2"></i>Cargar Alumnos del Grupo
                        </button>
                    </div>
                </div>
            </div>

            <!-- Panel de Configuración Masiva -->
            <div id="panelConfiguracion" style="display: none;">
                <div class="config-panel">
                    <h4 class="font-weight-bold mb-4">
                        <i class="fas fa-sliders-h mr-2"></i>Configuración Masiva de Status
                    </h4>
                    <p class="mb-4">Aplica estos valores a todos los alumnos seleccionados</p>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="font-weight-bold mb-2">Status Inicio</label>
                            <select id="status_inicio_masivo" class="form-control form-control-modern">
                                <option value="">-- Seleccionar --</option>
                                @foreach($statusAcademicos as $status)
                                    <option value="{{ $status->id_status_academico }}">{{ $status->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="font-weight-bold mb-2">Status Terminación</label>
                            <select id="status_terminacion_masivo" class="form-control form-control-modern">
                                <option value="">-- Seleccionar --</option>
                                @foreach($statusAcademicos as $status)
                                    <option value="{{ $status->id_status_academico }}">{{ $status->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3 d-flex align-items-end">
                            <button type="button" id="btnAplicarMasivo" class="btn btn-light btn-block font-weight-bold">
                                <i class="fas fa-magic mr-2"></i>Aplicar a Seleccionados
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PASO 2: Lista de Alumnos -->
            <div class="main-card card mb-4" id="cardAlumnos" style="display: none;">
                <div class="section-header success">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 font-weight-bold">
                            <i class="fas fa-user-graduate mr-2"></i>PASO 2: Seleccionar y Configurar Alumnos
                        </h4>
                        <div class="select-all-badge" id="btnSelectAll">
                            <i class="fas fa-check-double mr-2"></i>
                            <span id="selectAllText">Seleccionar Todos</span>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <!-- Estadísticas -->
                    <div class="row mb-4" id="statsContainer" style="display: none;">
                        <div class="col-md-4 mb-3">
                            <div class="stats-card">
                                <div class="stats-number" id="totalAlumnos">0</div>
                                <div class="text-muted font-weight-bold">Total Alumnos</div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="stats-card">
                                <div class="stats-number text-success" id="alumnosSeleccionados">0</div>
                                <div class="text-muted font-weight-bold">Seleccionados</div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="stats-card">
                                <div class="stats-number text-warning" id="alumnosConfigurados">0</div>
                                <div class="text-muted font-weight-bold">Configurados</div>
                            </div>
                        </div>
                    </div>

                    <!-- Contenedor de Alumnos -->
                    <div id="alumnosContainer">
                        <div class="empty-state">
                            <i class="fas fa-users"></i>
                            <h5 class="font-weight-bold">Carga los alumnos del grupo</h5>
                            <p>Selecciona un grupo y período, luego haz clic en "Cargar Alumnos"</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botón de Guardar -->
            <div class="text-center mb-5" id="btnGuardarContainer" style="display: none;">
                <button type="submit" class="btn btn-gradient-success btn-lg shadow-lg">
                    <i class="fas fa-save mr-2"></i>Guardar Reinscripciones Masivas
                </button>
                <p class="text-muted mt-3">
                    <i class="fas fa-info-circle mr-1"></i>
                    Asegúrate de configurar el Status Inicio para todos los alumnos seleccionados
                </p>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <footer class="sticky-footer bg-white mt-5">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Copyright &copy; UPN 2025 - Sistema de Control Escolar</span>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            let alumnosData = [];
            let selectAllState = false;

            // Cargar alumnos del grupo
            $('#btnCargarAlumnos').click(function() {
                const grupoId = $('#grupo_actual').val();
                const periodoId = $('#periodo_escolar').val();

                if (!grupoId || !periodoId) {
                    alert('Por favor selecciona un grupo y un período');
                    return;
                }

                const btn = $(this);
                btn.prop('disabled', true).html('<span class="loading-spinner mr-2"></span>Cargando...');

                $.ajax({
                    url: "{{ route('historial.obtener-alumnos-grupo') }}",
                    method: 'POST',
                    data: {
                        id_grupo: grupoId,
                        id_periodo: periodoId,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success && response.alumnos.length > 0) {
                            alumnosData = response.alumnos.map(alumno => ({
                                ...alumno,
                                selected: false,
                                statusInicio: '',
                                statusTerminacion: ''
                            }));
                            renderAlumnos();
                            $('#cardAlumnos').slideDown();
                            $('#panelConfiguracion').slideDown();
                            $('#btnGuardarContainer').slideDown();
                            updateStats();
                        } else {
                            $('#alumnosContainer').html(
                                '<div class="empty-state">' +
                                '<i class="fas fa-exclamation-triangle text-warning"></i>' +
                                '<h5 class="font-weight-bold">No hay alumnos en este grupo</h5>' +
                                '<p>Intenta con otro grupo o período</p>' +
                                '</div>'
                            );
                            $('#cardAlumnos').slideDown();
                        }
                    },
                    error: function() {
                        alert('Error al cargar los alumnos. Por favor intenta nuevamente.');
                    },
                    complete: function() {
                        btn.prop('disabled', false).html('<i class="fas fa-search mr-2"></i>Cargar Alumnos del Grupo');
                    }
                });
            });

            // Renderizar alumnos
            function renderAlumnos() {
                let html = '';
                
                alumnosData.forEach((alumno, index) => {
                    const promedioClass = alumno.promedio >= 9 ? 'promedio-excelente' :
                                         alumno.promedio >= 8 ? 'promedio-bueno' : 'promedio-regular';
                    
                    html += `
                        <div class="alumno-card ${alumno.selected ? 'selected' : ''}" data-index="${index}">
                            <div class="row align-items-center">
                                <div class="col-md-1 text-center">
                                    <input type="checkbox" 
                                           class="checkbox-custom alumno-checkbox" 
                                           data-index="${index}"
                                           ${alumno.selected ? 'checked' : ''}>
                                </div>
                                <div class="col-md-5">
                                    <h6 class="font-weight-bold mb-2">${alumno.nombre}</h6>
                                    <span class="matricula-badge">${alumno.matricula}</span>
                                    <span class="promedio-badge ${promedioClass} ml-2">
                                        <i class="fas fa-star mr-1"></i>${alumno.promedio}
                                    </span>
                                </div>
                                <div class="col-md-3">
                                    <label class="small font-weight-bold mb-1">Status Inicio *</label>
                                    <select class="form-control form-control-sm status-inicio" 
                                            data-index="${index}"
                                            ${!alumno.selected ? 'disabled' : ''}>
                                        <option value="">-- Seleccionar --</option>
                                        @foreach($statusAcademicos as $status)
                                            <option value="{{ $status->id_status_academico }}" 
                                                    ${alumno.statusInicio == '{{ $status->id_status_academico }}' ? 'selected' : ''}>
                                                {{ $status->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="small font-weight-bold mb-1">Status Terminación</label>
                                    <select class="form-control form-control-sm status-terminacion" 
                                            data-index="${index}"
                                            ${!alumno.selected ? 'disabled' : ''}>
                                        <option value="">-- Seleccionar --</option>
                                        @foreach($statusAcademicos as $status)
                                            <option value="{{ $status->id_status_academico }}"
                                                    ${alumno.statusTerminacion == '{{ $status->id_status_academico }}' ? 'selected' : ''}>
                                                {{ $status->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    `;
                });

                $('#alumnosContainer').html(html);
                $('#statsContainer').show();
            }

            // Toggle alumno individual
            $(document).on('change', '.alumno-checkbox', function() {
                const index = $(this).data('index');
                alumnosData[index].selected = $(this).is(':checked');
                
                const card = $(this).closest('.alumno-card');
                card.toggleClass('selected', alumnosData[index].selected);
                
                card.find('.status-inicio, .status-terminacion').prop('disabled', !alumnosData[index].selected);
                
                updateStats();
            });

            // Seleccionar/Deseleccionar todos
            $('#btnSelectAll').click(function() {
                selectAllState = !selectAllState;
                alumnosData.forEach(alumno => alumno.selected = selectAllState);
                renderAlumnos();
                updateStats();
                
                $('#selectAllText').text(selectAllState ? 'Deseleccionar Todos' : 'Seleccionar Todos');
            });

            // Cambios en status
            $(document).on('change', '.status-inicio', function() {
                const index = $(this).data('index');
                alumnosData[index].statusInicio = $(this).val();
                updateStats();
            });

            $(document).on('change', '.status-terminacion', function() {
                const index = $(this).data('index');
                alumnosData[index].statusTerminacion = $(this).val();
            });

            // Aplicar configuración masiva
            $('#btnAplicarMasivo').click(function() {
                const statusInicio = $('#status_inicio_masivo').val();
                const statusTerminacion = $('#status_terminacion_masivo').val();

                if (!statusInicio && !statusTerminacion) {
                    alert('Selecciona al menos un status para aplicar');
                    return;
                }

                const seleccionados = alumnosData.filter(a => a.selected);
                if (seleccionados.length === 0) {
                    alert('Debes seleccionar al menos un alumno');
                    return;
                }

                alumnosData.forEach(alumno => {
                    if (alumno.selected) {
                        if (statusInicio) alumno.statusInicio = statusInicio;
                        if (statusTerminacion) alumno.statusTerminacion = statusTerminacion;
                    }
                });

                renderAlumnos();
                updateStats();
                
                // Limpiar selects
                $('#status_inicio_masivo, #status_terminacion_masivo').val('');
            });

            // Actualizar estadísticas
            function updateStats() {
                const total = alumnosData.length;
                const seleccionados = alumnosData.filter(a => a.selected).length;
                const configurados = alumnosData.filter(a => a.selected && a.statusInicio).length;

                $('#totalAlumnos').text(total);
                $('#alumnosSeleccionados').text(seleccionados);
                $('#alumnosConfigurados').text(configurados);
            }

            // Validación y envío del formulario
            $('#formReinscripcionMasiva').submit(function(e) {
                e.preventDefault();

                const seleccionados = alumnosData.filter(a => a.selected);
                
                if (seleccionados.length === 0) {
                    alert('⚠️ Debes seleccionar al menos un alumno para reinscribir');
                    return false;
                }

                const sinStatus = seleccionados.filter(a => !a.statusInicio);
                if (sinStatus.length > 0) {
                    alert(`⚠️ Hay ${sinStatus.length} alumno(s) seleccionado(s) sin Status Inicio.\nTodos los alumnos seleccionados deben tener Status Inicio.`);
                    return false;
                }

                // Preparar datos para enviar
                const formData = new FormData(this);
                
                // Agregar alumnos seleccionados
                seleccionados.forEach((alumno, idx) => {
                    formData.append(`alumnos[${idx}][id_alumno]`, alumno.id);
                    formData.append(`alumnos[${idx}][id_status_inicio]`, alumno.statusInicio);
                    if (alumno.statusTerminacion) {
                        formData.append(`alumnos[${idx}][id_status_terminacion]`, alumno.statusTerminacion);
                    }
                    formData.append(`alumnos[${idx}][fecha_inscripcion]`, $('#fecha_inscripcion').val());
                });

                const btnSubmit = $(this).find('button[type="submit"]');
                btnSubmit.prop('disabled', true).html('<span class="loading-spinner mr-2"></span>Guardando...');

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            alert(`✅ ${response.message}\n\nReinscripciones creadas: ${response.reinscripciones}`);
                            window.location.href = "{{ route('historial.index') }}";
                        } else {
                            alert('❌ ' + (response.message || 'Error al guardar las reinscripciones'));
                            btnSubmit.prop('disabled', false).html('<i class="fas fa-save mr-2"></i>Guardar Reinscripciones Masivas');
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = 'Error al procesar la solicitud';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        alert('❌ ' + errorMsg);
                        btnSubmit.prop('disabled', false).html('<i class="fas fa-save mr-2"></i>Guardar Reinscripciones Masivas');
                    }
                });
            });

            // Click en card para seleccionar
            $(document).on('click', '.alumno-card', function(e) {
                if (!$(e.target).is('select, input, option')) {
                    const checkbox = $(this).find('.alumno-checkbox');
                    checkbox.prop('checked', !checkbox.prop('checked')).trigger('change');
                }
            });
        });
    </script>
</body>
</html>