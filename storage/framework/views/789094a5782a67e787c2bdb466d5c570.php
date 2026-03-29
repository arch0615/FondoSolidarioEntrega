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
        <!-- Header -->
        <div class="mb-8">
            <nav class="flex items-center text-sm text-secondary-500 mb-4">
                <a href="<?php echo e(route('alumnos.index')); ?>" class="hover:text-secondary-700">Alumnos</a>
                <svg class="mx-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-secondary-900"><?php echo e($modo == 'create' ? 'Nuevo Alumno' : ($modo == 'edit' ? 'Editar Alumno' : 'Detalles de Alumno')); ?></span>
            </nav>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-secondary-900">
                        <?php echo e($modo == 'create' ? 'Nuevo Alumno' : ($modo == 'edit' ? 'Editar Alumno' : 'Detalles de Alumno')); ?>

                    </h1>
                    <p class="mt-1 text-sm text-secondary-600">
                        <?php echo e($modo == 'create' ? 'Complete los datos para registrar un nuevo alumno' : ($modo == 'edit' ? 'Modifique los datos del alumno' : 'Información detallada del alumno')); ?>

                    </p>
                </div>
                <!--[if BLOCK]><![endif]--><?php if($modo == 'show'): ?>
                <div class="flex space-x-3">
                    <a href="<?php echo e(route('alumnos.edit', $alumno_id)); ?>" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
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
                <!-- Información Personal del Alumno -->
                <div class="border-b border-secondary-200 pb-6">
                    <h3 class="text-lg font-medium text-secondary-900 mb-4">Información Personal del Alumno</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nombre -->
                        <div class="space-y-1">
                            <label for="nombre" class="block text-sm font-medium text-secondary-700">
                                Nombre <span class="text-danger-500">*</span>
                            </label>
                            <input wire:model="nombre" type="text" id="nombre" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Ej: Ana" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Apellido -->
                        <div class="space-y-1">
                            <label for="apellido" class="block text-sm font-medium text-secondary-700">
                                Apellido <span class="text-danger-500">*</span>
                            </label>
                            <input wire:model="apellido" type="text" id="apellido" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Ej: Martínez" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['apellido'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- DNI -->
                        <div class="space-y-1">
                            <label for="dni" class="block text-sm font-medium text-secondary-700">
                                DNI <span class="text-danger-500">*</span>
                            </label>
                            <input wire:model="dni" type="text" id="dni" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Ej: 45678912" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['dni'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- CUIL -->
                        <div class="space-y-1" style="display: none;">
                            <label for="cuil" class="block text-sm font-medium text-secondary-700">CUIL</label>
                            <input wire:model="cuil" type="text" id="cuil" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Ej: 23-45678912-4" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['cuil'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Fecha de Nacimiento -->
                        <div class="space-y-1">
                            <label for="fecha_nacimiento" class="block text-sm font-medium text-secondary-700">
                                Fecha de Nacimiento <span class="text-danger-500">*</span>
                            </label>
                            <input wire:model="fecha_nacimiento" type="date" id="fecha_nacimiento" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['fecha_nacimiento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Escuela -->
                        <div class="space-y-1">
                            <label for="id_escuela" class="block text-sm font-medium text-secondary-700">
                                Escuela <span class="text-danger-500">*</span>
                            </label>
                            <select wire:model="id_escuela" id="id_escuela" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e(($modo == 'show' || auth()->user()->id_rol == 1) ? 'bg-secondary-50' : 'bg-white'); ?>" <?php echo e(($modo == 'show' || auth()->user()->id_rol == 1) ? 'disabled' : ''); ?>>
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
                    </div>
                </div>

                <!-- Información de Contacto Familiar -->
                <div class="border-b border-secondary-200 pb-6">
                    <h3 class="text-lg font-medium text-secondary-900 mb-4">Información de Contacto Familiar</h3>

                    <!-- Contacto Familiar 1 -->
                    <div class="mb-6">
                        <h4 class="text-md font-medium text-secondary-800 mb-3">Contacto Familiar 1</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Familiar 1 -->
                            <div class="space-y-1">
                                <label for="familiar1" class="block text-sm font-medium text-secondary-700">Nombre del Familiar</label>
                                <input wire:model="familiar1" type="text" id="familiar1" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Ej: Carlos Martínez" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['familiar1'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>

                            <!-- Parentesco 1 -->
                            <div class="space-y-1">
                                <label for="parentesco1" class="block text-sm font-medium text-secondary-700">Parentesco</label>
                                <input wire:model="parentesco1" type="text" id="parentesco1" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Ej: Padre" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['parentesco1'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>

                            <!-- Teléfono Contacto 1 -->
                            <div class="space-y-1">
                                <label for="telefono_contacto1" class="block text-sm font-medium text-secondary-700">Teléfono de Contacto</label>
                                <input wire:model="telefono_contacto1" type="tel" id="telefono_contacto1" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Ej: (351) 555-1234" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['telefono_contacto1'];
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

                    <!-- Contacto Familiar 2 -->
                    <div class="mb-6">
                        <h4 class="text-md font-medium text-secondary-800 mb-3">Contacto Familiar 2</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Familiar 2 -->
                            <div class="space-y-1">
                                <label for="familiar2" class="block text-sm font-medium text-secondary-700">Nombre del Familiar</label>
                                <input wire:model="familiar2" type="text" id="familiar2" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Ej: María González" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['familiar2'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>

                            <!-- Parentesco 2 -->
                            <div class="space-y-1">
                                <label for="parentesco2" class="block text-sm font-medium text-secondary-700">Parentesco</label>
                                <input wire:model="parentesco2" type="text" id="parentesco2" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Ej: Madre" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['parentesco2'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>

                            <!-- Teléfono Contacto 2 -->
                            <div class="space-y-1">
                                <label for="telefono_contacto2" class="block text-sm font-medium text-secondary-700">Teléfono de Contacto</label>
                                <input wire:model="telefono_contacto2" type="tel" id="telefono_contacto2" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Ej: (351) 555-5678" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['telefono_contacto2'];
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

                    <!-- Contacto Familiar 3 -->
                    <div class="mb-6">
                        <h4 class="text-md font-medium text-secondary-800 mb-3">Contacto Familiar 3</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Familiar 3 -->
                            <div class="space-y-1">
                                <label for="familiar3" class="block text-sm font-medium text-secondary-700">Nombre del Familiar</label>
                                <input wire:model="familiar3" type="text" id="familiar3" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Ej: Ana López" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['familiar3'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>

                            <!-- Parentesco 3 -->
                            <div class="space-y-1">
                                <label for="parentesco3" class="block text-sm font-medium text-secondary-700">Parentesco</label>
                                <input wire:model="parentesco3" type="text" id="parentesco3" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Ej: Tía" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['parentesco3'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>

                            <!-- Teléfono Contacto 3 -->
                            <div class="space-y-1">
                                <label for="telefono_contacto3" class="block text-sm font-medium text-secondary-700">Teléfono de Contacto</label>
                                <input wire:model="telefono_contacto3" type="tel" id="telefono_contacto3" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Ej: (351) 555-9012" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['telefono_contacto3'];
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
                </div>

                <!-- Información Adicional -->
                <div class="border-b border-secondary-200 pb-6">
                    <h3 class="text-lg font-medium text-secondary-900 mb-4">Información Adicional</h3>
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Obra Social -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-secondary-700 mb-2">¿Posee alguna obra social?</label>
                                <div class="flex space-x-6">
                                    <label class="inline-flex items-center">
                                        <input wire:model.live="posee_obra_social" type="radio" value="1" class="w-4 h-4 text-primary-600 bg-white border-secondary-300 focus:ring-primary-500 focus:ring-2" <?php echo e($modo == 'show' ? 'disabled' : ''); ?>>
                                        <span class="ml-2 text-sm text-secondary-700">Sí</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input wire:model.live="posee_obra_social" type="radio" value="0" class="w-4 h-4 text-primary-600 bg-white border-secondary-300 focus:ring-primary-500 focus:ring-2" <?php echo e($modo == 'show' ? 'disabled' : ''); ?>>
                                        <span class="ml-2 text-sm text-secondary-700">No</span>
                                    </label>
                                </div>
                            </div>

                            <!--[if BLOCK]><![endif]--><?php if($posee_obra_social): ?>
                            <div class="space-y-1">
                                <label for="obra_social" class="block text-sm font-medium text-secondary-700">Indicar cual</label>
                                <textarea wire:model="obra_social" id="obra_social" rows="3" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Indique cuál obra social posee" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>></textarea>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['obra_social'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Deportes -->
                        <div class="space-y-1">
                            <label for="deportes" class="block text-sm font-medium text-secondary-700">¿Practica algún deporte?</label>
                            <textarea wire:model="deportes" id="deportes" rows="3" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Describa los deportes que practica (opcional)" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>></textarea>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['deportes'];
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

                <!-- Estado -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-secondary-900">Estado</h3>
                    <div class="flex items-center">
                        <div class="flex items-center h-5">
                            <input wire:model="activo" type="checkbox" id="activo" class="w-4 h-4 text-primary-600 bg-white border-secondary-300 rounded focus:ring-primary-500 focus:ring-2" <?php echo e($modo == 'show' ? 'disabled' : ''); ?>>
                        </div>
                        <div class="ml-3">
                            <label for="activo" class="text-sm font-medium text-secondary-700">
                                Alumno Activo
                            </label>
                            <p class="text-xs text-secondary-500">Indica si el alumno se encuentra activo en la escuela</p>
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="flex items-center justify-between pt-6 border-t border-secondary-200">
                    <a href="<?php echo e(route('alumnos.index')); ?>" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Volver al Listado
                    </a>
                    <!--[if BLOCK]><![endif]--><?php if($modo != 'show'): ?>
                    <button type="submit" class="inline-flex items-center px-6 py-2 bg-primary-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                        <svg wire:loading wire:target="guardar" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span wire:loading.remove wire:target="guardar">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </span>
                        <?php echo e($modo == 'create' ? 'Crear Alumno' : 'Actualizar Alumno'); ?>

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
            // Evento para modo edición
        });

        Livewire.on('mostrar-mensaje-y-redirigir', () => {
            setTimeout(() => {
                window.Livewire.find('<?php echo e($_instance->getId()); ?>').call('redirigirAlListado');
            }, 3000);
        });
    });
</script>
<?php $__env->stopPush(); ?><?php /**PATH /home/ubuntu/Documents/FondoSolidarioEntrega/FondoSolidarioEntrega/resources/views/livewire/alumnos/form.blade.php ENDPATH**/ ?>