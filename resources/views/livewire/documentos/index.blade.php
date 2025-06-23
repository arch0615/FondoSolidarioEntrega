<div>
    <div class="mx-auto px-4">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 mb-8">
            <div>
                <h1 class="text-2xl font-semibold text-secondary-900">Gestión de Documentos</h1>
                <p class="mt-1 text-sm text-secondary-600">Administra los documentos institucionales de la escuela</p>
            </div>
            <div class="flex items-center space-x-3">
                <!-- Botón de Exportar -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="inline-flex items-center px-4 py-2 bg-white border border-secondary-300 rounded-lg font-medium text-sm text-secondary-700 hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        <i class="fas fa-download mr-2"></i>
                        Exportar
                        <i class="fas fa-chevron-down ml-2 -mr-1 h-5 w-5"></i>
                    </button>
                    <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10" style="display:none;" x-transition>
                        <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                            <button onclick="exportarDocumentos('csv')" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900 w-full text-left" role="menuitem"><i class="fas fa-file-csv fa-fw text-secondary-400"></i>Exportar a CSV</button>
                            <button onclick="exportarDocumentos('excel')" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900 w-full text-left" role="menuitem"><i class="fas fa-file-excel fa-fw text-secondary-400"></i>Exportar a Excel</button>
                            <button onclick="exportarDocumentos('pdf')" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900 w-full text-left" role="menuitem"><i class="fas fa-file-pdf fa-fw text-secondary-400"></i>Exportar a PDF</button>
                        </div>
                    </div>
                </div>
                <a href="{{ route('documentos.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Nuevo Documento
                </a>
            </div>
        </div>

        <!-- Mensaje Flash -->
        @if (session()->has('message'))
            <div class="mb-6 bg-success-50 border border-success-200 text-success-700 px-4 py-3 rounded-lg relative">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span class="font-medium">{{ session('message') }}</span>
                </div>
            </div>
        @endif

        <!-- Filtros -->
        <div class="bg-white rounded-xl border border-secondary-200 mb-6">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    <div class="space-y-1">
                        <label for="filtro_nombre" class="block text-sm font-medium text-secondary-700">Nombre del Documento</label>
                        <input wire:model.live="filtro_nombre" type="text" id="filtro_nombre" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Buscar por nombre">
                    </div>
                    <div class="space-y-1">
                        <label for="filtro_tipo_documento" class="block text-sm font-medium text-secondary-700">Tipo de Documento</label>
                        <select wire:model.live="filtro_tipo_documento" id="filtro_tipo_documento" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option value="">Todos los tipos</option>
                            @foreach($tipos_documento as $tipo)
                                <option value="{{ $tipo->id_tipo_documento }}">{{ $tipo->nombre_tipo_documento }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if(auth()->user()->id_rol != 1)
                    <div class="space-y-1">
                        <label for="filtro_escuela" class="block text-sm font-medium text-secondary-700">Escuela</label>
                        <select wire:model.live="filtro_escuela" id="filtro_escuela" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option value="">Todas las escuelas</option>
                            @foreach($escuelas as $escuela)
                                <option value="{{ $escuela->id_escuela }}">{{ $escuela->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <div class="space-y-1">
                        <label for="filtro_fecha_desde" class="block text-sm font-medium text-secondary-700">Vencimiento Desde</label>
                        <input wire:model.live="filtro_fecha_desde" type="date" id="filtro_fecha_desde" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    <div class="space-y-1">
                        <label for="filtro_fecha_hasta" class="block text-sm font-medium text-secondary-700">Vencimiento Hasta</label>
                        <input wire:model.live="filtro_fecha_hasta" type="date" id="filtro_fecha_hasta" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    <div class="lg:col-span-5 flex justify-end">
                        <button wire:click="limpiarFiltros" type="button" class="inline-flex justify-center items-center px-6 py-2 bg-secondary-200 border border-transparent rounded-lg font-medium text-sm text-secondary-800 hover:bg-secondary-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-500 transition-colors duration-200">
                            Limpiar Filtros
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Documentos -->
        <div class="bg-white rounded-xl border border-secondary-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-secondary-200">
                    <thead class="bg-secondary-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                                <button wire:click="sortBy('nombre_documento')" class="group inline-flex items-center hover:text-secondary-700">
                                    Documento
                                    @if($sortField === 'nombre_documento')
                                        <svg class="ml-2 w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"></path></svg>
                                    @else
                                        <svg class="ml-2 w-4 h-4 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path></svg>
                                    @endif
                                </button>
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                                <button wire:click="sortBy('id_escuela')" class="group inline-flex items-center hover:text-secondary-700">
                                    Escuela
                                    @if($sortField === 'id_escuela')
                                        <svg class="ml-2 w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"></path></svg>
                                    @else
                                        <svg class="ml-2 w-4 h-4 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path></svg>
                                    @endif
                                </button>
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Tipo</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-secondary-500 uppercase tracking-wider">Archivos</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                                <button wire:click="sortBy('fecha_vencimiento')" class="group inline-flex items-center hover:text-secondary-700">
                                    Vencimiento
                                    @if($sortField === 'fecha_vencimiento')
                                        <svg class="ml-2 w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"></path></svg>
                                    @else
                                        <svg class="ml-2 w-4 h-4 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path></svg>
                                    @endif
                                </button>
                            </th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-secondary-500 uppercase tracking-wider">Estado</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-secondary-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-secondary-200">
                        @forelse($documentos as $documento)
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
                            <tr class="hover:bg-secondary-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-secondary-900">{{ $documento->nombre_documento }}</div>
                                    <div class="text-sm text-secondary-500">{{ Str::limit($documento->descripcion, 50) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-800">{{ $documento->escuela->nombre ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-800">{{ $documento->tipoDocumento->nombre_tipo_documento ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($documento->cantidad_archivos > 0)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            {{ $documento->cantidad_archivos }}
                                        </span>
                                    @else
                                        <span class="text-secondary-400 text-sm">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-800">{{ $documento->fecha_vencimiento ? $documento->fecha_vencimiento->format('d/m/Y') : 'No vence' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{$estadoColor}}-100 text-{{$estadoColor}}-800">
                                        <svg class="w-1.5 h-1.5 mr-1.5" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3"/></svg>
                                        {{ $estado }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('documentos.show', $documento->id_documento) }}" class="p-2 text-secondary-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors duration-200" title="Ver detalles">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                        <a href="{{ route('documentos.edit', $documento->id_documento) }}" class="p-2 text-secondary-400 hover:text-warning-600 hover:bg-warning-50 rounded-lg transition-colors duration-200" title="Editar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        <button wire:click="eliminar({{ $documento->id_documento }})" wire:confirm="¿Estás seguro de que deseas eliminar este documento? Esta acción no se puede deshacer." class="p-2 text-secondary-400 hover:text-danger-600 hover:bg-danger-50 rounded-lg transition-colors duration-200" title="Eliminar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="text-secondary-500">No hay registros disponibles.</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="px-6 py-4 bg-secondary-50 border-t border-secondary-200">
                <div class="flex flex-col sm:flex-row items-center justify-between">
                    <div class="text-sm text-secondary-700 mb-4 sm:mb-0">
                        @if($documentos->total() > 0)
                            Mostrando <span class="font-medium text-secondary-900">{{ $documentos->firstItem() }}</span> a <span class="font-medium text-secondary-900">{{ $documentos->lastItem() }}</span> de <span class="font-medium text-secondary-900">{{ $documentos->total() }}</span> resultados
                        @else
                            No hay resultados para mostrar
                        @endif
                    </div>
                    @if($documentos->hasPages())
                        {{ $documentos->links('pagination.custom-tailwind') }}
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function exportarDocumentos(formato) {
            const filtroNombre = document.getElementById('filtro_nombre')?.value || '';
            const filtroTipo = document.getElementById('filtro_tipo_documento')?.value || '';
            const filtroDesde = document.getElementById('filtro_fecha_desde')?.value || '';
            const filtroHasta = document.getElementById('filtro_fecha_hasta')?.value || '';
            
            const params = new URLSearchParams();
            if (filtroNombre) params.append('filtro_nombre', filtroNombre);
            if (filtroTipo) params.append('filtro_tipo_documento', filtroTipo);
            if (filtroDesde) params.append('filtro_fecha_desde', filtroDesde);
            if (filtroHasta) params.append('filtro_fecha_hasta', filtroHasta);
            
            let url = '';
            switch(formato) {
                case 'csv':
                    url = '{{ route("documentos.export.csv") }}';
                    break;
                case 'excel':
                    url = '{{ route("documentos.export.excel") }}';
                    break;
                case 'pdf':
                    url = '{{ route("documentos.export.pdf") }}';
                    break;
            }
            
            if (params.toString()) {
                url += '?' + params.toString();
            }
            
            window.open(url, '_blank');
        }
    </script>
    @endpush
</div>