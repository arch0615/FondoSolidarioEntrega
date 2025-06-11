<div class="mx-auto px-4" x-data="{ showDetail: <?php if ((object) ('reintegroSeleccionado') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('reintegroSeleccionado'->value()); ?>')<?php echo e('reintegroSeleccionado'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('reintegroSeleccionado'); ?>')<?php endif; ?>, showInfoModal: <?php if ((object) ('solicitandoInformacion') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('solicitandoInformacion'->value()); ?>')<?php echo e('solicitandoInformacion'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('solicitandoInformacion'); ?>')<?php endif; ?>, showRechazoModal: <?php if ((object) ('rechazandoReintegro') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('rechazandoReintegro'->value()); ?>')<?php echo e('rechazandoReintegro'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('rechazandoReintegro'); ?>')<?php endif; ?> }">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 mb-8">
        <div>
            <h1 class="text-2xl font-semibold text-secondary-900">Reintegros Pendientes</h1>
            <p class="mt-1 text-sm text-secondary-600">Revisa y gestiona las solicitudes de reintegro pendientes.</p>
        </div>
    </div>

    <!-- Tabla de Reintegros Pendientes -->
    <div class="bg-white rounded-xl border border-secondary-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-secondary-200">
                <thead class="bg-secondary-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">ID Reintegro</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Alumno / Escuela</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Fecha Solicitud</th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-medium text-secondary-500 uppercase tracking-wider">Monto</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-secondary-500 uppercase tracking-wider">Estado</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-secondary-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-secondary-200">
                    <?php $__empty_1 = true; $__currentLoopData = $reintegros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reintegro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-secondary-50 transition-colors duration-150 <?php if(!$reintegro['es_nuevo']): ?> bg-blue-50 <?php endif; ?>" wire:key="reintegro-<?php echo e($reintegro['id']); ?>">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-secondary-900 flex items-center">
                                    <?php if($reintegro['es_nuevo']): ?>
                                        <span class="h-3 w-3 bg-success-500 rounded-full mr-3" title="Nuevo"></span>
                                    <?php else: ?>
                                        <span class="h-3 w-3 bg-warning-500 rounded-full mr-3" title="Información Recibida"></span>
                                    <?php endif; ?>
                                    <?php echo e($reintegro['id']); ?>

                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-secondary-900"><?php echo e($reintegro['alumno']); ?></div>
                                <div class="text-sm text-secondary-500"><?php echo e($reintegro['escuela']); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-secondary-900"><?php echo e(\Carbon\Carbon::parse($reintegro['fecha_solicitud'])->format('d/m/Y')); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="text-sm font-medium text-secondary-900">$ <?php echo e(number_format($reintegro['monto'], 2, ',', '.')); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <?php if($reintegro['es_nuevo']): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-100 text-success-800">
                                        Nuevo
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-warning-100 text-warning-800">
                                        Pendiente Información
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <button wire:click="verDetalle('<?php echo e($reintegro['id']); ?>')" class="p-2 text-secondary-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors duration-200" title="Ver detalles">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-secondary-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-secondary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <h3 class="mt-2 text-lg font-medium text-secondary-800">¡Todo al día!</h3>
                                    <p class="mt-1 text-sm text-secondary-600">No hay reintegros pendientes por revisar.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal/Side Panel para Detalles del Reintegro -->
    <div x-show="showDetail" 
         class="fixed inset-0 bg-black bg-opacity-50 z-40 transition-opacity" 
         @click="showDetail = null"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;"></div>

    <div x-show="showDetail" 
         class="fixed inset-y-0 right-0 w-full max-w-2xl bg-white z-50 shadow-xl transform"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         style="display: none;">
        
        <?php if($reintegroSeleccionado): ?>
            <div class="h-full flex flex-col">
                <div class="flex justify-between items-center px-6 py-4 bg-secondary-50 border-b border-secondary-200">
                    <h2 class="text-lg font-semibold text-secondary-900">Detalle del Reintegro: <?php echo e($reintegroSeleccionado['id']); ?></h2>
                    <button @click="showDetail = null" wire:click="cerrarDetalle" class="p-2 text-secondary-400 hover:text-secondary-600 hover:bg-secondary-100 rounded-full transition-colors duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="flex-grow p-6 overflow-y-auto">
                    <!-- Información del Accidente -->
                    <div class="mb-6">
                        <h3 class="text-base font-semibold text-secondary-800 border-b border-secondary-200 pb-2 mb-4">Información del Accidente</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div><span class="font-medium text-secondary-600">ID Accidente:</span> <span class="text-secondary-900"><?php echo e($reintegroSeleccionado['accidente_id']); ?></span></div>
                            <div><span class="font-medium text-secondary-600">Alumno:</span> <span class="text-secondary-900"><?php echo e($reintegroSeleccionado['alumno']); ?></span></div>
                            <div><span class="font-medium text-secondary-600">Escuela:</span> <span class="text-secondary-900"><?php echo e($reintegroSeleccionado['escuela']); ?></span></div>
                            <div><span class="font-medium text-secondary-600">Fecha Solicitud:</span> <span class="text-secondary-900"><?php echo e(\Carbon\Carbon::parse($reintegroSeleccionado['fecha_solicitud'])->format('d/m/Y')); ?></span></div>
                            <div class="md:col-span-2"><span class="font-medium text-secondary-600">Monto Solicitado:</span> <span class="text-secondary-900 font-bold text-lg">$ <?php echo e(number_format($reintegroSeleccionado['monto'], 2, ',', '.')); ?></span></div>
                        </div>
                    </div>

                    <!-- Documentos Adjuntos -->
                    <div>
                        <h3 class="text-base font-semibold text-secondary-800 border-b border-secondary-200 pb-2 mb-4">Documentos Adjuntos</h3>
                        <ul class="space-y-3">
                            <?php $__empty_1 = true; $__currentLoopData = $reintegroSeleccionado['documentos']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <li class="flex items-center justify-between p-3 bg-secondary-50 rounded-lg border border-secondary-200">
                                    <div class="flex items-center">
                                        <svg class="w-6 h-6 text-primary-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        <span class="text-sm font-medium text-secondary-800"><?php echo e($doc['nombre']); ?></span>
                                    </div>
                                    <a href="<?php echo e($doc['url']); ?>" target="_blank" class="inline-flex items-center px-3 py-1.5 bg-white border border-secondary-300 rounded-md text-xs font-medium text-secondary-700 hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                        Ver
                                    </a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <li class="text-sm text-secondary-500">No hay documentos adjuntos.</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>

                <div class="px-6 py-4 bg-secondary-50 border-t border-secondary-200 flex justify-end items-center space-x-3">
                    <button class="inline-flex items-center px-4 py-2 bg-success-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-success-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-success-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Aprobar
                    </button>
                    <button wire:click="mostrarModalRechazo" class="inline-flex items-center px-4 py-2 bg-danger-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-danger-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-danger-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        Rechazar
                    </button>
                    <button wire:click="solicitarInformacion" class="inline-flex items-center px-4 py-2 bg-warning-500 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-warning-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-warning-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.546-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Solicitar Información
                    </button>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Modal para Solicitar Información -->
    <div x-show="showInfoModal"
         class="fixed inset-0 bg-gray-900 bg-opacity-60 z-50 flex justify-center items-center"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-6 m-4" @click.away="showInfoModal = false">
            <h3 class="text-xl font-semibold text-secondary-900 mb-4">Solicitar Información Adicional</h3>
            <p class="text-sm text-secondary-600 mb-4">
                Escribe el motivo de tu solicitud. Esta información será enviada a la escuela para que puedan adjuntar los documentos o datos necesarios.
            </p>
            <div wire:key="solicitud-info-<?php echo e($reintegroSeleccionado['id'] ?? 'new'); ?>">
                <textarea wire:model="solicitudInfoTexto"
                          class="w-full h-32 p-3 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                          placeholder="Ej: Por favor, adjuntar el informe médico detallado y la factura de la consulta..."></textarea>
            </div>
            <div class="flex justify-end items-center mt-6 space-x-3">
                <button wire:click="cancelarSolicitud" class="px-4 py-2 bg-secondary-200 text-secondary-800 rounded-lg hover:bg-secondary-300 transition-colors">
                    Cancelar
                </button>
                <button wire:click="enviarSolicitud" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                    Enviar Solicitud
                </button>
            </div>
        </div>
    </div>

    <!-- Modal para Motivo de Rechazo -->
    <div x-show="showRechazoModal"
         class="fixed inset-0 bg-gray-900 bg-opacity-60 z-50 flex justify-center items-center"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-6 m-4" @click.away="showRechazoModal = false">
            <h3 class="text-xl font-semibold text-secondary-900 mb-4">Motivo del Rechazo</h3>
            <p class="text-sm text-secondary-600 mb-4">
                Por favor, especifica el motivo por el cual este reintegro está siendo rechazado. Esta información quedará registrada en el sistema.
            </p>
            <div wire:key="rechazo-<?php echo e($reintegroSeleccionado['id'] ?? 'new'); ?>">
                <textarea wire:model="motivoRechazo"
                          class="w-full h-32 p-3 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-danger-500 focus:border-danger-500 transition"
                          placeholder="Ej: La documentación presentada no corresponde con el accidente reportado..."></textarea>
            </div>
            <div class="flex justify-end items-center mt-6 space-x-3">
                <button wire:click="cancelarRechazo" class="px-4 py-2 bg-secondary-200 text-secondary-800 rounded-lg hover:bg-secondary-300 transition-colors">
                    Cancelar
                </button>
                <button wire:click="confirmarRechazo" class="px-4 py-2 bg-danger-600 text-white rounded-lg hover:bg-danger-700 transition-colors">
                    Confirmar Rechazo
                </button>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\Users\rican\OneDrive\Documentos\workana\Fondo Solidario\resources\views\livewire\reintegros\pendientes.blade.php ENDPATH**/ ?>