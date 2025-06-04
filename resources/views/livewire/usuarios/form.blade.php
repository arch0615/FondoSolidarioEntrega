@extends('layouts.app')

@section('content')
<div class="mx-auto px-4">
    <!-- Header -->
    <div class="mb-8">
        <nav class="flex items-center text-sm text-secondary-500 mb-4">
            {{-- TODO: Definir la ruta correcta para el listado de usuarios --}}
            <a href="{{ route('usuarios.index') }}" class="hover:text-secondary-700">Usuarios</a>
            <svg class="mx-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-secondary-900">{{ $modo == 'create' ? 'Nuevo Usuario' : ($modo == 'edit' ? 'Editar Usuario' : 'Detalles de Usuario') }}</span>
        </nav>
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-secondary-900">
                    {{ $modo == 'create' ? 'Nuevo Usuario' : ($modo == 'edit' ? 'Editar Usuario' : 'Detalles de Usuario') }}
                </h1>
                <p class="mt-1 text-sm text-secondary-600">
                    {{ $modo == 'create' ? 'Complete los datos para registrar un nuevo usuario' : ($modo == 'edit' ? 'Modifique los datos del usuario' : 'Información detallada del usuario') }}
                </p>
            </div>
            @if($modo == 'show')
            <div class="flex space-x-3">
                {{-- TODO: Definir la ruta correcta para editar usuario --}}
                <a href="{{ route('usuarios.edit', $usuario_id ?? 1) }}" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
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
        <form action="{{ $modo == 'create' ? route('usuarios.index') : route('usuarios.index') }}" method="POST" class="space-y-6 p-6">
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
                            placeholder="Ej: Ana"
                            value="{{ $usuario_id ?? '' == 1 ? 'Ana' : ($usuario_id ?? '' == 2 ? 'Carlos' : ($usuario_id ?? '' == 3 ? 'Luis' : '')) }}"
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
                            placeholder="Ej: López"
                            value="{{ $usuario_id ?? '' == 1 ? 'López' : ($usuario_id ?? '' == 2 ? 'Ruiz' : ($usuario_id ?? '' == 3 ? 'Martínez' : '')) }}"
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
                            placeholder="Ej: usuario@escuela.edu.ar"
                            value="{{ $usuario_id ?? '' == 1 ? 'ana.lopez@sanmartin.edu.ar' : ($usuario_id ?? '' == 2 ? 'carlos.ruiz@admin.jaec.org' : ($usuario_id ?? '' == 3 ? 'dr.martinez@medico.jaec.org' : '')) }}"
                            {{ $modo == 'show' ? 'readonly' : '' }}
                            required
                        >
                    </div>

                    <!-- Contraseña (solo para create y edit) -->
                    @if($modo != 'show')
                    <div class="space-y-1">
                        <label for="password" class="block text-sm font-medium text-secondary-700">
                            Contraseña {{ $modo == 'create' ? '*' : '' }}
                        </label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                            placeholder="{{ $modo == 'create' ? 'Ingrese una contraseña segura' : 'Dejar vacío para mantener la actual' }}"
                            {{ $modo == 'create' ? 'required' : '' }}
                        >
                        @if($modo == 'edit')
                        <p class="text-xs text-secondary-500">Dejar vacío para mantener la contraseña actual</p>
                        @endif
                    </div>

                    <!-- Confirmar Contraseña (solo para create) -->
                    @if($modo == 'create')
                    <div class="space-y-1">
                        <label for="password_confirmation" class="block text-sm font-medium text-secondary-700">
                            Confirmar Contraseña <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                            placeholder="Confirme la contraseña"
                            required
                        >
                    </div>
                    @endif
                    @endif
                </div>
            </div>

            <!-- Información del Sistema -->
            <div class="border-b border-secondary-200 pb-6">
                <h3 class="text-lg font-medium text-secondary-900 mb-4">Información del Sistema</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Rol -->
                    <div class="space-y-1">
                        <label for="id_rol" class="block text-sm font-medium text-secondary-700">
                            Rol <span class="text-danger-500">*</span>
                        </label>
                        {{-- TODO: Implementar selección de rol dinámica --}}
                        <select
                            name="id_rol"
                            id="id_rol"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            {{ $modo == 'show' ? 'disabled' : '' }}
                            required
                        >
                            <option value="">Seleccione un rol</option>
                            <option value="1" {{ ($usuario_id ?? '' == 1) ? 'selected' : '' }}>Usuario General</option>
                            <option value="2" {{ ($usuario_id ?? '' == 2) ? 'selected' : '' }}>Administrador</option>
                            <option value="3" {{ ($usuario_id ?? '' == 3) ? 'selected' : '' }}>Médico Auditor</option>
                        </select>
                    </div>

                    <!-- Escuela -->
                    <div class="space-y-1">
                        <label for="id_escuela" class="block text-sm font-medium text-secondary-700">
                            Escuela
                        </label>
                        {{-- TODO: Implementar selección de escuela dinámica --}}
                        <select
                            name="id_escuela"
                            id="id_escuela"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            {{ $modo == 'show' ? 'disabled' : '' }}
                        >
                            <option value="">Seleccione una escuela (opcional para Admin/Médico)</option>
                            <option value="1" {{ ($usuario_id ?? '' == 1) ? 'selected' : '' }}>Colegio San Martín</option>
                            <option value="2">Instituto Belgrano</option>
                            <option value="3">Escuela Santa María</option>
                        </select>
                        <p class="text-xs text-secondary-500">Los usuarios Administrador y Médico Auditor no requieren escuela asignada</p>
                    </div>

                    @if($modo == 'show')
                    <!-- Fecha de Registro (solo en vista) -->
                    <div class="space-y-1">
                        <label for="fecha_registro" class="block text-sm font-medium text-secondary-700">
                            Fecha de Registro
                        </label>
                        <input
                            type="text"
                            name="fecha_registro"
                            id="fecha_registro"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm bg-secondary-50"
                            value="{{ $usuario_id ?? '' == 1 ? '15/03/2024' : ($usuario_id ?? '' == 2 ? '01/01/2024' : ($usuario_id ?? '' == 3 ? '20/02/2024' : '')) }}"
                            readonly
                        >
                    </div>

                    <!-- Token de Verificación (solo en vista para debug) -->
                    @if(($usuario_id ?? '' == 3))
                    <div class="space-y-1">
                        <label for="token_verificacion" class="block text-sm font-medium text-secondary-700">
                            Token de Verificación
                        </label>
                        <input
                            type="text"
                            name="token_verificacion"
                            id="token_verificacion"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm bg-secondary-50 font-mono text-xs"
                            value="abc123xyz789token"
                            readonly
                        >
                        <p class="text-xs text-secondary-500">Token pendiente de verificación</p>
                    </div>
                    @endif
                    @endif
                </div>
            </div>

            <!-- Estado y Verificación -->
            <div class="space-y-4">
                <h3 class="text-lg font-medium text-secondary-900">Estado y Verificación</h3>
                
                <!-- Estado Activo -->
                <div class="flex items-center">
                    <div class="flex items-center h-5">
                        <input
                            type="checkbox"
                            name="activo"
                            id="activo"
                            class="w-4 h-4 text-primary-600 bg-white border-secondary-300 rounded focus:ring-primary-500 focus:ring-2"
                            {{ ($modo == 'create' || ($usuario_id ?? '' != 3 && $modo != 'create')) ? 'checked' : '' }}
                            {{ $modo == 'show' ? 'disabled' : '' }}
                        >
                    </div>
                    <div class="ml-3">
                        <label for="activo" class="text-sm font-medium text-secondary-700">
                            Usuario Activo
                        </label>
                        <p class="text-xs text-secondary-500">Indica si el usuario puede acceder al sistema</p>
                    </div>
                </div>

                <!-- Email Verificado -->
                <div class="flex items-center">
                    <div class="flex items-center h-5">
                        <input
                            type="checkbox"
                            name="email_verificado"
                            id="email_verificado"
                            class="w-4 h-4 text-primary-600 bg-white border-secondary-300 rounded focus:ring-primary-500 focus:ring-2"
                            {{ ($usuario_id ?? '' != 3) ? 'checked' : '' }}
                            {{ $modo == 'show' ? 'disabled' : '' }}
                        >
                    </div>
                    <div class="ml-3">
                        <label for="email_verificado" class="text-sm font-medium text-secondary-700">
                            Email Verificado
                        </label>
                        <p class="text-xs text-secondary-500">Indica si el usuario ha verificado su correo electrónico</p>
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="flex items-center justify-between pt-6 border-t border-secondary-200">
                {{-- TODO: Definir la ruta correcta para el listado de usuarios --}}
                <a href="{{ route('usuarios.index') }}" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver al Listado
                </a>
                @if($modo != 'show')
                <div class="flex space-x-3">
                    @if($modo == 'edit' && ($usuario_id ?? '' == 3))
                    <!-- Botón para reenviar verificación -->
                    <button type="button" class="inline-flex items-center px-4 py-2 bg-secondary-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-secondary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-500 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Reenviar Verificación
                    </button>
                    @endif
                    <button type="submit" class="inline-flex items-center px-6 py-2 bg-primary-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        {{ $modo == 'create' ? 'Crear Usuario' : 'Actualizar Usuario' }}
                    </button>
                </div>
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

        // Validación de contraseñas coincidentes
        const passwordInput = document.getElementById('password');
        const passwordConfirmationInput = document.getElementById('password_confirmation');
        
        if (passwordInput && passwordConfirmationInput) {
            function validatePasswordMatch() {
                const password = passwordInput.value;
                const confirmation = passwordConfirmationInput.value;
                
                if (confirmation && password !== confirmation) {
                    passwordConfirmationInput.classList.add('border-danger-300', 'focus:border-danger-500', 'focus:ring-danger-500');
                    passwordConfirmationInput.classList.remove('border-success-300');
                } else if (confirmation) {
                    passwordConfirmationInput.classList.remove('border-danger-300', 'focus:border-danger-500', 'focus:ring-danger-500');
                    passwordConfirmationInput.classList.add('border-success-300');
                }
            }

            passwordInput.addEventListener('input', validatePasswordMatch);
            passwordConfirmationInput.addEventListener('input', validatePasswordMatch);
        }

        // Lógica para mostrar/ocultar escuela según rol
        const rolSelect = document.getElementById('id_rol');
        const escuelaSelect = document.getElementById('id_escuela');
        const escuelaContainer = escuelaSelect.closest('.space-y-1');
        
        function toggleEscuelaField() {
            const rolValue = rolSelect.value;
            // Rol 1 = Usuario General (requiere escuela)
            // Rol 2 = Administrador (no requiere escuela)
            // Rol 3 = Médico Auditor (no requiere escuela)
            
            if (rolValue === '1') {
                escuelaContainer.style.display = 'block';
                escuelaSelect.required = true;
            } else {
                escuelaContainer.style.display = 'block'; // Mantener visible pero opcional
                escuelaSelect.required = false;
                escuelaSelect.value = ''; // Limpiar selección
            }
        }
        
        if (rolSelect && escuelaSelect) {
            rolSelect.addEventListener('change', toggleEscuelaField);
            // Ejecutar al cargar la página
            toggleEscuelaField();
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

                // Validar coincidencia de contraseñas
                if (passwordInput && passwordConfirmationInput) {
                    if (passwordInput.value !== passwordConfirmationInput.value) {
                        formIsValid = false;
                        alert('Las contraseñas no coinciden.');
                        return;
                    }
                }

                if (formIsValid) {
                    submitButton.classList.add('opacity-75');
                    submitButton.disabled = true;

                    // Simular procesamiento (en producción esto sería manejado por el servidor)
                    setTimeout(() => {
                        submitButton.classList.remove('opacity-75');
                        submitButton.disabled = false;
                        alert('Formulario de Usuario simulado enviado.'); // Feedback visual
                    }, 2000);
                } else {
                    alert('Por favor, complete todos los campos obligatorios.');
                }
            });
        }

        // Botón de reenvío de verificación
        const reenviarBtn = document.querySelector('button[type="button"]');
        if (reenviarBtn && reenviarBtn.textContent.includes('Reenviar')) {
            reenviarBtn.addEventListener('click', function() {
                this.classList.add('opacity-75');
                this.disabled = true;
                
                setTimeout(() => {
                    this.classList.remove('opacity-75');
                    this.disabled = false;
                    alert('Email de verificación reenviado exitosamente.');
                }, 1500);
            });
        }
    });
</script>
@endpush