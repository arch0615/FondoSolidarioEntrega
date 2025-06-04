@extends('layouts.app')

@section('content')
<div class="mx-auto px-4">
    <!-- Header -->
    <div class="mb-8">
        <nav class="flex items-center text-sm text-secondary-500 mb-4">
            {{-- TODO: Definir la ruta correcta para el listado de empleados --}}
            <a href="{{ route('empleados.index') }}" class="hover:text-secondary-700">Empleados</a>
            <svg class="mx-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-secondary-900">{{ $modo == 'create' ? 'Nuevo Empleado' : ($modo == 'edit' ? 'Editar Empleado' : 'Detalles de Empleado') }}</span>
        </nav>
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-secondary-900">
                    {{ $modo == 'create' ? 'Nuevo Empleado' : ($modo == 'edit' ? 'Editar Empleado' : 'Detalles de Empleado') }}
                </h1>
                <p class="mt-1 text-sm text-secondary-600">
                    {{ $modo == 'create' ? 'Complete los datos para registrar un nuevo empleado' : ($modo == 'edit' ? 'Modifique los datos del empleado' : 'Información detallada del empleado') }}
                </p>
            </div>
            @if($modo == 'show')
            <div class="flex space-x-3">
                {{-- TODO: Definir la ruta correcta para editar empleado --}}
                <a href="{{ route('empleados.edit', $empleado_id ?? 1) }}" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Editar
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- Formulario -->
    <div class="bg-white rounded-xl border border-secondary-200">
        {{-- TODO: Definir la acción y método correctos del formulario --}}
        <form action="{{ $modo == 'create' ? route('empleados.index') : route('empleados.index') }}" method="POST" class="space-y-6 p-6">
            @csrf
            @if($modo == 'edit')
                @method('PUT')
            @endif

            <!-- Información Personal -->
            <div class="border-b border-secondary-200 pb-6">
                <h3 class="text-lg font-medium text-secondary-900 mb-4">Información Personal</h3>
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
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            placeholder="Ej: Juan"
                            value="{{ $empleado_id ?? '' == 1 ? 'Juan' : ($empleado_id ?? '' == 2 ? 'María' : '') }}"
                            {{ $modo == 'show' ? 'readonly' : '' }}
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
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            placeholder="Ej: Pérez"
                            value="{{ $empleado_id ?? '' == 1 ? 'Pérez' : ($empleado_id ?? '' == 2 ? 'García' : '') }}"
                            {{ $modo == 'show' ? 'readonly' : '' }}
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
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            placeholder="Ej: 12345678"
                            value="{{ $empleado_id ?? '' == 1 ? '12345678' : ($empleado_id ?? '' == 2 ? '87654321' : '') }}"
                            {{ $modo == 'show' ? 'readonly' : '' }}
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
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            placeholder="Ej: 20-12345678-9"
                            value="{{ $empleado_id ?? '' == 1 ? '20-12345678-9' : ($empleado_id ?? '' == 2 ? '27-87654321-2' : '') }}"
                            {{ $modo == 'show' ? 'readonly' : '' }}
                            required
                        >
                    </div>

                     <!-- Teléfono -->
                    <div class="space-y-1">
                        <label for="telefono" class="block text-sm font-medium text-secondary-700">
                            Teléfono <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="tel"
                            name="telefono"
                            id="telefono"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            placeholder="Ej: (351) 425-6789"
                            value="{{ $empleado_id ?? '' == 1 ? '(351) 111-2222' : ($empleado_id ?? '' == 2 ? '(351) 333-4444' : '') }}"
                            {{ $modo == 'show' ? 'readonly' : '' }}
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
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            placeholder="Ej: juan.perez@escuela.edu.ar"
                            value="{{ $empleado_id ?? '' == 1 ? 'juan.perez@sanmartin.edu.ar' : ($empleado_id ?? '' == 2 ? 'maria.garcia@belgrano.edu.ar' : '') }}"
                            {{ $modo == 'show' ? 'readonly' : '' }}
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
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            placeholder="Ej: Calle Falsa 123, Córdoba"
                            value="{{ $empleado_id ?? '' == 1 ? 'Av. Siempre Viva 742, Córdoba' : ($empleado_id ?? '' == 2 ? 'Calle Falsa 123, Córdoba' : '') }}"
                            {{ $modo == 'show' ? 'readonly' : '' }}
                            required
                        >
                    </div>
                </div>
            </div>

            <!-- Información Laboral -->
            <div class="border-b border-secondary-200 pb-6">
                <h3 class="text-lg font-medium text-secondary-900 mb-4">Información Laboral</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Escuela -->
                    <div class="space-y-1">
                        <label for="id_escuela" class="block text-sm font-medium text-secondary-700">
                            Escuela <span class="text-danger-500">*</span>
                        </label>
                        {{-- TODO: Implementar selección de escuela dinámica --}}
                        <select
                            name="id_escuela"
                            id="id_escuela"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            {{ $modo == 'show' ? 'disabled' : '' }}
                            required
                        >
                            <option value="">Seleccione una escuela</option>
                            {{-- Opciones de escuelas --}}
                             <option value="1" {{ ($empleado_id ?? '' == 1) ? 'selected' : '' }}>Colegio San Martín</option>
                             <option value="2" {{ ($empleado_id ?? '' == 2) ? 'selected' : '' }}>Instituto Belgrano</option>
                        </select>
                    </div>

                    <!-- Cargo -->
                    <div class="space-y-1">
                        <label for="cargo" class="block text-sm font-medium text-secondary-700">
                            Cargo <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="cargo"
                            id="cargo"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            placeholder="Ej: Docente de Matemáticas"
                            value="{{ $empleado_id ?? '' == 1 ? 'Docente' : ($empleado_id ?? '' == 2 ? 'Preceptora' : '') }}"
                            {{ $modo == 'show' ? 'readonly' : '' }}
                            required
                        >
                    </div>

                    <!-- Fecha de Ingreso -->
                    <div class="space-y-1">
                        <label for="fecha_ingreso" class="block text-sm font-medium text-secondary-700">
                            Fecha de Ingreso <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="date"
                            name="fecha_ingreso"
                            id="fecha_ingreso"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            value="{{ $empleado_id ?? '' == 1 ? '2020-03-01' : ($empleado_id ?? '' == 2 ? '2018-08-15' : '') }}"
                            {{ $modo == 'show' ? 'readonly' : '' }}
                            required
                        >
                    </div>

                    <!-- Fecha de Egreso -->
                    <div class="space-y-1">
                        <label for="fecha_egreso" class="block text-sm font-medium text-secondary-700">
                            Fecha de Egreso
                        </label>
                        <input
                            type="date"
                            name="fecha_egreso"
                            id="fecha_egreso"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            value="{{ $empleado_id ?? '' == 2 ? '2024-01-31' : '' }}"
                            {{ $modo == 'show' ? 'readonly' : '' }}
                        >
                         <p class="text-xs text-secondary-500">Dejar vacío si el empleado sigue activo</p>
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
                            {{ ($modo == 'create' || ($empleado_id ?? '' == 1 && $modo != 'create')) ? 'checked' : '' }}
                            {{ $modo == 'show' ? 'disabled' : '' }}
                        >
                    </div>
                    <div class="ml-3">
                        <label for="activo" class="text-sm font-medium text-secondary-700">
                            Empleado Activo
                        </label>
                        <p class="text-xs text-secondary-500">Indica si el empleado se encuentra activo en la escuela</p>
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="flex items-center justify-between pt-6 border-t border-secondary-200">
                {{-- TODO: Definir la ruta correcta para el listado de empleados --}}
                <a href="{{ route('empleados.index') }}" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver al Listado
                </a>
                @if($modo != 'show')
                <button type="submit" class="inline-flex items-center px-6 py-2 bg-primary-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ $modo == 'create' ? 'Crear Empleado' : 'Actualizar Empleado' }}
                </button>
                @endif
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
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
                        alert('Formulario de Empleado simulado enviado.'); // Feedback visual
                    }, 2000);
                } else {
                    alert('Por favor, complete todos los campos obligatorios.');
                }
            });
        }
    });
</script>
@endpush