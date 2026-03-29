@extends('pdf.layout')

@section('title', 'Expediente Completo - ' . ($accidente->numero_expediente ?? 'S/N'))

@section('content')
    <!-- Encabezado -->
    @if(file_exists(public_path('images/EncabezadoDerivacion.png')))
    <div class="text-center mb-5">
        <img src="{{ public_path('images/EncabezadoDerivacion.png') }}" class="header-img" alt="Encabezado">
    </div>
    @endif

    <h1>EXPEDIENTE DE SINIESTRO</h1>
    @if($accidente->numero_expediente)
    <p class="text-center text-sm">N&deg; Expediente: <strong>{{ $accidente->numero_expediente }}</strong></p>
    @endif

    <div class="fecha-emision">
        Fecha de Emisi&oacute;n: <strong>{{ now()->format('d/m/Y') }}</strong>
    </div>

    <!-- 1. DATOS DEL ACCIDENTE -->
    <h2>1. DATOS DEL ACCIDENTE</h2>
    <div class="data-box">
        <table class="data-table">
            <tr>
                <td class="label">Escuela:</td>
                <td>{{ $accidente->escuela->nombre ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Fecha:</td>
                <td>{{ $accidente->fecha_accidente ? $accidente->fecha_accidente->format('d/m/Y') : 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Hora:</td>
                <td>{{ $accidente->hora_accidente ? \Carbon\Carbon::parse($accidente->hora_accidente)->format('H:i') : 'N/A' }} hs</td>
            </tr>
            <tr>
                <td class="label">Lugar:</td>
                <td>{{ $accidente->lugar_accidente }}</td>
            </tr>
            <tr>
                <td class="label">Tipo de Lesi&oacute;n:</td>
                <td>{{ $accidente->tipo_lesion }}</td>
            </tr>
            <tr>
                <td class="label">Estado:</td>
                <td>{{ $accidente->estado->nombre_estado ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Protocolo Activado:</td>
                <td>{{ $accidente->protocolo_activado ? 'S&iacute;' : 'No' }}</td>
            </tr>
            @if($accidente->llamada_emergencia)
            <tr>
                <td class="label">Llamada de Emergencia:</td>
                <td>
                    S&iacute;
                    @if($accidente->hora_llamada) - {{ \Carbon\Carbon::parse($accidente->hora_llamada)->format('H:i') }} hs @endif
                    @if($accidente->servicio_emergencia) - {{ $accidente->servicio_emergencia }} @endif
                </td>
            </tr>
            @endif
        </table>
    </div>

    <div class="mb-10">
        <p class="mb-5"><strong>Descripci&oacute;n del Accidente:</strong></p>
        <div class="data-box">
            <p>{{ $accidente->descripcion_accidente }}</p>
        </div>
    </div>

    <!-- 2. ALUMNOS INVOLUCRADOS -->
    @if($accidente->alumnos && $accidente->alumnos->count() > 0)
    <h2>2. ALUMNOS INVOLUCRADOS</h2>
    <table class="bordered">
        <thead>
            <tr>
                <th>Nombre Completo</th>
                <th>DNI</th>
            </tr>
        </thead>
        <tbody>
            @foreach($accidente->alumnos as $accidenteAlumno)
            <tr>
                <td>{{ $accidenteAlumno->alumno->apellido ?? '' }} {{ $accidenteAlumno->alumno->nombre ?? '' }}</td>
                <td>{{ $accidenteAlumno->alumno->dni ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <!-- 3. DERIVACIONES -->
    @if($accidente->derivaciones && $accidente->derivaciones->count() > 0)
    <h2>3. DERIVACIONES M&Eacute;DICAS</h2>
    @foreach($accidente->derivaciones as $i => $derivacion)
    <div class="data-box mb-10">
        <h3>Derivaci&oacute;n #{{ $i + 1 }}</h3>
        <table class="data-table">
            <tr>
                <td class="label">Alumno:</td>
                <td>{{ $derivacion->alumno->apellido ?? '' }} {{ $derivacion->alumno->nombre ?? '' }}</td>
            </tr>
            <tr>
                <td class="label">Fecha:</td>
                <td>{{ $derivacion->fecha_derivacion ? $derivacion->fecha_derivacion->format('d/m/Y') : 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Hora:</td>
                <td>{{ $derivacion->hora_derivacion ? \Carbon\Carbon::parse($derivacion->hora_derivacion)->format('H:i') : 'N/A' }} hs</td>
            </tr>
            <tr>
                <td class="label">Prestador:</td>
                <td>{{ $derivacion->prestador->nombre ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Diagn&oacute;stico Inicial:</td>
                <td>{{ $derivacion->diagnostico_inicial }}</td>
            </tr>
            <tr>
                <td class="label">Acompa&ntilde;ante:</td>
                <td>{{ $derivacion->acompanante }}</td>
            </tr>
            @if($derivacion->observaciones)
            <tr>
                <td class="label">Observaciones:</td>
                <td>{{ $derivacion->observaciones }}</td>
            </tr>
            @endif
        </table>
    </div>
    @endforeach
    @endif

    <!-- 4. REINTEGROS -->
    @if($accidente->reintegros && $accidente->reintegros->count() > 0)
    <h2>{{ $accidente->derivaciones && $accidente->derivaciones->count() > 0 ? '4' : '3' }}. SOLICITUDES DE REINTEGRO</h2>
    @foreach($accidente->reintegros as $i => $reintegro)
    <div class="data-box mb-10">
        <h3>Reintegro #{{ $i + 1 }}</h3>
        <table class="data-table">
            <tr>
                <td class="label">Alumno:</td>
                <td>{{ $reintegro->alumno->apellido ?? '' }} {{ $reintegro->alumno->nombre ?? '' }}</td>
            </tr>
            <tr>
                <td class="label">Fecha Solicitud:</td>
                <td>{{ $reintegro->fecha_solicitud ? $reintegro->fecha_solicitud->format('d/m/Y') : 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Tipo de Gasto:</td>
                <td>{{ $reintegro->tiposGastos->pluck('descripcion')->join(', ') ?: $reintegro->descripcion_gasto }}</td>
            </tr>
            <tr>
                <td class="label">Monto Solicitado:</td>
                <td>${{ number_format($reintegro->monto_solicitado, 2) }}</td>
            </tr>
            <tr>
                <td class="label">Estado:</td>
                <td>{{ $reintegro->estadoReintegro->descripcion ?? $reintegro->estadoReintegro->nombre_estado ?? 'N/A' }}</td>
            </tr>
            @if($reintegro->monto_autorizado)
            <tr>
                <td class="label">Monto Autorizado:</td>
                <td>${{ number_format($reintegro->monto_autorizado, 2) }}</td>
            </tr>
            @endif
            @if($reintegro->observaciones_auditor)
            <tr>
                <td class="label">Observaciones Auditor:</td>
                <td>{{ $reintegro->observaciones_auditor }}</td>
            </tr>
            @endif
            @if($reintegro->fecha_pago)
            <tr>
                <td class="label">Fecha de Pago:</td>
                <td>{{ $reintegro->fecha_pago->format('d/m/Y') }}</td>
            </tr>
            @endif
            @if($reintegro->numero_transferencia)
            <tr>
                <td class="label">N&deg; Transferencia:</td>
                <td>{{ $reintegro->numero_transferencia }}</td>
            </tr>
            @endif
        </table>
    </div>
    @endforeach
    @endif

    <!-- Archivos adjuntos -->
    @if($archivos->count() > 0)
    <h2>ARCHIVOS ADJUNTOS</h2>
    <ul>
        @foreach($archivos as $archivo)
            <li>{{ $archivo->nombre_archivo }} ({{ $archivo->tamano_formateado }})</li>
        @endforeach
    </ul>
    @endif

    <p class="mt-15 mb-15">Se extiende el presente informe para ser presentado ante quien corresponda.</p>

    <!-- Firmas -->
    <table class="footer-signatures">
        <tr>
            <td>
                <div class="signature-line">Firma del Personal Autorizado</div>
            </td>
            <td>
                <div class="signature-line">Sello de la Instituci&oacute;n</div>
            </td>
        </tr>
    </table>
@endsection
