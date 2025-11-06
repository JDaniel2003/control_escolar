<!-- Custom fonts for this template-->
<link href="{{ asset('libs/fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css">
<link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

<!-- Custom styles for this template-->
<link href="{{ asset('libs/sbadmin/css/sb-admin-2.min.css') }}" rel="stylesheet">
<div class="container">
    <h1>Editar Plan de estudios</h1>

    <form action="{{ route('planes.update', $plane) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-2">
            <label>Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre', $plane->nombre) }}" class="form-control" required>
        </div>

        <div class="form-group mb-2">
            <label>Carrera</label>
            <select name="id_carrera" class="form-control">
                <option value="">Selecciona carrera</option>
                @foreach ($carreras as $carrera)
                    <option value="{{ $carrera->id_carrera }}" {{ old('id_carrera', $plane->id_carrera) == $carrera->id_carrera ? 'selected' : '' }}>
                        {{ $carrera->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('planes.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<!-- Bootstrap core JavaScript-->
<script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('libs/sbadmin/js/sb-admin-2.min.js') }}"></script>
