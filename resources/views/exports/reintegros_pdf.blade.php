<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte de Reintegros</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 4px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .header { text-align: center; margin-bottom: 20px; }
        .footer { margin-top: 20px; text-align: center; font-size: 9px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte de Reintegros</h1>
        <p>Sistema Fondo Solidario - Generado el: {{ date('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID Reintegro</th>
                <th>ID Accidente</th>
                <th>Alumno(s)</th>
                <th>Escuela</th>
                <th>Fecha Solicitud</th>
                <th>Monto Solicitado</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reintegros as $reintegro)
                <tr>
                    <td>{{ $reintegro->id_reintegro }}</td>
                    <td>{{ $reintegro->accidente->id_accidente_entero ?? 'N/A' }}</td>
                    <td>{{ export_clean($reintegro->alumno->nombre_completo ?? 'N/A') }}</td>
                    <td>{{ export_clean($reintegro->accidente->escuela->nombre ?? 'N/A') }}</td>
                    <td>{{ $reintegro->fecha_solicitud ? $reintegro->fecha_solicitud->format('d/m/Y') : '' }}</td>
                    <td>$ {{ number_format($reintegro->monto_solicitado, 2) }}</td>
                    <td>{{ export_clean($reintegro->estadoReintegro->descripcion ?? 'Sin Estado') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">No hay reintegros para mostrar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Total de registros: {{ count($reintegros) }}</p>
    </div>
</body>
</html>