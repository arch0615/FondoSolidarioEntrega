@extends('layouts.app')

@section('content')
<div class="mx-auto px-4">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 mb-8">
        <div>
            <h1 class="text-2xl font-semibold text-secondary-900">Gestión de Accidentes</h1>
            <p class="mt-1 text-sm text-secondary-600">Administra los accidentes registrados en el sistema</p>
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
                        {{-- TODO: Implementar rutas de exportación reales --}}
                        <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900" role="menuitem"><i class="fas fa-file-csv fa-fw text-secondary-400"></i>Exportar a CSV</a>
                        <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900" role="menuitem"><i class="fas fa-file-excel fa-fw text-secondary-400"></i>Exportar a Excel</a>
                        <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900" role="menuitem"><i class="fas fa-file-pdf fa-fw text-secondary-400"></i>Exportar a PDF</a>
                    </div>
                </div>
            </div>
            <!-- Botón Nuevo Accidente -->
            <a href="{{ route('accidentes.create') }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nuevo Accidente
            </a>
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-xl border border-secondary-200 mb-6">
        <details class="group">
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
                <form class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="space-y-1">
                        <label for="filtro_expediente" class="block text-sm font-medium text-secondary-700">N° Expediente</label>
                        <input type="text" name="filtro_expediente" id="filtro_expediente" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Ej: EXP-2024-001">
                    </div>
                    <div class="space-y-1">
                        <label for="filtro_alumno" class="block text-sm font-medium text-secondary-700">Alumno</label>
                        <input type="text" name="filtro_alumno" id="filtro_alumno" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Nombre del alumno">
                    </div>
                    <div class="space-y-1">
                        <label for="filtro_escuela" class="block text-sm font-medium text-secondary-700">Escuela</label>
                        <select name="filtro_escuela" id="filtro_escuela" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option value="">Todas las escuelas</option>
                            <option value="1">Colegio San Martín</option>
                            <option value="2">Instituto Belgrano</option>
                            <option value="3">Escuela Santa María</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label for="filtro_fecha" class="block text-sm font-medium text-secondary-700">Fecha Accidente</label>
                        <input type="date" name="filtro_fecha" id="filtro_fecha" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-secondary-900 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-secondary-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-500 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Buscar
                        </button>
                    </div>
                </form>
            </div>
        </details>
    </div>

    <!-- Vista de Cards de Accidentes -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @php
            $accidentes = [
                ['id' => 1, 'numero_expediente' => 'EXP-2024-001', 'escuela' => 'Colegio San Martín', 'alumnos' => ['Juan Pérez'], 'cantidad_alumnos' => 1, 'fecha_accidente' => '2024-01-15', 'hora_accidente' => '10:30', 'lugar' => 'Patio de juegos', 'tipo_lesion' => 'Fractura de brazo', 'estado' => 'Activo', 'derivaciones' => 2, 'reintegros_pendientes' => 1, 'reintegros_autorizados' => 0, 'reintegros_solicitando_info' => 0, 'protocolo_activado' => true],
                ['id' => 2, 'numero_expediente' => 'EXP-2024-002', 'escuela' => 'Instituto Belgrano', 'alumnos' => ['María García'], 'cantidad_alumnos' => 1, 'fecha_accidente' => '2024-01-20', 'hora_accidente' => '14:15', 'lugar' => 'Aula de educación física', 'tipo_lesion' => 'Contusión en rodilla', 'estado' => 'Activo', 'derivaciones' => 1, 'reintegros_pendientes' => 0, 'reintegros_autorizados' => 1, 'reintegros_solicitando_info' => 0, 'protocolo_activado' => false],
                ['id' => 3, 'numero_expediente' => 'EXP-2024-003', 'escuela' => 'Escuela Santa María', 'alumnos' => ['Carlos López', 'Ana Martínez'], 'cantidad_alumnos' => 2, 'fecha_accidente' => '2024-01-25', 'hora_accidente' => '09:45', 'lugar' => 'Escaleras del edificio', 'tipo_lesion' => 'Golpe en cabeza', 'estado' => 'Activo', 'derivaciones' => 3, 'reintegros_pendientes' => 2, 'reintegros_autorizados' => 0, 'reintegros_solicitando_info' => 1, 'protocolo_activado' => true],
                ['id' => 4, 'numero_expediente' => 'EXP-2024-004', 'escuela' => 'Colegio San Martín', 'alumnos' => ['Diego Rodríguez'], 'cantidad_alumnos' => 1, 'fecha_accidente' => '2024-02-01', 'hora_accidente' => '11:20', 'lugar' => 'Laboratorio de ciencias', 'tipo_lesion' => 'Corte en mano', 'estado' => 'Cerrado', 'derivaciones' => 1, 'reintegros_pendientes' => 0, 'reintegros_autorizados' => 1, 'reintegros_solicitando_info' => 0, 'protocolo_activado' => false],
                ['id' => 5, 'numero_expediente' => 'EXP-2024-005', 'escuela' => 'Instituto Belgrano', 'alumnos' => ['Sofía González', 'Lucas Fernández', 'Emma Torres'], 'cantidad_alumnos' => 3, 'fecha_accidente' => '2024-02-05', 'hora_accidente' => '15:30', 'lugar' => 'Cancha de fútbol', 'tipo_lesion' => 'Múltiples lesiones menores', 'estado' => 'Activo', 'derivaciones' => 2, 'reintegros_pendientes' => 1, 'reintegros_autorizados' => 0, 'reintegros_solicitando_info' => 0, 'protocolo_activado' => true],
                ['id' => 6, 'numero_expediente' => 'EXP-2024-006', 'escuela' => 'Escuela Santa María', 'alumnos' => ['Mateo Ruiz'], 'cantidad_alumnos' => 1, 'fecha_accidente' => '2024-02-10', 'hora_accidente' => '13:45', 'lugar' => 'Comedor escolar', 'tipo_lesion' => 'Reacción alérgica', 'estado' => 'Activo', 'derivaciones' => 1, 'reintegros_pendientes' => 0, 'reintegros_autorizados' => 0, 'reintegros_solicitando_info' => 1, 'protocolo_activado' => true],
            ];
        @endphp

        @foreach ($accidentes as $accidente)
        <div class="bg-white rounded-xl border border-secondary-200 shadow-sm hover:shadow-lg transition-shadow duration-300 flex flex-col">
            <div class="p-6 flex-grow">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex-1 min-w-0 pr-3">
                        <h2 class="text-xl font-semibold text-red-700 truncate">{{ $accidente['numero_expediente'] }}</h2>
                        <div class="mt-1">
                            @if($accidente['cantidad_alumnos'] === 1)
                                <p class="text-sm text-secondary-600 font-medium">{{ $accidente['alumnos'][0] }}</p>
                            @else
                                <p class="text-sm text-secondary-600 font-medium whitespace-nowrap">
                                    {{ $accidente['alumnos'][0] }}
                                    <span class="text-xs text-secondary-500">+{{ $accidente['cantidad_alumnos'] - 1 }} más</span>
                                </p>
                                <p class="text-xs text-secondary-500 mt-1 whitespace-nowrap">
                                    <strong>Total:</strong> {{ $accidente['cantidad_alumnos'] }} alumnos involucrados
                                </p>
                            @endif
                        </div>
                        <p class="text-xs text-secondary-500 mt-1">{{ $accidente['escuela'] }}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        @if ($accidente['estado'] == 'Activo')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-100 text-success-800">
                            <svg class="w-1.5 h-1.5 mr-1.5" fill="currentColor" viewBox="0 0 8 8">
                                <circle cx="4" cy="4" r="3"/>
                            </svg>
                            Activo
                        </span>
                        @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-secondary-100 text-secondary-700">
                            <svg class="w-1.5 h-1.5 mr-1.5" fill="currentColor" viewBox="0 0 8 8">
                                <circle cx="4" cy="4" r="3"/>
                            </svg>
                            Cerrado
                        </span>
                        @endif
                        @if ($accidente['protocolo_activado'])
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            <i class="fas fa-shield-alt w-1.5 h-1.5 mr-1.5"></i>
                            Protocolo
                        </span>
                        @endif
                        <div x-data="{ open: false }" @click.away="open = false" class="relative">
                            <button @click="open = !open" class="p-2 text-secondary-500 hover:text-primary-600 hover:bg-primary-50 rounded-full transition-colors duration-200 -mr-2" title="Acciones">
                                <i class="fas fa-ellipsis-v fa-fw"></i>
                            </button>
                            <div x-show="open"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-20 border border-secondary-200"
                                 style="display: none;">
                                <a href="{{ route('accidentes.show', $accidente['id']) }}" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900 w-full text-left">
                                    <i class="fas fa-eye fa-fw text-secondary-400"></i>
                                    Consultar
                                </a>
                                <a href="{{ route('accidentes.edit', $accidente['id']) }}" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900 w-full text-left">
                                    <i class="fas fa-pencil-alt fa-fw text-secondary-400"></i>
                                    Editar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4 text-sm text-secondary-700 space-y-1">
                    <p><i class="fas fa-calendar-alt text-secondary-400 mr-2 fa-fw"></i>{{ \Carbon\Carbon::parse($accidente['fecha_accidente'])->format('d/m/Y') }} - {{ $accidente['hora_accidente'] }}</p>
                    <p><i class="fas fa-map-marker-alt text-secondary-400 mr-2 fa-fw"></i>{{ $accidente['lugar'] }}</p>
                    <p><i class="fas fa-user-injured text-secondary-400 mr-2 fa-fw"></i>{{ $accidente['tipo_lesion'] }}</p>
                </div>

                <div class="border-t border-secondary-200 pt-4 mb-4">
                    <h4 class="text-sm font-medium text-secondary-600 mb-2">Estado de Gestión:</h4>
                    <div class="grid grid-cols-2 gap-x-4 gap-y-1 text-sm">
                        <p class="text-secondary-700">Derivaciones: <span class="font-semibold text-blue-600">{{ $accidente['derivaciones'] }}</span></p>
                        <p class="text-secondary-700">Reintegros Total: <span class="font-semibold text-secondary-900">{{ $accidente['reintegros_pendientes'] + $accidente['reintegros_autorizados'] + $accidente['reintegros_solicitando_info'] }}</span></p>
                        @if($accidente['reintegros_pendientes'] > 0)
                        <p class="text-amber-700">R. Pendientes: <span class="font-semibold text-amber-800">{{ $accidente['reintegros_pendientes'] }}</span></p>
                        @endif
                        @if($accidente['reintegros_autorizados'] > 0)
                        <p class="text-green-700">R. Autorizados: <span class="font-semibold text-green-800">{{ $accidente['reintegros_autorizados'] }}</span></p>
                        @endif
                        @if($accidente['reintegros_solicitando_info'] > 0)
                        <p class="text-blue-700">R. Sol. Info: <span class="font-semibold text-blue-800">{{ $accidente['reintegros_solicitando_info'] }}</span></p>
                        @endif
                    </div>
                </div>

                <!-- Botones de Acción en el Card -->
                <div class="flex gap-2 mt-4">
                    <a href="{{ route('derivaciones.create', ['accidente_id' => $accidente['id']]) }}" class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-blue-600 border border-transparent rounded-lg font-medium text-xs text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <i class="fas fa-file-medical mr-1"></i>
                        Generar Derivación
                    </a>
                    <button class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-green-600 border border-transparent rounded-lg font-medium text-xs text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                        <i class="fas fa-dollar-sign mr-1"></i>
                        Solicitar Reintegro
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <!-- Paginación -->
        <div class="mt-8 px-6 py-4 bg-white border-t border-secondary-200 flex flex-col sm:flex-row items-center justify-between rounded-b-xl">
            <div class="text-sm text-secondary-700 mb-4 sm:mb-0">
                Mostrando <span class="font-medium text-secondary-900">1</span> a <span class="font-medium text-secondary-900">6</span> de <span class="font-medium text-secondary-900">24</span> resultados
            </div>
            <nav class="inline-flex rounded-lg shadow-sm" aria-label="Paginación">
                <button type="button" class="relative inline-flex items-center px-2 py-2 rounded-l-lg border border-secondary-300 bg-white text-sm font-medium text-secondary-500 hover:bg-secondary-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span class="sr-only">Anterior</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button type="button" class="relative inline-flex items-center px-4 py-2 border border-secondary-300 bg-white text-sm font-medium text-secondary-700 hover:bg-secondary-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500">
                    1
                </button>
                <button type="button" class="relative inline-flex items-center px-4 py-2 border border-secondary-300 bg-red-600 text-sm font-medium text-white hover:bg-red-700 focus:z-10 focus:outline-none focus:ring-1 focus:ring-red-500 focus:border-red-500" aria-current="page">
                    2
                </button>
                <button type="button" class="relative inline-flex items-center px-4 py-2 border border-secondary-300 bg-white text-sm font-medium text-secondary-700 hover:bg-secondary-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500">
                    3
                </button>
                <span class="relative inline-flex items-center px-4 py-2 border border-secondary-300 bg-white text-sm font-medium text-secondary-700">
                    ...
                </span>
                <button type="button" class="relative inline-flex items-center px-4 py-2 border border-secondary-300 bg-white text-sm font-medium text-secondary-700 hover:bg-secondary-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500">
                    8
                </button>
                <button type="button" class="relative inline-flex items-center px-2 py-2 rounded-r-lg border border-secondary-300 bg-white text-sm font-medium text-secondary-500 hover:bg-secondary-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500">
                    <span class="sr-only">Siguiente</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </nav>
        </div>
    </div>
</div>

<!-- Modal para mostrar lista completa de alumnos -->
<div id="modal_alumnos" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-md w-full">
        <div class="flex justify-between items-center p-6 border-b border-secondary-200">
            <h3 class="text-lg font-semibold text-secondary-900">Alumnos Involucrados</h3>
            <button type="button" id="cerrar_modal_alumnos" class="text-secondary-400 hover:text-secondary-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <div class="p-6">
            <div id="expediente_info" class="mb-4 p-3 bg-secondary-50 rounded-lg">
                <p class="text-sm font-medium text-secondary-900 mb-1">Expediente: <span id="modal_expediente"></span></p>
                <p class="text-xs text-secondary-600">Escuela: <span id="modal_escuela"></span></p>
            </div>
            
            <h4 class="text-sm font-medium text-secondary-700 mb-3">Lista de Alumnos:</h4>
            <div id="lista_alumnos_modal" class="space-y-2">
                <!-- Lista dinámica de alumnos -->
            </div>
        </div>
        
        <div class="flex justify-end p-6 border-t border-secondary-200">
            <button type="button" id="cerrar_modal_btn" class="px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                Cerrar
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Datos de alumnos por accidente para el modal
    const alumnosPorAccidente = {
        1: ['Juan Pérez - 5to A'],
        2: ['María García - 3ro B'],
        3: ['Carlos López - 6to A', 'Ana Martínez - 4to C'],
        4: ['Diego Rodríguez - 2do A'],
        5: ['Sofía González - 1er Año', 'Lucas Fernández - 3er Año', 'Emma Torres - 2do B'],
        6: ['Mateo Ruiz - 5to B']
    };

    const modal = document.getElementById('modal_alumnos');
    const cerrarModalBtn = document.getElementById('cerrar_modal_alumnos');
    const cerrarModalBtn2 = document.getElementById('cerrar_modal_btn');
    
    // Agregar evento de clic a los elementos que muestran múltiples alumnos
    document.querySelectorAll('.text-secondary-600').forEach(element => {
        if (element.textContent.includes('+') && element.textContent.includes('más')) {
            element.style.cursor = 'pointer';
            element.classList.add('hover:text-primary-600', 'transition-colors', 'duration-200');
            element.title = 'Haga clic para ver todos los alumnos';
            
            element.addEventListener('click', function() {
                // Encontrar el accidente ID desde el card padre
                const card = element.closest('.bg-white');
                const expedienteElement = card.querySelector('.text-red-700');
                const escuelaElement = card.querySelector('.text-secondary-500');
                
                if (expedienteElement && escuelaElement) {
                    const expediente = expedienteElement.textContent;
                    const escuela = escuelaElement.textContent;
                    
                    // Extraer ID del expediente para obtener los alumnos
                    const match = expediente.match(/EXP-2024-(\d+)/);
                    if (match) {
                        const id = parseInt(match[1]);
                        mostrarModalAlumnos(expediente, escuela, id);
                    }
                }
            });
        }
    });

    function mostrarModalAlumnos(expediente, escuela, id) {
        document.getElementById('modal_expediente').textContent = expediente;
        document.getElementById('modal_escuela').textContent = escuela;
        
        const listaAlumnos = alumnosPorAccidente[id] || [];
        const listaContainer = document.getElementById('lista_alumnos_modal');
        
        listaContainer.innerHTML = listaAlumnos.map((alumno, index) => `
            <div class="flex items-center p-3 bg-secondary-50 rounded-lg">
                <div class="flex-shrink-0 w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center mr-3">
                    <span class="text-sm font-medium text-primary-700">${index + 1}</span>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-secondary-900">${alumno}</p>
                </div>
            </div>
        `).join('');
        
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function cerrarModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    if (cerrarModalBtn) {
        cerrarModalBtn.addEventListener('click', cerrarModal);
    }

    if (cerrarModalBtn2) {
        cerrarModalBtn2.addEventListener('click', cerrarModal);
    }

    // Cerrar modal con ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            cerrarModal();
        }
    });

    // Cerrar modal al hacer clic fuera de él
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            cerrarModal();
        }
    });
});
</script>

@endsection