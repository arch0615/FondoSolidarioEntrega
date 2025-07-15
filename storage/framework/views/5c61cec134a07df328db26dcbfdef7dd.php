<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Pasantías / Prácticas Profesionales</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #333;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .no-data {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 20px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte de Pasantías / Prácticas Profesionales</h1>
        <p>Sistema de Fondo Solidario</p>
        <p>Fecha de generación: <?php echo e(date('d/m/Y H:i:s')); ?></p>
        <p>Total de registros: <?php echo e($pasantias->count()); ?></p>
    </div>

    <?php if($pasantias->count() > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Alumno</th>
                    <th>DNI</th>
                    <th>Empresa</th>
                    <th>Tutor</th>
                    <th>Escuela</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Horario</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $pasantias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pasantia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($pasantia->alumno ? $pasantia->alumno->nombre . ' ' . $pasantia->alumno->apellido : 'Sin alumno'); ?></td>
                    <td><?php echo e($pasantia->alumno ? $pasantia->alumno->numero_documento : ''); ?></td>
                    <td><?php echo e($pasantia->empresa); ?></td>
                    <td><?php echo e($pasantia->tutor_empresa); ?></td>
                    <td><?php echo e($pasantia->escuela ? $pasantia->escuela->nombre : 'Sin escuela'); ?></td>
                    <td><?php echo e($pasantia->fecha_inicio ? $pasantia->fecha_inicio->format('d/m/Y') : ''); ?></td>
                    <td><?php echo e($pasantia->fecha_fin ? $pasantia->fecha_fin->format('d/m/Y') : ''); ?></td>
                    <td><?php echo e($pasantia->horario); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="no-data">
            No hay pasantías / prácticas profesionales para mostrar con los filtros aplicados.
        </div>
    <?php endif; ?>

    <div class="footer">
        <p>Reporte generado por: <?php echo e(auth()->user()->nombre); ?> <?php echo e(auth()->user()->apellido); ?> - <?php echo e(auth()->user()->email); ?></p>
        <p>Sistema de Fondo Solidario &copy; <?php echo e(date('Y')); ?></p>
    </div>
</body>
</html><?php /**PATH C:\Users\rican\OneDrive\Documentos\workana\Fondo Solidario\resources\views\exports\pasantias_pdf.blade.php ENDPATH**/ ?>