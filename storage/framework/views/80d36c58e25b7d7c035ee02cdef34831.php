

<?php $__env->startSection('content'); ?>
<div class="mx-auto px-4">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 mb-8">
        <div>
            <h1 class="text-2xl font-semibold text-secondary-900">Gestión de Escuelas</h1>
            <p class="mt-1 text-sm text-secondary-600">Administra las escuelas del sistema</p>
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
                        
                        <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900" role="menuitem"><i class="fas fa-file-csv fa-fw text-secondary-400"></i>Exportar a CSV</a>
                        <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900" role="menuitem"><i class="fas fa-file-excel fa-fw text-secondary-400"></i>Exportar a Excel</a>
                        <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900" role="menuitem"><i class="fas fa-file-pdf fa-fw text-secondary-400"></i>Exportar a PDF</a>
                    </div>
                </div>
            </div>
            <!-- Botón Nueva Escuela -->
            <a href="<?php echo e(route('escuelas.create')); ?>" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nueva Escuela
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
                <form class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="space-y-1">
                        <label for="filtro_nombre" class="block text-sm font-medium text-secondary-700">Nombre</label>
                        <input type="text" name="filtro_nombre" id="filtro_nombre" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Buscar por nombre">
                    </div>
                    <div class="space-y-1">
                        <label for="filtro_codigo" class="block text-sm font-medium text-secondary-700">Código</label>
                        <input type="text" name="filtro_codigo" id="filtro_codigo" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Ej: ESC001">
                    </div>
                    <div class="space-y-1">
                        <label for="filtro_estado" class="block text-sm font-medium text-secondary-700">Estado</label>
                        <select name="filtro_estado" id="filtro_estado" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option value="">Todos</option>
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-secondary-900 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-secondary-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-500 transition-colors duration-200">
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

    <!-- Vista de Cards de Escuelas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php
            $escuelas = [
                ['id' => 1, 'nombre' => 'Colegio San Martín', 'codigo' => 'ESC001', 'activo' => true, 'telefono' => '(351) 455-1234', 'email' => 'info@sanmartin.edu.ar', 'direccion' => 'Av. Siempre Viva 742, Córdoba', 'alumnos' => 450, 'empleados' => 35, 'salidas' => 5, 'pasantias' => 2, 'svo' => 30, 'accidentes' => 12, 'derivaciones' => 8, 'reintegros' => '3 Pend.'],
                ['id' => 2, 'nombre' => 'Instituto Belgrano', 'codigo' => 'ESC002', 'activo' => false, 'telefono' => '(351) 477-5678', 'email' => 'contacto@belgrano.edu.ar', 'direccion' => 'Calle Falsa 123, Córdoba', 'alumnos' => 320, 'empleados' => 28, 'salidas' => 3, 'pasantias' => 1, 'svo' => 25, 'accidentes' => 8, 'derivaciones' => 5, 'reintegros' => '1 Pend.'],
                ['id' => 3, 'nombre' => 'Escuela Santa María', 'codigo' => 'ESC003', 'activo' => true, 'telefono' => '(351) 423-9876', 'email' => 'contacto@santamaria.edu.ar', 'direccion' => 'Otra Dirección 789, Córdoba', 'alumnos' => 510, 'empleados' => 42, 'salidas' => 7, 'pasantias' => 4, 'svo' => 40, 'accidentes' => 15, 'derivaciones' => 10, 'reintegros' => '5 Pend.'],
                ['id' => 4, 'nombre' => 'Colegio Nacional', 'codigo' => 'ESC004', 'activo' => true, 'telefono' => '(351) 411-2233', 'email' => 'info@nacional.edu.ar', 'direccion' => 'Av. Patria 567, Córdoba', 'alumnos' => 600, 'empleados' => 50, 'salidas' => 8, 'pasantias' => 3, 'svo' => 45, 'accidentes' => 20, 'derivaciones' => 12, 'reintegros' => '2 Pend.'],
                ['id' => 5, 'nombre' => 'Escuela Alberdi', 'codigo' => 'ESC005', 'activo' => true, 'telefono' => '(351) 499-8877', 'email' => 'contacto@alberdi.edu.ar', 'direccion' => 'Bv. San Juan 100, Córdoba', 'alumnos' => 250, 'empleados' => 20, 'salidas' => 2, 'pasantias' => 0, 'svo' => 18, 'accidentes' => 5, 'derivaciones' => 3, 'reintegros' => '0 Pend.'],
                ['id' => 6, 'nombre' => 'Instituto Sarmiento', 'codigo' => 'ESC006', 'activo' => false, 'telefono' => '(351) 400-0000', 'email' => 'info@sarmiento.edu.ar', 'direccion' => 'Pje. de la Reforma 200, Córdoba', 'alumnos' => 180, 'empleados' => 15, 'salidas' => 1, 'pasantias' => 1, 'svo' => 12, 'accidentes' => 3, 'derivaciones' => 1, 'reintegros' => '1 Pend.'],
            ];
        ?>

        <?php $__currentLoopData = $escuelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $escuela): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="bg-white rounded-xl border border-secondary-200 shadow-sm hover:shadow-lg transition-shadow duration-300 flex flex-col">
            <div class="p-6 flex-grow">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h2 class="text-xl font-semibold text-primary-700"><?php echo e($escuela['nombre']); ?></h2>
                        <p class="text-xs text-secondary-500">Código: <?php echo e($escuela['codigo']); ?></p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <?php if($escuela['activo']): ?>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-100 text-success-800">
                            <svg class="w-1.5 h-1.5 mr-1.5" fill="currentColor" viewBox="0 0 8 8">
                                <circle cx="4" cy="4" r="3"/>
                            </svg>
                            Activo
                        </span>
                        <?php else: ?>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-secondary-100 text-secondary-700">
                            <svg class="w-1.5 h-1.5 mr-1.5" fill="currentColor" viewBox="0 0 8 8">
                                <circle cx="4" cy="4" r="3"/>
                            </svg>
                            Inactivo
                        </span>
                        <?php endif; ?>
                        <div x-data="{ open: false }" @click.away="open = false" class="relative">
                            <button @click="open = !open" class="p-2 text-secondary-500 hover:text-primary-600 hover:bg-primary-50 rounded-full transition-colors duration-200 -mr-2" title="Acciones">
                                <i class="fas fa-ellipsis-v fa-fw"></i>
                            </button>
                            <div x-show="open"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-20 border border-secondary-200"
                                 style="display: none;">
                                <a href="<?php echo e(route('escuelas.show', $escuela['id'])); ?>" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900 w-full text-left">
                                    <i class="fas fa-eye fa-fw text-secondary-400"></i>
                                    Consultar
                                </a>
                                <a href="<?php echo e(route('escuelas.edit', $escuela['id'])); ?>" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900 w-full text-left">
                                    <i class="fas fa-pencil-alt fa-fw text-secondary-400"></i>
                                    Editar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4 text-sm text-secondary-700 space-y-1">
                    <p><i class="fas fa-phone-alt text-secondary-400 mr-2 fa-fw"></i><?php echo e($escuela['telefono']); ?></p>
                    <p><i class="fas fa-envelope text-secondary-400 mr-2 fa-fw"></i><?php echo e($escuela['email']); ?></p>
                    <p><i class="fas fa-map-marker-alt text-secondary-400 mr-2 fa-fw"></i><?php echo e($escuela['direccion']); ?></p>
                </div>

                <div class="border-t border-secondary-200 pt-4 mb-4">
                    <h4 class="text-sm font-medium text-secondary-600 mb-2">Resumen General:</h4>
                    <div class="grid grid-cols-2 gap-x-4 gap-y-1 text-sm">
                        <p class="text-secondary-700">Alumnos: <span class="font-semibold text-secondary-900"><?php echo e($escuela['alumnos']); ?></span></p>
                        <p class="text-secondary-700">Empleados: <span class="font-semibold text-secondary-900"><?php echo e($escuela['empleados']); ?></span></p>
                        <p class="text-secondary-700">Salidas Ed.: <span class="font-semibold text-secondary-900"><?php echo e($escuela['salidas']); ?></span></p>
                        <p class="text-secondary-700">Pasantías: <span class="font-semibold text-secondary-900"><?php echo e($escuela['pasantias']); ?></span></p>
                        <p class="text-secondary-700">Benef. SVO: <span class="font-semibold text-secondary-900"><?php echo e($escuela['svo']); ?></span></p>
                        <p class="text-secondary-700">Accidentes: <span class="font-semibold text-secondary-900"><?php echo e($escuela['accidentes']); ?></span></p>
                        <p class="text-secondary-700">Derivaciones: <span class="font-semibold text-secondary-900"><?php echo e($escuela['derivaciones']); ?></span></p>
                        <p class="text-secondary-700">Reintegros: <span class="font-semibold text-secondary-900"><?php echo e($escuela['reintegros']); ?></span></p>
                    </div>
                </div>
            </div>
            
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <!-- Paginación -->
        <div class="mt-8 px-6 py-4 bg-white border-t border-secondary-200 flex flex-col sm:flex-row items-center justify-between rounded-b-xl">
            <div class="text-sm text-secondary-700 mb-4 sm:mb-0">
                Mostrando <span class="font-medium text-secondary-900">1</span> a <span class="font-medium text-secondary-900">6</span> de <span class="font-medium text-secondary-900">18</span> resultados
            </div>
            <nav class="inline-flex rounded-lg shadow-sm" aria-label="Paginación">
                <button type="button" class="relative inline-flex items-center px-2 py-2 rounded-l-lg border border-secondary-300 bg-white text-sm font-medium text-secondary-500 hover:bg-secondary-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span class="sr-only">Anterior</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button type="button" class="relative inline-flex items-center px-4 py-2 border border-secondary-300 bg-white text-sm font-medium text-secondary-700 hover:bg-secondary-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500">
                    1
                </button>
                <button type="button" class="relative inline-flex items-center px-4 py-2 border border-secondary-300 bg-primary-600 text-sm font-medium text-white hover:bg-primary-700 focus:z-10 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500" aria-current="page">
                    2
                </button>
                <button type="button" class="relative inline-flex items-center px-4 py-2 border border-secondary-300 bg-white text-sm font-medium text-secondary-700 hover:bg-secondary-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500">
                    3
                </button>
                <span class="relative inline-flex items-center px-4 py-2 border border-secondary-300 bg-white text-sm font-medium text-secondary-700">
                    ...
                </span>
                <button type="button" class="relative inline-flex items-center px-4 py-2 border border-secondary-300 bg-white text-sm font-medium text-secondary-700 hover:bg-secondary-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500">
                    9
                </button>
                <button type="button" class="relative inline-flex items-center px-2 py-2 rounded-r-lg border border-secondary-300 bg-white text-sm font-medium text-secondary-500 hover:bg-secondary-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500">
                    <span class="sr-only">Siguiente</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </nav>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Disco\Documentos\Personal\Proyectos\workana\SistemaFondoSolidario\FondoSolidarioSite\resources\views/livewire/escuelas/index.blade.php ENDPATH**/ ?>