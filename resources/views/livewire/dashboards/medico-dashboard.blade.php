<div>
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-6">
        @foreach($stats as $key => $stat)
        <div class="bg-white rounded-lg border border-{{ $stat['color'] }}-200 p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="text-center">
                <p class="text-sm font-medium text-gray-600 mb-2">
                    @switch($key)
                        @case('reintegros_pendientes') Pendientes Auditoría @break
                        @case('reintegros_autorizados') Autorizados @break
                        @case('reintegros_rechazados') Rechazados @break
                        @case('solicitudes_informacion') Info. Solicitada @break
                        @case('tiempo_promedio_revision') Tiempo Promedio @break
                    @endswitch
                </p>
                <p class="text-3xl font-bold text-{{ $stat['color'] }}-700 mb-1">{{ $stat['total'] }}</p>
                <p class="text-xs text-{{ $stat['color'] }}-600">{{ $stat['incremento'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Activity -->
        <div class="lg:col-span-2 bg-white rounded-lg border border-gray-200 p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Actividad Médica Reciente</h3>
            
            <div class="space-y-4">
                @foreach($recentActivity as $activity)
                <div class="flex items-center justify-between p-4 bg-{{ $activity['color'] }}-25 border border-{{ $activity['color'] }}-100 rounded-lg hover:bg-{{ $activity['color'] }}-50 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-{{ $activity['color'] }}-100 rounded-lg border border-{{ $activity['color'] }}-200">
                            <i class="{{ $activity['icono'] }} text-{{ $activity['color'] }}-600"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ $activity['titulo'] }}</p>
                            <p class="text-sm text-gray-600">{{ $activity['descripcion'] }}</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500">{{ $activity['tiempo'] }}</p>
                </div>
                @endforeach
            </div>

            <div class="mt-4 pt-4 border-t border-gray-200">
                <button class="w-full text-center text-sm text-green-600 hover:text-green-800 font-medium">
                    Ver historial completo de auditorías →
                </button>
            </div>
        </div>

        <!-- Medical Actions -->
        <div class="bg-white rounded-lg border border-green-200 p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-green-800 mb-4">Acciones Médicas</h3>
            
            <div class="space-y-3">
                <button class="w-full flex items-center gap-3 p-3 bg-amber-600 hover:bg-amber-700 text-white rounded-lg transition-all duration-200 hover:shadow-md">
                    <i class="fas fa-clipboard-check"></i>
                    <span>Revisar Pendientes</span>
                    @if($stats['reintegros_pendientes']['total'] > 0)
                    <span class="ml-auto bg-white text-amber-600 text-xs rounded-full px-2 py-1">{{ $stats['reintegros_pendientes']['total'] }}</span>
                    @endif
                </button>
                
                <button class="w-full flex items-center gap-3 p-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-all duration-200 hover:shadow-md">
                    <i class="fas fa-info-circle"></i>
                    <span>Info. Solicitada</span>
                    @if($stats['solicitudes_informacion']['total'] > 0)
                    <span class="ml-auto bg-white text-blue-600 text-xs rounded-full px-2 py-1">{{ $stats['solicitudes_informacion']['total'] }}</span>
                    @endif
                </button>

                <button class="w-full flex items-center gap-3 p-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-all duration-200 hover:shadow-md">
                    <i class="fas fa-check-circle"></i>
                    <span>Historial Autorizados</span>
                </button>
            </div>
        </div>
    </div>
</div>