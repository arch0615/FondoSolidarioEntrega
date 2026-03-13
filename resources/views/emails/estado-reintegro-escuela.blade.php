<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado de Reintegro</title>
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
            background-color: #e8f4fd;
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
        }
        .info-table td {
            font-size: 14px;
        }
        .info-table tr:last-child td {
            border-bottom: none;
        }
        .link-button {
            display: inline-block;
            background: linear-gradient(135deg, #339966, #2a7d54);
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            margin: 20px 0;
            transition: background-color 0.3s;
        }
        .link-button:hover {
            background: linear-gradient(135deg, #2a7d54, #236446);
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
        .highlight {
            background-color: #fff3cd;
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <img src="{{ asset('images/LogoFondoBlanco.png') }}" alt="JAEC Logo" class="logo">
            <h1>Fondo Solidario JAEC</h1>
            <p>Sistema de Gestión de Reintegros</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="status">
                <h3>📣 Actualización del Estado del Reintegro</h3>
                <p>
                    @if(strtolower($resultado) == 'aprobación' || strtolower($resultado) == 'aprobado')
                        Su solicitud de reintegro ha sido <strong>APROBADA</strong>.
                    @elseif(strtolower($resultado) == 'rechazo' || strtolower($resultado) == 'rechazado')
                        Su solicitud de reintegro ha sido <strong>RECHAZADA</strong>.
                    @elseif(strtolower($resultado) == 'solicitud de información' || strtolower($resultado) == 'solicitud de informacion')
                        Se ha <strong>solicitado información adicional</strong> sobre su solicitud de reintegro.
                    @elseif(strtolower($resultado) == 'pago' || strtolower($resultado) == 'pagado')
                        Su solicitud de reintegro ha sido <strong>PAGADA</strong>.
                    @elseif(strtolower($resultado) == 'enviado a aseguradora')
                        Su solicitud de reintegro ha sido <strong>ENVIADA A LA COMPAÑÍA ASEGURADORA</strong>.
                    @else
                        Ha recibido un <strong>mensaje</strong> relativo a su solicitud de reintegro.
                    @endif
                </p>
            </div>

            @if(!empty($detalle))
            <div style="background-color:#fffdf6;padding:15px;border-radius:6px;margin-bottom:20px;border:1px solid #f5e6b8;">
                <strong>Detalle:</strong>
                <p style="margin:8px 0 0 0;">{!! nl2br(e($detalle)) !!}</p>
                @if(!empty($autorNombre))
                    <p style="margin:8px 0 0 0;font-size:13px;color:#555;"><em>Enviado por: {{ $autorNombre }}</em></p>
                @endif
            </div>
            @endif

            <h2 style="color: #339966; margin-bottom: 20px;">Detalles del Reintegro</h2>

            <table class="info-table">
                <tr>
                    <th>Número de Reintegro</th>
                    <td><span class="highlight">REI-{{ $reintegro->id_reintegro }}</span></td>
                </tr>
                <tr>
                    <th>Fecha de Solicitud</th>
                    <td>{{ optional($reintegro->fecha_solicitud) ? \Carbon\Carbon::parse($reintegro->fecha_solicitud)->format('d/m/Y') : 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Alumno</th>
                    <td>{{ $reintegro->alumno->nombre_completo ?? ($reintegro->alumno->nombre . ' ' . $reintegro->alumno->apellido ?? 'N/D') }}</td>
                </tr>
                <tr>
                    <th>Monto</th>
                    <td><strong>${{ number_format($reintegro->monto_solicitado ?? 0, 2) }}</strong></td>
                </tr>
            </table>

            <div style="background-color: #f0f9f4; padding: 20px; border-radius: 8px; margin: 20px 0;">
                <h3 style="color: #339966; margin: 0 0 10px 0;">📋 Información del Accidente Relacionado</h3>
                <p><strong>Expediente:</strong> {{ $reintegro->accidente->numero_expediente ?? 'N/D' }}</p>
                <p><strong>Fecha del Accidente:</strong> {{ $reintegro->accidente->fecha_accidente ? \Carbon\Carbon::parse($reintegro->accidente->fecha_accidente)->format('d/m/Y H:i') : 'N/A' }}</p>
                <p><strong>Descripción/Lugar:</strong> {{ $reintegro->accidente->descripcion_accidente ?? $reintegro->accidente->lugar_accidente ?? 'N/D' }}</p>
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <p>Para revisar esta solicitud y gestionar el reintegro, ingrese al sistema:</p>
                <a href="https://fondosolidario.jaeccba.org/" class="link-button">
                    🔗 Acceder al Sistema Fondo Solidario
                </a>
            </div>

        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Fondo Solidario JAEC</strong></p>
            <p>Sistema de Gestión de Accidentes y Reintegros</p>
            <p style="margin-top: 15px;">Este es un mensaje automático, por favor no responder a este correo.</p>
            <p>Para soporte técnico contactar al administrador del sistema.</p>
        </div>
    </div>
</body>
</html>