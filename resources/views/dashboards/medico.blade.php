@extends('layouts.app')

@section('header')
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Dashboard - Auditoría Médica</h2>
        <p class="text-gray-600">Panel de auditoría y autorización de reintegros - {{ Auth::user()->nombre_completo ?? 'Médico Auditor' }}</p>
        <p class="text-sm text-green-600">{{ Auth::user()->rol_nombre }}</p>
    </div>
@endsection

@section('content')
    @livewire('dashboards.medico-dashboard')
@endsection