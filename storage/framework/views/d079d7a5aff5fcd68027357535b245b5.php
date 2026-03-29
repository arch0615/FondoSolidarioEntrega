<div class="mx-auto px-4">
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
            <!--[if BLOCK]><![endif]--><?php if(Auth::user()->id_rol == 3): ?>
                <h1 class="text-2xl font-semibold text-secondary-900">Historial de Auditorías</h1>
                <p class="mt-1 text-sm text-secondary-600">Listado de Auditorías atendidas</p>
            <?php else: ?>
                <h1 class="text-2xl font-semibold text-secondary-900">Gestión de Reintegros</h1>
                <p class="mt-1 text-sm text-secondary-600">Administra las solicitudes de reintegro de gastos médicos.</p>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
        <div class="flex items-center space-x-3">
            <!-- Botón de Exportar -->
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="inline-flex items-center px-4 py-2 bg-white border border-secondary-300 rounded-lg font-medium text-sm text-secondary-700 hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    <i class="fas fa-download mr-2"></i>
                    Exportar
                    <i class="fas fa-chevron-down ml-2 -mr-1 h-5 w-5"></i>
                </button>
                <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10" style="display:none;">
                    <div class="py-1" role="menu" aria-orientation="vertical">
                        <button onclick="exportarReintegros('csv')" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900 w-full text-left" role="menuitem">
                            <i class="fas fa-file-csv fa-fw text-secondary-400"></i>
                            Exportar a CSV
                        </button>
                        <button onclick="exportarReintegros('excel')" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900 w-full text-left" role="menuitem">
                            <i class="fas fa-file-excel fa-fw text-secondary-400"></i>
                            Exportar a Excel
                        </button>
                        <button onclick="exportarReintegros('pdf')" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900 w-full text-left" role="menuitem">
                            <i class="fas fa-file-pdf fa-fw text-secondary-400"></i>
                            Exportar a PDF
                        </button>
                    </div>
                </div>
            </div>
            <?php if(Auth::user()->id_rol != 3): ?>
            <a href="<?php echo e(route('reintegros.create')); ?>" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nuevo Reintegro
            </a>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-xl border border-secondary-200 mb-6">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <div class="space-y-1">
                    <label for="filtro_id_accidente" class="block text-sm font-medium text-secondary-700">ID Accidente</label>
                    <input wire:model.live="filtro_id_accidente" type="text" id="filtro_id_accidente" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Buscar por ID Accidente">
                </div>
                <div class="space-y-1">
                    <label for="filtro_alumno" class="block text-sm font-medium text-secondary-700">Alumno (Nombre/DNI)</label>
                    <input wire:model.live="filtro_alumno" type="text" id="filtro_alumno" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Nombre, apellido o DNI">
                </div>
                <?php if(Auth::user()->id_rol != 1): ?>
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
                <div class="space-y-1">
                    <label for="filtro_estado" class="block text-sm font-medium text-secondary-700">Estado</label>
                    <select wire:model.live="filtro_estado" id="filtro_estado" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Todos</option>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $estados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($estado->id_estado_reintegro); ?>"><?php echo e($estado->descripcion); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </select>
                </div>
                <div class="flex items-end col-span-full">
                    <button wire:click="limpiarFiltros" type="button" class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 bg-secondary-100 border border-transparent rounded-lg font-medium text-sm text-secondary-700 hover:bg-secondary-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-500 transition-colors duration-200">
                        Limpiar Filtros
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Reintegros -->
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
                            <div class="text-sm font-medium text-secondary-900"><?php echo e($reintegro->id_reintegro); ?></div>
                        </td>
                         <td class="px-6 py-4 whitespace-nowrap">
                             <div class="text-sm text-secondary-900"><?php echo e($reintegro->accidente->numero_expediente ?? $reintegro->accidente->id_accidente_entero ?? 'N/A'); ?> (<?php echo e($reintegro->alumno->nombre_completo ?? 'N/A'); ?>)</div>
                             <div class="text-sm text-secondary-500"><?php echo e($reintegro->accidente->escuela->nombre ?? 'N/A'); ?></div>
                         </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-secondary-900"><?php echo e($reintegro->fecha_solicitud ? $reintegro->fecha_solicitud->format('d/m/Y') : 'N/A'); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="text-sm font-medium text-secondary-900">$ <?php echo e(number_format($reintegro->monto_solicitado, 2)); ?></div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="w-24 mx-auto text-xs font-medium text-secondary-900 leading-tight break-words">
                                <?php echo e($reintegro->estadoReintegro->descripcion ?? 'Sin Estado'); ?>

                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <a href="<?php echo e(route('reintegros.show', $reintegro->id_reintegro)); ?>" class="p-2 text-secondary-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors duration-200" title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button wire:click="showHistorial(<?php echo e($reintegro->id_reintegro); ?>)" class="p-2 text-secondary-400 hover:text-info-600 hover:bg-info-50 rounded-lg transition-colors duration-200" title="Ver historial">
                                    <i class="fas fa-history"></i>
                                </button>
                                <!--[if BLOCK]><![endif]--><?php if($reintegro->id_estado_reintegro == 2): ?> 
                                    <button wire:click="showObservation(<?php echo e($reintegro->id_reintegro); ?>)" class="p-2 text-info-400 hover:text-info-600 hover:bg-info-50 rounded-lg transition-colors duration-200" title="Ver Información Solicitada">
                                        <i class="fas fa-info-circle"></i>
                                    </button>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <!--[if BLOCK]><![endif]--><?php if($reintegro->id_estado_reintegro == 4): ?> 
                                    <button wire:click="showObservation(<?php echo e($reintegro->id_reintegro); ?>)" class="p-2 text-danger-400 hover:text-danger-600 hover:bg-danger-50 rounded-lg transition-colors duration-200" title="Ver Motivo de Rechazo">
                                        <i class="fas fa-comment-alt-slash"></i>
                                    </button>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <!--[if BLOCK]><![endif]--><?php if($reintegro->id_estado_reintegro == $estadoPagadoId): ?>
                                    <button wire:click="showPagoInfo(<?php echo e($reintegro->id_reintegro); ?>)" class="p-2 text-success-400 hover:text-success-600 hover:bg-success-50 rounded-lg transition-colors duration-200" title="Ver Información de Pago">
                                        <i class="fas fa-dollar-sign"></i>
                                    </button>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <?php if(Auth::user()->id_rol != 3): ?>
                                <a href="<?php echo e(route('reintegros.edit', $reintegro->id_reintegro)); ?>"
                                   class="p-2 rounded-lg transition-colors duration-200 <?php echo e(in_array($reintegro->id_estado_reintegro, [$estadoRechazadoId, $estadoAutorizadoId, $estadoPagadoId]) ? 'text-secondary-300 cursor-not-allowed' : 'text-secondary-400 hover:text-warning-600 hover:bg-warning-50'); ?>"
                                   title="Editar"
                                   <?php if(in_array($reintegro->id_estado_reintegro, [$estadoRechazadoId, $estadoAutorizadoId, $estadoPagadoId])): ?> onclick="return false;" <?php endif; ?>>
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button wire:click="eliminar(<?php echo e($reintegro->id_reintegro); ?>)"
                                        wire:confirm="¿Estás seguro de que deseas eliminar este reintegro? Esta acción no se puede deshacer."
                                        class="p-2 rounded-lg transition-colors duration-200 <?php echo e(in_array($reintegro->id_estado_reintegro, [$estadoRechazadoId, $estadoAutorizadoId, $estadoPagadoId]) ? 'text-secondary-300 cursor-not-allowed' : 'text-secondary-400 hover:text-danger-600 hover:bg-danger-50'); ?>"
                                        title="Eliminar"
                                        <?php if(in_array($reintegro->id_estado_reintegro, [$estadoRechazadoId, $estadoAutorizadoId, $estadoPagadoId])): ?> disabled <?php endif; ?>>
                                    <i class="fas fa-trash"></i>
                                </button>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-secondary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-secondary-900">No hay reintegros</h3>
                                <p class="mt-1 text-sm text-secondary-500">No se encontraron reintegros que coincidan con los filtros aplicados.</p>
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
    <!-- Modal para Observaciones -->
    <div x-data="{ show: <?php if ((object) ('showingObservationModal') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showingObservationModal'->value()); ?>')<?php echo e('showingObservationModal'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showingObservationModal'); ?>')<?php endif; ?> }"
         x-show="show"
         @keydown.escape.window="show = false"
         class="fixed inset-0 bg-gray-900 bg-opacity-60 z-50 flex justify-center items-center"
         style="display: none;">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-6 m-4" @click.away="show = false">
            <h3 class="text-xl font-semibold text-secondary-900 mb-4">Observaciones del Auditor</h3>
            <p class="text-sm text-secondary-600 mb-4 whitespace-pre-wrap"><?php echo e($observationToShow); ?></p>
            <div class="flex justify-end items-center mt-6">
                <button @click="show = false" wire:click="closeObservationModal" class="px-4 py-2 bg-secondary-200 text-secondary-800 rounded-lg hover:bg-secondary-300 transition-colors">
                    Cerrar
                </button>
            </div>
        </div>
    </div>

    <!-- Modal para Información de Pago -->
    <!--[if BLOCK]><![endif]--><?php if($pagoInfoToShow): ?>
    <div x-data="{ show: <?php if ((object) ('showingPagoInfoModal') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showingPagoInfoModal'->value()); ?>')<?php echo e('showingPagoInfoModal'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showingPagoInfoModal'); ?>')<?php endif; ?> }"
         x-show="show"
         @keydown.escape.window="show = false"
         class="fixed inset-0 bg-gray-900 bg-opacity-60 z-50 flex justify-center items-center"
         style="display: none;">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-6 m-4" @click.away="show = false">
            <h3 class="text-xl font-semibold text-secondary-900 mb-4">Información del Pago</h3>
            <div class="space-y-3 text-sm">
                <p><strong class="font-medium text-secondary-600">Fecha de Pago:</strong> <span class="text-secondary-800"><?php echo e($pagoInfoToShow->fecha_pago ? $pagoInfoToShow->fecha_pago->format('d/m/Y') : 'N/A'); ?></span></p>
                <p><strong class="font-medium text-secondary-600">Número de Transferencia:</strong> <span class="text-secondary-800"><?php echo e($pagoInfoToShow->numero_transferencia ?? 'N/A'); ?></span></p>
            </div>
            <div class="flex justify-end items-center mt-6">
                <button @click="show = false" wire:click="closePagoInfoModal" class="px-4 py-2 bg-secondary-200 text-secondary-800 rounded-lg hover:bg-secondary-300 transition-colors">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!-- Modal para Historial del Reintegro -->
    <div x-data="{ show: <?php if ((object) ('showingHistorialModal') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showingHistorialModal'->value()); ?>')<?php echo e('showingHistorialModal'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showingHistorialModal'); ?>')<?php endif; ?> }"
         x-show="show"
         @keydown.escape.window="show = false"
         class="fixed inset-0 bg-gray-900 bg-opacity-60 z-50 flex justify-center items-center"
         style="display: none;">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[80vh] m-4 flex flex-col" @click.away="show = false">
            <!-- Header del Modal -->
            <div class="flex items-center justify-between p-6 border-b border-secondary-200">
                <h3 class="text-xl font-semibold text-secondary-900">Historial del Reintegro #<?php echo e($reintegroHistorialId); ?></h3>
                <button @click="show = false" wire:click="closeHistorialModal" class="text-secondary-400 hover:text-secondary-600 transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            
            <!-- Contenido del Historial -->
            <div class="flex-1 overflow-y-auto p-6">
                <!--[if BLOCK]><![endif]--><?php if(count($historialReintegro) > 0): ?>
                    <div class="space-y-4">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $historialReintegro; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entrada): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="border-l-4 border-<?php echo e($entrada['color_accion']); ?>-400 bg-<?php echo e($entrada['color_accion']); ?>-50 p-4 rounded-r-lg">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2 mb-2">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-<?php echo e($entrada['color_accion']); ?>-100 text-<?php echo e($entrada['color_accion']); ?>-800">
                                                <?php echo e($entrada['texto_accion']); ?>

                                            </span>
                                            <span class="text-xs text-secondary-500">
                                                por <?php echo e($entrada['usuario']); ?>

                                            </span>
                                        </div>
                                        <!--[if BLOCK]><![endif]--><?php if($entrada['mensaje']): ?>
                                            <p class="text-sm text-secondary-700 mt-2"><?php echo e($entrada['mensaje']); ?></p>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                    <div class="text-xs text-secondary-500 ml-4 whitespace-nowrap">
                                        <?php echo e(\Carbon\Carbon::parse($entrada['fecha_hora'])->format('d/m/Y H:i')); ?>

                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                <?php else: ?>
                    <div class="text-center py-8">
                        <i class="fas fa-history text-4xl text-secondary-300 mb-4"></i>
                        <p class="text-secondary-500">No hay historial disponible para este reintegro.</p>
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
            
            <!-- Footer del Modal -->
            <div class="flex justify-between items-center p-6 border-t border-secondary-200">
                <div class="flex space-x-3">
                    <?php if(Auth::user()->id_rol != 3): ?>
                    <!-- Botón Enviar Mensaje (solo visible para roles que no sean médico auditor) -->
                    <button wire:click="showMessageModal(<?php echo e($reintegroHistorialId); ?>)" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <i class="fas fa-comment mr-2"></i>
                        Enviar Mensaje
                    </button>
                    
                    <!-- Botón Enviar Información Requerida (solo si estado = 2) -->
                    <!--[if BLOCK]><![endif]--><?php if($reintegroParaContestar && $reintegroParaContestar->id_estado_reintegro == 2): ?>
                        <button wire:click="showContestModal(<?php echo e($reintegroHistorialId); ?>)" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                            <i class="fas fa-reply mr-2"></i>
                            Enviar Información Requerida
                        </button>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                <button @click="show = false" wire:click="closeHistorialModal" class="px-4 py-2 bg-secondary-200 text-secondary-800 rounded-lg hover:bg-secondary-300 transition-colors">
                    Cerrar
                </button>
            </div>
        </div>
    </div>

    <!-- Modal para Contestar -->
    <!--[if BLOCK]><![endif]--><?php if($reintegroParaContestar): ?>
    <div x-data="{ show: <?php if ((object) ('showingContestModal') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showingContestModal'->value()); ?>')<?php echo e('showingContestModal'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showingContestModal'); ?>')<?php endif; ?> }"
         x-show="show"
         @keydown.escape.window="show = false"
         class="fixed inset-0 bg-gray-900 bg-opacity-60 z-50 flex justify-center items-center"
         style="display: none;">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] m-4 flex flex-col" @click.away="show = false">
            <!-- Header del Modal -->
            <div class="flex items-center justify-between p-6 border-b border-secondary-200">
                <h3 class="text-xl font-semibold text-secondary-900">Contestar Reintegro #<?php echo e($reintegroParaContestar->id_reintegro); ?></h3>
                <button @click="show = false" wire:click="closeContestModal" class="text-secondary-400 hover:text-secondary-600 transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            
            <!-- Información del Reintegro -->
            <div class="px-6 py-4 bg-secondary-50 border-b border-secondary-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="font-medium text-secondary-600">Alumno:</span>
                        <span class="text-secondary-800"><?php echo e($reintegroParaContestar->alumno->nombre_completo ?? 'N/A'); ?></span>
                    </div>
                    <div>
                        <span class="font-medium text-secondary-600">Escuela:</span>
                        <span class="text-secondary-800"><?php echo e($reintegroParaContestar->accidente->escuela->nombre ?? 'N/A'); ?></span>
                    </div>
                    <div>
                        <span class="font-medium text-secondary-600">Estado:</span>
                        <span class="text-secondary-800"><?php echo e($reintegroParaContestar->estadoReintegro->descripcion ?? 'N/A'); ?></span>
                    </div>
                    <div>
                        <span class="font-medium text-secondary-600">Monto:</span>
                        <span class="text-secondary-800">$<?php echo e(number_format($reintegroParaContestar->monto_solicitado, 2)); ?></span>
                    </div>
                </div>
            </div>
            
            <!-- Formulario de Respuesta -->
            <div class="flex-1 overflow-y-auto p-6">
                <form wire:submit.prevent="enviarRespuesta">
                    <!-- Campo de Mensaje -->
                    <div class="mb-6">
                        <label for="contestMessage" class="block text-sm font-medium text-secondary-700 mb-2">
                            Mensaje <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            wire:model="contestMessage"
                            id="contestMessage"
                            rows="4"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 resize-none"
                            placeholder="Escriba su respuesta aquí..."
                            maxlength="1000"></textarea>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['contestMessage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        <p class="mt-1 text-xs text-secondary-500">Máximo 1000 caracteres</p>
                    </div>

                    <!-- Campo de Archivos -->
                    <div class="mb-6">
                        <label for="contestFiles" class="block text-sm font-medium text-secondary-700 mb-2">
                            Archivos Adjuntos (Opcional)
                        </label>
                        <input
                            wire:model="contestFiles"
                            type="file"
                            id="contestFiles"
                            multiple
                            class="block w-full text-sm text-secondary-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 border border-secondary-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['contestFiles.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        <p class="mt-1 text-xs text-secondary-500">Máximo 10MB por archivo. Formatos permitidos: PDF, JPG, PNG, DOC, DOCX</p>
                    </div>

                    <!-- Descripción de Archivos -->
                    <!--[if BLOCK]><![endif]--><?php if(!empty($contestFiles)): ?>
                    <div class="mb-6">
                        <label for="contestFilesDescription" class="block text-sm font-medium text-secondary-700 mb-2">
                            Descripción de los Archivos (Opcional)
                        </label>
                        <input
                            wire:model="contestFilesDescription"
                            type="text"
                            id="contestFilesDescription"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                            placeholder="Breve descripción de los archivos adjuntos"
                            maxlength="255">
                    </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <!-- Archivos Seleccionados -->
                    <!--[if BLOCK]><![endif]--><?php if(!empty($contestFiles)): ?>
                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-secondary-700 mb-2">Archivos Seleccionados:</h4>
                        <div class="space-y-2">
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $contestFiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex items-center justify-between p-2 bg-secondary-50 rounded-lg">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-file text-secondary-400"></i>
                                        <span class="text-sm text-secondary-700"><?php echo e($file->getClientOriginalName()); ?></span>
                                        <span class="text-xs text-secondary-500">(<?php echo e(number_format($file->getSize() / 1024, 1)); ?> KB)</span>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </form>
            </div>
            
            <!-- Footer del Modal -->
            <div class="flex justify-end space-x-3 p-6 border-t border-secondary-200">
                <button @click="show = false" wire:click="closeContestModal" type="button" class="px-4 py-2 bg-secondary-200 text-secondary-800 rounded-lg hover:bg-secondary-300 transition-colors">
                    Cancelar
                </button>
                <button wire:click="enviarRespuesta" type="button" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Enviar Respuesta
                </button>
            </div>
        </div>
    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!-- Modal para Enviar Mensaje -->
    <!--[if BLOCK]><![endif]--><?php if($reintegroParaMensaje): ?>
    <div x-data="{ show: <?php if ((object) ('showingMessageModal') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showingMessageModal'->value()); ?>')<?php echo e('showingMessageModal'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showingMessageModal'); ?>')<?php endif; ?> }"
         x-show="show"
         @keydown.escape.window="show = false"
         class="fixed inset-0 bg-gray-900 bg-opacity-60 z-50 flex justify-center items-center"
         style="display: none;">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg max-h-[80vh] m-4 flex flex-col" @click.away="show = false">
            <!-- Header del Modal -->
            <div class="flex items-center justify-between p-6 border-b border-secondary-200">
                <h3 class="text-xl font-semibold text-secondary-900">Enviar Mensaje - Reintegro #<?php echo e($reintegroParaMensaje->id_reintegro); ?></h3>
                <button @click="show = false" wire:click="closeMessageModal" class="text-secondary-400 hover:text-secondary-600 transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            
            <!-- Información del Reintegro -->
            <div class="px-6 py-4 bg-secondary-50 border-b border-secondary-200">
                <div class="grid grid-cols-1 gap-2 text-sm">
                    <div>
                        <span class="font-medium text-secondary-600">Alumno:</span>
                        <span class="text-secondary-800"><?php echo e($reintegroParaMensaje->alumno->nombre_completo ?? 'N/A'); ?></span>
                    </div>
                    <div>
                        <span class="font-medium text-secondary-600">Estado:</span>
                        <span class="text-secondary-800"><?php echo e($reintegroParaMensaje->estadoReintegro->descripcion ?? 'N/A'); ?></span>
                    </div>
                </div>
            </div>
            
            <!-- Formulario de Mensaje -->
            <div class="flex-1 overflow-y-auto p-6">
                <form wire:submit.prevent="enviarMensaje">
                    <!-- Campo de Mensaje -->
                    <div class="mb-6">
                        <label for="messageText" class="block text-sm font-medium text-secondary-700 mb-2">
                            Mensaje <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            wire:model="messageText"
                            id="messageText"
                            rows="4"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 resize-none"
                            placeholder="Escriba su mensaje aquí..."
                            maxlength="1000"></textarea>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['messageText'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        <p class="mt-1 text-xs text-secondary-500">Máximo 1000 caracteres</p>
                    </div>
                </form>
            </div>
            
            <!-- Footer del Modal -->
            <div class="flex justify-end space-x-3 p-6 border-t border-secondary-200">
                <button @click="show = false" wire:click="closeMessageModal" type="button" class="px-4 py-2 bg-secondary-200 text-secondary-800 rounded-lg hover:bg-secondary-300 transition-colors">
                    Cancelar
                </button>
                <button wire:click="enviarMensaje" type="button" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Enviar Mensaje
                </button>
            </div>
        </div>
    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    function exportarReintegros(formato) {
        const filtroIdAccidente = window.Livewire.find('<?php echo e($_instance->getId()); ?>').get('filtro_id_accidente');
        const filtroEscuela = window.Livewire.find('<?php echo e($_instance->getId()); ?>').get('filtro_escuela');
        const filtroFechaSolicitud = window.Livewire.find('<?php echo e($_instance->getId()); ?>').get('filtro_fecha_solicitud');
        const filtroEstado = window.Livewire.find('<?php echo e($_instance->getId()); ?>').get('filtro_estado');
        
        const params = new URLSearchParams();
        if (filtroIdAccidente) params.append('filtro_id_accidente', filtroIdAccidente);
        if (filtroEscuela) params.append('filtro_escuela', filtroEscuela);
        if (filtroFechaSolicitud) params.append('filtro_fecha_solicitud', filtroFechaSolicitud);
        if (filtroEstado) params.append('filtro_estado', filtroEstado);
        
        let url = '';
        switch(formato) {
            case 'csv':
                url = '<?php echo e(route("reintegros.export.csv")); ?>';
                break;
            case 'excel':
                url = '<?php echo e(route("reintegros.export.excel")); ?>';
                break;
            case 'pdf':
                url = '<?php echo e(route("reintegros.export.pdf")); ?>';
                break;
        }
        
        if (params.toString()) {
            url += '?' + params.toString();
        }
        
        window.open(url, '_blank');
    }
</script>
<?php $__env->stopPush(); ?><?php /**PATH /home/ubuntu/Documents/FondoSolidarioEntrega/FondoSolidarioEntrega/resources/views/livewire/reintegros/index.blade.php ENDPATH**/ ?>