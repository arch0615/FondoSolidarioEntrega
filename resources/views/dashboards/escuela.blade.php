@extends('layouts.app')

@section('header')
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Dashboard - Escuela</h2>
        <p class="text-gray-600">Bienvenido al sistema - {{ Auth::user()->nombre_completo ?? 'Usuario' }}</p>
        <p class="text-sm text-primary-600">{{ Auth::user()->rol_nombre }}</p>
    </div>
@endsection

@section('content')
    @livewire('dashboards.escuela-dashboard')
@endsection