<div class="container">
    <h2>Detalles del Plan de Estudio</h2>

    <div class="card">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $plane->id_plan_estudio }}</p>
            <p><strong>Nombre:</strong> {{ $plane->nombre }}</p>
            <p><strong>Carrera:</strong> {{ $plane->carrera->nombre ?? 'Sin asignar' }}</p>
            <p><strong>Datos:</strong> {{ $plane->datos }}</p>
        </div>
    </div>

    <a href="{{ route('planes.index') }}" class="btn btn-secondary mt-3">Volver</a>
</div>