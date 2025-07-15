<div>
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <?php $__currentLoopData = $stats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="bg-white rounded-lg border border-<?php echo e($stat['color']); ?>-200 p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="text-center">
                <p class="text-sm font-medium text-gray-600 mb-2">
                    <?php switch($key):
                        case ('total_escuelas'): ?> Escuelas Activas <?php break; ?>
                        <?php case ('total_accidentes'): ?> Total Accidentes <?php break; ?>
                        <?php case ('reintegros_autorizados'): ?> Reintegros Autorizados <?php break; ?>
                        <?php case ('monto_total_pagado'): ?> Monto Total Pagado <?php break; ?>
                    <?php endswitch; ?>
                </p>
                <p class="text-3xl font-bold text-<?php echo e($stat['color']); ?>-700 mb-1"><?php echo e($stat['total']); ?></p>
                <p class="text-xs text-<?php echo e($stat['color']); ?>-600"><?php echo e($stat['incremento']); ?></p>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Activity -->
        <div class="lg:col-span-2 bg-white rounded-lg border border-gray-200 p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Actividad Reciente del Sistema</h3>
            
            <div class="space-y-4">
                <?php $__currentLoopData = $recentActivity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="mt-4 pt-4 border-t border-gray-200">
                <a href="<?php echo e(route('auditoria.operaciones')); ?>" class="w-full text-center text-sm text-blue-600 hover:text-blue-800 font-medium">
                    Ver todas las actividades →
                </a>
            </div>
        </div>

        <!-- Management Actions -->
        <div class="bg-white rounded-lg border border-blue-200 p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-blue-800 mb-4">Accesos Rápidos</h3>
            
            <div class="space-y-3">
                <a href="<?php echo e(route('accidentes.index')); ?>" class="w-full flex items-center gap-3 p-3 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-all duration-200 hover:shadow-md">
                    <i class="fas fa-medkit"></i>
                    <span>Accidentes</span>
                </a>
                
                <a href="<?php echo e(route('escuelas.index')); ?>" class="w-full flex items-center gap-3 p-3 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition-all duration-200 hover:shadow-md">
                    <i class="fas fa-school"></i>
                    <span>Gestionar Escuelas</span>
                </a>

                <a href="<?php echo e(route('usuarios.index')); ?>" class="w-full flex items-center gap-3 p-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-all duration-200 hover:shadow-md">
                    <i class="fas fa-users-cog"></i>
                    <span>Gestionar Usuarios</span>
                </a>

                <button class="w-full flex items-center gap-3 p-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-all duration-200 hover:shadow-md">
                    <i class="fas fa-dollar-sign"></i>
                    <span>Gestionar Pagos</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Escuelas Stats Table -->
    <div class="mt-6 bg-white rounded-lg border border-gray-200 p-6 shadow-sm">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Resumen por Escuela</h3>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Escuela</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Accidentes</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reintegros</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monto Pendiente</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__currentLoopData = $escuelasStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $escuela): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo e($escuela['nombre']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo e($escuela['accidentes']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo e($escuela['reintegros']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-amber-600"><?php echo e($escuela['monto_pendiente']); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div><?php /**PATH C:\Users\rican\OneDrive\Documentos\workana\Fondo Solidario\resources\views\livewire\dashboards\admin-dashboard.blade.php ENDPATH**/ ?>