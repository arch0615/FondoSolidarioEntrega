<div>
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

    <form wire:submit.prevent="guardar" class="space-y-6 p-6 bg-white rounded-xl border border-secondary-200">
        @csrf
        <!-- Información del Documento -->
        <div class="border-b border-secondary-200 pb-6">
            <h3 class="text-lg font-medium text-secondary-900 mb-4">Información del Documento</h3>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Columna Izquierda: Información del Documento -->
                <div class="space-y-4">
                    <div class="space-y-1">
                        <label for="nombre_documento" class="block text-sm font-medium text-secondary-700">Nombre del Documento <span class="text-danger-500">*</span></label>
                        <input wire:model="nombre_documento" type="text" id="nombre_documento" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm" {{ $modo == 'show' ? 'readonly' : '' }}>
                        @error('nombre_documento') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1">
                        <label for="fecha_documento" class="block text-sm font-medium text-secondary-700">Fecha del Documento</label>
                        <input wire:model="fecha_documento" type="date" id="fecha_documento" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm" {{ $modo == 'show' ? 'readonly' : '' }}>
                        @error('fecha_documento') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1">
                        <label for="fecha_vencimiento" class="block text-sm font-medium text-secondary-700">Fecha de Vencimiento</label>
                        <input wire:model="fecha_vencimiento" type="date" id="fecha_vencimiento" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm" {{ $modo == 'show' ? 'readonly' : '' }}>
                        @error('fecha_vencimiento') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1">
                        <label for="descripcion" class="block text-sm font-medium text-secondary-700">Descripción</label>
                        <textarea wire:model="descripcion" id="descripcion" rows="4" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm" {{ $modo == 'show' ? 'readonly' : '' }}></textarea>
                        @error('descripcion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Columna Derecha: Selector de Escuelas -->
                <div class="space-y-4">
                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-secondary-700">Escuelas <span class="text-danger-500">*</span></label>
                        <div class="border border-secondary-300 rounded-lg p-4 bg-secondary-50">
                            @if($modo != 'show')
                            <div class="flex gap-2 mb-3">
                                <button wire:click="seleccionarTodasEscuelas" type="button" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                    Seleccionar Todas
                                </button>
                                <button wire:click="limpiarSeleccion" type="button" class="inline-flex items-center px-3 py-1.5 border border-secondary-300 text-xs font-medium rounded-md text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                    Limpiar
                                </button>
                            </div>
                            @endif

                            <div class="max-h-60 overflow-y-auto border border-secondary-200 rounded-md bg-white">
                                <div class="p-2 space-y-1">
                                    @foreach($escuelas as $escuela)
                                        <div wire:click="toggleEscuela({{ $escuela->id_escuela }})"
                                             class="flex items-center p-2 rounded-md cursor-pointer transition-colors duration-150 {{ in_array($escuela->id_escuela, $escuelas_seleccionadas) ? 'bg-primary-100 border border-primary-300' : 'hover:bg-secondary-50' }}"
                                             {{ $modo == 'show' ? '' : '' }}>
                                            <div class="flex items-center flex-1">
                                                <div class="w-4 h-4 mr-3 rounded border-2 {{ in_array($escuela->id_escuela, $escuelas_seleccionadas) ? 'bg-primary-600 border-primary-600' : 'border-secondary-300' }}">
                                                    @if(in_array($escuela->id_escuela, $escuelas_seleccionadas))
                                                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    @endif
                                                </div>
                                                <span class="text-sm text-secondary-900">{{ $escuela->nombre }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mt-2 text-xs text-secondary-600">
                                {{ count($escuelas_seleccionadas) }} escuela(s) seleccionada(s)
                            </div>
                        </div>
                        @error('escuelas_seleccionadas') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Documentos Adjuntos -->
        <div class="border-b border-secondary-200 pb-6">
            <h3 class="text-lg font-medium text-secondary-900 mb-4">Documentos Adjuntos</h3>
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

            <div id="lista_archivos_container">
                <label class="block text-sm font-medium text-secondary-700 mb-2">Archivos:</label>
                <div class="space-y-2">
                    @if (count($archivos_existentes) > 0)
                        @foreach ($archivos_existentes as $archivo)
                            <div class="flex items-center justify-between bg-white border border-secondary-200 rounded-lg p-3">
                                <div class="flex items-center flex-1">
                                    <a href="{{ Storage::url($archivo->ruta_archivo) }}" target="_blank" class="font-medium text-secondary-900 truncate hover:text-primary-600">{{ $archivo->nombre_archivo }}</a>
                                    <span class="text-sm text-secondary-600 ml-2">({{ $archivo->tamano_formateado }})</span>
                                </div>
                                @if($modo != 'show')
                                <button wire:click.prevent="eliminarArchivoExistente({{ $archivo->id_archivo }})" type="button" class="text-red-600 hover:text-red-800 p-1 ml-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                @endif
                            </div>
                        @endforeach
                    @endif
                    @if (count($archivos_adjuntos) > 0)
                        @foreach ($archivos_adjuntos as $archivo)
                            <div class="flex items-center justify-between bg-white border border-secondary-200 rounded-lg p-3">
                                <div class="font-medium text-secondary-900 truncate">{{ $archivo->getClientOriginalName() }}</div>
                                <button wire:click.prevent="$removeUpload('archivos_adjuntos', '{{ $archivo->getFilename() }}')" type="button" class="text-red-600 hover:text-red-800 p-1"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                            </div>
                        @endforeach
                    @endif
                    @if (count($archivos_existentes) == 0 && count($archivos_adjuntos) == 0)
                        <div class="text-center py-8 border-2 border-dashed border-secondary-200 rounded-lg">
                            <p class="text-sm text-secondary-500">No hay documentos adjuntos</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="flex items-center justify-between pt-6 border-t border-secondary-200">
            <a href="{{ route('documentos.index') }}" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50">Volver al Listado</a>
            @if($modo != 'show')
            <button type="submit" class="inline-flex items-center px-6 py-2 bg-primary-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-primary-700">
                <div wire:loading.remove wire:target="guardar">
                    {{ $modo == 'create' ? 'Guardar Documento' : 'Actualizar Documento' }}
                </div>
                <div wire:loading wire:target="guardar">
                    Guardando...
                </div>
            </button>
            @endif
        </div>
    </form>

    @push('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('mostrar-mensaje', () => {
                // El modal se muestra automáticamente por las directivas de Alpine
            });

            Livewire.on('mostrar-mensaje-y-redirigir', () => {
                setTimeout(() => {
                    @this.call('redirigirAlListado');
                }, 3000);
            });
        });
    </script>
    @endpush
</div>