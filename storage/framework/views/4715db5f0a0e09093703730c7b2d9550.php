

<?php $__env->startSection('content'); ?>
<div class="mx-auto px-4">
    <!-- Header -->
    <div class="mb-8">
        <nav class="flex items-center text-sm text-secondary-500 mb-4">
            <a href="<?php echo e(route('reintegros.index')); ?>" class="hover:text-secondary-700">Reintegros</a>
            <svg class="mx-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-secondary-900"><?php echo e($modo == 'create' ? 'Nueva Solicitud de Reintegro' : ($modo == 'edit' ? 'Editar Solicitud' : 'Detalles de la Solicitud')); ?></span>
        </nav>
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-secondary-900">
                    <?php echo e($modo == 'create' ? 'Nueva Solicitud de Reintegro' : ($modo == 'edit' ? 'Editar Solicitud' : 'Detalles de la Solicitud')); ?>

                </h1>
                <p class="mt-1 text-sm text-secondary-600">
                    <?php echo e($modo == 'create' ? 'Complete los datos para solicitar un nuevo reintegro.' : ($modo == 'edit' ? 'Modifique los datos de la solicitud.' : 'Información detallada de la solicitud de reintegro.')); ?>

                </p>
            </div>
            <?php if($modo == 'show'): ?>
            <div class="flex space-x-3">
                <a href="<?php echo e(route('reintegros.edit', $reintegro_id ?? 1)); ?>" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Editar
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Formulario -->
    <div class="bg-white rounded-xl border border-secondary-200">
        <form wire:submit.prevent="save" class="space-y-6 p-6" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            
            <!-- Información de la Solicitud -->
            <div class="border-b border-secondary-200 pb-6">
                <h3 class="text-lg font-medium text-secondary-900 mb-4">Información de la Solicitud</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Accidente Relacionado -->
                    <div class="space-y-1">
                        <label for="id_accidente" class="block text-sm font-medium text-secondary-700">
                            Accidente Relacionado (Alumno) <span class="text-danger-500">*</span>
                        </label>
                        <select wire:model="id_accidente" id="id_accidente" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" <?php echo e($modo == 'show' ? 'disabled' : ''); ?> required>
                            <option value="">Seleccione un accidente</option>
                            <option value="1">ACC-001 (Juan Pérez - Colegio San Martín)</option>
                            <option value="2">ACC-002 (Ana López - Instituto Belgrano)</option>
                        </select>
                        <?php if($modo == 'create'): ?>
                        <p class="text-xs text-secondary-500">Si el accidente no está listado, primero debe <a href="<?php echo e(route('accidentes.create')); ?>" class="text-primary-600 hover:underline">registrar el accidente</a>.</p>
                        <?php endif; ?>
                    </div>

                    <!-- Fecha de Solicitud -->
                    <div class="space-y-1">
                        <label for="fecha_solicitud" class="block text-sm font-medium text-secondary-700">
                            Fecha de Solicitud <span class="text-danger-500">*</span>
                        </label>
                        <input type="date" wire:model="fecha_solicitud" id="fecha_solicitud" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" <?php echo e($modo == 'show' ? 'readonly' : ''); ?> required>
                    </div>

                    <!-- Tipo de Gasto -->
                    <div class="space-y-1">
                        <label for="tipo_gasto" class="block text-sm font-medium text-secondary-700">
                            Tipo de Gasto <span class="text-danger-500">*</span>
                        </label>
                        <select wire:model="tipo_gasto" id="tipo_gasto" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" <?php echo e($modo == 'show' ? 'disabled' : ''); ?> required>
                            <option value="">Seleccione un tipo</option>
                            <option value="Farmacia">Farmacia</option>
                            <option value="Consulta Médica">Consulta Médica</option>
                            <option value="Estudios Médicos">Estudios Médicos</option>
                            <option value="Tratamiento">Tratamiento</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>

                    <!-- Monto Solicitado -->
                    <div class="space-y-1">
                        <label for="monto_solicitado" class="block text-sm font-medium text-secondary-700">
                            Monto Solicitado <span class="text-danger-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 pl-3 flex items-center">
                                <span class="text-secondary-500 sm:text-sm">$</span>
                            </div>
                            <input type="number" wire:model="monto_solicitado" id="monto_solicitado" class="block w-full pl-7 pr-12 px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="0.00" step="0.01" <?php echo e($modo == 'show' ? 'readonly' : ''); ?> required>
                        </div>
                    </div>

                    <!-- Descripción del Gasto -->
                    <div class="md:col-span-2 space-y-1">
                        <label for="descripcion_gasto" class="block text-sm font-medium text-secondary-700">
                            Descripción del Gasto <span class="text-danger-500">*</span>
                        </label>
                        <textarea wire:model="descripcion_gasto" id="descripcion_gasto" rows="3" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Ej: Compra de analgésicos y material de curación." <?php echo e($modo == 'show' ? 'readonly' : ''); ?> required></textarea>
                    </div>
                </div>
            </div>

            <!-- Documentos Adjuntos -->
            <div class="border-b border-secondary-200 pb-6">
                <h3 class="text-lg font-medium text-secondary-900 mb-4">Documentos Adjuntos (Facturas/Tickets)</h3>
                
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div>
                            <h4 class="text-sm font-medium text-blue-800 mb-1">Subida de Comprobantes</h4>
                            <p class="text-sm text-blue-700">Adjunte las facturas, tickets o cualquier comprobante de los gastos. Puede subir múltiples archivos. Formatos permitidos: PDF, JPG, PNG.</p>
                        </div>
                    </div>
                </div>

                <?php if($modo != 'show'): ?>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-secondary-700 mb-2">Seleccionar Archivos</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-secondary-300 border-dashed rounded-lg hover:border-secondary-400 transition-colors duration-200">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-secondary-400" stroke="currentColor" fill="none" viewBox="0 0 48 48"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                            <div class="flex text-sm text-secondary-600">
                                <label for="archivos" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                    <span>Subir archivos</span>
                                    <input wire:model="archivos" id="archivos" type="file" class="sr-only" multiple>
                                </label>
                                <p class="pl-1">o arrastrar y soltar</p>
                            </div>
                            <p class="text-xs text-secondary-500">PDF, JPG, PNG hasta 10MB</p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <div id="lista_archivos_container">
                    <label class="block text-sm font-medium text-secondary-700 mb-2">
                        <?php echo e($modo == 'show' ? 'Documentos del Reintegro:' : 'Archivos Seleccionados:'); ?>

                    </label>
                    <div id="lista_archivos" class="space-y-2">
                        
                        <?php if($modo != 'create'): ?>
                        <div class="archivo-item flex items-center justify-between bg-white border border-secondary-200 rounded-lg p-3">
                            <div class="flex items-center flex-1"><svg class="w-8 h-8 text-red-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
                                <div class="flex-1 min-w-0">
                                    <div class="font-medium text-secondary-900 truncate">factura_farmacia.pdf</div>
                                    <div class="text-sm text-secondary-600">1.2 MB • 20/05/2024</div>
                                </div>
                            </div>
                            <div class="flex items-center ml-4">
                                <button type="button" class="text-primary-600 hover:text-primary-800 p-1 mr-2" title="Ver archivo"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg></button>
                                <?php if($modo != 'show'): ?>
                                <button type="button" class="text-red-600 hover:text-red-800 p-1" title="Eliminar archivo"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        
                        <?php if(!empty($archivos) && is_array($archivos)): ?>
                            <?php $__currentLoopData = $archivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $archivo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="archivo-item flex items-center justify-between bg-white border border-secondary-200 rounded-lg p-3">
                                <div class="flex items-center flex-1">
                                    <div class="flex-1 min-w-0">
                                        <div class="font-medium text-secondary-900 truncate"><?php echo e($archivo->getClientOriginalName()); ?></div>
                                        <div class="text-sm text-secondary-600"><?php echo e(round($archivo->getSize() / 1024, 2)); ?> KB</div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php elseif($modo == 'create'): ?>
                            <div class="text-center py-8 border-2 border-dashed border-secondary-200 rounded-lg">
                                <p class="text-sm text-secondary-500">No hay archivos seleccionados</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Estado y Auditoría (Solo visible en modo 'show' o 'edit' para roles específicos) -->
            <?php if($modo != 'create'): ?>
            <div class="pb-6">
                <h3 class="text-lg font-medium text-secondary-900 mb-4">Estado y Auditoría</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-secondary-700">Estado Actual</label>
                        <p class="text-sm font-semibold p-2 rounded-lg 
                            <?php if($estado == 'Autorizado'): ?> bg-success-100 text-success-800 <?php endif; ?>
                            <?php if($estado == 'En Proceso'): ?> bg-warning-100 text-warning-800 <?php endif; ?>
                            <?php if($estado == 'Pagado'): ?> bg-blue-100 text-blue-800 <?php endif; ?>
                            <?php if($estado == 'Rechazado'): ?> bg-danger-100 text-danger-800 <?php endif; ?>
                        ">
                            <?php echo e($estado ?? 'En Proceso'); ?>

                        </p>
                    </div>
                    
                </div>
            </div>
            <?php endif; ?>

            <!-- Botones de Acción -->
            <div class="flex items-center justify-between pt-6 border-t border-secondary-200">
                <a href="<?php echo e(route('reintegros.index')); ?>" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Volver al Listado
                </a>
                <?php if($modo != 'show'): ?>
                <button type="submit" class="inline-flex items-center px-6 py-2 bg-primary-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <?php echo e($modo == 'create' ? 'Crear Solicitud' : 'Actualizar Solicitud'); ?>

                </button>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\rican\OneDrive\Documentos\workana\Fondo Solidario\resources\views\livewire\reintegros\form.blade.php ENDPATH**/ ?>