@extends('layouts.app')

@section('content')
<div class="mx-auto px-4">
    <!-- Header -->
    <div class="mb-8">
        <nav class="flex items-center text-sm text-secondary-500 mb-4">
            {{-- TODO: Definir la ruta correcta para el listado de beneficiarios SVO --}}
            <a href="{{ route('beneficiarios_svo.index') }}" class="hover:text-secondary-700">Beneficiarios SVO</a>
            <svg class="mx-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-secondary-900">{{ $modo == 'create' ? 'Nuevo Beneficiario SVO' : ($modo == 'edit' ? 'Editar Beneficiario SVO' : 'Detalles de Beneficiario SVO') }}</span>
        </nav>
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-secondary-900">
                    {{ $modo == 'create' ? 'Nuevo Beneficiario SVO' : ($modo == 'edit' ? 'Editar Beneficiario SVO' : 'Detalles de Beneficiario SVO') }}
                </h1>
                <p class="mt-1 text-sm text-secondary-600">
                    {{ $modo == 'create' ? 'Complete los datos para registrar un nuevo beneficiario SVO' : ($modo == 'edit' ? 'Modifique los datos del beneficiario SVO' : 'Información detallada del beneficiario SVO') }}
                </p>
            </div>
            @if($modo == 'show')
            <div class="flex space-x-3">
                {{-- TODO: Definir la ruta correcta para editar beneficiario SVO --}}
                <a href="{{ isset($beneficiario_id) ? route('beneficiarios_svo.edit', $beneficiario_id) : '#' }}" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
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
        <form action="{{ $modo == 'create' ? route('beneficiarios_svo.index') : route('beneficiarios_svo.index') }}" method="POST" class="space-y-6 p-6">
            @csrf
            @if($modo == 'edit')
                @method('PUT')
            @endif

            <!-- Información del Beneficiario -->
            <div class="border-b border-secondary-200 pb-6">
                <h3 class="text-lg font-medium text-secondary-900 mb-4">Información del Beneficiario</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Escuela -->
                    <div class="md:col-span-2 space-y-1">
                        <label for="id_escuela" class="block text-sm font-medium text-secondary-700">
                            Escuela <span class="text-danger-500">*</span>
                        </label>
                        {{--
                            Lógica a implementar:
                            - Si Auth::user()->rol es 'usuario_general', preseleccionar su escuela y deshabilitar.
                            - Si Auth::user()->rol es 'admin' (y $modo == 'show'), mostrar la escuela del beneficiario y deshabilitar.
                            - El select de empleados debería filtrarse por esta escuela.
                        --}}
                        <select
                            name="id_escuela"
                            id="id_escuela"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ ($modo == 'show' || (Auth::check() && Auth::user()->rol === 'usuario_general')) ? 'bg-secondary-50' : 'bg-white' }}"
                            {{ ($modo == 'show' || (Auth::check() && Auth::user()->rol === 'usuario_general')) ? 'disabled' : '' }}
                            required
                        >
                            <option value="">Seleccione una escuela</option>
                            {{-- Ejemplo de opciones, se deben cargar dinámicamente --}}
                            <option value="1" {{ (isset($beneficiario_id) && ($beneficiario_id == 1 || $beneficiario_id == 2)) ? 'selected' : (Auth::check() && Auth::user()->id_escuela == 1 ? 'selected' : '') }}>Colegio San Martín</option>
                            <option value="2" {{ (Auth::check() && Auth::user()->id_escuela == 2 ? 'selected' : '') }}>Instituto Belgrano</option>
                            {{--  En un caso real, si es admin y modo show, se seleccionaría $beneficiario->id_escuela --}}
                        </select>
                        @if(Auth::check() && Auth::user()->rol === 'usuario_general')
                            <input type="hidden" name="id_escuela" value="{{ Auth::user()->id_escuela }}">
                        @endif
                    </div>

                    <!-- Empleado -->
                    <div class="md:col-span-2 space-y-1">
                        <label for="id_empleado" class="block text-sm font-medium text-secondary-700">
                            Empleado Titular <span class="text-danger-500">*</span>
                        </label>
                        {{-- TODO: Implementar selección de empleado dinámica, filtrada por la escuela seleccionada/del usuario --}}
                        <select
                            name="id_empleado"
                            id="id_empleado"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            {{ $modo == 'show' ? 'disabled' : '' }}
                            required
                        >
                            <option value="">Seleccione un empleado</option>
                             {{-- Ejemplo de opciones, se deben cargar dinámicamente y filtrar por escuela --}}
                             <option value="1" {{ (isset($beneficiario_id) && ($beneficiario_id == 1 || $beneficiario_id == 2)) ? 'selected' : '' }}>Juan Pérez (DNI: 12345678) - Colegio San Martín</option>
                             <option value="2">María García (DNI: 87654321) - Instituto Belgrano</option>
                        </select>
                    </div>

                    <!-- Nombre del Beneficiario -->
                    <div class="space-y-1">
                        <label for="nombre_beneficiario" class="block text-sm font-medium text-secondary-700">
                            Nombre del Beneficiario <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="nombre_beneficiario"
                            id="nombre_beneficiario"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            placeholder="Ej: Ana"
                            value="{{ old('nombre_beneficiario', (isset($beneficiario_id) && $beneficiario_id == 1 ? 'Ana' : (isset($beneficiario_id) && $beneficiario_id == 2 ? 'Luis' : ''))) }}"
                            {{ $modo == 'show' ? 'readonly' : '' }}
                            required
                        >
                    </div>

                    <!-- Apellido del Beneficiario -->
                    <div class="space-y-1">
                        <label for="apellido_beneficiario" class="block text-sm font-medium text-secondary-700">
                            Apellido del Beneficiario <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="apellido_beneficiario"
                            id="apellido_beneficiario"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            placeholder="Ej: Pérez"
                            value="{{ old('apellido_beneficiario', ((isset($beneficiario_id) && ($beneficiario_id == 1 || $beneficiario_id == 2)) ? 'Pérez' : '')) }}"
                            {{ $modo == 'show' ? 'readonly' : '' }}
                            required
                        >
                    </div>

                    <!-- DNI del Beneficiario -->
                    <div class="space-y-1">
                        <label for="dni_beneficiario" class="block text-sm font-medium text-secondary-700">
                            DNI del Beneficiario <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="dni_beneficiario"
                            id="dni_beneficiario"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            placeholder="Ej: 45678901"
                            value="{{ old('dni_beneficiario', (isset($beneficiario_id) && $beneficiario_id == 1 ? '45678901' : (isset($beneficiario_id) && $beneficiario_id == 2 ? '56789012' : ''))) }}"
                            {{ $modo == 'show' ? 'readonly' : '' }}
                            required
                        >
                    </div>

                    <!-- Parentesco -->
                    <div class="space-y-1">
                        <label for="parentesco" class="block text-sm font-medium text-secondary-700">
                            Parentesco <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="parentesco"
                            id="parentesco"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            placeholder="Ej: Cónyuge, Hijo, Padre"
                            value="{{ old('parentesco', (isset($beneficiario_id) && $beneficiario_id == 1 ? 'Cónyuge' : (isset($beneficiario_id) && $beneficiario_id == 2 ? 'Hijo' : ''))) }}"
                            {{ $modo == 'show' ? 'readonly' : '' }}
                            required
                        >
                    </div>

                    <!-- Porcentaje -->
                    <div class="space-y-1">
                        <label for="porcentaje" class="block text-sm font-medium text-secondary-700">
                            Porcentaje <span class="text-danger-500">*</span>
                        </label>
                        <div class="relative">
                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                max="100"
                                name="porcentaje"
                                id="porcentaje"
                                class="block w-full pr-10 pl-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                                placeholder="Ej: 50"
                                value="{{ old('porcentaje', ((isset($beneficiario_id) && ($beneficiario_id == 1 || $beneficiario_id == 2)) ? '50' : '')) }}"
                                {{ $modo == 'show' ? 'readonly' : '' }}
                                required
                            >
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-secondary-500 text-sm">%</span>
                            </div>
                        </div>
                         <p class="text-xs text-secondary-500">Porcentaje de la cobertura asignado a este beneficiario.</p>
                    </div>

                    @if($modo != 'create')
                    <!-- Fecha de Alta -->
                    <div class="space-y-1">
                        <label for="fecha_alta" class="block text-sm font-medium text-secondary-700">Fecha de Alta</label>
                        <input
                            type="date"
                            name="fecha_alta"
                            id="fecha_alta"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm bg-secondary-50 focus:outline-none"
                            value="{{ (isset($beneficiario_id) && ($beneficiario_id == 1 || $beneficiario_id == 2)) ? '2023-05-10' : '' }}"
                            readonly
                        >
                    </div>
                    @endif
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
                            {{ old('activo', ($modo == 'create' || (isset($beneficiario_id) && ($beneficiario_id == 1 || $beneficiario_id == 2)))) ? 'checked' : '' }}
                            {{ $modo == 'show' ? 'disabled' : '' }}
                        >
                    </div>
                    <div class="ml-3">
                        <label for="activo" class="text-sm font-medium text-secondary-700">
                            Beneficiario Activo
                        </label>
                        <p class="text-xs text-secondary-500">Indica si el beneficiario está activo para el SVO del empleado.</p>
                    </div>
                </div>
            </div>


            <!-- Botones de Acción -->
            <div class="flex items-center justify-between pt-6 border-t border-secondary-200">
                {{-- TODO: Definir la ruta correcta para el listado de beneficiarios SVO --}}
                <a href="{{ route('beneficiarios_svo.index') }}" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
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
                    {{ $modo == 'create' ? 'Crear Beneficiario' : 'Actualizar Beneficiario' }}
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
                        alert('Formulario de Beneficiario SVO simulado enviado.'); // Feedback visual
                    }, 2000);
                } else {
                    alert('Por favor, complete todos los campos obligatorios.');
                }
            });
        }
    });
</script>
@endpush