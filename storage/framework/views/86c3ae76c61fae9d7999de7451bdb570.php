<div class="mx-auto px-4">
    <?php if(session()->has('message')): ?>
        <div class="mb-6 bg-success-50 border border-success-200 text-success-700 px-4 py-3 rounded-lg relative">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="font-medium"><?php echo e(session('message')); ?></span>
            </div>
        </div>
    <?php endif; ?>

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 mb-8">
        <div>
            <h1 class="text-2xl font-semibold text-secondary-900">Gestión de Reintegros</h1>
            <p class="mt-1 text-sm text-secondary-600">Administra las solicitudes de reintegro de gastos médicos.</p>
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
            <a href="<?php echo e(route('reintegros.create')); ?>" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nuevo Reintegro
            </a>
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
                <?php if(Auth::user()->id_rol != 1): ?>
                <div class="space-y-1">
                    <label for="filtro_escuela" class="block text-sm font-medium text-secondary-700">Escuela</label>
                    <select wire:model.live="filtro_escuela" id="filtro_escuela" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Todas</option>
                        <?php $__currentLoopData = $escuelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $escuela): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($escuela->id_escuela); ?>"><?php echo e($escuela->nombre); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <?php endif; ?>
                <div class="space-y-1">
                    <label for="filtro_fecha_solicitud" class="block text-sm font-medium text-secondary-700">Fecha Solicitud</label>
                    <input wire:model.live="filtro_fecha_solicitud" type="date" id="filtro_fecha_solicitud" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div class="space-y-1">
                    <label for="filtro_estado" class="block text-sm font-medium text-secondary-700">Estado</label>
                    <select wire:model.live="filtro_estado" id="filtro_estado" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Todos</option>
                        <?php $__currentLoopData = $estados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($estado->id_estado_reintegro); ?>"><?php echo e($estado->descripcion); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                <?php if($sortField === 'id_reintegro'): ?>
                                    <?php if($sortDirection === 'asc'): ?> <svg class="ml-2 w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                    <?php else: ?> <svg class="ml-2 w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    <?php endif; ?>
                                <?php else: ?> <svg class="ml-2 w-4 h-4 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path></svg>
                                <?php endif; ?>
                            </button>
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Accidente (Alumno)</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                            <button wire:click="sortBy('fecha_solicitud')" class="group inline-flex items-center">
                                Fecha Solicitud
                                <?php if($sortField === 'fecha_solicitud'): ?>
                                    <?php if($sortDirection === 'asc'): ?> <svg class="ml-2 w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                    <?php else: ?> <svg class="ml-2 w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    <?php endif; ?>
                                <?php else: ?> <svg class="ml-2 w-4 h-4 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path></svg>
                                <?php endif; ?>
                            </button>
                        </th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-medium text-secondary-500 uppercase tracking-wider">
                            <button wire:click="sortBy('monto_solicitado')" class="group inline-flex items-center">
                                Monto Solicitado
                                <?php if($sortField === 'monto_solicitado'): ?>
                                    <?php if($sortDirection === 'asc'): ?> <svg class="ml-2 w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                    <?php else: ?> <svg class="ml-2 w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    <?php endif; ?>
                                <?php else: ?> <svg class="ml-2 w-4 h-4 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path></svg>
                                <?php endif; ?>
                            </button>
                        </th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-secondary-500 uppercase tracking-wider">Estado</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-secondary-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-secondary-200">
                    <?php $__empty_1 = true; $__currentLoopData = $reintegros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reintegro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-secondary-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-secondary-900"><?php echo e($reintegro->id_reintegro); ?></div>
                        </td>
                         <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-secondary-900"><?php echo e($reintegro->accidente->id_accidente_entero ?? 'N/A'); ?> (<?php echo e($reintegro->alumno->nombre_completo ?? 'N/A'); ?>)</div>
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
                                <a href="<?php echo e(route('reintegros.show', $reintegro->id_reintegro)); ?>" class="p-2 text-secondary-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors duration-200" title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <?php if($reintegro->id_estado_reintegro == 2): ?> 
                                    <button wire:click="showObservation(<?php echo e($reintegro->id_reintegro); ?>)" class="p-2 text-info-400 hover:text-info-600 hover:bg-info-50 rounded-lg transition-colors duration-200" title="Ver Información Solicitada">
                                        <i class="fas fa-info-circle"></i>
                                    </button>
                                <?php endif; ?>
                                <?php if($reintegro->id_estado_reintegro == 4): ?> 
                                    <button wire:click="showObservation(<?php echo e($reintegro->id_reintegro); ?>)" class="p-2 text-danger-400 hover:text-danger-600 hover:bg-danger-50 rounded-lg transition-colors duration-200" title="Ver Motivo de Rechazo">
                                        <i class="fas fa-comment-alt-slash"></i>
                                    </button>
                                <?php endif; ?>
                                <?php if($reintegro->id_estado_reintegro == $estadoPagadoId): ?>
                                    <button wire:click="showPagoInfo(<?php echo e($reintegro->id_reintegro); ?>)" class="p-2 text-success-400 hover:text-success-600 hover:bg-success-50 rounded-lg transition-colors duration-200" title="Ver Información de Pago">
                                        <i class="fas fa-dollar-sign"></i>
                                    </button>
                                <?php endif; ?>
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
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="px-6 py-4 bg-secondary-50 border-t border-secondary-200">
            <div class="flex flex-col sm:flex-row items-center justify-between">
                <div class="text-sm text-secondary-700 mb-4 sm:mb-0">
                    <?php if($reintegros->total() > 0): ?>
                        Mostrando <span class="font-medium text-secondary-900"><?php echo e($reintegros->firstItem()); ?></span> a <span class="font-medium text-secondary-900"><?php echo e($reintegros->lastItem()); ?></span> de <span class="font-medium text-secondary-900"><?php echo e($reintegros->total()); ?></span> resultados
                    <?php else: ?>
                        No hay resultados para mostrar
                    <?php endif; ?>
                </div>
                <?php if($reintegros->hasPages()): ?>
                    <?php echo e($reintegros->links('pagination.custom-tailwind')); ?>

                <?php endif; ?>
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
    <?php if($pagoInfoToShow): ?>
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
    <?php endif; ?>
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
<?php $__env->stopPush(); ?><?php /**PATH C:\Users\rican\OneDrive\Documentos\workana\Fondo Solidario\resources\views\livewire\reintegros\index.blade.php ENDPATH**/ ?>