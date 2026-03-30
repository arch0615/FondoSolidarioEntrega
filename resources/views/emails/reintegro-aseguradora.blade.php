<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud de Reintegro</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #339966, #2a7d54);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .logo {
            max-width: 120px;
            height: auto;
            margin-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 14px;
            opacity: 0.9;
        }
        .content {
            padding: 30px 20px;
        }
        .status {
            background-color: #e0f2fe;
            border-left: 4px solid #0284c7;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .status h3 {
            margin: 0 0 10px 0;
            color: #0284c7;
            font-size: 16px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fafafa;
            border-radius: 8px;
            overflow: hidden;
        }
        .info-table th,
        .info-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        .info-table th {
            background-color: #339966;
            color: white;
            font-weight: bold;
            font-size: 14px;
            width: 40%;
        }
        .info-table td {
            font-size: 14px;
        }
        .info-table tr:last-child td {
            border-bottom: none;
        }
        .section-title {
            color: #339966;
            margin: 25px 0 15px 0;
            font-size: 16px;
            border-bottom: 2px solid #339966;
            padding-bottom: 5px;
        }
        .highlight {
            background-color: #fff3cd;
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: bold;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #eee;
        }
        .footer p {
            margin: 5px 0;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <img src="{{ asset('images/LogoFondoBlanco.png') }}" alt="JAEC Logo" class="logo">
            <h1>Fondo Solidario JAEC</h1>
            <p>Solicitud de Reintegro a Aseguradora</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="status">
                <h3>Solicitud de Reintegro</h3>
                <p>Se remite la siguiente solicitud de reintegro para su gesti&oacute;n y procesamiento.</p>
            </div>

            <!-- Datos del Reintegro -->
            <h2 class="section-title">Datos del Reintegro</h2>
            <table class="info-table">
                <tr>
                    <th>N&uacute;mero de Reintegro</th>
                    <td><span class="highlight">REI-{{ $reintegro->id_reintegro }}</span></td>
                </tr>
                <tr>
                    <th>Fecha de Solicitud</th>
                    <td>{{ $reintegro->fecha_solicitud ? \Carbon\Carbon::parse($reintegro->fecha_solicitud)->format('d/m/Y') : 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Monto Solicitado</th>
                    <td><strong>${{ number_format($reintegro->monto_solicitado ?? 0, 2) }}</strong></td>
                </tr>
                @if($reintegro->monto_autorizado)
                <tr>
                    <th>Monto Autorizado</th>
                    <td><strong>${{ number_format($reintegro->monto_autorizado, 2) }}</strong></td>
                </tr>
                @endif
                <tr>
                    <th>Tipo(s) de Gasto</th>
                    <td>{{ $reintegro->tiposGastos->pluck('descripcion')->join(', ') ?: $reintegro->descripcion_gasto ?? 'N/D' }}</td>
                </tr>
                @if($reintegro->fecha_autorizacion)
                <tr>
                    <th>Fecha de Autorizaci&oacute;n</th>
                    <td>{{ \Carbon\Carbon::parse($reintegro->fecha_autorizacion)->format('d/m/Y') }}</td>
                </tr>
                @endif
            </table>

            <!-- Datos del Alumno -->
            <h2 class="section-title">Datos del Alumno</h2>
            <table class="info-table">
                <tr>
                    <th>Nombre Completo</th>
                    <td>{{ $reintegro->alumno->nombre_completo ?? ($reintegro->alumno->apellido . ' ' . $reintegro->alumno->nombre) }}</td>
                </tr>
                <tr>
                    <th>DNI</th>
                    <td>{{ $reintegro->alumno->dni ?? 'N/D' }}</td>
                </tr>
            </table>

            <!-- Datos del Accidente -->
            <h2 class="section-title">Datos del Accidente</h2>
            <table class="info-table">
                <tr>
                    <th>N&uacute;mero de Expediente</th>
                    <td><span class="highlight">{{ $reintegro->accidente->numero_expediente ?? 'N/D' }}</span></td>
                </tr>
                <tr>
                    <th>Fecha del Accidente</th>
                    <td>{{ $reintegro->accidente->fecha_accidente ? \Carbon\Carbon::parse($reintegro->accidente->fecha_accidente)->format('d/m/Y') : 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Lugar</th>
                    <td>{{ $reintegro->accidente->lugar_accidente ?? 'N/D' }}</td>
                </tr>
                <tr>
                    <th>Tipo de Lesi&oacute;n</th>
                    <td>{{ $reintegro->accidente->tipo_lesion ?? 'N/D' }}</td>
                </tr>
                <tr>
                    <th>Descripci&oacute;n</th>
                    <td>{{ $reintegro->accidente->descripcion_accidente ?? 'N/D' }}</td>
                </tr>
            </table>

            <!-- Datos de la Escuela -->
            <h2 class="section-title">Escuela</h2>
            <table class="info-table">
                <tr>
                    <th>Nombre</th>
                    <td>{{ $reintegro->accidente->escuela->nombre ?? 'N/D' }}</td>
                </tr>
                @if($reintegro->accidente->escuela->direccion ?? null)
                <tr>
                    <th>Direcci&oacute;n</th>
                    <td>{{ $reintegro->accidente->escuela->direccion }}</td>
                </tr>
                @endif
            </table>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Fondo Solidario JAEC</strong></p>
            <p>Sistema de Gesti&oacute;n de Accidentes y Reintegros</p>
            <p style="margin-top: 15px;">Este es un mensaje autom&aacute;tico generado por el sistema.</p>
        </div>
    </div>
</body>
</html>
