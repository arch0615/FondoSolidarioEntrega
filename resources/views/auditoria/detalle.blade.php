<x-layouts.app>
    <x-slot name="title">
        Detalle de Auditoría
    </x-slot>

    <div class="mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-secondary-900">Detalle del Evento de Auditoría</h1>
            <a href="{{ route('auditoria.historial-auditorias') }}" class="px-4 py-2 bg-secondary-200 text-secondary-800 rounded-lg hover:bg-secondary-300 transition-colors">
                &larr; Volver al Historial
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-2xl w-full">
            @if ($itemType === 'auditoria')
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-6">
                        <div>
                            <h4 class="font-semibold text-secondary-800 mb-3">Detalles del Evento</h4>
                            <div class="text-sm space-y-2">
                                <div><strong class="text-secondary-600 w-28 inline-block">Fecha:</strong> {{ $item->fecha_hora->format('d/m/Y H:i:s') }}</div>
                                <div><strong class="text-secondary-600 w-28 inline-block">Usuario:</strong> {{ $item->usuario->email ?? 'N/A' }}</div>
                                <div><strong class="text-secondary-600 w-28 inline-block">Acción:</strong> {{ $item->accion }}</div>
                                <div><strong class="text-secondary-600 w-28 inline-block">Tabla:</strong> {{ $item->tabla_afectada }}</div>
                                <div><strong class="text-secondary-600 w-28 inline-block">ID Registro:</strong> {{ $item->id_registro }}</div>
                            </div>
                        </div>
                        <div>
                            <h4 class="font-semibold text-secondary-800 mb-3">Información del Reintegro</h4>
                            <div class="text-sm space-y-2">
                                <div><strong class="text-secondary-600 w-28 inline-block">Alumno:</strong> {{ $item->reintegro->accidente->alumnos->first()->alumno->nombre_completo ?? 'N/A' }}</div>
                                <div><strong class="text-secondary-600 w-28 inline-block">Escuela:</strong> {{ $item->reintegro->accidente->escuela->nombre ?? 'N/A' }}</div>
                                <div><strong class="text-secondary-600 w-28 inline-block">Monto:</strong> ${{ number_format($item->reintegro->monto_solicitado, 2) }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-6">
                        <div>
                            <h4 class="font-semibold text-secondary-800 mb-2">Datos Anteriores</h4>
                            <pre class="bg-secondary-50 p-3 rounded-lg text-xs text-secondary-700 overflow-x-auto">@json(json_decode($item->datos_anteriores), JSON_PRETTY_PRINT)</pre>
                        </div>
                        <div>
                            <h4 class="font-semibold text-secondary-800 mb-2">Datos Nuevos</h4>
                            <pre class="bg-secondary-50 p-3 rounded-lg text-xs text-secondary-700 overflow-x-auto">@json(json_decode($item->datos_nuevos), JSON_PRETTY_PRINT)</pre>
                        </div>
                    </div>
                </div>
            @else
                <div class="p-6 space-y-6">
                    <div>
                        <h4 class="font-semibold text-secondary-800 mb-3">Detalles de la Solicitud</h4>
                        <div class="text-sm space-y-2">
                            <div><strong class="text-secondary-600 w-40 inline-block">Fecha Solicitud:</strong> {{ $item->fecha_solicitud->format('d/m/Y H:i:s') }}</div>
                            <div><strong class="text-secondary-600 w-40 inline-block">Auditor:</strong> {{ $item->auditor->nombre_completo ?? 'N/A' }}</div>
                            <div><strong class="text-secondary-600 w-40 inline-block">Estado:</strong> {{ $item->estadoSolicitud->nombre_estado ?? 'N/A' }}</div>
                            <div><strong class="text-secondary-600 w-40 inline-block">Reintegro ID:</strong> {{ $item->id_reintegro }}</div>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-semibold text-secondary-800 mb-2">Descripción de la Solicitud</h4>
                        <p class="text-sm text-secondary-700">{{ $item->descripcion_solicitud }}</p>
                    </div>
                    <div>
                        <h4 class="font-semibold text-secondary-800 mb-2">Documentos Requeridos</h4>
                        <p class="text-sm text-secondary-700">{{ $item->documentos_requeridos }}</p>
                    </div>
                     @if($item->fecha_respuesta)
                    <div>
                        <h4 class="font-semibold text-secondary-800 mb-3">Respuesta</h4>
                         <div class="text-sm space-y-2">
                            <div><strong class="text-secondary-600 w-40 inline-block">Fecha Respuesta:</strong> {{ $item->fecha_respuesta->format('d/m/Y H:i:s') }}</div>
                            <div><strong class="text-secondary-600 w-40 inline-block">Usuario Respuesta:</strong> {{ $item->usuarioResponde->nombre_completo ?? 'N/A' }}</div>
                            <div>
                                <strong class="text-secondary-600 w-40 inline-block align-top">Observaciones:</strong>
                                <p class="inline-block w-2/3">{{ $item->observaciones_respuesta }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>