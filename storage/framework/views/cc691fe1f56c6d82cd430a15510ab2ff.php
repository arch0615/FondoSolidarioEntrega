<div>
    <!-- Toast notifications are handled by the layout's toast system -->

    <div class="mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <nav class="flex items-center text-sm text-secondary-500 mb-4">
                <a href="<?php echo e(route('salidas-educativas.index')); ?>" class="hover:text-secondary-700">Salidas Educativas</a>
                <svg class="mx-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-secondary-900"><?php echo e($modo == 'create' ? 'Nueva Salida Educativa' : ($modo == 'edit' ? 'Editar Salida Educativa' : 'Detalles de Salida Educativa')); ?></span>
            </nav>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-secondary-900">
                        <?php echo e($modo == 'create' ? 'Nueva Salida Educativa' : ($modo == 'edit' ? 'Editar Salida Educativa' : 'Detalles de Salida Educativa')); ?>

                    </h1>
                    <p class="mt-1 text-sm text-secondary-600">
                        <?php echo e($modo == 'create' ? 'Complete los datos para registrar una nueva salida educativa' : ($modo == 'edit' ? 'Modifique los datos de la salida educativa' : 'Información detallada de la salida educativa')); ?>

                    </p>
                </div>
                <!--[if BLOCK]><![endif]--><?php if($modo == 'show'): ?>
                <div class="flex space-x-3">
                    <a href="<?php echo e(route('salidas-educativas.print', $salida_id)); ?>" target="_blank" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Imprimir
                    </a>
                    <a href="<?php echo e(route('salidas-educativas.edit', $salida_id)); ?>" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Editar
                    </a>
                </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>

        <!-- Formulario -->
        <div class="bg-white rounded-xl border border-secondary-200">
            <form wire:submit.prevent="guardar" class="space-y-6 p-6">
                <?php echo csrf_field(); ?>

                <!-- Información de la Salida -->
                <div class="border-b border-secondary-200 pb-6">
                    <h3 class="text-lg font-medium text-secondary-900 mb-4">Información de la Salida</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Escuela -->
                        <div class="md:col-span-2 space-y-1">
                            <label for="id_escuela" class="block text-sm font-medium text-secondary-700">Escuela <span class="text-danger-500">*</span></label>
                            <select wire:model.live="id_escuela" id="id_escuela" class="block w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($errors->has('id_escuela') ? 'border-red-500 ring-1 ring-red-500' : 'border-secondary-300'); ?> <?php echo e(($modo == 'show' || $esUsuarioGeneral) ? 'bg-secondary-50' : 'bg-white'); ?>" <?php echo e(($modo == 'show' || $esUsuarioGeneral) ? 'disabled' : ''); ?>>
                                <option value="">Seleccione una escuela</option>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $escuelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $escuela): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($escuela->id_escuela); ?>"><?php echo e($escuela->nombre); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </select>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['id_escuela'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Fecha Desde -->
                        <div class="space-y-1">
                            <label for="fecha_salida" class="block text-sm font-medium text-secondary-700">Fecha Desde <span class="text-danger-500">*</span></label>
                            <input wire:model="fecha_salida" type="date" id="fecha_salida" class="block w-full px-3 py-2 border rounded-lg text-sm <?php echo e($errors->has('fecha_salida') ? 'border-red-500 ring-1 ring-red-500' : 'border-secondary-300'); ?> <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['fecha_salida'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Hora de Salida -->
                        <div class="space-y-1">
                            <label for="hora_salida" class="block text-sm font-medium text-secondary-700">Hora de Salida <span class="text-danger-500">*</span></label>
                            <input wire:model="hora_salida" type="time" id="hora_salida" class="block w-full px-3 py-2 border rounded-lg text-sm <?php echo e($errors->has('hora_salida') ? 'border-red-500 ring-1 ring-red-500' : 'border-secondary-300'); ?> <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['hora_salida'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Fecha Hasta -->
                        <div class="space-y-1">
                            <label for="fecha_hasta" class="block text-sm font-medium text-secondary-700">Fecha Hasta</label>
                            <input wire:model="fecha_hasta" type="date" id="fecha_hasta" class="block w-full px-3 py-2 border rounded-lg text-sm <?php echo e($errors->has('fecha_hasta') ? 'border-red-500 ring-1 ring-red-500' : 'border-secondary-300'); ?> <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
                            <p class="text-xs text-secondary-400">Dejar vacío si la salida es de un solo día</p>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['fecha_hasta'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Hora de Regreso -->
                        <div class="space-y-1">
                            <label for="hora_regreso" class="block text-sm font-medium text-secondary-700">Hora de Regreso <span class="text-danger-500">*</span></label>
                            <input wire:model="hora_regreso" type="time" id="hora_regreso" class="block w-full px-3 py-2 border rounded-lg text-sm <?php echo e($errors->has('hora_regreso') ? 'border-red-500 ring-1 ring-red-500' : 'border-secondary-300'); ?> <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['hora_regreso'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Destino -->
                        <div class="md:col-span-2 space-y-1">
                            <label for="destino" class="block text-sm font-medium text-secondary-700">Destino <span class="text-danger-500">*</span></label>
                            <input wire:model="destino" type="text" id="destino" class="block w-full px-3 py-2 border rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($errors->has('destino') ? 'border-red-500 ring-1 ring-red-500' : 'border-secondary-300'); ?> <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Ej: Museo de Ciencias Naturales" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['destino'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Propósito -->
                        <div class="md:col-span-2 space-y-1">
                            <label for="proposito" class="block text-sm font-medium text-secondary-700">Propósito <span class="text-danger-500">*</span></label>
                            <textarea wire:model="proposito" id="proposito" rows="3" class="block w-full px-3 py-2 border rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($errors->has('proposito') ? 'border-red-500 ring-1 ring-red-500' : 'border-secondary-300'); ?> <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Describa el propósito de la salida educativa" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>></textarea>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['proposito'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>


                        <!-- Grado/Curso -->
                        <div class="space-y-1">
                            <label for="grado_curso" class="block text-sm font-medium text-secondary-700">Grado/Curso</label>
                            <input wire:model="grado_curso" type="text" id="grado_curso" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Ej: 3er Año A" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['grado_curso'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Cantidad de Alumnos -->
                        <div class="space-y-1">
                            <label for="cantidad_alumnos" class="block text-sm font-medium text-secondary-700">Cantidad de Alumnos <span class="text-danger-500">*</span></label>
                            <input wire:model="cantidad_alumnos" type="number" id="cantidad_alumnos" class="block w-full px-3 py-2 border rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($errors->has('cantidad_alumnos') ? 'border-red-500 ring-1 ring-red-500' : 'border-secondary-300'); ?> <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Ej: 30" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['cantidad_alumnos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Docentes Acompañantes -->
                        <div class="md:col-span-2 space-y-1">
                            <label for="docentes_acompanantes" class="block text-sm font-medium text-secondary-700">Docentes Acompañantes <span class="text-danger-500">*</span></label>
                            <textarea wire:model="docentes_acompanantes" id="docentes_acompanantes" rows="3" class="block w-full px-3 py-2 border rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($errors->has('docentes_acompanantes') ? 'border-red-500 ring-1 ring-red-500' : 'border-secondary-300'); ?> <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Ej: Prof. Ana Gómez, Prof. Carlos Ruiz" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>></textarea>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['docentes_acompanantes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Medio de Transporte -->
                        <div class="md:col-span-2 space-y-1">
                            <label for="transporte" class="block text-sm font-medium text-secondary-700">Medio de Transporte <span class="text-danger-500">*</span></label>
                            <input wire:model="transporte" type="text" id="transporte" class="block w-full px-3 py-2 border rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($errors->has('transporte') ? 'border-red-500 ring-1 ring-red-500' : 'border-secondary-300'); ?> <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Ej: Colectivo escolar" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['transporte'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                </div>

                <!-- Archivos Adjuntos -->
                <div class="border-b border-secondary-200 pb-6" x-data="{ showDetail: false, detailArchivo: null }">
                    <h3 class="text-lg font-medium text-secondary-900 mb-4">Archivos Adjuntos</h3>

                    <div class="flex flex-wrap gap-4">
                        
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $archivos_existentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $archivo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="relative rounded-xl border border-secondary-200 bg-white shadow-sm" style="width: 10rem; height: 10rem;" x-data="{ hover: false }" x-on:mouseenter="hover = true" x-on:mouseleave="hover = false">
                            
                            <div class="absolute inset-0 overflow-hidden rounded-xl">
                                <!--[if BLOCK]><![endif]--><?php if(in_array(strtolower($archivo['tipo_archivo'] ?? ''), ['jpg', 'jpeg', 'png', 'gif', 'webp'])): ?>
                                    <img src="<?php echo e(Storage::url($archivo['ruta_archivo'])); ?>" alt="<?php echo e($archivo['nombre_archivo']); ?>" class="w-full h-full object-cover">
                                <?php elseif(strtolower($archivo['tipo_archivo'] ?? '') === 'pdf'): ?>
                                    <div class="w-full h-full flex flex-col items-center justify-center bg-red-50">
                                        <svg class="w-12 h-12 text-red-500" fill="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm-1 2l5 5h-5V4zM6 20V4h5v7h7v9H6z"/><path d="M8 12h1.5v1.5h1V12H12v-1.5h-1.5V9h-1v1.5H8V12zm0 2.5h4V16H8v-1.5z"/></svg>
                                        <span class="text-xs text-red-600 font-medium mt-1">PDF</span>
                                    </div>
                                <?php else: ?>
                                    <div class="w-full h-full flex flex-col items-center justify-center bg-secondary-50">
                                        <svg class="w-12 h-12 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                        <span class="text-xs text-secondary-500 font-medium mt-1"><?php echo e(strtoupper($archivo['tipo_archivo'] ?? 'FILE')); ?></span>
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            
                            <div class="absolute bottom-0 left-0 right-0 bg-white/90 backdrop-blur-sm px-2 py-1 border-t border-secondary-100 rounded-b-xl z-10">
                                <p class="text-xs text-secondary-700 truncate"><?php echo e($archivo['nombre_archivo']); ?></p>
                            </div>
                            
                            <!--[if BLOCK]><![endif]--><?php if($modo != 'show'): ?>
                            <div x-show="hover" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                 class="absolute inset-0 rounded-xl z-20 flex items-center justify-center" style="background-color: rgba(156,163,175,0.7); display: none;">
                                
                                <button wire:click.prevent="eliminarArchivoExistente(<?php echo e($archivo['id_archivo']); ?>)" type="button"
                                    class="text-black hover:scale-110 transition-transform" title="Eliminar">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                        
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $archivos_adjuntos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $archivo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="relative rounded-xl border-2 border-blue-300 bg-blue-50 shadow-sm" style="width: 10rem; height: 10rem;" x-data="{ hover: false }" x-on:mouseenter="hover = true" x-on:mouseleave="hover = false">
                            
                            <div class="absolute inset-0 overflow-hidden rounded-xl">
                                <!--[if BLOCK]><![endif]--><?php if(in_array(strtolower($archivo->getClientOriginalExtension()), ['jpg', 'jpeg', 'png', 'gif', 'webp'])): ?>
                                    <img src="<?php echo e($archivo->temporaryUrl()); ?>" alt="<?php echo e($archivo->getClientOriginalName()); ?>" class="w-full h-full object-cover">
                                <?php elseif(strtolower($archivo->getClientOriginalExtension()) === 'pdf'): ?>
                                    <div class="w-full h-full flex flex-col items-center justify-center bg-red-50">
                                        <svg class="w-12 h-12 text-red-500" fill="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm-1 2l5 5h-5V4zM6 20V4h5v7h7v9H6z"/><path d="M8 12h1.5v1.5h1V12H12v-1.5h-1.5V9h-1v1.5H8V12zm0 2.5h4V16H8v-1.5z"/></svg>
                                        <span class="text-xs text-red-600 font-medium mt-1">PDF</span>
                                    </div>
                                <?php else: ?>
                                    <div class="w-full h-full flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            
                            <div class="absolute bottom-0 left-0 right-0 bg-blue-100/90 backdrop-blur-sm px-2 py-1 border-t border-blue-200 rounded-b-xl z-10">
                                <p class="text-xs text-secondary-700 truncate"><?php echo e($archivo->getClientOriginalName()); ?></p>
                            </div>
                            
                            <div x-show="hover" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                 class="absolute inset-0 rounded-xl z-20 flex items-center justify-center" style="background-color: rgba(156,163,175,0.7); display: none;">
                                
                                <button wire:click.prevent="removeNuevoArchivo(<?php echo e($index); ?>)" type="button"
                                    class="text-black hover:scale-110 transition-transform" title="Quitar">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                        
                        <!--[if BLOCK]><![endif]--><?php if($modo != 'show'): ?>
                        <div x-data="{ isUploading: false, progress: 0 }"
                             x-on:livewire-upload-start="isUploading = true"
                             x-on:livewire-upload-finish="isUploading = false"
                             x-on:livewire-upload-error="isUploading = false"
                             x-on:livewire-upload-progress="progress = $event.detail.progress">
                            <label for="archivos_nuevos" class="group relative rounded-xl border-2 border-dashed border-secondary-300 bg-secondary-50 hover:bg-secondary-100 hover:border-primary-400 cursor-pointer transition-colors duration-200" style="width: 10rem; height: 10rem; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                <svg class="w-10 h-10 text-secondary-400 group-hover:text-primary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                <span class="text-xs text-secondary-500 group-hover:text-primary-600 mt-1 font-medium">Agregar archivo</span>
                                <span class="text-[10px] text-secondary-400 mt-0.5">PDF, JPG, PNG</span>
                                <input wire:model="archivos_nuevos" id="archivos_nuevos" type="file" class="sr-only" multiple accept=".pdf,.jpg,.jpeg,.png">
                            </label>
                            
                            <div x-show="isUploading" class="mt-2 w-40">
                                <div class="w-full bg-secondary-200 rounded-full h-1.5">
                                    <div class="bg-primary-500 h-1.5 rounded-full transition-all duration-300" :style="'width: ' + progress + '%'"></div>
                                </div>
                            </div>
                        </div>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['archivos_nuevos.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        
                        <!--[if BLOCK]><![endif]--><?php if(count($archivos_existentes) == 0 && count($archivos_adjuntos) == 0 && $modo == 'show'): ?>
                        <div class="w-full text-center py-8 border-2 border-dashed border-secondary-200 rounded-lg">
                            <p class="text-sm text-secondary-500">No hay archivos adjuntos</p>
                        </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    
                    <div x-show="showDetail" x-cloak x-transition:enter="ease-out duration-200" x-transition:leave="ease-in duration-150"
                         class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display: none;">
                        
                        <div class="fixed inset-0 bg-black/40" x-on:click="showDetail = false"></div>
                        
                        <div class="relative bg-white rounded-2xl shadow-xl max-w-lg w-full p-6 z-10" x-on:click.away="showDetail = false">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-secondary-900">Detalle del Archivo</h3>
                                <button type="button" x-on:click="showDetail = false" class="text-secondary-400 hover:text-secondary-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                            <template x-if="detailArchivo">
                                <div>
                                    
                                    <div class="mb-4 rounded-lg overflow-hidden border border-secondary-200 bg-secondary-50 flex items-center justify-center" style="max-height: 300px;">
                                        <template x-if="['jpg','jpeg','png','gif','webp'].includes(detailArchivo.tipo.toLowerCase())">
                                            <img :src="detailArchivo.url" :alt="detailArchivo.nombre" class="max-h-[300px] object-contain">
                                        </template>
                                        <template x-if="!['jpg','jpeg','png','gif','webp'].includes(detailArchivo.tipo.toLowerCase())">
                                            <div class="py-8 text-center">
                                                <svg class="w-16 h-16 text-secondary-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                                <span class="text-sm text-secondary-400 font-medium mt-2 block uppercase" x-text="detailArchivo.tipo"></span>
                                            </div>
                                        </template>
                                    </div>
                                    
                                    <div class="space-y-2 text-sm">
                                        <div class="flex justify-between">
                                            <span class="text-secondary-500">Nombre:</span>
                                            <span class="text-secondary-900 font-medium text-right max-w-[280px] truncate" x-text="detailArchivo.nombre"></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-secondary-500">Tipo:</span>
                                            <span class="text-secondary-900 font-medium uppercase" x-text="detailArchivo.tipo"></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-secondary-500">Tamaño:</span>
                                            <span class="text-secondary-900 font-medium" x-text="detailArchivo.tamano"></span>
                                        </div>
                                        <div class="flex justify-between" x-show="detailArchivo.fecha">
                                            <span class="text-secondary-500">Fecha de carga:</span>
                                            <span class="text-secondary-900 font-medium" x-text="detailArchivo.fecha"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-5 flex justify-end gap-3">
                                        <a :href="detailArchivo.url" target="_blank" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                            Abrir
                                        </a>
                                        <button type="button" x-on:click="showDetail = false" class="px-4 py-2 border border-secondary-300 text-sm font-medium rounded-lg text-secondary-700 hover:bg-secondary-50 transition-colors">
                                            Cerrar
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="flex items-center justify-between pt-6 border-t border-secondary-200">
                    <a href="<?php echo e(route('salidas-educativas.index')); ?>" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Volver al Listado
                    </a>
                    <!--[if BLOCK]><![endif]--><?php if($modo != 'show'): ?>
                    <button type="submit" class="inline-flex items-center px-6 py-2 bg-primary-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <?php echo e($modo == 'create' ? 'Crear Salida Educativa' : 'Actualizar Salida Educativa'); ?>

                    </button>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('mostrar-mensaje', () => {
            // Lógica para mostrar el modal si es necesario, o simplemente para confirmar que el evento se recibió.
        });

        Livewire.on('mostrar-mensaje-y-redirigir', () => {
            setTimeout(() => {
                window.Livewire.find('<?php echo e($_instance->getId()); ?>').call('redirigirAlListado');
            }, 1000);
        });
    });
</script>
<?php $__env->stopPush(); ?><?php /**PATH /home/ubuntu/Documents/FondoSolidarioEntrega/FondoSolidarioEntrega/resources/views/livewire/salidas_educativas/form.blade.php ENDPATH**/ ?>