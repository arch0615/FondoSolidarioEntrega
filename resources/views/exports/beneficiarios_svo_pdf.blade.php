<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte de Beneficiarios SVO</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 10px; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .header { text-align: center; margin-bottom: 20px; }
        .fecha { text-align: right; margin-bottom: 10px; font-size: 10px; }
        .footer { margin-top: 30px; text-align: center; font-size: 10px; color: #666; }
        @media print { body { margin: 0; } .no-print { display: none; } }
    </style>
</head>
<body>
    <div class="fecha">Generado el: {{ date('d/m/Y H:i') }}</div>
    <div class="header">
        <h1>Reporte de Beneficiarios SVO</h1>
        <p>Sistema de Fondo Solidario</p>
    </div>
    
    <div class="no-print" style="margin-bottom: 20px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
            🖨️ Imprimir / Guardar como PDF
        </button>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Empleado Titular</th>
                <th>DNI Empleado</th>
                <th>Escuela</th>
                <th>Beneficiario</th>
                <th>DNI Beneficiario</th>
                <th>Parentesco</th>
                <th>Porcentaje</th>
                <th>Estado</th>
                <th>Fecha de Alta</th>
            </tr>
        </thead>
        <tbody>
            @foreach($beneficiarios as $beneficiario)
                <tr>
                    <td>{{ $beneficiario->empleado->nombre_completo ?? 'N/A' }}</td>
                    <td>{{ $beneficiario->empleado->dni ?? 'N/A' }}</td>
                    <td>{{ $beneficiario->escuela->nombre ?? 'N/A' }}</td>
                    <td>{{ $beneficiario->nombre }} {{ $beneficiario->apellido }}</td>
                    <td>{{ $beneficiario->dni }}</td>
                    <td>{{ $beneficiario->parentesco->nombre_parentesco ?? 'N/A' }}</td>
                    <td>{{ $beneficiario->porcentaje }}%</td>
                    <td>{{ $beneficiario->activo ? 'Activo' : 'Inactivo' }}</td>
                    <td>{{ $beneficiario->fecha_alta ? $beneficiario->fecha_alta->format('d/m/Y') : 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>Total de registros: {{ count($beneficiarios) }}</p>
        <p>Sistema de Fondo Solidario - {{ date('Y') }}</p>
    </div>
</body>
</html>