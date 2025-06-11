<?php $__env->startSection('header'); ?>
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Gestión de Alumnos</h2>
        <p class="text-gray-600">Registro y búsqueda de alumnos de la institución</p>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Search and Action Bar -->
    <div class="mb-6 flex flex-col sm:flex-row gap-4 justify-between">
        <div class="flex-1 max-w-md">
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                <input type="text" placeholder="Buscar alumno por nombre, DNI o curso..." 
                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:border-primary-500 focus:ring-2 focus:ring-primary-200 focus:outline-none">
            </div>
        </div>
        <button class="flex items-center gap-2 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors">
            <i class="fas fa-plus"></i>
            Registrar Alumno
        </button>
    </div>

    <!-- Filters -->
    <div class="mb-6 bg-white rounded-lg border border-gray-200 p-4">
        <h3 class="text-sm font-medium text-gray-700 mb-3">Filtros</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <select class="border border-gray-300 rounded-lg px-3 py-2 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 focus:outline-none">
                <option>Todos los años</option>
                <option>1er Año</option>
                <option>2do Año</option>
                <option>3er Año</option>
                <option>4to Año</option>
                <option>5to Año</option>
            </select>
            <select class="border border-gray-300 rounded-lg px-3 py-2 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 focus:outline-none">
                <option>Todas las divisiones</option>
                <option>División A</option>
                <option>División B</option>
                <option>División C</option>
            </select>
            <select class="border border-gray-300 rounded-lg px-3 py-2 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 focus:outline-none">
                <option>Estado: Todos</option>
                <option>Activo</option>
                <option>Inactivo</option>
            </select>
            <button class="flex items-center justify-center gap-2 px-4 py-2 border border-gray-300 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                <i class="fas fa-filter"></i>
                Aplicar Filtros
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg border border-primary-200 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Alumnos</p>
                    <p class="text-2xl font-bold text-primary-700 mt-1">450</p>
                </div>
                <div class="p-2 bg-primary-100 rounded-lg">
                    <i class="fas fa-graduation-cap text-primary-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg border border-green-200 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Activos</p>
                    <p class="text-2xl font-bold text-green-700 mt-1">442</p>
                </div>
                <div class="p-2 bg-green-100 rounded-lg">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg border border-amber-200 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Con Accidentes</p>
                    <p class="text-2xl font-bold text-amber-700 mt-1">12</p>
                </div>
                <div class="p-2 bg-amber-100 rounded-lg">
                    <i class="fas fa-exclamation-triangle text-amber-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg border border-blue-200 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Nuevos (Este mes)</p>
                    <p class="text-2xl font-bold text-blue-700 mt-1">8</p>
                </div>
                <div class="p-2 bg-blue-100 rounded-lg">
                    <i class="fas fa-user-plus text-blue-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Students List -->
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Lista de Alumnos</h3>
                <div class="flex gap-2">
                    <button class="text-sm text-gray-600 hover:text-gray-700">
                        <i class="fas fa-download mr-1"></i>
                        Exportar
                    </button>
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Alumno</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">DNI</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Curso</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha Nacimiento</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-10 w-10 bg-primary-100 rounded-full flex items-center justify-center">
                                    <span class="text-primary-600 font-medium">JP</span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Juan Pérez</p>
                                    <p class="text-sm text-gray-500">juan.perez@email.com</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">42.123.456</td>
                        <td class="px-6 py-4 text-sm text-gray-900">5to A</td>
                        <td class="px-6 py-4 text-sm text-gray-900">15/03/2008</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Activo</span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <button class="text-primary-600 hover:text-primary-700 mr-3">Ver</button>
                            <button class="text-blue-600 hover:text-blue-700 mr-3">Editar</button>
                            <button class="text-red-600 hover:text-red-700">Historial</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-10 w-10 bg-pink-100 rounded-full flex items-center justify-center">
                                    <span class="text-pink-600 font-medium">MG</span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">María González</p>
                                    <p class="text-sm text-gray-500">maria.gonzalez@email.com</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">43.987.654</td>
                        <td class="px-6 py-4 text-sm text-gray-900">3ro B</td>
                        <td class="px-6 py-4 text-sm text-gray-900">22/08/2010</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Activo</span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <button class="text-primary-600 hover:text-primary-700 mr-3">Ver</button>
                            <button class="text-blue-600 hover:text-blue-700 mr-3">Editar</button>
                            <button class="text-red-600 hover:text-red-700">Historial</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-blue-600 font-medium">CR</span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Carlos Rodríguez</p>
                                    <p class="text-sm text-gray-500">carlos.rodriguez@email.com</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">44.567.890</td>
                        <td class="px-6 py-4 text-sm text-gray-900">1ro A</td>
                        <td class="px-6 py-4 text-sm text-gray-900">10/12/2012</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Activo</span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <button class="text-primary-600 hover:text-primary-700 mr-3">Ver</button>
                            <button class="text-blue-600 hover:text-blue-700 mr-3">Editar</button>
                            <button class="text-red-600 hover:text-red-700">Historial</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600">Mostrando 3 de 450 alumnos</p>
                <div class="flex gap-2">
                    <button class="px-3 py-1 border border-gray-300 rounded text-sm hover:bg-gray-50">Anterior</button>
                    <span class="px-3 py-1 bg-primary-600 text-white rounded text-sm">1</span>
                    <button class="px-3 py-1 border border-gray-300 rounded text-sm hover:bg-gray-50">2</button>
                    <button class="px-3 py-1 border border-gray-300 rounded text-sm hover:bg-gray-50">3</button>
                    <button class="px-3 py-1 border border-gray-300 rounded text-sm hover:bg-gray-50">Siguiente</button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\rican\OneDrive\Documentos\workana\Fondo Solidario\resources\views\alumnos\index.blade.php ENDPATH**/ ?>