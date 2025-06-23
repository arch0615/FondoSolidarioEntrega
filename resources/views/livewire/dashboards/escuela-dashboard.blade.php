<div>
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Accidentes Reportados -->
        <div class="bg-white rounded-lg border border-red-200 p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Accidentes Reportados</p>
                    <p class="text-3xl font-bold text-red-700 mt-2">{{ $stats['accidentes_reportados']['total'] }}</p>
                    <p class="text-xs text-red-600 mt-1">{{ $stats['accidentes_reportados']['incremento'] }}</p>
                </div>
                <div class="p-3 rounded-lg bg-red-50 border border-red-200">
                    <i class="fas fa-shield-alt text-red-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Alumnos Registrados -->
        <div class="bg-white rounded-lg border border-primary-200 p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Alumnos Registrados</p>
                    <p class="text-3xl font-bold text-primary-700 mt-2">{{ $stats['alumnos_registrados']['total'] }}</p>
                    <p class="text-xs text-primary-600 mt-1">{{ $stats['alumnos_registrados']['incremento'] }}</p>
                </div>
                <div class="p-3 rounded-lg bg-primary-50 border border-primary-200">
                    <i class="fas fa-graduation-cap text-primary-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Reintegros Pendientes -->
        <div class="bg-white rounded-lg border border-amber-200 p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Reintegros Pendientes</p>
                    <p class="text-3xl font-bold text-amber-700 mt-2">{{ $stats['reintegros_pendientes']['total'] }}</p>
                    <p class="text-xs text-amber-600 mt-1">{{ $stats['reintegros_pendientes']['incremento'] }}</p>
                </div>
                <div class="p-3 rounded-lg bg-amber-50 border border-amber-200">
                    <i class="fas fa-clock text-amber-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Documentos Subidos -->
        <div class="bg-white rounded-lg border border-primary-300 p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Documentos Subidos</p>
                    <p class="text-3xl font-bold text-primary-800 mt-2">{{ $stats['documentos_subidos']['total'] }}</p>
                    <p class="text-xs text-primary-700 mt-1">{{ $stats['documentos_subidos']['incremento'] }}</p>
                </div>
                <div class="p-3 rounded-lg bg-primary-100 border border-primary-300">
                    <i class="fas fa-folder-open text-primary-700 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Activity -->
        <div class="lg:col-span-2 bg-white rounded-lg border border-gray-200 p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Actividad Reciente</h3>
            
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
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg border border-primary-200 p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-primary-800 mb-4">Acciones Rápidas</h3>
            
            <div class="space-y-3">
                <a href="{{ route('accidentes.create') }}" class="w-full flex items-center gap-3 p-3 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-all duration-200 hover:shadow-md">
                    <i class="fas fa-shield-alt"></i>
                    <span>Reportar Accidente</span>
                </a>
                
                <a href="{{ route('alumnos.create') }}" class="w-full flex items-center gap-3 p-3 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-all duration-200 hover:shadow-md">
                    <i class="fas fa-graduation-cap"></i>
                    <span>Registrar Alumno</span>
                </a>
                
                <a href="{{ route('derivaciones.create') }}" class="w-full flex items-center gap-3 p-3 border-2 border-primary-300 text-primary-700 hover:bg-primary-50 hover:border-primary-400 rounded-lg transition-all duration-200">
                    <i class="fas fa-file-medical"></i>
                    <span>Generar Derivación</span>
                </a>

                <a href="{{ route('documentos.create') }}" class="w-full flex items-center gap-3 p-3 border-2 border-primary-200 text-primary-600 hover:bg-primary-25 hover:border-primary-300 rounded-lg transition-all duration-200">
                    <i class="fas fa-folder-open"></i>
                    <span>Subir Documentos</span>
                </a>
            </div>
        </div>
    </div>
</div>