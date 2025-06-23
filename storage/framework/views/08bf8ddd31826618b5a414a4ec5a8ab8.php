<div>
    <!--[if BLOCK]><![endif]--><?php if($mensaje): ?>
    <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: true }" x-show="show" x-transition>
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="show = false"></div>
            <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full sm:p-6">
                <div>
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full <?php echo e($tipoMensaje === 'success' ? 'bg-green-100' : 'bg-red-100'); ?>">
                        <!--[if BLOCK]><![endif]--><?php if($tipoMensaje === 'success'): ?>
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
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

    <form wire:submit.prevent="guardar" class="space-y-6 p-6 bg-white rounded-xl border border-secondary-200">
        <?php echo csrf_field(); ?>
        <!-- Información del Documento -->
        <div class="border-b border-secondary-200 pb-6">
            <h3 class="text-lg font-medium text-secondary-900 mb-4">Información del Documento</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2 space-y-1">
                    <label for="nombre_documento" class="block text-sm font-medium text-secondary-700">Nombre del Documento <span class="text-danger-500">*</span></label>
                    <input wire:model="nombre_documento" type="text" id="nombre_documento" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['nombre_documento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>

                <div class="space-y-1">
                    <label for="id_tipo_documento" class="block text-sm font-medium text-secondary-700">Tipo de Documento <span class="text-danger-500">*</span></label>
                    <select wire:model="id_tipo_documento" id="id_tipo_documento" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm" <?php echo e($modo == 'show' ? 'disabled' : ''); ?>>
                        <option value="">Seleccione un tipo</option>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $tipos_documento; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($tipo->id_tipo_documento); ?>"><?php echo e($tipo->nombre_tipo_documento); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </select>
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['id_tipo_documento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>

                <div class="space-y-1">
                    <label for="id_escuela" class="block text-sm font-medium text-secondary-700">Escuela <span class="text-danger-500">*</span></label>
                    <select wire:model="id_escuela" id="id_escuela" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm" <?php echo e($modo == 'show' || auth()->user()->id_rol == 1 ? 'disabled' : ''); ?>>
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

                <div class="space-y-1">
                    <label for="fecha_documento" class="block text-sm font-medium text-secondary-700">Fecha del Documento</label>
                    <input wire:model="fecha_documento" type="date" id="fecha_documento" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['fecha_documento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>

                <div class="space-y-1">
                    <label for="fecha_vencimiento" class="block text-sm font-medium text-secondary-700">Fecha de Vencimiento</label>
                    <input wire:model="fecha_vencimiento" type="date" id="fecha_vencimiento" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['fecha_vencimiento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>

                <div class="md:col-span-2 space-y-1">
                    <label for="descripcion" class="block text-sm font-medium text-secondary-700">Descripción</label>
                    <textarea wire:model="descripcion" id="descripcion" rows="4" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>></textarea>
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['descripcion'];
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
            <h3 class="text-lg font-medium text-secondary-900 mb-4">Documentos Adjuntos</h3>
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

            <div id="lista_archivos_container">
                <label class="block text-sm font-medium text-secondary-700 mb-2">Archivos:</label>
                <div class="space-y-2">
                    <!--[if BLOCK]><![endif]--><?php if(count($archivos_existentes) > 0): ?>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $archivos_existentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $archivo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center justify-between bg-white border border-secondary-200 rounded-lg p-3">
                                <div class="flex items-center flex-1">
                                    <a href="<?php echo e(Storage::url($archivo->ruta_archivo)); ?>" target="_blank" class="font-medium text-secondary-900 truncate hover:text-primary-600"><?php echo e($archivo->nombre_archivo); ?></a>
                                    <span class="text-sm text-secondary-600 ml-2">(<?php echo e($archivo->tamano_formateado); ?>)</span>
                                </div>
                                <!--[if BLOCK]><![endif]--><?php if($modo != 'show'): ?>
                                <button wire:click.prevent="eliminarArchivoExistente(<?php echo e($archivo->id_archivo); ?>)" type="button" class="text-red-600 hover:text-red-800 p-1 ml-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <!--[if BLOCK]><![endif]--><?php if(count($archivos_adjuntos) > 0): ?>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $archivos_adjuntos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $archivo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center justify-between bg-white border border-secondary-200 rounded-lg p-3">
                                <div class="font-medium text-secondary-900 truncate"><?php echo e($archivo->getClientOriginalName()); ?></div>
                                <button wire:click.prevent="$removeUpload('archivos_adjuntos', '<?php echo e($archivo->getFilename()); ?>')" type="button" class="text-red-600 hover:text-red-800 p-1"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <?php if(count($archivos_existentes) == 0 && count($archivos_adjuntos) == 0): ?>
                        <div class="text-center py-8 border-2 border-dashed border-secondary-200 rounded-lg">
                            <p class="text-sm text-secondary-500">No hay documentos adjuntos</p>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="flex items-center justify-between pt-6 border-t border-secondary-200">
            <a href="<?php echo e(route('documentos.index')); ?>" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50">Volver al Listado</a>
            <!--[if BLOCK]><![endif]--><?php if($modo != 'show'): ?>
            <button type="submit" class="inline-flex items-center px-6 py-2 bg-primary-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-primary-700">
                <div wire:loading.remove wire:target="guardar">
                    <?php echo e($modo == 'create' ? 'Guardar Documento' : 'Actualizar Documento'); ?>

                </div>
                <div wire:loading wire:target="guardar">
                    Guardando...
                </div>
            </button>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </form>

    <?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('mostrar-mensaje', () => {
                // El modal se muestra automáticamente por las directivas de Alpine
            });

            Livewire.on('mostrar-mensaje-y-redirigir', () => {
                setTimeout(() => {
                    window.Livewire.find('<?php echo e($_instance->getId()); ?>').call('redirigirAlListado');
                }, 3000);
            });
        });
    </script>
    <?php $__env->stopPush(); ?>
</div><?php /**PATH C:\Users\rican\OneDrive\Documentos\workana\Fondo Solidario\resources\views/livewire/documentos/form.blade.php ENDPATH**/ ?>