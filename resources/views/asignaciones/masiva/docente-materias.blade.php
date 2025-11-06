<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Asignar Docente a Materias</title>
    <link href="{{ asset('libs/fontawesome/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('libs/sbadmin/img/up_logo.png') }}">
    <link href="{{ asset('libs/sbadmin/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <style>
        .asignacion-row {
            padding: 15px;
            margin-bottom: 10px;
            border: 2px solid #e3e6f0;
            border-radius: 8px;
            background: #f8f9fc;
            position: relative;
        }
        .remove-row {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            color: #e74a3b;
        }
        .add-row-btn {
            border: 2px dashed #4e73df;
            background: #f8f9fc;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .add-row-btn:hover {
            background: #e7f3ff;
            border-color: #2e59d9;
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
            Asignar Docente a Materias y Grupos
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

        <form action="{{ route('asignaciones.masiva.store-docente') }}" method="POST" id="formAsignacion">
            @csrf
            
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    
                    <!-- Sección 1: Selección de Docente y Período -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 bg-primary text-white">
                            <h6 class="m-0 font-weight-bold">
                                <i class="fas fa-user-tie"></i> Paso 1: Seleccione Docente y Período
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Docente <span class="text-danger">*</span></label>
                                        <select name="id_docente" id="docente" class="form-control" required>
                                            <option value="">-- Seleccione un docente --</option>
                                            @foreach($docentes as $docente)
                                                <option value="{{ $docente->id_usuario }}">{{ $docente->username }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
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

                    <!-- Sección 2: Asignaciones Materia-Grupo -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 bg-success text-white">
                            <h6 class="m-0 font-weight-bold">
                                <i class="fas fa-list"></i> Paso 2: Agregue Materias y Grupos
                            </h6>
                        </div>
                        <div class="card-body">
                            <div id="asignaciones-container">
                                <!-- Primera fila de asignación -->
                                <div class="asignacion-row" data-index="0">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Carrera <span class="text-danger">*</span></label>
                                                <select class="form-control carrera-select" data-index="0" required>
                                                    <option value="">-- Seleccione carrera --</option>
                                                    @foreach($carreras as $carrera)
                                                        <option value="{{ $carrera->id_carrera }}">{{ $carrera->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Materia <span class="text-danger">*</span></label>
                                                <select name="asignaciones[0][id_materia]" class="form-control materia-select" data-index="0" required>
                                                    <option value="">-- Primero seleccione carrera --</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Grupo <span class="text-danger">*</span></label>
                                                <select name="asignaciones[0][id_grupo]" class="form-control grupo-select" data-index="0" required>
                                                    <option value="">-- Primero seleccione carrera --</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Botón para agregar más asignaciones -->
                            <div class="add-row-btn" id="addRow">
                                <i class="fas fa-plus-circle fa-2x text-primary"></i>
                                <p class="mb-0 mt-2 font-weight-bold text-primary">Agregar otra materia/grupo</p>
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
            const materias = @json($materias);
            const grupos = @json($grupos);
            let rowIndex = 1;

            // Función para cargar materias según carrera
            function cargarMaterias(carreraId, selectIndex) {
                const materiaSelect = $(`.materia-select[data-index="${selectIndex}"]`);
                materiaSelect.html('<option value="">-- Seleccione materia --</option>');
                
                if (carreraId) {
                    const materiasFiltradas = materias.filter(m => m.id_carrera == carreraId);
                    materiasFiltradas.forEach(materia => {
                        materiaSelect.append(`<option value="${materia.id_materia}">${materia.nombre} (${materia.clave || 'Sin clave'})</option>`);
                    });
                }
            }

            // Función para cargar grupos según carrera
            function cargarGrupos(carreraId, selectIndex) {
                const grupoSelect = $(`.grupo-select[data-index="${selectIndex}"]`);
                grupoSelect.html('<option value="">-- Seleccione grupo --</option>');
                
                if (carreraId) {
                    const gruposFiltrados = grupos.filter(g => g.id_carrera == carreraId);
                    gruposFiltrados.forEach(grupo => {
                        grupoSelect.append(`<option value="${grupo.id_grupo}">${grupo.nombre}</option>`);
                    });
                }
            }

            // Evento cambio de carrera
            $(document).on('change', '.carrera-select', function() {
                const carreraId = $(this).val();
                const index = $(this).data('index');
                cargarMaterias(carreraId, index);
                cargarGrupos(carreraId, index);
            });

            // Agregar nueva fila
            $('#addRow').click(function() {
                const nuevaFila = `
                    <div class="asignacion-row" data-index="${rowIndex}">
                        <i class="fas fa-times remove-row" data-index="${rowIndex}"></i>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Carrera <span class="text-danger">*</span></label>
                                    <select class="form-control carrera-select" data-index="${rowIndex}" required>
                                        <option value="">-- Seleccione carrera --</option>
                                        @foreach($carreras as $carrera)
                                            <option value="{{ $carrera->id_carrera }}">{{ $carrera->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Materia <span class="text-danger">*</span></label>
                                    <select name="asignaciones[${rowIndex}][id_materia]" class="form-control materia-select" data-index="${rowIndex}" required>
                                        <option value="">-- Primero seleccione carrera --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Grupo <span class="text-danger">*</span></label>
                                    <select name="asignaciones[${rowIndex}][id_grupo]" class="form-control grupo-select" data-index="${rowIndex}" required>
                                        <option value="">-- Primero seleccione carrera --</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                $('#asignaciones-container').append(nuevaFila);
                rowIndex++;
            });

            // Eliminar fila
            $(document).on('click', '.remove-row', function() {
                const index = $(this).data('index');
                $(`.asignacion-row[data-index="${index}"]`).remove();
            });

            // Validar antes de enviar
            $('#formAsignacion').submit(function(e) {
                const filas = $('.asignacion-row').length;
                if (filas === 0) {
                    e.preventDefault();
                    alert('Debe agregar al menos una asignación');
                    return false;
                }
            });
        });
    </script>
</body>
</html>