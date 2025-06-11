<?php $__env->startSection('content'); ?>
<div class="mx-auto px-4">
    <!-- Header -->
    <div class="mb-8">
        <nav class="flex items-center text-sm text-secondary-500 mb-4">
            
            <a href="<?php echo e(route('pasantias.index')); ?>" class="hover:text-secondary-700">Pasantías</a>
            <svg class="mx-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-secondary-900"><?php echo e($modo == 'create' ? 'Nueva Pasantía' : ($modo == 'edit' ? 'Editar Pasantía' : 'Detalles de Pasantía')); ?></span>
        </nav>
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-secondary-900">
                    <?php echo e($modo == 'create' ? 'Nueva Pasantía' : ($modo == 'edit' ? 'Editar Pasantía' : 'Detalles de Pasantía')); ?>

                </h1>
                <p class="mt-1 text-sm text-secondary-600">
                    <?php echo e($modo == 'create' ? 'Complete los datos para registrar una nueva pasantía' : ($modo == 'edit' ? 'Modifique los datos de la pasantía' : 'Información detallada de la pasantía')); ?>

                </p>
            </div>
            <?php if($modo == 'show'): ?>
            <div class="flex space-x-3">
                
                <a href="<?php echo e(route('pasantias.edit', $pasantia_id ?? 1)); ?>" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
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
        
        <form action="<?php echo e($modo == 'create' ? route('pasantias.index') : route('pasantias.index')); ?>" method="POST" class="space-y-6 p-6">
            <?php echo csrf_field(); ?>
            <?php if($modo == 'edit'): ?>
                <?php echo method_field('PUT'); ?>
            <?php endif; ?>

            <!-- Información de la Pasantía -->
            <div class="border-b border-secondary-200 pb-6">
                <h3 class="text-lg font-medium text-secondary-900 mb-4">Información de la Pasantía</h3>
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
                             <option value="1" <?php echo e(($pasantia_id ?? '' == 1) ? 'selected' : ''); ?>>Colegio San Martín</option>
                             <option value="2" <?php echo e(($pasantia_id ?? '' == 2) ? 'selected' : ''); ?>>Instituto Belgrano</option>
                        </select>
                    </div>

                    <!-- Alumno -->
                    <div class="space-y-1">
                        <label for="id_alumno" class="block text-sm font-medium text-secondary-700">
                            Alumno <span class="text-danger-500">*</span>
                        </label>
                        
                        <select
                            name="id_alumno"
                            id="id_alumno"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                            <?php echo e($modo == 'show' ? 'disabled' : ''); ?>

                            required
                        >
                            <option value="">Seleccione un alumno</option>
                            <option value="101" <?php echo e(($pasantia_id ?? '' == 1) ? 'selected' : ''); ?>>Pedro Gómez (DNI: 30123456)</option>
                            <option value="102" <?php echo e(($pasantia_id ?? '' == 2) ? 'selected' : ''); ?>>Ana Torres (DNI: 31987654)</option>
                        </select>
                    </div>

                    <!-- Empresa -->
                    <div class="md:col-span-2 space-y-1">
                        <label for="empresa" class="block text-sm font-medium text-secondary-700">
                            Empresa <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="empresa"
                            id="empresa"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                            placeholder="Ej: Tech Solutions S.A."
                            value="<?php echo e($pasantia_id ?? '' == 1 ? 'Tech Solutions S.A.' : ($pasantia_id ?? '' == 2 ? 'Creative Marketing' : '')); ?>"
                            <?php echo e($modo == 'show' ? 'readonly' : ''); ?>

                            required
                        >
                    </div>

                    <!-- Dirección Empresa -->
                    <div class="md:col-span-2 space-y-1">
                        <label for="direccion_empresa" class="block text-sm font-medium text-secondary-700">
                            Dirección de la Empresa <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="direccion_empresa"
                            id="direccion_empresa"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                            placeholder="Ej: Av. Principal 456, Córdoba"
                            value="<?php echo e($pasantia_id ?? '' == 1 ? 'Av. Principal 456, Córdoba' : ($pasantia_id ?? '' == 2 ? 'Calle Secundaria 789, Córdoba' : '')); ?>"
                            <?php echo e($modo == 'show' ? 'readonly' : ''); ?>

                            required
                        >
                    </div>

                     <!-- Tutor en Empresa -->
                    <div class="space-y-1">
                        <label for="tutor_empresa" class="block text-sm font-medium text-secondary-700">
                            Tutor en Empresa <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="tutor_empresa"
                            id="tutor_empresa"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                            placeholder="Ej: Ing. Ricardo López"
                            value="<?php echo e($pasantia_id ?? '' == 1 ? 'Ing. Ricardo López' : ($pasantia_id ?? '' == 2 ? 'Lic. Laura Méndez' : '')); ?>"
                            <?php echo e($modo == 'show' ? 'readonly' : ''); ?>

                            required
                        >
                    </div>

                    <!-- Fecha de Inicio -->
                    <div class="space-y-1">
                        <label for="fecha_inicio" class="block text-sm font-medium text-secondary-700">
                            Fecha de Inicio <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="date"
                            name="fecha_inicio"
                            id="fecha_inicio"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                            value="<?php echo e($pasantia_id ?? '' == 1 ? '2025-01-10' : ($pasantia_id ?? '' == 2 ? '2025-02-01' : '')); ?>"
                            <?php echo e($modo == 'show' ? 'readonly' : ''); ?>

                            required
                        >
                    </div>

                    <!-- Fecha de Fin -->
                    <div class="space-y-1">
                        <label for="fecha_fin" class="block text-sm font-medium text-secondary-700">
                            Fecha de Fin <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="date"
                            name="fecha_fin"
                            id="fecha_fin"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                            value="<?php echo e($pasantia_id ?? '' == 1 ? '2025-03-10' : ($pasantia_id ?? '' == 2 ? '2025-04-01' : '')); ?>"
                            <?php echo e($modo == 'show' ? 'readonly' : ''); ?>

                            required
                        >
                    </div>

                    <!-- Horario -->
                    <div class="space-y-1">
                        <label for="horario" class="block text-sm font-medium text-secondary-700">
                            Horario <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="horario"
                            id="horario"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                            placeholder="Ej: Lunes a Viernes de 9:00 a 13:00"
                            value="<?php echo e($pasantia_id ?? '' == 1 ? 'Lunes a Viernes de 9:00 a 13:00' : ($pasantia_id ?? '' == 2 ? 'Martes y Jueves de 14:00 a 18:00' : '')); ?>"
                            <?php echo e($modo == 'show' ? 'readonly' : ''); ?>

                            required
                        >
                    </div>

                    <!-- Descripción de Tareas -->
                    <div class="md:col-span-2 space-y-1">
                        <label for="descripcion_tareas" class="block text-sm font-medium text-secondary-700">
                            Descripción de Tareas <span class="text-danger-500">*</span>
                        </label>
                        <textarea
                            name="descripcion_tareas"
                            id="descripcion_tareas"
                            rows="4"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                            placeholder="Describa las tareas que realizará el pasante"
                            <?php echo e($modo == 'show' ? 'readonly' : ''); ?>

                            required
                        ><?php echo e($pasantia_id ?? '' == 1 ? 'Desarrollo de software, testing y documentación.' : ($pasantia_id ?? '' == 2 ? 'Gestión de redes sociales, creación de contenido.' : '')); ?></textarea>
                    </div>
                </div>
            </div>

            
            <div class="border-b border-secondary-200 pb-6">
                 <h3 class="text-lg font-medium text-secondary-900 mb-4">Documentación Adicional</h3>
                 <p class="text-sm text-secondary-600">Aquí se podrá adjuntar convenios, seguros y otra documentación relevante.</p>
                 
            </div>


            <!-- Botones de Acción -->
            <div class="flex items-center justify-between pt-6 border-t border-secondary-200">
                
                <a href="<?php echo e(route('pasantias.index')); ?>" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
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
                    <?php echo e($modo == 'create' ? 'Crear Pasantía' : 'Actualizar Pasantía'); ?>

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
                        alert('Formulario de Pasantía simulado enviado.'); // Feedback visual
                    }, 2000);
                } else {
                    alert('Por favor, complete todos los campos obligatorios.');
                }
            });
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\rican\OneDrive\Documentos\workana\Fondo Solidario\resources\views\livewire\pasantias\form.blade.php ENDPATH**/ ?>