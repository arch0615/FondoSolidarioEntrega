<div>
    <div class="mx-auto px-4">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 mb-8">
            <div>
                <h1 class="text-2xl font-semibold text-secondary-900">Correos de Aseguradora</h1>
                <p class="mt-1 text-sm text-secondary-600">Administra las direcciones de correo a las que se enviarán los reintegros.</p>
            </div>
        </div>

        @if (session()->has('message'))
            <div class="bg-success-100 border-l-4 border-success-500 text-success-700 p-4 mb-6 rounded" role="alert">
                <p>{{ session('message') }}</p>
            </div>
        @endif

        <!-- Formulario para agregar -->
        <div class="bg-white rounded-xl border border-secondary-200 p-6 mb-8">
            <h2 class="text-lg font-semibold text-secondary-800 mb-4">
                <i class="fas fa-plus-circle text-primary-600 mr-2"></i>
                Agregar Correo
            </h2>
            <form wire:submit.prevent="agregar">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                    <div>
                        <label for="email" class="block text-sm font-medium text-secondary-700">Correo Electrónico *</label>
                        <input type="email" wire:model="email" id="email" placeholder="correo@aseguradora.com" class="mt-1 block w-full rounded-md border-secondary-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                        @error('email') <span class="text-danger-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="descripcion" class="block text-sm font-medium text-secondary-700">Descripción (opcional)</label>
                        <input type="text" wire:model="descripcion" id="descripcion" placeholder="Ej: Contacto principal, Siniestros, etc." class="mt-1 block w-full rounded-md border-secondary-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                        @error('descripcion') <span class="text-danger-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                            <i class="fas fa-plus mr-2"></i>
                            Agregar
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Lista de correos -->
        <div class="bg-white rounded-xl border border-secondary-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-secondary-200">
                    <thead class="bg-secondary-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Correo Electrónico</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Descripción</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-secondary-500 uppercase tracking-wider">Estado</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-secondary-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-secondary-200">
                        @forelse ($emails as $emailItem)
                        <tr class="hover:bg-secondary-50 transition-colors duration-150 {{ !$emailItem->activo ? 'opacity-50' : '' }}">
                            @if($editingId === $emailItem->id_email_aseguradora)
                                <!-- Modo edición -->
                                <td class="px-6 py-4">
                                    <input type="email" wire:model="editEmail" class="block w-full rounded-md border-secondary-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                    @error('editEmail') <span class="text-danger-500 text-xs">{{ $message }}</span> @enderror
                                </td>
                                <td class="px-6 py-4">
                                    <input type="text" wire:model="editDescripcion" class="block w-full rounded-md border-secondary-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $emailItem->activo ? 'bg-success-100 text-success-800' : 'bg-secondary-100 text-secondary-800' }}">
                                        {{ $emailItem->activo ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button wire:click="actualizar" class="inline-flex items-center px-3 py-1.5 bg-success-600 text-white text-xs font-medium rounded-lg hover:bg-success-700 transition-colors">
                                            <i class="fas fa-check mr-1"></i> Guardar
                                        </button>
                                        <button wire:click="cancelarEdicion" class="inline-flex items-center px-3 py-1.5 bg-secondary-400 text-white text-xs font-medium rounded-lg hover:bg-secondary-500 transition-colors">
                                            <i class="fas fa-times mr-1"></i> Cancelar
                                        </button>
                                    </div>
                                </td>
                            @else
                                <!-- Modo vista -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <i class="fas fa-envelope text-secondary-400 mr-2"></i>
                                        <span class="text-sm font-medium text-secondary-900">{{ $emailItem->email }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-secondary-600">{{ $emailItem->descripcion ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <button wire:click="toggleActivo({{ $emailItem->id_email_aseguradora }})" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium cursor-pointer transition-colors {{ $emailItem->activo ? 'bg-success-100 text-success-800 hover:bg-success-200' : 'bg-secondary-100 text-secondary-800 hover:bg-secondary-200' }}">
                                        {{ $emailItem->activo ? 'Activo' : 'Inactivo' }}
                                    </button>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button wire:click="editar({{ $emailItem->id_email_aseguradora }})" class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-full transition-colors" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button wire:click="confirmarEliminar({{ $emailItem->id_email_aseguradora }})" class="p-2 text-danger-600 hover:text-danger-800 hover:bg-danger-50 rounded-full transition-colors" title="Eliminar">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="text-center">
                                    <i class="fas fa-inbox text-4xl text-secondary-300 mb-3"></i>
                                    <h3 class="text-sm font-medium text-secondary-900">No hay correos configurados</h3>
                                    <p class="mt-1 text-sm text-secondary-500">Agregue al menos un correo de aseguradora para poder enviar reintegros.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación de eliminación -->
    @if($showDeleteModal)
    <div class="fixed inset-0 bg-secondary-900 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-sm shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-danger-100">
                    <i class="fas fa-exclamation-triangle text-danger-600 text-xl"></i>
                </div>
                <h3 class="text-lg leading-6 font-medium text-secondary-900 mt-4">Eliminar Correo</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-secondary-500">¿Está seguro de que desea eliminar este correo de aseguradora? Esta acción no se puede deshacer.</p>
                </div>
            </div>
            <div class="flex justify-end gap-3 px-4 py-3">
                <button wire:click="$set('showDeleteModal', false)" class="px-4 py-2 bg-white text-secondary-700 border border-secondary-300 rounded-md shadow-sm hover:bg-secondary-50">
                    Cancelar
                </button>
                <button wire:click="eliminar" class="px-4 py-2 bg-danger-600 text-white rounded-md hover:bg-danger-700">
                    Eliminar
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
