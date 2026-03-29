

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('reintegros.form', ['reintegroId' => $reintegro_id ?? null,'idAccidente' => $id_accidente ?? null,'modo' => $modo,'reintegro_id' => $reintegro_id ?? null,'id_accidente' => $id_accidente ?? null]);

$__html = app('livewire')->mount($__name, $__params, 'lw-4221788395-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ubuntu/Documents/FondoSolidarioEntrega/FondoSolidarioEntrega/resources/views/reintegros/form.blade.php ENDPATH**/ ?>