<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Asignar Materias a Grupo</title>
    <link href="{{ asset('libs/fontawesome/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('libs/sbadmin/img/up_logo.png') }}">
    <link href="{{ asset('libs/sbadmin/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <style>
        .materia-item {
            padding: 15px;
            margin-bottom: 10px;
            border: 2px solid #e3e6f0;
            border-radius: 8px;
            background: #f8f9fc;
            transition: all 0.3s;
        }
        .materia-item:hover {
            border-color: #4e73df;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .materia-item.selected {
            background: #e7f3ff;
            border-color: #4e73df;
        }
        .select-all-btn {
            cursor: pointer;
        }
    </style>
</head>
<body id="page-top">

    <div class="bg-danger text-white1 text-center py-2">
        <div class="d-flex justify-content-between align-items-center px-4">
            <h4 class="mb-0">SISTEMA DE CONTROL ESCOLAR</h4>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dangerb">
        <div class="d-flex align-items-center">
            <div style="width: 300px; height: 120px;">
                <img src="{{ asset('libs/sbadmin/img/upn.png') }}" alt="Logo" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
        </div>
        <div class="collapse navbar-collapse ml-4">
            <ul class="navbar-nav" style="padding-left: 20%;">
                <li class="nav-item">
                    <a class="nav-link text-white px-3 mr-1" href="{{ route('admin') }}">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link navbar-active-item px-3 mr-1">Asignaciones Docentes</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container-fluid py-5">
        <div class="row mb-4">
            <div class="col-12">
                <a href="{{ route('asignaciones.masiva.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>

        <h1 class="text-danger text-center mb-5" style="font-size: 2.5rem; font-family: 'Arial Black', Verdana, sans-serif; font-weight: bold;">
            Asignar Materias a Grupo
        </h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('asignaciones.masiva.store-materias') }}" method="POST" id="formAsignacion">
            @csrf
            
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    
                    <!-- Sección 1: Selección de Grupo y Período -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 bg-primary text-white">
                            <h6 class="m-0 font-weight-bold">
                                <i class="fas fa-users"></i> Paso 1: Seleccione Grupo y Período
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Carrera <span class="text-danger">*</span></label>
                                        <select id="carrera" class="form-control" required>
                                            <option value="">-- Seleccione una carrera --</option>
                                            @foreach($carreras as $carrera)
                                                <option value="{{ $carrera->id_carrera }}">{{ $carrera->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Grupo <span class="text-danger">*</span></label>
                                        <select name="id_grupo" id="grupo" class="form-control" required>
                                            <option value="">-- Primero seleccione carrera --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Período Escolar <span class="text-danger">*</span></label>
                                        <select name="id_periodo_escolar" class="form-control" required>
                                            <option value="">-- Seleccione período --</option>
                                            @foreach($periodos as $periodo)
                                                <option value="{{ $periodo->id_periodo_escolar }}">{{ $periodo->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección 2: Selección de Materias -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 bg-success text-white d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold">
                                <i class="fas fa-book"></i> Paso 2: Seleccione Materias
                            </h6>
                            <button type="button" class="btn btn-sm btn-light select-all-btn" id="selectAll">
                                <i class="fas fa-check-square"></i> Seleccionar Todas
                            </button>
                        </div>
                        <div class="card-body">
                            <div id="materias-container">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> Seleccione primero una carrera para ver las materias disponibles
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botón de Guardar -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save"></i> Guardar Asignaciones
                        </button>
                    </div>

                </div>
            </div>
        </form>
    </div>

    <footer class="sticky-footer bg-white mt-5">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Copyright &copy; Tu Web 2025</span>
            </div>
        </div>
    </footer>

    <script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            const grupos = @json($grupos);
            const docentes = @json($docentes);

            // Filtrar grupos por carrera
            $('#carrera').change(function() {
                const carreraId = $(this).val();
                const grupoSelect = $('#grupo');
                grupoSelect.html('<option value="">-- Seleccione un grupo --</option>');
                
                if (carreraId) {
                    const gruposFiltrados = grupos.filter(g => g.id_carrera == carreraId);
                    gruposFiltrados.forEach(grupo => {
                        grupoSelect.append(`<option value="${grupo.id_grupo}">${grupo.nombre}</option>`);
                    });

                    // Cargar materias de la carrera
                    cargarMaterias(carreraId);
                } else {
                    $('#materias-container').html('<div class="alert alert-info"><i class="fas fa-info-circle"></i> Seleccione una carrera</div>');
                }
            });

            // Cargar materias por AJAX
            function cargarMaterias(carreraId) {
                $.ajax({
                    url: `/asignaciones/masiva/materias-carrera/${carreraId}`,
                    method: 'GET',
                    success: function(materias) {
                        let html = '';
                        
                        if (materias.length === 0) {
                            html = '<div class="alert alert-warning"><i class="fas fa-exclamation-triangle"></i> No hay materias para esta carrera</div>';
                        } else {
                            materias.forEach((materia, index) => {
                                html += `
                                    <div class="materia-item">
                                        <div class="row align-items-center">
                                            <div class="col-md-1 text-center">
                                                <input type="checkbox" name="materias[]" value="${materia.id_materia}" 
                                                       class="form-check-input materia-checkbox" style="width: 20px; height: 20px;">
                                            </div>
                                            <div class="col-md-5">
                                                <strong>${materia.nombre}</strong><br>
                                                <small class="text-muted">Clave: ${materia.clave || 'N/A'}</small>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="small mb-1">Docente (opcional)</label>
                                                <select name="docentes[${index}]" class="form-control form-control-sm">
                                                    <option value="">-- Sin asignar --</option>
                                                    ${docentes.map(d => `<option value="${d.id_usuario}">${d.username}</option>`).join('')}
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            });
                        }
                        
                        $('#materias-container').html(html);
                    },
                    error: function() {
                        $('#materias-container').html('<div class="alert alert-danger"><i class="fas fa-times-circle"></i> Error al cargar materias</div>');
                    }
                });
            }

            // Seleccionar/Deseleccionar todas
            $('#selectAll').click(function() {
                const checkboxes = $('.materia-checkbox');
                const allChecked = checkboxes.filter(':checked').length === checkboxes.length;
                checkboxes.prop('checked', !allChecked);
                checkboxes.closest('.materia-item').toggleClass('selected', !allChecked);
                $(this).html(allChecked ? 
                    '<i class="fas fa-check-square"></i> Seleccionar Todas' : 
                    '<i class="fas fa-square"></i> Deseleccionar Todas');
            });

            // Marcar visualmente items seleccionados
            $(document).on('change', '.materia-checkbox', function() {
                $(this).closest('.materia-item').toggleClass('selected', $(this).is(':checked'));
            });

            // Validar antes de enviar
            $('#formAsignacion').submit(function(e) {
                const materiasSeleccionadas = $('.materia-checkbox:checked').length;
                if (materiasSeleccionadas === 0) {
                    e.preventDefault();
                    alert('Debe seleccionar al menos una materia');
                    return false;
                }
            });
        });
    </script>
</body>
</html>