<div>
    <!-- Modal de confirmación -->
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
                <a href="<?php echo e(route('accidentes.index')); ?>" class="hover:text-secondary-700">Accidentes</a>
                <svg class="mx-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-secondary-900"><?php echo e($modo == 'create' ? 'Nuevo Accidente' : ($modo == 'edit' ? 'Editar Accidente' : 'Detalles de Accidente')); ?></span>
            </nav>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-secondary-900">
                        <?php echo e($modo == 'create' ? 'Nuevo Accidente' : ($modo == 'edit' ? 'Editar Accidente' : 'Detalles de Accidente')); ?>

                    </h1>
                    <p class="mt-1 text-sm text-secondary-600">
                        <?php echo e($modo == 'create' ? 'Complete los datos para registrar un nuevo accidente' : ($modo == 'edit' ? 'Modifique los datos del accidente' : 'Información detallada del accidente')); ?>

                    </p>
                </div>
                <!--[if BLOCK]><![endif]--><?php if($modo == 'show'): ?>
                <div class="flex space-x-3">
                    <a href="<?php echo e(route('accidentes.edit', $accidente_id ?? 1)); ?>" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
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
                <!-- Selección de Escuela -->
                <div class="border-b border-secondary-200 pb-6">
                    <h3 class="text-lg font-medium text-secondary-900 mb-4">Información de la Escuela</h3>
                    <div class="space-y-1">
                        <label for="id_escuela" class="block text-sm font-medium text-secondary-700">
                            Escuela <span class="text-danger-500">*</span>
                        </label>
                        <select wire:model="id_escuela" id="id_escuela" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' || $es_usuario_general ? 'bg-secondary-50' : 'bg-white'); ?>" <?php echo e($modo == 'show' || $es_usuario_general ? 'disabled' : ''); ?> required>
                            <option value="">Seleccione una escuela</option>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $escuelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $escuela): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($escuela->id_escuela); ?>"><?php echo e($escuela->nombre); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </select>
                        <!--[if BLOCK]><![endif]--><?php if($es_usuario_general): ?>
                            <p class="text-xs text-secondary-500 mt-1">La escuela se asigna automáticamente según su usuario</p>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['id_escuela'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                            <span class="text-red-500 text-sm"><?php echo e($message); ?></span> 
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>

                <!-- Información de los Alumnos -->
                <div class="border-b border-secondary-200 pb-6">
                    <h3 class="text-lg font-medium text-secondary-900 mb-4">Alumnos Involucrados</h3>
                    
                    <!-- Campo de búsqueda con autocompletado -->
                    <div class="mb-4">
                        <label for="buscar_alumno" class="block text-sm font-medium text-secondary-700 mb-2">
                            Buscar y Agregar Alumnos <span class="text-danger-500">*</span>
                        </label>
                        <div class="flex gap-2">
                            <div class="flex-1 relative">
                                <input wire:model.live="buscar_alumno" type="text" id="buscar_alumno" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Escriba el nombre del alumno..." <?php echo e($modo == 'show' ? 'readonly' : ''); ?> autocomplete="off">
                                
                                <!-- Dropdown de sugerencias -->
                                <?php if(strlen($buscar_alumno) >= 2 && $id_escuela): ?>
                                    <?php $sugerencias = $this->buscarAlumnos(); ?>
                                    <!--[if BLOCK]><![endif]--><?php if($sugerencias->count() > 0): ?>
                                    <div class="absolute z-10 mt-1 w-full bg-white border border-secondary-300 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $sugerencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alumno): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div wire:click="agregarAlumno(<?php echo e($alumno->id_alumno); ?>)" class="p-2 hover:bg-secondary-50 cursor-pointer border-b border-secondary-100">
                                            <div class="font-medium text-secondary-900"><?php echo e($alumno->nombre_completo); ?></div>
                                            <div class="text-sm text-secondary-600"><?php echo e($alumno->sala_grado_curso); ?> - DNI: <?php echo e($alumno->dni); ?></div>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <!-- Botón para agregar nuevo alumno -->
                            <button wire:click="abrirModalAlumno" type="button" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 <?php echo e($modo == 'show' || !$id_escuela ? 'opacity-50 cursor-not-allowed' : ''); ?>" <?php echo e($modo == 'show' || !$id_escuela ? 'disabled' : ''); ?>>
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Nuevo Alumno
                            </button>
                        </div>
                        <p class="text-xs text-secondary-500 mt-1">Escriba para buscar o haga clic en "Nuevo Alumno" para agregar uno nuevo</p>
                    </div>

                    <!-- Lista de alumnos seleccionados -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-secondary-700 mb-2">Alumnos Seleccionados:</label>
                        <div class="min-h-[60px] border border-secondary-200 rounded-lg p-3 bg-secondary-50">
                            <!--[if BLOCK]><![endif]--><?php if(empty($alumnos_seleccionados)): ?>
                                <p class="text-sm text-secondary-500 italic">No hay alumnos seleccionados</p>
                            <?php else: ?>
                                <?php $alumnosDetalle = $this->getAlumnosSeleccionadosDetalle(); ?>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $alumnosDetalle; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alumno): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex items-center justify-between bg-white border border-secondary-200 rounded-lg p-3 mb-2">
                                    <div class="flex-1">
                                        <div class="font-medium text-secondary-900"><?php echo e($alumno->nombre_completo); ?></div>
                                        <div class="text-sm text-secondary-600"><?php echo e($alumno->sala_grado_curso); ?> - DNI: <?php echo e($alumno->dni); ?></div>
                                    </div>
                                    <!--[if BLOCK]><![endif]--><?php if($modo != 'show'): ?>
                                    <button wire:click="removerAlumno(<?php echo e($alumno->id_alumno); ?>)" type="button" class="text-red-600 hover:text-red-800 p-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['alumnos_seleccionados'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                            <span class="text-red-500 text-sm"><?php echo e($message); ?></span> 
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>

                <!-- Detalles del Accidente -->
                <div class="border-b border-secondary-200 pb-6">
                    <h3 class="text-lg font-medium text-secondary-900 mb-4">Detalles del Accidente</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Fecha del Accidente -->
                        <div class="space-y-1">
                            <label for="fecha_accidente" class="block text-sm font-medium text-secondary-700">
                                Fecha del Accidente <span class="text-danger-500">*</span>
                            </label>
                            <input wire:model="fecha_accidente" type="date" id="fecha_accidente" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" <?php echo e($modo == 'show' ? 'readonly' : ''); ?> required>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['fecha_accidente'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                <span class="text-red-500 text-sm"><?php echo e($message); ?></span> 
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Hora del Accidente -->
                        <div class="space-y-1">
                            <label for="hora_accidente" class="block text-sm font-medium text-secondary-700">
                                Hora del Accidente <span class="text-danger-500">*</span>
                            </label>
                            <input wire:model="hora_accidente" type="time" id="hora_accidente" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" <?php echo e($modo == 'show' ? 'readonly' : ''); ?> required>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['hora_accidente'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                <span class="text-red-500 text-sm"><?php echo e($message); ?></span> 
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Lugar del Accidente -->
                        <div class="md:col-span-2 space-y-1">
                            <label for="lugar_accidente" class="block text-sm font-medium text-secondary-700">
                                Lugar del Accidente <span class="text-danger-500">*</span>
                            </label>
                            <input wire:model="lugar_accidente" type="text" id="lugar_accidente" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Ej: Patio de recreo, Aula 5B, Escaleras principales" <?php echo e($modo == 'show' ? 'readonly' : ''); ?> required>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['lugar_accidente'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                <span class="text-red-500 text-sm"><?php echo e($message); ?></span> 
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Descripción del Accidente -->
                        <div class="md:col-span-2 space-y-1">
                            <label for="descripcion_accidente" class="block text-sm font-medium text-secondary-700">
                                Descripción del Accidente <span class="text-danger-500">*</span>
                            </label>
                            <textarea wire:model="descripcion_accidente" id="descripcion_accidente" rows="4" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Describa detalladamente cómo ocurrió el accidente..." <?php echo e($modo == 'show' ? 'readonly' : ''); ?> required></textarea>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['descripcion_accidente'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                <span class="text-red-500 text-sm"><?php echo e($message); ?></span> 
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Tipo de Lesión -->
                        <div class="md:col-span-2 space-y-1">
                            <label for="tipo_lesion" class="block text-sm font-medium text-secondary-700">
                                Tipo de Lesión <span class="text-danger-500">*</span>
                            </label>
                            <input wire:model="tipo_lesion" type="text" id="tipo_lesion" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Ej: Fractura, Contusión, Corte, Esguince" <?php echo e($modo == 'show' ? 'readonly' : ''); ?> required>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['tipo_lesion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                <span class="text-red-500 text-sm"><?php echo e($message); ?></span> 
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                </div>

                <!-- Protocolo de Emergencias -->
                <div class="border-b border-secondary-200 pb-6">
                    <h3 class="text-lg font-medium text-secondary-900 mb-4">Protocolo de Emergencias</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Protocolo Activado -->
                        <div class="md:col-span-2 flex items-center">
                            <div class="flex items-center h-5">
                                <input wire:model="protocolo_activado" type="checkbox" id="protocolo_activado" class="w-4 h-4 text-red-600 bg-white border-secondary-300 rounded focus:ring-red-500 focus:ring-2" <?php echo e($modo == 'show' ? 'disabled' : ''); ?>>
                            </div>
                            <div class="ml-3">
                                <label for="protocolo_activado" class="text-sm font-medium text-secondary-700">
                                    Se activó el Protocolo de Emergencias
                                </label>
                                <p class="text-xs text-secondary-500">Marcar si se llamó al Sistema de Emergencias y Urgencias médicas</p>
                            </div>
                        </div>

                        <!-- Llamada a Emergencia -->
                        <div class="flex items-center">
                            <div class="flex items-center h-5">
                                <input wire:model="llamada_emergencia" type="checkbox" id="llamada_emergencia" class="w-4 h-4 text-red-600 bg-white border-secondary-300 rounded focus:ring-red-500 focus:ring-2" <?php echo e($modo == 'show' ? 'disabled' : ''); ?>>
                            </div>
                            <div class="ml-3">
                                <label for="llamada_emergencia" class="text-sm font-medium text-secondary-700">
                                    Se realizó llamada de emergencia
                                </label>
                            </div>
                        </div>

                        <!-- Hora de Llamada -->
                        <div class="space-y-1">
                            <label for="hora_llamada" class="block text-sm font-medium text-secondary-700">Hora de Llamada</label>
                            <input wire:model="hora_llamada" type="time" id="hora_llamada" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['hora_llamada'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                <span class="text-red-500 text-sm"><?php echo e($message); ?></span> 
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Servicio de Emergencia -->
                        <div class="md:col-span-2 space-y-1">
                            <label for="servicio_emergencia" class="block text-sm font-medium text-secondary-700">Servicio de Emergencia Contactado</label>
                            <input wire:model="servicio_emergencia" type="text" id="servicio_emergencia" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>" placeholder="Ej: SAME, Cruz Roja, Emergencias Médicas FS" <?php echo e($modo == 'show' ? 'readonly' : ''); ?>>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['servicio_emergencia'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                <span class="text-red-500 text-sm"><?php echo e($message); ?></span> 
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                </div>

                <!-- Estado y Configuración -->
                <!--[if BLOCK]><![endif]--><?php if($modo != 'create'): ?>
                <div class="border-b border-secondary-200 pb-6">
                    <h3 class="text-lg font-medium text-secondary-900 mb-4">Estado del Expediente</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Estado -->
                        <div class="space-y-1">
                            <label for="id_estado_accidente" class="block text-sm font-medium text-secondary-700">Estado</label>
                            <select wire:model="id_estado_accidente" id="id_estado_accidente" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' || $es_usuario_general ? 'bg-secondary-50' : 'bg-white'); ?>" <?php echo e($modo == 'show' || $es_usuario_general ? 'disabled' : ''); ?>>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $estados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($estado->id_estado_accidente); ?>"><?php echo e($estado->nombre_estado); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </select>
                            <!--[if BLOCK]><![endif]--><?php if($es_usuario_general): ?>
                                <p class="text-xs text-secondary-500 mt-1">Solo los administradores pueden modificar el estado del expediente</p>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['id_estado_accidente'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-red-500 text-sm"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <!-- Documentos Adjuntos -->
                <div class="border-b border-secondary-200 pb-6">
                    <h3 class="text-lg font-medium text-secondary-900 mb-4">Documentos Adjuntos</h3>
                    
                    <!-- Información explicativa -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h4 class="text-sm font-medium text-blue-800 mb-1">Subida de Documentos</h4>
                                <p class="text-sm text-blue-700">
                                    Puede adjuntar múltiples documentos relacionados con el accidente (fotos, informes médicos, facturas, etc.).
                                    Formatos permitidos: PDF, JPG, JPEG, PNG. Tamaño máximo por archivo: 10MB.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Subida de archivos -->
                    <!--[if BLOCK]><![endif]--><?php if($modo != 'show'): ?>
                    <div class="mb-6"
                         x-data="{ isUploading: false, progress: 0 }"
                         x-on:livewire-upload-start="isUploading = true"
                         x-on:livewire-upload-finish="isUploading = false"
                         x-on:livewire-upload-error="isUploading = false"
                         x-on:livewire-upload-progress="progress = $event.detail.progress">
                        <label class="block text-sm font-medium text-secondary-700 mb-2">
                            Seleccionar Archivos
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-secondary-300 border-dashed rounded-lg hover:border-secondary-400 transition-colors duration-200"
                             @dragover.prevent @dragenter.prevent @drop.prevent="$wire.uploadMultiple('archivos_adjuntos', $event.dataTransfer.files)">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-secondary-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-secondary-600">
                                    <label for="archivos_adjuntos" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                        <span>Subir archivos</span>
                                        <input wire:model="archivos_adjuntos" id="archivos_adjuntos" name="archivos_adjuntos" type="file" class="sr-only" multiple>
                                    </label>
                                    <p class="pl-1">o arrastrar y soltar</p>
                                </div>
                                <p class="text-xs text-secondary-500">
                                    PDF, JPG, JPEG, PNG hasta 10MB cada uno
                                </p>
                            </div>
                        </div>
                        <!-- Progress Bar -->
                        <div x-show="isUploading">
                            <progress max="100" x-bind:value="progress" class="w-full"></progress>
                        </div>
                    </div>

                    <!-- Campo para descripción general de archivos - OCULTO -->
                    <div class="mb-4" style="display: none;">
                        <label for="archivos_descripcion" class="block text-sm font-medium text-secondary-700 mb-2">
                            Descripción de los Documentos (Opcional)
                        </label>
                        <textarea wire:model.live="archivos_descripcion" id="archivos_descripcion" rows="2" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Breve descripción de los documentos adjuntos..."></textarea>
                    </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <!-- Lista de archivos seleccionados/existentes -->
                    <div id="lista_archivos_container">
                        <label class="block text-sm font-medium text-secondary-700 mb-2">
                            <?php echo e($modo == 'show' ? 'Documentos del Accidente:' : 'Archivos Seleccionados:'); ?>

                        </label>
                        <div class="space-y-2">
                            <!--[if BLOCK]><![endif]--><?php if(count($archivos_existentes) > 0): ?>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $archivos_existentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $archivo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex items-center justify-between bg-white border border-secondary-200 rounded-lg p-3 mb-2">
                                        <div class="flex items-center flex-1">
                                            <div class="flex-shrink-0 mr-3">
                                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <a href="<?php echo e(Storage::url($archivo->ruta_archivo)); ?>" target="_blank" class="font-medium text-secondary-900 truncate hover:text-primary-600 transition-colors duration-200">
                                                    <?php echo e($archivo->nombre_archivo); ?>

                                                </a>
                                                <div class="text-sm text-secondary-600">
                                                    <?php echo e(round($archivo->tamano / 1024, 2)); ?> KB
                                                    <!--[if BLOCK]><![endif]--><?php if($archivo->descripcion): ?>
                                                        • <?php echo e($archivo->descripcion); ?>

                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </div>
                                            </div>
                                        </div>
                                        <!--[if BLOCK]><![endif]--><?php if($modo != 'show'): ?>
                                        <button wire:click.prevent="eliminarArchivoExistente(<?php echo e($archivo->id_archivo); ?>)" type="button" class="text-red-600 hover:text-red-800 p-1 ml-2 transition-colors duration-200" title="Eliminar archivo">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                            <!--[if BLOCK]><![endif]--><?php if(count($archivos_adjuntos) > 0): ?>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $archivos_adjuntos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $archivo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex items-center justify-between bg-white border border-secondary-200 rounded-lg p-3 mb-2">
                                        <div class="flex items-center flex-1">
                                            <div class="flex-1 min-w-0">
                                                <div class="font-medium text-secondary-900 truncate"><?php echo e($archivo->getClientOriginalName()); ?></div>
                                                <div class="text-sm text-secondary-600"><?php echo e(round($archivo->getSize() / 1024, 2)); ?> KB</div>
                                            </div>
                                        </div>
                                        <button wire:click.prevent="removeUpload('archivos_adjuntos', '<?php echo e($archivo->getFilename()); ?>')" type="button" class="text-red-600 hover:text-red-800 p-1">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                            <?php if(count($archivos_existentes) == 0 && count($archivos_adjuntos) == 0): ?>
                                <div class="text-center py-8 border-2 border-dashed border-secondary-200 rounded-lg">
                                    <svg class="mx-auto h-8 w-8 text-secondary-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <p class="text-sm text-secondary-500"><?php echo e($modo == 'show' ? 'No hay documentos adjuntos' : 'No hay archivos seleccionados'); ?></p>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="flex items-center justify-between pt-6 border-t border-secondary-200">
                    <a href="<?php echo e(route('accidentes.index')); ?>" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Volver al Listado
                    </a>
                    <!--[if BLOCK]><![endif]--><?php if($modo != 'show'): ?>
                    <button type="submit" class="inline-flex items-center px-6 py-2 bg-red-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <?php echo e($modo == 'create' ? 'Registrar Accidente' : 'Actualizar Accidente'); ?>

                    </button>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para Nuevo Alumno -->
    <!--[if BLOCK]><![endif]--><?php if($mostrar_modal_alumno): ?>
    <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center p-6 border-b border-secondary-200">
                <h3 class="text-lg font-semibold text-secondary-900">Agregar Nuevo Alumno</h3>
                <button wire:click="cerrarModalAlumno" type="button" class="text-secondary-400 hover:text-secondary-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="p-6">
                <form wire:submit.prevent="guardarNuevoAlumno" class="space-y-6">
                    <!-- Información Personal del Alumno -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nombre -->
                        <div class="space-y-1">
                            <label for="nuevo_alumno_nombre" class="block text-sm font-medium text-secondary-700">
                                Nombre <span class="text-danger-500">*</span>
                            </label>
                            <input wire:model="nuevo_alumno.nombre" type="text" id="nuevo_alumno_nombre" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Ej: Ana" required>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['nuevo_alumno.nombre'];
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
                            <label for="nuevo_alumno_apellido" class="block text-sm font-medium text-secondary-700">
                                Apellido <span class="text-danger-500">*</span>
                            </label>
                            <input wire:model="nuevo_alumno.apellido" type="text" id="nuevo_alumno_apellido" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Ej: Martínez" required>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['nuevo_alumno.apellido'];
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
                            <label for="nuevo_alumno_dni" class="block text-sm font-medium text-secondary-700">
                                DNI <span class="text-danger-500">*</span>
                            </label>
                            <input wire:model="nuevo_alumno.dni" type="text" id="nuevo_alumno_dni" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Ej: 45678912" required>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['nuevo_alumno.dni'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- CUIL -->
                        <div class="space-y-1">
                            <label for="nuevo_alumno_cuil" class="block text-sm font-medium text-secondary-700">
                                CUIL <span class="text-danger-500">*</span>
                            </label>
                            <input wire:model="nuevo_alumno.cuil" type="text" id="nuevo_alumno_cuil" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Ej: 23-45678912-4" required>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['nuevo_alumno.cuil'];
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
                            <label for="nuevo_alumno_fecha_nacimiento" class="block text-sm font-medium text-secondary-700">
                                Fecha de Nacimiento <span class="text-danger-500">*</span>
                            </label>
                            <input wire:model="nuevo_alumno.fecha_nacimiento" type="date" id="nuevo_alumno_fecha_nacimiento" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['nuevo_alumno.fecha_nacimiento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Sala/Grado/Curso -->
                        <div class="space-y-1">
                            <label for="nuevo_alumno_sala_grado_curso" class="block text-sm font-medium text-secondary-700">
                                Sala/Grado/Curso <span class="text-danger-500">*</span>
                            </label>
                            <input wire:model="nuevo_alumno.sala_grado_curso" type="text" id="nuevo_alumno_sala_grado_curso" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Ej: 7° Grado, 3° Año, Sala de 5" required>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['nuevo_alumno.sala_grado_curso'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Nombre del Padre/Madre -->
                        <div class="space-y-1">
                            <label for="nuevo_alumno_nombre_padre_madre" class="block text-sm font-medium text-secondary-700">
                                Nombre del Padre/Madre <span class="text-danger-500">*</span>
                            </label>
                            <input wire:model="nuevo_alumno.nombre_padre_madre" type="text" id="nuevo_alumno_nombre_padre_madre" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Ej: Carlos Martínez" required>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['nuevo_alumno.nombre_padre_madre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Teléfono de Contacto -->
                        <div class="space-y-1">
                            <label for="nuevo_alumno_telefono_contacto" class="block text-sm font-medium text-secondary-700">
                                Teléfono de Contacto <span class="text-danger-500">*</span>
                            </label>
                            <input wire:model="nuevo_alumno.telefono_contacto" type="tel" id="nuevo_alumno_telefono_contacto" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Ej: (351) 555-1234" required>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['nuevo_alumno.telefono_contacto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>

                    <!-- Botones del Modal -->
                    <div class="flex justify-end space-x-3 pt-6 border-t border-secondary-200">
                        <button wire:click="cerrarModalAlumno" type="button" class="px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                            Cancelar
                        </button>
                        <button type="submit" class="px-6 py-2 bg-primary-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                            Agregar Alumno
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

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

            // Variables para manejar archivos seleccionados
            let archivosSeleccionados = [];

            // Funcionalidad de archivos mejorada
            const inputArchivos = document.getElementById('archivos_accidente');
            const listaArchivos = document.getElementById('lista_archivos');

            if (inputArchivos) {
                inputArchivos.addEventListener('change', function(e) {
                    const nuevosArchivos = Array.from(e.target.files);
                    if (nuevosArchivos.length > 0) {
                        // Agregar nuevos archivos a los existentes en lugar de reemplazar
                        archivosSeleccionados = [...archivosSeleccionados, ...nuevosArchivos];
                        mostrarArchivos();
                    }
                });
            }

            function mostrarArchivos() {
                if (!listaArchivos) return;

                if (archivosSeleccionados.length === 0) {
                    listaArchivos.innerHTML = `
                        <div class="text-center py-8 border-2 border-dashed border-secondary-200 rounded-lg">
                            <svg class="mx-auto h-8 w-8 text-secondary-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-sm text-secondary-500">No hay archivos seleccionados</p>
                        </div>
                    `;
                    return;
                }

                listaArchivos.innerHTML = '';
                archivosSeleccionados.forEach((archivo, index) => {
                    const div = document.createElement('div');
                    div.className = 'flex items-center justify-between bg-white border border-secondary-200 rounded-lg p-3 mb-2';
                    div.innerHTML = `
                        <div class="flex items-center flex-1">
                            <div class="flex-1 min-w-0">
                                <div class="font-medium text-secondary-900 truncate">${archivo.name}</div>
                                <div class="text-sm text-secondary-600">${formatBytes(archivo.size)} • Seleccionado para subir</div>
                            </div>
                        </div>
                        <button type="button" class="text-red-600 hover:text-red-800 p-1 eliminar-archivo" data-index="${index}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    `;
                    listaArchivos.appendChild(div);
                });

                // Agregar eventos para eliminar archivos
                document.querySelectorAll('.eliminar-archivo').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const index = parseInt(this.dataset.index);
                        archivosSeleccionados.splice(index, 1);
                        mostrarArchivos();
                    });
                });
            }

            function formatBytes(bytes, decimals = 2) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const dm = decimals < 0 ? 0 : decimals;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
            }

            // Inicializar vista de archivos
            mostrarArchivos();
        });
    </script>
    <?php $__env->stopPush(); ?>
</div><?php /**PATH C:\Users\rican\OneDrive\Documentos\workana\Fondo Solidario\resources\views/livewire/accidentes/form.blade.php ENDPATH**/ ?>