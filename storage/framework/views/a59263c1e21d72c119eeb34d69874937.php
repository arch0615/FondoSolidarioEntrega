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
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
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

    <div class="mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <nav class="flex items-center text-sm text-secondary-500 mb-4">
                <a href="<?php echo e(route('pasantias.index')); ?>" class="hover:text-secondary-700">Pasantías / Prácticas Profesionales</a>
                <svg class="mx-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-secondary-900"><?php echo e($modo == 'create' ? 'Nueva Pasantía / Práctica Profesional' : ($modo == 'edit' ? 'Editar Pasantía / Práctica Profesional' : 'Detalles de Pasantía / Práctica Profesional')); ?></span>
            </nav>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-secondary-900">
                        <?php echo e($modo == 'create' ? 'Nueva Pasantía / Práctica Profesional' : ($modo == 'edit' ? 'Editar Pasantía / Práctica Profesional' : 'Detalles de Pasantía / Práctica Profesional')); ?>

                    </h1>
                    <p class="mt-1 text-sm text-secondary-600">
                        <?php echo e($modo == 'create' ? 'Complete los datos para registrar una nueva pasantía o práctica profesional' : ($modo == 'edit' ? 'Modifique los datos de la pasantía o práctica profesional' : 'Información detallada de la pasantía o práctica profesional')); ?>

                    </p>
                </div>
                <?php if($modo == 'show'): ?>
                <div class="flex space-x-3">
                    <a href="<?php echo e(route('pasantias.edit', $pasantia_id)); ?>" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
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

                <!-- Información de la Pasantía / Práctica Profesional -->
                <div class="border-b border-secondary-200 pb-6">
                    <h3 class="text-lg font-medium text-secondary-900 mb-4">Información de la Pasantía / Práctica Profesional</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Escuela -->
                        <div class="space-y-1">
                            <label for="id_escuela" class="block text-sm font-medium text-secondary-700">Escuela <span class="text-danger-500">*</span></label>
                            <select wire:model.live="id_escuela" id="id_escuela" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e(($modo == 'show' || $esUsuarioGeneral) ? 'bg-secondary-50' : 'bg-white'); ?>" <?php echo e(($modo == 'show' || $esUsuarioGeneral) ? 'disabled' : ''); ?>>
                                <option value="">Seleccione una escuela</option>
                                <?php $__currentLoopData = $escuelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $escuela): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($escuela->id_escuela); ?>"><?php echo e($escuela->nombre); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['id_escuela'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Alumno -->
                        <div class="space-y-1">
                            <label for="id_alumno" class="block text-sm font-medium text-secondary-700">Alumno <span class="text-danger-500">*</span></label>
                            <select wire:model="id_alumno" id="id_alumno" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" <?php echo e($modo == 'show' ? 'disabled' : ''); ?>>
                                <option value=""><?php echo e($id_escuela ? 'Seleccione un alumno' : 'Primero seleccione una escuela'); ?></option>
                                <?php $__currentLoopData = $alumnos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alumno): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($alumno->id_alumno); ?>"><?php echo e($alumno->apellido); ?>, <?php echo e($alumno->nombre); ?> <?php if($alumno->numero_documento): ?>(DNI: <?php echo e($alumno->numero_documento); ?>)<?php endif; ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['id_alumno'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Empresa -->
                        <div class="md:col-span-2 space-y-1">
                            <label for="empresa" class="block text-sm font-medium text-secondary-700">Empresa <span class="text-danger-500">*</span></label>
                            <input wire:model="empresa" type="text" id="empresa" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Ej: Tech Solutions S.A." <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
                            <?php $__errorArgs = ['empresa'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Dirección Empresa -->
                        <div class="md:col-span-2 space-y-1">
                            <label for="direccion_empresa" class="block text-sm font-medium text-secondary-700">Dirección de la Empresa</label>
                            <input wire:model="direccion_empresa" type="text" id="direccion_empresa" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Ej: Av. Principal 456, Córdoba" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
                            <?php $__errorArgs = ['direccion_empresa'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Tutor en Empresa -->
                        <div class="space-y-1">
                            <label for="tutor_empresa" class="block text-sm font-medium text-secondary-700">Tutor en Empresa</label>
                            <input wire:model="tutor_empresa" type="text" id="tutor_empresa" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Ej: Ing. Ricardo López" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
                            <?php $__errorArgs = ['tutor_empresa'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Fecha de Inicio -->
                        <div class="space-y-1">
                            <label for="fecha_inicio" class="block text-sm font-medium text-secondary-700">Fecha de Inicio <span class="text-danger-500">*</span></label>
                            <input wire:model="fecha_inicio" type="date" id="fecha_inicio" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
                            <?php $__errorArgs = ['fecha_inicio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Fecha de Fin -->
                        <div class="space-y-1">
                            <label for="fecha_fin" class="block text-sm font-medium text-secondary-700">Fecha de Fin</label>
                            <input wire:model="fecha_fin" type="date" id="fecha_fin" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
                            <?php $__errorArgs = ['fecha_fin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Horario -->
                        <div class="space-y-1">
                            <label for="horario" class="block text-sm font-medium text-secondary-700">Horario</label>
                            <input wire:model="horario" type="text" id="horario" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Ej: Lunes a Viernes de 9:00 a 13:00" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
                            <?php $__errorArgs = ['horario'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Descripción de Tareas -->
                        <div class="md:col-span-2 space-y-1">
                            <label for="descripcion_tareas" class="block text-sm font-medium text-secondary-700">Descripción de Tareas</label>
                            <textarea wire:model="descripcion_tareas" id="descripcion_tareas" rows="4" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Describa las tareas que realizará el pasante" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>></textarea>
                            <?php $__errorArgs = ['descripcion_tareas'];
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

                <!-- Botones de Acción -->
                <div class="flex items-center justify-between pt-6 border-t border-secondary-200">
                    <a href="<?php echo e(route('pasantias.index')); ?>" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Volver al Listado
                    </a>
                    <?php if($modo != 'show'): ?>
                    <button type="submit" class="inline-flex items-center px-6 py-2 bg-primary-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <?php echo e($modo == 'create' ? 'Crear Pasantía / Práctica Profesional' : 'Actualizar Pasantía / Práctica Profesional'); ?>

                    </button>
                    <?php endif; ?>
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
            }, 3000);
        });
    });
</script>
<?php $__env->stopPush(); ?><?php /**PATH C:\Users\rican\OneDrive\Documentos\workana\Fondo Solidario\resources\views\livewire\pasantias\form.blade.php ENDPATH**/ ?>