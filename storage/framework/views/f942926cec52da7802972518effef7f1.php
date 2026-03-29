<div class="mx-auto px-4">
    <!-- 🔥 AGREGAR: Mensajes flash al inicio -->
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
            <h1 class="text-2xl font-semibold text-secondary-900">Gestión de Pasantías / Prácticas Profesionales</h1>
            <p class="mt-1 text-sm text-secondary-600">Administra las pasantías y prácticas profesionales de los alumnos</p>
        </div>
        <div class="flex items-center space-x-3">
            <!-- Botón de Exportar -->
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="inline-flex items-center px-4 py-2 bg-white border border-secondary-300 rounded-lg font-medium text-sm text-secondary-700 hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    <i class="fas fa-download mr-2"></i>
                    Exportar
                    <i class="fas fa-chevron-down ml-2 -mr-1 h-5 w-5"></i>
                </button>
                <div x-show="open"
                     @click.away="open = false"
                     class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10"
                     style="display:none;"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95">
                    <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                        <button onclick="exportarPasantias('csv')" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900 w-full text-left" role="menuitem">
                            <i class="fas fa-file-csv fa-fw text-secondary-400"></i>
                            Exportar a CSV
                        </button>
                        <button onclick="exportarPasantias('excel')" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900 w-full text-left" role="menuitem">
                            <i class="fas fa-file-excel fa-fw text-secondary-400"></i>
                            Exportar a Excel
                        </button>
                        <button onclick="exportarPasantias('pdf')" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900 w-full text-left" role="menuitem">
                            <i class="fas fa-file-pdf fa-fw text-secondary-400"></i>
                            Exportar a PDF
                        </button>
                    </div>
                </div>
            </div>
            <a href="<?php echo e(route('pasantias.create')); ?>" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nueva Pasantía / Práctica Profesional
            </a>
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-xl border border-secondary-200 mb-6">
        <details class="group">
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
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-<?php echo e(auth()->user()->id_rol == 1 ? '4' : '5'); ?> gap-4">
                    <div class="space-y-1">
                        <label for="filtro_empresa" class="block text-sm font-medium text-secondary-700">Empresa</label>
                        <input wire:model.live="filtro_empresa" type="text" id="filtro_empresa" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Buscar por empresa">
                    </div>
                    <div class="space-y-1">
                        <label for="filtro_alumno" class="block text-sm font-medium text-secondary-700">Alumno</label>
                        <input wire:model.live="filtro_alumno" type="text" id="filtro_alumno" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Buscar por alumno">
                    </div>
                    <!--[if BLOCK]><![endif]--><?php if(auth()->user()->id_rol != 1): ?>
                    <div class="space-y-1">
                        <label for="filtro_escuela" class="block text-sm font-medium text-secondary-700">Escuela</label>
                        <select wire:model.live="filtro_escuela" id="filtro_escuela" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option value="">Todas las escuelas</option>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $escuelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $escuela): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($escuela->id_escuela); ?>"><?php echo e($escuela->nombre); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </select>
                    </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <div class="space-y-1">
                        <label for="filtro_fecha_inicio" class="block text-sm font-medium text-secondary-700">Fecha Inicio Desde</label>
                        <input wire:model.live="filtro_fecha_inicio" type="date" id="filtro_fecha_inicio" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    <div class="flex items-end">
                        <button wire:click="limpiarFiltros" type="button" class="w-full inline-flex justify-center items-center px-4 py-2 bg-secondary-100 border border-secondary-300 rounded-lg font-medium text-sm text-secondary-700 hover:bg-secondary-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-500 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Limpiar
                        </button>
                    </div>
                </div>
            </div>
        </details>
    </div>

    <!-- Tabla de Pasantías / Prácticas Profesionales -->
    <div class="bg-white rounded-xl border border-secondary-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-secondary-200">
                <thead class="bg-secondary-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                            <button wire:click="sortBy('alumno')" class="group inline-flex items-center hover:text-secondary-700">
                                Alumno
                                <!--[if BLOCK]><![endif]--><?php if($sortField === 'alumno'): ?>
                                    <!--[if BLOCK]><![endif]--><?php if($sortDirection === 'asc'): ?>
                                        <svg class="ml-2 w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                        </svg>
                                    <?php else: ?>
                                        <svg class="ml-2 w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <?php else: ?>
                                    <svg class="ml-2 w-4 h-4 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                    </svg>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </button>
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                            <button wire:click="sortBy('empresa')" class="group inline-flex items-center hover:text-secondary-700">
                                Empresa
                                <!--[if BLOCK]><![endif]--><?php if($sortField === 'empresa'): ?>
                                    <!--[if BLOCK]><![endif]--><?php if($sortDirection === 'asc'): ?>
                                        <svg class="ml-2 w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                        </svg>
                                    <?php else: ?>
                                        <svg class="ml-2 w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <?php else: ?>
                                    <svg class="ml-2 w-4 h-4 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                    </svg>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </button>
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                            Escuela
                        </th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-secondary-500 uppercase tracking-wider">
                            <button wire:click="sortBy('fecha_inicio')" class="group inline-flex items-center hover:text-secondary-700">
                                Período
                                <!--[if BLOCK]><![endif]--><?php if($sortField === 'fecha_inicio'): ?>
                                    <!--[if BLOCK]><![endif]--><?php if($sortDirection === 'asc'): ?>
                                        <svg class="ml-2 w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                        </svg>
                                    <?php else: ?>
                                        <svg class="ml-2 w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <?php else: ?>
                                    <svg class="ml-2 w-4 h-4 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                    </svg>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </button>
                        </th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-secondary-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-secondary-200">
                    <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $pasantias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pasantia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-secondary-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-secondary-900">
                                <?php echo e($pasantia->alumno ? $pasantia->alumno->nombre . ' ' . $pasantia->alumno->apellido : 'Sin alumno'); ?>

                            </div>
                            <!--[if BLOCK]><![endif]--><?php if($pasantia->alumno && $pasantia->alumno->numero_documento): ?>
                                <div class="text-xs text-secondary-500">DNI: <?php echo e($pasantia->alumno->numero_documento); ?></div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-secondary-900"><?php echo e($pasantia->empresa); ?></div>
                            <!--[if BLOCK]><![endif]--><?php if($pasantia->tutor_empresa): ?>
                                <div class="text-xs text-secondary-500">Tutor: <?php echo e($pasantia->tutor_empresa); ?></div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-secondary-900">
                                <?php echo e($pasantia->escuela ? $pasantia->escuela->nombre : 'Sin escuela'); ?>

                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="text-sm font-medium text-secondary-900">
                                <?php echo e($pasantia->periodo_formateado); ?>

                            </div>
                            <!--[if BLOCK]><![endif]--><?php if($pasantia->horario): ?>
                                <div class="text-xs text-secondary-500"><?php echo e($pasantia->horario); ?></div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <a href="<?php echo e(route('pasantias.show', $pasantia->id_pasantia)); ?>" class="p-2 text-secondary-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors duration-200" title="Ver detalles">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <a href="<?php echo e(route('pasantias.print', $pasantia->id_pasantia)); ?>" target="_blank" class="p-2 text-secondary-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200" title="Imprimir">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                    </svg>
                                </a>
                                <a href="<?php echo e(route('pasantias.edit', $pasantia->id_pasantia)); ?>" class="p-2 text-secondary-400 hover:text-warning-600 hover:bg-warning-50 rounded-lg transition-colors duration-200" title="Editar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <button wire:click="eliminar(<?php echo e($pasantia->id_pasantia); ?>)"
                                        wire:confirm="¿Estás seguro de eliminar esta pasantía?"
                                        class="p-2 text-secondary-400 hover:text-danger-600 hover:bg-danger-50 rounded-lg transition-colors duration-200"
                                        title="Eliminar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="text-secondary-500">
                                <svg class="mx-auto h-8 w-8 text-secondary-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                No hay pasantías / prácticas profesionales registradas que coincidan con los filtros.
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="px-6 py-4 bg-secondary-50 border-t border-secondary-200 flex flex-col sm:flex-row items-center justify-between">
            <div class="text-sm text-secondary-700 mb-4 sm:mb-0">
                <!--[if BLOCK]><![endif]--><?php if($pasantias->total() > 0): ?>
                    Mostrando <?php echo e($pasantias->firstItem()); ?> a <?php echo e($pasantias->lastItem()); ?> de <?php echo e($pasantias->total()); ?> resultados
                <?php else: ?>
                    No hay resultados para mostrar
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
            <!--[if BLOCK]><![endif]--><?php if($pasantias->hasPages()): ?>
                <?php echo e($pasantias->links('pagination.custom-tailwind')); ?>

            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>
    
    <?php $__env->startPush('scripts'); ?>
    <script>
        function exportarPasantias(formato) {
            const filtroEmpresa = window.Livewire.find('<?php echo e($_instance->getId()); ?>').get('filtro_empresa');
            const filtroAlumno = window.Livewire.find('<?php echo e($_instance->getId()); ?>').get('filtro_alumno');
            const filtroEscuela = window.Livewire.find('<?php echo e($_instance->getId()); ?>').get('filtro_escuela');
            const filtroFechaInicio = window.Livewire.find('<?php echo e($_instance->getId()); ?>').get('filtro_fecha_inicio');
            
            const params = new URLSearchParams();
            if (filtroEmpresa) params.append('filtro_empresa', filtroEmpresa);
            if (filtroAlumno) params.append('filtro_alumno', filtroAlumno);
            if (filtroEscuela) params.append('filtro_escuela', filtroEscuela);
            if (filtroFechaInicio) params.append('filtro_fecha_inicio', filtroFechaInicio);
            
            let url = '';
            switch(formato) {
                case 'csv':
                    url = '<?php echo e(route("pasantias.export.csv")); ?>';
                    break;
                case 'excel':
                    url = '<?php echo e(route("pasantias.export.excel")); ?>';
                    break;
                case 'pdf':
                    url = '<?php echo e(route("pasantias.export.pdf")); ?>';
                    break;
            }
            
            if (params.toString()) {
                url += '?' + params.toString();
            }
            
            window.open(url, '_blank');
        }
    </script>
    <?php $__env->stopPush(); ?>
</div><?php /**PATH /home/ubuntu/Documents/FondoSolidarioEntrega/FondoSolidarioEntrega/resources/views/livewire/pasantias/index.blade.php ENDPATH**/ ?>