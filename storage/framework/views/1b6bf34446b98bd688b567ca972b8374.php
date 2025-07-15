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
</table><?php /**PATH C:\Users\rican\OneDrive\Documentos\workana\Fondo Solidario\resources\views\exports\alumnos.blade.php ENDPATH**/ ?>