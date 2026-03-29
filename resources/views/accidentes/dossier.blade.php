<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expediente Completo - {{ $accidente->numero_expediente ?? 'S/N' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            background-color: #E5E7EB;
        }
        .page {
            background: white;
            width: 21cm;
            min-height: 29.7cm;
            display: block;
            margin: 0 auto;
            margin-bottom: 0.5cm;
            box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
            padding: 1cm;
            box-sizing: border-box;
        }
        @media print {
            body, .page {
                margin: 0;
                box-shadow: none;
                background: white;
            }
            .no-print {
                display: none;
            }
            .page-break {
                page-break-before: always;
            }
            @page {
                margin: 0.3cm;
                size: A4;
            }
        }
    </style>
</head>
<body>
    <div class="no-print my-4 text-center">
        <a href="{{ route('accidentes.dossier.pdf', $accidente->id_accidente) }}" target="_blank" class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow-md">
            Descargar PDF
        </a>
        <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md">
            Imprimir / Guardar como PDF
        </button>
        <button onclick="window.close()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg shadow-md">
            Cerrar
        </button>
    </div>

    <div class="page">
        <!-- Encabezado -->
        <header class="mb-6">
            @if(file_exists(public_path('images/EncabezadoDerivacion.png')))
            <div class="w-full mb-3">
                <img src="{{ asset('images/EncabezadoDerivacion.png') }}"
                     alt="Encabezado"
                     class="w-full h-auto object-contain"
                     style="max-height: 120px;">
            </div>
            @endif
            <div class="text-center">
                <h1 class="text-xl font-bold text-black">EXPEDIENTE DE SINIESTRO</h1>
                @if($accidente->numero_expediente)
                <p class="text-sm mt-1">N° Expediente: <strong>{{ $accidente->numero_expediente }}</strong></p>
                @endif
            </div>
        </header>

        <div class="text-right mb-4">
            <p class="text-sm">Fecha de Emisión: <span class="font-semibold">{{ now()->format('d/m/Y') }}</span></p>
        </div>

        <main class="text-sm leading-normal">
            <!-- 1. DATOS DEL ACCIDENTE -->
            <h2 class="text-base font-bold border-b-2 border-black pb-1 mb-3">1. DATOS DEL ACCIDENTE</h2>
            <div class="bg-gray-50 border border-gray-200 rounded-md p-4 mb-4">
                <table class="w-full text-sm">
                    <tr>
                        <td class="font-semibold py-1 pr-4 w-1/3">Escuela:</td>
                        <td class="py-1">{{ $accidente->escuela->nombre ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-1 pr-4">Fecha:</td>
                        <td class="py-1">{{ $accidente->fecha_accidente ? $accidente->fecha_accidente->format('d/m/Y') : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-1 pr-4">Hora:</td>
                        <td class="py-1">{{ $accidente->hora_accidente ? \Carbon\Carbon::parse($accidente->hora_accidente)->format('H:i') : 'N/A' }} hs</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-1 pr-4">Lugar:</td>
                        <td class="py-1">{{ $accidente->lugar_accidente }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-1 pr-4">Tipo de Lesión:</td>
                        <td class="py-1">{{ $accidente->tipo_lesion }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-1 pr-4">Estado:</td>
                        <td class="py-1">{{ $accidente->estado->nombre_estado ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-1 pr-4">Protocolo Activado:</td>
                        <td class="py-1">{{ $accidente->protocolo_activado ? 'Sí' : 'No' }}</td>
                    </tr>
                    @if($accidente->llamada_emergencia)
                    <tr>
                        <td class="font-semibold py-1 pr-4">Llamada de Emergencia:</td>
                        <td class="py-1">
                            Sí
                            @if($accidente->hora_llamada) - {{ \Carbon\Carbon::parse($accidente->hora_llamada)->format('H:i') }} hs @endif
                            @if($accidente->servicio_emergencia) - {{ $accidente->servicio_emergencia }} @endif
                        </td>
                    </tr>
                    @endif
                </table>
            </div>

            <div class="mb-4">
                <p class="font-semibold mb-1">Descripción del Accidente:</p>
                <div class="bg-gray-50 border border-gray-200 rounded-md p-3">
                    <p>{{ $accidente->descripcion_accidente }}</p>
                </div>
            </div>

            <!-- Alumnos -->
            @if($accidente->alumnos && $accidente->alumnos->count() > 0)
            <h2 class="text-base font-bold border-b-2 border-black pb-1 mb-3 mt-6">2. ALUMNOS INVOLUCRADOS</h2>
            <table class="w-full text-sm border border-gray-200 mb-4">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left py-2 px-3 border-b font-semibold">Nombre Completo</th>
                        <th class="text-left py-2 px-3 border-b font-semibold">DNI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($accidente->alumnos as $accidenteAlumno)
                    <tr class="border-b border-gray-100">
                        <td class="py-2 px-3">{{ $accidenteAlumno->alumno->apellido ?? '' }} {{ $accidenteAlumno->alumno->nombre ?? '' }}</td>
                        <td class="py-2 px-3">{{ $accidenteAlumno->alumno->dni ?? 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif

            <!-- 3. DERIVACIONES -->
            @if($accidente->derivaciones && $accidente->derivaciones->count() > 0)
            <h2 class="text-base font-bold border-b-2 border-black pb-1 mb-3 mt-6">3. DERIVACIONES MÉDICAS</h2>
            @foreach($accidente->derivaciones as $i => $derivacion)
            <div class="bg-gray-50 border border-gray-200 rounded-md p-4 mb-3">
                <p class="font-bold text-sm mb-2">Derivación #{{ $i + 1 }}</p>
                <table class="w-full text-sm">
                    <tr>
                        <td class="font-semibold py-1 pr-4 w-1/3">Alumno:</td>
                        <td class="py-1">{{ $derivacion->alumno->apellido ?? '' }} {{ $derivacion->alumno->nombre ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-1 pr-4">Fecha:</td>
                        <td class="py-1">{{ $derivacion->fecha_derivacion ? $derivacion->fecha_derivacion->format('d/m/Y') : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-1 pr-4">Hora:</td>
                        <td class="py-1">{{ $derivacion->hora_derivacion ? \Carbon\Carbon::parse($derivacion->hora_derivacion)->format('H:i') : 'N/A' }} hs</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-1 pr-4">Prestador:</td>
                        <td class="py-1">{{ $derivacion->prestador->nombre ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-1 pr-4">Diagnóstico Inicial:</td>
                        <td class="py-1">{{ $derivacion->diagnostico_inicial }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-1 pr-4">Acompañante:</td>
                        <td class="py-1">{{ $derivacion->acompanante }}</td>
                    </tr>
                    @if($derivacion->observaciones)
                    <tr>
                        <td class="font-semibold py-1 pr-4">Observaciones:</td>
                        <td class="py-1">{{ $derivacion->observaciones }}</td>
                    </tr>
                    @endif
                </table>
            </div>
            @endforeach
            @endif

            <!-- 4. REINTEGROS -->
            @if($accidente->reintegros && $accidente->reintegros->count() > 0)
            <h2 class="text-base font-bold border-b-2 border-black pb-1 mb-3 mt-6">{{ $accidente->derivaciones && $accidente->derivaciones->count() > 0 ? '4' : '3' }}. SOLICITUDES DE REINTEGRO</h2>
            @foreach($accidente->reintegros as $i => $reintegro)
            <div class="bg-gray-50 border border-gray-200 rounded-md p-4 mb-3">
                <p class="font-bold text-sm mb-2">Reintegro #{{ $i + 1 }}</p>
                <table class="w-full text-sm">
                    <tr>
                        <td class="font-semibold py-1 pr-4 w-1/3">Alumno:</td>
                        <td class="py-1">{{ $reintegro->alumno->apellido ?? '' }} {{ $reintegro->alumno->nombre ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-1 pr-4">Fecha Solicitud:</td>
                        <td class="py-1">{{ $reintegro->fecha_solicitud ? $reintegro->fecha_solicitud->format('d/m/Y') : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-1 pr-4">Tipo de Gasto:</td>
                        <td class="py-1">{{ $reintegro->tiposGastos->pluck('descripcion')->join(', ') ?: $reintegro->descripcion_gasto }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-1 pr-4">Monto Solicitado:</td>
                        <td class="py-1">${{ number_format($reintegro->monto_solicitado, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-1 pr-4">Estado:</td>
                        <td class="py-1">
                            <span class="font-semibold">{{ $reintegro->estadoReintegro->descripcion ?? $reintegro->estadoReintegro->nombre_estado ?? 'N/A' }}</span>
                        </td>
                    </tr>
                    @if($reintegro->monto_autorizado)
                    <tr>
                        <td class="font-semibold py-1 pr-4">Monto Autorizado:</td>
                        <td class="py-1">${{ number_format($reintegro->monto_autorizado, 2) }}</td>
                    </tr>
                    @endif
                    @if($reintegro->observaciones_auditor)
                    <tr>
                        <td class="font-semibold py-1 pr-4">Observaciones Auditor:</td>
                        <td class="py-1">{{ $reintegro->observaciones_auditor }}</td>
                    </tr>
                    @endif
                    @if($reintegro->fecha_pago)
                    <tr>
                        <td class="font-semibold py-1 pr-4">Fecha de Pago:</td>
                        <td class="py-1">{{ $reintegro->fecha_pago->format('d/m/Y') }}</td>
                    </tr>
                    @endif
                    @if($reintegro->numero_transferencia)
                    <tr>
                        <td class="font-semibold py-1 pr-4">N° Transferencia:</td>
                        <td class="py-1">{{ $reintegro->numero_transferencia }}</td>
                    </tr>
                    @endif
                </table>
            </div>
            @endforeach
            @endif

            <!-- Archivos adjuntos -->
            @if($archivos->count() > 0)
            <h2 class="text-base font-bold border-b-2 border-black pb-1 mb-3 mt-6">ARCHIVOS ADJUNTOS</h2>
            <ul class="list-disc list-inside text-sm mb-4">
                @foreach($archivos as $archivo)
                    <li>{{ $archivo->nombre_archivo }} ({{ $archivo->tamano_formateado }})</li>
                @endforeach
            </ul>
            @endif
        </main>

        <!-- Firmas -->
        <footer class="mt-16 grid grid-cols-2 gap-16 text-center">
            <div class="border-t border-gray-400 pt-2">
                <p class="text-xs">Firma del Personal Autorizado</p>
            </div>
            <div class="border-t border-gray-400 pt-2">
                <p class="text-xs">Sello de la Institución</p>
            </div>
        </footer>
    </div>
</body>
</html>
