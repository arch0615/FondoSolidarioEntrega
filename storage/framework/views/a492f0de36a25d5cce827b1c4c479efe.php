<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte de Alumnos</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 11px; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .header { text-align: center; margin-bottom: 20px; }
        .fecha { text-align: right; margin-bottom: 10px; font-size: 10px; }
        .footer { margin-top: 30px; text-align: center; font-size: 10px; color: #666; }
        @media print {
            body { margin: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="fecha">Generado el: <?php echo e(date('d/m/Y H:i')); ?></div>
    <div class="header">
        <h1>Reporte de Alumnos</h1>
        <p>Sistema Fondo Solidario</p>
    </div>
    
    <div class="no-print" style="margin-bottom: 20px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
            🖨️ Imprimir / Guardar como PDF
        </button>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Apellido</th>
                <th>Nombre</th>
                <th>DNI</th>
                <th>CUIL</th>
                <th>Grado/Curso</th>
                <th>Escuela</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $alumnos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alumno): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($alumno->apellido); ?></td>
                    <td><?php echo e($alumno->nombre); ?></td>
                    <td><?php echo e($alumno->dni); ?></td>
                    <td><?php echo e($alumno->cuil); ?></td>
                    <td><?php echo e($alumno->sala_grado_curso); ?></td>
                    <td><?php echo e($alumno->escuela->nombre ?? 'N/A'); ?></td>
                    <td><?php echo e($alumno->activo ? 'Activo' : 'Inactivo'); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    
    <div class="footer">
        <p>Total de registros: <?php echo e(count($alumnos)); ?></p>
        <p>Sistema Fondo Solidario - <?php echo e(date('Y')); ?></p>
    </div>
</body>
</html><?php /**PATH C:\Users\rican\OneDrive\Documentos\workana\Fondo Solidario\resources\views\exports\alumnos_pdf.blade.php ENDPATH**/ ?>