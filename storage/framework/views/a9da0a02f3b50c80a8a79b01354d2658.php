<div>
    <!--[if BLOCK]><![endif]--><?php if($mensaje): ?>
        <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: true }" x-show="show" x-transition>
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="show = false"></div>
                <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full sm:p-6">
                    <div>
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full <?php echo e($tipoMensaje === 'success' ? 'bg-green-100' : 'bg-red-100'); ?>">
                            <!--[if BLOCK]><![endif]--><?php if($tipoMensaje === 'success'): ?>
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div class="mt-3 text-center sm:mt-5">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">¡Éxito!</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500"><?php echo e($mensaje); ?></p>
                                <!--[if BLOCK]><![endif]--><?php if($modo == 'create' && $tipoMensaje === 'success'): ?>
                                    <p class="text-xs text-gray-400 mt-2">Redirigiendo al listado en 3 segundos...</p>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-6">
                        <!--[if BLOCK]><![endif]--><?php if($modo == 'create'): ?>
                            <button @click="show = false" wire:click="redirigirAlListado" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 hover:bg-green-700 text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:text-sm">
                                Ir al Listado
                            </button>
                        <?php else: ?>
                            <button @click="show = false" wire:click="limpiarMensaje" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 hover:bg-green-700 text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:text-sm">
                                Aceptar
                            </button>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <div class="mx-auto px-4">
        <!-- Formulario -->
        <div class="bg-white rounded-xl border border-secondary-200">
            <form wire:submit.prevent="guardar" class="space-y-6 p-6" enctype="multipart/form-data">
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
                            <select wire:model.live="id_accidente" id="id_accidente" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" <?php echo e($modo == 'show' ? 'disabled' : ''); ?> required>
                                <option value="">Seleccione un accidente</option>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $accidentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accidente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($accidente->id_accidente); ?>">
                                        ACC-<?php echo e(str_pad($accidente->id_accidente, 3, '0', STR_PAD_LEFT)); ?> (<?php echo e($accidente->fecha_accidente->format('d/m/Y')); ?> - <?php echo e(\Carbon\Carbon::parse($accidente->hora_accidente)->format('h:i A')); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </select>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['id_accidente'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Alumno Involucrado -->
                        <!--[if BLOCK]><![endif]--><?php if(count($alumnosDelAccidente) > 0): ?>
                        <div class="space-y-1">
                            <label for="id_alumno" class="block text-sm font-medium text-secondary-700">
                                Alumno Involucrado <span class="text-danger-500">*</span>
                            </label>
                            <select wire:model="id_alumno" id="id_alumno" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" <?php echo e($modo == 'show' ? 'disabled' : ''); ?> required>
                                <option value="">Seleccione un alumno</option>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $alumnosDelAccidente; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accidenteAlumno): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($accidenteAlumno->alumno->id_alumno); ?>">
                                        <?php echo e($accidenteAlumno->alumno->nombre_completo); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </select>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['id_alumno'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        <!-- Fecha de Solicitud -->
                        <div class="space-y-1">
                            <label for="fecha_solicitud" class="block text-sm font-medium text-secondary-700">
                                Fecha de Solicitud <span class="text-danger-500">*</span>
                            </label>
                            <input type="date" wire:model="fecha_solicitud" id="fecha_solicitud" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" <?php echo e($modo == 'show' ? 'readonly' : ''); ?> required>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['fecha_solicitud'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Tipo de Gasto -->
                        <div class="space-y-1">
                            <label for="id_tipo_gasto" class="block text-sm font-medium text-secondary-700">
                                Tipo de Gasto <span class="text-danger-500">*</span>
                            </label>
                            <select wire:model="id_tipo_gasto" id="id_tipo_gasto" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" <?php echo e($modo == 'show' ? 'disabled' : ''); ?> required>
                                <option value="">Seleccione un tipo</option>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $tiposGasto; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($tipo->id_tipo_gasto); ?>"><?php echo e($tipo->descripcion); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </select>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['id_tipo_gasto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
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
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['monto_solicitado'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Descripción del Gasto -->
                        <div class="md:col-span-2 space-y-1">
                            <label for="descripcion_gasto" class="block text-sm font-medium text-secondary-700">
                                Descripción del Gasto <span class="text-danger-500">*</span>
                            </label>
                            <textarea wire:model="descripcion_gasto" id="descripcion_gasto" rows="3" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Ej: Compra de analgésicos y material de curación." <?php echo e($modo == 'show' ? 'readonly' : ''); ?> required></textarea>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['descripcion_gasto'];
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

                <!-- Documentos Adjuntos -->
                <div class="border-b border-secondary-200 pb-6">
                    <h3 class="text-lg font-medium text-secondary-900 mb-4">Documentos Adjuntos (Facturas/Tickets)</h3>
                    
                    <!--[if BLOCK]><![endif]--><?php if($modo != 'show'): ?>
                    <div class="mb-6"
                         x-data="{ isUploading: false, progress: 0 }"
                         x-on:livewire-upload-start="isUploading = true"
                         x-on:livewire-upload-finish="isUploading = false"
                         x-on:livewire-upload-error="isUploading = false"
                         x-on:livewire-upload-progress="progress = $event.detail.progress">
                        <label class="block text-sm font-medium text-secondary-700 mb-2">Seleccionar Archivos</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-secondary-300 border-dashed rounded-lg hover:border-secondary-400 transition-colors duration-200">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-secondary-400" stroke="currentColor" fill="none" viewBox="0 0 48 48"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                                <div class="flex text-sm text-secondary-600">
                                    <label for="archivos_adjuntos" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus:within:ring-primary-500">
                                        <span>Subir archivos</span>
                                        <input wire:model="archivos_adjuntos" id="archivos_adjuntos" type="file" class="sr-only" multiple>
                                    </label>
                                    <p class="pl-1">o arrastrar y soltar</p>
                                </div>
                                <p class="text-xs text-secondary-500">PDF, JPG, PNG hasta 10MB</p>
                            </div>
                        </div>
                        <div x-show="isUploading">
                            <progress max="100" x-bind:value="progress" class="w-full"></progress>
                        </div>
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

                    <div id="lista_archivos_container">
                        <label class="block text-sm font-medium text-secondary-700 mb-2">
                            <?php echo e($modo == 'show' ? 'Documentos del Reintegro:' : 'Archivos Adjuntos:'); ?>

                        </label>
                        <div class="space-y-2">
                            <!--[if BLOCK]><![endif]--><?php if($archivos_existentes->isNotEmpty()): ?>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $archivos_existentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $archivo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex items-center justify-between bg-white border border-secondary-200 rounded-lg p-3">
                                        <div class="flex items-center flex-1">
                                            <a href="<?php echo e(Storage::url($archivo->ruta_archivo)); ?>" target="_blank" class="font-medium text-secondary-900 truncate hover:text-primary-600">
                                                <?php echo e($archivo->nombre_archivo); ?>

                                            </a>
                                        </div>
                                        <!--[if BLOCK]><![endif]--><?php if($modo != 'show'): ?>
                                        <button wire:click.prevent="eliminarArchivoExistente(<?php echo e($archivo->id_archivo); ?>)" type="button" class="text-red-600 hover:text-red-800 p-1">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <!--[if BLOCK]><![endif]--><?php if(!empty($archivos_adjuntos)): ?>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $archivos_adjuntos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $archivo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex items-center justify-between bg-white border border-secondary-200 rounded-lg p-3">
                                    <div class="font-medium text-secondary-900 truncate"><?php echo e($archivo->getClientOriginalName()); ?></div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <!--[if BLOCK]><![endif]--><?php if($archivos_existentes->isEmpty() && empty($archivos_adjuntos)): ?>
                                <div class="text-center py-8 border-2 border-dashed border-secondary-200 rounded-lg">
                                    <p class="text-sm text-secondary-500">No hay archivos adjuntos</p>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="flex items-center justify-between pt-6 border-t border-secondary-200">
                    <a href="<?php echo e(route('reintegros.index')); ?>" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50">
                        Volver al Listado
                    </a>
                    <!--[if BLOCK]><![endif]--><?php if($modo != 'show'): ?>
                    <button type="submit" class="inline-flex items-center px-6 py-2 bg-primary-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-primary-700">
                        <?php echo e($modo == 'create' ? 'Crear Solicitud' : 'Actualizar Solicitud'); ?>

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
            // El modal se muestra automáticamente por la variable $mensaje
        });

        Livewire.on('mostrar-mensaje-y-redirigir', () => {
            setTimeout(() => {
                window.Livewire.find('<?php echo e($_instance->getId()); ?>').call('redirigirAlListado');
            }, 3000);
        });
    });
</script>
<?php $__env->stopPush(); ?><?php /**PATH C:\Users\rican\OneDrive\Documentos\workana\Fondo Solidario\resources\views/livewire/reintegros/form.blade.php ENDPATH**/ ?>