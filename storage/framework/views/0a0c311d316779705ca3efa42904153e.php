<table>
    <thead>
        <tr>
            <th>Empleado Titular</th>
            <th>DNI Empleado</th>
            <th>Escuela</th>
            <th>Beneficiario</th>
            <th>DNI Beneficiario</th>
            <th>Parentesco</th>
            <th>Porcentaje</th>
            <th>Estado</th>
            <th>Fecha de Alta</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $beneficiarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $beneficiario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($beneficiario->empleado->nombre_completo ?? 'N/A'); ?></td>
                <td><?php echo e($beneficiario->empleado->dni ?? 'N/A'); ?></td>
                <td><?php echo e($beneficiario->escuela->nombre ?? 'N/A'); ?></td>
                <td><?php echo e($beneficiario->nombre); ?> <?php echo e($beneficiario->apellido); ?></td>
                <td><?php echo e($beneficiario->dni); ?></td>
                <td><?php echo e($beneficiario->parentesco->nombre_parentesco ?? 'N/A'); ?></td>
                <td><?php echo e($beneficiario->porcentaje); ?>%</td>
                <td><?php echo e($beneficiario->activo ? 'Activo' : 'Inactivo'); ?></td>
                <td><?php echo e($beneficiario->fecha_alta ? $beneficiario->fecha_alta->format('d/m/Y') : 'N/A'); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table><?php /**PATH C:\Users\rican\OneDrive\Documentos\workana\Fondo Solidario\resources\views\exports\beneficiarios_svo_excel.blade.php ENDPATH**/ ?>