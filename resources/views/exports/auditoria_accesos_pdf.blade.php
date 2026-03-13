<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte de Accesos de Auditoría</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #dddddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Reporte de Accesos de Auditoría</h1>
    <table>
        <thead>
            <tr>
                <th>Fecha y Hora</th>
                <th>Usuario</th>
                <th>Acción</th>
                <th>IP</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($registros as $registro)
            <tr>
                <td>{{ $registro->fecha_hora->format('d/m/Y H:i:s') }}</td>
                <td>{{ $registro->usuario->nombre_completo ?? 'N/A' }}</td>
                <td>{{ $registro->accion }}</td>
                <td>{{ $registro->ip_usuario }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>