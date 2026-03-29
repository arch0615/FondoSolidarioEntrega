@extends('pdf.layout')

@section('title', 'Salida Educativa - ' . $salida->destino)

@section('content')
    <!-- Encabezado -->
    @if(file_exists(public_path('images/EncabezadoDerivacion.png')))
    <div class="text-center mb-5">
        <img src="{{ public_path('images/EncabezadoDerivacion.png') }}" class="header-img" alt="Encabezado">
    </div>
    @endif

    <h1>AUTORIZACI&Oacute;N DE SALIDA EDUCATIVA</h1>

    <div class="fecha-emision">
        Fecha de Emisi&oacute;n: <strong>{{ now()->format('d/m/Y') }}</strong>
    </div>

    <p class="mb-10">Por medio de la presente, se autoriza la siguiente salida educativa de la <strong>{{ $salida->escuela->nombre ?? 'N/A' }}</strong>:</p>

    <!-- Datos de la Salida -->
    <div class="data-box">
        <table class="data-table">
            <tr>
                <td class="label">Destino:</td>
                <td>{{ $salida->destino }}</td>
            </tr>
            <tr>
                <td class="label">Fecha de Salida:</td>
                <td>
                    {{ $salida->fecha_salida ? $salida->fecha_salida->format('d/m/Y') : 'N/A' }}
                    @if($salida->fecha_hasta)
                        al {{ $salida->fecha_hasta->format('d/m/Y') }}
                    @endif
                </td>
            </tr>
            <tr>
                <td class="label">Horario:</td>
                <td>
                    {{ $salida->hora_salida ? \Carbon\Carbon::parse($salida->hora_salida)->format('H:i') : 'N/A' }} hs
                    a
                    {{ $salida->hora_regreso ? \Carbon\Carbon::parse($salida->hora_regreso)->format('H:i') : 'N/A' }} hs
                </td>
            </tr>
            @if($salida->grado_curso)
            <tr>
                <td class="label">Grado/Curso:</td>
                <td>{{ $salida->grado_curso }}</td>
            </tr>
            @endif
            <tr>
                <td class="label">Cantidad de Alumnos:</td>
                <td>{{ $salida->cantidad_alumnos }}</td>
            </tr>
            <tr>
                <td class="label">Medio de Transporte:</td>
                <td>{{ $salida->transporte }}</td>
            </tr>
        </table>
    </div>

    <!-- Proposito -->
    <div class="mb-10">
        <p class="mb-5"><strong>Prop&oacute;sito de la Salida:</strong></p>
        <div class="data-box">
            <p>{{ $salida->proposito }}</p>
        </div>
    </div>

    <!-- Docentes Acompanantes -->
    <div class="mb-10">
        <p class="mb-5"><strong>Docentes Acompa&ntilde;antes:</strong></p>
        <div class="data-box">
            <p>{{ $salida->docentes_acompanantes }}</p>
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

    <p class="mt-15 mb-15">Se extiende la presente para ser presentada ante quien corresponda.</p>

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
