@php
    $prestador_id = $prestador_id ?? null;
@endphp

@extends('layouts.app')

@section('content')
<div class="mx-auto px-4">
    <!-- Header -->
    <div class="mb-8">
        <nav class="flex items-center text-sm text-secondary-500 mb-4">
            {{-- TODO: Definir la ruta correcta para el listado de prestadores --}}
            <a href="{{ route('prestadores.index') }}" class="hover:text-secondary-700">Prestadores</a>
            <svg class="mx-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-secondary-900">{{ $modo == 'create' ? 'Nuevo Prestador' : ($modo == 'edit' ? 'Editar Prestador' : 'Detalles de Prestador') }}</span>
        </nav>
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-secondary-900">
                    {{ $modo == 'create' ? 'Nuevo Prestador' : ($modo == 'edit' ? 'Editar Prestador' : 'Detalles de Prestador') }}
                </h1>
                <p class="mt-1 text-sm text-secondary-600">
                    {{ $modo == 'create' ? 'Complete los datos para registrar un nuevo prestador médico' : ($modo == 'edit' ? 'Modifique los datos del prestador' : 'Información detallada del prestador médico') }}
                </p>
            </div>
            @if($modo == 'show')
            <div class="flex space-x-3">
                {{-- TODO: Definir la ruta correcta para editar prestador --}}
                <a href="{{ route('prestadores.edit', $prestador_id ?? 1) }}" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
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
        <form action="{{ $modo == 'create' ? route('prestadores.index') : route('prestadores.index') }}" method="POST" class="space-y-6 p-6">
            @csrf
            @if($modo == 'edit')
                @method('PUT')
            @endif

            <!-- Información Básica -->
            <div class="border-b border-secondary-200 pb-6">
                <h3 class="text-lg font-medium text-secondary-900 mb-4">Información Básica</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nombre del Prestador -->
                    <div class="md:col-span-2 space-y-1">
                        <label for="nombre" class="block text-sm font-medium text-secondary-700">
                            Nombre del Prestador <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="nombre"
                            id="nombre"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            placeholder="Ej: Hospital San Roque"
                            value="{{ $prestador_id ?? '' == 1 ? 'Hospital San Roque' : ($prestador_id ?? '' == 2 ? 'Clínica Privada Vélez Sarsfield' : ($prestador_id ?? '' == 3 ? 'Dr. Carlos Mendez' : '')) }}"
                            {{ $modo == 'show' ? 'readonly' : '' }}
                            required
                        >
                    </div>

                    <!-- Tipo de Prestador -->
                    <div class="space-y-1">
                        <label for="tipo_prestador" class="block text-sm font-medium text-secondary-700">
                            Tipo de Prestador <span class="text-danger-500">*</span>
                        </label>
                        <select
                            name="tipo_prestador"
                            id="tipo_prestador"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            {{ $modo == 'show' ? 'disabled' : '' }}
                            required
                        >
                            <option value="">Seleccione un tipo</option>
                            <option value="hospital" {{ ($prestador_id ?? '' == 1) ? 'selected' : '' }}>Hospital</option>
                            <option value="clinica" {{ ($prestador_id ?? '' == 2) ? 'selected' : '' }}>Clínica</option>
                            <option value="medico" {{ ($prestador_id ?? '' == 3) ? 'selected' : '' }}>Médico</option>
                            <option value="farmacia">Farmacia</option>
                            <option value="laboratorio">Laboratorio</option>
                            <option value="centro_medico">Centro Médico</option>
                            <option value="consultorio">Consultorio</option>
                        </select>
                    </div>

                    <!-- Sistema de Emergencias -->
                    <div class="space-y-1">
                        <label for="es_sistema_emergencias" class="block text-sm font-medium text-secondary-700">
                            Sistema de Emergencias
                        </label>
                        <div class="flex items-center">
                            <div class="flex items-center h-5">
                                <input
                                    type="checkbox"
                                    name="es_sistema_emergencias"
                                    id="es_sistema_emergencias"
                                    class="w-4 h-4 text-primary-600 bg-white border-secondary-300 rounded focus:ring-primary-500 focus:ring-2"
                                    {{ ($prestador_id ?? '' == 1) ? 'checked' : '' }}
                                    {{ $modo == 'show' ? 'disabled' : '' }}
                                >
                            </div>
                            <div class="ml-3">
                                <label for="es_sistema_emergencias" class="text-sm text-secondary-700">
                                    Es parte del Sistema de Emergencias y Urgencias médicas
                                </label>
                                <p class="text-xs text-secondary-500">Marque si este prestador forma parte del sistema de emergencias del Fondo Solidario</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información de Contacto -->
            <div class="border-b border-secondary-200 pb-6">
                <h3 class="text-lg font-medium text-secondary-900 mb-4">Información de Contacto</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                            placeholder="Ej: Av. Vélez Sarsfield 562, Córdoba"
                            value="{{ $prestador_id ?? '' == 1 ? 'Av. Vélez Sarsfield 562, Córdoba' : ($prestador_id ?? '' == 2 ? 'Colón 1538, Córdoba' : ($prestador_id ?? '' == 3 ? 'Independencia 1425, Consultorio 3B, Córdoba' : '')) }}"
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
                            placeholder="Ej: (351) 421-7000"
                            value="{{ $prestador_id ?? '' == 1 ? '(351) 421-7000' : ($prestador_id ?? '' == 2 ? '(351) 424-9600' : ($prestador_id ?? '' == 3 ? '(351) 156-789123' : '')) }}"
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
                            placeholder="Ej: info@prestador.com.ar"
                            value="{{ $prestador_id ?? '' == 1 ? 'info@sanroque.com.ar' : ($prestador_id ?? '' == 2 ? 'recepcion@velezs.com.ar' : ($prestador_id ?? '' == 3 ? 'dr.mendez@gmail.com' : '')) }}"
                            {{ $modo == 'show' ? 'readonly' : '' }}
                            required
                        >
                    </div>
                </div>
            </div>

            <!-- Especialidades Médicas -->
            <div class="border-b border-secondary-200 pb-6">
                <h3 class="text-lg font-medium text-secondary-900 mb-4">Especialidades Médicas</h3>
                <div class="space-y-4">
                    <!-- Especialidades -->
                    <div class="space-y-1">
                        <label for="especialidades" class="block text-sm font-medium text-secondary-700">
                            Especialidades <span class="text-danger-500">*</span>
                        </label>
                        <textarea
                            name="especialidades"
                            id="especialidades"
                            rows="4"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            placeholder="Ej: Cardiología, Neurología, Pediatría, Traumatología"
                            {{ $modo == 'show' ? 'readonly' : '' }}
                            required
                        >{{ $prestador_id ?? '' == 1 ? 'Cardiología, Neurología, Pediatría, Traumatología, Medicina General, Cirugía' : ($prestador_id ?? '' == 2 ? 'Medicina General, Ginecología, Oftalmología, Dermatología' : ($prestador_id ?? '' == 3 ? 'Pediatría, Medicina del Deporte' : '')) }}</textarea>
                        <p class="text-xs text-secondary-500">Separe las especialidades con comas. Ej: Cardiología, Neurología, Pediatría</p>
                    </div>

                    <!-- Especialidades Comunes (Checkboxes) -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-secondary-700">
                            Especialidades Comunes (Selección Rápida)
                        </label>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                            <div class="flex items-center">
                                <input type="checkbox" id="esp_medicina_general" class="w-4 h-4 text-primary-600 border-secondary-300 rounded focus:ring-primary-500" {{ $modo == 'show' ? 'disabled' : '' }}>
                                <label for="esp_medicina_general" class="ml-2 text-sm text-secondary-700">Medicina General</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="esp_pediatria" class="w-4 h-4 text-primary-600 border-secondary-300 rounded focus:ring-primary-500" {{ ($prestador_id ?? '' == 1 || $prestador_id ?? '' == 3) ? 'checked' : '' }} {{ $modo == 'show' ? 'disabled' : '' }}>
                                <label for="esp_pediatria" class="ml-2 text-sm text-secondary-700">Pediatría</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="esp_cardiologia" class="w-4 h-4 text-primary-600 border-secondary-300 rounded focus:ring-primary-500" {{ ($prestador_id ?? '' == 1) ? 'checked' : '' }} {{ $modo == 'show' ? 'disabled' : '' }}>
                                <label for="esp_cardiologia" class="ml-2 text-sm text-secondary-700">Cardiología</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="esp_neurologia" class="w-4 h-4 text-primary-600 border-secondary-300 rounded focus:ring-primary-500" {{ ($prestador_id ?? '' == 1) ? 'checked' : '' }} {{ $modo == 'show' ? 'disabled' : '' }}>
                                <label for="esp_neurologia" class="ml-2 text-sm text-secondary-700">Neurología</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="esp_traumatologia" class="w-4 h-4 text-primary-600 border-secondary-300 rounded focus:ring-primary-500" {{ ($prestador_id ?? '' == 1) ? 'checked' : '' }} {{ $modo == 'show' ? 'disabled' : '' }}>
                                <label for="esp_traumatologia" class="ml-2 text-sm text-secondary-700">Traumatología</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="esp_ginecologia" class="w-4 h-4 text-primary-600 border-secondary-300 rounded focus:ring-primary-500" {{ ($prestador_id ?? '' == 2) ? 'checked' : '' }} {{ $modo == 'show' ? 'disabled' : '' }}>
                                <label for="esp_ginecologia" class="ml-2 text-sm text-secondary-700">Ginecología</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="esp_oftalmologia" class="w-4 h-4 text-primary-600 border-secondary-300 rounded focus:ring-primary-500" {{ ($prestador_id ?? '' == 2) ? 'checked' : '' }} {{ $modo == 'show' ? 'disabled' : '' }}>
                                <label for="esp_oftalmologia" class="ml-2 text-sm text-secondary-700">Oftalmología</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="esp_dermatologia" class="w-4 h-4 text-primary-600 border-secondary-300 rounded focus:ring-primary-500" {{ $modo == 'show' ? 'disabled' : '' }}>
                                <label for="esp_dermatologia" class="ml-2 text-sm text-secondary-700">Dermatología</label>
                            </div>
                        </div>
                        <p class="text-xs text-secondary-500">Marque las especialidades aplicables. Estas se agregarán automáticamente al campo de especialidades arriba.</p>
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
                            {{ ($modo == 'create' || ($prestador_id ?? '' == 1 || $prestador_id ?? '' == 2) && $modo != 'create') ? 'checked' : '' }}
                            {{ $modo == 'show' ? 'disabled' : '' }}
                        >
                    </div>
                    <div class="ml-3">
                        <label for="activo" class="text-sm font-medium text-secondary-700">
                            Prestador Activo
                        </label>
                        <p class="text-xs text-secondary-500">Indica si el prestador se encuentra disponible para derivaciones</p>
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="flex items-center justify-between pt-6 border-t border-secondary-200">
                {{-- TODO: Definir la ruta correcta para el listado de prestadores --}}
                <a href="{{ route('prestadores.index') }}" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
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
                    {{ $modo == 'create' ? 'Crear Prestador' : 'Actualizar Prestador' }}
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

        // Gestión de especialidades - Checkboxes a textarea
        const especialidadesTextarea = document.getElementById('especialidades');
        const checkboxes = document.querySelectorAll('input[type="checkbox"][id^="esp_"]');
        
        if (especialidadesTextarea && !especialidadesTextarea.readOnly) {
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateEspecialidadesFromCheckboxes();
                });
            });

            function updateEspecialidadesFromCheckboxes() {
                const selectedEspecialidades = [];
                checkboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        const label = document.querySelector(`label[for="${checkbox.id}"]`);
                        if (label) {
                            selectedEspecialidades.push(label.textContent.trim());
                        }
                    }
                });
                
                // Mantener especialidades escritas manualmente que no están en los checkboxes
                const currentText = especialidadesTextarea.value;
                const manualEspecialidades = currentText.split(',').map(esp => esp.trim()).filter(esp => {
                    return esp && !selectedEspecialidades.some(selected => 
                        selected.toLowerCase() === esp.toLowerCase()
                    );
                });
                
                // Combinar especialidades
                const allEspecialidades = [...selectedEspecialidades, ...manualEspecialidades];
                especialidadesTextarea.value = allEspecialidades.join(', ');
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
                        alert('Formulario de Prestador simulado enviado.'); // Feedback visual
                    }, 2000);
                } else {
                    alert('Por favor, complete todos los campos obligatorios.');
                }
            });
        }
    });
</script>
@endpush