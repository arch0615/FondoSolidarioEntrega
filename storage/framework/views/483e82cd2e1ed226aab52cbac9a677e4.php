<?php $__env->startSection('content'); ?>
<div class="mx-auto px-4">
    <!-- Header -->
    <div class="mb-8">
        <nav class="flex items-center text-sm text-secondary-500 mb-4">
            <a href="<?php echo e(route('escuelas.index')); ?>" class="hover:text-secondary-700">Escuelas</a>
            <svg class="mx-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-secondary-900"><?php echo e($modo == 'create' ? 'Nueva Escuela' : ($modo == 'edit' ? 'Editar Escuela' : 'Detalles de Escuela')); ?></span>
        </nav>
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-secondary-900">
                    <?php echo e($modo == 'create' ? 'Nueva Escuela' : ($modo == 'edit' ? 'Editar Escuela' : 'Detalles de Escuela')); ?>

                </h1>
                <p class="mt-1 text-sm text-secondary-600">
                    <?php echo e($modo == 'create' ? 'Complete los datos para registrar una nueva escuela' : ($modo == 'edit' ? 'Modifique los datos de la escuela' : 'Información detallada de la escuela')); ?>

                </p>
            </div>
            <?php if($modo == 'show'): ?>
            <div class="flex space-x-3">
                <a href="<?php echo e(route('escuelas.edit', $escuela_id ?? 1)); ?>" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
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
        <form action="<?php echo e($modo == 'create' ? route('escuelas.index') : route('escuelas.index')); ?>" method="POST" class="space-y-6 p-6">
            <?php echo csrf_field(); ?>
            <?php if($modo == 'edit'): ?>
                <?php echo method_field('PUT'); ?>
            <?php endif; ?>

            <!-- Información Básica -->
            <div class="border-b border-secondary-200 pb-6">
                <h3 class="text-lg font-medium text-secondary-900 mb-4">Información Básica</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Código -->
                    <div class="space-y-1">
                        <label for="codigo_escuela" class="block text-sm font-medium text-secondary-700">
                            Código de Escuela <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="codigo_escuela"
                            id="codigo_escuela"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                            placeholder="Ej: ESC001"
                            value="<?php echo e($escuela_id ?? '' == 1 ? 'ESC001' : ($escuela_id ?? '' == 2 ? 'ESC002' : '')); ?>"
                            <?php echo e($modo == 'show' ? 'readonly' : ''); ?>

                            required
                        >
                        <p class="text-xs text-secondary-500">Código único identificador de la escuela</p>
                    </div>

                    <!-- Nombre -->
                    <div class="space-y-1">
                        <label for="nombre" class="block text-sm font-medium text-secondary-700">
                            Nombre de Escuela <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="nombre"
                            id="nombre"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                            placeholder="Ej: Colegio San José del Calasanz"
                            value="<?php echo e($escuela_id ?? '' == 1 ? 'Colegio San Martín' : ($escuela_id ?? '' == 2 ? 'Instituto Belgrano' : '')); ?>"
                            <?php echo e($modo == 'show' ? 'readonly' : ''); ?>

                            required
                        >
                    </div>

                    <!-- Dirección -->
                    <div class="md:col-span-2 space-y-1">
                        <label for="direccion" class="block text-sm font-medium text-secondary-700">
                            Dirección <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="direccion"
                            id="direccion"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                            placeholder="Ej: Av. Colón 1234, Córdoba"
                            value="<?php echo e($escuela_id ?? '' == 1 ? 'Av. Siempre Viva 742, Córdoba' : ($escuela_id ?? '' == 2 ? 'Calle Falsa 123, Córdoba' : '')); ?>"
                            <?php echo e($modo == 'show' ? 'readonly' : ''); ?>

                            required
                        >
                    </div>
                </div>
            </div>

            <!-- Información de Contacto -->
            <div class="border-b border-secondary-200 pb-6">
                <h3 class="text-lg font-medium text-secondary-900 mb-4">Información de Contacto</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Teléfono -->
                    <div class="space-y-1">
                        <label for="telefono" class="block text-sm font-medium text-secondary-700">
                            Teléfono <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="tel"
                            name="telefono"
                            id="telefono"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                            placeholder="Ej: (351) 425-6789"
                            value="<?php echo e($escuela_id ?? '' == 1 ? '(351) 455-1234' : ($escuela_id ?? '' == 2 ? '(351) 477-5678' : '')); ?>"
                            <?php echo e($modo == 'show' ? 'readonly' : ''); ?>

                            required
                        >
                    </div>

                    <!-- Email -->
                    <div class="space-y-1">
                        <label for="email" class="block text-sm font-medium text-secondary-700">
                            Correo Electrónico <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                            placeholder="Ej: contacto@sanjose.edu.ar"
                            value="<?php echo e($escuela_id ?? '' == 1 ? 'info@sanmartin.edu.ar' : ($escuela_id ?? '' == 2 ? 'contacto@belgrano.edu.ar' : '')); ?>"
                            <?php echo e($modo == 'show' ? 'readonly' : ''); ?>

                            required
                        >
                    </div>
                </div>
            </div>

            <!-- Configuración Financiera -->
            <div class="border-b border-secondary-200 pb-6">
                <h3 class="text-lg font-medium text-secondary-900 mb-4">Configuración Financiera</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Aporte por Alumno -->
                    <div class="space-y-1">
                        <label for="aporte_por_alumno" class="block text-sm font-medium text-secondary-700">
                            Aporte por Alumno (ARS) <span class="text-danger-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-secondary-500 text-sm">$</span>
                            </div>
                            <input
                                type="number"
                                step="0.01"
                                name="aporte_por_alumno"
                                id="aporte_por_alumno"
                                class="block w-full pl-8 pr-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                                placeholder="150.50"
                                value="<?php echo e($escuela_id ?? '' == 1 ? '250.75' : ($escuela_id ?? '' == 2 ? '180.00' : '')); ?>"
                                <?php echo e($modo == 'show' ? 'readonly' : ''); ?>

                                required
                            >
                        </div>
                        <p class="text-xs text-secondary-500">Monto que aporta la escuela por cada alumno al fondo</p>
                    </div>

                    <?php if($modo != 'create'): ?>
                    <!-- Fecha de Alta -->
                    <div class="space-y-1">
                        <label for="fecha_alta" class="block text-sm font-medium text-secondary-700">Fecha de Alta</label>
                        <input
                            type="date"
                            name="fecha_alta"
                            id="fecha_alta"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm bg-secondary-50 focus:outline-none"
                            value="<?php echo e($escuela_id ?? '' == 1 ? '2023-01-15' : ($escuela_id ?? '' == 2 ? '2022-05-20' : '')); ?>"
                            readonly
                        >
                        <p class="text-xs text-secondary-500">Fecha de registro en el sistema</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Estado y Configuración -->
            <div class="space-y-4">
                <h3 class="text-lg font-medium text-secondary-900">Estado</h3>
                <div class="flex items-center">
                    <div class="flex items-center h-5">
                        <input
                            type="checkbox"
                            name="activo"
                            id="activo"
                            class="w-4 h-4 text-primary-600 bg-white border-secondary-300 rounded focus:ring-primary-500 focus:ring-2"
                            <?php echo e(($modo == 'create' || ($escuela_id ?? '' == 1 && $modo != 'create')) ? 'checked' : ''); ?>

                            <?php echo e($modo == 'show' ? 'disabled' : ''); ?>

                        >
                    </div>
                    <div class="ml-3">
                        <label for="activo" class="text-sm font-medium text-secondary-700">
                            Escuela Activa
                        </label>
                        <p class="text-xs text-secondary-500">Las escuelas activas pueden registrar accidentes y gestionar reintegros</p>
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="flex items-center justify-between pt-6 border-t border-secondary-200">
                <a href="<?php echo e(route('escuelas.index')); ?>" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
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
                    <?php echo e($modo == 'create' ? 'Crear Escuela' : 'Actualizar Escuela'); ?>

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
    const requiredInputs = form.querySelectorAll('input[required]');
    
    requiredInputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });
        
        input.addEventListener('input', function() {
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
    
    // Formateo automático de número de teléfono
    const phoneInput = document.getElementById('telefono');
    if (phoneInput && !phoneInput.readOnly) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 3) {
                value = value.replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
            }
            e.target.value = value;
        });
    }
    
    // Formateo automático de aporte por alumno
    const aporteInput = document.getElementById('aporte_por_alumno');
    if (aporteInput && !aporteInput.readOnly) {
        aporteInput.addEventListener('blur', function(e) {
            const value = parseFloat(e.target.value);
            if (!isNaN(value)) {
                e.target.value = value.toFixed(2);
            }
        });
    }
    
    // Animación de feedback visual
    const submitButton = document.querySelector('button[type="submit"]');
    if (submitButton) {
        form.addEventListener('submit', function(e) {
            submitButton.classList.add('opacity-75');
            submitButton.disabled = true;
            
            // Simular procesamiento (en producción esto sería manejado por el servidor)
            setTimeout(() => {
                submitButton.classList.remove('opacity-75');
                submitButton.disabled = false;
            }, 2000);
        });
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\rican\OneDrive\Documentos\workana\Fondo Solidario\resources\views\livewire\escuelas\form.blade.php ENDPATH**/ ?>