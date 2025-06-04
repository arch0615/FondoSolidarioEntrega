

<?php $__env->startSection('content'); ?>
<div class="mx-auto px-4">
    <!-- Header -->
    <div class="mb-8">
        <nav class="flex items-center text-sm text-secondary-500 mb-4">
            
            <a href="<?php echo e(route('salidas_educativas.index')); ?>" class="hover:text-secondary-700">Salidas Educativas</a>
            <svg class="mx-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
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
            <?php if($modo == 'show'): ?>
            <div class="flex space-x-3">
                
                <a href="<?php echo e(route('salidas_educativas.edit', $salida_id ?? 1)); ?>" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
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
        
        <form action="<?php echo e($modo == 'create' ? route('salidas_educativas.index') : route('salidas_educativas.index')); ?>" method="POST" class="space-y-6 p-6">
            <?php echo csrf_field(); ?>
            <?php if($modo == 'edit'): ?>
                <?php echo method_field('PUT'); ?>
            <?php endif; ?>

            <!-- Información de la Salida -->
            <div class="border-b border-secondary-200 pb-6">
                <h3 class="text-lg font-medium text-secondary-900 mb-4">Información de la Salida</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Escuela -->
                    <div class="space-y-1">
                        <label for="id_escuela" class="block text-sm font-medium text-secondary-700">
                            Escuela <span class="text-danger-500">*</span>
                        </label>
                        
                        <select
                            name="id_escuela"
                            id="id_escuela"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                            <?php echo e($modo == 'show' ? 'disabled' : ''); ?>

                            required
                        >
                            <option value="">Seleccione una escuela</option>
                            
                             <option value="1" <?php echo e(($salida_id ?? '' == 1) ? 'selected' : ''); ?>>Colegio San Martín</option>
                             <option value="2" <?php echo e(($salida_id ?? '' == 2) ? 'selected' : ''); ?>>Instituto Belgrano</option>
                        </select>
                    </div>

                    <!-- Fecha de Salida -->
                    <div class="space-y-1">
                        <label for="fecha_salida" class="block text-sm font-medium text-secondary-700">
                            Fecha de Salida <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="date"
                            name="fecha_salida"
                            id="fecha_salida"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                            value="<?php echo e($salida_id ?? '' == 1 ? '2024-10-15' : ($salida_id ?? '' == 2 ? '2024-11-20' : '')); ?>"
                            <?php echo e($modo == 'show' ? 'readonly' : ''); ?>

                            required
                        >
                    </div>

                    <!-- Hora de Salida -->
                    <div class="space-y-1">
                        <label for="hora_salida" class="block text-sm font-medium text-secondary-700">
                            Hora de Salida <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="time"
                            name="hora_salida"
                            id="hora_salida"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                            value="<?php echo e($salida_id ?? '' == 1 ? '08:00' : ($salida_id ?? '' == 2 ? '09:30' : '')); ?>"
                            <?php echo e($modo == 'show' ? 'readonly' : ''); ?>

                            required
                        >
                    </div>

                    <!-- Hora de Regreso -->
                    <div class="space-y-1">
                        <label for="hora_regreso" class="block text-sm font-medium text-secondary-700">
                            Hora de Regreso <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="time"
                            name="hora_regreso"
                            id="hora_regreso"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                            value="<?php echo e($salida_id ?? '' == 1 ? '17:00' : ($salida_id ?? '' == 2 ? '16:00' : '')); ?>"
                            <?php echo e($modo == 'show' ? 'readonly' : ''); ?>

                            required
                        >
                    </div>

                    <!-- Destino -->
                    <div class="md:col-span-2 space-y-1">
                        <label for="destino" class="block text-sm font-medium text-secondary-700">
                            Destino <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="destino"
                            id="destino"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                            placeholder="Ej: Museo de Ciencias Naturales"
                            value="<?php echo e($salida_id ?? '' == 1 ? 'Museo de Ciencias Naturales' : ($salida_id ?? '' == 2 ? 'Fábrica de Alfajores' : '')); ?>"
                            <?php echo e($modo == 'show' ? 'readonly' : ''); ?>

                            required
                        >
                    </div>

                    <!-- Propósito -->
                    <div class="md:col-span-2 space-y-1">
                        <label for="proposito" class="block text-sm font-medium text-secondary-700">
                            Propósito <span class="text-danger-500">*</span>
                        </label>
                        <textarea
                            name="proposito"
                            id="proposito"
                            rows="3"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                            placeholder="Describa el propósito de la salida educativa"
                            <?php echo e($modo == 'show' ? 'readonly' : ''); ?>

                            required
                        ><?php echo e($salida_id ?? '' == 1 ? 'Visita guiada para complementar contenidos de biología.' : ($salida_id ?? '' == 2 ? 'Conocer el proceso de producción industrial.' : '')); ?></textarea>
                    </div>

                    <!-- Grado/Curso -->
                    <div class="space-y-1">
                        <label for="grado_curso" class="block text-sm font-medium text-secondary-700">
                            Grado/Curso <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="grado_curso"
                            id="grado_curso"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                            placeholder="Ej: 5to Grado"
                            value="<?php echo e($salida_id ?? '' == 1 ? '5to Grado' : ($salida_id ?? '' == 2 ? '3er Año' : '')); ?>"
                            <?php echo e($modo == 'show' ? 'readonly' : ''); ?>

                            required
                        >
                    </div>

                    <!-- Cantidad de Alumnos -->
                    <div class="space-y-1">
                        <label for="cantidad_alumnos" class="block text-sm font-medium text-secondary-700">
                            Cantidad de Alumnos <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="number"
                            name="cantidad_alumnos"
                            id="cantidad_alumnos"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                            placeholder="Ej: 30"
                            value="<?php echo e($salida_id ?? '' == 1 ? '35' : ($salida_id ?? '' == 2 ? '28' : '')); ?>"
                            <?php echo e($modo == 'show' ? 'readonly' : ''); ?>

                            required
                        >
                    </div>

                    <!-- Docentes Acompañantes -->
                    <div class="md:col-span-2 space-y-1">
                        <label for="docentes_acompañantes" class="block text-sm font-medium text-secondary-700">
                            Docentes Acompañantes <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="docentes_acompañantes"
                            id="docentes_acompañantes"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                            placeholder="Ej: Prof. Ana Gómez, Prof. Carlos Ruiz"
                            value="<?php echo e($salida_id ?? '' == 1 ? 'Prof. Ana Gómez, Prof. Carlos Ruiz' : ($salida_id ?? '' == 2 ? 'Prof. Laura Fernández' : '')); ?>"
                            <?php echo e($modo == 'show' ? 'readonly' : ''); ?>

                            required
                        >
                    </div>

                    <!-- Medio de Transporte -->
                    <div class="md:col-span-2 space-y-1">
                        <label for="transporte" class="block text-sm font-medium text-secondary-700">
                            Medio de Transporte <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="transporte"
                            id="transporte"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                            placeholder="Ej: Colectivo escolar"
                            value="<?php echo e($salida_id ?? '' == 1 ? 'Colectivo escolar' : ($salida_id ?? '' == 2 ? 'Transporte público' : '')); ?>"
                            <?php echo e($modo == 'show' ? 'readonly' : ''); ?>

                            required
                        >
                    </div>
                </div>
            </div>

            
            <div class="border-b border-secondary-200 pb-6">
                 <h3 class="text-lg font-medium text-secondary-900 mb-4">Documentación</h3>
                 <p class="text-sm text-secondary-600">Aquí se podrán adjuntar las autorizaciones parentales y otra documentación relevante.</p>
                 
            </div>


            <!-- Botones de Acción -->
            <div class="flex items-center justify-between pt-6 border-t border-secondary-200">
                
                <a href="<?php echo e(route('salidas_educativas.index')); ?>" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
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
                    <?php echo e($modo == 'create' ? 'Crear Salida Educativa' : 'Actualizar Salida Educativa'); ?>

                </button>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validación de formulario en tiempo real
        const form = document.querySelector('form');
        const requiredInputs = form.querySelectorAll('input[required], select[required], textarea[required]');

        requiredInputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });

            input.addEventListener('input', function() {
                if (this.classList.contains('border-danger-300')) {
                    validateField(this);
                }
            });
             input.addEventListener('change', function() { // Added for select elements
                if (this.classList.contains('border-danger-300')) {
                    validateField(this);
                }
            });
        });

        function validateField(field) {
            const value = field.value.trim();
            const isValid = value !== '';

            if (isValid) {
                field.classList.remove('border-danger-300', 'focus:border-danger-500', 'focus:ring-danger-500');
                field.classList.add('border-success-300', 'focus:border-primary-500', 'focus:ring-primary-500');
            } else {
                field.classList.remove('border-success-300', 'focus:border-primary-500', 'focus:ring-primary-500');
                field.classList.add('border-danger-300', 'focus:border-danger-500', 'focus:ring-danger-500');
            }
        }

        // Animación de feedback visual
        const submitButton = document.querySelector('button[type="submit"]');
        if (submitButton) {
            form.addEventListener('submit', function(e) {
                // Prevent actual form submission for mockup
                e.preventDefault();

                // Basic validation check before simulating submission
                let formIsValid = true;
                requiredInputs.forEach(input => {
                    if (input.value.trim() === '') {
                        validateField(input); // Highlight empty required fields
                        formIsValid = false;
                    }
                });

                if (formIsValid) {
                    submitButton.classList.add('opacity-75');
                    submitButton.disabled = true;

                    // Simular procesamiento (en producción esto sería manejado por el servidor)
                    setTimeout(() => {
                        submitButton.classList.remove('opacity-75');
                        submitButton.disabled = false;
                        alert('Formulario de Salida Educativa simulado enviado.'); // Feedback visual
                    }, 2000);
                } else {
                    alert('Por favor, complete todos los campos obligatorios.');
                }
            });
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Disco\Documentos\Personal\Proyectos\workana\SistemaFondoSolidario\FondoSolidarioSite\resources\views/livewire/salidas_educativas/form.blade.php ENDPATH**/ ?>