<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte de Operaciones de Auditoría</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #dddddd; padding: 8px; text-align: left; font-size: 10px; }
        th { background-color: #f2f2f2; }
        .datos { max-width: 200px; word-wrap: break-word; }
    </style>
</head>
<body>
    <h1>Reporte de Operaciones de Auditoría</h1>
    <table>
        <thead>
            <tr>
                <th>Fecha y Hora</th>
                <th>Usuario</th>
                <th>Acción</th>
                <th>Tabla</th>
                <th>ID Reg.</th>
                <th class="datos">Datos Anteriores</th>
                <th class="datos">Datos Nuevos</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($registros as $registro)
            <tr>
                <td>{{ $registro->fecha_hora->format('d/m/Y H:i:s') }}</td>
                <td>{{ $registro->usuario->nombre_completo ?? 'N/A' }}</td>
                <td>{{ $registro->accion }}</td>
                <td>{{ $registro->tabla_afectada }}</td>
                <td>{{ $registro->id_registro }}</td>
                <td class="datos">{{ $registro->datos_anteriores }}</td>
                <td class="datos">{{ $registro->datos_nuevos }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>