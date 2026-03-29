<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accidente - Expediente {{ $accidente->numero_expediente ?? 'S/N' }}</title>
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
            @page {
                margin: 0.3cm;
                size: A4;
            }
        }
    </style>
</head>
<body>
    <div class="no-print my-4 text-center">
        <a href="{{ route('accidentes.pdf', $accidente->id_accidente) }}" target="_blank" class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow-md">
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
                <h1 class="text-xl font-bold text-black">INFORME DE ACCIDENTE ESCOLAR</h1>
                @if($accidente->numero_expediente)
                <p class="text-sm mt-1">Expediente N°: <strong>{{ $accidente->numero_expediente }}</strong></p>
                @endif
            </div>
        </header>

        <!-- Fecha de Emisión -->
        <div class="text-right mb-4">
            <p class="text-sm">Fecha de Emisión: <span class="font-semibold">{{ now()->format('d/m/Y') }}</span></p>
        </div>

        <!-- Cuerpo -->
        <main class="text-sm leading-normal">
            <p class="mb-4">Se informa el siguiente accidente registrado en la <strong>{{ $accidente->escuela->nombre ?? 'N/A' }}</strong>:</p>

            <!-- Datos del Accidente -->
            <div class="bg-gray-50 border border-gray-200 rounded-md p-4 mb-4">
                <h3 class="font-bold text-sm mb-2">Datos del Accidente</h3>
                <table class="w-full text-sm">
                    <tr>
                        <td class="font-semibold py-1 pr-4 w-1/3">Fecha:</td>
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
                            @if($accidente->hora_llamada)
                                - {{ \Carbon\Carbon::parse($accidente->hora_llamada)->format('H:i') }} hs
                            @endif
                            @if($accidente->servicio_emergencia)
                                - {{ $accidente->servicio_emergencia }}
                            @endif
                        </td>
                    </tr>
                    @endif
                </table>
            </div>

            <!-- Alumnos Involucrados -->
            @if($accidente->alumnos && $accidente->alumnos->count() > 0)
            <div class="bg-gray-50 border border-gray-200 rounded-md p-4 mb-4">
                <h3 class="font-bold text-sm mb-2">Alumnos Involucrados</h3>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-300">
                            <th class="text-left py-1 font-semibold">Nombre</th>
                            <th class="text-left py-1 font-semibold">DNI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($accidente->alumnos as $accidenteAlumno)
                        <tr class="border-b border-gray-100">
                            <td class="py-1">{{ $accidenteAlumno->alumno->apellido ?? '' }} {{ $accidenteAlumno->alumno->nombre ?? '' }}</td>
                            <td class="py-1">{{ $accidenteAlumno->alumno->dni ?? 'N/A' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            <!-- Descripción -->
            <div class="mb-4">
                <p class="font-semibold mb-1">Descripción del Accidente:</p>
                <div class="bg-gray-50 border border-gray-200 rounded-md p-3">
                    <p>{{ $accidente->descripcion_accidente }}</p>
                </div>
            </div>

            @if($archivos->count() > 0)
            <div class="mb-4">
                <p class="font-semibold mb-1">Archivos Adjuntos:</p>
                <ul class="list-disc list-inside text-sm">
                    @foreach($archivos as $archivo)
                        <li>{{ $archivo->nombre_archivo }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <p class="mb-6 mt-6">Se extiende el presente informe para ser presentado ante quien corresponda.</p>
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
