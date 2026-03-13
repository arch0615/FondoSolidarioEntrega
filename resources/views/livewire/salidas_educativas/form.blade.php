<div>
    <!-- Modal de confirmación -->
    @if($mensaje)
    <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: true }" x-show="show" x-transition>
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="show = false"></div>
            <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full sm:p-6">
                <div>
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full {{ $tipoMensaje === 'success' ? 'bg-green-100' : 'bg-red-100' }}">
                        @if($tipoMensaje === 'success')
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
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
                <a href="{{ route('salidas-educativas.index') }}" class="hover:text-secondary-700">Salidas Educativas</a>
                <svg class="mx-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-secondary-900">{{ $modo == 'create' ? 'Nueva Salida Educativa' : ($modo == 'edit' ? 'Editar Salida Educativa' : 'Detalles de Salida Educativa') }}</span>
            </nav>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-secondary-900">
                        {{ $modo == 'create' ? 'Nueva Salida Educativa' : ($modo == 'edit' ? 'Editar Salida Educativa' : 'Detalles de Salida Educativa') }}
                    </h1>
                    <p class="mt-1 text-sm text-secondary-600">
                        {{ $modo == 'create' ? 'Complete los datos para registrar una nueva salida educativa' : ($modo == 'edit' ? 'Modifique los datos de la salida educativa' : 'Información detallada de la salida educativa') }}
                    </p>
                </div>
                @if($modo == 'show')
                <div class="flex space-x-3">
                    <a href="{{ route('salidas-educativas.print', $salida_id) }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Imprimir
                    </a>
                    <a href="{{ route('salidas-educativas.edit', $salida_id) }}" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
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

                <!-- Información de la Salida -->
                <div class="border-b border-secondary-200 pb-6">
                    <h3 class="text-lg font-medium text-secondary-900 mb-4">Información de la Salida</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Escuela -->
                        <div class="space-y-1">
                            <label for="id_escuela" class="block text-sm font-medium text-secondary-700">Escuela <span class="text-danger-500">*</span></label>
                            <select wire:model.live="id_escuela" id="id_escuela" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ ($modo == 'show' || $esUsuarioGeneral) ? 'bg-secondary-50' : 'bg-white' }}" {{ ($modo == 'show' || $esUsuarioGeneral) ? 'disabled' : '' }}>
                                <option value="">Seleccione una escuela</option>
                                @foreach($escuelas as $escuela)
                                    <option value="{{ $escuela->id_escuela }}">{{ $escuela->nombre }}</option>
                                @endforeach
                            </select>
                            @error('id_escuela') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Fecha Desde -->
                        <div class="space-y-1">
                            <label for="fecha_salida" class="block text-sm font-medium text-secondary-700">Fecha Desde <span class="text-danger-500">*</span></label>
                            <input wire:model="fecha_salida" type="date" id="fecha_salida" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}" {{ $modo == 'show' ? 'readonly' : '' }}>
                            @error('fecha_salida') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Fecha Hasta -->
                        <div class="space-y-1">
                            <label for="fecha_hasta" class="block text-sm font-medium text-secondary-700">Fecha Hasta</label>
                            <input wire:model="fecha_hasta" type="date" id="fecha_hasta" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}" {{ $modo == 'show' ? 'readonly' : '' }}>
                            <p class="text-xs text-secondary-400">Dejar vacío si la salida es de un solo día</p>
                            @error('fecha_hasta') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Hora de Salida -->
                        <div class="space-y-1">
                            <label for="hora_salida" class="block text-sm font-medium text-secondary-700">Hora de Salida <span class="text-danger-500">*</span></label>
                            <input wire:model="hora_salida" type="time" id="hora_salida" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}" {{ $modo == 'show' ? 'readonly' : '' }}>
                            @error('hora_salida') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Hora de Regreso -->
                        <div class="space-y-1">
                            <label for="hora_regreso" class="block text-sm font-medium text-secondary-700">Hora de Regreso <span class="text-danger-500">*</span></label>
                            <input wire:model="hora_regreso" type="time" id="hora_regreso" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}" {{ $modo == 'show' ? 'readonly' : '' }}>
                            @error('hora_regreso') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Destino -->
                        <div class="md:col-span-2 space-y-1">
                            <label for="destino" class="block text-sm font-medium text-secondary-700">Destino <span class="text-danger-500">*</span></label>
                            <input wire:model="destino" type="text" id="destino" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}" placeholder="Ej: Museo de Ciencias Naturales" {{ $modo == 'show' ? 'readonly' : '' }}>
                            @error('destino') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Propósito -->
                        <div class="md:col-span-2 space-y-1">
                            <label for="proposito" class="block text-sm font-medium text-secondary-700">Propósito <span class="text-danger-500">*</span></label>
                            <textarea wire:model="proposito" id="proposito" rows="3" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}" placeholder="Describa el propósito de la salida educativa" {{ $modo == 'show' ? 'readonly' : '' }}></textarea>
                            @error('proposito') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>


                        <!-- Grado/Curso -->
                        <div class="space-y-1">
                            <label for="grado_curso" class="block text-sm font-medium text-secondary-700">Grado/Curso</label>
                            <input wire:model="grado_curso" type="text" id="grado_curso" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}" placeholder="Ej: 3er Año A" {{ $modo == 'show' ? 'readonly' : '' }}>
                            @error('grado_curso') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Cantidad de Alumnos -->
                        <div class="space-y-1">
                            <label for="cantidad_alumnos" class="block text-sm font-medium text-secondary-700">Cantidad de Alumnos <span class="text-danger-500">*</span></label>
                            <input wire:model="cantidad_alumnos" type="number" id="cantidad_alumnos" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}" placeholder="Ej: 30" {{ $modo == 'show' ? 'readonly' : '' }}>
                            @error('cantidad_alumnos') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Docentes Acompañantes -->
                        <div class="md:col-span-2 space-y-1">
                            <label for="docentes_acompanantes" class="block text-sm font-medium text-secondary-700">Docentes Acompañantes <span class="text-danger-500">*</span></label>
                            <textarea wire:model="docentes_acompanantes" id="docentes_acompanantes" rows="3" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}" placeholder="Ej: Prof. Ana Gómez, Prof. Carlos Ruiz" {{ $modo == 'show' ? 'readonly' : '' }}></textarea>
                            @error('docentes_acompanantes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Medio de Transporte -->
                        <div class="md:col-span-2 space-y-1">
                            <label for="transporte" class="block text-sm font-medium text-secondary-700">Medio de Transporte <span class="text-danger-500">*</span></label>
                            <input wire:model="transporte" type="text" id="transporte" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}" placeholder="Ej: Colectivo escolar" {{ $modo == 'show' ? 'readonly' : '' }}>
                            @error('transporte') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Archivos Adjuntos -->
                <div class="border-b border-secondary-200 pb-6">
                    <h3 class="text-lg font-medium text-secondary-900 mb-4">Archivos Adjuntos</h3>

                    @if($modo != 'show')
                    <div class="mb-6" x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-secondary-300 border-dashed rounded-lg">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-secondary-400" stroke="currentColor" fill="none" viewBox="0 0 48 48"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                                <div class="flex text-sm text-secondary-600">
                                    <label for="archivos_adjuntos" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500">
                                        <span>Subir archivos</span>
                                        <input wire:model="archivos_adjuntos" id="archivos_adjuntos" type="file" class="sr-only" multiple>
                                    </label>
                                    <p class="pl-1">o arrastrar y soltar</p>
                                </div>
                                <p class="text-xs text-secondary-500">PDF, JPG, PNG hasta 10MB</p>
                            </div>
                        </div>
                        <div x-show="isUploading"><progress max="100" x-bind:value="progress" class="w-full"></progress></div>
                        @error('archivos_adjuntos.*') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    @endif

                    <div>
                        @if (count($archivos_existentes) > 0)
                            @foreach ($archivos_existentes as $archivo)
                                <div class="flex items-center justify-between bg-white border border-secondary-200 rounded-lg p-3 mb-2">
                                    <div class="flex items-center flex-1">
                                        <a href="{{ Storage::url($archivo['ruta_archivo']) }}" target="_blank" class="font-medium text-secondary-900 truncate hover:text-primary-600">{{ $archivo['nombre_archivo'] }}</a>
                                        <span class="text-sm text-secondary-600 ml-2">({{ number_format(($archivo['tamano'] ?? 0) / 1024, 1) }} KB)</span>
                                    </div>
                                    @if($modo != 'show')
                                    <button wire:click.prevent="eliminarArchivoExistente({{ $archivo['id_archivo'] }})" type="button" class="text-red-600 hover:text-red-800 p-1 ml-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                        @if (count($archivos_adjuntos) > 0)
                            @foreach ($archivos_adjuntos as $archivo)
                                <div class="flex items-center justify-between bg-blue-50 border border-blue-200 rounded-lg p-3 mb-2">
                                    <div class="font-medium text-secondary-900 truncate">{{ $archivo->getClientOriginalName() }} <span class="text-xs text-blue-600">(nuevo)</span></div>
                                    <button wire:click.prevent="$removeUpload('archivos_adjuntos', '{{ $archivo->getFilename() }}')" type="button" class="text-red-600 hover:text-red-800 p-1"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                </div>
                            @endforeach
                        @endif
                        @if (count($archivos_existentes) == 0 && count($archivos_adjuntos) == 0)
                            <div class="text-center py-8 border-2 border-dashed border-secondary-200 rounded-lg">
                                <p class="text-sm text-secondary-500">No hay archivos adjuntos</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="flex items-center justify-between pt-6 border-t border-secondary-200">
                    <a href="{{ route('salidas-educativas.index') }}" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Volver al Listado
                    </a>
                    @if($modo != 'show')
                    <button type="submit" class="inline-flex items-center px-6 py-2 bg-primary-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        {{ $modo == 'create' ? 'Crear Salida Educativa' : 'Actualizar Salida Educativa' }}
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
            // Lógica para mostrar el modal si es necesario, o simplemente para confirmar que el evento se recibió.
        });

        Livewire.on('mostrar-mensaje-y-redirigir', () => {
            setTimeout(() => {
                @this.call('redirigirAlListado');
            }, 3000);
        });
    });
</script>
@endpush