<div wire:key="historial-auditorias-{{ now() }}">
    <div class="mx-auto px-4">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 mb-8">
        <div>
            <h1 class="text-2xl font-semibold text-secondary-900">Historial de Auditorías</h1>
            <p class="mt-1 text-sm text-secondary-600">Consulta el historial de reintegros auditados.</p>
        </div>
    </div>

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
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="space-y-1">
                        <label for="filtro_escuela" class="block text-sm font-medium text-secondary-700">Escuela</label>
                        <select wire:model.live="filtro_escuela" id="filtro_escuela" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option value="">Todas</option>
                            @foreach($escuelas as $escuela)
                                <option value="{{ $escuela->id_escuela }}">{{ $escuela->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label for="filtro_fecha_desde" class="block text-sm font-medium text-secondary-700">Fecha Desde</label>
                        <input wire:model.live="filtro_fecha_desde" type="date" id="filtro_fecha_desde" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm">
                    </div>
                    <div class="space-y-1">
                        <label for="filtro_fecha_hasta" class="block text-sm font-medium text-secondary-700">Fecha Hasta</label>
                        <input wire:model.live="filtro_fecha_hasta" type="date" id="filtro_fecha_hasta" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm">
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

    <!-- Tabla de Solicitudes de Auditor -->
    <div class="mb-12">
        <h2 class="text-xl font-semibold text-secondary-800 mb-4">Solicitudes de Información de Auditores</h2>
        <div class="bg-white rounded-xl border border-secondary-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-secondary-200">
                    <thead class="bg-secondary-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider"><button wire:click="sortBy('fecha_solicitud')">Fecha</button></th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Alumno</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Escuela</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Evento</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Auditor</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-secondary-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-secondary-200">
                        @forelse ($solicitudes as $solicitud)
                            @php
                                $evento = $solicitud->estadoSolicitud->nombre_estado ?? 'N/A';
                                $color = 'secondary';
                                if ($solicitud->id_estado_solicitud == 1) { $color = 'warning'; } // Pendiente
                                if ($solicitud->id_estado_solicitud == 2) { $color = 'success'; } // Respondida
                                if ($solicitud->id_estado_solicitud == 3) { $color = 'secondary'; } // Cerrada
                            @endphp
                            <tr class="hover:bg-secondary-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap"><div class="text-sm font-medium text-secondary-900">{{ $solicitud->fecha_solicitud->format('d/m/Y H:i:s') }}</div></td>
                                <td class="px-6 py-4 whitespace-nowrap"><div class="text-sm text-secondary-900">{{ $solicitud->reintegro->accidente->alumnos->first()->alumno->nombre_completo ?? 'N/A' }}</div></td>
                                <td class="px-6 py-4 whitespace-nowrap"><div class="text-sm text-secondary-900">{{ $solicitud->reintegro->accidente->escuela->nombre ?? 'N/A' }}</div></td>
                                <td class="px-6 py-4 whitespace-nowrap text-center"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $color }}-100 text-{{ $color }}-800">{{ $evento }}</span></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-500">{{ $solicitud->auditor->email ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <a href="{{ route('auditoria.detalle', ['type' => 'solicitud', 'id' => $solicitud->id_solicitud]) }}" class="p-2 text-secondary-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors duration-200" title="Ver detalles">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-6 py-12 text-center text-sm text-secondary-500">No hay solicitudes de información que coincidan con los filtros.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 bg-secondary-50 border-t border-secondary-200">{{ $solicitudes->links() }}</div>
        </div>
    </div>


</div>
</div>