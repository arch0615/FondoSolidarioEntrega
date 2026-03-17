
<div class="mx-auto px-4" x-data="{ 
    showDetail: <?php if ((object) ('showDetailModal') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showDetailModal'->value()); ?>')<?php echo e('showDetailModal'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showDetailModal'); ?>')<?php endif; ?>,
    showInfoModal: <?php if ((object) ('solicitandoInformacion') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('solicitandoInformacion'->value()); ?>')<?php echo e('solicitandoInformacion'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('solicitandoInformacion'); ?>')<?php endif; ?>,
    showRechazoModal: <?php if ((object) ('rechazandoReintegro') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('rechazandoReintegro'->value()); ?>')<?php echo e('rechazandoReintegro'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('rechazandoReintegro'); ?>')<?php endif; ?>,
    showAprobacionModal: <?php if ((object) ('aprobandoReintegro') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('aprobandoReintegro'->value()); ?>')<?php echo e('aprobandoReintegro'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('aprobandoReintegro'); ?>')<?php endif; ?>,
    showPagoModal: <?php if ((object) ('pagandoReintegro') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('pagandoReintegro'->value()); ?>')<?php echo e('pagandoReintegro'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('pagandoReintegro'); ?>')<?php endif; ?>,
    showMensajeModal: <?php if ((object) ('enviandoMensaje') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('enviandoMensaje'->value()); ?>')<?php echo e('enviandoMensaje'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('enviandoMensaje'); ?>')<?php endif; ?>
}">
    <!--[if BLOCK]><![endif]--><?php if(session()->has('message')): ?>
        <div class="mb-6 bg-success-50 border border-success-200 text-success-700 px-4 py-3 rounded-lg relative">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="font-medium"><?php echo e(session('message')); ?></span>
            </div>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 mb-8">
        <div>
            <h1 class="text-2xl font-semibold text-secondary-900">Reintegros Pendientes de Auditoría</h1>
            <p class="mt-1 text-sm text-secondary-600">Revisa y gestiona las solicitudes de reintegro que requieren tu atención.</p>
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-xl border border-secondary-200 mb-6">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="space-y-1">
                    <label for="filtro_id_accidente" class="block text-sm font-medium text-secondary-700">ID Accidente</label>
                    <input wire:model.live="filtro_id_accidente" type="text" id="filtro_id_accidente" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Buscar por ID Accidente">
                </div>
                <!--[if BLOCK]><![endif]--><?php if(Auth::user()->id_rol != 1): ?> 
                <div class="space-y-1">
                    <label for="filtro_escuela" class="block text-sm font-medium text-secondary-700">Escuela</label>
                    <select wire:model.live="filtro_escuela" id="filtro_escuela" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Todas</option>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $escuelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $escuela): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($escuela->id_escuela); ?>"><?php echo e($escuela->nombre); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </select>
                </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <div class="space-y-1">
                    <label for="filtro_fecha_solicitud" class="block text-sm font-medium text-secondary-700">Fecha Solicitud</label>
                    <input wire:model.live="filtro_fecha_solicitud" type="date" id="filtro_fecha_solicitud" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div class="flex items-end col-span-full lg:col-span-1">
                    <button wire:click="limpiarFiltros" type="button" class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 bg-secondary-100 border border-transparent rounded-lg font-medium text-sm text-secondary-700 hover:bg-secondary-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-500 transition-colors duration-200">
                        Limpiar Filtros
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Reintegros Pendientes -->
    <div class="bg-white rounded-xl border border-secondary-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-secondary-200">
                <thead class="bg-secondary-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                            <button wire:click="sortBy('id_reintegro')" class="group inline-flex items-center">
                                ID
                                <!--[if BLOCK]><![endif]--><?php if($sortField === 'id_reintegro'): ?>
                                    <!--[if BLOCK]><![endif]--><?php if($sortDirection === 'asc'): ?> <svg class="ml-2 w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                    <?php else: ?> <svg class="ml-2 w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <?php else: ?> <svg class="ml-2 w-4 h-4 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path></svg>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </button>
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Accidente (Alumno)</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                            <button wire:click="sortBy('fecha_solicitud')" class="group inline-flex items-center">
                                Fecha Solicitud
                                <!--[if BLOCK]><![endif]--><?php if($sortField === 'fecha_solicitud'): ?>
                                    <!--[if BLOCK]><![endif]--><?php if($sortDirection === 'asc'): ?> <svg class="ml-2 w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                    <?php else: ?> <svg class="ml-2 w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <?php else: ?> <svg class="ml-2 w-4 h-4 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path></svg>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </button>
                        </th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-medium text-secondary-500 uppercase tracking-wider">
                            <button wire:click="sortBy('monto_solicitado')" class="group inline-flex items-center">
                                Monto Solicitado
                                <!--[if BLOCK]><![endif]--><?php if($sortField === 'monto_solicitado'): ?>
                                    <!--[if BLOCK]><![endif]--><?php if($sortDirection === 'asc'): ?> <svg class="ml-2 w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                    <?php else: ?> <svg class="ml-2 w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <?php else: ?> <svg class="ml-2 w-4 h-4 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path></svg>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </button>
                        </th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-secondary-500 uppercase tracking-wider">Estado</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-secondary-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-secondary-200">
                    <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $reintegros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reintegro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-secondary-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-secondary-900 flex items-center">
                                    <!--[if BLOCK]><![endif]--><?php if($reintegro->estadoReintegro->descripcion == 'Nuevo'): ?>
                                        <span class="h-3 w-3 bg-success-500 rounded-full mr-3" title="Nuevo"></span>
                                    <?php elseif($reintegro->estadoReintegro->descripcion == 'Pendiente Información'): ?>
                                        <span class="h-3 w-3 bg-warning-500 rounded-full mr-3" title="Pendiente Información"></span>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    REI-<?php echo e(str_pad($reintegro->id_reintegro, 3, '0', STR_PAD_LEFT)); ?>

                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-secondary-900"><?php echo e($reintegro->alumno->nombre_completo ?? 'N/A'); ?></div>
                                <div class="text-sm text-secondary-500"><?php echo e($reintegro->accidente->escuela->nombre ?? 'N/A'); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-secondary-900"><?php echo e($reintegro->fecha_solicitud ? $reintegro->fecha_solicitud->format('d/m/Y') : 'N/A'); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="text-sm font-medium text-secondary-900">$ <?php echo e(number_format($reintegro->monto_solicitado, 2)); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($reintegro->estadoReintegro->color_clase ?? 'bg-secondary-100 text-secondary-800'); ?>">
                                    <?php echo e($reintegro->estadoReintegro->descripcion ?? 'Sin Estado'); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <button wire:click="verDetalle(<?php echo e($reintegro->id_reintegro); ?>)" class="p-2 text-secondary-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors duration-200" title="Ver detalles">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-secondary-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-secondary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2H5a2 2 0 01-2-2z" /></svg>
                                    <h3 class="mt-2 text-lg font-medium text-secondary-800">No hay reintegros pendientes</h3>
                                    <p class="mt-1 text-sm text-secondary-600">No se encontraron reintegros que requieran auditoría en este momento.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="px-6 py-4 bg-secondary-50 border-t border-secondary-200">
            <div class="flex flex-col sm:flex-row items-center justify-between">
                <div class="text-sm text-secondary-700 mb-4 sm:mb-0">
                    <!--[if BLOCK]><![endif]--><?php if($reintegros->total() > 0): ?>
                        Mostrando <span class="font-medium text-secondary-900"><?php echo e($reintegros->firstItem()); ?></span> a <span class="font-medium text-secondary-900"><?php echo e($reintegros->lastItem()); ?></span> de <span class="font-medium text-secondary-900"><?php echo e($reintegros->total()); ?></span> resultados
                    <?php else: ?>
                        No hay resultados para mostrar
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                <!--[if BLOCK]><![endif]--><?php if($reintegros->hasPages()): ?>
                    <?php echo e($reintegros->links('pagination.custom-tailwind')); ?>

                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>
    </div>

    <!-- Modal de Pantalla Completa para Detalles del Reintegro -->
    <div x-show="showDetail" 
         class="fixed inset-0 bg-black bg-opacity-50 z-40 transition-opacity" 
         @click="showDetail = false"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;"></div>

    <div x-show="showDetail" 
         class="fixed inset-4 bg-white z-50 shadow-xl rounded-xl transform overflow-hidden"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         style="display: none;">
         
        <!--[if BLOCK]><![endif]--><?php if($reintegroSeleccionado): ?>
            <div class="h-full flex flex-col">
                <!-- Header del Modal -->
                <div class="flex justify-between items-center px-6 py-4 bg-secondary-50 border-b border-secondary-200 rounded-t-xl">
                    <h2 class="text-xl font-semibold text-secondary-900">Detalle del Reintegro: REI-<?php echo e(str_pad($reintegroSeleccionado->id_reintegro, 3, '0', STR_PAD_LEFT)); ?></h2>
                    <button @click="showDetail = false" wire:click="cerrarDetalle" class="p-2 text-secondary-400 hover:text-secondary-600 hover:bg-secondary-100 rounded-full transition-colors duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Contenido del Modal en dos columnas -->
                <div class="flex-grow flex overflow-hidden">
                    <!-- Columna Izquierda: Información del Reintegro -->
                    <div class="w-2/3 p-3 border-r border-secondary-200">
                        <div class="space-y-3">
                            <!-- Información del Accidente -->
                            <div>
                                <h3 class="text-sm font-semibold text-secondary-800 border-b border-secondary-200 pb-1 mb-2">Información del Accidente</h3>
                                <div class="grid grid-cols-2 gap-3 text-xs">
                                    <div><span class="font-medium text-secondary-600">ID:</span> <span class="text-secondary-900"><?php echo e($reintegroSeleccionado->accidente->numero_expediente ?? $reintegroSeleccionado->accidente->id_accidente_entero ?? 'N/A'); ?></span></div>
                                    <div><span class="font-medium text-secondary-600">Escuela:</span> <span class="text-secondary-900"><?php echo e($reintegroSeleccionado->accidente->escuela->nombre ?? 'N/A'); ?></span></div>
                                    <div><span class="font-medium text-secondary-600">Fecha:</span> <span class="text-secondary-900"><?php echo e($reintegroSeleccionado->fecha_solicitud ? $reintegroSeleccionado->fecha_solicitud->format('d/m/Y') : 'N/A'); ?></span></div>
                                    <div><span class="font-medium text-secondary-600">Estado:</span>
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium <?php echo e($reintegroSeleccionado->estadoReintegro->color_clase ?? 'bg-secondary-100 text-secondary-800'); ?>">
                                            <?php echo e($reintegroSeleccionado->estadoReintegro->descripcion ?? 'Sin Estado'); ?>

                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Detalles del Reintegro -->
                            <div>
                                <h3 class="text-sm font-semibold text-secondary-800 border-b border-secondary-200 pb-1 mb-2">Detalles del Reintegro</h3>
                                <div class="space-y-1 text-xs">
                                    <div><span class="font-medium text-secondary-600">Descripción:</span></div>
                                    <div class="text-secondary-900 text-xs bg-secondary-50 p-2 rounded"><?php echo e($reintegroSeleccionado->descripcion_gasto); ?></div>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div><span class="font-medium text-secondary-600">Monto Solicitado:</span> <span class="text-secondary-900 font-bold">$ <?php echo e(number_format($reintegroSeleccionado->monto_solicitado, 2)); ?></span></div>
                                        <!--[if BLOCK]><![endif]--><?php if($reintegroSeleccionado->monto_autorizado): ?>
                                            <div><span class="font-medium text-secondary-600">Monto Autorizado:</span> <span class="text-success-600 font-bold">$ <?php echo e(number_format($reintegroSeleccionado->monto_autorizado, 2)); ?></span></div>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                    <!--[if BLOCK]><![endif]--><?php if($reintegroSeleccionado->fecha_autorizacion || $reintegroSeleccionado->fecha_pago || $reintegroSeleccionado->numero_transferencia): ?>
                                        <div class="grid grid-cols-2 gap-3">
                                            <!--[if BLOCK]><![endif]--><?php if($reintegroSeleccionado->fecha_autorizacion): ?>
                                                <div><span class="font-medium text-secondary-600">Fecha Autorización:</span> <span class="text-secondary-900"><?php echo e($reintegroSeleccionado->fecha_autorizacion->format('d/m/Y')); ?></span></div>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            <!--[if BLOCK]><![endif]--><?php if($reintegroSeleccionado->fecha_pago): ?>
                                                <div><span class="font-medium text-secondary-600">Fecha Pago:</span> <span class="text-secondary-900"><?php echo e($reintegroSeleccionado->fecha_pago->format('d/m/Y')); ?></span></div>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            <!--[if BLOCK]><![endif]--><?php if($reintegroSeleccionado->numero_transferencia): ?>
                                                <div class="col-span-2"><span class="font-medium text-secondary-600">No. Transferencia:</span> <span class="text-secondary-900"><?php echo e($reintegroSeleccionado->numero_transferencia); ?></span></div>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>

                            <!-- Alumnos Afectados y Tipos de Gastos en el mismo row -->
                            <div class="grid grid-cols-2 gap-3">
                                <!-- Alumnos Afectados -->
                                <div>
                                    <h3 class="text-sm font-semibold text-secondary-800 border-b border-secondary-200 pb-1 mb-2">Alumnos Afectados</h3>
                                    <!--[if BLOCK]><![endif]--><?php if($reintegroSeleccionado->accidente->alumnos && $reintegroSeleccionado->accidente->alumnos->count() > 0): ?>
                                        <div class="space-y-1">
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $reintegroSeleccionado->accidente->alumnos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accidenteAlumno): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="text-xs">
                                                    <span class="font-medium text-secondary-900"><?php echo e($accidenteAlumno->alumno->nombre_completo ?? 'N/A'); ?></span>
                                                    <span class="text-secondary-600">(<?php echo e($accidenteAlumno->grado_seccion ?? 'N/A'); ?>)</span>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                    <?php else: ?>
                                        <p class="text-xs text-secondary-500">No hay información disponible.</p>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>

                                <!-- Tipos de Gastos -->
                                <div>
                                    <h3 class="text-sm font-semibold text-secondary-800 border-b border-secondary-200 pb-1 mb-2">Tipos de Gastos</h3>
                                    <!--[if BLOCK]><![endif]--><?php if($reintegroSeleccionado->tiposGastos && $reintegroSeleccionado->tiposGastos->count() > 0): ?>
                                        <div class="flex flex-wrap gap-1">
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $reintegroSeleccionado->tiposGastos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipoGasto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                                                    <?php echo e($tipoGasto->descripcion); ?>

                                                </span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                    <?php else: ?>
                                        <p class="text-xs text-secondary-500">No especificados.</p>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>

                            <!-- Documentos Adjuntos - Con scroll y fecha de carga -->
                            <div>
                                <h3 class="text-sm font-semibold text-secondary-800 border-b border-secondary-200 pb-1 mb-2">Documentos Adjuntos</h3>
                                <div class="max-h-40 overflow-y-auto space-y-1">
                                    <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $reintegroSeleccionado->archivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <div class="bg-white border border-secondary-200 rounded-md p-2 shadow-sm hover:shadow-md transition-shadow duration-200">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-2 flex-1 min-w-0">
                                                    <div class="flex-shrink-0">
                                                        <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-xs font-medium text-secondary-900 truncate"><?php echo e($doc->nombre_archivo); ?></p>
                                                        <p class="text-xs text-secondary-500"><?php echo e($doc->fecha_carga ? \Carbon\Carbon::parse($doc->fecha_carga)->format('d/m/Y H:i') : 'N/A'); ?></p>
                                                    </div>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <a href="<?php echo e(Storage::url($doc->ruta_archivo)); ?>" target="_blank" class="inline-flex items-center px-2 py-1 bg-primary-600 text-white text-xs font-medium rounded hover:bg-primary-700 transition-colors duration-200">
                                                        Ver
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <div class="bg-secondary-50 border-2 border-dashed border-secondary-300 rounded-md p-3 text-center">
                                            <svg class="w-6 h-6 text-secondary-400 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <p class="text-xs text-secondary-500">No hay documentos adjuntos</p>
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Columna Derecha: Historial -->
                    <div class="w-1/3 p-6 bg-secondary-25">
                        <h3 class="text-lg font-semibold text-secondary-800 border-b border-secondary-200 pb-2 mb-4">Historial de Reintegro</h3>
                        
                        <!-- Área de historial con scroll -->
                        <div class="h-96 overflow-y-auto space-y-4 mb-4">
                            <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $historialReintegro; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entrada): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="bg-white rounded-lg p-4 border border-secondary-200 shadow-sm">
                                    <div class="flex items-start justify-between mb-2">
                                        <div class="flex items-center space-x-2">
                                            <?php
                                                $claseColor = match($entrada['accion']) {
                                                    'aceptar' => 'bg-success-100 text-success-800',
                                                    'rechazar' => 'bg-danger-100 text-danger-800',
                                                    'solicitar_informacion' => 'bg-warning-100 text-warning-800',
                                                    default => 'bg-info-100 text-info-800'
                                                };
                                                $textoAccion = match($entrada['accion']) {
                                                    'aceptar' => 'Aprobado',
                                                    'rechazar' => 'Rechazado',
                                                    'solicitar_informacion' => 'Info Solicitada',
                                                    'mensaje' => 'Mensaje',
                                                    default => 'Acción'
                                                };
                                            ?>
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium <?php echo e($claseColor); ?>">
                                                <?php echo e($textoAccion); ?>

                                            </span>
                                        </div>
                                        <span class="text-xs text-secondary-500"><?php echo e(\Carbon\Carbon::parse($entrada['fecha_hora'])->format('d/m/Y H:i')); ?></span>
                                    </div>
                                    <p class="text-sm text-secondary-700 mb-2"><?php echo e($entrada['mensaje']); ?></p>
                                    <p class="text-xs text-secondary-500">Por: <?php echo e($entrada['usuario']['nombre'] ?? $entrada['usuario']['name'] ?? 'Usuario'); ?></p>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="text-center py-8">
                                    <svg class="w-12 h-12 text-secondary-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a8.959 8.959 0 01-4.906-1.436L3 21l2.436-5.094A8.959 8.959 0 013 12c0-4.418 3.582-8 8-8s8 3.582 8 8z"></path>
                                    </svg>
                                    <p class="text-sm text-secondary-500">No hay historial disponible</p>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                </div>

                <!-- Footer del Modal con Botones de Acción -->
                <div class="px-6 py-4 bg-secondary-50 border-t border-secondary-200 rounded-b-xl">
                    <div class="flex justify-end items-center space-x-3 flex-wrap gap-2">
                        <!--[if BLOCK]><![endif]--><?php if(optional($reintegroSeleccionado)->id_estado_reintegro == $estadoAutorizadoId): ?>
                            <button wire:click="mostrarModalPago" class="inline-flex items-center px-4 py-2 bg-info-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-info-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-info-500">
                                <i class="fas fa-money-bill-wave mr-2"></i>
                                Marcar como Pagado
                            </button>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <?php if(optional($reintegroSeleccionado)->id_estado_reintegro == $estadoNuevoId || optional($reintegroSeleccionado)->id_estado_reintegro == $estadoPendienteInfoId): ?>
                            <button wire:click="mostrarModalAprobacion" class="inline-flex items-center px-4 py-2 bg-success-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-success-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-success-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Aprobar
                            </button>
                            <button wire:click="mostrarModalRechazo" class="inline-flex items-center px-4 py-2 bg-danger-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-danger-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-danger-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                Rechazar
                            </button>
                            <button wire:click="mostrarModalSolicitudInfo" class="inline-flex items-center px-4 py-2 bg-warning-500 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-warning-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-warning-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.546-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Solicitar Información
                            </button>
                            <button wire:click="mostrarModalMensaje" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a8.959 8.959 0 01-4.906-1.436L3 21l2.436-5.094A8.959 8.959 0 013 12c0-4.418 3.582-8 8-8s8 3.582 8 8z"></path></svg>
                                Enviar Mensaje
                            </button>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <button @click="showDetail = false" wire:click="cerrarDetalle" class="inline-flex items-center px-4 py-2 bg-secondary-200 border border-transparent rounded-lg font-medium text-sm text-secondary-700 hover:bg-secondary-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-500">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
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
            <div>
                <textarea wire:model="solicitudInfoTexto"
                          class="w-full h-32 p-3 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                          placeholder="Ej: Por favor, adjuntar el informe médico detallado y la factura de la consulta..."></textarea>
                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['solicitudInfoTexto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
            <div class="flex justify-end items-center mt-6 space-x-3">
                <button wire:click="cancelarSolicitud" class="px-4 py-2 bg-secondary-200 text-secondary-800 rounded-lg hover:bg-secondary-300 transition-colors">
                    Cancelar
                </button>
                <button wire:click="solicitarInformacion" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
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
            <div>
                <textarea wire:model="motivoRechazo"
                          class="w-full h-32 p-3 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-danger-500 focus:border-danger-500 transition"
                          placeholder="Ej: La documentación presentada no corresponde con el accidente reportado..."></textarea>
                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['motivoRechazo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
            <div class="flex justify-end items-center mt-6 space-x-3">
                <button wire:click="cancelarRechazo" class="px-4 py-2 bg-secondary-200 text-secondary-800 rounded-lg hover:bg-secondary-300 transition-colors">
                    Cancelar
                </button>
                <button wire:click="rechazarReintegro" class="px-4 py-2 bg-danger-600 text-white rounded-lg hover:bg-danger-700 transition-colors">
                    Confirmar Rechazo
                </button>
            </div>
        </div>
    </div>

    <!-- Modal para Aprobación de Reintegro -->
    <div x-show="showAprobacionModal"
         class="fixed inset-0 bg-gray-900 bg-opacity-60 z-50 flex justify-center items-center"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-6 m-4" @click.away="showAprobacionModal = false">
            <h3 class="text-xl font-semibold text-secondary-900 mb-4">Aprobar Reintegro</h3>
            <p class="text-sm text-secondary-600 mb-4">
                Ingresa el monto final autorizado para este reintegro y cualquier observación adicional.
            </p>
            <div class="space-y-4">
                <div>
                    <label for="montoAutorizado" class="block text-sm font-medium text-secondary-700">Monto Autorizado <span class="text-danger-500">*</span></label>
                    <input type="number" step="0.01" wire:model="montoAutorizado" id="montoAutorizado" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:ring-2 focus:ring-success-500 focus:border-success-500">
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['montoAutorizado'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                <div>
                    <label for="observacionesAuditor" class="block text-sm font-medium text-secondary-700">Observaciones del Auditor</label>
                    <textarea wire:model="observacionesAuditor" id="observacionesAuditor" rows="3" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:ring-2 focus:ring-success-500 focus:border-success-500" placeholder="Observaciones adicionales..."></textarea>
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['observacionesAuditor'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
            <div class="flex justify-end items-center mt-6 space-x-3">
                <button wire:click="cancelarAprobacion" class="px-4 py-2 bg-secondary-200 text-secondary-800 rounded-lg hover:bg-secondary-300 transition-colors">
                    Cancelar
                </button>
                <button wire:click="aprobarReintegro" class="px-4 py-2 bg-success-600 text-white rounded-lg hover:bg-success-700 transition-colors">
                    Confirmar Aprobación
                </button>
            </div>
        </div>
    </div>

    <!-- Modal para Marcar como Pagado -->
    <div x-show="showPagoModal"
         class="fixed inset-0 bg-gray-900 bg-opacity-60 z-50 flex justify-center items-center"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-6 m-4" @click.away="showPagoModal = false">
            <h3 class="text-xl font-semibold text-secondary-900 mb-4">Marcar Reintegro como Pagado</h3>
            <p class="text-sm text-secondary-600 mb-4">
                Confirma que el reintegro ha sido pagado e ingresa el número de transferencia.
            </p>
            <div class="space-y-4">
                <div>
                    <label for="numeroTransferencia" class="block text-sm font-medium text-secondary-700">Número de Transferencia <span class="text-danger-500">*</span></label>
                    <input type="text" wire:model="numeroTransferencia" id="numeroTransferencia" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:ring-2 focus:ring-info-500 focus:border-info-500">
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['numeroTransferencia'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
            <div class="flex justify-end items-center mt-6 space-x-3">
                <button wire:click="cancelarPago" class="px-4 py-2 bg-secondary-200 text-secondary-800 rounded-lg hover:bg-secondary-300 transition-colors">
                    Cancelar
                </button>
                <button wire:click="marcarComoPagado" class="px-4 py-2 bg-info-600 text-white rounded-lg hover:bg-info-700 transition-colors">
                    Confirmar Pago
                </button>
            </div>
        </div>
    </div>

    <!-- Modal para Enviar Mensaje -->
    <div x-show="showMensajeModal"
         class="fixed inset-0 bg-gray-900 bg-opacity-60 z-50 flex justify-center items-center"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-6 m-4" @click.away="showMensajeModal = false">
            <h3 class="text-xl font-semibold text-secondary-900 mb-4">Enviar Mensaje</h3>
            <p class="text-sm text-secondary-600 mb-4">
                Envía un mensaje a la escuela sobre este reintegro. El mensaje será registrado en el historial y la escuela recibirá una notificación.
            </p>
            <div>
                <textarea wire:model="textoMensaje"
                          class="w-full h-32 p-3 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                          placeholder="Escribe tu mensaje aquí..."></textarea>
                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['textoMensaje'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
            <div class="flex justify-end items-center mt-6 space-x-3">
                <button wire:click="cancelarMensaje" class="px-4 py-2 bg-secondary-200 text-secondary-800 rounded-lg hover:bg-secondary-300 transition-colors">
                    Cancelar
                </button>
                <button wire:click="enviarMensaje" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                    Enviar Mensaje
                </button>
            </div>
        </div>
    </div>
</div><?php /**PATH /home/passion/Documents/FondoSolidarioEntrega11/Fondo Solidario Entrega/resources/views/livewire/reintegros/pendientes.blade.php ENDPATH**/ ?>