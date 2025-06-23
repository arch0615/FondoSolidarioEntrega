<div>
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 mb-8">
        <div>
            <h1 class="text-2xl font-semibold text-secondary-900">Gestión de Beneficiarios SVO</h1>
            <p class="mt-1 text-sm text-secondary-600">Administra los beneficiarios del Seguro de Vida Obligatorio</p>
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
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95">
                    <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                        <button onclick="exportarBeneficiarios('csv')" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900 w-full text-left" role="menuitem">
                            <i class="fas fa-file-csv fa-fw text-secondary-400"></i>
                            Exportar a CSV
                        </button>
                        <button onclick="exportarBeneficiarios('excel')" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900 w-full text-left" role="menuitem">
                            <i class="fas fa-file-excel fa-fw text-secondary-400"></i>
                            Exportar a Excel
                        </button>
                        <button onclick="exportarBeneficiarios('pdf')" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900 w-full text-left" role="menuitem">
                            <i class="fas fa-file-pdf fa-fw text-secondary-400"></i>
                            Exportar a PDF
                        </button>
                    </div>
                </div>
            </div>
            <a href="{{ route('beneficiarios_svo.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nuevo Beneficiario
            </a>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="mb-6 bg-success-50 border border-success-200 text-success-700 px-4 py-3 rounded-lg relative">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="font-medium">{{ session('message') }}</span>
            </div>
        </div>
    @endif

    <!-- Filtros -->
    <div class="bg-white rounded-xl border border-secondary-200 mb-6">
        <details class="group" open>
            <summary class="flex items-center justify-between p-6 cursor-pointer list-none">
                <div class="flex items-center text-secondary-900">
                    <svg class="w-5 h-5 mr-3 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"></path>
                    </svg>
                    <span class="font-medium">Filtros</span>
                </div>
                <svg class="w-5 h-5 text-secondary-400 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </summary>
            <div class="px-6 pb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="space-y-1">
                        <label for="filtro_nombre" class="block text-sm font-medium text-secondary-700">Beneficiario / Empleado</label>
                        <input wire:model.live="filtro_nombre" type="text" id="filtro_nombre" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Buscar por nombre o apellido">
                    </div>
                     <div class="space-y-1">
                        <label for="filtro_dni" class="block text-sm font-medium text-secondary-700">DNI</label>
                        <input wire:model.live="filtro_dni" type="text" id="filtro_dni" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Buscar por DNI">
                    </div>
                    @if(Auth::user()->rol !== 'Usuario General')
                    @if(Auth::user()->rol !== 'usuario_general')
                     <div class="space-y-1">
                        <label for="filtro_escuela" class="block text-sm font-medium text-secondary-700">Escuela</label>
                        <select wire:model.live="filtro_escuela" id="filtro_escuela" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option value="">Todas</option>
                            @foreach($escuelas as $escuela)
                                <option value="{{ $escuela->id_escuela }}">{{ $escuela->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    @endif
                    <div class="space-y-1">
                        <label for="filtro_estado" class="block text-sm font-medium text-secondary-700">Estado</label>
                        <select wire:model.live="filtro_estado" id="filtro_estado" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option value="">Todos</option>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button wire:click="limpiarFiltros" type="button" class="w-full inline-flex justify-center items-center px-4 py-2 bg-secondary-100 border border-transparent rounded-lg font-medium text-sm text-secondary-700 hover:bg-secondary-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-500 transition-colors duration-200">
                            Limpiar
                        </button>
                    </div>
                </div>
            </div>
        </details>
    </div>

    <!-- Tabla de Beneficiarios SVO -->
    <div class="bg-white rounded-xl border border-secondary-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-secondary-200">
                <thead class="bg-secondary-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                            <button wire:click="sortBy('empleado.nombre')" class="group inline-flex items-center hover:text-secondary-700">
                                Empleado
                                @if($sortField === 'empleado.nombre')
                                    @if($sortDirection === 'asc') <svg class="ml-2 w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                    @else <svg class="ml-2 w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg> @endif
                                @else <svg class="ml-2 w-4 h-4 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path></svg>
                                @endif
                            </button>
                        </th>
                        @if(Auth::user()->rol !== 'Usuario General')
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                            <button wire:click="sortBy('escuela.nombre')" class="group inline-flex items-center hover:text-secondary-700">
                                Escuela
                                @if($sortField === 'escuela.nombre')
                                    @if($sortDirection === 'asc') <svg class="ml-2 w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                    @else <svg class="ml-2 w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg> @endif
                                @else <svg class="ml-2 w-4 h-4 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path></svg>
                                @endif
                            </button>
                        </th>
                        @endif
                         <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                             <button wire:click="sortBy('apellido')" class="group inline-flex items-center hover:text-secondary-700">
                                 Beneficiario
                                @if($sortField === 'apellido')
                                    @if($sortDirection === 'asc') <svg class="ml-2 w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                    @else <svg class="ml-2 w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg> @endif
                                @else <svg class="ml-2 w-4 h-4 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path></svg>
                                @endif
                            </button>
                        </th>
                         <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                             <button wire:click="sortBy('id_parentesco')" class="group inline-flex items-center hover:text-secondary-700">
                                Parentesco
                                @if($sortField === 'id_parentesco')
                                    @if($sortDirection === 'asc') <svg class="ml-2 w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                    @else <svg class="ml-2 w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg> @endif
                                @else <svg class="ml-2 w-4 h-4 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path></svg>
                                @endif
                            </button>
                        </th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-secondary-500 uppercase tracking-wider">
                            Porcentaje
                        </th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-secondary-500 uppercase tracking-wider">
                            Estado
                        </th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-secondary-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-secondary-200">
                    @forelse($beneficiarios as $beneficiario)
                    <tr class="hover:bg-secondary-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-secondary-900">{{ $beneficiario->empleado->apellido ?? 'N/A' }}, {{ $beneficiario->empleado->nombre ?? 'N/A' }}</div>
                            <div class="text-xs text-secondary-500">DNI: {{ $beneficiario->empleado->dni ?? 'N/A' }}</div>
                        </td>
                        @if(Auth::user()->rol !== 'Usuario General')
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-secondary-500">{{ $beneficiario->escuela->nombre ?? 'N/A' }}</div>
                        </td>
                        @endif
                         <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-secondary-900">{{ $beneficiario->apellido }}, {{ $beneficiario->nombre }}</div>
                            <div class="text-xs text-secondary-500">DNI: {{ $beneficiario->dni }}</div>
                        </td>
                         <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-secondary-900">{{ $beneficiario->parentesco->nombre_parentesco ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="text-sm font-medium text-secondary-900">{{ $beneficiario->porcentaje }}%</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <button wire:click="cambiarEstado({{ $beneficiario->id_beneficiario }})"
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $beneficiario->activo ? 'bg-success-100 text-success-800' : 'bg-danger-100 text-danger-800' }}
                                transition-colors duration-200 hover:bg-opacity-80">
                                <svg class="w-1.5 h-1.5 mr-1.5" fill="currentColor" viewBox="0 0 8 8">
                                    <circle cx="4" cy="4" r="3"/>
                                </svg>
                                {{ $beneficiario->activo ? 'Activo' : 'Inactivo' }}
                            </button>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <a href="{{ route('beneficiarios_svo.show', $beneficiario->id_beneficiario) }}" class="p-2 text-secondary-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors duration-200" title="Ver detalles">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>
                                <a href="{{ route('beneficiarios_svo.edit', $beneficiario->id_beneficiario) }}" class="p-2 text-secondary-400 hover:text-warning-600 hover:bg-warning-50 rounded-lg transition-colors duration-200" title="Editar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <button wire:click="eliminar({{ $beneficiario->id_beneficiario }})" wire:confirm="¿Está seguro que desea eliminar este beneficiario?" class="p-2 text-secondary-400 hover:text-danger-600 hover:bg-danger-50 rounded-lg transition-colors duration-200" title="Eliminar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ Auth::user()->rol !== 'Usuario General' ? '7' : '6' }}" class="px-6 py-12 text-center">
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
                    @if($beneficiarios->total() > 0)
                        Mostrando <span class="font-medium text-secondary-900">{{ $beneficiarios->firstItem() }}</span> a <span class="font-medium text-secondary-900">{{ $beneficiarios->lastItem() }}</span> de <span class="font-medium text-secondary-900">{{ $beneficiarios->total() }}</span> resultados
                    @else
                        No hay resultados para mostrar
                    @endif
                </div>
                @if($beneficiarios->hasPages())
                    {{ $beneficiarios->links('pagination.custom-tailwind') }}
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function exportarBeneficiarios(formato) {
        const filtroNombre = @this.get('filtro_nombre');
        const filtroDni = @this.get('filtro_dni');
        const filtroEscuela = @this.get('filtro_escuela');
        const filtroEstado = @this.get('filtro_estado');
        
        const params = new URLSearchParams();
        if (filtroNombre) params.append('filtro_nombre', filtroNombre);
        if (filtroDni) params.append('filtro_dni', filtroDni);
        if (filtroEscuela) params.append('filtro_escuela', filtroEscuela);
        if (filtroEstado !== '') params.append('filtro_estado', filtroEstado);
        
        let url = '';
        switch(formato) {
            case 'csv':
                url = '{{ route("beneficiarios_svo.export.csv") }}';
                break;
            case 'excel':
                url = '{{ route("beneficiarios_svo.export.excel") }}';
                break;
            case 'pdf':
                url = '{{ route("beneficiarios_svo.export.pdf") }}';
                break;
        }
        
        if (params.toString()) {
            url += '?' + params.toString();
        }
        
        window.open(url, '_blank');
    }
</script>
@endpush