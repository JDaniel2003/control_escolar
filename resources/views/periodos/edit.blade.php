<!-- Custom fonts for this template-->
<link href="{{ asset('libs/fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css">
<link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

<!-- Custom styles for this template-->
<link href="{{ asset('libs/sbadmin/css/sb-admin-2.min.css') }}" rel="stylesheet">
<div class="container" class="modal fade">
    <h1>Editar Período Escolar</h1>

    <form action="{{ route('periodos.update', Route::current()->parameter('id')) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nombre</label>
            <input type="text" placeholder="Ejemplo: JULIO-DICIEMBRE 2024" name="nombre" class="form-control"
                value="{{ $periodo->nombre }}" required>
            @error('nombre')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label>Tipo Período</label>
            <select name="id_tipo_periodo" class="form-control" required>
                <option value="">Tipo de período</option>
                @foreach ($tipos as $tipo)
                    <option value="{{ $tipo->id_tipo_periodo }}"
                        {{ old('id_tipo_periodo') == $tipo->id_tipo_periodo ? 'selected' : '' }}>
                        {{ $tipo->nombre }}
                    </option>
                @endforeach
            </select>

            @error('id_tipo_periodo')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label>Fecha Inicio</label>
            <input type="date" name="fecha_inicio" class="form-control" value="{{ $periodo->fecha_inicio }}"
                required>
            @error('fecha_inicio')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label>Fecha Fin</label>
            <input type="date" name="fecha_fin" class="form-control" value="{{ $periodo->fecha_fin }}" required>
            @error('fecha_fin')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label>Estado</label>
            <select name="estado" class="form-control" required>
                <option value="">Selecciona</option>
                <option value="Abierto" {{ old('estado') == 'Abierto' ? 'selected' : '' }}>Abierto
                </option>
                <option value="Cerrado" {{ old('estado') == 'Cerrado' ? 'selected' : '' }}>Cerrado
                </option>
            </select>
            @error('estado')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('periodos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<!-- Bootstrap core JavaScript-->
<script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('libs/sbadmin/js/sb-admin-2.min.js') }}"></script>
