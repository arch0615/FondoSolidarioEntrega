<div>
    <!-- Mensajes flash -->
    <!--[if BLOCK]><![endif]--><?php if(session()->has('message')): ?>
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg relative">
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
            <h1 class="text-2xl font-semibold text-secondary-900">Gestión de Escuelas</h1>
            <p class="mt-1 text-sm text-secondary-600">Administra las escuelas del sistema</p>
        </div>
        <div class="flex items-center space-x-3">
            <!-- Botón de Exportar -->
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="inline-flex items-center px-4 py-2 bg-white border border-secondary-300 rounded-lg font-medium text-sm text-secondary-700 hover:bg-secondary-50">
                    <i class="fas fa-download mr-2"></i>
                    Exportar
                    <i class="fas fa-chevron-down ml-2 -mr-1 h-5 w-5"></i>
                </button>
                <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10" style="display:none;">
                    <div class="py-1" role="menu">
                        <button onclick="exportarEscuelas('csv')" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 w-full text-left">
                            <i class="fas fa-file-csv fa-fw text-secondary-400"></i> Exportar a CSV
                        </button>
                        <button onclick="exportarEscuelas('excel')" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 w-full text-left">
                            <i class="fas fa-file-excel fa-fw text-secondary-400"></i> Exportar a Excel
                        </button>
                        <button onclick="exportarEscuelas('pdf')" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 w-full text-left">
                            <i class="fas fa-file-pdf fa-fw text-secondary-400"></i> Exportar a PDF
                        </button>
                    </div>
                </div>
            </div>
            <!-- Botón Nueva Escuela -->
            <a href="<?php echo e(route('escuelas.create')); ?>" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-primary-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Nueva Escuela
            </a>
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-xl border border-secondary-200 mb-6">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label for="filtro_nombre" class="block text-sm font-medium text-secondary-700">Nombre</label>
                    <input wire:model.live="filtro_nombre" type="text" id="filtro_nombre" class="block w-full mt-1 px-3 py-2 border border-secondary-300 rounded-lg" placeholder="Buscar por nombre">
                </div>
                <div>
                    <label for="filtro_codigo" class="block text-sm font-medium text-secondary-700">CUIT</label>
                    <input wire:model.live="filtro_codigo" type="text" id="filtro_codigo" class="block w-full mt-1 px-3 py-2 border border-secondary-300 rounded-lg" placeholder="Ej: ESC001">
                </div>
                <div>
                    <label for="filtro_estado" class="block text-sm font-medium text-secondary-700">Estado</label>
                    <select wire:model.live="filtro_estado" id="filtro_estado" class="block w-full mt-1 px-3 py-2 border border-secondary-300 rounded-lg">
                        <option value="">Todos</option>
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button wire:click="limpiarFiltros" type="button" class="w-full inline-flex justify-center items-center px-4 py-2 bg-secondary-200 border border-transparent rounded-lg font-medium text-sm text-secondary-700 hover:bg-secondary-300">
                        Limpiar Filtros
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Vista de Cards de Escuelas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $escuelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $escuela): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="bg-white rounded-xl border border-secondary-200 shadow-sm hover:shadow-lg transition-shadow duration-300 flex flex-col">
            <div class="p-6 flex-grow">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h2 class="text-xl font-semibold text-primary-700"><?php echo e($escuela->nombre); ?></h2>
                        <p class="text-xs text-secondary-500">CUIT: <?php echo e($escuela->codigo_escuela); ?></p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <!--[if BLOCK]><![endif]--><?php if($escuela->activo): ?>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-100 text-success-800">Activo</span>
                        <?php else: ?>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-secondary-100 text-secondary-700">Inactivo</span>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <div x-data="{ open: false }" @click.away="open = false" class="relative">
                            <button @click="open = !open" class="p-2 text-secondary-500 hover:text-primary-600" title="Acciones">
                                <i class="fas fa-ellipsis-v fa-fw"></i>
                            </button>
                            <div x-show="open" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-20 border" style="display: none;">
                                <a href="<?php echo e(route('escuelas.show', $escuela->id_escuela)); ?>" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100">
                                    <i class="fas fa-eye fa-fw text-secondary-400"></i> Consultar
                                </a>
                                <a href="<?php echo e(route('escuelas.edit', $escuela->id_escuela)); ?>" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100">
                                    <i class="fas fa-pencil-alt fa-fw text-secondary-400"></i> Editar
                                </a>
                                <button wire:click="cambiarEstado(<?php echo e($escuela->id_escuela); ?>)" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 w-full text-left">
                                    <i class="fas fa-<?php echo e($escuela->activo ? 'toggle-off' : 'toggle-on'); ?> fa-fw text-secondary-400"></i> <?php echo e($escuela->activo ? 'Desactivar' : 'Activar'); ?>

                                </button>
                                <button wire:click="eliminar(<?php echo e($escuela->id_escuela); ?>)" wire:confirm="¿Estás seguro?" class="flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 w-full text-left">
                                    <i class="fas fa-trash fa-fw"></i> Eliminar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-4 text-sm text-secondary-700 space-y-1">
                    <p><i class="fas fa-phone-alt text-secondary-400 mr-2 fa-fw"></i><?php echo e($escuela->telefono ?? 'No disponible'); ?></p>
                    <p><i class="fas fa-envelope text-secondary-400 mr-2 fa-fw"></i><?php echo e($escuela->email ?? 'No disponible'); ?></p>
                    <p><i class="fas fa-map-marker-alt text-secondary-400 mr-2 fa-fw"></i><?php echo e($escuela->direccion ?? 'No disponible'); ?></p>
                </div>
                <div class="border-t border-secondary-200 pt-4 mb-4">
                    <h4 class="text-sm font-medium text-secondary-600 mb-2">Resumen General:</h4>
                    <div class="grid grid-cols-2 gap-x-4 gap-y-1 text-sm">
                        <p>Alumnos: <span class="font-semibold"><?php echo e($escuela->cantidad_alumnos ?? 0); ?></span></p>
                        <p>Empleados: <span class="font-semibold"><?php echo e($escuela->cantidad_empleados ?? 0); ?></span></p>
                        <p>Salidas Ed.: <span class="font-semibold"><?php echo e($escuela->salidas_educativas_count); ?></span></p>
                        <p>Pasantías: <span class="font-semibold"><?php echo e($escuela->pasantias_count); ?></span></p>
                        <p>Benef. SVO: <span class="font-semibold"><?php echo e($escuela->beneficiarios_svo_count); ?></span></p>
                        <p>Accidentes: <span class="font-semibold"><?php echo e($escuela->accidentes_count); ?></span></p>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="md:col-span-2 lg:col-span-3">
            <div class="text-center py-12 border-2 border-dashed border-secondary-200 rounded-lg">
                <svg class="mx-auto h-12 w-12 text-secondary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-secondary-900">No se encontraron escuelas</h3>
                <p class="mt-1 text-sm text-secondary-500">Intenta ajustar los filtros de búsqueda.</p>
            </div>
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>

    <!-- Paginación -->
    <div class="mt-8 px-6 py-4 bg-secondary-50 border-t border-secondary-200">
        <div class="flex flex-col sm:flex-row items-center justify-between">
            <div class="text-sm text-secondary-700 mb-4 sm:mb-0">
                <!--[if BLOCK]><![endif]--><?php if($escuelas->total() > 0): ?>
                    Mostrando <span class="font-medium text-secondary-900"><?php echo e($escuelas->firstItem()); ?></span> a <span class="font-medium text-secondary-900"><?php echo e($escuelas->lastItem()); ?></span> de <span class="font-medium text-secondary-900"><?php echo e($escuelas->total()); ?></span> resultados
                <?php else: ?>
                    No hay resultados para mostrar
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
            <!--[if BLOCK]><![endif]--><?php if($escuelas->hasPages()): ?>
                <?php echo e($escuelas->links('pagination.custom-tailwind')); ?>

            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    function exportarEscuelas(formato) {
        const filtroNombre = document.getElementById('filtro_nombre')?.value || '';
        const filtroCodigo = document.getElementById('filtro_codigo')?.value || '';
        const filtroEstado = document.getElementById('filtro_estado')?.value || '';
        
        const params = new URLSearchParams();
        if (filtroNombre) params.append('filtro_nombre', filtroNombre);
        if (filtroCodigo) params.append('filtro_codigo', filtroCodigo);
        if (filtroEstado) params.append('filtro_estado', filtroEstado);
        
        let url = '';
        switch(formato) {
            case 'csv':
                url = '<?php echo e(route("escuelas.export.csv")); ?>';
                break;
            case 'excel':
                url = '<?php echo e(route("escuelas.export.excel")); ?>';
                break;
            case 'pdf':
                url = '<?php echo e(route("escuelas.export.pdf")); ?>';
                break;
        }
        
        if (params.toString()) {
            url += '?' + params.toString();
        }
        
        window.open(url, '_blank');
    }
</script>
<?php $__env->stopPush(); ?><?php /**PATH /home/passion/Documents/FondoSolidarioEntrega11/Fondo Solidario Entrega/resources/views/livewire/escuelas/index.blade.php ENDPATH**/ ?>