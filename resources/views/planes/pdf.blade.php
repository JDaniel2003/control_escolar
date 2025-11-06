<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Plan de Estudio {{ $plan->nombre }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; margin: 20px; }
        h2 { margin-bottom: 5px; }
        p { margin: 2px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: center; font-size: 11px; }
        th { background: #ddd; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Plan de Estudio {{ $plan->nombre }}</h2>
    <p><strong>Carrera:</strong> {{ $plan->carrera->nombre ?? 'N/A' }}</p>
    <p><strong>Vigencia:</strong> {{ $plan->vigencia ?? 'N/A' }}</p>

    @php
        $materiasPorPeriodo = $plan->materias->groupBy('id_numero_periodo');
        $maxMaterias = $materiasPorPeriodo->map->count()->max();
    @endphp

    <table>
        <thead>
            <tr>
                @foreach ($materiasPorPeriodo as $materias)
                    <th>
                        {{ $materias->first()->numeroPeriodo->tipoPeriodo->nombre ?? 'Periodo' }}
                        {{ $materias->first()->numeroPeriodo->numero ?? '' }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @for ($i = 0; $i < $maxMaterias; $i++)
                <tr>
                    @foreach ($materiasPorPeriodo as $materias)
                        <td>
                            @if (isset($materias[$i]))
                                <strong>{{ $materias[$i]->nombre }}</strong><br>
                                Horas: {{ $materias[$i]->horas ?? '-' }}<br>
                                Créditos: {{ $materias[$i]->creditos ?? '-' }}
                            @else
                                -
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endfor
        </tbody>
    </table>
</body>
</html>
