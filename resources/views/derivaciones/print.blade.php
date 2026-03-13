<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Derivación Médica - {{ $derivacion->alumno->nombre_completo }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Times+New+Roman&family=Roboto:wght@400;500;700&display=swap');
        body {
            font-family: 'Times New Roman', serif;
            background-color: #E5E7EB; /* Gris claro para el fondo fuera de la hoja */
        }
        .page {
            background: white;
            width: 21cm;
            height: 29.7cm;
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
        <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition-transform transform hover:scale-105">
            🖨️ Imprimir / Guardar como PDF
        </button>
        <button onclick="window.close()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition-transform transform hover:scale-105">
            Cerrar
        </button>
    </div>

    <div class="page">
        <!-- Encabezado con imagen -->
        <header class="mb-4">
            <div class="w-full mb-3">
                <img src="{{ asset('images/EncabezadoDerivacion.png') }}"
                     alt="Encabezado Derivación"
                     class="w-full h-auto object-contain"
                     style="max-height: 120px;">
            </div>
            <div class="text-center">
                <h1 class="text-xl font-bold text-black">AUTORIZACIÓN DE DERIVACIÓN MÉDICA</h1>
            </div>
        </header>

        <!-- Fecha -->
        <div class="text-right mb-4">
            <p class="text-sm">Fecha de Emisión: <span class="font-semibold">{{ now()->format('d/m/Y') }}</span></p>
        </div>

        <!-- Cuerpo -->
        <main class="text-sm leading-normal">
            <p class="mb-3">Por medio de la presente, la Dirección de la <strong>{{ $derivacion->accidente->escuela->nombre }}</strong>, autoriza la derivación para atención médica del alumno/a:</p>
            
            <div class="bg-gray-50 border border-gray-200 rounded-md p-3 mb-3">
                <p><strong>Nombre Completo:</strong> {{ $derivacion->alumno->nombre_completo }}</p>
                <p><strong>DNI:</strong> {{ $derivacion->alumno->dni }}</p>
            </div>

            <p class="mb-3">El/la mismo/a será trasladado/a a la institución <strong>{{ $derivacion->prestador->nombre }}</strong> en compañía de <strong>{{ $derivacion->acompanante }}</strong>, con fecha y hora de derivación <strong>{{ $derivacion->fecha_derivacion->format('d/m/Y') }} a las {{ \Carbon\Carbon::parse($derivacion->hora_derivacion)->format('H:i') }} hs.</strong></p>

            <p class="mb-3">El motivo de la derivación se debe a un accidente ocurrido en las instalaciones de la escuela, cuya descripción y diagnóstico presuntivo se detallan a continuación:</p>

            <div class="bg-gray-50 border border-gray-200 rounded-md p-3 mb-4">
                <p><strong>Descripción del Accidente:</strong> {{ $derivacion->accidente->descripcion_accidente }}</p>
                <p class="mt-1"><strong>Diagnóstico Inicial (Presuntivo):</strong> {{ $derivacion->diagnostico_inicial }}</p>
                @if($derivacion->observaciones)
                <p class="mt-1"><strong>Observaciones Adicionales:</strong> {{ $derivacion->observaciones }}</p>
                @endif
            </div>

            <p class="mb-6">Se extiende la presente para ser presentada ante quien corresponda.</p>
        </main>

        <!-- Pie de Página y Firmas -->
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