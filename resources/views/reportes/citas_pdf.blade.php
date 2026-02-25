<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Citas</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #4F46E5; padding-bottom: 10px; }
        .header h1 { margin: 0; color: #1F2937; }
        .header p { margin: 5px 0 0 0; color: #6B7280; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #4F46E5; color: white; padding: 10px; text-align: left; font-size: 11px; text-transform: uppercase; }
        td { padding: 10px; border-bottom: 1px solid #E5E7EB; }
        .estado-completada { color: #10B981; font-weight: bold; }
        .estado-confirmada { color: #3B82F6; font-weight: bold; }
        .estado-pendiente { color: #F59E0B; font-weight: bold; }
        .estado-cancelada { color: #EF4444; font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <h1>{{ auth()->user()->veterinaria->nombre ?? 'Reporte de Veterinaria' }}</h1>
        <p>Reporte de Citas Generado el: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
        <p>Total de citas en este reporte: <strong>{{ $citasParaExportar->count() }}</strong></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Fecha y Hora</th>
                <th>Cliente</th>
                <th>Mascotas</th>
                <th>Motivo</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($citasParaExportar as $cita)
            <tr>
                <td>{{ $cita->fecha_hora_inicio->format('d/m/Y') }}<br><strong>{{ $cita->fecha_hora_inicio->format('H:i') }}</strong></td>
                <td>{{ $cita->cliente->nombre }}<br><em>{{ $cita->cliente->telefono }}</em></td>
                <td>
                    @foreach($cita->mascotas as $mascota)
                        - {{ $mascota->nombre }} ({{ $mascota->especie }})<br>
                    @endforeach
                </td>
                <td>{{ $cita->motivo }}</td>
                <td class="estado-{{ strtolower($cita->estado) }}">
                    {{ strtoupper($cita->estado) }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>