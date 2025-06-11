<?php $__env->startSection('content'); ?>
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
            <?php if($modo == 'show'): ?>
            <div class="flex space-x-3">
                
                <a href="<?php echo e(route('alumnos.edit', isset($alumno_id) ? $alumno_id : 1)); ?>" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
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
        
        <form action="<?php echo e($modo == 'create' ? route('alumnos.index') : route('alumnos.index')); ?>" method="POST" class="space-y-6 p-6">
            <?php echo csrf_field(); ?>
            <?php if($modo == 'edit'): ?>
                <?php echo method_field('PUT'); ?>
            <?php endif; ?>

            <?php
                // Definir valores por defecto basados en el ID del alumno para el mockup
                $alumnoData = [];
                if (isset($alumno_id)) {
                    switch ($alumno_id) {
                        case 1:
                            $alumnoData = [
                                'nombre' => 'Ana',
                                'apellido' => 'Martínez',
                                'dni' => '45678912',
                                'cuil' => '23-45678912-4',
                                'fecha_nacimiento' => '2011-03-15',
                                'id_escuela' => '1',
                                'sala_grado_curso' => '7° Grado',
                                'seccion' => 'A',
                                'nombre_padre_madre' => 'Carlos Martínez',
                                'telefono_contacto' => '(351) 555-1234',
                                'activo' => true
                            ];
                            break;
                        case 2:
                            $alumnoData = [
                                'nombre' => 'Luis',
                                'apellido' => 'González',
                                'dni' => '46789123',
                                'cuil' => '20-46789123-7',
                                'fecha_nacimiento' => '2008-07-22',
                                'id_escuela' => '2',
                                'sala_grado_curso' => '3° Año',
                                'seccion' => 'B',
                                'nombre_padre_madre' => 'María González',
                                'telefono_contacto' => '(351) 555-5678',
                                'activo' => true
                            ];
                            break;
                        case 3:
                            $alumnoData = [
                                'nombre' => 'Sofía',
                                'apellido' => 'Rodríguez',
                                'dni' => '47891234',
                                'cuil' => '27-47891234-1',
                                'fecha_nacimiento' => '2009-11-10',
                                'id_escuela' => '1',
                                'sala_grado_curso' => '2° Año',
                                'seccion' => 'A',
                                'nombre_padre_madre' => 'Roberto Rodríguez',
                                'telefono_contacto' => '(351) 555-9012',
                                'activo' => false
                            ];
                            break;
                        default:
                            $alumnoData = [
                                'nombre' => '',
                                'apellido' => '',
                                'dni' => '',
                                'cuil' => '',
                                'fecha_nacimiento' => '',
                                'id_escuela' => '',
                                'sala_grado_curso' => '',
                                'seccion' => '',
                                'nombre_padre_madre' => '',
                                'telefono_contacto' => '',
                                'activo' => true
                            ];
                    }
                } else {
                    $alumnoData = [
                        'nombre' => '',
                        'apellido' => '',
                        'dni' => '',
                        'cuil' => '',
                        'fecha_nacimiento' => '',
                        'id_escuela' => '',
                        'sala_grado_curso' => '',
                        'seccion' => '',
                        'nombre_padre_madre' => '',
                        'telefono_contacto' => '',
                        'activo' => true
                    ];
                }
            ?>

            <!-- Información Personal del Alumno -->
            <div class="border-b border-secondary-200 pb-6">
                <h3 class="text-lg font-medium text-secondary-900 mb-4">Información Personal del Alumno</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nombre -->
                    <div class="space-y-1">
                        <label for="nombre" class="block text-sm font-medium text-secondary-700">
                            Nombre <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="nombre"
                            id="nombre"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                            placeholder="Ej: Ana"
                            value="<?php echo e($alumnoData['nombre']); ?>"
                            <?php echo e($modo == 'show' ? 'readonly' : ''); ?>

                            required
                        >
                    </div>

                    <!-- Apellido -->
                    <div class="space-y-1">
                        <label for="apellido" class="block text-sm font-medium text-secondary-700">
                            Apellido <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="apellido"
                            id="apellido"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                            placeholder="Ej: Martínez"
                            value="<?php echo e($alumnoData['apellido']); ?>"
                            <?php echo e($modo == 'show' ? 'readonly' : ''); ?>

                            required
                        >
                    </div>

                    <!-- DNI -->
                    <div class="space-y-1">
                        <label for="dni" class="block text-sm font-medium text-secondary-700">
                            DNI <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="dni"
                            id="dni"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                            placeholder="Ej: 45678912"
                            value="<?php echo e($alumnoData['dni']); ?>"
                            <?php echo e($modo == 'show' ? 'readonly' : ''); ?>

                            required
                        >
                    </div>

                    <!-- CUIL -->
                    <div class="space-y-1">
                        <label for="cuil" class="block text-sm font-medium text-secondary-700">
                            CUIL <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="cuil"
                            id="cuil"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                            placeholder="Ej: 23-45678912-4"
                            value="<?php echo e($alumnoData['cuil']); ?>"
                            <?php echo e($modo == 'show' ? 'readonly' : ''); ?>

                            required
                        >
                    </div>

                    <!-- Fecha de Nacimiento -->
                    <div class="space-y-1">
                        <label for="fecha_nacimiento" class="block text-sm font-medium text-secondary-700">
                            Fecha de Nacimiento <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="date"
                            name="fecha_nacimiento"
                            id="fecha_nacimiento"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                            value="<?php echo e($alumnoData['fecha_nacimiento']); ?>"
                            <?php echo e($modo == 'show' ? 'readonly' : ''); ?>

                            required
                        >
                    </div>

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
                            
                             <option value="1" <?php echo e($alumnoData['id_escuela'] == '1' ? 'selected' : ''); ?>>Colegio San Martín</option>
                             <option value="2" <?php echo e($alumnoData['id_escuela'] == '2' ? 'selected' : ''); ?>>Instituto Belgrano</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Información Académica -->
            <div class="border-b border-secondary-200 pb-6">
                <h3 class="text-lg font-medium text-secondary-900 mb-4">Información Académica</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Sala/Grado/Curso -->
                    <div class="space-y-1">
                        <label for="sala_grado_curso" class="block text-sm font-medium text-secondary-700">
                            Sala/Grado/Curso <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="sala_grado_curso"
                            id="sala_grado_curso"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                            placeholder="Ej: 7° Grado, 3° Año, Sala de 5"
                            value="<?php echo e($alumnoData['sala_grado_curso']); ?>"
                            <?php echo e($modo == 'show' ? 'readonly' : ''); ?>

                            required
                        >
                    </div>

                    <!-- Sección -->
                    <div class="space-y-1">
                        <label for="seccion" class="block text-sm font-medium text-secondary-700">
                            Sección <span class="text-danger-500">*</span>
                        </label>
                        <select
                            name="seccion"
                            id="seccion"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                            <?php echo e($modo == 'show' ? 'disabled' : ''); ?>

                            required
                        >
                            <option value="">Seleccione una sección</option>
                            <option value="A" <?php echo e($alumnoData['seccion'] == 'A' ? 'selected' : ''); ?>>A</option>
                            <option value="B" <?php echo e($alumnoData['seccion'] == 'B' ? 'selected' : ''); ?>>B</option>
                            <option value="C" <?php echo e($alumnoData['seccion'] == 'C' ? 'selected' : ''); ?>>C</option>
                            <option value="D" <?php echo e($alumnoData['seccion'] == 'D' ? 'selected' : ''); ?>>D</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Información de Contacto Familiar -->
            <div class="border-b border-secondary-200 pb-6">
                <h3 class="text-lg font-medium text-secondary-900 mb-4">Información de Contacto Familiar</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nombre del Padre/Madre -->
                    <div class="space-y-1">
                        <label for="nombre_padre_madre" class="block text-sm font-medium text-secondary-700">
                            Nombre del Padre/Madre <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="nombre_padre_madre"
                            id="nombre_padre_madre"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                            placeholder="Ej: Carlos Martínez"
                            value="<?php echo e($alumnoData['nombre_padre_madre']); ?>"
                            <?php echo e($modo == 'show' ? 'readonly' : ''); ?>

                            required
                        >
                    </div>

                    <!-- Teléfono de Contacto -->
                    <div class="space-y-1">
                        <label for="telefono_contacto" class="block text-sm font-medium text-secondary-700">
                            Teléfono de Contacto <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="tel"
                            name="telefono_contacto"
                            id="telefono_contacto"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?php echo e($modo == 'show' ? 'bg-secondary-50' : 'bg-white'); ?>"
                            placeholder="Ej: (351) 555-1234"
                            value="<?php echo e($alumnoData['telefono_contacto']); ?>"
                            <?php echo e($modo == 'show' ? 'readonly' : ''); ?>

                            required
                        >
                    </div>
                </div>
            </div>

            <!-- Estado -->
            <div class="space-y-4">
                <h3 class="text-lg font-medium text-secondary-900">Estado</h3>
                <div class="flex items-center">
                    <div class="flex items-center h-5">
                        <input
                            type="checkbox"
                            name="activo"
                            id="activo"
                            class="w-4 h-4 text-primary-600 bg-white border-secondary-300 rounded focus:ring-primary-500 focus:ring-2"
                            <?php echo e($alumnoData['activo'] ? 'checked' : ''); ?>

                            <?php echo e($modo == 'show' ? 'disabled' : ''); ?>

                        >
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
                <?php if($modo != 'show'): ?>
                <button type="submit" class="inline-flex items-center px-6 py-2 bg-primary-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <?php echo e($modo == 'create' ? 'Crear Alumno' : 'Actualizar Alumno'); ?>

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
        const requiredInputs = form.querySelectorAll('input[required], select[required]');

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

        // Formateo automático de número de teléfono
        const phoneInput = document.getElementById('telefono_contacto');
        if (phoneInput && !phoneInput.readOnly) {
            phoneInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length >= 3) {
                    value = value.replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
                }
                e.target.value = value;
            });
        }

        // Validación de edad basada en fecha de nacimiento
        const fechaNacimientoInput = document.getElementById('fecha_nacimiento');
        if (fechaNacimientoInput && !fechaNacimientoInput.readOnly) {
            fechaNacimientoInput.addEventListener('change', function(e) {
                const fechaNacimiento = new Date(e.target.value);
                const hoy = new Date();
                let edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
                const mes = hoy.getMonth() - fechaNacimiento.getMonth();
                
                if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNacimiento.getDate())) {
                    edad--;
                }

                // Validar que la edad esté entre 3 y 18 años (rango típico escolar)
                if (edad < 3 || edad > 18) {
                    alert('Por favor, verifique la fecha de nacimiento. La edad del alumno debe estar entre 3 y 18 años.');
                    e.target.focus();
                }
            });
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
                        alert('Formulario de Alumno simulado enviado.'); // Feedback visual
                    }, 2000);
                } else {
                    alert('Por favor, complete todos los campos obligatorios.');
                }
            });
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\rican\OneDrive\Documentos\workana\Fondo Solidario\resources\views\livewire\alumnos\form.blade.php ENDPATH**/ ?>