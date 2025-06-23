<div class="mx-auto px-4">
    <!-- Modal de Confirmación -->
    @if($mensaje)
        <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: true }" x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Overlay -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="show = false"></div>

                <!-- Modal -->
                <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full sm:p-6" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <div>
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full {{ $tipoMensaje === 'success' ? 'bg-green-100' : 'bg-red-100' }}">
                            @if($tipoMensaje === 'success')
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            @else
                                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            @endif
                        </div>
                        <div class="mt-3 text-center sm:mt-5">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                {{ $tipoMensaje === 'success' ? '¡Éxito!' : 'Error' }}
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">{{ $mensaje }}</p>
                                @if($modo == 'create' && $tipoMensaje === 'success')
                                    <p class="text-xs text-gray-400 mt-2">Redirigiendo al listado en 3 segundos...</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-6">
                        @if($modo == 'create')
                            <button @click="show = false" wire:click="redirigirAlListado" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 {{ $tipoMensaje === 'success' ? 'bg-green-600 hover:bg-green-700 focus:ring-green-500' : 'bg-red-600 hover:bg-red-700 focus:ring-red-500' }} text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 sm:text-sm">
                                Ir al Listado
                            </button>
                        @else
                            <button @click="show = false" wire:click="limpiarMensaje" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 {{ $tipoMensaje === 'success' ? 'bg-green-600 hover:bg-green-700 focus:ring-green-500' : 'bg-red-600 hover:bg-red-700 focus:ring-red-500' }} text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 sm:text-sm">
                                Aceptar
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Mensajes Flash (para compatibilidad) -->
    @if (session()->has('message'))
        <div class="mb-6 bg-success-50 border border-success-200 text-success-700 px-4 py-3 rounded-lg relative" role="alert">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="font-medium">{{ session('message') }}</span>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-6 bg-danger-50 border border-danger-200 text-danger-700 px-4 py-3 rounded-lg relative" role="alert">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        </div>
    @endif

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
        <form wire:submit.prevent="guardar" class="space-y-6 p-6">

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
                            wire:model="nombre"
                            type="text"
                            id="nombre"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            placeholder="Ej: Ana"
                            {{ $modo == 'show' ? 'readonly' : '' }}
                            required
                        >
                        @error('nombre') <span class="text-danger-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Apellido -->
                    <div class="space-y-1">
                        <label for="apellido" class="block text-sm font-medium text-secondary-700">
                            Apellido <span class="text-danger-500">*</span>
                        </label>
                        <input
                            wire:model="apellido"
                            type="text"
                            id="apellido"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            placeholder="Ej: López"
                            {{ $modo == 'show' ? 'readonly' : '' }}
                            required
                        >
                        @error('apellido') <span class="text-danger-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Email -->
                    <div class="space-y-1">
                        <label for="email" class="block text-sm font-medium text-secondary-700">
                            Correo Electrónico <span class="text-danger-500">*</span>
                        </label>
                        <input
                            wire:model="email"
                            type="email"
                            id="email"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            placeholder="Ej: usuario@escuela.edu.ar"
                            {{ $modo == 'show' ? 'readonly' : '' }}
                            required
                        >
                        @error('email') <span class="text-danger-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Contraseña (solo para create y edit) -->
                    @if($modo != 'show')
                    <div class="space-y-1">
                        <label for="password" class="block text-sm font-medium text-secondary-700">
                            Contraseña {{ $modo == 'create' ? '*' : '' }}
                        </label>
                        <div class="flex gap-2">
                            <input
                                wire:model="password"
                                type="password"
                                id="password"
                                class="flex-1 px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'edit' ? 'bg-secondary-50' : 'bg-white' }}"
                                placeholder="{{ $modo == 'create' ? 'Ingrese una contraseña segura' : 'Haga clic en Cambiar Contraseña para modificar' }}"
                                {{ $modo == 'create' ? 'required' : 'disabled' }}
                            >
                            @if($modo == 'edit')
                                <button
                                    type="button"
                                    id="toggle-password-btn"
                                    onclick="togglePasswordChange()"
                                    class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 whitespace-nowrap transition-colors duration-200"
                                >
                                    <span id="btn-text">Cambiar Contraseña</span>
                                </button>
                            @endif
                        </div>
                        @error('password') <span class="text-danger-500 text-sm">{{ $message }}</span> @enderror
                        @if($modo == 'edit')
                        <p class="text-xs text-secondary-500" id="password-help">Haga clic en "Cambiar Contraseña" para modificar la contraseña actual</p>
                        @endif
                    </div>

                    <!-- Confirmar Contraseña (para create o cuando se cambia password en edit) -->
                    @if($modo == 'create')
                    <div class="space-y-1">
                        <label for="password_confirmation" class="block text-sm font-medium text-secondary-700">
                            Confirmar Contraseña <span class="text-danger-500">*</span>
                        </label>
                        <input
                            wire:model="password_confirmation"
                            type="password"
                            id="password_confirmation"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                            placeholder="Confirme la contraseña"
                            required
                        >
                        @error('password_confirmation') <span class="text-danger-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    @elseif($modo == 'edit')
                    <div class="space-y-1" id="confirm-password-container" style="display: none;">
                        <label for="password_confirmation" class="block text-sm font-medium text-secondary-700">
                            Confirmar Contraseña <span class="text-danger-500">*</span>
                        </label>
                        <input
                            wire:model="password_confirmation"
                            type="password"
                            id="password_confirmation"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                            placeholder="Confirme la nueva contraseña"
                            disabled
                        >
                        @error('password_confirmation') <span class="text-danger-500 text-sm">{{ $message }}</span> @enderror
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
                            wire:model="id_rol"
                            id="id_rol"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            {{ $modo == 'show' ? 'disabled' : '' }}
                            required
                        >
                            <option value="">Seleccione un rol</option>
                            @foreach($roles as $rol)
                                <option value="{{ $rol->id_rol }}">{{ $rol->nombre_rol }}</option>
                            @endforeach
                        </select>
                        @error('id_rol') <span class="text-danger-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Escuela -->
                    <div class="space-y-1">
                        <label for="id_escuela" class="block text-sm font-medium text-secondary-700">
                            Escuela
                        </label>
                        {{-- TODO: Implementar selección de escuela dinámica --}}
                        <select
                            wire:model="id_escuela"
                            id="id_escuela"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            {{ $modo == 'show' ? 'disabled' : '' }}
                        >
                            <option value="">Seleccione una escuela (opcional para Admin/Médico)</option>
                            @foreach($escuelas as $escuela)
                                <option value="{{ $escuela->id_escuela }}">{{ $escuela->nombre }}</option>
                            @endforeach
                        </select>
                        @error('id_escuela') <span class="text-danger-500 text-sm">{{ $message }}</span> @enderror
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
                            wire:model="activo"
                            type="checkbox"
                            id="activo"
                            class="w-4 h-4 text-primary-600 bg-white border-secondary-300 rounded focus:ring-primary-500 focus:ring-2"
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

                <!-- Email Verificado (Oculto) -->
                {{--
                <div class="flex items-center">
                    <div class="flex items-center h-5">
                        <input
                            wire:model="email_verificado"
                            type="checkbox"
                            id="email_verificado"
                            class="w-4 h-4 text-primary-600 bg-white border-secondary-300 rounded focus:ring-primary-500 focus:ring-2"
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
                --}}
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

@push('scripts')
<script>
    // Variable global para controlar el estado de cambio de contraseña
    let isChangingPassword = false;

    // Manejo de modales y redirección
    document.addEventListener('livewire:init', () => {
        Livewire.on('mostrar-mensaje', () => {
            // El modal aparece automáticamente cuando $mensaje tiene valor
            console.log('Mensaje mostrado en modal - modo edición');
        });

        Livewire.on('mostrar-mensaje-y-redirigir', () => {
            // Para modo creación: mostrar modal y redirigir automáticamente después de 3 segundos
            console.log('Mensaje mostrado en modal - modo creación');
            setTimeout(() => {
                @this.call('redirigirAlListado');
            }, 3000);
        });
    });

    // Función para alternar el cambio de contraseña
    function togglePasswordChange() {
        const passwordInput = document.getElementById('password');
        const passwordConfirmationInput = document.getElementById('password_confirmation');
        const confirmationContainer = document.getElementById('confirm-password-container');
        const toggleBtn = document.getElementById('toggle-password-btn');
        const btnText = document.getElementById('btn-text');
        const helpText = document.getElementById('password-help');

        if (!isChangingPassword) {
            // Habilitar cambio de contraseña
            isChangingPassword = true;
            passwordInput.disabled = false;
            passwordInput.classList.remove('bg-secondary-50');
            passwordInput.classList.add('bg-white');
            passwordInput.placeholder = 'Ingrese la nueva contraseña';
            passwordInput.focus();
            
            // Mostrar campo de confirmación
            if (confirmationContainer) {
                confirmationContainer.style.display = 'block';
                passwordConfirmationInput.disabled = false;
            }
            
            // Cambiar botón
            btnText.textContent = 'Cancelar';
            toggleBtn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
            toggleBtn.classList.add('bg-red-600', 'hover:bg-red-700');
            
            // Cambiar texto de ayuda
            helpText.textContent = 'Ingrese una nueva contraseña segura';
            
        } else {
            // Cancelar cambio de contraseña
            isChangingPassword = false;
            passwordInput.disabled = true;
            passwordInput.classList.remove('bg-white');
            passwordInput.classList.add('bg-secondary-50');
            passwordInput.placeholder = 'Haga clic en Cambiar Contraseña para modificar';
            passwordInput.value = '';
            
            // Ocultar campo de confirmación
            if (confirmationContainer) {
                confirmationContainer.style.display = 'none';
                passwordConfirmationInput.disabled = true;
                passwordConfirmationInput.value = '';
            }
            
            // Restaurar botón
            btnText.textContent = 'Cambiar Contraseña';
            toggleBtn.classList.remove('bg-red-600', 'hover:bg-red-700');
            toggleBtn.classList.add('bg-blue-600', 'hover:bg-blue-700');
            
            // Restaurar texto de ayuda
            helpText.textContent = 'Haga clic en "Cambiar Contraseña" para modificar la contraseña actual';
            
            // Disparar eventos para Livewire
            passwordInput.dispatchEvent(new Event('input'));
            passwordConfirmationInput.dispatchEvent(new Event('input'));
        }
    }

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

        // Validación de contraseñas coincidentes (solo para modo edición cuando se está cambiando)
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

        // Animación de feedback visual y validación de envío
        const submitButton = document.querySelector('button[type="submit"]');
        if (submitButton) {
            form.addEventListener('submit', function(e) {
                    // Basic validation check before submission
                    let formIsValid = true;
                    requiredInputs.forEach(input => {
                        if (input.value.trim() === '') {
                            validateField(input); // Highlight empty required fields
                            formIsValid = false;
                        }
                    });
    
                    // Validar coincidencia de contraseñas solo si se está cambiando la contraseña
                    if (passwordInput && passwordConfirmationInput) {
                        // En modo creación, siempre validar
                        const isCreateMode = passwordInput.hasAttribute('required');
                        // En modo edición, solo validar si se está cambiando la contraseña
                        const isChangingPasswordInEdit = isChangingPassword && passwordInput.value.trim() !== '';
                        
                        if (isCreateMode || isChangingPasswordInEdit) {
                            if (passwordInput.value !== passwordConfirmationInput.value) {
                                formIsValid = false;
                                alert('Las contraseñas no coinciden.');
                                e.preventDefault();
                                return;
                            }
                            
                            if (passwordInput.value.trim() === '') {
                                formIsValid = false;
                                alert('La contraseña es obligatoria.');
                                e.preventDefault();
                                return;
                            }
                        }
                    }
    
                    if (!formIsValid) {
                        e.preventDefault();
                        alert('Por favor, complete todos los campos obligatorios.');
                    }
                });
        }

    });
</script>
@endpush