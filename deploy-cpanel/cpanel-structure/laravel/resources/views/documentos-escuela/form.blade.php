@extends('layouts.app')

@section('title', $modo === 'create' ? 'Crear Documento' : ($modo === 'edit' ? 'Editar Documento' : 'Ver Documento'))

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-secondary-900">
                        @if($modo === 'create')
                            Crear Nuevo Documento
                        @elseif($modo === 'edit')
                            Editar Documento
                        @else
                            Ver Documento
                        @endif
                    </h1>
                    <p class="mt-1 text-sm text-secondary-600">
                        @if($modo === 'create')
                            Completa la información para crear un nuevo documento institucional
                        @elseif($modo === 'edit')
                            Modifica la información del documento institucional
                        @else
                            Información detallada del documento institucional
                        @endif
                    </p>
                </div>
                <a href="{{ route('documentos-escuela.index') }}" class="inline-flex items-center px-4 py-2 bg-secondary-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-secondary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver al Listado
                </a>
            </div>
        </div>

        <!-- Formulario -->
        <div class="bg-white rounded-xl border border-secondary-200 overflow-hidden">
            @if($modo === 'create')
                @livewire('documentos-escuela.form', ['modo' => 'create'])
            @elseif($modo === 'edit')
                @livewire('documentos-escuela.form', ['modo' => 'edit', 'documento_id' => $documento_id])
            @else
                @livewire('documentos-escuela.form', ['modo' => 'show', 'documento_id' => $documento_id])
            @endif
        </div>
    </div>
</div>
@endsection
