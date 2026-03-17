<div>
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

    <div class="mx-auto px-4">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 mb-8">
            <div>
                <h1 class="text-2xl font-semibold text-secondary-900">Gestión de Accidentes</h1>
                <p class="mt-1 text-sm text-secondary-600">Administra los accidentes registrados en el sistema</p>
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
                            <button onclick="exportarAccidentes('csv')" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900 w-full text-left" role="menuitem">
                                <i class="fas fa-file-csv fa-fw text-secondary-400"></i>
                                Exportar a CSV
                            </button>
                            <button onclick="exportarAccidentes('excel')" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900 w-full text-left" role="menuitem">
                                <i class="fas fa-file-excel fa-fw text-secondary-400"></i>
                                Exportar a Excel
                            </button>
                            <button onclick="exportarAccidentes('pdf')" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900 w-full text-left" role="menuitem">
                                <i class="fas fa-file-pdf fa-fw text-secondary-400"></i>
                                Exportar a PDF
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Botón Nuevo Accidente -->
                <!--[if BLOCK]><![endif]--><?php if(auth()->user()->id_rol != 3): ?>
                <a href="<?php echo e(route('accidentes.create')); ?>" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Nuevo Accidente
                </a>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
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
                    <div class="grid grid-cols-1 md:grid-cols-2 <?php echo e($es_usuario_general ? 'lg:grid-cols-4' : 'lg:grid-cols-5'); ?> gap-4">
                        <div class="space-y-1">
                            <label for="filtro_expediente" class="block text-sm font-medium text-secondary-700">N° Expediente</label>
                            <input wire:model.live="filtro_expediente" type="text" id="filtro_expediente" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Ej: EXP-2024-001">
                        </div>

                        <div class="space-y-1">
                            <label for="filtro_alumno" class="block text-sm font-medium text-secondary-700">Alumno (Nombre/DNI)</label>
                            <input wire:model.live="filtro_alumno" type="text" id="filtro_alumno" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Nombre, apellido o DNI">
                        </div>

                        <!--[if BLOCK]><![endif]--><?php if(!$es_usuario_general): ?>
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
                            <label for="filtro_fecha" class="block text-sm font-medium text-secondary-700">Fecha Accidente</label>
                            <input wire:model.live="filtro_fecha" type="date" id="filtro_fecha" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        <div class="flex items-end">
                            <button wire:click="limpiarFiltros" type="button" class="w-full inline-flex justify-center items-center px-4 py-2 bg-secondary-200 border border-transparent rounded-lg font-medium text-sm text-secondary-700 hover:bg-secondary-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-500 transition-colors duration-200">
                                Limpiar
                            </button>
                        </div>
                    </div>
                </div>
            </details>
        </div>

        <!-- Vista de Cards de Accidentes -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $accidentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accidente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white rounded-xl border border-secondary-200 shadow-sm hover:shadow-lg transition-shadow duration-300 flex flex-col">
                <div class="p-6 flex-grow">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-1 min-w-0 pr-3">
                            <h2 class="text-xl font-semibold text-red-700 break-words"><?php echo e($accidente->numero_expediente ?? 'Sin número de expediente'); ?></h2>
                            <div class="mt-1">
                                <!--[if BLOCK]><![endif]--><?php if($accidente->alumnos->count() === 0): ?>
                                    <p class="text-sm text-secondary-500 italic">Sin alumnos asociados</p>
                                <?php elseif($accidente->alumnos->count() === 1): ?>
                                    <p class="text-sm text-secondary-600 font-medium"><?php echo e($accidente->alumnos->first()->alumno->nombre_completo ?? 'Alumno no encontrado'); ?></p>
                                <?php else: ?>
                                    <p wire:click="getAlumnosDelAccidente(<?php echo e($accidente->id_accidente); ?>)" class="text-sm text-secondary-600 font-medium whitespace-nowrap cursor-pointer hover:text-primary-600 transition-colors duration-200">
                                        <?php echo e($accidente->alumnos->first()->alumno->nombre_completo ?? 'Alumno no encontrado'); ?>

                                        <span class="text-xs text-secondary-500 underline">+<?php echo e($accidente->alumnos->count() - 1); ?> más</span>
                                    </p>
                                    <p class="text-xs text-secondary-500 mt-1 whitespace-nowrap">
                                        <strong>Total:</strong> <?php echo e($accidente->alumnos->count()); ?> alumnos involucrados
                                    </p>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <p class="text-xs text-secondary-500 mt-1"><?php echo e($accidente->escuela->nombre); ?></p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <!--[if BLOCK]><![endif]--><?php if($accidente->estado): ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-100 text-success-800">
                                <svg class="w-1.5 h-1.5 mr-1.5" fill="currentColor" viewBox="0 0 8 8">
                                    <circle cx="4" cy="4" r="3"/>
                                </svg>
                                <?php echo e($accidente->estado->nombre_estado); ?>

                            </span>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <!--[if BLOCK]><![endif]--><?php if($accidente->protocolo_activado): ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <i class="fas fa-shield-alt w-1.5 h-1.5 mr-1.5"></i>
                                Protocolo
                            </span>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
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
                                    <a href="<?php echo e(route('accidentes.show', $accidente->id_accidente)); ?>" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900 w-full text-left">
                                        <i class="fas fa-eye fa-fw text-secondary-400"></i>
                                        Consultar
                                    </a>
                                    <!--[if BLOCK]><![endif]--><?php if(auth()->user()->id_rol != 3): ?>
                                    <a href="<?php echo e(route('accidentes.edit', $accidente->id_accidente)); ?>" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900 w-full text-left">
                                        <i class="fas fa-pencil-alt fa-fw text-secondary-400"></i>
                                        Editar
                                    </a>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <a href="<?php echo e(route('accidentes.print', $accidente->id_accidente)); ?>" target="_blank" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900 w-full text-left">
                                        <i class="fas fa-print fa-fw text-secondary-400"></i>
                                        Imprimir
                                    </a>
                                    <a href="<?php echo e(route('accidentes.dossier', $accidente->id_accidente)); ?>" target="_blank" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900 w-full text-left">
                                        <i class="fas fa-folder-open fa-fw text-secondary-400"></i>
                                        Expediente Completo
                                    </a>
                                    <!--[if BLOCK]><![endif]--><?php if(auth()->user()->id_rol != 3): ?>
                                    <button wire:click="eliminar(<?php echo e($accidente->id_accidente); ?>)" wire:confirm="¿Estás seguro de que deseas eliminar este accidente?" class="flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 w-full text-left">
                                        <i class="fas fa-trash-alt fa-fw text-red-400"></i>
                                        Eliminar
                                    </button>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 text-sm text-secondary-700 space-y-1">
                        <p><i class="fas fa-calendar-alt text-secondary-400 mr-2 fa-fw"></i><?php echo e($accidente->fecha_accidente->format('d/m/Y')); ?> - <?php echo e($accidente->hora_accidente ? $accidente->hora_accidente->format('H:i') : 'N/A'); ?></p>
                        <p><i class="fas fa-map-marker-alt text-secondary-400 mr-2 fa-fw"></i><?php echo e($accidente->lugar_accidente); ?></p>
                        <p><i class="fas fa-user-injured text-secondary-400 mr-2 fa-fw"></i><?php echo e($accidente->tipo_lesion); ?></p>
                    </div>

                    <div class="border-t border-secondary-200 pt-4 mb-4">
                        <h4 class="text-sm font-medium text-secondary-600 mb-2">Estado de Gestión:</h4>
                        <div class="grid grid-cols-2 gap-x-4 gap-y-1 text-sm">
                            <p class="text-secondary-700">Derivaciones: <span class="font-semibold text-blue-600"><?php echo e($accidente->derivaciones->count()); ?></span></p>
                            <p class="text-secondary-700">Reintegros: <span class="font-semibold text-secondary-900"><?php echo e($accidente->reintegros->count()); ?></span></p>
                        </div>
                    </div>

                    <!-- Botones de Acción en el Card -->
                    <!--[if BLOCK]><![endif]--><?php if(auth()->user()->id_rol != 3): ?>
                    <div class="flex gap-2 mt-4">
                        <a href="<?php echo e(route('derivaciones.create', ['id_accidente' => $accidente->id_accidente])); ?>" class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-blue-600 border border-transparent rounded-lg font-medium text-xs text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            <i class="fas fa-file-medical mr-1"></i>
                            Generar Derivación
                        </a>
                        <a href="<?php echo e(route('reintegros.create', ['id_accidente' => $accidente->id_accidente])); ?>" class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-green-600 border border-transparent rounded-lg font-medium text-xs text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                            <i class="fas fa-dollar-sign mr-1"></i>
                            Solicitar Reintegro
                        </a>
                    </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="md:col-span-2 lg:col-span-3 text-center py-12">
                <p class="text-secondary-500">No hay accidentes que coincidan con los filtros seleccionados.</p>
            </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
        <!-- Paginación -->
        <div class="mt-8 px-6 py-4 bg-white border-t border-secondary-200 flex flex-col sm:flex-row items-center justify-between rounded-b-xl">
            <!--[if BLOCK]><![endif]--><?php if($accidentes->hasPages()): ?>
                <div class="text-sm text-secondary-700">
                    Mostrando <?php echo e($accidentes->firstItem()); ?> a <?php echo e($accidentes->lastItem()); ?> de <?php echo e($accidentes->total()); ?> resultados
                </div>
                <?php echo e($accidentes->links('pagination.custom-tailwind')); ?>

            <?php else: ?>
                <div class="text-sm text-secondary-700">
                    <!--[if BLOCK]><![endif]--><?php if($accidentes->total() > 0): ?>
                        Mostrando <?php echo e($accidentes->firstItem()); ?> a <?php echo e($accidentes->lastItem()); ?> de <?php echo e($accidentes->total()); ?> resultados
                    <?php else: ?>
                        No hay resultados para mostrar
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>

    <!-- Modal para mostrar lista completa de alumnos -->
    <div id="modal_alumnos" style="
        display: none !important;
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        background-color: rgba(0,0,0,0.8) !important;
        z-index: 999999 !important;
        justify-content: center !important;
        align-items: center !important;
        padding: 20px !important;
        box-sizing: border-box !important;
    ">
        <div style="
            background: white !important;
            border-radius: 12px !important;
            max-width: 600px !important;
            width: 100% !important;
            max-height: 80vh !important;
            overflow-y: auto !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5) !important;
            position: relative !important;
            z-index: 1000000 !important;
            margin: auto !important;
        ">
            <div style="
                display: flex !important;
                justify-content: space-between !important;
                align-items: center !important;
                padding: 24px !important;
                border-bottom: 2px solid #e5e7eb !important;
                background: #f8fafc !important;
                border-radius: 12px 12px 0 0 !important;
            ">
                <h3 style="font-size: 20px !important; font-weight: 700 !important; color: #111827 !important; margin: 0 !important;">Alumnos Involucrados</h3>
                <button type="button" id="cerrar_modal_alumnos" style="
                    color: #ef4444 !important;
                    cursor: pointer !important;
                    background: #fee2e2 !important;
                    border: none !important;
                    padding: 8px !important;
                    border-radius: 6px !important;
                    font-size: 18px !important;
                    font-weight: bold !important;
                ">✕</button>
            </div>
            
            <div style="padding: 24px !important;">
                <div id="expediente_info" style="
                    margin-bottom: 20px !important;
                    padding: 16px !important;
                    background-color: #dbeafe !important;
                    border-radius: 8px !important;
                    border: 2px solid #3b82f6 !important;
                ">
                    <p style="font-size: 16px !important; font-weight: 600 !important; color: #1e40af !important; margin: 0 0 8px 0 !important;">
                        Expediente: <span id="modal_expediente" style="color: #dc2626 !important;"></span>
                    </p>
                    <p style="font-size: 14px !important; color: #1e40af !important; margin: 0 !important;">
                        Escuela: <span id="modal_escuela" style="font-weight: 500 !important;"></span>
                    </p>
                </div>
                
                <h4 style="font-size: 16px !important; font-weight: 600 !important; color: #374151 !important; margin: 0 0 16px 0 !important;">Lista de Alumnos:</h4>
                <div id="lista_alumnos_modal" style="display: flex !important; flex-direction: column !important; gap: 12px !important;">
                    <!-- Lista dinámica de alumnos -->
                </div>
            </div>
            
            <div style="
                display: flex !important;
                justify-content: center !important;
                padding: 24px !important;
                border-top: 2px solid #e5e7eb !important;
                background: #f8fafc !important;
                border-radius: 0 0 12px 12px !important;
            ">
                <button type="button" id="cerrar_modal_btn" style="
                    padding: 12px 24px !important;
                    border: 2px solid #dc2626 !important;
                    border-radius: 8px !important;
                    font-size: 16px !important;
                    font-weight: 600 !important;
                    color: white !important;
                    background: #dc2626 !important;
                    cursor: pointer !important;
                ">Cerrar Modal</button>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
    document.addEventListener('livewire:init', () => {
        const modal = document.getElementById('modal_alumnos');
        const cerrarModalBtn = document.getElementById('cerrar_modal_alumnos');
        const cerrarModalBtn2 = document.getElementById('cerrar_modal_btn');

        const mostrarModalAlumnos = (expediente, escuela, alumnos) => {
            // Crear modal dinámicamente
            const modalDinamico = document.createElement('div');
            modalDinamico.id = 'modal_dinamico_alumnos';
            modalDinamico.innerHTML = `
                <div style="
                    position: fixed !important;
                    top: 0 !important;
                    left: 0 !important;
                    width: 100vw !important;
                    height: 100vh !important;
                    background: rgba(0, 0, 0, 0.6) !important;
                    z-index: 9999999 !important;
                    display: flex !important;
                    justify-content: center !important;
                    align-items: center !important;
                    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
                ">
                    <div style="
                        background: white !important;
                        padding: 0 !important;
                        border-radius: 12px !important;
                        max-width: 500px !important;
                        width: 90% !important;
                        max-height: 80vh !important;
                        overflow: hidden !important;
                        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
                        border: 1px solid #e5e7eb !important;
                    ">
                        <!-- Header -->
                        <div style="
                            display: flex !important;
                            justify-content: space-between !important;
                            align-items: center !important;
                            padding: 24px !important;
                            border-bottom: 1px solid #e5e7eb !important;
                            background: #f8fafc !important;
                        ">
                            <h3 style="
                                color: #111827 !important;
                                font-size: 18px !important;
                                font-weight: 600 !important;
                                margin: 0 !important;
                            ">Alumnos Involucrados</h3>
                            <button onclick="document.getElementById('modal_dinamico_alumnos').remove(); document.body.style.overflow='auto';" style="
                                background: none !important;
                                border: none !important;
                                color: #6b7280 !important;
                                cursor: pointer !important;
                                padding: 4px !important;
                                border-radius: 4px !important;
                                font-size: 20px !important;
                            ">×</button>
                        </div>
                        
                        <!-- Content -->
                        <div style="padding: 24px !important; max-height: 60vh !important; overflow-y: auto !important;">
                            <!-- Expediente Info -->
                            <div style="
                                margin-bottom: 20px !important;
                                padding: 16px !important;
                                background: #f0f9ff !important;
                                border-radius: 8px !important;
                                border: 1px solid #0ea5e9 !important;
                            ">
                                <p style="
                                    font-size: 14px !important;
                                    font-weight: 600 !important;
                                    color: #0c4a6e !important;
                                    margin: 0 0 4px 0 !important;
                                ">Expediente: <span style="color: #dc2626 !important;">${expediente}</span></p>
                                <p style="
                                    font-size: 12px !important;
                                    color: #0369a1 !important;
                                    margin: 0 !important;
                                ">Escuela: ${escuela}</p>
                            </div>
                            
                            <!-- Lista de Alumnos -->
                            <h4 style="
                                font-size: 14px !important;
                                font-weight: 600 !important;
                                color: #374151 !important;
                                margin: 0 0 12px 0 !important;
                            ">Lista de Alumnos:</h4>
                            
                            <div style="display: flex !important; flex-direction: column !important; gap: 8px !important;">
                                ${alumnos.map((alumno, index) => `
                                    <div style="
                                        display: flex !important;
                                        align-items: center !important;
                                        padding: 12px !important;
                                        background: #f9fafb !important;
                                        border-radius: 8px !important;
                                        border: 1px solid #e5e7eb !important;
                                    ">
                                        <div style="
                                            flex-shrink: 0 !important;
                                            width: 32px !important;
                                            height: 32px !important;
                                            background: #3b82f6 !important;
                                            border-radius: 50% !important;
                                            display: flex !important;
                                            align-items: center !important;
                                            justify-content: center !important;
                                            margin-right: 12px !important;
                                        ">
                                            <span style="
                                                font-size: 14px !important;
                                                font-weight: 600 !important;
                                                color: white !important;
                                            ">${index + 1}</span>
                                        </div>
                                        <div style="flex: 1 !important;">
                                            <p style="
                                                font-size: 14px !important;
                                                font-weight: 600 !important;
                                                color: #111827 !important;
                                                margin: 0 0 2px 0 !important;
                                            ">${alumno.nombre_completo}</p>
                                            <p style="
                                                font-size: 12px !important;
                                                color: #6b7280 !important;
                                                margin: 0 0 2px 0 !important;
                                            ">DNI: ${alumno.dni}</p>
                                            <p style="
                                                font-size: 12px !important;
                                                color: #6b7280 !important;
                                                margin: 0 !important;
                                            ">Grado/Sección: ${alumno.grado_seccion}</p>
                                        </div>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                        
                        <!-- Footer -->
                        <div style="
                            display: flex !important;
                            justify-content: flex-end !important;
                            padding: 24px !important;
                            border-top: 1px solid #e5e7eb !important;
                            background: #f8fafc !important;
                        ">
                            <button onclick="document.getElementById('modal_dinamico_alumnos').remove(); document.body.style.overflow='auto';" style="
                                background: #6b7280 !important;
                                color: white !important;
                                border: none !important;
                                padding: 8px 16px !important;
                                font-size: 14px !important;
                                font-weight: 500 !important;
                                border-radius: 6px !important;
                                cursor: pointer !important;
                            ">Cerrar</button>
                        </div>
                    </div>
                </div>
            `;
            
            // Agregar al body
            document.body.appendChild(modalDinamico);
            document.body.style.overflow = 'hidden';
        }

        const cerrarModal = () => {
            if (modal) {
                modal.style.setProperty('display', 'none', 'important');
                modal.style.setProperty('visibility', 'hidden', 'important');
                modal.style.setProperty('opacity', '0', 'important');
                document.body.style.overflow = 'auto';
            }
        }

        // Escuchar el evento alumnosModal
        Livewire.on('alumnosModal', (event) => {
            // El evento viene como array, tomamos el primer elemento
            const data = Array.isArray(event) ? event[0] : event;
            const { alumnos, expediente, escuela } = data;
            
            mostrarModalAlumnos(expediente, escuela, alumnos);
        });

        if (cerrarModalBtn) cerrarModalBtn.addEventListener('click', cerrarModal);
        if (cerrarModalBtn2) cerrarModalBtn2.addEventListener('click', cerrarModal);

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                cerrarModal();
            }
        });

        if (modal) {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    cerrarModal();
                }
            });
        }
    });

    // Función para exportar accidentes
    function exportarAccidentes(formato) {
        // Obtener los valores actuales de los filtros
        const filtroExpediente = document.getElementById('filtro_expediente')?.value || '';
        const filtroEscuela = document.getElementById('filtro_escuela')?.value || '';
        const filtroFecha = document.getElementById('filtro_fecha')?.value || '';
        
        // Construir la URL con los parámetros
        const params = new URLSearchParams();
        if (filtroExpediente) params.append('filtro_expediente', filtroExpediente);
        if (filtroEscuela) params.append('filtro_escuela', filtroEscuela);
        if (filtroFecha) params.append('filtro_fecha', filtroFecha);
        
        // Determinar la URL según el formato
        let url = '';
        switch(formato) {
            case 'csv':
                url = '<?php echo e(route("accidentes.export.csv")); ?>';
                break;
            case 'excel':
                url = '<?php echo e(route("accidentes.export.excel")); ?>';
                break;
            case 'pdf':
                url = '<?php echo e(route("accidentes.export.pdf")); ?>';
                break;
        }
        
        // Agregar parámetros a la URL
        if (params.toString()) {
            url += '?' + params.toString();
        }
        
        // Abrir la URL en una nueva ventana/pestaña
        window.open(url, '_blank');
    }
    </script>
    <?php $__env->stopPush(); ?>
</div><?php /**PATH /home/passion/Documents/FondoSolidarioEntrega11/Fondo Solidario Entrega/resources/views/livewire/accidentes/index.blade.php ENDPATH**/ ?>