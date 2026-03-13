<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Beneficiarios SVO - {{ $empleado->nombre_completo }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Times+New+Roman&family=Roboto:wght@400;500;700&display=swap');
        body {
            font-family: 'Times New Roman', serif;
            background-color: #E5E7EB;
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
            🖨️ Imprimir Documento
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
                      alt="Encabezado"
                      class="w-full h-auto object-contain"
                      style="max-height: 120px;">
            </div>
            <div class="text-center">
                <h1 class="text-xl font-bold text-black">REGISTRO DE BENEFICIARIOS SVO</h1>
                <p class="text-sm text-gray-600 mt-1">Documento para archivo escolar</p>
            </div>
        </header>

        <!-- Fecha -->
        <div class="text-right mb-4">
            <p class="text-sm">Fecha de Emisión: <span class="font-semibold">{{ now()->format('d/m/Y') }}</span></p>
        </div>

        <!-- Cuerpo -->
        <main class="text-sm leading-normal">
            <p class="mb-3">A continuación se detalla la información del empleado y sus beneficiarios registrados en el Sistema de Vivienda y Obra Social (SVO) para archivo escolar:</p>

            <!-- Datos del Empleado -->
            <div class="bg-gray-50 border border-gray-200 rounded-md p-3 mb-4">
                <h3 class="font-semibold text-base mb-2">DATOS DEL EMPLEADO/A</h3>
                <div class="grid grid-cols-2 gap-2">
                    <p><strong>Nombre Completo:</strong> {{ $empleado->nombre_completo }}</p>
                    <p><strong>DNI:</strong> {{ $empleado->dni ?? 'N/A' }}</p>
                    <p><strong>CUIL:</strong> {{ $empleado->cuil ?? 'N/A' }}</p>
                    <p><strong>Cargo:</strong> {{ $empleado->cargo ?? 'N/A' }}</p>
                    <p><strong>Dirección:</strong> {{ $empleado->direccion ?? 'N/A' }}</p>
                    <p><strong>Teléfono:</strong> {{ $empleado->telefono ?? 'N/A' }}</p>
                    <p><strong>Email:</strong> {{ $empleado->email ?? 'N/A' }}</p>
                    <p><strong>Escuela:</strong> {{ $empleado->escuela->nombre ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- Beneficiarios -->
            <div class="mb-4">
                <h3 class="font-semibold text-base mb-2">BENEFICIARIOS DECLARADOS</h3>

                @if($empleado->beneficiariosSvo->count() > 0)
                    <div class="border border-gray-200 rounded-md overflow-hidden">
                        <div class="bg-gray-100 px-3 py-2 border-b border-gray-200">
                            <div class="grid grid-cols-4 gap-2 text-xs font-semibold text-gray-700">
                                <span>NOMBRE COMPLETO</span>
                                <span>DNI</span>
                                <span>PARENTESCO</span>
                                <span class="text-center">%</span>
                            </div>
                        </div>
                        @foreach($empleado->beneficiariosSvo as $beneficiario)
                        <div class="px-3 py-2 border-b border-gray-100 last:border-b-0">
                            <div class="grid grid-cols-4 gap-2 text-sm">
                                <span>{{ $beneficiario->nombre }} {{ $beneficiario->apellido }}</span>
                                <span>{{ $beneficiario->dni }}</span>
                                <span>{{ $beneficiario->parentesco->nombre_parentesco ?? 'N/A' }}</span>
                                <span class="text-center font-semibold">{{ number_format($beneficiario->porcentaje, 1) }}%</span>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Total de porcentajes -->
                    <div class="mt-3 p-2 bg-blue-50 border border-blue-200 rounded">
                        <p class="text-sm">
                            <strong>Total de Porcentajes:</strong>
                            <span class="text-blue-700">{{ number_format($empleado->beneficiariosSvo->sum('porcentaje'), 1) }}%</span>
                        </p>
                    </div>
                @else
                    <div class="bg-yellow-50 border border-yellow-200 rounded-md p-3">
                        <p class="text-yellow-800">No se han declarado beneficiarios para este empleado.</p>
                    </div>
                @endif
            </div>

            <div class="mt-6">
                <p class="mb-3">Este documento contiene la información registrada del empleado y sus beneficiarios SVO para fines administrativos y de archivo escolar.</p>

                <p class="mb-3">Cualquier modificación o actualización de esta información debe ser procesada a través del sistema correspondiente.</p>
            </div>
        </main>

        <!-- Pie de Página -->
        <footer class="mt-16 text-center">
            <div class="border-t border-gray-400 pt-2">
                <p class="text-xs mb-2">Documento generado por el Sistema de Gestión Educativa</p>
                <p class="text-xs text-gray-600">Fecha de generación: {{ now()->format('d/m/Y H:i') }} horas</p>
                <p class="text-xs text-gray-600">Para archivo administrativo escolar</p>
            </div>
        </footer>
    </div>
</body>
</html>