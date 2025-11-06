<!-- Custom fonts for this template-->
<link href="{{ asset('libs/fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css">
<link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

<!-- Custom styles for this template-->
<link href="{{ asset('libs/sbadmin/css/sb-admin-2.min.css') }}" rel="stylesheet">
@section('content')
    <div class="container">
    <h1>Nueva Carrera</h1>

    <form action="{{ route('carreras.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Duración</label>
            <input type="text" name="duracion" class="form-control">
        </div>

        <div class="form-group">
            <label>Datos (JSON opcional)</label>
            <textarea name="datos" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('carreras.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('libs/sbadmin/js/sb-admin-2.min.js') }}"></script>
