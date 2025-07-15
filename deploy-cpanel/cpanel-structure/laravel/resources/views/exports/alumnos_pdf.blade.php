<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte de Alumnos</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 11px; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .header { text-align: center; margin-bottom: 20px; }
        .fecha { text-align: right; margin-bottom: 10px; font-size: 10px; }
        .footer { margin-top: 30px; text-align: center; font-size: 10px; color: #666; }
        @media print {
            body { margin: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="fecha">Generado el: {{ date('d/m/Y H:i') }}</div>
    <div class="header">
        <h1>Reporte de Alumnos</h1>
        <p>Sistema Fondo Solidario</p>
    </div>
    
    <div class="no-print" style="margin-bottom: 20px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
            🖨️ Imprimir / Guardar como PDF
        </button>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Apellido</th>
                <th>Nombre</th>
                <th>DNI</th>
                <th>CUIL</th>
                <th>Grado/Curso</th>
                <th>Escuela</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alumnos as $alumno)
                <tr>
                    <td>{{ $alumno->apellido }}</td>
                    <td>{{ $alumno->nombre }}</td>
                    <td>{{ $alumno->dni }}</td>
                    <td>{{ $alumno->cuil }}</td>
                    <td>{{ $alumno->sala_grado_curso }}</td>
                    <td>{{ $alumno->escuela->nombre ?? 'N/A' }}</td>
                    <td>{{ $alumno->activo ? 'Activo' : 'Inactivo' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>Total de registros: {{ count($alumnos) }}</p>
        <p>Sistema Fondo Solidario - {{ date('Y') }}</p>
    </div>
</body>
</html>