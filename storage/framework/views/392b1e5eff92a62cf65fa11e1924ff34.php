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
                        <div class="space-y-1">
                            <label for="id_escuela" class="block text-sm font-medium text-secondary-700">Escuela <span class="text-danger-500">*</span></label>
                            <select wire:model.live="id_escuela" id="id_escuela" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e(($modo == 'show' || $esUsuarioGeneral) ? 'bg-secondary-50' : 'bg-white'); ?>" <?php echo e(($modo == 'show' || $esUsuarioGeneral) ? 'disabled' : ''); ?>>
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
                            <input wire:model="fecha_salida" type="date" id="fecha_salida" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['fecha_salida'];
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
                            <input wire:model="fecha_hasta" type="date" id="fecha_hasta" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
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

                        <!-- Hora de Salida -->
                        <div class="space-y-1">
                            <label for="hora_salida" class="block text-sm font-medium text-secondary-700">Hora de Salida <span class="text-danger-500">*</span></label>
                            <input wire:model="hora_salida" type="time" id="hora_salida" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['hora_salida'];
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
                            <input wire:model="hora_regreso" type="time" id="hora_regreso" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
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
                            <input wire:model="destino" type="text" id="destino" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Ej: Museo de Ciencias Naturales" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
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
                            <textarea wire:model="proposito" id="proposito" rows="3" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Describa el propósito de la salida educativa" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>></textarea>
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
                            <input wire:model="cantidad_alumnos" type="number" id="cantidad_alumnos" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Ej: 30" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
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
                            <textarea wire:model="docentes_acompanantes" id="docentes_acompanantes" rows="3" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Ej: Prof. Ana Gómez, Prof. Carlos Ruiz" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>></textarea>
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
                            <input wire:model="transporte" type="text" id="transporte" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Ej: Colectivo escolar" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
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
                <div class="border-b border-secondary-200 pb-6">
                    <h3 class="text-lg font-medium text-secondary-900 mb-4">Archivos Adjuntos</h3>

                    <!--[if BLOCK]><![endif]--><?php if($modo != 'show'): ?>
                    <div class="mb-6" x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-secondary-300 border-dashed rounded-lg">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-secondary-400" stroke="currentColor" fill="none" viewBox="0 0 48 48"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                                <div class="flex text-sm text-secondary-600">
                                    <label for="archivos_adjuntos" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500">
                                        <span>Subir archivos</span>
                                        <input wire:model="archivos_adjuntos" id="archivos_adjuntos" type="file" class="sr-only" multiple>
                                    </label>
                                    <p class="pl-1">o arrastrar y soltar</p>
                                </div>
                                <p class="text-xs text-secondary-500">PDF, JPG, PNG hasta 10MB</p>
                            </div>
                        </div>
                        <div x-show="isUploading"><progress max="100" x-bind:value="progress" class="w-full"></progress></div>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['archivos_adjuntos.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <div>
                        <!--[if BLOCK]><![endif]--><?php if(count($archivos_existentes) > 0): ?>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $archivos_existentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $archivo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="bg-white border border-secondary-200 rounded-lg p-3 mb-2">
                                    <!--[if BLOCK]><![endif]--><?php if(in_array(strtolower($archivo['tipo_archivo'] ?? ''), ['jpg', 'jpeg', 'png', 'gif', 'webp'])): ?>
                                    <div class="mb-2">
                                        <a href="<?php echo e(Storage::url($archivo['ruta_archivo'])); ?>" target="_blank">
                                            <img src="<?php echo e(Storage::url($archivo['ruta_archivo'])); ?>" alt="<?php echo e($archivo['nombre_archivo']); ?>" class="max-h-48 rounded-md border border-secondary-200 object-contain">
                                        </a>
                                    </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center flex-1">
                                            <a href="<?php echo e(Storage::url($archivo['ruta_archivo'])); ?>" target="_blank" class="font-medium text-secondary-900 truncate hover:text-primary-600"><?php echo e($archivo['nombre_archivo']); ?></a>
                                            <span class="text-sm text-secondary-600 ml-2">(<?php echo e(number_format(($archivo['tamano'] ?? 0) / 1024, 1)); ?> KB)</span>
                                        </div>
                                        <!--[if BLOCK]><![endif]--><?php if($modo != 'show'): ?>
                                        <button wire:click.prevent="eliminarArchivoExistente(<?php echo e($archivo['id_archivo']); ?>)" type="button" class="text-red-600 hover:text-red-800 p-1 ml-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <!--[if BLOCK]><![endif]--><?php if(count($archivos_adjuntos) > 0): ?>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $archivos_adjuntos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $archivo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex items-center justify-between bg-blue-50 border border-blue-200 rounded-lg p-3 mb-2">
                                    <div class="font-medium text-secondary-900 truncate"><?php echo e($archivo->getClientOriginalName()); ?> <span class="text-xs text-blue-600">(nuevo)</span></div>
                                    <button wire:click.prevent="$removeUpload('archivos_adjuntos', '<?php echo e($archivo->getFilename()); ?>')" type="button" class="text-red-600 hover:text-red-800 p-1"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <?php if(count($archivos_existentes) == 0 && count($archivos_adjuntos) == 0): ?>
                            <div class="text-center py-8 border-2 border-dashed border-secondary-200 rounded-lg">
                                <p class="text-sm text-secondary-500">No hay archivos adjuntos</p>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
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
<?php $__env->stopPush(); ?><?php /**PATH /home/passion/Documents/FondoSolidarioEntrega11/Fondo Solidario Entrega/resources/views/livewire/salidas_educativas/form.blade.php ENDPATH**/ ?>