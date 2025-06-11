<div>
    <div class="mx-auto px-4">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 mb-8">
            <div>
                <h1 class="text-2xl font-semibold text-secondary-900">Gestión de Pagos</h1>
                <p class="mt-1 text-sm text-secondary-600">Revisa los reintegros autorizados y márcalos como pagados.</p>
            </div>
        </div>
    
        <!-- Sección de Reintegros Pendientes -->
        <div class="mb-12">
            <h2 class="text-xl font-semibold text-secondary-800 mb-4">Reintegros Pendientes de Pago</h2>
            <div class="bg-white rounded-xl border border-secondary-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-secondary-200">
                        <thead class="bg-secondary-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">ID Reintegro</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Alumno (Escuela)</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Fecha Autorización</th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-medium text-secondary-500 uppercase tracking-wider">Monto a Pagar</th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-secondary-500 uppercase tracking-wider">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-secondary-200">
                            @forelse ($pendientes as $reintegro)
                            <tr class="hover:bg-secondary-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-secondary-900">{{ $reintegro['id_reintegro'] }}</div>
                                    <div class="text-xs text-secondary-500">Accidente #{{ $reintegro['id_accidente'] }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-secondary-900">{{ $reintegro['nombre_alumno'] }}</div>
                                    <div class="text-sm text-secondary-500">{{ $reintegro['escuela'] }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-secondary-900">{{ \Carbon\Carbon::parse($reintegro['fecha_autorizacion'])->format('d/m/Y') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="text-sm font-bold text-secondary-900">$ {{ number_format($reintegro['monto'], 2) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <button wire:click="iniciarPago({{ $reintegro['id_reintegro'] }})" class="inline-flex items-center px-4 py-2 bg-success-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-success-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-success-500 transition-colors duration-200">
                                        <i class="fas fa-check-circle mr-2"></i>
                                        Marcar como Pagado
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="text-center">
                                        <svg class="mx-auto h-12 w-12 text-secondary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-secondary-900">No hay pagos pendientes</h3>
                                        <p class="mt-1 text-sm text-secondary-500">Todos los reintegros autorizados están al día.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    
        <!-- Sección de Historial de Pagos -->
        <div>
            <h2 class="text-xl font-semibold text-secondary-800 mb-4">Historial de Pagos</h2>
            
            <!-- Filtros -->
            <div class="bg-white rounded-xl border border-secondary-200 p-4 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="filtroEscuela" class="block text-sm font-medium text-secondary-700">Filtrar por Escuela</label>
                        <select id="filtroEscuela" wire:model.live="filtroEscuela" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-secondary-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md">
                            <option value="">Todas las escuelas</option>
                            @foreach($escuelas as $escuela)
                                <option value="{{ $escuela }}">{{ $escuela }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="filtroFechaDesde" class="block text-sm font-medium text-secondary-700">Fecha de Pago Desde</label>
                        <input type="date" id="filtroFechaDesde" wire:model.live="filtroFechaDesde" class="mt-1 block w-full rounded-md border-secondary-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="filtroFechaHasta" class="block text-sm font-medium text-secondary-700">Fecha de Pago Hasta</label>
                        <input type="date" id="filtroFechaHasta" wire:model.live="filtroFechaHasta" class="mt-1 block w-full rounded-md border-secondary-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-secondary-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-secondary-200">
                        <thead class="bg-secondary-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">ID Reintegro</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Alumno (Escuela)</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Fecha de Pago</th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-medium text-secondary-500 uppercase tracking-wider">Monto Pagado</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Nro. Transferencia</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-secondary-200">
                            @forelse ($historialPaginado as $reintegro)
                            <tr class="hover:bg-secondary-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-secondary-900">{{ $reintegro['id_reintegro'] }}</div>
                                     <div class="text-xs text-secondary-500">Accidente #{{ $reintegro['id_accidente'] }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-secondary-900">{{ $reintegro['nombre_alumno'] }}</div>
                                    <div class="text-sm text-secondary-500">{{ $reintegro['escuela'] }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-secondary-900">{{ \Carbon\Carbon::parse($reintegro['fecha_pago'])->format('d/m/Y') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="text-sm font-medium text-secondary-900">$ {{ number_format($reintegro['monto'], 2) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-secondary-700">{{ $reintegro['numero_transferencia'] }}</div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="text-center">
                                        <svg class="mx-auto h-12 w-12 text-secondary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7M3 7l9 6 9-6" />
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-secondary-900">No hay pagos que coincidan con los filtros</h3>
                                        <p class="mt-1 text-sm text-secondary-500">Intenta ajustar los filtros de búsqueda.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Paginación Mockup -->
                <div class="px-6 py-4 bg-secondary-50 border-t border-secondary-200 flex flex-col sm:flex-row items-center justify-between">
                    <div class="text-sm text-secondary-700 mb-4 sm:mb-0">
                        Mostrando <span class="font-medium text-secondary-900">{{ $historialPaginado->firstItem() }}</span> a <span class="font-medium text-secondary-900">{{ $historialPaginado->lastItem() }}</span> de <span class="font-medium text-secondary-900">{{ $historialPaginado->total() }}</span> resultados
                    </div>
                    @if ($historialPaginado->hasPages())
                        <nav class="inline-flex rounded-lg shadow-sm" aria-label="Paginación">
                            {{-- Previous Page Link --}}
                            @if ($historialPaginado->onFirstPage())
                                <span class="relative inline-flex items-center px-2 py-2 rounded-l-lg border border-secondary-300 bg-white text-sm font-medium text-secondary-300 cursor-not-allowed">
                                    <span class="sr-only">Anterior</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                </span>
                            @else
                                <button wire:click="previousPage" class="relative inline-flex items-center px-2 py-2 rounded-l-lg border border-secondary-300 bg-white text-sm font-medium text-secondary-500 hover:bg-secondary-50">
                                    <span class="sr-only">Anterior</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                </button>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($historialPaginado->links()->elements as $element)
                                {{-- "Three Dots" Separator --}}
                                @if (is_string($element))
                                    <span class="relative inline-flex items-center px-4 py-2 border border-secondary-300 bg-white text-sm font-medium text-secondary-700">{{ $element }}</span>
                                @endif

                                {{-- Array Of Links --}}
                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        @if ($page == $historialPaginado->currentPage())
                                            <span aria-current="page" class="relative inline-flex items-center px-4 py-2 border border-secondary-300 bg-primary-600 text-sm font-medium text-white">
                                                {{ $page }}
                                            </span>
                                        @else
                                            <button wire:click="gotoPage({{ $page }})" class="relative inline-flex items-center px-4 py-2 border border-secondary-300 bg-white text-sm font-medium text-secondary-700 hover:bg-secondary-50">
                                                {{ $page }}
                                            </button>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($historialPaginado->hasMorePages())
                                <button wire:click="nextPage" class="relative inline-flex items-center px-2 py-2 rounded-r-lg border border-secondary-300 bg-white text-sm font-medium text-secondary-500 hover:bg-secondary-50">
                                    <span class="sr-only">Siguiente</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </button>
                            @else
                                <span class="relative inline-flex items-center px-2 py-2 rounded-r-lg border border-secondary-300 bg-white text-sm font-medium text-secondary-300 cursor-not-allowed">
                                    <span class="sr-only">Siguiente</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </span>
                            @endif
                        </nav>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmación de Pago -->
    @if($showPagoModal)
    <div class="fixed inset-0 bg-secondary-900 bg-opacity-50 overflow-y-auto h-full w-full z-50" x-data="{ show: @entangle('showPagoModal') }" x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white" @click.away="show = false">
            <form wire:submit.prevent="confirmarPago">
                <div class="mt-3 text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-success-100">
                        <i class="fas fa-dollar-sign text-success-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg leading-6 font-medium text-secondary-900 mt-4">Confirmar Pago</h3>
                    <div class="mt-2 px-7 py-3">
                        <p class="text-sm text-secondary-500">
                            Estás a punto de registrar el pago para el reintegro #{{ $reintegroSeleccionado['id_reintegro'] }} del alumno <strong>{{ $reintegroSeleccionado['nombre_alumno'] }}</strong> por un monto de <strong>${{ number_format($reintegroSeleccionado['monto'], 2) }}</strong>.
                        </p>
                        <div class="mt-4 space-y-4 text-left">
                            <div>
                                <label for="fecha_pago" class="block text-sm font-medium text-secondary-700">Fecha de Pago</label>
                                <input type="date" wire:model="fecha_pago" id="fecha_pago" class="mt-1 block w-full rounded-md border-secondary-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                @error('fecha_pago') <span class="text-danger-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="numero_transferencia" class="block text-sm font-medium text-secondary-700">Número de Transferencia/Comprobante</label>
                                <input type="text" wire:model="numero_transferencia" id="numero_transferencia" class="mt-1 block w-full rounded-md border-secondary-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" placeholder="Ej: TR-123456">
                                @error('numero_transferencia') <span class="text-danger-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="items-center px-4 py-3 bg-secondary-50 rounded-b-md">
                    <div class="flex justify-end gap-3">
                        <button type="button" wire:click="$set('showPagoModal', false)" class="px-4 py-2 bg-white text-secondary-700 border border-secondary-300 rounded-md shadow-sm hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            Cancelar
                        </button>
                        <button type="submit" class="px-4 py-2 bg-success-600 text-white rounded-md hover:bg-success-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-success-500">
                            Confirmar Pago
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
