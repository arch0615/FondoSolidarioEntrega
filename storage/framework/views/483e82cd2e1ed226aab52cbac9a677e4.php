<div>
    <!-- Modal de confirmación -->
    <?php if($mensaje): ?>
    <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: true }" x-show="show" x-transition>
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="show = false"></div>
            <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full sm:p-6">
                <div>
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full <?php echo e($tipoMensaje === 'success' ? 'bg-green-100' : 'bg-red-100'); ?>">
                        <?php if($tipoMensaje === 'success'): ?>
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        <?php endif; ?>
                    </div>
                    <div class="mt-3 text-center sm:mt-5">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">¡Éxito!</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500"><?php echo e($mensaje); ?></p>
                            <?php if($modo == 'create' && $tipoMensaje === 'success'): ?>
                                <p class="text-xs text-gray-400 mt-2">Redirigiendo al listado en 3 segundos...</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-6">
                    <?php if($modo == 'create'): ?>
                        <button @click="show = false" wire:click="redirigirAlListado" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 hover:bg-green-700 text-base font-medium text-white">
                            Ir al Listado
                        </button>
                    <?php else: ?>
                        <button @click="show = false" wire:click="limpiarMensaje" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 hover:bg-green-700 text-base font-medium text-white">
                            Aceptar
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Formulario -->
    <div class="bg-white rounded-xl border border-secondary-200">
        <form wire:submit.prevent="guardar" class="space-y-6 p-6">
            <?php echo csrf_field(); ?>
            <!-- Información Básica -->
            <div class="border-b border-secondary-200 pb-6">
                <h3 class="text-lg font-medium text-secondary-900 mb-4">Información Básica</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="codigo_escuela" class="block text-sm font-medium text-secondary-700">Código de Escuela <span class="text-red-500">*</span></label>
                        <input wire:model="codigo_escuela" type="text" id="codigo_escuela" class="block w-full mt-1" :disabled="$modo == 'show'">
                        <?php $__errorArgs = ['codigo_escuela'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-secondary-700">Nombre de Escuela <span class="text-red-500">*</span></label>
                        <input wire:model="nombre" type="text" id="nombre" class="block w-full mt-1" :disabled="$modo == 'show'">
                        <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="md:col-span-2">
                        <label for="direccion" class="block text-sm font-medium text-secondary-700">Dirección</label>
                        <input wire:model="direccion" type="text" id="direccion" class="block w-full mt-1" :disabled="$modo == 'show'">
                        <?php $__errorArgs = ['direccion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>
            <!-- Información de Contacto -->
            <div class="border-b border-secondary-200 pb-6">
                <h3 class="text-lg font-medium text-secondary-900 mb-4">Información de Contacto</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="telefono" class="block text-sm font-medium text-secondary-700">Teléfono</label>
                        <input wire:model="telefono" type="tel" id="telefono" class="block w-full mt-1" :disabled="$modo == 'show'">
                        <?php $__errorArgs = ['telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-secondary-700">Correo Electrónico</label>
                        <input wire:model="email" type="email" id="email" class="block w-full mt-1" :disabled="$modo == 'show'">
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>
            <!-- Configuración Financiera y Estado -->
            <div class="border-b border-secondary-200 pb-6">
                <h3 class="text-lg font-medium text-secondary-900 mb-4">Configuración</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="aporte_por_alumno" class="block text-sm font-medium text-secondary-700">Aporte por Alumno (ARS) <span class="text-red-500">*</span></label>
                        <input wire:model="aporte_por_alumno" type="number" step="0.01" id="aporte_por_alumno" class="block w-full mt-1" :disabled="$modo == 'show'">
                        <?php $__errorArgs = ['aporte_por_alumno'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label for="fecha_alta" class="block text-sm font-medium text-secondary-700">Fecha de Alta <span class="text-red-500">*</span></label>
                        <input wire:model="fecha_alta" type="date" id="fecha_alta" class="block w-full mt-1" :disabled="$modo == 'show'">
                        <?php $__errorArgs = ['fecha_alta'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="md:col-span-2 flex items-center">
                        <input wire:model="activo" type="checkbox" id="activo" class="w-4 h-4 text-primary-600 rounded" :disabled="$modo == 'show'">
                        <label for="activo" class="ml-3 text-sm font-medium text-secondary-700">Escuela Activa</label>
                    </div>
                </div>
            </div>
            <!-- Botones de Acción -->
            <div class="flex items-center justify-between pt-6">
                <a href="<?php echo e(route('escuelas.index')); ?>" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50">
                    Volver al Listado
                </a>
                <?php if($modo != 'show'): ?>
                <button type="submit" class="inline-flex items-center px-6 py-2 bg-primary-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-primary-700">
                    <?php echo e($modo == 'create' ? 'Crear Escuela' : 'Actualizar Escuela'); ?>

                </button>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('mostrar-mensaje', () => {
            // Lógica si es necesaria al mostrar el modal en modo edición
        });

        Livewire.on('mostrar-mensaje-y-redirigir', () => {
            setTimeout(() => {
                window.Livewire.find('<?php echo e($_instance->getId()); ?>').call('redirigirAlListado');
            }, 3000);
        });
    });
</script>
<?php $__env->stopPush(); ?><?php /**PATH C:\Users\rican\OneDrive\Documentos\workana\Fondo Solidario\resources\views\livewire\escuelas\form.blade.php ENDPATH**/ ?>