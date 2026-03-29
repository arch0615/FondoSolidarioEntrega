

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('pasantias.form', ['pasantiaId' => $pasantia_id ?? null,'modo' => $modo,'pasantia_id' => $pasantia_id ?? null]);

$__html = app('livewire')->mount($__name, $__params, 'lw-1601502285-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ubuntu/Documents/FondoSolidarioEntrega/FondoSolidarioEntrega/resources/views/pasantias/form.blade.php ENDPATH**/ ?>