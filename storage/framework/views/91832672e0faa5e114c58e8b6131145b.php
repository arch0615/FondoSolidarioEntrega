<div>
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Accidentes Reportados -->
        <div class="bg-white rounded-lg border border-red-200 p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Accidentes Reportados</p>
                    <p class="text-3xl font-bold text-red-700 mt-2"><?php echo e($stats['accidentes_reportados']['total']); ?></p>
                    <p class="text-xs text-red-600 mt-1"><?php echo e($stats['accidentes_reportados']['incremento']); ?></p>
                </div>
                <div class="p-3 rounded-lg bg-red-50 border border-red-200">
                    <i class="fas fa-shield-alt text-red-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Derivaciones Generadas -->
        <div class="bg-white rounded-lg border border-blue-200 p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Derivaciones Generadas</p>
                    <p class="text-3xl font-bold text-blue-700 mt-2"><?php echo e($stats['derivaciones_generadas']['total'] ?? 0); ?></p>
                    <p class="text-xs text-blue-600 mt-1"><?php echo e($stats['derivaciones_generadas']['incremento'] ?? 'Sin cambios'); ?></p>
                </div>
                <div class="p-3 rounded-lg bg-blue-50 border border-blue-200">
                    <i class="fas fa-file-medical text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Reintegros Pendientes -->
        <div class="bg-white rounded-lg border border-amber-200 p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Reintegros Pendientes</p>
                    <p class="text-3xl font-bold text-amber-700 mt-2"><?php echo e($stats['reintegros_pendientes']['total']); ?></p>
                    <p class="text-xs text-amber-600 mt-1"><?php echo e($stats['reintegros_pendientes']['incremento']); ?></p>
                </div>
                <div class="p-3 rounded-lg bg-amber-50 border border-amber-200">
                    <i class="fas fa-clock text-amber-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Salidas Educativas -->
        <div class="bg-white rounded-lg border border-green-200 p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Salidas Educativas</p>
                    <p class="text-3xl font-bold text-green-700 mt-2"><?php echo e($stats['salidas_educativas']['total'] ?? 0); ?></p>
                    <p class="text-xs text-green-600 mt-1"><?php echo e($stats['salidas_educativas']['incremento'] ?? 'Sin cambios'); ?></p>
                </div>
                <div class="p-3 rounded-lg bg-green-50 border border-green-200">
                    <i class="fas fa-route text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Activity -->
        <div class="lg:col-span-2 bg-white rounded-lg border border-gray-200 p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Actividad Reciente</h3>
            
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
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg border border-primary-200 p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-primary-800 mb-4">Acciones Rápidas</h3>
            
            <div class="space-y-3">
                <a href="<?php echo e(route('accidentes.create')); ?>" class="w-full flex items-center gap-3 p-3 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-all duration-200 hover:shadow-md">
                    <i class="fas fa-shield-alt"></i>
                    <span>Reportar Accidente</span>
                </a>
                
                <a href="<?php echo e(route('salidas-educativas.create')); ?>" class="w-full flex items-center gap-3 p-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-all duration-200 hover:shadow-md">
                    <i class="fas fa-route"></i>
                    <span>Registrar Salida Educativa</span>
                </a>
                
                <a href="<?php echo e(route('derivaciones.create')); ?>" class="w-full flex items-center gap-3 p-3 border-2 border-primary-300 text-primary-700 hover:bg-primary-50 hover:border-primary-400 rounded-lg transition-all duration-200">
                    <i class="fas fa-file-medical"></i>
                    <span>Generar Derivación</span>
                </a>

                
            </div>
        </div>
    </div>
</div><?php /**PATH C:\Users\rican\OneDrive\Documentos\workana\Fondo Solidario\resources\views/livewire/dashboards/escuela-dashboard.blade.php ENDPATH**/ ?>