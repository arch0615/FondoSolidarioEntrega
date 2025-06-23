

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('derivaciones.form', ['derivacionId' => $derivacion_id ?? null,'accidenteId' => $accidente_id ?? null,'modo' => $modo,'derivacion_id' => $derivacion_id ?? null,'accidente_id' => $accidente_id ?? null]);

$__html = app('livewire')->mount($__name, $__params, 'lw-2923602350-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\rican\OneDrive\Documentos\workana\Fondo Solidario\resources\views/derivaciones/form.blade.php ENDPATH**/ ?>