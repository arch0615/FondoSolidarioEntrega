<?php $__env->startSection('title', 'Pasantia - ' . ($pasantia->alumno->apellido ?? '') . ' ' . ($pasantia->alumno->nombre ?? '')); ?>

<?php $__env->startSection('content'); ?>
    <!-- Encabezado -->
    <?php if(file_exists(public_path('images/EncabezadoDerivacion.png'))): ?>
    <div class="text-center mb-5">
        <img src="<?php echo e(public_path('images/EncabezadoDerivacion.png')); ?>" class="header-img" alt="Encabezado">
    </div>
    <?php endif; ?>

    <h1>CONSTANCIA DE PASANT&Iacute;A</h1>

    <div class="fecha-emision">
        Fecha de Emisi&oacute;n: <strong><?php echo e(now()->format('d/m/Y')); ?></strong>
    </div>

    <p class="mb-10">Por medio de la presente, se deja constancia de la siguiente pasant&iacute;a registrada por la <strong><?php echo e($pasantia->escuela->nombre ?? 'N/A'); ?></strong>:</p>

    <!-- Datos del Alumno -->
    <div class="data-box">
        <h3>Datos del Alumno/a</h3>
        <table class="data-table">
            <tr>
                <td class="label">Nombre Completo:</td>
                <td><?php echo e($pasantia->alumno->apellido ?? ''); ?> <?php echo e($pasantia->alumno->nombre ?? ''); ?></td>
            </tr>
            <tr>
                <td class="label">DNI:</td>
                <td><?php echo e($pasantia->alumno->dni ?? 'N/A'); ?></td>
            </tr>
        </table>
    </div>

    <!-- Datos de la Pasantia -->
    <div class="data-box">
        <h3>Datos de la Pasant&iacute;a</h3>
        <table class="data-table">
            <tr>
                <td class="label">Empresa:</td>
                <td><?php echo e($pasantia->empresa); ?></td>
            </tr>
            <tr>
                <td class="label">Direcci&oacute;n:</td>
                <td><?php echo e($pasantia->direccion_empresa); ?></td>
            </tr>
            <tr>
                <td class="label">Tutor de Empresa:</td>
                <td><?php echo e($pasantia->tutor_empresa); ?></td>
            </tr>
            <tr>
                <td class="label">Per&iacute;odo:</td>
                <td>
                    <?php echo e($pasantia->fecha_inicio ? $pasantia->fecha_inicio->format('d/m/Y') : 'N/A'); ?>

                    al
                    <?php echo e($pasantia->fecha_fin ? $pasantia->fecha_fin->format('d/m/Y') : 'N/A'); ?>

                </td>
            </tr>
            <?php if($pasantia->horario): ?>
            <tr>
                <td class="label">Horario:</td>
                <td><?php echo e($pasantia->horario); ?></td>
            </tr>
            <?php endif; ?>
        </table>
    </div>

    <!-- Descripcion de Tareas -->
    <?php if($pasantia->descripcion_tareas): ?>
    <div class="mb-10">
        <p class="mb-5"><strong>Descripci&oacute;n de Tareas:</strong></p>
        <div class="data-box">
            <p><?php echo e($pasantia->descripcion_tareas); ?></p>
        </div>
    </div>
    <?php endif; ?>

    <p class="mt-15 mb-15">Se extiende la presente para ser presentada ante quien corresponda.</p>

    <!-- Firmas -->
    <table class="footer-signatures">
        <tr>
            <td>
                <div class="signature-line">Firma del Personal Autorizado</div>
            </td>
            <td>
                <div class="signature-line">Sello de la Instituci&oacute;n</div>
            </td>
        </tr>
    </table>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('pdf.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ubuntu/Documents/FondoSolidarioEntrega/FondoSolidarioEntrega/resources/views/pdf/pasantia.blade.php ENDPATH**/ ?>