@extends('pdf.layout')

@section('title', 'Accidente - Expediente ' . ($accidente->numero_expediente ?? 'S/N'))

@section('content')
    <!-- Encabezado -->
    @if(file_exists(public_path('images/EncabezadoDerivacion.png')))
    <div class="text-center mb-5">
        <img src="{{ public_path('images/EncabezadoDerivacion.png') }}" class="header-img" alt="Encabezado">
    </div>
    @endif

    <h1>INFORME DE ACCIDENTE ESCOLAR</h1>
    @if($accidente->numero_expediente)
    <p class="text-center text-sm">Expediente N&deg;: <strong>{{ $accidente->numero_expediente }}</strong></p>
    @endif

    <div class="fecha-emision">
        Fecha de Emisi&oacute;n: <strong>{{ now()->format('d/m/Y') }}</strong>
    </div>

    <p class="mb-10">Se informa el siguiente accidente registrado en la <strong>{{ $accidente->escuela->nombre ?? 'N/A' }}</strong>:</p>

    <!-- Datos del Accidente -->
    <div class="data-box">
        <h3>Datos del Accidente</h3>
        <table class="data-table">
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

    <!-- Alumnos Involucrados -->
    @if($accidente->alumnos && $accidente->alumnos->count() > 0)
    <div class="data-box">
        <h3>Alumnos Involucrados</h3>
        <table class="bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
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
    </div>
    @endif

    <!-- Descripcion -->
    <div class="mb-10">
        <p class="mb-5"><strong>Descripci&oacute;n del Accidente:</strong></p>
        <div class="data-box">
            <p>{{ $accidente->descripcion_accidente }}</p>
        </div>
    </div>

    @if($archivos->count() > 0)
    <div class="mb-10">
        <p class="mb-5"><strong>Archivos Adjuntos:</strong></p>
        <ul>
            @foreach($archivos as $archivo)
                <li>{{ $archivo->nombre_archivo }}</li>
            @endforeach
        </ul>
    </div>
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
