<div>
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-6">
        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $stats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="bg-white rounded-lg border border-<?php echo e($stat['color']); ?>-200 p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="text-center">
                <p class="text-sm font-medium text-gray-600 mb-2">
                    <!--[if BLOCK]><![endif]--><?php switch($key):
                        case ('reintegros_pendientes'): ?> Pendientes Auditoría <?php break; ?>
                        <?php case ('reintegros_autorizados'): ?> Autorizados <?php break; ?>
                        <?php case ('reintegros_rechazados'): ?> Rechazados <?php break; ?>
                        <?php case ('solicitudes_informacion'): ?> Info. Solicitada <?php break; ?>
                        <?php case ('tiempo_promedio_revision'): ?> Tiempo Promedio <?php break; ?>
                    <?php endswitch; ?><!--[if ENDBLOCK]><![endif]-->
                </p>
                <p class="text-3xl font-bold text-<?php echo e($stat['color']); ?>-700 mb-1"><?php echo e($stat['total']); ?></p>
                <p class="text-xs text-<?php echo e($stat['color']); ?>-600"><?php echo e($stat['incremento']); ?></p>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Activity -->
        <div class="lg:col-span-2 bg-white rounded-lg border border-gray-200 p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Actividad Médica Reciente</h3>
            
            <div class="space-y-4">
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $recentActivity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex items-center justify-between p-4 bg-<?php echo e($activity['color']); ?>-25 border border-<?php echo e($activity['color']); ?>-100 rounded-lg hover:bg-<?php echo e($activity['color']); ?>-50 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-<?php echo e($activity['color']); ?>-100 rounded-lg border border-<?php echo e($activity['color']); ?>-200">
                            <i class="<?php echo e($activity['icono']); ?> text-<?php echo e($activity['color']); ?>-600"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900"><?php echo e($activity['titulo']); ?></p>
                            <p class="text-sm text-gray-600"><?php echo e($activity['descripcion']); ?></p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500"><?php echo e($activity['tiempo']); ?></p>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </div>

            <div class="mt-4 pt-4 border-t border-gray-200">
                <button class="w-full text-center text-sm text-green-600 hover:text-green-800 font-medium">
                    Ver historial completo de auditorías →
                </button>
            </div>
        </div>

        <!-- Medical Actions -->
        <div class="bg-white rounded-lg border border-green-200 p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-green-800 mb-4">Acciones Médicas</h3>
            
            <div class="space-y-3">
                <a href="<?php echo e(route('reintegros.pendientes')); ?>" class="w-full flex items-center gap-3 p-3 bg-amber-600 hover:bg-amber-700 text-white rounded-lg transition-all duration-200 hover:shadow-md">
                    <i class="fas fa-clipboard-check"></i>
                    <span>Revisar Pendientes</span>
                    <!--[if BLOCK]><![endif]--><?php if($stats['reintegros_pendientes']['total'] > 0): ?>
                    <span class="ml-auto bg-white text-amber-600 text-xs rounded-full px-2 py-1"><?php echo e($stats['reintegros_pendientes']['total']); ?></span>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </a>
                
                <a href="<?php echo e(route('auditoria.historial-auditorias')); ?>" class="w-full flex items-center gap-3 p-3 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-all duration-200 hover:shadow-md">
                    <i class="fas fa-history"></i>
                    <span>Historial de Auditorías</span>
                </a>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\Users\rican\OneDrive\Documentos\workana\Fondo Solidario\resources\views/livewire/dashboards/medico-dashboard.blade.php ENDPATH**/ ?>