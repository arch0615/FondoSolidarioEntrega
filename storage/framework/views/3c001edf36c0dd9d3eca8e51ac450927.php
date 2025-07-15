<div>
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
                        <button @click="show = false" wire:click="redirigirAlListado" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 hover:bg-green-700 text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:text-sm">
                            Ir al Listado
                        </button>
                    <?php else: ?>
                        <button @click="show = false" wire:click="limpiarMensaje" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 hover:bg-green-700 text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:text-sm">
                            Aceptar
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Header -->
    <div class="mb-8">
        <nav class="flex items-center text-sm text-secondary-500 mb-4">
            <a href="<?php echo e(route('prestadores.index')); ?>" class="hover:text-secondary-700">Prestadores</a>
            <svg class="mx-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7-7"></path>
            </svg>
            <span class="text-secondary-900"><?php echo e($modo == 'create' ? 'Nuevo Prestador' : ($modo == 'edit' ? 'Editar Prestador' : 'Detalles de Prestador')); ?></span>
        </nav>
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-secondary-900">
                    <?php echo e($modo == 'create' ? 'Nuevo Prestador' : ($modo == 'edit' ? 'Editar Prestador' : 'Detalles de Prestador')); ?>

                </h1>
                <p class="mt-1 text-sm text-secondary-600">
                    <?php echo e($modo == 'create' ? 'Complete los datos para registrar un nuevo prestador médico' : ($modo == 'edit' ? 'Modifique los datos del prestador' : 'Información detallada del prestador médico')); ?>

                </p>
            </div>
            <?php if($modo == 'show'): ?>
            <div class="flex space-x-3">
                <a href="<?php echo e(route('prestadores.edit', $prestador_id)); ?>" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
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
        <form wire:submit.prevent="guardar" class="space-y-6 p-6">
            <?php echo csrf_field(); ?>

            <!-- Información Básica -->
            <div class="border-b border-secondary-200 pb-6">
                <h3 class="text-lg font-medium text-secondary-900 mb-4">Información Básica</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nombre del Prestador -->
                    <div class="md:col-span-2 space-y-1">
                        <label for="nombre" class="block text-sm font-medium text-secondary-700">
                            Nombre del Prestador <span class="text-danger-500">*</span>
                        </label>
                        <input wire:model="nombre" type="text" id="nombre" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Ej: Hospital San Roque" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
                        <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Tipo de Prestador -->
                    <div class="space-y-1">
                        <label for="id_tipo_prestador" class="block text-sm font-medium text-secondary-700">
                            Tipo de Prestador <span class="text-danger-500">*</span>
                        </label>
                        <select wire:model="id_tipo_prestador" id="id_tipo_prestador" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" <?php echo e($modo == 'show' ? 'disabled' : ''); ?>>
                            <option value="">Seleccione un tipo</option>
                            <?php $__currentLoopData = $tiposPrestador; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($tipo->id_tipo_prestador); ?>"><?php echo e($tipo->descripcion); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['id_tipo_prestador'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Sistema de Emergencias -->
                    <div class="space-y-1">
                        <label for="es_sistema_emergencias" class="block text-sm font-medium text-secondary-700">
                            Sistema de Emergencias
                        </label>
                        <div class="flex items-center">
                            <div class="flex items-center h-5">
                                <input wire:model="es_sistema_emergencias" type="checkbox" id="es_sistema_emergencias" class="w-4 h-4 text-primary-600 bg-white border-secondary-300 rounded focus:ring-primary-500 focus:ring-2" <?php echo e($modo == 'show' ? 'disabled' : ''); ?>>
                            </div>
                            <div class="ml-3">
                                <label for="es_sistema_emergencias" class="text-sm text-secondary-700">
                                    Es parte del Sistema de Emergencias y Urgencias médicas
                                </label>
                                <p class="text-xs text-secondary-500">Marque si este prestador forma parte del sistema de emergencias del Fondo Solidario</p>
                            </div>
                        </div>
                        <?php $__errorArgs = ['es_sistema_emergencias'];
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
                    <!-- Dirección -->
                    <div class="md:col-span-2 space-y-1">
                        <label for="direccion" class="block text-sm font-medium text-secondary-700">
                            Dirección <span class="text-danger-500">*</span>
                        </label>
                        <input wire:model="direccion" type="text" id="direccion" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Ej: Av. Vélez Sarsfield 562, Córdoba" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
                        <?php $__errorArgs = ['direccion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Teléfono -->
                    <div class="space-y-1">
                        <label for="telefono" class="block text-sm font-medium text-secondary-700">
                            Teléfono <span class="text-danger-500">*</span>
                        </label>
                        <input wire:model="telefono" type="tel" id="telefono" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Ej: (351) 421-7000" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
                        <?php $__errorArgs = ['telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Email -->
                    <div class="space-y-1">
                        <label for="email" class="block text-sm font-medium text-secondary-700">
                            Correo Electrónico <span class="text-danger-500">*</span>
                        </label>
                        <input wire:model="email" type="email" id="email" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Ej: info@prestador.com.ar" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
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

            <!-- Especialidades Médicas -->
            <div class="border-b border-secondary-200 pb-6">
                <h3 class="text-lg font-medium text-secondary-900 mb-4">Especialidades Médicas</h3>
                <div class="space-y-4">
                    <div class="space-y-1">
                        <label for="especialidades" class="block text-sm font-medium text-secondary-700">
                            Especialidades <span class="text-danger-500">*</span>
                        </label>
                        <textarea wire:model="especialidades" id="especialidades" rows="4" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Ej: Cardiología, Neurología, Pediatría, Traumatología" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>></textarea>
                        <p class="text-xs text-secondary-500">Separe las especialidades con comas. Ej: Cardiología, Neurología, Pediatría</p>
                        <?php $__errorArgs = ['especialidades'];
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

            <!-- Estado -->
            <div class="space-y-4">
                <h3 class="text-lg font-medium text-secondary-900">Estado</h3>
                <div class="flex items-center">
                    <div class="flex items-center h-5">
                        <input wire:model="activo" type="checkbox" id="activo" class="w-4 h-4 text-primary-600 bg-white border-secondary-300 rounded focus:ring-primary-500 focus:ring-2" <?php echo e($modo == 'show' ? 'disabled' : ''); ?>>
                    </div>
                    <div class="ml-3">
                        <label for="activo" class="text-sm font-medium text-secondary-700">
                            Prestador Activo
                        </label>
                        <p class="text-xs text-secondary-500">Indica si el prestador se encuentra disponible para derivaciones</p>
                    </div>
                </div>
                <?php $__errorArgs = ['activo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Botones de Acción -->
            <div class="flex items-center justify-between pt-6 border-t border-secondary-200">
                <a href="<?php echo e(route('prestadores.index')); ?>" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver al Listado
                </a>
                <?php if($modo != 'show'): ?>
                <button type="submit" class="inline-flex items-center px-6 py-2 bg-primary-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <?php echo e($modo == 'create' ? 'Crear Prestador' : 'Actualizar Prestador'); ?>

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
            console.log('Mensaje mostrado - modo edición');
        });

        Livewire.on('mostrar-mensaje-y-redirigir', () => {
            console.log('Mensaje mostrado - modo creación');
            setTimeout(() => {
                window.Livewire.find('<?php echo e($_instance->getId()); ?>').call('redirigirAlListado');
            }, 3000);
        });
    });
</script>
<?php $__env->stopPush(); ?><?php /**PATH C:\Users\rican\OneDrive\Documentos\workana\Fondo Solidario\resources\views\livewire\prestadores\form.blade.php ENDPATH**/ ?>