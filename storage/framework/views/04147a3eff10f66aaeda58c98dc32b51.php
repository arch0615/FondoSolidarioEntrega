<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pasantía - <?php echo e($pasantia->alumno->apellido ?? ''); ?> <?php echo e($pasantia->alumno->nombre ?? ''); ?></title>
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
        <a href="<?php echo e(route('pasantias.pdf', $pasantia->id_pasantia)); ?>" target="_blank" class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow-md">
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
            <?php if(file_exists(public_path('images/EncabezadoDerivacion.png'))): ?>
            <div class="w-full mb-3">
                <img src="<?php echo e(asset('images/EncabezadoDerivacion.png')); ?>"
                     alt="Encabezado"
                     class="w-full h-auto object-contain"
                     style="max-height: 120px;">
            </div>
            <?php endif; ?>
            <div class="text-center">
                <h1 class="text-xl font-bold text-black">CONSTANCIA DE PASANTÍA</h1>
            </div>
        </header>

        <!-- Fecha de Emisión -->
        <div class="text-right mb-4">
            <p class="text-sm">Fecha de Emisión: <span class="font-semibold"><?php echo e(now()->format('d/m/Y')); ?></span></p>
        </div>

        <!-- Cuerpo -->
        <main class="text-sm leading-normal">
            <p class="mb-4">Por medio de la presente, se deja constancia de la siguiente pasantía registrada por la <strong><?php echo e($pasantia->escuela->nombre ?? 'N/A'); ?></strong>:</p>

            <!-- Datos del Alumno -->
            <div class="bg-gray-50 border border-gray-200 rounded-md p-4 mb-4">
                <h3 class="font-bold text-sm mb-2">Datos del Alumno/a</h3>
                <table class="w-full text-sm">
                    <tr>
                        <td class="font-semibold py-1 pr-4 w-1/3">Nombre Completo:</td>
                        <td class="py-1"><?php echo e($pasantia->alumno->apellido ?? ''); ?> <?php echo e($pasantia->alumno->nombre ?? ''); ?></td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-1 pr-4">DNI:</td>
                        <td class="py-1"><?php echo e($pasantia->alumno->dni ?? 'N/A'); ?></td>
                    </tr>
                </table>
            </div>

            <!-- Datos de la Pasantía -->
            <div class="bg-gray-50 border border-gray-200 rounded-md p-4 mb-4">
                <h3 class="font-bold text-sm mb-2">Datos de la Pasantía</h3>
                <table class="w-full text-sm">
                    <tr>
                        <td class="font-semibold py-1 pr-4 w-1/3">Empresa:</td>
                        <td class="py-1"><?php echo e($pasantia->empresa); ?></td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-1 pr-4">Dirección:</td>
                        <td class="py-1"><?php echo e($pasantia->direccion_empresa); ?></td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-1 pr-4">Tutor de Empresa:</td>
                        <td class="py-1"><?php echo e($pasantia->tutor_empresa); ?></td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-1 pr-4">Período:</td>
                        <td class="py-1">
                            <?php echo e($pasantia->fecha_inicio ? $pasantia->fecha_inicio->format('d/m/Y') : 'N/A'); ?>

                            al
                            <?php echo e($pasantia->fecha_fin ? $pasantia->fecha_fin->format('d/m/Y') : 'N/A'); ?>

                        </td>
                    </tr>
                    <?php if($pasantia->horario): ?>
                    <tr>
                        <td class="font-semibold py-1 pr-4">Horario:</td>
                        <td class="py-1"><?php echo e($pasantia->horario); ?></td>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>

            <!-- Descripción de Tareas -->
            <?php if($pasantia->descripcion_tareas): ?>
            <div class="mb-4">
                <p class="font-semibold mb-1">Descripción de Tareas:</p>
                <div class="bg-gray-50 border border-gray-200 rounded-md p-3">
                    <p><?php echo e($pasantia->descripcion_tareas); ?></p>
                </div>
            </div>
            <?php endif; ?>

            <p class="mb-6 mt-6">Se extiende la presente para ser presentada ante quien corresponda.</p>
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
<?php /**PATH /home/ubuntu/Documents/FondoSolidarioEntrega/FondoSolidarioEntrega/resources/views/pasantias/print.blade.php ENDPATH**/ ?>