<div class="mx-auto px-4">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 mb-8">
        <div>
            <h1 class="text-2xl font-semibold text-secondary-900">Auditoría de Accesos al Sistema</h1>
            <p class="mt-1 text-sm text-secondary-600">Registro de inicios y cierres de sesión</p>
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
                        <button onclick="exportarAccesos('csv')" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900 w-full text-left" role="menuitem"><i class="fas fa-file-csv fa-fw text-secondary-400"></i>Exportar a CSV</button>
                        <button onclick="exportarAccesos('excel')" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900 w-full text-left" role="menuitem"><i class="fas fa-file-excel fa-fw text-secondary-400"></i>Exportar a Excel</button>
                        <button onclick="exportarAccesos('pdf')" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900 w-full text-left" role="menuitem"><i class="fas fa-file-pdf fa-fw text-secondary-400"></i>Exportar a PDF</button>
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
                        <input wire:model.live.debounce.300ms="filtro_usuario" type="text" id="filtro_usuario" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Buscar por nombre, apellido o email">
                    </div>
                    <div class="space-y-1">
                        <label for="filtro_fecha_desde" class="block text-sm font-medium text-secondary-700">Fecha Desde</label>
                        <input wire:model.live="filtro_fecha_desde" type="date" id="filtro_fecha_desde" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    <div class="space-y-1">
                        <label for="filtro_fecha_hasta" class="block text-sm font-medium text-secondary-700">Fecha Hasta</label>
                        <input wire:model.live="filtro_fecha_hasta" type="date" id="filtro_fecha_hasta" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    <div class="space-y-1">
                        <label for="filtro_ip" class="block text-sm font-medium text-secondary-700">Dirección IP</label>
                        <input wire:model.live.debounce.300ms="filtro_ip" type="text" id="filtro_ip" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Buscar por IP">
                    </div>
                </div>
            </div>
        </details>
    </div>

    <!-- Tabla de Accesos -->
    <div class="bg-white rounded-xl border border-secondary-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-secondary-200">
                <thead class="bg-secondary-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                            <button wire:click="sortBy('usuarios.email')" class="group inline-flex items-center hover:text-secondary-700">
                                Usuario
                                @if($sortField === 'usuarios.email')
                                    @if($sortDirection === 'asc') <svg class="ml-2 w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                    @else <svg class="ml-2 w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    @endif
                                @else <svg class="ml-2 w-4 h-4 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path></svg>
                                @endif
                            </button>
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                            <button wire:click="sortBy('accion')" class="group inline-flex items-center hover:text-secondary-700">
                                Acción
                                @if($sortField === 'accion')
                                    @if($sortDirection === 'asc') <svg class="ml-2 w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                    @else <svg class="ml-2 w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    @endif
                                @else <svg class="ml-2 w-4 h-4 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path></svg>
                                @endif
                            </button>
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                            <button wire:click="sortBy('fecha_hora')" class="group inline-flex items-center hover:text-secondary-700">
                                Fecha y Hora
                                @if($sortField === 'fecha_hora')
                                    @if($sortDirection === 'asc') <svg class="ml-2 w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                    @else <svg class="ml-2 w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    @endif
                                @else <svg class="ml-2 w-4 h-4 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path></svg>
                                @endif
                            </button>
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                            <button wire:click="sortBy('ip_usuario')" class="group inline-flex items-center hover:text-secondary-700">
                                Dirección IP
                                @if($sortField === 'ip_usuario')
                                    @if($sortDirection === 'asc') <svg class="ml-2 w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                    @else <svg class="ml-2 w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    @endif
                                @else <svg class="ml-2 w-4 h-4 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path></svg>
                                @endif
                            </button>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-secondary-200">
                    @forelse($accesos as $acceso)
                    <tr class="hover:bg-secondary-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-secondary-900">{{ $acceso->usuario->email ?? 'Usuario no encontrado' }}</div>
                            <div class="text-sm text-secondary-500">{{ $acceso->usuario->nombre ?? '' }} {{ $acceso->usuario->apellido ?? '' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($acceso->accion == 'LOGIN')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-100 text-success-800">
                                <svg class="w-1.5 h-1.5 mr-1.5" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3"/></svg>
                                LOGIN
                            </span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-secondary-100 text-secondary-700">
                                <svg class="w-1.5 h-1.5 mr-1.5" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3"/></svg>
                                LOGOUT
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-secondary-900">{{ $acceso->fecha_hora->format('d/m/Y H:i:s') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-secondary-900">{{ $acceso->ip_usuario }}</div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="text-secondary-500">No hay registros de acceso que coincidan con los filtros.</div>
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
                    @if($accesos->total() > 0)
                        Mostrando {{ $accesos->firstItem() }} a {{ $accesos->lastItem() }} de {{ $accesos->total() }} resultados
                    @else
                        No hay resultados para mostrar
                    @endif
                </div>
                @if($accesos->hasPages())
                    <div class="flex-shrink-0">
                        {{ $accesos->links('vendor.pagination.custom-tailwind') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function exportarAccesos(formato) {
        const filtroUsuario = document.getElementById('filtro_usuario')?.value || '';
        const filtroFechaDesde = document.getElementById('filtro_fecha_desde')?.value || '';
        const filtroFechaHasta = document.getElementById('filtro_fecha_hasta')?.value || '';
        const filtroIp = document.getElementById('filtro_ip')?.value || '';
        
        const params = new URLSearchParams();
        if (filtroUsuario) params.append('filtro_usuario', filtroUsuario);
        if (filtroFechaDesde) params.append('filtro_fecha_desde', filtroFechaDesde);
        if (filtroFechaHasta) params.append('filtro_fecha_hasta', filtroFechaHasta);
        if (filtroIp) params.append('filtro_ip', filtroIp);
        
        let url = '';
        switch(formato) {
            case 'csv':
                url = '{{ route("auditoria.export.accesos.csv") }}';
                break;
            case 'excel':
                url = '{{ route("auditoria.export.accesos.excel") }}';
                break;
            case 'pdf':
                url = '{{ route("auditoria.export.accesos.pdf") }}';
                break;
        }
        
        if (params.toString()) {
            url += '?' + params.toString();
        }
        
        window.open(url, '_blank');
    }
</script>
@endpush