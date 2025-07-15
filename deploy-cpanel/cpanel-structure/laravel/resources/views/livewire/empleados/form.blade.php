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

    <!-- Formulario -->
    <div class="bg-white rounded-xl border border-secondary-200">
        <form wire:submit.prevent="guardar" class="space-y-6 p-6">
            @csrf

            <!-- Información Personal -->
            <div class="border-b border-secondary-200 pb-6">
                <h3 class="text-lg font-medium text-secondary-900 mb-4">Información Personal</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nombre -->
                    <div class="space-y-1">
                        <label for="nombre" class="block text-sm font-medium text-secondary-700">
                            Nombre <span class="text-danger-500">*</span>
                        </label>
                        <input wire:model="nombre" type="text" id="nombre" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}" placeholder="Ej: Juan" {{ $modo == 'show' ? 'readonly' : '' }}>
                        @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Apellido -->
                    <div class="space-y-1">
                        <label for="apellido" class="block text-sm font-medium text-secondary-700">
                            Apellido <span class="text-danger-500">*</span>
                        </label>
                        <input wire:model="apellido" type="text" id="apellido" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}" placeholder="Ej: Pérez" {{ $modo == 'show' ? 'readonly' : '' }}>
                        @error('apellido') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- DNI -->
                    <div class="space-y-1">
                        <label for="dni" class="block text-sm font-medium text-secondary-700">
                            DNI <span class="text-danger-500">*</span>
                        </label>
                        <input wire:model="dni" type="text" id="dni" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}" placeholder="Ej: 12345678" {{ $modo == 'show' ? 'readonly' : '' }}>
                        @error('dni') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- CUIL -->
                    <div class="space-y-1">
                        <label for="cuil" class="block text-sm font-medium text-secondary-700">
                            CUIL <span class="text-danger-500">*</span>
                        </label>
                        <input wire:model="cuil" type="text" id="cuil" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}" placeholder="Ej: 20-12345678-9" {{ $modo == 'show' ? 'readonly' : '' }}>
                        @error('cuil') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                     <!-- Teléfono -->
                    <div class="space-y-1">
                        <label for="telefono" class="block text-sm font-medium text-secondary-700">
                            Teléfono <span class="text-danger-500">*</span>
                        </label>
                        <input wire:model="telefono" type="tel" id="telefono" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}" placeholder="Ej: (351) 425-6789" {{ $modo == 'show' ? 'readonly' : '' }}>
                        @error('telefono') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Email -->
                    <div class="space-y-1">
                        <label for="email" class="block text-sm font-medium text-secondary-700">
                            Correo Electrónico <span class="text-danger-500">*</span>
                        </label>
                        <input wire:model="email" type="email" id="email" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}" placeholder="Ej: juan.perez@escuela.edu.ar" {{ $modo == 'show' ? 'readonly' : '' }}>
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Dirección -->
                    <div class="md:col-span-2 space-y-1">
                        <label for="direccion" class="block text-sm font-medium text-secondary-700">
                            Dirección <span class="text-danger-500">*</span>
                        </label>
                        <input wire:model="direccion" type="text" id="direccion" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}" placeholder="Ej: Calle Falsa 123, Córdoba" {{ $modo == 'show' ? 'readonly' : '' }}>
                        @error('direccion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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
                        <select wire:model="id_escuela" id="id_escuela" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ ($modo == 'show' || auth()->user()->id_rol == 1) ? 'bg-secondary-50' : 'bg-white' }}" {{ ($modo == 'show' || auth()->user()->id_rol == 1) ? 'disabled' : '' }}>
                            <option value="">Seleccione una escuela</option>
                            @foreach($escuelas as $escuela)
                                <option value="{{ $escuela->id_escuela }}">{{ $escuela->nombre }}</option>
                            @endforeach
                        </select>
                        @error('id_escuela') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Cargo -->
                    <div class="space-y-1">
                        <label for="cargo" class="block text-sm font-medium text-secondary-700">
                            Cargo <span class="text-danger-500">*</span>
                        </label>
                        <input wire:model="cargo" type="text" id="cargo" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}" placeholder="Ej: Docente de Matemáticas" {{ $modo == 'show' ? 'readonly' : '' }}>
                        @error('cargo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Fecha de Ingreso -->
                    <div class="space-y-1">
                        <label for="fecha_ingreso" class="block text-sm font-medium text-secondary-700">
                            Fecha de Ingreso <span class="text-danger-500">*</span>
                        </label>
                        <input wire:model="fecha_ingreso" type="date" id="fecha_ingreso" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}" {{ $modo == 'show' ? 'readonly' : '' }}>
                        @error('fecha_ingreso') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Fecha de Egreso -->
                    <div class="space-y-1">
                        <label for="fecha_egreso" class="block text-sm font-medium text-secondary-700">
                            Fecha de Egreso
                        </label>
                        <input wire:model="fecha_egreso" type="date" id="fecha_egreso" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}" {{ $modo == 'show' ? 'readonly' : '' }}>
                         <p class="text-xs text-secondary-500">Dejar vacío si el empleado sigue activo</p>
                         @error('fecha_egreso') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Estado -->
            <div class="space-y-4">
                <h3 class="text-lg font-medium text-secondary-900">Estado</h3>
                <div class="flex items-center">
                    <div class="flex items-center h-5">
                        <input wire:model="activo" type="checkbox" id="activo" class="w-4 h-4 text-primary-600 bg-white border-secondary-300 rounded focus:ring-primary-500 focus:ring-2" {{ $modo == 'show' ? 'disabled' : '' }}>
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

@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('mostrar-mensaje', () => {
            console.log('Mensaje mostrado - modo edición');
        });

        Livewire.on('mostrar-mensaje-y-redirigir', () => {
            console.log('Mensaje mostrado - modo creación');
            setTimeout(() => {
                @this.call('redirigirAlListado');
            }, 3000);
        });
    });
</script>
@endpush