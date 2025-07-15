<div>
    <!-- Modal de Confirmación -->
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
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-6">
                    <button @click="show = false" wire:click="limpiarMensaje" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 hover:bg-green-700 text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:text-sm">
                        Aceptar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <nav class="flex items-center text-sm text-secondary-500 mb-4">
                <a href="<?php echo e(route('derivaciones.index')); ?>" class="hover:text-secondary-700">Derivaciones</a>
                <svg class="mx-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7-7"></path>
                </svg>
                <span class="text-secondary-900"><?php echo e($modo == 'create' ? 'Nueva Derivación' : ($modo == 'edit' ? 'Editar Derivación' : 'Detalles de Derivación')); ?></span>
            </nav>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-secondary-900">
                        <?php echo e($modo == 'create' ? 'Nueva Derivación' : ($modo == 'edit' ? 'Editar Derivación' : 'Detalles de Derivación')); ?>

                    </h1>
                    <p class="mt-1 text-sm text-secondary-600">
                        <?php echo e($modo == 'create' ? 'Complete los datos para registrar una nueva derivación médica.' : ($modo == 'edit' ? 'Modifique los datos de la derivación médica.' : 'Información detallada de la derivación médica.')); ?>

                    </p>
                </div>
                <?php if($modo == 'show'): ?>
                <div class="flex space-x-3">
                    <a href="<?php echo e(route('derivaciones.edit', $derivacion_id)); ?>" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Editar
                    </a>
                     <button type="button" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                        <i class="fas fa-print mr-2"></i>
                        Imprimir Derivación
                    </button>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Formulario -->
        <div class="bg-white rounded-xl border border-secondary-200">
            <form wire:submit.prevent="guardar" class="space-y-6 p-6">
                <?php echo csrf_field(); ?>
                
                <!-- Información de la Derivación -->
                <div class="border-b border-secondary-200 pb-6">
                    <h3 class="text-lg font-medium text-secondary-900 mb-4">Información de la Derivación</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- ID Accidente (Relacionado) -->
                        <div class="space-y-1">
                            <label for="id_accidente" class="block text-sm font-medium text-secondary-700">
                                Accidente Relacionado <span class="text-danger-500">*</span>
                            </label>
                            <select
                                wire:model.live="id_accidente"
                                id="id_accidente"
                                class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                                <?php echo e($modo == 'show' ? 'disabled' : ''); ?>

                            >
                                <option value="">Seleccione un accidente</option>
                                <?php $__currentLoopData = $accidentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accidente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($accidente->id_accidente); ?>">
                                        ACC-<?php echo e(str_pad($accidente->id_accidente, 3, '0', STR_PAD_LEFT)); ?> (<?php echo e($accidente->fecha_accidente->format('d/m/Y')); ?> - <?php echo e(\Carbon\Carbon::parse($accidente->hora_accidente)->format('h:i A')); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['id_accidente'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Alumno Involucrado -->
                        <?php if(count($alumnosDelAccidente) > 0): ?>
                        <div class="space-y-1">
                            <label for="id_alumno" class="block text-sm font-medium text-secondary-700">
                                Alumno Involucrado <span class="text-danger-500">*</span>
                            </label>
                            <select
                                wire:model="id_alumno"
                                id="id_alumno"
                                class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                                <?php echo e($modo == 'show' ? 'disabled' : ''); ?>

                            >
                                <option value="">Seleccione un alumno</option>
                                <?php $__currentLoopData = $alumnosDelAccidente; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accidenteAlumno): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($accidenteAlumno->alumno->id_alumno); ?>">
                                        <?php echo e($accidenteAlumno->alumno->nombre_completo); ?>

                                    </option>
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
                        <?php endif; ?>

                        <!-- Prestador Médico -->
                        <div class="space-y-1">
                            <label for="id_prestador" class="block text-sm font-medium text-secondary-700">
                                Prestador Médico <span class="text-danger-500">*</span>
                            </label>
                            <select
                                wire:model="id_prestador"
                                id="id_prestador"
                                class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                                <?php echo e($modo == 'show' ? 'disabled' : ''); ?>

                            >
                                <option value="">Seleccione un prestador</option>
                                <?php $__currentLoopData = $prestadores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prestador): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($prestador->id_prestador); ?>"><?php echo e($prestador->nombre); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['id_prestador'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Fecha de Derivación -->
                        <div class="space-y-1">
                            <label for="fecha_derivacion" class="block text-sm font-medium text-secondary-700">
                                Fecha de Derivación <span class="text-danger-500">*</span>
                            </label>
                            <input
                                wire:model="fecha_derivacion"
                                type="date"
                                id="fecha_derivacion"
                                class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                                <?php echo e($modo == 'show' ? 'readonly' : ''); ?>

                            >
                            <?php $__errorArgs = ['fecha_derivacion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Hora de Derivación -->
                        <div class="space-y-1">
                            <label for="hora_derivacion" class="block text-sm font-medium text-secondary-700">
                                Hora de Derivación <span class="text-danger-500">*</span>
                            </label>
                            <input
                                wire:model="hora_derivacion"
                                type="time"
                                id="hora_derivacion"
                                class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                                <?php echo e($modo == 'show' ? 'readonly' : ''); ?>

                            >
                            <?php $__errorArgs = ['hora_derivacion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Médico que Deriva -->
                        <div class="space-y-1">
                            <label for="medico_deriva" class="block text-sm font-medium text-secondary-700">
                                Médico que Deriva (Sistema de Emergencias)
                            </label>
                            <input
                                wire:model="medico_deriva"
                                type="text"
                                id="medico_deriva"
                                class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                                placeholder="Ej: Dr. Carlos Rodriguez (SEM)"
                                <?php echo e($modo == 'show' ? 'readonly' : ''); ?>

                            >
                             <p class="text-xs text-secondary-500">Nombre del profesional del servicio de emergencias que atendió en la escuela y sugiere la derivación.</p>
                             <?php $__errorArgs = ['medico_deriva'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Acompañante -->
                        <div class="space-y-1">
                            <label for="acompanante" class="block text-sm font-medium text-secondary-700">
                                Adulto Acompañante <span class="text-danger-500">*</span>
                            </label>
                            <input
                                wire:model="acompanante"
                                type="text"
                                id="acompanante"
                                class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                                placeholder="Ej: Laura Gómez (Madre) / Prof. Ana Díaz"
                                <?php echo e($modo == 'show' ? 'readonly' : ''); ?>

                            >
                            <p class="text-xs text-secondary-500">Nombre y rol/parentesco del adulto que acompaña al alumno al prestador.</p>
                            <?php $__errorArgs = ['acompanante'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Diagnóstico Inicial -->
                        <div class="md:col-span-2 space-y-1">
                            <label for="diagnostico_inicial" class="block text-sm font-medium text-secondary-700">
                                Diagnóstico Inicial (Presuntivo) <span class="text-danger-500">*</span>
                            </label>
                            <textarea
                                wire:model="diagnostico_inicial"
                                id="diagnostico_inicial"
                                rows="3"
                                class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                                placeholder="Ej: Posible esguince de tobillo derecho, traumatismo leve en muñeca."
                                <?php echo e($modo == 'show' ? 'readonly' : ''); ?>

                            ></textarea>
                            <p class="text-xs text-secondary-500">Descripción breve del motivo de la derivación según la evaluación inicial en la escuela.</p>
                            <?php $__errorArgs = ['diagnostico_inicial'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Observaciones Adicionales -->
                        <div class="md:col-span-2 space-y-1">
                            <label for="observaciones" class="block text-sm font-medium text-secondary-700">
                                Observaciones Adicionales
                            </label>
                            <textarea
                                wire:model="observaciones"
                                id="observaciones"
                                rows="3"
                                class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                                placeholder="Ej: Alumno refiere mareos. Se contactó a la familia."
                                <?php echo e($modo == 'show' ? 'readonly' : ''); ?>

                            ></textarea>
                            <?php $__errorArgs = ['observaciones'];
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

                <!-- Estado de Impresión -->
                 <?php if($modo == 'show' || $modo == 'edit'): ?>
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-secondary-900">Estado de Impresión</h3>
                    <div class="flex items-center">
                        <div class="flex items-center h-5">
                            <input
                                wire:model="impresa"
                                type="checkbox"
                                id="impresa"
                                class="w-4 h-4 text-primary-600 bg-white border-secondary-300 rounded focus:ring-primary-500 focus:ring-2"
                                <?php echo e($modo == 'show' ? 'disabled' : ''); ?>

                            >
                        </div>
                        <div class="ml-3">
                            <label for="impresa" class="text-sm font-medium text-secondary-700">
                                Derivación Impresa
                            </label>
                            <?php if($fecha_impresion): ?>
                            <p class="text-xs text-secondary-500">Fecha de impresión: <?php echo e(\Carbon\Carbon::parse($fecha_impresion)->format('d/m/Y h:i A')); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Botones de Acción -->
                <div class="flex items-center justify-between pt-6 border-t border-secondary-200">
                    <a href="<?php echo e(route('derivaciones.index')); ?>" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
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
                        <?php echo e($modo == 'create' ? 'Crear Derivación' : 'Actualizar Derivación'); ?>

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
            // El modal se muestra automáticamente cuando $mensaje tiene valor.
            // No se necesita lógica JS adicional para el modo de edición.
        });
    });
</script>
<?php $__env->stopPush(); ?><?php /**PATH C:\Users\rican\OneDrive\Documentos\workana\Fondo Solidario\resources\views\livewire\derivaciones\form.blade.php ENDPATH**/ ?>