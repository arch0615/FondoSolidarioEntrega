@extends('layouts.app')

@section('header')
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Dashboard</h2>
        <p class="text-gray-600">Bienvenido al sistema - {{ Auth::user()->nombre_completo ?? 'Usuario' }}</p>
    </div>
@endsection

@section('content')
    <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white rounded-lg border border-red-200 p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Accidentes Reportados</p>
                            <p class="text-3xl font-bold text-red-700 mt-2">12</p>
                            <p class="text-xs text-red-600 mt-1">↑ 2 este mes</p>
                        </div>
                        <div class="p-3 rounded-lg bg-red-50 border border-red-200">
                            <i class="fas fa-shield-alt text-red-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg border border-blue-200 p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Derivaciones Generadas</p>
                            <p class="text-3xl font-bold text-blue-700 mt-2">25</p>
                            <p class="text-xs text-blue-600 mt-1">↑ 5 este mes</p>
                        </div>
                        <div class="p-3 rounded-lg bg-blue-50 border border-blue-200">
                            <i class="fas fa-file-medical text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg border border-amber-200 p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Reintegros Pendientes</p>
                            <p class="text-3xl font-bold text-amber-700 mt-2">3</p>
                            <p class="text-xs text-amber-600 mt-1">En proceso</p>
                        </div>
                        <div class="p-3 rounded-lg bg-amber-50 border border-amber-200">
                            <i class="fas fa-clock text-amber-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg border border-green-200 p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Salidas Educativas</p>
                            <p class="text-3xl font-bold text-green-700 mt-2">8</p>
                            <p class="text-xs text-green-600 mt-1">↑ 3 esta semana</p>
                        </div>
                        <div class="p-3 rounded-lg bg-green-50 border border-green-200">
                            <i class="fas fa-route text-green-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Recent Activity -->
                <div class="lg:col-span-2 bg-white rounded-lg border border-gray-200 p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Actividad Reciente</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-red-25 border border-red-100 rounded-lg hover:bg-red-50 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-red-100 rounded-lg border border-red-200">
                                    <i class="fas fa-shield-alt text-red-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Accidente reportado</p>
                                    <p class="text-sm text-gray-600">Juan Pérez - 5to A</p>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500">Hace 2 horas</p>
                        </div>
                        
                        <div class="flex items-center justify-between p-4 bg-primary-25 border border-primary-100 rounded-lg hover:bg-primary-50 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-primary-100 rounded-lg border border-primary-200">
                                    <i class="fas fa-check-circle text-primary-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Reintegro autorizado</p>
                                    <p class="text-sm text-gray-600">Farmacia Central - $1,200</p>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500">Hace 4 horas</p>
                        </div>
                        
                        <div class="flex items-center justify-between p-4 bg-primary-25 border border-primary-100 rounded-lg hover:bg-primary-50 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-primary-100 rounded-lg border border-primary-200">
                                    <i class="fas fa-file-medical text-primary-700"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Derivación generada</p>
                                    <p class="text-sm text-gray-600">María González - Clínica Norte</p>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500">Ayer</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg border border-primary-200 p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-primary-800 mb-4">Acciones Rápidas</h3>
                    
                    <div class="space-y-3">
                        <button class="w-full flex items-center gap-3 p-3 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-all duration-200 hover:shadow-md">
                            <i class="fas fa-shield-alt"></i>
                            <span>Reportar Accidente</span>
                        </button>
                        
                        <a href="{{ route('salidas-educativas.create') }}" class="w-full flex items-center gap-3 p-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-all duration-200 hover:shadow-md">
                            <i class="fas fa-route"></i>
                            <span>Registrar Salida Educativa</span>
                        </a>
                        
                        <button class="w-full flex items-center gap-3 p-3 border-2 border-primary-300 text-primary-700 hover:bg-primary-50 hover:border-primary-400 rounded-lg transition-all duration-200">
                            <i class="fas fa-file-medical"></i>
                            <span>Generar Derivación</span>
                        </button>

                        <button class="w-full flex items-center gap-3 p-3 border-2 border-primary-200 text-primary-600 hover:bg-primary-25 hover:border-primary-300 rounded-lg transition-all duration-200">
                            <i class="fas fa-folder-open"></i>
                            <span>Subir Documentos</span>
                        </button>
                    </div>
                </div>
            </div>
@endsection