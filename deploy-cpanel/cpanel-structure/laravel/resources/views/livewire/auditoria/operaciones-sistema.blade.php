<div class="mx-auto px-4">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 mb-8">
        <div>
            <h1 class="text-2xl font-semibold text-secondary-900">Auditoría de Operaciones</h1>
            <p class="mt-1 text-sm text-secondary-600">Registro de operaciones realizadas en el sistema</p>
        </div>
        <div class="flex items-center space-x-3">
            <!-- Botón de Exportar -->
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="inline-flex items-center px-4 py-2 bg-white border border-secondary-300 rounded-lg font-medium text-sm text-secondary-700 hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    <i class="fas fa-download mr-2"></i>
                    Exportar
                    <i class="fas fa-chevron-down ml-2 -mr-1 h-5 w-5"></i>
                </button>
                <div x-show="open"
                     @click.away="open = false"
                     class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10"
                     style="display:none;"
                     x-transition>
                    <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                        <button onclick="exportarOperaciones('csv')" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900 w-full text-left" role="menuitem"><i class="fas fa-file-csv fa-fw text-secondary-400"></i>Exportar a CSV</button>
                        <button onclick="exportarOperaciones('excel')" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900 w-full text-left" role="menuitem"><i class="fas fa-file-excel fa-fw text-secondary-400"></i>Exportar a Excel</button>
                        <button onclick="exportarOperaciones('pdf')" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900 w-full text-left" role="menuitem"><i class="fas fa-file-pdf fa-fw text-secondary-400"></i>Exportar a PDF</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-xl border border-secondary-200 mb-6">
        <details class="group" open>
            <summary class="flex items-center justify-between p-6 cursor-pointer list-none">
                <div class="flex items-center text-secondary-900">
                    <svg class="w-5 h-5 mr-3 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"></path></svg>
                    <span class="font-medium">Filtros</span>
                </div>
                <svg class="w-5 h-5 text-secondary-400 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </summary>
            <div class="px-6 pb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="space-y-1">
                        <label for="filtro_usuario" class="block text-sm font-medium text-secondary-700">Usuario</label>
                        <input wire:model.live.debounce.300ms="filtro_usuario" type="text" id="filtro_usuario" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Buscar por usuario">
                    </div>
                    <div class="space-y-1">
                        <label for="filtro_tabla" class="block text-sm font-medium text-secondary-700">Tabla Afectada</label>
                        <input wire:model.live.debounce.300ms="filtro_tabla" type="text" id="filtro_tabla" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Buscar por tabla">
                    </div>
                    <div class="space-y-1">
                        <label for="filtro_fecha_desde" class="block text-sm font-medium text-secondary-700">Fecha Desde</label>
                        <input wire:model.live="filtro_fecha_desde" type="date" id="filtro_fecha_desde" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    <div class="space-y-1">
                        <label for="filtro_fecha_hasta" class="block text-sm font-medium text-secondary-700">Fecha Hasta</label>
                        <input wire:model.live="filtro_fecha_hasta" type="date" id="filtro_fecha_hasta" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    <div class="flex items-end">
                        <button wire:click="limpiarFiltros" type="button" class="w-full inline-flex justify-center items-center px-4 py-2 bg-secondary-200 border border-transparent rounded-lg font-medium text-sm text-secondary-700 hover:bg-secondary-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-500 transition-colors duration-200">
                            Limpiar Filtros
                        </button>
                    </div>
                </div>
            </div>
        </details>
    </div>

    <!-- Tabla de Operaciones -->
    <div class="bg-white rounded-xl border border-secondary-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-secondary-200">
                <thead class="bg-secondary-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                            <button wire:click="sortBy('usuarios.email')" class="group inline-flex items-center hover:text-secondary-700">Usuario</button>
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                            <button wire:click="sortBy('tabla_afectada')" class="group inline-flex items-center hover:text-secondary-700">Tabla</button>
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                            <button wire:click="sortBy('accion')" class="group inline-flex items-center hover:text-secondary-700">Acción</button>
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                            <button wire:click="sortBy('fecha_hora')" class="group inline-flex items-center hover:text-secondary-700">Fecha y Hora</button>
                        </th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-secondary-500 uppercase tracking-wider">
                            Detalles
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-secondary-200">
                    @forelse($operaciones as $operacion)
                    <tr class="hover:bg-secondary-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-secondary-900">{{ $operacion->usuario->email ?? 'N/A' }}</div>
                            <div class="text-sm text-secondary-500">{{ $operacion->usuario->nombre ?? '' }} {{ $operacion->usuario->apellido ?? '' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-secondary-900">{{ $operacion->tabla_afectada }}</div>
                            <div class="text-sm text-secondary-500">ID: {{ $operacion->id_registro }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                @switch($operacion->accion)
                                    @case('CREAR') bg-success-100 text-success-800 @break
                                    @case('ACTUALIZAR') bg-info-100 text-info-800 @break
                                    @case('ELIMINAR') bg-danger-100 text-danger-800 @break
                                    @default bg-secondary-100 text-secondary-800
                                @endswitch
                            ">
                                {{ $operacion->accion }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-secondary-900">{{ $operacion->fecha_hora->format('d/m/Y H:i:s') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <button wire:click="mostrarDetalles('{{ $operacion->datos_anteriores }}', '{{ $operacion->datos_nuevos }}')" class="p-2 text-secondary-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors duration-200" title="Ver detalles">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="text-secondary-500">No hay operaciones que coincidan con los filtros.</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Información de paginación y controles -->
        <div class="px-6 py-4 bg-secondary-50 border-t border-secondary-200">
            <div class="flex flex-col sm:flex-row items-center justify-between space-y-3 sm:space-y-0">
                <div class="text-sm text-secondary-700">
                    @if($operaciones->total() > 0)
                        Mostrando {{ $operaciones->firstItem() }} a {{ $operaciones->lastItem() }} de {{ $operaciones->total() }} resultados
                    @else
                        No hay resultados para mostrar
                    @endif
                </div>
                @if($operaciones->hasPages())
                    <div class="flex-shrink-0">
                        {{ $operaciones->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if($showModal)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Detalles de la Operación</h3>
                    <button wire:click="cerrarModal" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="space-y-4">
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Datos Anteriores:</h4>
                        <div class="bg-gray-50 rounded-lg p-3 max-h-60 overflow-y-auto">
                            <pre class="text-sm text-gray-600 whitespace-pre-wrap">{{ $datosAnteriores }}</pre>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Datos Nuevos:</h4>
                        <div class="bg-gray-50 rounded-lg p-3 max-h-60 overflow-y-auto">
                            <pre class="text-sm text-gray-600 whitespace-pre-wrap">{{ $datosNuevos }}</pre>
                        </div>
                    </div>
                </div>
                <div class="mt-5">
                    <button wire:click="cerrarModal" class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:text-sm">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
    function exportarOperaciones(formato) {
        const params = new URLSearchParams({
            filtro_usuario: document.getElementById('filtro_usuario')?.value || '',
            filtro_tabla: document.getElementById('filtro_tabla')?.value || '',
            filtro_fecha_desde: document.getElementById('filtro_fecha_desde')?.value || '',
            filtro_fecha_hasta: document.getElementById('filtro_fecha_hasta')?.value || '',
        });
        
        let url = '';
        switch(formato) {
            case 'csv':
                url = '{{ route("auditoria.export.operaciones.csv") }}';
                break;
            case 'excel':
                url = '{{ route("auditoria.export.operaciones.excel") }}';
                break;
            case 'pdf':
                url = '{{ route("auditoria.export.operaciones.pdf") }}';
                break;
        }
        
        if (params.toString()) {
            url += '?' + params.toString();
        }
        
        window.open(url, '_blank');
    }
</script>
@endpush