<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte de Accesos de Auditoría</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #dddddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Reporte de Accesos de Auditoría</h1>
    <table>
        <thead>
            <tr>
                <th>Fecha y Hora</th>
                <th>Usuario</th>
                <th>Acción</th>
                <th>IP</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $registros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $registro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($registro->fecha_hora->format('d/m/Y H:i:s')); ?></td>
                <td><?php echo e($registro->usuario->nombre_completo ?? 'N/A'); ?></td>
                <td><?php echo e($registro->accion); ?></td>
                <td><?php echo e($registro->ip_usuario); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</body>
</html><?php /**PATH C:\Users\rican\OneDrive\Documentos\workana\Fondo Solidario\resources\views\exports\auditoria_accesos_pdf.blade.php ENDPATH**/ ?>