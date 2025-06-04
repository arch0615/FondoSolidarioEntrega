@extends('layouts.app')

@section('content')
<div class="mx-auto px-4">
    <!-- Header -->
    <div class="mb-8">
        <nav class="flex items-center text-sm text-secondary-500 mb-4">
            {{-- TODO: Definir la ruta correcta para el listado de documentos --}}
            <a href="{{ route('documentos.index') }}" class="hover:text-secondary-700">Documentos</a>
            <svg class="mx-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-secondary-900">{{ $modo == 'create' ? 'Nuevo Documento' : ($modo == 'edit' ? 'Editar Documento' : 'Detalles de Documento') }}</span>
        </nav>
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-secondary-900">
                    {{ $modo == 'create' ? 'Nuevo Documento' : ($modo == 'edit' ? 'Editar Documento' : 'Detalles de Documento') }}
                </h1>
                <p class="mt-1 text-sm text-secondary-600">
                    {{ $modo == 'create' ? 'Complete los datos para registrar un nuevo documento institucional' : ($modo == 'edit' ? 'Modifique los datos del documento' : 'Información detallada del documento') }}
                </p>
            </div>
            @if($modo == 'show')
            <div class="flex space-x-3">
                {{-- TODO: Definir la ruta correcta para editar documento --}}
                <a href="{{ route('documentos.edit', $documento_id ?? 1) }}" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Editar
                </a>
                <a href="#" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Descargar
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- Formulario -->
    <div class="bg-white rounded-xl border border-secondary-200">
        {{-- TODO: Definir la acción y método correctos del formulario --}}
        <form action="{{ $modo == 'create' ? route('documentos.index') : route('documentos.index') }}" method="POST" enctype="multipart/form-data" class="space-y-6 p-6">
            @csrf
            @if($modo == 'edit')
                @method('PUT')
            @endif

            <!-- Información del Documento -->
            <div class="border-b border-secondary-200 pb-6">
                <h3 class="text-lg font-medium text-secondary-900 mb-4">Información del Documento</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nombre del Documento -->
                    <div class="md:col-span-2 space-y-1">
                        <label for="nombre_documento" class="block text-sm font-medium text-secondary-700">
                            Nombre del Documento <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="nombre_documento"
                            id="nombre_documento"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            placeholder="Ej: Resolución Matrícula 2024"
                            value="{{ isset($documento_id) && $documento_id == 1 ? 'Resolución Matrícula 2024' : (isset($documento_id) && $documento_id == 2 ? 'Plan de Estudios 2024' : (isset($documento_id) && $documento_id == 3 ? 'Habilitación Sanitaria' : '')) }}"
                            {{ $modo == 'show' ? 'readonly' : '' }}
                            required
                        >
                    </div>

                    <!-- Tipo de Documento -->
                    <div class="space-y-1">
                        <label for="tipo_documento" class="block text-sm font-medium text-secondary-700">
                            Tipo de Documento <span class="text-danger-500">*</span>
                        </label>
                        <select
                            name="tipo_documento"
                            id="tipo_documento"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            {{ $modo == 'show' ? 'disabled' : '' }}
                            required
                        >
                            <option value="">Seleccione un tipo</option>
                            <option value="administrativo" {{ (isset($documento_id) && $documento_id == 1) ? 'selected' : '' }}>Administrativo</option>
                            <option value="academico" {{ (isset($documento_id) && $documento_id == 2) ? 'selected' : '' }}>Académico</option>
                            <option value="legal" {{ (isset($documento_id) && $documento_id == 3) ? 'selected' : '' }}>Legal</option>
                            <option value="institucional">Institucional</option>
                            <option value="financiero">Financiero</option>
                            <option value="tecnico">Técnico</option>
                            <option value="normativo">Normativo</option>
                        </select>
                    </div>

                    <!-- Escuela (solo visible para administradores) -->
                    <div class="space-y-1">
                        <label for="id_escuela" class="block text-sm font-medium text-secondary-700">
                            Escuela <span class="text-danger-500">*</span>
                        </label>
                        {{-- TODO: Implementar selección de escuela dinámica según rol del usuario --}}
                        <select
                            name="id_escuela"
                            id="id_escuela"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            {{ $modo == 'show' ? 'disabled' : '' }}
                            required
                        >
                            <option value="">Seleccione una escuela</option>
                            {{-- Para Usuario General: Solo su escuela / Para Admin: Todas las escuelas --}}
                            <option value="1" {{ (isset($documento_id) && ($documento_id == 1 || $documento_id == 2)) ? 'selected' : '' }}>Colegio San Martín</option>
                            <option value="2" {{ (isset($documento_id) && $documento_id == 3) ? 'selected' : '' }}>Instituto Belgrano</option>
                        </select>
                    </div>

                    <!-- Fecha del Documento -->
                    <div class="space-y-1">
                        <label for="fecha_documento" class="block text-sm font-medium text-secondary-700">
                            Fecha del Documento <span class="text-danger-500">*</span>
                        </label>
                        <input
                            type="date"
                            name="fecha_documento"
                            id="fecha_documento"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            value="{{ isset($documento_id) && $documento_id == 1 ? '2024-02-15' : (isset($documento_id) && $documento_id == 2 ? '2024-03-01' : (isset($documento_id) && $documento_id == 3 ? '2023-01-20' : '')) }}"
                            {{ $modo == 'show' ? 'readonly' : '' }}
                            required
                        >
                    </div>

                    <!-- Fecha de Vencimiento -->
                    <div class="space-y-1">
                        <label for="fecha_vencimiento" class="block text-sm font-medium text-secondary-700">
                            Fecha de Vencimiento
                        </label>
                        <input
                            type="date"
                            name="fecha_vencimiento"
                            id="fecha_vencimiento"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            value="{{ isset($documento_id) && $documento_id == 1 ? '2024-12-31' : (isset($documento_id) && $documento_id == 3 ? '2025-01-20' : '') }}"
                            {{ $modo == 'show' ? 'readonly' : '' }}
                        >
                        <p class="text-xs text-secondary-500">Dejar vacío si el documento no tiene vencimiento</p>
                    </div>

                    <!-- Descripción -->
                    <div class="md:col-span-2 space-y-1">
                        <label for="descripcion" class="block text-sm font-medium text-secondary-700">
                            Descripción
                        </label>
                        <textarea
                            name="descripcion"
                            id="descripcion"
                            rows="4"
                            class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}"
                            placeholder="Descripción detallada del documento..."
                            {{ $modo == 'show' ? 'readonly' : '' }}
                        >{{ isset($documento_id) && $documento_id == 1 ? 'Documento oficial de matrícula estudiantil para el ciclo lectivo 2024. Contiene las resoluciones y normativas para el proceso de inscripción.' : (isset($documento_id) && $documento_id == 2 ? 'Curriculum académico oficial aprobado por el Ministerio de Educación para el año 2024.' : (isset($documento_id) && $documento_id == 3 ? 'Certificado de habilitación del establecimiento educativo emitido por las autoridades sanitarias correspondientes.' : '')) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Archivo del Documento -->
            @if($modo != 'show')
            <div class="border-b border-secondary-200 pb-6">
                <h3 class="text-lg font-medium text-secondary-900 mb-4">Archivo del Documento</h3>
                <div class="space-y-4">
                    <!-- Subida de Archivo -->
                    <div class="space-y-1">
                        <label for="archivo" class="block text-sm font-medium text-secondary-700">
                            Archivo <span class="text-danger-500">*</span>
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-secondary-300 border-dashed rounded-lg hover:border-primary-400 transition-colors">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-secondary-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-secondary-600">
                                    <label for="archivo" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                        <span>Subir un archivo</span>
                                        <input id="archivo" name="archivo" type="file" class="sr-only" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png" {{ $modo == 'create' ? 'required' : '' }}>
                                    </label>
                                    <p class="pl-1">o arrastrar y soltar</p>
                                </div>
                                <p class="text-xs text-secondary-500">
                                    PDF, DOC, DOCX, XLS, XLSX, JPG, PNG hasta 10MB
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <!-- Vista del archivo existente -->
            <div class="border-b border-secondary-200 pb-6">
                <h3 class="text-lg font-medium text-secondary-900 mb-4">Archivo del Documento</h3>
                <div class="bg-secondary-50 rounded-lg p-4 flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <div class="h-12 w-12 rounded-lg bg-red-100 flex items-center justify-center">
                            <i class="fas fa-file-pdf text-red-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-secondary-900 truncate">
                            {{ isset($documento_id) && $documento_id == 1 ? 'resolucion_matricula_2024.pdf' : (isset($documento_id) && $documento_id == 2 ? 'plan_estudios_2024.xlsx' : 'habilitacion_sanitaria.pdf') }}
                        </p>
                        <p class="text-sm text-secondary-500">
                            {{ isset($documento_id) && $documento_id == 1 ? '2.3 MB' : (isset($documento_id) && $documento_id == 2 ? '1.8 MB' : '1.1 MB') }} • Subido el {{ isset($documento_id) && $documento_id == 1 ? '15/02/2024' : (isset($documento_id) && $documento_id == 2 ? '01/03/2024' : '20/01/2023') }}
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        <a href="#" class="inline-flex items-center px-3 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Descargar
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Información de Carga -->
            @if($modo == 'show')
            <div class="space-y-4">
                <h3 class="text-lg font-medium text-secondary-900">Información de Carga</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-secondary-700">Usuario que Cargó</label>
                        <div class="block w-full px-3 py-2 bg-secondary-50 border border-secondary-300 rounded-lg text-sm text-secondary-900">
                            {{ isset($documento_id) && $documento_id == 1 ? 'Juan Pérez (Secretario)' : (isset($documento_id) && $documento_id == 2 ? 'María García (Directora Académica)' : 'Carlos López (Director)') }}
                        </div>
                    </div>
                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-secondary-700">Fecha de Carga</label>
                        <div class="block w-full px-3 py-2 bg-secondary-50 border border-secondary-300 rounded-lg text-sm text-secondary-900">
                            {{ isset($documento_id) && $documento_id == 1 ? '15/02/2024 14:30' : (isset($documento_id) && $documento_id == 2 ? '01/03/2024 09:15' : '20/01/2023 16:45') }}
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Botones de Acción -->
            <div class="flex items-center justify-between pt-6 border-t border-secondary-200">
                {{-- TODO: Definir la ruta correcta para el listado de documentos --}}
                <a href="{{ route('documentos.index') }}" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver al Listado
                </a>
                @if($modo != 'show')
                <button type="submit" class="inline-flex items-center px-6 py-2 bg-primary-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ $modo == 'create' ? 'Guardar Documento' : 'Actualizar Documento' }}
                </button>
                @endif
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validación de formulario en tiempo real
        const form = document.querySelector('form');
        const requiredInputs = form.querySelectorAll('input[required], select[required]');

        requiredInputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });

            input.addEventListener('input', function() {
                if (this.classList.contains('border-danger-300')) {
                    validateField(this);
                }
            });

            input.addEventListener('change', function() {
                if (this.classList.contains('border-danger-300')) {
                    validateField(this);
                }
            });
        });

        function validateField(field) {
            const value = field.value.trim();
            const isValid = value !== '';

            if (isValid) {
                field.classList.remove('border-danger-300', 'focus:border-danger-500', 'focus:ring-danger-500');
                field.classList.add('border-success-300', 'focus:border-primary-500', 'focus:ring-primary-500');
            } else {
                field.classList.remove('border-success-300', 'focus:border-primary-500', 'focus:ring-primary-500');
                field.classList.add('border-danger-300', 'focus:border-danger-500', 'focus:ring-danger-500');
            }
        }

        // Manejo de subida de archivos
        const fileInput = document.getElementById('archivo');
        const dropZone = fileInput?.closest('.border-dashed');

        if (fileInput && dropZone) {
            // Prevenir comportamientos por defecto del drag & drop
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
                document.body.addEventListener(eventName, preventDefaults, false);
            });

            // Highlight drop zone cuando el archivo está sobre ella
            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, unhighlight, false);
            });

            // Manejar el drop del archivo
            dropZone.addEventListener('drop', handleDrop, false);

            // Mostrar información del archivo seleccionado
            fileInput.addEventListener('change', function() {
                handleFiles(this.files);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            function highlight(e) {
                dropZone.classList.add('border-primary-400', 'bg-primary-50');
            }

            function unhighlight(e) {
                dropZone.classList.remove('border-primary-400', 'bg-primary-50');
            }

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                fileInput.files = files;
                handleFiles(files);
            }

            function handleFiles(files) {
                if (files.length > 0) {
                    const file = files[0];
                    const maxSize = 10 * 1024 * 1024; // 10MB
                    const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'image/jpeg', 'image/jpg', 'image/png'];

                    if (file.size > maxSize) {
                        alert('El archivo es demasiado grande. El tamaño máximo permitido es 10MB.');
                        fileInput.value = '';
                        return;
                    }

                    if (!allowedTypes.includes(file.type)) {
                        alert('Tipo de archivo no permitido. Solo se permiten archivos PDF, DOC, DOCX, XLS, XLSX, JPG y PNG.');
                        fileInput.value = '';
                        return;
                    }

                    // Mostrar información del archivo seleccionado
                    const fileInfo = document.createElement('div');
                    fileInfo.className = 'mt-2 p-2 bg-success-50 border border-success-200 rounded text-sm text-success-700';
                    fileInfo.innerHTML = `
                        <i class="fas fa-check-circle mr-2"></i>
                        Archivo seleccionado: <strong>${file.name}</strong> (${(file.size / 1024 / 1024).toFixed(2)} MB)
                    `;
                    
                    // Remover mensaje anterior si existe
                    const existingInfo = dropZone.querySelector('.bg-success-50');
                    if (existingInfo) {
                        existingInfo.remove();
                    }
                    
                    dropZone.appendChild(fileInfo);
                }
            }
        }

        // Animación de feedback visual
        const submitButton = document.querySelector('button[type="submit"]');
        if (submitButton) {
            form.addEventListener('submit', function(e) {
                // Prevent actual form submission for mockup
                e.preventDefault();

                // Basic validation check before simulating submission
                let formIsValid = true;
                requiredInputs.forEach(input => {
                    if (input.value.trim() === '') {
                        validateField(input);
                        formIsValid = false;
                    }
                });

                if (formIsValid) {
                    submitButton.classList.add('opacity-75');
                    submitButton.disabled = true;

                    // Simular procesamiento (en producción esto sería manejado por el servidor)
                    setTimeout(() => {
                        submitButton.classList.remove('opacity-75');
                        submitButton.disabled = false;
                        alert('Formulario de Documento simulado enviado.');
                    }, 2000);
                } else {
                    alert('Por favor, complete todos los campos obligatorios.');
                }
            });
        }
    });
</script>
@endpush