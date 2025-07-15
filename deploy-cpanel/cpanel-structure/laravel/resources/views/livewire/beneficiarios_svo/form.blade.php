<div>
    @if($mensaje)
    <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: true }" x-show="show" x-transition>
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="show = false"></div>
            <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full sm:p-6">
                <div>
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full {{ $tipoMensaje === 'success' ? 'bg-green-100' : 'bg-red-100' }}">
                        @if($tipoMensaje === 'success')
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        @endif
                    </div>
                    <div class="mt-3 text-center sm:mt-5">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">¡Éxito!</h3>
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
                        <button @click="show = false" wire:click="redirigirAlListado" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 hover:bg-green-700 text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:text-sm">
                            Ir al Listado
                        </button>
                    @else
                        <button @click="show = false" wire:click="limpiarMensaje" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 hover:bg-green-700 text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:text-sm">
                            Aceptar
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="bg-white rounded-xl border border-secondary-200">
        <form wire:submit.prevent="guardar" class="space-y-6 p-6">
            @csrf

            <!-- Información del Beneficiario -->
            <div class="border-b border-secondary-200 pb-6">
                <h3 class="text-lg font-medium text-secondary-900 mb-4">Información del Beneficiario</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Escuela -->
                    <div class="md:col-span-2 space-y-1">
                        <label for="id_escuela" class="block text-sm font-medium text-secondary-700">
                            Escuela <span class="text-danger-500">*</span>
                        </label>
                        <select
                            wire:model.live="id_escuela"
                            id="id_escuela"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ ($modo == 'show' || (Auth::check() && Auth::user()->rol === 'usuario_general')) ? 'bg-secondary-50' : 'bg-white' }}"
                            {{ ($modo == 'show' || (Auth::check() && Auth::user()->rol === 'usuario_general')) ? 'disabled' : '' }}
                        >
                            <option value="">Seleccione una escuela</option>
                            @foreach($escuelas as $escuela)
                                <option value="{{ $escuela->id_escuela }}">{{ $escuela->nombre }}</option>
                            @endforeach
                        </select>
                        @error('id_escuela') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Empleado -->
                    <div class="md:col-span-2 space-y-1">
                        <label for="id_empleado" class="block text-sm font-medium text-secondary-700">
                            Empleado Titular <span class="text-danger-500">*</span>
                        </label>
                        <select
                            wire:model="id_empleado"
                            id="id_empleado"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            {{ $modo == 'show' ? 'disabled' : '' }}
                        >
                            <option value="">Seleccione un empleado</option>
                            @foreach($empleados as $empleado)
                                <option value="{{ $empleado->id_empleado }}">{{ $empleado->nombre }} {{ $empleado->apellido }} (DNI: {{ $empleado->dni }})</option>
                            @endforeach
                        </select>
                        @error('id_empleado') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Nombre del Beneficiario -->
                    <div class="space-y-1">
                        <label for="nombre" class="block text-sm font-medium text-secondary-700">
                            Nombre del Beneficiario <span class="text-danger-500">*</span>
                        </label>
                        <input
                            wire:model="nombre"
                            type="text"
                            id="nombre"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            placeholder="Ej: Ana"
                            {{ $modo == 'show' ? 'readonly' : '' }}
                        >
                        @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Apellido del Beneficiario -->
                    <div class="space-y-1">
                        <label for="apellido" class="block text-sm font-medium text-secondary-700">
                            Apellido del Beneficiario <span class="text-danger-500">*</span>
                        </label>
                        <input
                            wire:model="apellido"
                            type="text"
                            id="apellido"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            placeholder="Ej: Pérez"
                            {{ $modo == 'show' ? 'readonly' : '' }}
                        >
                        @error('apellido') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- DNI del Beneficiario -->
                    <div class="space-y-1">
                        <label for="dni" class="block text-sm font-medium text-secondary-700">
                            DNI del Beneficiario <span class="text-danger-500">*</span>
                        </label>
                        <input
                            wire:model="dni"
                            type="text"
                            id="dni"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            placeholder="Ej: 45678901"
                            {{ $modo == 'show' ? 'readonly' : '' }}
                        >
                        @error('dni') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Parentesco -->
                    <div class="space-y-1">
                        <label for="id_parentesco" class="block text-sm font-medium text-secondary-700">
                            Parentesco <span class="text-danger-500">*</span>
                        </label>
                        <select
                            wire:model="id_parentesco"
                            id="id_parentesco"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            {{ $modo == 'show' ? 'disabled' : '' }}
                        >
                            <option value="">Seleccione un parentesco</option>
                            @foreach($parentescos as $parentesco)
                                <option value="{{ $parentesco->id_parentesco }}">{{ $parentesco->nombre_parentesco }}</option>
                            @endforeach
                        </select>
                        @error('id_parentesco') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Porcentaje -->
                    <div class="space-y-1">
                        <label for="porcentaje" class="block text-sm font-medium text-secondary-700">
                            Porcentaje <span class="text-danger-500">*</span>
                        </label>
                        <div class="relative">
                            <input
                                wire:model="porcentaje"
                                type="number"
                                step="0.01"
                                min="0"
                                max="100"
                                id="porcentaje"
                                class="block w-full pr-10 pl-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                                placeholder="Ej: 50"
                                {{ $modo == 'show' ? 'readonly' : '' }}
                            >
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-secondary-500 text-sm">%</span>
                            </div>
                        </div>
                        @error('porcentaje') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                         <p class="text-xs text-secondary-500">Porcentaje de la cobertura asignado a este beneficiario.</p>
                    </div>

                    @if($modo != 'create')
                    <!-- Fecha de Alta -->
                    <div class="space-y-1">
                        <label for="fecha_alta" class="block text-sm font-medium text-secondary-700">Fecha de Alta</label>
                        <input
                            type="date"
                            wire:model="fecha_alta"
                            id="fecha_alta"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm bg-secondary-50 focus:outline-none"
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
                            wire:model="activo"
                            type="checkbox"
                            id="activo"
                            class="w-4 h-4 text-primary-600 bg-white border-secondary-300 rounded focus:ring-primary-500 focus:ring-2"
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
                <a href="{{ route('beneficiarios_svo.index') }}" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver al Listado
                </a>
                @if($modo != 'show')
                <button type="submit" class="inline-flex items-center px-6 py-2 bg-primary-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                    <svg wire:loading wire:target="guardar" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span wire:loading.remove wire:target="guardar">
                        {{ $modo == 'create' ? 'Crear Beneficiario' : 'Actualizar Beneficiario' }}
                    </span>
                    <span wire:loading wire:target="guardar">
                        {{ $modo == 'create' ? 'Creando...' : 'Actualizando...' }}
                    </span>
                </button>
                @endif
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('mostrar-mensaje', () => {
            // Lógica para mostrar feedback si es necesario, aunque el modal ya lo maneja.
        });

        Livewire.on('mostrar-mensaje-y-redirigir', () => {
            setTimeout(() => {
                @this.call('redirigirAlListado');
            }, 3000);
        });
    });
</script>
@endpush