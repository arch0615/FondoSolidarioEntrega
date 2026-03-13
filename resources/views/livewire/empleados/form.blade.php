<div>
    @if($mensaje)
    <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: true }" x-show="show" x-transition>
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="show = false"></div>
            <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full sm:p-6">
                <div>
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full {{ $tipoMensaje === 'success' ? 'bg-green-100' : ($tipoMensaje === 'info' ? 'bg-blue-100' : 'bg-red-100') }}">
                        @if($tipoMensaje === 'success')
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        @elseif($tipoMensaje === 'info')
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @endif
                    </div>
                    <div class="mt-3 text-center sm:mt-5">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            @if($tipoMensaje === 'success')
                                ¡Éxito!
                            @elseif($tipoMensaje === 'info')
                                Información
                            @else
                                Error
                            @endif
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">{{ $mensaje }}</p>
                            @if($modo == 'create' && $tipoMensaje === 'success')
                                <p class="text-xs text-gray-400 mt-2">Redirigiendo al listado en 3 segundos...</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-6">
                    @if($modo == 'create' && $tipoMensaje === 'success')
                        <button @click="show = false" wire:click="redirigirAlListado" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 hover:bg-green-700 text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:text-sm">
                            Ir al Listado
                        </button>
                    @elseif($modo == 'edit' && $tipoMensaje === 'success')
                        <button @click="show = false" wire:click="redirigirAlListado" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 hover:bg-green-700 text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:text-sm">
                            Aceptar
                        </button>
                    @else
                        <button @click="show = false" wire:click="limpiarMensaje" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 {{ $tipoMensaje === 'success' ? 'bg-green-600 hover:bg-green-700' : ($tipoMensaje === 'info' ? 'bg-blue-600 hover:bg-blue-700' : 'bg-red-600 hover:bg-red-700') }} text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 {{ $tipoMensaje === 'success' ? 'focus:ring-green-500' : ($tipoMensaje === 'info' ? 'focus:ring-blue-500' : 'focus:ring-red-500') }} sm:text-sm">
                            @if($tipoMensaje === 'info')
                                Entendido
                            @else
                                Aceptar
                            @endif
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Formulario -->
    <div class="bg-white rounded-xl border border-secondary-200">
        <form wire:submit.prevent="guardar" class="space-y-6 p-6">
            @csrf

            <!-- Información Personal -->
            <div class="border-b border-secondary-200 pb-6">
                <h3 class="text-lg font-medium text-secondary-900 mb-4">Información Personal</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- DNI -->
                    <div class="space-y-1">
                        <label for="dni" class="block text-sm font-medium text-secondary-700">
                            DNI <span class="text-danger-500">*</span>
                        </label>
                        <input wire:model="dni" @blur="$wire.buscarEmpleadoPorDni()" type="text" id="dni" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}" placeholder="Ej: 12345678" {{ $modo == 'show' ? 'readonly' : '' }}>
                        @error('dni') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- CUIL -->
                    <div class="space-y-1">
                        <label for="cuil" class="block text-sm font-medium text-secondary-700">
                            CUIL <span class="text-danger-500">*</span>
                        </label>
                        <input wire:model="cuil" type="text" id="cuil" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}" placeholder="Ej: 20-12345678-9" {{ $modo == 'show' ? 'readonly' : '' }}>
                        @error('cuil') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Nombre -->
                    <div class="space-y-1">
                        <label for="nombre" class="block text-sm font-medium text-secondary-700">
                            Nombre <span class="text-danger-500">*</span>
                        </label>
                        <input wire:model="nombre" type="text" id="nombre" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}" placeholder="Ej: Juan" {{ $modo == 'show' ? 'readonly' : '' }}>
                        @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Apellido -->
                    <div class="space-y-1">
                        <label for="apellido" class="block text-sm font-medium text-secondary-700">
                            Apellido <span class="text-danger-500">*</span>
                        </label>
                        <input wire:model="apellido" type="text" id="apellido" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}" placeholder="Ej: Pérez" {{ $modo == 'show' ? 'readonly' : '' }}>
                        @error('apellido') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                     <!-- Teléfono -->
                    <div class="space-y-1">
                        <label for="telefono" class="block text-sm font-medium text-secondary-700">
                            Teléfono <span class="text-danger-500">*</span>
                        </label>
                        <input wire:model="telefono" type="tel" id="telefono" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}" placeholder="Ej: (351) 425-6789" {{ $modo == 'show' ? 'readonly' : '' }}>
                        @error('telefono') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Email -->
                    <div class="space-y-1">
                        <label for="email" class="block text-sm font-medium text-secondary-700">
                            Correo Electrónico <span class="text-danger-500">*</span>
                        </label>
                        <input wire:model="email" type="email" id="email" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}" placeholder="Ej: juan.perez@escuela.edu.ar" {{ $modo == 'show' ? 'readonly' : '' }}>
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Dirección -->
                    <div class="md:col-span-2 space-y-1">
                        <label for="direccion" class="block text-sm font-medium text-secondary-700">
                            Dirección <span class="text-danger-500">*</span>
                        </label>
                        <input wire:model="direccion" type="text" id="direccion" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}" placeholder="Ej: Calle Falsa 123, Córdoba" {{ $modo == 'show' ? 'readonly' : '' }}>
                        @error('direccion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Información Laboral -->
            <div class="border-b border-secondary-200 pb-6">
                <h3 class="text-lg font-medium text-secondary-900 mb-4">Información Laboral</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Escuela -->
                    <div class="space-y-1">
                        <label for="id_escuela" class="block text-sm font-medium text-secondary-700">
                            Escuela <span class="text-danger-500">*</span>
                        </label>
                        <select wire:model="id_escuela" id="id_escuela" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ ($modo == 'show' || auth()->user()->id_rol == 1) ? 'bg-secondary-50' : 'bg-white' }}" {{ ($modo == 'show' || auth()->user()->id_rol == 1) ? 'disabled' : '' }}>
                            <option value="">Seleccione una escuela</option>
                            @foreach($escuelas as $escuela)
                                <option value="{{ $escuela->id_escuela }}">{{ $escuela->nombre }}</option>
                            @endforeach
                        </select>
                        @error('id_escuela') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Cargo -->
                    <div class="space-y-1">
                        <label for="cargo" class="block text-sm font-medium text-secondary-700">
                            Cargo(s) <span class="text-danger-500">*</span>
                        </label>
                        <input wire:model="cargo" type="text" id="cargo" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}" placeholder="Ej: Docente de Matemáticas, Coordinador" {{ $modo == 'show' ? 'readonly' : '' }}>
                        @error('cargo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Fecha de Ingreso -->
                    <div class="space-y-1">
                        <label for="fecha_ingreso" class="block text-sm font-medium text-secondary-700">
                            Fecha de Ingreso <span class="text-danger-500">*</span>
                        </label>
                        <input wire:model="fecha_ingreso" type="date" id="fecha_ingreso" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}" {{ $modo == 'show' ? 'readonly' : '' }}>
                        @error('fecha_ingreso') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Fecha de Egreso -->
                    <div class="space-y-1">
                        <label for="fecha_egreso" class="block text-sm font-medium text-secondary-700">
                            Fecha de Egreso
                        </label>
                        <input wire:model="fecha_egreso" type="date" id="fecha_egreso" class="block w-full px-3 py-2 border border-secondary-300 rounded-lg text-sm {{ $modo == 'show' ? 'bg-secondary-50' : 'bg-white' }}" {{ $modo == 'show' ? 'readonly' : '' }}>
                         <p class="text-xs text-secondary-500">Dejar vacío si el empleado sigue activo</p>
                         @error('fecha_egreso') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Beneficiarios SVO -->
            <div class="border-b border-secondary-200 pb-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-4">
                        <h3 class="text-lg font-medium text-secondary-900">Beneficiarios SVO</h3>
                        @if(count($beneficiarios) > 0)
                        <div class="text-sm">
                            <span class="text-secondary-600">Total porcentajes: </span>
                            <span id="total-porcentajes" class="font-semibold text-orange-600">0.00%</span>
                            <span class="text-xs text-secondary-500">(debe ser 100%)</span>
                        </div>
                        @endif
                    </div>
                    @if($modo != 'show')
                    <button type="button" wire:click="agregarFilaBeneficiario" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Agregar Beneficiario
                    </button>
                    @endif
                </div>

                @if($errorBeneficiarios)
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex">
                        <svg class="w-5 h-5 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm text-red-700">{{ $errorBeneficiarios }}</p>
                    </div>
                </div>
                @endif

                @if(count($beneficiarios) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-secondary-200">
                        <thead class="bg-secondary-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Apellido</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">DNI</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Parentesco</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Porcentaje</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Estado</th>
                                @if($modo != 'show')
                                <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Acciones</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-secondary-200">
                            @foreach($beneficiarios as $index => $beneficiario)
                            <tr class="hover:bg-secondary-50 {{ (isset($beneficiario['marcado_para_eliminar']) && $beneficiario['marcado_para_eliminar']) ? 'opacity-50 bg-red-50' : '' }}">
                                <!-- Nombre -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($beneficiario['modo_edicion'] ?? false)
                                        <input wire:model="beneficiarios.{{ $index }}.nombre"
                                               type="text"
                                               class="block w-full px-2 py-1 border border-secondary-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                               placeholder="Nombre">
                                    @else
                                        <span class="text-sm font-medium text-secondary-900">{{ $beneficiario['nombre'] }}</span>
                                    @endif
                                </td>

                                <!-- Apellido -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($beneficiario['modo_edicion'] ?? false)
                                        <input wire:model="beneficiarios.{{ $index }}.apellido"
                                               type="text"
                                               class="block w-full px-2 py-1 border border-secondary-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                               placeholder="Apellido">
                                    @else
                                        <span class="text-sm text-secondary-500">{{ $beneficiario['apellido'] }}</span>
                                    @endif
                                </td>

                                <!-- DNI -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($beneficiario['modo_edicion'] ?? false)
                                        <input wire:model="beneficiarios.{{ $index }}.dni"
                                               type="text"
                                               class="block w-full px-2 py-1 border border-secondary-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                               placeholder="DNI">
                                    @else
                                        <span class="text-sm text-secondary-500">{{ $beneficiario['dni'] }}</span>
                                    @endif
                                </td>

                                <!-- Parentesco -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($beneficiario['modo_edicion'] ?? false)
                                        <select wire:model="beneficiarios.{{ $index }}.id_parentesco"
                                                class="block w-full px-2 py-1 border border-secondary-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                            <option value="">Seleccionar</option>
                                            @foreach($parentescos as $parentesco)
                                                <option value="{{ $parentesco->id_parentesco }}">{{ $parentesco->nombre_parentesco }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <span class="text-sm text-secondary-500">{{ $beneficiario['parentesco'] }}</span>
                                    @endif
                                </td>

                                <!-- Porcentaje -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($beneficiario['modo_edicion'] ?? false)
                                        <div class="flex items-center">
                                            <input wire:model="beneficiarios.{{ $index }}.porcentaje"
                                                   type="number"
                                                   step="1"
                                                   min="0"
                                                   max="100"
                                                   class="block w-full px-2 py-1 border border-secondary-300 rounded-l text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                                   placeholder="0"
                                                   oninput="validarPorcentajeIndividual(this)">
                                            <span class="inline-flex items-center px-2 py-1 border border-l-0 border-secondary-300 bg-secondary-50 rounded-r text-sm text-secondary-500">%</span>
                                        </div>
                                    @else
                                        <span class="text-sm text-secondary-500">{{ $beneficiario['porcentaje'] }}%</span>
                                    @endif
                                </td>

                                <!-- Estado -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if(isset($beneficiario['marcado_para_eliminar']) && $beneficiario['marcado_para_eliminar'])
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Pendiente eliminación
                                        </span>
                                    @elseif($beneficiario['activo'])
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Activo
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            Inactivo
                                        </span>
                                    @endif
                                </td>

                                @if($modo != 'show')
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        @if($beneficiario['modo_edicion'] ?? false)
                                            <button type="button" wire:click="guardarEdicionBeneficiario({{ $index }})"
                                                    class="text-green-600 hover:text-green-900"
                                                    title="Guardar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </button>
                                            <button type="button" wire:click="cancelarEdicionBeneficiario({{ $index }})"
                                                    class="text-gray-600 hover:text-gray-900"
                                                    title="Cancelar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        @else
                                            <button type="button" wire:click="editarBeneficiario({{ $index }})"
                                                    class="text-primary-600 hover:text-primary-900"
                                                    title="Editar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>
                                            <button type="button" wire:click="eliminarBeneficiario({{ $index }})"
                                                    class="text-red-600 hover:text-red-900"
                                                    title="Eliminar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-8 text-secondary-500">
                    <svg class="mx-auto h-12 w-12 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-secondary-900">No hay beneficiarios</h3>
                    <p class="mt-1 text-sm text-secondary-500">Comienza agregando un beneficiario para este empleado.</p>
                    @if($modo != 'show')
                    <div class="mt-6">
                        <button type="button" wire:click="agregarFilaBeneficiario" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Agregar primer beneficiario
                        </button>
                    </div>
                    @endif
                </div>
                @endif
            </div>

            <!-- Estado -->
            <div class="space-y-4">
                <h3 class="text-lg font-medium text-secondary-900">Estado</h3>
                <div class="flex items-center">
                    <div class="flex items-center h-5">
                        <input wire:model="activo" type="checkbox" id="activo" class="w-4 h-4 text-primary-600 bg-white border-secondary-300 rounded focus:ring-primary-500 focus:ring-2" {{ $modo == 'show' ? 'disabled' : '' }}>
                    </div>
                    <div class="ml-3">
                        <label for="activo" class="text-sm font-medium text-secondary-700">
                            Empleado Activo
                        </label>
                        <p class="text-xs text-secondary-500">Indica si el empleado se encuentra activo en la escuela</p>
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="flex items-center justify-between pt-6 border-t border-secondary-200">
                <a href="{{ route('empleados.index') }}" class="inline-flex items-center px-4 py-2 border border-secondary-300 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver al Listado
                </a>
                @if($modo != 'show')
                <button type="submit" class="inline-flex items-center px-6 py-2 bg-primary-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ $modo == 'create' ? 'Crear Empleado' : 'Actualizar Empleado' }}
                </button>
                @endif
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('mostrar-mensaje', () => {
            console.log('Mensaje mostrado - modo edición');
        });

        Livewire.on('mostrar-mensaje-y-redirigir', () => {
            console.log('Mensaje mostrado - modo creación');
            setTimeout(() => {
                @this.call('redirigirAlListado');
            }, 3000);
        });

        // Event listener para recalcular porcentajes cuando se actualiza un beneficiario
        Livewire.on('beneficiarioActualizado', () => {
            console.log('Beneficiario actualizado - recalculating percentages');
            setTimeout(validarPorcentajesTiempoReal, 200);
        });

        // Event listener para actualizar el total desde el backend
        Livewire.on('totalPorcentajesActualizado', (data) => {
            console.log('Total porcentajes actualizado desde backend:', data.total);
            const indicadorTotal = document.getElementById('total-porcentajes');
            if (indicadorTotal) {
                indicadorTotal.textContent = data.total + '%';

                // Actualizar color según el total
                if (data.total > 100) {
                    indicadorTotal.className = 'text-red-600 font-semibold';
                } else if (data.total === 100) {
                    indicadorTotal.className = 'text-green-600 font-semibold';
                } else {
                    indicadorTotal.className = 'text-orange-600 font-semibold';
                }
            }
        });
    });

    // Función para calcular el total de porcentajes en tiempo real
    function calcularTotalPorcentajes() {
        let total = 0;

        // Buscar todas las filas de beneficiarios
        const filasBeneficiarios = document.querySelectorAll('tbody tr');

        filasBeneficiarios.forEach(row => {
            // Solo procesar filas que no estén marcadas para eliminar
            if (!row.classList.contains('opacity-50')) {
                let porcentaje = 0;

                // Buscar si hay un input de porcentaje (modo edición)
                const inputPorcentaje = row.querySelector('input[name*="porcentaje"]');
                if (inputPorcentaje) {
                    porcentaje = parseInt(inputPorcentaje.value) || 0;
                } else {
                    // Buscar el span que contiene el porcentaje (modo visualización)
                    const spanPorcentaje = row.querySelector('td:nth-child(5) span');
                    if (spanPorcentaje) {
                        const texto = spanPorcentaje.textContent.trim();
                        porcentaje = parseInt(texto.replace('%', '')) || 0;
                    }
                }

                total += porcentaje;
            }
        });

        console.log('Total calculado:', total);
        return total;
    }

    // Función para validar porcentaje individual
    function validarPorcentajeIndividual(input) {
        const valor = parseInt(input.value) || 0;
        if (valor > 100) {
            input.value = 100;
        } else if (valor < 0) {
            input.value = 0;
        }
        // Forzar recálculo después de la validación
        setTimeout(validarPorcentajesTiempoReal, 10);
    }

    // Función para validar porcentajes en tiempo real
    function validarPorcentajesTiempoReal() {
        const total = calcularTotalPorcentajes();
        const indicadorTotal = document.getElementById('total-porcentajes');

        if (indicadorTotal) {
            indicadorTotal.textContent = total + '%';

            if (total > 100) {
                indicadorTotal.className = 'text-red-600 font-semibold';
            } else if (total === 100) {
                indicadorTotal.className = 'text-green-600 font-semibold';
            } else {
                indicadorTotal.className = 'text-orange-600 font-semibold';
            }
        }
    }

    // Agregar event listeners para validación en tiempo real
    document.addEventListener('input', function(e) {
        if (e.target.type === 'number' && e.target.name && e.target.name.includes('porcentaje')) {
            validarPorcentajesTiempoReal();
        }
    });

    // También actualizar cuando cambian los valores de Livewire
    document.addEventListener('livewire:updated', function() {
        console.log('Livewire updated - recalculating percentages');
        setTimeout(validarPorcentajesTiempoReal, 100);
    });

    // Escuchar cambios en los inputs de porcentaje específicamente
    document.addEventListener('input', function(e) {
        if (e.target.name && e.target.name.includes('porcentaje')) {
            console.log('Input changed:', e.target.name, e.target.value);
            setTimeout(validarPorcentajesTiempoReal, 50);
        }
    });

    // Ejecutar cálculo inicial después de que el DOM esté completamente cargado
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(validarPorcentajesTiempoReal, 100);
    });

    // También ejecutar cuando Livewire termine de renderizar
    document.addEventListener('livewire:loaded', function() {
        setTimeout(validarPorcentajesTiempoReal, 200);
    });

    // Ejecutar cuando se complete cualquier acción de Livewire
    Livewire.on('actionCompleted', () => {
        console.log('Livewire action completed - recalculating');
        setTimeout(validarPorcentajesTiempoReal, 150);
    });

    // Event listener específico para botones de editar
    document.addEventListener('click', function(e) {
        if (e.target.closest('button') && e.target.closest('button').getAttribute('wire:click') &&
            e.target.closest('button').getAttribute('wire:click').includes('editarBeneficiario')) {
            console.log('Edit button clicked - will recalculate after DOM update');
            setTimeout(validarPorcentajesTiempoReal, 200);
        }
    });

    // Event listener específico para botones de guardar
    document.addEventListener('click', function(e) {
        if (e.target.closest('button') && e.target.closest('button').getAttribute('wire:click') &&
            e.target.closest('button').getAttribute('wire:click').includes('guardarEdicionBeneficiario')) {
            console.log('Save button clicked - will recalculate after DOM update');
            setTimeout(validarPorcentajesTiempoReal, 200);
        }
    });
</script>
@endpush
