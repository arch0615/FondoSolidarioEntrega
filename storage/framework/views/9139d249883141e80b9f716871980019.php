<div>
    <div class="mx-auto px-4">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 mb-8">
        <div>
            <h1 class="text-2xl font-semibold text-secondary-900">Historial de Auditorías</h1>
            <p class="mt-1 text-sm text-secondary-600">Consulta el historial de reintegros auditados.</p>
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-xl border border-secondary-200 mb-6">
        <details class="group" open>
            <summary class="flex items-center justify-between p-6 cursor-pointer list-none">
                <div class="flex items-center text-secondary-900">
                    <svg class="w-5 h-5 mr-3 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"></path>
                    </svg>
                    <span class="font-medium">Filtros</span>
                </div>
                <svg class="w-5 h-5 text-secondary-400 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </summary>
            <div class="px-6 pb-6">
                <form class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="space-y-1">
                        <label for="filtro_busqueda" class="block text-sm font-medium text-secondary-700">Buscar</label>
                        <input type="text" name="filtro_busqueda" id="filtro_busqueda" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Buscar por alumno, escuela...">
                    </div>
                    <div class="space-y-1">
                        <label for="filtro_estado" class="block text-sm font-medium text-secondary-700">Estado</label>
                        <select name="filtro_estado" id="filtro_estado" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option value="">Todos</option>
                            <option value="Aprobado">Aprobado</option>
                            <option value="Rechazado">Rechazado</option>
                            <option value="Solicitud de Información">Solicitud de Información</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label for="filtro_escuela" class="block text-sm font-medium text-secondary-700">Escuela</label>
                        <select wire:model.lazy="filtro_escuela" id="filtro_escuela" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option value="">Todas</option>
                            <?php $__currentLoopData = $escuelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $escuela): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($escuela); ?>"><?php echo e($escuela); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label for="filtro_fecha_desde" class="block text-sm font-medium text-secondary-700">Fecha Desde</label>
                            <input wire:model.lazy="filtro_fecha_desde" type="date" id="filtro_fecha_desde" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm">
                        </div>
                        <div class="space-y-1">
                            <label for="filtro_fecha_hasta" class="block text-sm font-medium text-secondary-700">Fecha Hasta</label>
                            <input wire:model.lazy="filtro_fecha_hasta" type="date" id="filtro_fecha_hasta" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm">
                        </div>
                    </div>
                    <div class="flex items-end col-span-full">
                        <button type="submit" class="w-full md:w-auto inline-flex justify-center items-center px-6 py-2 bg-secondary-900 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-secondary-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-500 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Buscar
                        </button>
                    </div>
                </form>
            </div>
        </details>
    </div>

    <!-- Tabla de Historial -->
    <div class="bg-white rounded-xl border border-secondary-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-secondary-200">
                <thead class="bg-secondary-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Alumno</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Escuela</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Cód. Accidente</th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-medium text-secondary-500 uppercase tracking-wider">Monto Solicitado</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Fecha Solicitud</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-secondary-500 uppercase tracking-wider">Estado</th>
                        <th scope="col" " class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Detalles</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-secondary-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-secondary-200">
                    <?php $__empty_1 = true; $__currentLoopData = $reintegros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reintegro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-secondary-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-secondary-900"><?php echo e($reintegro['nombre_alumno']); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-secondary-900"><?php echo e($reintegro['escuela']); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-500">
                                <?php echo e($reintegro['codigo_accidente']); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-secondary-900 font-medium">
                                $<?php echo e(number_format($reintegro['monto_solicitado'], 2)); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-500">
                                <?php echo e(\Carbon\Carbon::parse($reintegro['fecha_solicitud'])->format('d/m/Y')); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <?php if($reintegro['estado'] == 'Aprobado'): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-100 text-success-800">
                                        Aprobado
                                    </span>
                                <?php elseif($reintegro['estado'] == 'Rechazado'): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-danger-100 text-danger-800">
                                        Rechazado
                                    </span>
                                <?php elseif($reintegro['estado'] == 'Solicitud de Información'): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-warning-100 text-warning-800">
                                        Solicitud de Información
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-500">
                                <?php if($reintegro['estado'] == 'Aprobado'): ?>
                                    <div><strong>Fecha Aprobación:</strong> <?php echo e($reintegro['fecha_aprobacion']); ?></div>
                                <?php elseif($reintegro['estado'] == 'Rechazado'): ?>
                                    <div><strong>Motivo:</strong> <?php echo e($reintegro['motivo_rechazo']); ?></div>
                                    <div><strong>Fecha Rechazo:</strong> <?php echo e($reintegro['fecha_rechazo']); ?></div>
                                <?php elseif($reintegro['estado'] == 'Solicitud de Información'): ?>
                                    <div><strong>Solicitud:</strong> <?php echo e($reintegro['solicitud_informacion']); ?></div>
                                    <div><strong>Fecha Solicitud:</strong> <?php echo e($reintegro['fecha_solicitud']); ?></div>
                                    <div><strong>Días Transcurridos:</strong> <?php echo e($reintegro['dias_transcurridos']); ?></div>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <button wire:click="showReintegroModal(<?php echo e($reintegro['id']); ?>)" class="p-2 text-secondary-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors duration-200" title="Ver reintegro">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="text-center">
                                    <svg class="mx-auto h-12 w-12 text-secondary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-secondary-900">No hay reintegros</h3>
                                    <p class="mt-1 text-sm text-secondary-500">No se encontraron reintegros para mostrar.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="px-6 py-4 bg-secondary-50 border-t border-secondary-200 flex flex-col sm:flex-row items-center justify-between">
            <div class="text-sm text-secondary-700 mb-4 sm:mb-0">
                Mostrando <span class="font-medium text-secondary-900">1</span> a <span class="font-medium text-secondary-900">3</span> de <span class="font-medium text-secondary-900">3</span> resultados
            </div>
            <nav class="inline-flex rounded-lg shadow-sm" aria-label="Paginación">
                <button type="button" class="relative inline-flex items-center px-2 py-2 rounded-l-lg border border-secondary-300 bg-white text-sm font-medium text-secondary-500 hover:bg-secondary-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                    <span class="sr-only">Anterior</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <button type="button" class="relative inline-flex items-center px-4 py-2 border border-secondary-300 bg-primary-600 text-sm font-medium text-white hover:bg-primary-700 focus:z-10 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500" aria-current="page">
                    1
                </button>
                <button type="button" class="relative inline-flex items-center px-2 py-2 rounded-r-lg border border-secondary-300 bg-white text-sm font-medium text-secondary-500 hover:bg-secondary-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500" disabled>
                    <span class="sr-only">Siguiente</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </nav>
        </div>
    
        <?php if($showModal && $selectedReintegro): ?>
        <!-- Modal -->
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" x-data="{ showModal: <?php if ((object) ('showModal') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showModal'->value()); ?>')<?php echo e('showModal'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showModal'); ?>')<?php endif; ?> }" x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl mx-4" @click.away="$wire.closeModal()">
                <div class="p-6 border-b border-secondary-200 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-secondary-900">Detalle del Reintegro</h3>
                    <button wire:click="closeModal" class="text-secondary-400 hover:text-secondary-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="p-6 space-y-6 max-h-[70vh] overflow-y-auto">
                    <!-- Información del Reintegro -->
                    <div>
                        <h4 class="font-semibold text-secondary-800 mb-3">Información del Reintegro</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div><strong class="text-secondary-600">Alumno:</strong> <?php echo e($selectedReintegro['nombre_alumno']); ?></div>
                            <div><strong class="text-secondary-600">Escuela:</strong> <?php echo e($selectedReintegro['escuela']); ?></div>
                            <div><strong class="text-secondary-600">Cód. Accidente:</strong> <?php echo e($selectedReintegro['codigo_accidente']); ?></div>
                            <div><strong class="text-secondary-600">Monto Solicitado:</strong> $<?php echo e(number_format($selectedReintegro['monto_solicitado'], 2)); ?></div>
                            <div><strong class="text-secondary-600">Estado:</strong> <?php echo e($selectedReintegro['estado']); ?></div>
                        </div>
                    </div>
    
                    <!-- Información del Accidente -->
                    <div>
                        <h4 class="font-semibold text-secondary-800 mb-3">Información del Accidente</h4>
                        <p class="text-sm text-secondary-700 bg-secondary-50 p-4 rounded-lg"><?php echo e($selectedReintegro['info_accidente']); ?></p>
                    </div>
    
                    <!-- Documentos Adjuntos -->
                    <div>
                        <h4 class="font-semibold text-secondary-800 mb-3">Documentos Adjuntos</h4>
                        <ul class="space-y-2">
                            <?php $__empty_1 = true; $__currentLoopData = $selectedReintegro['documentos']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <li class="flex items-center justify-between p-3 bg-secondary-50 rounded-lg border border-secondary-200">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-3 text-secondary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    <span class="text-sm text-secondary-800"><?php echo e($doc['nombre']); ?></span>
                                </div>
                                <a href="<?php echo e($doc['url']); ?>" target="_blank" class="text-sm text-primary-600 hover:text-primary-800 font-medium">Ver</a>
                            </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <li class="text-sm text-secondary-500">No hay documentos adjuntos.</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                <div class="p-6 bg-secondary-50 border-t border-secondary-200 text-right">
                    <button wire:click="closeModal" class="px-4 py-2 bg-secondary-200 text-secondary-800 rounded-lg hover:bg-secondary-300 transition-colors">Cerrar</button>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div><?php /**PATH C:\Users\rican\OneDrive\Documentos\workana\Fondo Solidario\resources\views\livewire\auditoria\historial-auditorias.blade.php ENDPATH**/ ?>