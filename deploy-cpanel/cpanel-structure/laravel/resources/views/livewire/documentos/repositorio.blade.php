<div>
    <div class="mx-auto px-4">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 mb-8">
            <div>
                <h1 class="text-2xl font-semibold text-secondary-900">Repositorio de Documentos</h1>
                <p class="mt-1 text-sm text-secondary-600">Documentos disponibles para tu escuela</p>
            </div>
        </div>

        <!-- Filtro de búsqueda -->
        <div class="bg-white rounded-xl border border-secondary-200 mb-6">
            <div class="p-6">
                <div class="max-w-md">
                    <label for="filtro_descripcion" class="block text-sm font-medium text-secondary-700 mb-2">Buscar por descripción</label>
                    <input wire:model.live="filtro_descripcion" type="text" id="filtro_descripcion" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Escribe para buscar...">
                </div>
            </div>
        </div>

        <!-- Grid de Documentos -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($documentos as $documento)
                <div class="bg-white rounded-xl border border-secondary-200 overflow-hidden hover:shadow-lg transition-shadow duration-200">
                    <div class="p-6">
                        <!-- Tipo de documento -->
                        <div class="flex items-center justify-between mb-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                                {{ $documento->tipoDocumento->nombre ?? 'Documento' }}
                            </span>
                            <span class="text-xs text-secondary-500">
                                {{ $documento->fecha_carga ? $documento->fecha_carga->format('d/m/Y') : 'Sin fecha' }}
                            </span>
                        </div>

                        <!-- Título -->
                        <h3 class="text-lg font-semibold text-secondary-900 mb-2 line-clamp-2">
                            {{ $documento->nombre_documento }}
                        </h3>

                        <!-- Descripción -->
                        <p class="text-sm text-secondary-600 mb-4 line-clamp-3">
                            {{ $documento->descripcion ?? 'Sin descripción' }}
                        </p>

                        <!-- Estado -->
                        <div class="mb-4">
                            @php
                                $estado = 'Vigente';
                                $estadoColor = 'success';
                                if ($documento->fecha_vencimiento) {
                                    $vencimiento = \Carbon\Carbon::parse($documento->fecha_vencimiento);
                                    if ($vencimiento->isPast()) {
                                        $estado = 'Vencido';
                                        $estadoColor = 'danger';
                                    } elseif ($vencimiento->isBetween(now(), now()->addDays(30))) {
                                        $estado = 'Por Vencer';
                                        $estadoColor = 'warning';
                                    }
                                }
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{$estadoColor}}-100 text-{{$estadoColor}}-800">
                                <svg class="w-1.5 h-1.5 mr-1.5" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3"/></svg>
                                {{ $estado }}
                            </span>
                        </div>

                        <!-- Lista de Archivos -->
                        @if($documento->tieneArchivos())
                            <div class="mb-4">
                                <div class="flex items-center text-xs text-secondary-500 mb-2">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Archivos disponibles:
                                </div>
                                <div class="space-y-2">
                                    @foreach($documento->archivos as $archivo)
                                        <a href="{{ route('documentos.archivo.download', $archivo->id_archivo) }}"
                                           target="_blank"
                                           title="{{ $archivo->nombre_archivo }}"
                                           class="flex items-center p-2 text-sm text-primary-600 hover:text-primary-800 hover:bg-primary-50 rounded-lg transition-colors duration-200 border border-primary-200 hover:border-primary-300">
                                            <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <span class="truncate">{{ $archivo->nombre_archivo }}</span>
                                            <span class="ml-auto text-xs text-secondary-400">
                                                {{ strtoupper($archivo->tipo_archivo) }}
                                            </span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <div class="inline-flex items-center px-3 py-2 bg-secondary-100 border border-secondary-200 rounded-lg text-sm text-secondary-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Sin archivos disponibles
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="bg-white rounded-xl border border-secondary-200 p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-secondary-900">No hay documentos</h3>
                        <p class="mt-1 text-sm text-secondary-500">
                            @if($filtro_descripcion)
                                No se encontraron documentos que coincidan con tu búsqueda.
                            @else
                                No hay documentos disponibles para tu escuela en este momento.
                            @endif
                        </p>
                        @if($filtro_descripcion)
                            <div class="mt-4">
                                <button wire:click="$set('filtro_descripcion', '')" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                                    Limpiar búsqueda
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Paginación -->
        @if($documentos->hasPages())
            <div class="mt-8">
                {{ $documentos->links('pagination.custom-tailwind') }}
            </div>
        @endif

        <!-- Mensaje Flash -->
        @if (session()->has('message'))
            <div class="fixed top-4 right-4 z-50 bg-success-50 border border-success-200 text-success-700 px-4 py-3 rounded-lg shadow-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="font-medium">{{ session('message') }}</span>
                </div>
            </div>
        @endif

        <!-- Mensaje de Error -->
        @if (session()->has('error'))
            <div class="fixed top-4 right-4 z-50 bg-danger-50 border border-danger-200 text-danger-700 px-4 py-3 rounded-lg shadow-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif
    </div>
</div>