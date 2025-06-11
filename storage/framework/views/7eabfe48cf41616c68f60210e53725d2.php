<?php $__env->startSection('content'); ?>
<div class="mx-auto px-4">
    <!-- Header -->
    <div class="mb-8">
        <nav class="flex items-center text-sm text-secondary-500 mb-4">
            
            <a href="<?php echo e(route('derivaciones.index')); ?>" class="hover:text-secondary-700">Derivaciones</a>
            <svg class="mx-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
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
                
                <a href="<?php echo e(route('derivaciones.edit', $derivacion_id ?? 1)); ?>" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
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
        
        <form action="<?php echo e($modo == 'create' ? route('derivaciones.index') : route('derivaciones.index')); ?>" method="POST" class="space-y-6 p-6" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php if($modo == 'edit'): ?>
                <?php echo method_field('PUT'); ?>
            <?php endif; ?>

            <!-- Información de la Derivación -->
            <div class="border-b border-secondary-200 pb-6">
                <h3 class="text-lg font-medium text-secondary-900 mb-4">Información de la Derivación</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- ID Accidente (Relacionado) -->
                    <div class="space-y-1">
                        <label for="id_accidente" class="block text-sm font-medium text-secondary-700">
                            Accidente Relacionado (Alumno) <span class="text-danger-500">*</span>
                        </label>
                        
                        <select
                            name="id_accidente"
                            id="id_accidente"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                            <?php echo e($modo == 'show' ? 'disabled' : ''); ?>

                            required
                        >
                            <option value="">Seleccione un accidente</option>
                            <option value="1" <?php echo e(($derivacion_id ?? '' == 1) ? 'selected' : ''); ?>>ACC-001 (Juan Pérez - Colegio San Martín)</option>
                            <option value="2" <?php echo e(($derivacion_id ?? '' == 2) ? 'selected' : ''); ?>>ACC-002 (Ana López - Instituto Belgrano)</option>
                        </select>
                        <?php if($modo == 'create'): ?>
                        <p class="text-xs text-secondary-500">Si el accidente no está listado, primero debe <a href="<?php echo e(route('accidentes.create')); ?>" class="text-primary-600 hover:underline">registrar el accidente</a>.</p>
                        <?php endif; ?>
                    </div>

                    <!-- Prestador Médico -->
                    <div class="space-y-1">
                        <label for="id_prestador" class="block text-sm font-medium text-secondary-700">
                            Prestador Médico <span class="text-danger-500">*</span>
                        </label>
                        
                        <select
                            name="id_prestador"
                            id="id_prestador"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                            <?php echo e($modo == 'show' ? 'disabled' : ''); ?>

                            required
                        >
                            <option value="">Seleccione un prestador</option>
                            <option value="1" <?php echo e(($derivacion_id ?? '' == 1) ? 'selected' : ''); ?>>Clínica del Sol</option>
                            <option value="2" <?php echo e(($derivacion_id ?? '' == 2) ? 'selected' : ''); ?>>Hospital Privado</option>
                            <option value="3">Sanatorio Allende</option>
                        </select>
                    </div>

                    <!-- Fecha de Derivación -->
                    <div class="space-y-1">
                        <label for="fecha_derivacion" class="block text-sm font-medium text-secondary-700">
                            Fecha de Derivación <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="date"
                            name="fecha_derivacion"
                            id="fecha_derivacion"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                            value="<?php echo e($derivacion_id ?? '' == 1 ? '2024-05-15' : ($derivacion_id ?? '' == 2 ? '2024-05-18' : date('Y-m-d'))); ?>"
                            <?php echo e($modo == 'show' ? 'readonly' : ''); ?>

                            required
                        >
                    </div>

                    <!-- Hora de Derivación -->
                    <div class="space-y-1">
                        <label for="hora_derivacion" class="block text-sm font-medium text-secondary-700">
                            Hora de Derivación <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="time"
                            name="hora_derivacion"
                            id="hora_derivacion"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                            value="<?php echo e($derivacion_id ?? '' == 1 ? '10:30' : ($derivacion_id ?? '' == 2 ? '15:15' : date('H:i'))); ?>"
                            <?php echo e($modo == 'show' ? 'readonly' : ''); ?>

                            required
                        >
                    </div>

                    <!-- Médico que Deriva -->
                    <div class="space-y-1">
                        <label for="medico_deriva" class="block text-sm font-medium text-secondary-700">
                            Médico que Deriva (Sistema de Emergencias)
                        </label>
                        <input
                            type="text"
                            name="medico_deriva"
                            id="medico_deriva"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                            placeholder="Ej: Dr. Carlos Rodriguez (SEM)"
                            value="<?php echo e($derivacion_id ?? '' == 1 ? 'Dr. Lucas Gonzalez (SEM)' : ($derivacion_id ?? '' == 2 ? 'Dra. Valeria Ochoa (SEM)' : '')); ?>"
                            <?php echo e($modo == 'show' ? 'readonly' : ''); ?>

                        >
                         <p class="text-xs text-secondary-500">Nombre del profesional del servicio de emergencias que atendió en la escuela y sugiere la derivación.</p>
                    </div>

                    <!-- Acompañante -->
                    <div class="space-y-1">
                        <label for="acompañante" class="block text-sm font-medium text-secondary-700">
                            Adulto Acompañante <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="acompañante"
                            id="acompañante"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                            placeholder="Ej: Laura Gómez (Madre) / Prof. Ana Díaz"
                            value="<?php echo e($derivacion_id ?? '' == 1 ? 'Mariana Torres (Preceptora)' : ($derivacion_id ?? '' == 2 ? 'Roberto Sánchez (Padre)' : '')); ?>"
                            <?php echo e($modo == 'show' ? 'readonly' : ''); ?>

                            required
                        >
                        <p class="text-xs text-secondary-500">Nombre y rol/parentesco del adulto que acompaña al alumno al prestador.</p>
                    </div>

                    <!-- Diagnóstico Inicial -->
                    <div class="md:col-span-2 space-y-1">
                        <label for="diagnostico_inicial" class="block text-sm font-medium text-secondary-700">
                            Diagnóstico Inicial (Presuntivo) <span class="text-danger-500">*</span>
                        </label>
                        <textarea
                            name="diagnostico_inicial"
                            id="diagnostico_inicial"
                            rows="3"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                            placeholder="Ej: Posible esguince de tobillo derecho, traumatismo leve en muñeca."
                            <?php echo e($modo == 'show' ? 'readonly' : ''); ?>

                            required
                        ><?php echo e($derivacion_id ?? '' == 1 ? 'Golpe en la cabeza, posible contusión leve.' : ($derivacion_id ?? '' == 2 ? 'Dolor abdominal agudo, se sugiere observación.' : '')); ?></textarea>
                        <p class="text-xs text-secondary-500">Descripción breve del motivo de la derivación según la evaluación inicial en la escuela.</p>
                    </div>

                    <!-- Observaciones Adicionales -->
                    <div class="md:col-span-2 space-y-1">
                        <label for="observaciones" class="block text-sm font-medium text-secondary-700">
                            Observaciones Adicionales
                        </label>
                        <textarea
                            name="observaciones"
                            id="observaciones"
                            rows="3"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                            placeholder="Ej: Alumno refiere mareos. Se contactó a la familia."
                            <?php echo e($modo == 'show' ? 'readonly' : ''); ?>

                        ><?php echo e($derivacion_id ?? '' == 1 ? 'Se administró paño frío. Familia notificada.' : ($derivacion_id ?? '' == 2 ? 'Presentó fiebre leve (37.8°C) antes de la derivación.' : '')); ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Estado de Impresión (Solo informativo en el form, se actualiza al imprimir) -->
             <?php if($modo == 'show' || $modo == 'edit'): ?>
            <div class="space-y-4">
                <h3 class="text-lg font-medium text-secondary-900">Estado de Impresión</h3>
                <div class="flex items-center">
                    <div class="flex items-center h-5">
                        <input
                            type="checkbox"
                            name="impresa"
                            id="impresa"
                            class="w-4 h-4 text-primary-600 bg-white border-secondary-300 rounded focus:ring-primary-500 focus:ring-2"
                            <?php echo e(($derivacion_id ?? '' == 1 && $modo != 'create') ? 'checked' : ''); ?>

                            disabled 
                        >
                    </div>
                    <div class="ml-3">
                        <label for="impresa" class="text-sm font-medium text-secondary-700">
                            Derivación Impresa
                        </label>
                        <p class="text-xs text-secondary-500">Indica si el documento de derivación ya ha sido impreso. (Fecha de impresión: <?php echo e($derivacion_id ?? '' == 1 ? '15/05/2024 10:35 AM' : 'No impresa'); ?>)</p>
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
                        alert('Formulario de Derivación simulado enviado.'); // Feedback visual
                    }, 2000);
                } else {
                    alert('Por favor, complete todos los campos obligatorios.');
                }
            });
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\rican\OneDrive\Documentos\workana\Fondo Solidario\resources\views\livewire\derivaciones\form.blade.php ENDPATH**/ ?>