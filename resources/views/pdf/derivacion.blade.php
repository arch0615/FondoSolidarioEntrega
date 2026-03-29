@extends('pdf.layout')

@section('title', 'Derivacion Medica - ' . $derivacion->alumno->nombre_completo)

@section('content')
    <!-- Encabezado -->
    @if(file_exists(public_path('images/EncabezadoDerivacion.png')))
    <div class="text-center mb-5">
        <img src="{{ public_path('images/EncabezadoDerivacion.png') }}" class="header-img" alt="Encabezado">
    </div>
    @endif

    <h1>AUTORIZACI&Oacute;N DE DERIVACI&Oacute;N M&Eacute;DICA</h1>

    <div class="fecha-emision">
        Fecha de Emisi&oacute;n: <strong>{{ now()->format('d/m/Y') }}</strong>
    </div>

    <p class="mb-10">Por medio de la presente, la Direcci&oacute;n de la <strong>{{ $derivacion->accidente->escuela->nombre }}</strong>, autoriza la derivaci&oacute;n para atenci&oacute;n m&eacute;dica del alumno/a:</p>

    <div class="data-box mb-10">
        <p><strong>Nombre Completo:</strong> {{ $derivacion->alumno->nombre_completo }}</p>
        <p><strong>DNI:</strong> {{ $derivacion->alumno->dni }}</p>
    </div>

    <p class="mb-10">El/la mismo/a ser&aacute; trasladado/a a la instituci&oacute;n <strong>{{ $derivacion->prestador->nombre }}</strong> en compa&ntilde;&iacute;a de <strong>{{ $derivacion->acompanante }}</strong>, con fecha y hora de derivaci&oacute;n <strong>{{ $derivacion->fecha_derivacion->format('d/m/Y') }} a las {{ \Carbon\Carbon::parse($derivacion->hora_derivacion)->format('H:i') }} hs.</strong></p>

    <p class="mb-10">El motivo de la derivaci&oacute;n se debe a un accidente ocurrido en las instalaciones de la escuela, cuya descripci&oacute;n y diagn&oacute;stico presuntivo se detallan a continuaci&oacute;n:</p>

    <div class="data-box mb-10">
        <p><strong>Descripci&oacute;n del Accidente:</strong> {{ $derivacion->accidente->descripcion_accidente }}</p>
        <p style="margin-top: 5px;"><strong>Diagn&oacute;stico Inicial (Presuntivo):</strong> {{ $derivacion->diagnostico_inicial }}</p>
        @if($derivacion->observaciones)
        <p style="margin-top: 5px;"><strong>Observaciones Adicionales:</strong> {{ $derivacion->observaciones }}</p>
        @endif
    </div>

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
