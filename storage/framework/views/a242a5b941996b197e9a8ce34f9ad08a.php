<?php $__env->startSection('header'); ?>
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Gestión de Accidentes</h2>
        <p class="text-gray-600">Registro y seguimiento de accidentes escolares</p>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Action Buttons -->
    <div class="mb-6 flex gap-4">
        <button class="flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
            <i class="fas fa-plus"></i>
            Registrar Accidente
        </button>
        <button class="flex items-center gap-2 px-4 py-2 border border-primary-300 text-primary-700 hover:bg-primary-50 rounded-lg transition-colors">
            <i class="fas fa-file-medical"></i>
            Generar Derivación
        </button>
        <button class="flex items-center gap-2 px-4 py-2 border border-green-300 text-green-700 hover:bg-green-50 rounded-lg transition-colors">
            <i class="fas fa-dollar-sign"></i>
            Solicitar Reintegro
        </button>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg border border-red-200 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Este Mes</p>
                    <p class="text-2xl font-bold text-red-700 mt-1">5</p>
                </div>
                <div class="p-2 bg-red-100 rounded-lg">
                    <i class="fas fa-calendar text-red-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg border border-amber-200 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Pendientes</p>
                    <p class="text-2xl font-bold text-amber-700 mt-1">2</p>
                </div>
                <div class="p-2 bg-amber-100 rounded-lg">
                    <i class="fas fa-clock text-amber-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg border border-green-200 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Resueltos</p>
                    <p class="text-2xl font-bold text-green-700 mt-1">10</p>
                </div>
                <div class="p-2 bg-green-100 rounded-lg">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Accident List -->
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Accidentes Recientes</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Alumno</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900">2025-05-30</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Juan Pérez - 5to A</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Caída en recreo</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-medium bg-amber-100 text-amber-800 rounded-full">Pendiente</span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <button class="text-primary-600 hover:text-primary-700 mr-3">Ver</button>
                            <button class="text-blue-600 hover:text-blue-700 mr-3">Derivar</button>
                            <button class="text-green-600 hover:text-green-700">Reintegro</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900">2025-05-28</td>
                        <td class="px-6 py-4 text-sm text-gray-900">María González - 3ro B</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Golpe en educación física</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Resuelto</span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <button class="text-primary-600 hover:text-primary-700 mr-3">Ver</button>
                            <button class="text-gray-400 cursor-not-allowed mr-3">Derivar</button>
                            <button class="text-gray-400 cursor-not-allowed">Reintegro</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900">2025-05-25</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Carlos Rodríguez - 1ro A</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Corte en el laboratorio</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">En proceso</span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <button class="text-primary-600 hover:text-primary-700 mr-3">Ver</button>
                            <button class="text-blue-600 hover:text-blue-700 mr-3">Derivar</button>
                            <button class="text-green-600 hover:text-green-700">Reintegro</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600">Mostrando 3 de 12 accidentes</p>
                <div class="flex gap-2">
                    <button class="px-3 py-1 border border-gray-300 rounded text-sm hover:bg-gray-50">Anterior</button>
                    <button class="px-3 py-1 border border-gray-300 rounded text-sm hover:bg-gray-50">Siguiente</button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\rican\OneDrive\Documentos\workana\Fondo Solidario\resources\views\accidentes\index.blade.php ENDPATH**/ ?>