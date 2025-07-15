<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte de Reintegros</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 4px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .header { text-align: center; margin-bottom: 20px; }
        .footer { margin-top: 20px; text-align: center; font-size: 9px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte de Reintegros</h1>
        <p>Sistema Fondo Solidario - Generado el: <?php echo e(date('d/m/Y H:i')); ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID Reintegro</th>
                <th>ID Accidente</th>
                <th>Alumno(s)</th>
                <th>Escuela</th>
                <th>Fecha Solicitud</th>
                <th>Monto Solicitado</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $reintegros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reintegro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($reintegro->id_reintegro); ?></td>
                    <td><?php echo e($reintegro->accidente->id_accidente_entero ?? 'N/A'); ?></td>
                    <td><?php echo e(export_clean($reintegro->alumno->nombre_completo ?? 'N/A')); ?></td>
                    <td><?php echo e(export_clean($reintegro->accidente->escuela->nombre ?? 'N/A')); ?></td>
                    <td><?php echo e($reintegro->fecha_solicitud ? $reintegro->fecha_solicitud->format('d/m/Y') : ''); ?></td>
                    <td>$ <?php echo e(number_format($reintegro->monto_solicitado, 2)); ?></td>
                    <td><?php echo e(export_clean($reintegro->estadoReintegro->descripcion ?? 'Sin Estado')); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" style="text-align: center;">No hay reintegros para mostrar.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        <p>Total de registros: <?php echo e(count($reintegros)); ?></p>
    </div>
</body>
</html><?php /**PATH C:\Users\rican\OneDrive\Documentos\workana\Fondo Solidario\resources\views\exports\reintegros_pdf.blade.php ENDPATH**/ ?>