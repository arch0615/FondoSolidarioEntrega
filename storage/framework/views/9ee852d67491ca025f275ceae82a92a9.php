<?php $__env->startSection('header'); ?>
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Dashboard - Administración JAEC</h2>
        <p class="text-gray-600">Panel de control general del sistema - <?php echo e(Auth::user()->nombre_completo ?? 'Administrador'); ?></p>
        <p class="text-sm text-blue-600"><?php echo e(Auth::user()->rol_nombre); ?></p>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('dashboards.admin-dashboard');

$__html = app('livewire')->mount($__name, $__params, 'lw-1629491011-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/passion/Documents/FondoSolidarioEntrega11/Fondo Solidario Entrega/resources/views/dashboards/admin.blade.php ENDPATH**/ ?>