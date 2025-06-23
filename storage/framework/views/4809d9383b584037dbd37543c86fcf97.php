<?php $__env->startSection('header'); ?>
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Dashboard - Escuela</h2>
        <p class="text-gray-600">Bienvenido al sistema - <?php echo e(Auth::user()->nombre_completo ?? 'Usuario'); ?></p>
        <p class="text-sm text-primary-600"><?php echo e(Auth::user()->rol_nombre); ?></p>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('dashboards.escuela-dashboard');

$__html = app('livewire')->mount($__name, $__params, 'lw-2076362768-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\rican\OneDrive\Documentos\workana\Fondo Solidario\resources\views/dashboards/escuela.blade.php ENDPATH**/ ?>