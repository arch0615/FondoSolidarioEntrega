<div>
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        @foreach($stats as $key => $stat)
        <div class="bg-white rounded-lg border border-{{ $stat['color'] }}-200 p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="text-center">
                <p class="text-sm font-medium text-gray-600 mb-2">
                    @switch($key)
                        @case('total_escuelas') Escuelas Activas @break
                        @case('total_accidentes') Total Accidentes @break
                        @case('reintegros_autorizados') Reintegros Autorizados @break
                        @case('monto_total_pagado') Monto Total Pagado @break
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
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Actividad Reciente del Sistema</h3>
            
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
                <button class="w-full text-center text-sm text-blue-600 hover:text-blue-800 font-medium">
                    Ver todas las actividades →
                </button>
            </div>
        </div>

        <!-- Management Actions -->
        <div class="bg-white rounded-lg border border-blue-200 p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-blue-800 mb-4">Accesos Rápidos</h3>
            
            <div class="space-y-3">
                <button class="w-full flex items-center gap-3 p-3 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-all duration-200 hover:shadow-md">
                    <i class="fas fa-medkit"></i>
                    <span>Accidentes</span>
                </button>
                
                <a href="{{ route('escuelas.index') }}" class="w-full flex items-center gap-3 p-3 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition-all duration-200 hover:shadow-md">
                    <i class="fas fa-school"></i>
                    <span>Gestionar Escuelas</span>
                </a>

                <a href="{{ route('usuarios.index') }}" class="w-full flex items-center gap-3 p-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-all duration-200 hover:shadow-md">
                    <i class="fas fa-users-cog"></i>
                    <span>Gestionar Usuarios</span>
                </a>

                <button class="w-full flex items-center gap-3 p-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-all duration-200 hover:shadow-md">
                    <i class="fas fa-dollar-sign"></i>
                    <span>Gestionar Pagos</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Escuelas Stats Table -->
    <div class="mt-6 bg-white rounded-lg border border-gray-200 p-6 shadow-sm">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Resumen por Escuela</h3>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Escuela</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Accidentes</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reintegros</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monto Pendiente</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($escuelasStats as $escuela)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $escuela['nombre'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $escuela['accidentes'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $escuela['reintegros'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-amber-600">{{ $escuela['monto_pendiente'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>