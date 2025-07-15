<div class="relative" x-data="{ open: false }" @click.away="open = false">
    <button @click="open = !open; if(open) { $wire.loadNotifications(); $wire.markAsRead(); }" class="relative p-2 text-gray-500 rounded-full hover:bg-gray-100 hover:text-gray-600 focus:bg-gray-100 focus:text-gray-600">
        <i class="fas fa-bell"></i>
        @if($unreadNotificationsCount > 0)
            <span class="absolute top-0 right-0 flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full">
                {{ $unreadNotificationsCount }}
            </span>
        @endif
    </button>

    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute right-0 w-80 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
         style="display: none;">
        <div class="py-1">
            <div class="px-4 py-2 text-sm text-gray-700 font-semibold border-b">Notificaciones</div>
            <div class="divide-y divide-gray-100">
                @forelse($notifications as $notification)
                    <a href="#" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                        <p class="font-bold">{{ $notification->titulo }}</p>
                        <p class="text-xs text-gray-500">{{ $notification->mensaje }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ $notification->fecha_creacion->diffForHumans() }}</p>
                    </a>
                @empty
                    <div class="px-4 py-3 text-sm text-gray-500 text-center">No hay notificaciones nuevas.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>