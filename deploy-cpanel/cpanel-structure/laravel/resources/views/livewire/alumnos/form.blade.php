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

    <div class="mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <nav class="flex items-center text-sm text-secondary-500 mb-4">
                <a href="{{ route('alumnos.index') }}" class="hover:text-secondary-700">Alumnos</a>
                <svg class="mx-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-secondary-900">{{ $modo == 'create' ? 'Nuevo Alumno' : ($modo == 'edit' ? 'Editar Alumno' : 'Detalles de Alumno') }}</span>
            </nav>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-secondary-900">
                        {{ $modo == 'create' ? 'Nuevo Alumno' : ($modo == 'edit' ? 'Editar Alumno' : 'Detalles de Alumno') }}
                    </h1>
                    <p class="mt-1 text-sm text-secondary-600">
                        {{ $modo == 'create' ? 'Complete los datos para registrar un nuevo alumno' : ($modo == 'edit' ? 'Modifique los datos del alumno' : 'Información detallada del alumno') }}
                    </p>
                </div>
                @if($modo == 'show')
                <div class="flex space-x-3">
                    <a href="{{ route('alumnos.edit', $alumno_id) }}" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
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
                @csrf
                <!-- Información Personal del Alumno -->
                <div class="border-b border-secondary-200 pb-6">
                    <h3 class="text-lg font-medium text-secondary-900 mb-4">Información Personal del Alumno</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nombre -->
                        <div class="space-y-1">
                            <label for="nombre" class="block text-sm font-medium text-secondary-700">
                                Nombre <span class="text-danger-500">*</span>
                            </label>
                            <input wire:model="nombre" type="text" id="nombre" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}" placeholder="Ej: Ana" {{ $modo == 'show' ? 'readonly' : '' }}>
                            @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Apellido -->
                        <div class="space-y-1">
                            <label for="apellido" class="block text-sm font-medium text-secondary-700">
                                Apellido <span class="text-danger-500">*</span>
                            </label>
                            <input wire:model="apellido" type="text" id="apellido" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}" placeholder="Ej: Martínez" {{ $modo == 'show' ? 'readonly' : '' }}>
                            @error('apellido') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- DNI -->
                        <div class="space-y-1">
                            <label for="dni" class="block text-sm font-medium text-secondary-700">
                                DNI <span class="text-danger-500">*</span>
                            </label>
                            <input wire:model="dni" type="text" id="dni" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}" placeholder="Ej: 45678912" {{ $modo == 'show' ? 'readonly' : '' }}>
                            @error('dni') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- CUIL -->
                        <div class="space-y-1">
                            <label for="cuil" class="block text-sm font-medium text-secondary-700">CUIL</label>
                            <input wire:model="cuil" type="text" id="cuil" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}" placeholder="Ej: 23-45678912-4" {{ $modo == 'show' ? 'readonly' : '' }}>
                            @error('cuil') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Fecha de Nacimiento -->
                        <div class="space-y-1">
                            <label for="fecha_nacimiento" class="block text-sm font-medium text-secondary-700">
                                Fecha de Nacimiento <span class="text-danger-500">*</span>
                            </label>
                            <input wire:model="fecha_nacimiento" type="date" id="fecha_nacimiento" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}" {{ $modo == 'show' ? 'readonly' : '' }}>
                            @error('fecha_nacimiento') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

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
                            <input wire:model="sala_grado_curso" type="text" id="sala_grado_curso" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}" placeholder="Ej: 7° Grado, 3° Año, Sala de 5" {{ $modo == 'show' ? 'readonly' : '' }}>
                            @error('sala_grado_curso') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Información de Contacto Familiar -->
                <div class="border-b border-secondary-200 pb-6">
                    <h3 class="text-lg font-medium text-secondary-900 mb-4">Información de Contacto Familiar</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nombre del Padre/Madre -->
                        <div class="space-y-1">
                            <label for="nombre_padre_madre" class="block text-sm font-medium text-secondary-700">Nombre del Padre/Madre</label>
                            <input wire:model="nombre_padre_madre" type="text" id="nombre_padre_madre" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}" placeholder="Ej: Carlos Martínez" {{ $modo == 'show' ? 'readonly' : '' }}>
                            @error('nombre_padre_madre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Teléfono de Contacto -->
                        <div class="space-y-1">
                            <label for="telefono_contacto" class="block text-sm font-medium text-secondary-700">Teléfono de Contacto</label>
                            <input wire:model="telefono_contacto" type="tel" id="telefono_contacto" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}" placeholder="Ej: (351) 555-1234" {{ $modo == 'show' ? 'readonly' : '' }}>
                            @error('telefono_contacto') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Información Adicional -->
                <div class="border-b border-secondary-200 pb-6">
                    <h3 class="text-lg font-medium text-secondary-900 mb-4">Información Adicional</h3>
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Obra Social -->
                        <div class="space-y-1">
                            <label for="obra_social" class="block text-sm font-medium text-secondary-700">¿Realiza alguna obra social?</label>
                            <textarea wire:model="obra_social" id="obra_social" rows="3" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}" placeholder="Describa las actividades de obra social que realiza (opcional)" {{ $modo == 'show' ? 'readonly' : '' }}></textarea>
                            @error('obra_social') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Deportes -->
                        <div class="space-y-1">
                            <label for="deportes" class="block text-sm font-medium text-secondary-700">¿Practica algún deporte?</label>
                            <textarea wire:model="deportes" id="deportes" rows="3" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}" placeholder="Describa los deportes que practica (opcional)" {{ $modo == 'show' ? 'readonly' : '' }}></textarea>
                            @error('deportes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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
                                Alumno Activo
                            </label>
                            <p class="text-xs text-secondary-500">Indica si el alumno se encuentra activo en la escuela</p>
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="flex items-center justify-between pt-6 border-t border-secondary-200">
                    <a href="{{ route('alumnos.index') }}" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
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
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </span>
                        {{ $modo == 'create' ? 'Crear Alumno' : 'Actualizar Alumno' }}
                    </button>
                    @endif
                </div>
            </form>
        </div>
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