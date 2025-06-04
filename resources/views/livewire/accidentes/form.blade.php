@extends('layouts.app')

@section('content')
<div class="mx-auto px-4">
    <!-- Header -->
    <div class="mb-8">
        <nav class="flex items-center text-sm text-secondary-500 mb-4">
            <a href="{{ route('accidentes.index') }}" class="hover:text-secondary-700">Accidentes</a>
            <svg class="mx-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-secondary-900">{{ $modo == 'create' ? 'Nuevo Accidente' : ($modo == 'edit' ? 'Editar Accidente' : 'Detalles de Accidente') }}</span>
        </nav>
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-secondary-900">
                    {{ $modo == 'create' ? 'Nuevo Accidente' : ($modo == 'edit' ? 'Editar Accidente' : 'Detalles de Accidente') }}
                </h1>
                <p class="mt-1 text-sm text-secondary-600">
                    {{ $modo == 'create' ? 'Complete los datos para registrar un nuevo accidente' : ($modo == 'edit' ? 'Modifique los datos del accidente' : 'Información detallada del accidente') }}
                </p>
            </div>
            @if($modo == 'show')
            <div class="flex space-x-3">
                <a href="{{ route('accidentes.edit', $accidente_id ?? 1) }}" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Editar
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- Formulario -->
    <div class="bg-white rounded-xl border border-secondary-200">
        <form action="{{ $modo == 'create' ? route('accidentes.index') : route('accidentes.index') }}" method="POST" class="space-y-6 p-6">
            @csrf
            @if($modo == 'edit')
                @method('PUT')
            @endif

            <!-- Información de los Alumnos -->
            <div class="border-b border-secondary-200 pb-6">
                <h3 class="text-lg font-medium text-secondary-900 mb-4">Alumnos Involucrados</h3>
                
                <!-- Campo de búsqueda con autocompletado -->
                <div class="mb-4">
                    <label for="buscar_alumno" class="block text-sm font-medium text-secondary-700 mb-2">
                        Buscar y Agregar Alumnos <span class="text-danger-500">*</span>
                    </label>
                    <div class="flex gap-2">
                        <div class="flex-1 relative">
                            <input
                                type="text"
                                id="buscar_alumno"
                                class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                                placeholder="Escriba el nombre del alumno..."
                                {{ $modo == 'show' ? 'readonly' : '' }}
                                autocomplete="off"
                            >
                            <!-- Dropdown de sugerencias -->
                            <div id="sugerencias_alumnos" class="absolute z-10 mt-1 w-full bg-white border border-secondary-300 rounded-lg shadow-lg hidden max-h-60 overflow-y-auto">
                                <!-- Las sugerencias se llenarán dinámicamente con JavaScript -->
                            </div>
                        </div>
                        <!-- Botón para agregar nuevo alumno -->
                        <button
                            type="button"
                            id="btn_nuevo_alumno"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 {{ $modo == 'show' ? 'opacity-50 cursor-not-allowed' : '' }}"
                            @if($modo == 'show') disabled @endif
                        >
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Nuevo Alumno
                        </button>
                    </div>
                    <p class="text-xs text-secondary-500 mt-1">Escriba para buscar o haga clic en "Nuevo Alumno" para agregar uno nuevo</p>
                </div>

                <!-- Lista de alumnos seleccionados -->
                <div id="alumnos_seleccionados" class="space-y-2">
                    <label class="block text-sm font-medium text-secondary-700 mb-2">Alumnos Seleccionados:</label>
                    <div id="lista_alumnos" class="min-h-[60px] border border-secondary-200 rounded-lg p-3 bg-secondary-50">
                        @php
                            // Simular alumnos seleccionados para el mockup según el ID del accidente
                            $alumnosSeleccionados = [];
                            if (isset($accidente_id)) {
                                switch($accidente_id) {
                                    case 1:
                                        $alumnosSeleccionados = [
                                            ['id' => 1, 'nombre' => 'Juan Pérez', 'grado' => '5to A', 'dni' => '12345678']
                                        ];
                                        break;
                                    case 2:
                                        $alumnosSeleccionados = [
                                            ['id' => 2, 'nombre' => 'María García', 'grado' => '3ro B', 'dni' => '87654321']
                                        ];
                                        break;
                                    case 3:
                                        $alumnosSeleccionados = [
                                            ['id' => 3, 'nombre' => 'Carlos López', 'grado' => '6to A', 'dni' => '11223344'],
                                            ['id' => 4, 'nombre' => 'Ana Martínez', 'grado' => '4to C', 'dni' => '55667788']
                                        ];
                                        break;
                                }
                            }
                        @endphp
                        
                        @if(empty($alumnosSeleccionados))
                            <p class="text-sm text-secondary-500 italic">No hay alumnos seleccionados</p>
                        @else
                            @foreach($alumnosSeleccionados as $alumno)
                            <div class="alumno-item flex items-center justify-between bg-white border border-secondary-200 rounded-lg p-3" data-id="{{ $alumno['id'] }}">
                                <div class="flex-1">
                                    <div class="font-medium text-secondary-900">{{ $alumno['nombre'] }}</div>
                                    <div class="text-sm text-secondary-600">{{ $alumno['grado'] }} - DNI: {{ $alumno['dni'] }}</div>
                                </div>
                                @if($modo != 'show')
                                <button type="button" class="btn-remover-alumno text-red-600 hover:text-red-800 p-1" data-id="{{ $alumno['id'] }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                                @endif
                                <input type="hidden" name="alumnos_ids[]" value="{{ $alumno['id'] }}">
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <!-- Detalles del Accidente -->
            <div class="border-b border-secondary-200 pb-6">
                <h3 class="text-lg font-medium text-secondary-900 mb-4">Detalles del Accidente</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Fecha del Accidente -->
                    <div class="space-y-1">
                        <label for="fecha_accidente" class="block text-sm font-medium text-secondary-700">
                            Fecha del Accidente <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="date"
                            name="fecha_accidente"
                            id="fecha_accidente"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            value="{{ $accidente_id ?? '' == 1 ? '2024-01-15' : ($accidente_id ?? '' == 2 ? '2024-01-20' : '') }}"
                            {{ $modo == 'show' ? 'readonly' : '' }}
                            required
                        >
                    </div>

                    <!-- Hora del Accidente -->
                    <div class="space-y-1">
                        <label for="hora_accidente" class="block text-sm font-medium text-secondary-700">
                            Hora del Accidente <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="time"
                            name="hora_accidente"
                            id="hora_accidente"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            value="{{ $accidente_id ?? '' == 1 ? '10:30' : ($accidente_id ?? '' == 2 ? '14:15' : '') }}"
                            {{ $modo == 'show' ? 'readonly' : '' }}
                            required
                        >
                    </div>

                    <!-- Lugar del Accidente -->
                    <div class="md:col-span-2 space-y-1">
                        <label for="lugar_accidente" class="block text-sm font-medium text-secondary-700">
                            Lugar del Accidente <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="lugar_accidente"
                            id="lugar_accidente"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            placeholder="Ej: Patio de recreo, Aula 5B, Escaleras principales"
                            value="{{ $accidente_id ?? '' == 1 ? 'Patio de juegos' : ($accidente_id ?? '' == 2 ? 'Aula de educación física' : '') }}"
                            {{ $modo == 'show' ? 'readonly' : '' }}
                            required
                        >
                    </div>

                    <!-- Descripción del Accidente -->
                    <div class="md:col-span-2 space-y-1">
                        <label for="descripcion_accidente" class="block text-sm font-medium text-secondary-700">
                            Descripción del Accidente <span class="text-danger-500">*</span>
                        </label>
                        <textarea
                            name="descripcion_accidente"
                            id="descripcion_accidente"
                            rows="4"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            placeholder="Describa detalladamente cómo ocurrió el accidente..."
                            {{ $modo == 'show' ? 'readonly' : '' }}
                            required>{{ $accidente_id ?? '' == 1 ? 'El alumno se encontraba jugando en el patio durante el recreo cuando se resbaló y cayó, golpeándose el brazo derecho contra el suelo.' : ($accidente_id ?? '' == 2 ? 'Durante la clase de educación física, la alumna tropezó mientras corría y se golpeó la rodilla.' : '') }}</textarea>
                    </div>

                    <!-- Tipo de Lesión -->
                    <div class="md:col-span-2 space-y-1">
                        <label for="tipo_lesion" class="block text-sm font-medium text-secondary-700">
                            Tipo de Lesión <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="tipo_lesion"
                            id="tipo_lesion"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            placeholder="Ej: Fractura, Contusión, Corte, Esguince"
                            value="{{ $accidente_id ?? '' == 1 ? 'Fractura de brazo' : ($accidente_id ?? '' == 2 ? 'Contusión en rodilla' : '') }}"
                            {{ $modo == 'show' ? 'readonly' : '' }}
                            required
                        >
                    </div>
                </div>
            </div>

            <!-- Protocolo de Emergencias -->
            <div class="border-b border-secondary-200 pb-6">
                <h3 class="text-lg font-medium text-secondary-900 mb-4">Protocolo de Emergencias</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Protocolo Activado -->
                    <div class="md:col-span-2 flex items-center">
                        <div class="flex items-center h-5">
                            <input
                                type="checkbox"
                                name="protocolo_activado"
                                id="protocolo_activado"
                                class="w-4 h-4 text-red-600 bg-white border-secondary-300 rounded focus:ring-red-500 focus:ring-2"
                                {{ ($modo == 'create' || ($accidente_id ?? '' == 1 && $modo != 'create')) ? 'checked' : '' }}
                                {{ $modo == 'show' ? 'disabled' : '' }}
                            >
                        </div>
                        <div class="ml-3">
                            <label for="protocolo_activado" class="text-sm font-medium text-secondary-700">
                                Se activó el Protocolo de Emergencias
                            </label>
                            <p class="text-xs text-secondary-500">Marcar si se llamó al Sistema de Emergencias y Urgencias médicas</p>
                        </div>
                    </div>

                    <!-- Llamada a Emergencia -->
                    <div class="flex items-center">
                        <div class="flex items-center h-5">
                            <input
                                type="checkbox"
                                name="llamada_emergencia"
                                id="llamada_emergencia"
                                class="w-4 h-4 text-red-600 bg-white border-secondary-300 rounded focus:ring-red-500 focus:ring-2"
                                {{ ($accidente_id ?? '' == 1 && $modo != 'create') ? 'checked' : '' }}
                                {{ $modo == 'show' ? 'disabled' : '' }}
                            >
                        </div>
                        <div class="ml-3">
                            <label for="llamada_emergencia" class="text-sm font-medium text-secondary-700">
                                Se realizó llamada de emergencia
                            </label>
                        </div>
                    </div>

                    <!-- Hora de Llamada -->
                    <div class="space-y-1">
                        <label for="hora_llamada" class="block text-sm font-medium text-secondary-700">Hora de Llamada</label>
                        <input
                            type="time"
                            name="hora_llamada"
                            id="hora_llamada"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            value="{{ $accidente_id ?? '' == 1 ? '10:35' : '' }}"
                            {{ $modo == 'show' ? 'readonly' : '' }}
                        >
                    </div>

                    <!-- Servicio de Emergencia -->
                    <div class="md:col-span-2 space-y-1">
                        <label for="servicio_emergencia" class="block text-sm font-medium text-secondary-700">Servicio de Emergencia Contactado</label>
                        <input
                            type="text"
                            name="servicio_emergencia"
                            id="servicio_emergencia"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            placeholder="Ej: SAME, Cruz Roja, Emergencias Médicas FS"
                            value="{{ $accidente_id ?? '' == 1 ? 'Emergencias Médicas FS' : '' }}"
                            {{ $modo == 'show' ? 'readonly' : '' }}
                        >
                    </div>
                </div>
            </div>

            <!-- Estado y Configuración -->
            @if($modo != 'create')
            <div class="border-b border-secondary-200 pb-6">
                <h3 class="text-lg font-medium text-secondary-900 mb-4">Estado del Expediente</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Número de Expediente -->
                    <div class="space-y-1">
                        <label for="numero_expediente" class="block text-sm font-medium text-secondary-700">Número de Expediente</label>
                        <input
                            type="text"
                            name="numero_expediente"
                            id="numero_expediente"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm bg-secondary-50"
                            value="{{ $accidente_id ?? '' == 1 ? 'EXP-2024-001' : ($accidente_id ?? '' == 2 ? 'EXP-2024-002' : '') }}"
                            readonly
                        >
                        <p class="text-xs text-secondary-500">Generado automáticamente por el sistema</p>
                    </div>

                    <!-- Estado -->
                    <div class="space-y-1">
                        <label for="estado" class="block text-sm font-medium text-secondary-700">Estado</label>
                        <select
                            name="estado"
                            id="estado"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            {{ $modo == 'show' ? 'disabled' : '' }}>
                            <option value="Activo" {{ ($accidente_id ?? '' == 1) ? 'selected' : '' }}>Activo</option>
                            <option value="Cerrado">Cerrado</option>
                        </select>
                    </div>

                    <!-- Fecha de Carga -->
                    <div class="space-y-1">
                        <label for="fecha_carga" class="block text-sm font-medium text-secondary-700">Fecha de Carga</label>
                        <input
                            type="date"
                            name="fecha_carga"
                            id="fecha_carga"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm bg-secondary-50"
                            value="{{ $accidente_id ?? '' == 1 ? '2024-01-15' : ($accidente_id ?? '' == 2 ? '2024-01-20' : '') }}"
                            readonly
                        >
                        <p class="text-xs text-secondary-500">Fecha de registro en el sistema</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Botones de Acción -->
            <div class="flex items-center justify-between pt-6 border-t border-secondary-200">
                <a href="{{ route('accidentes.index') }}" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver al Listado
                </a>
                @if($modo != 'show')
                <button type="submit" class="inline-flex items-center px-6 py-2 bg-red-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ $modo == 'create' ? 'Registrar Accidente' : 'Actualizar Accidente' }}
                </button>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Modal para Nuevo Alumno -->
<div id="modal_nuevo_alumno" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center p-6 border-b border-secondary-200">
            <h3 class="text-lg font-semibold text-secondary-900">Agregar Nuevo Alumno</h3>
            <button type="button" id="cerrar_modal" class="text-secondary-400 hover:text-secondary-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <div class="p-6">
            <form id="form_nuevo_alumno" class="space-y-6">
                <!-- Información Personal del Alumno -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nombre -->
                    <div class="space-y-1">
                        <label for="modal_nombre" class="block text-sm font-medium text-secondary-700">
                            Nombre <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="modal_nombre"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                            placeholder="Ej: Ana"
                            required
                        >
                    </div>

                    <!-- Apellido -->
                    <div class="space-y-1">
                        <label for="modal_apellido" class="block text-sm font-medium text-secondary-700">
                            Apellido <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="modal_apellido"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                            placeholder="Ej: Martínez"
                            required
                        >
                    </div>

                    <!-- DNI -->
                    <div class="space-y-1">
                        <label for="modal_dni" class="block text-sm font-medium text-secondary-700">
                            DNI <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="modal_dni"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                            placeholder="Ej: 45678912"
                            required
                        >
                    </div>

                    <!-- CUIL -->
                    <div class="space-y-1">
                        <label for="modal_cuil" class="block text-sm font-medium text-secondary-700">
                            CUIL <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="modal_cuil"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                            placeholder="Ej: 23-45678912-4"
                            required
                        >
                    </div>

                    <!-- Fecha de Nacimiento -->
                    <div class="space-y-1">
                        <label for="modal_fecha_nacimiento" class="block text-sm font-medium text-secondary-700">
                            Fecha de Nacimiento <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="date"
                            id="modal_fecha_nacimiento"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                            required
                        >
                    </div>

                    <!-- Sala/Grado/Curso -->
                    <div class="space-y-1">
                        <label for="modal_sala_grado_curso" class="block text-sm font-medium text-secondary-700">
                            Sala/Grado/Curso <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="modal_sala_grado_curso"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                            placeholder="Ej: 7° Grado, 3° Año, Sala de 5"
                            required
                        >
                    </div>

                    <!-- Sección -->
                    <div class="space-y-1">
                        <label for="modal_seccion" class="block text-sm font-medium text-secondary-700">
                            Sección <span class="text-danger-500">*</span>
                        </label>
                        <select
                            id="modal_seccion"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                            required
                        >
                            <option value="">Seleccione una sección</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                        </select>
                    </div>

                    <!-- Nombre del Padre/Madre -->
                    <div class="space-y-1">
                        <label for="modal_nombre_padre_madre" class="block text-sm font-medium text-secondary-700">
                            Nombre del Padre/Madre <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="modal_nombre_padre_madre"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                            placeholder="Ej: Carlos Martínez"
                            required
                        >
                    </div>

                    <!-- Teléfono de Contacto -->
                    <div class="space-y-1">
                        <label for="modal_telefono_contacto" class="block text-sm font-medium text-secondary-700">
                            Teléfono de Contacto <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="tel"
                            id="modal_telefono_contacto"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                            placeholder="Ej: (351) 555-1234"
                            required
                        >
                    </div>
                </div>

                <!-- Botones del Modal -->
                <div class="flex justify-end space-x-3 pt-6 border-t border-secondary-200">
                    <button type="button" id="cancelar_modal" class="px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                        Cancelar
                    </button>
                    <button type="submit" class="px-6 py-2 bg-primary-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                        Agregar Alumno
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Inicializando formulario de accidentes...');
    
    // Datos de alumnos para autocompletado
    const alumnosData = {
        '1': { id: 1, nombre: 'Juan Pérez', grado: '5to A', dni: '12345678' },
        '2': { id: 2, nombre: 'María García', grado: '3ro B', dni: '87654321' },
        '3': { id: 3, nombre: 'Carlos López', grado: '6to A', dni: '11223344' },
        '4': { id: 4, nombre: 'Ana Martínez', grado: '4to C', dni: '55667788' },
        '5': { id: 5, nombre: 'Diego Rodríguez', grado: '2do A', dni: '99887766' },
        '6': { id: 6, nombre: 'Sofía González', grado: '1er Año', dni: '44556677' },
        '7': { id: 7, nombre: 'Lucas Fernández', grado: '3er Año', dni: '33445566' },
        '8': { id: 8, nombre: 'Valentina Ruiz', grado: '4to B', dni: '22334455' },
        '9': { id: 9, nombre: 'Mateo Silva', grado: '2do C', dni: '66778899' },
        '10': { id: 10, nombre: 'Isabella Torres', grado: '6to B', dni: '11223355' }
    };
    
    console.log('Total de alumnos disponibles:', Object.keys(alumnosData).length);

    let alumnosSeleccionados = [];

    // Elementos DOM
    const buscarInput = document.getElementById('buscar_alumno');
    const sugerenciasDiv = document.getElementById('sugerencias_alumnos');
    const listaAlumnos = document.getElementById('lista_alumnos');
    const btnNuevoAlumno = document.getElementById('btn_nuevo_alumno');
    const modal = document.getElementById('modal_nuevo_alumno');
    const formModal = document.getElementById('form_nuevo_alumno');
    const cerrarModal = document.getElementById('cerrar_modal');
    const cancelarModal = document.getElementById('cancelar_modal');
    
    // Verificar que los elementos existen
    console.log('Elementos encontrados:', {
        buscarInput: !!buscarInput,
        sugerenciasDiv: !!sugerenciasDiv,
        listaAlumnos: !!listaAlumnos,
        btnNuevoAlumno: !!btnNuevoAlumno,
        modal: !!modal,
        formModal: !!formModal
    });

    // Inicializar alumnos seleccionados desde el markup existente
    const alumnosExistentes = document.querySelectorAll('.alumno-item');
    alumnosExistentes.forEach(item => {
        const id = parseInt(item.dataset.id);
        if (alumnosData[id]) {
            alumnosSeleccionados.push(alumnosData[id]);
        }
    });

    // **FUNCIONALIDAD DE AUTOCOMPLETADO**
    if (buscarInput && !buscarInput.readOnly) {
        buscarInput.addEventListener('input', function() {
            const termino = this.value.toLowerCase().trim();
            console.log('Buscando:', termino, 'Longitud:', termino.length);
            
            if (termino.length < 1) {  // Cambiado de 2 a 1 para que funcione con una sola letra
                ocultarSugerencias();
                return;
            }
            
            // Filtrar alumnos que coincidan y no estén ya seleccionados
            const todosLosAlumnos = Object.values(alumnosData);
            console.log('Total alumnos a buscar:', todosLosAlumnos.length);
            console.log('Alumnos ya seleccionados:', alumnosSeleccionados.map(a => a.id));
            
            const sugerencias = todosLosAlumnos.filter(alumno => {
                const yaSeleccionado = alumnosSeleccionados.some(sel => sel.id === alumno.id);
                const coincide = alumno.nombre.toLowerCase().includes(termino) ||
                               alumno.grado.toLowerCase().includes(termino) ||
                               alumno.dni.includes(termino);
                return !yaSeleccionado && coincide;
            });
            
            console.log('Sugerencias encontradas:', sugerencias.length);
            mostrarSugerencias(sugerencias);
        });

        buscarInput.addEventListener('focus', function() {
            if (this.value.length >= 1) {  // Cambiado para coincidir con el mínimo de caracteres
                this.dispatchEvent(new Event('input'));
            }
        });

        // Ocultar sugerencias al hacer clic fuera
        document.addEventListener('click', function(e) {
            if (!buscarInput.contains(e.target) && !sugerenciasDiv.contains(e.target)) {
                ocultarSugerencias();
            }
        });
    }

    function mostrarSugerencias(sugerencias) {
        console.log('Mostrando sugerencias:', sugerencias.length);
        
        if (sugerencias.length === 0) {
            sugerenciasDiv.innerHTML = '<div class="p-3 text-sm text-secondary-500">No se encontraron alumnos</div>';
        } else {
            sugerenciasDiv.innerHTML = sugerencias.map(alumno => `
                <div class="p-2 hover:bg-secondary-50 cursor-pointer border-b border-secondary-100 sugerencia-item"
                     data-id="${alumno.id}" data-nombre="${alumno.nombre}" data-grado="${alumno.grado}" data-dni="${alumno.dni}">
                    <div class="font-medium text-secondary-900">${alumno.nombre}</div>
                    <div class="text-sm text-secondary-600">${alumno.grado} - DNI: ${alumno.dni}</div>
                </div>
            `).join('');
            
            // Agregar eventos de clic a las sugerencias
            sugerenciasDiv.querySelectorAll('.sugerencia-item').forEach(item => {
                item.addEventListener('click', function() {
                    const alumno = {
                        id: parseInt(this.dataset.id),
                        nombre: this.dataset.nombre,
                        grado: this.dataset.grado,
                        dni: this.dataset.dni
                    };
                    agregarAlumno(alumno);
                    buscarInput.value = '';
                    ocultarSugerencias();
                });
            });
        }
        
        sugerenciasDiv.classList.remove('hidden');
    }

    function ocultarSugerencias() {
        console.log('Ocultando sugerencias');
        sugerenciasDiv.classList.add('hidden');
    }

    // **GESTIÓN DE ALUMNOS SELECCIONADOS**
    function agregarAlumno(alumno) {
        // Verificar que no esté ya agregado
        if (alumnosSeleccionados.some(a => a.id === alumno.id)) {
            alert('Este alumno ya está seleccionado');
            return;
        }
        
        alumnosSeleccionados.push(alumno);
        actualizarListaAlumnos();
    }

    function removerAlumno(id) {
        alumnosSeleccionados = alumnosSeleccionados.filter(a => a.id !== id);
        actualizarListaAlumnos();
    }

    function actualizarListaAlumnos() {
        if (alumnosSeleccionados.length === 0) {
            listaAlumnos.innerHTML = '<p class="text-sm text-secondary-500 italic">No hay alumnos seleccionados</p>';
        } else {
            listaAlumnos.innerHTML = alumnosSeleccionados.map(alumno => `
                <div class="alumno-item flex items-center justify-between bg-white border border-secondary-200 rounded-lg p-3" data-id="${alumno.id}">
                    <div class="flex-1">
                        <div class="font-medium text-secondary-900">${alumno.nombre}</div>
                        <div class="text-sm text-secondary-600">${alumno.grado} - DNI: ${alumno.dni}</div>
                    </div>
                    <button type="button" class="btn-remover-alumno text-red-600 hover:text-red-800 p-1" data-id="${alumno.id}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    <input type="hidden" name="alumnos_ids[]" value="${alumno.id}">
                </div>
            `).join('');
            
            // Agregar eventos de remover
            listaAlumnos.querySelectorAll('.btn-remover-alumno').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = parseInt(this.dataset.id);
                    removerAlumno(id);
                });
            });
        }
    }

    // **MODAL PARA NUEVO ALUMNO**
    if (btnNuevoAlumno && modal) {
        console.log('Botón nuevo alumno encontrado:', btnNuevoAlumno);
        console.log('Modal encontrado:', modal);
        
        btnNuevoAlumno.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Click en botón nuevo alumno');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            // Focus en el primer campo después de un pequeño delay
            setTimeout(() => {
                const primerCampo = document.getElementById('modal_nombre');
                if (primerCampo) {
                    primerCampo.focus();
                }
            }, 100);
        });
    } else {
        console.error('No se encontró el botón o el modal:', { btnNuevoAlumno, modal });
    }

    function cerrarModalAlumno() {
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            if (formModal) {
                formModal.reset();
            }
        }
    }

    if (cerrarModal) {
        cerrarModal.addEventListener('click', cerrarModalAlumno);
    }

    if (cancelarModal) {
        cancelarModal.addEventListener('click', cerrarModalAlumno);
    }

    // Cerrar modal con ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
            cerrarModalAlumno();
        }
    });

    // Cerrar modal al hacer clic fuera de él
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                cerrarModalAlumno();
            }
        });
    }

    // Envío del formulario del modal
    if (formModal) {
        formModal.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const nombre = document.getElementById('modal_nombre').value.trim();
            const apellido = document.getElementById('modal_apellido').value.trim();
            const dni = document.getElementById('modal_dni').value.trim();
            const grado = document.getElementById('modal_sala_grado_curso').value.trim();
            const seccion = document.getElementById('modal_seccion').value;
            
            if (!nombre || !apellido || !dni || !grado || !seccion) {
                alert('Por favor complete todos los campos obligatorios');
                return;
            }
            
            // Crear nuevo alumno con ID temporal
            const nuevoId = Math.max(...Object.keys(alumnosData).map(k => parseInt(k))) + 1;
            const nuevoAlumno = {
                id: nuevoId,
                nombre: `${nombre} ${apellido}`,
                grado: `${grado} - Sección ${seccion}`,
                dni: dni
            };
            
            // Agregar a los datos y a la lista
            alumnosData[nuevoId] = nuevoAlumno;
            agregarAlumno(nuevoAlumno);
            
            // Cerrar modal
            cerrarModalAlumno();
            
            // Mostrar mensaje de éxito
            alert(`Alumno "${nuevoAlumno.nombre}" agregado exitosamente`);
        });
    }

    // **VALIDACIÓN DE FECHA NO FUTURA**
    const fechaInput = document.getElementById('fecha_accidente');
    if (fechaInput && !fechaInput.readOnly) {
        fechaInput.addEventListener('change', function() {
            const fechaSeleccionada = new Date(this.value);
            const hoy = new Date();
            
            if (fechaSeleccionada > hoy) {
                alert('La fecha del accidente no puede ser futura');
                this.value = '';
            }
        });
    }

    // **CONTROL DE PROTOCOLO DE EMERGENCIAS**
    const protocoloCheckbox = document.getElementById('protocolo_activado');
    const llamadaCheckbox = document.getElementById('llamada_emergencia');
    const horaLlamada = document.getElementById('hora_llamada');
    const servicioEmergencia = document.getElementById('servicio_emergencia');
    
    function toggleEmergenciaFields() {
        if (protocoloCheckbox && !protocoloCheckbox.disabled) {
            const isChecked = protocoloCheckbox.checked;
            
            if (llamadaCheckbox) llamadaCheckbox.disabled = !isChecked;
            if (horaLlamada) horaLlamada.disabled = !isChecked;
            if (servicioEmergencia) servicioEmergencia.disabled = !isChecked;
            
            if (!isChecked) {
                if (llamadaCheckbox) llamadaCheckbox.checked = false;
                if (horaLlamada) horaLlamada.value = '';
                if (servicioEmergencia) servicioEmergencia.value = '';
            }
        }
    }
    
    if (protocoloCheckbox) {
        protocoloCheckbox.addEventListener('change', toggleEmergenciaFields);
        toggleEmergenciaFields(); // Ejecutar al cargar
    }

    // **VALIDACIÓN DE FORMULARIO**
    const form = document.querySelector('form');
    const submitButton = document.querySelector('button[type="submit"]');
    
    if (form && submitButton) {
        form.addEventListener('submit', function(e) {
            // Validar que haya al menos un alumno seleccionado
            if (alumnosSeleccionados.length === 0) {
                e.preventDefault();
                alert('Debe seleccionar al menos un alumno para el accidente');
                buscarInput.focus();
                return;
            }
            
            submitButton.classList.add('opacity-75');
            submitButton.disabled = true;
            
            // Simular procesamiento
            setTimeout(() => {
                submitButton.classList.remove('opacity-75');
                submitButton.disabled = false;
            }, 2000);
        });
    }
});
</script>
@endpush