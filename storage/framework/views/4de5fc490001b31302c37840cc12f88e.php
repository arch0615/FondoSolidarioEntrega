<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salida Educativa - <?php echo e($salida->destino); ?></title>
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
        <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition-transform transform hover:scale-105">
            Imprimir / Guardar como PDF
        </button>
        <button onclick="window.close()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition-transform transform hover:scale-105">
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
                <h1 class="text-xl font-bold text-black">AUTORIZACIÓN DE SALIDA EDUCATIVA</h1>
            </div>
        </header>

        <!-- Fecha de Emisión -->
        <div class="text-right mb-4">
            <p class="text-sm">Fecha de Emisión: <span class="font-semibold"><?php echo e(now()->format('d/m/Y')); ?></span></p>
        </div>

        <!-- Cuerpo -->
        <main class="text-sm leading-normal">
            <p class="mb-4">Por medio de la presente, se autoriza la siguiente salida educativa de la <strong><?php echo e($salida->escuela->nombre ?? 'N/A'); ?></strong>:</p>

            <!-- Datos de la Salida -->
            <div class="bg-gray-50 border border-gray-200 rounded-md p-4 mb-4">
                <table class="w-full text-sm">
                    <tr>
                        <td class="font-semibold py-1 pr-4 w-1/3">Destino:</td>
                        <td class="py-1"><?php echo e($salida->destino); ?></td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-1 pr-4">Fecha de Salida:</td>
                        <td class="py-1">
                            <?php echo e($salida->fecha_salida ? $salida->fecha_salida->format('d/m/Y') : 'N/A'); ?>

                            <?php if($salida->fecha_hasta): ?>
                                al <?php echo e($salida->fecha_hasta->format('d/m/Y')); ?>

                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-1 pr-4">Horario:</td>
                        <td class="py-1">
                            <?php echo e($salida->hora_salida ? \Carbon\Carbon::parse($salida->hora_salida)->format('H:i') : 'N/A'); ?> hs
                            a
                            <?php echo e($salida->hora_regreso ? \Carbon\Carbon::parse($salida->hora_regreso)->format('H:i') : 'N/A'); ?> hs
                        </td>
                    </tr>
                    <?php if($salida->grado_curso): ?>
                    <tr>
                        <td class="font-semibold py-1 pr-4">Grado/Curso:</td>
                        <td class="py-1"><?php echo e($salida->grado_curso); ?></td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <td class="font-semibold py-1 pr-4">Cantidad de Alumnos:</td>
                        <td class="py-1"><?php echo e($salida->cantidad_alumnos); ?></td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-1 pr-4">Medio de Transporte:</td>
                        <td class="py-1"><?php echo e($salida->transporte); ?></td>
                    </tr>
                </table>
            </div>

            <!-- Propósito -->
            <div class="mb-4">
                <p class="font-semibold mb-1">Propósito de la Salida:</p>
                <div class="bg-gray-50 border border-gray-200 rounded-md p-3">
                    <p><?php echo e($salida->proposito); ?></p>
                </div>
            </div>

            <!-- Docentes Acompañantes -->
            <div class="mb-4">
                <p class="font-semibold mb-1">Docentes Acompañantes:</p>
                <div class="bg-gray-50 border border-gray-200 rounded-md p-3">
                    <p><?php echo e($salida->docentes_acompanantes); ?></p>
                </div>
            </div>

            <?php if($archivos->count() > 0): ?>
            <div class="mb-4">
                <p class="font-semibold mb-1">Archivos Adjuntos:</p>
                <ul class="list-disc list-inside text-sm">
                    <?php $__currentLoopData = $archivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $archivo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($archivo->nombre_archivo); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
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
<?php /**PATH /home/passion/Documents/FondoSolidarioEntrega11/Fondo Solidario Entrega/resources/views/salidas_educativas/print.blade.php ENDPATH**/ ?>