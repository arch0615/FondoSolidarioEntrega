@extends('layouts.app')

@section('header')
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Dashboard - Administración JAEC</h2>
        <p class="text-gray-600">Panel de control general del sistema - {{ Auth::user()->nombre_completo ?? 'Administrador' }}</p>
        <p class="text-sm text-blue-600">{{ Auth::user()->rol_nombre }}</p>
    </div>
@endsection

@section('content')
    @livewire('dashboards.admin-dashboard')
@endsection